<?php
session_start();
include '../connection.php'; // Ensure you have your database connection
include '../connection2.php'; // Ensure you have your database connection

if (isset($_GET['student_id'])) {
    $student_id = htmlspecialchars($_GET['student_id']);

    // Check if student_id is set in the query parameters




    // Fetch the category, book_id, and student details based on the student_id
    $categoryQuery = "
    SELECT a.Category, a.book_id, a.Issued_Date
    FROM GFI_Library_Database.borrow AS a
    WHERE a.student_id = ? and status ='borrowed'";

    $stmt = $conn->prepare($categoryQuery);
    $stmt->bind_param('i', $student_id); // Assuming student_id is an integer
    $stmt->execute();

    $result = $stmt->get_result();

    // Fetch all data into an array
    $books = $result->fetch_all(MYSQLI_ASSOC) ?: []; // Use short-circuit evaluation for empty check
    // Fetch student details for full name
    $studentQuery = "
    SELECT First_Name, Middle_Initial, Last_Name 
    FROM GFI_Library_Database.students 
    WHERE id = ?";
    $stmtStudent = $conn->prepare($studentQuery);
    $stmtStudent->bind_param('i', $student_id);
    $stmtStudent->execute();
    $studentResult = $stmtStudent->get_result();

    if ($studentResult->num_rows > 0) {
        $studentRow = $studentResult->fetch_assoc();
        $fullName = $studentRow['First_Name'] . ' ' . $studentRow['Middle_Initial'] . ' ' . $studentRow['Last_Name'];
    } else {
        $fullName = 'Unknown Student'; // Fallback if no student found
    }
    $stmtStudent->close();

    // Group books by Date_To_Claim


    $stmt->close(); // Close the first statement


} elseif (isset($_GET['walk_in_id'])) {
    $walk_in_id = htmlspecialchars($_GET['walk_in_id']);
    // Proceed with your logic for online borrowing

    // Check if student_id is set in the query parameters

    // Fetch the student ID and full name based on walk_in_id
    $studentQuery = "
  SELECT student_id, walk_in_id, Full_Name
  FROM GFI_Library_Database.borrow 
  WHERE walk_in_id = ? AND status = 'borrowed'";

    $stmtStudent = $conn->prepare($studentQuery);
    $stmtStudent->bind_param('s', $walk_in_id); // Assuming walk_in_id is a string
    $stmtStudent->execute();
    $studentResult = $stmtStudent->get_result();

    if ($studentResult->num_rows > 0) {
        $studentData = $studentResult->fetch_assoc();

        $student_id = $studentData['student_id']; // Get the student ID for future queries
        $fullName = $studentData['Full_Name'];

        // Fetch the category, book_id, and issued date based on the student_id
        $categoryQuery = "
      SELECT a.Category, a.book_id, a.Issued_Date 
      FROM GFI_Library_Database.borrow AS a
      WHERE a.walk_in_id = ? AND a.status = 'borrowed'";

        $stmt = $conn->prepare($categoryQuery);
        $stmt->bind_param('i', $walk_in_id); // Assuming student_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all data into an array
        $books = $result->fetch_all(MYSQLI_ASSOC) ?: []; // Use short-circuit evaluation for empty check

        $stmt->close(); // Close the book query statement
    } else {
        $fullName = 'Unknown Student'; // Fallback if no student found
    }
    $stmtStudent->close(); // Close the student statement

} else {
    // Handle the case where student_id is not provided
    echo "No student ID provided.";
    exit; // Stop execution if no student_id
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>

    <style>
        .active-borrowed-books {
            background-color: #f0f0f0;
            color: #000;
        }

        .active-request {
            background-color: #f0f0f0;
            color: #000;
        }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>
    <main id="content" class="">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="bg-gray-100 p-6 w-full mx-auto">
                    <div class="bg-white p-4 shadow-sm rounded-lg mb-2">
                        <div class="bg-gray-100 p-2 flex justify-between items-center">
                            <h1 class="m-0">Student Name: <?php echo $fullName; ?></h1>

                        </div>
                    </div>

                    <?php if (!empty($books)): ?>
                        <?php
                        // Group books by Date_To_Claim
                        $grouped_books = [];
                        foreach ($books as $book) {
                            $date_to_claim = htmlspecialchars($book['Issued_Date']);
                            $grouped_books[$date_to_claim][] = $book;
                        }
                        ?>

                        <form id="book-request-form" class="space-y-6" method="POST" action="book_request_2_save.php">
                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

                            <?php foreach ($grouped_books as $date => $books_group): ?>




                                <div class="bg-blue-200 p-4 rounded-lg">





                                    <div class="bg-blue-200 rounded-lg flex items-center justify-between ">
                                        <!-- Left side: Date to Claim -->
                                        <h3 class="text-lg font-semibold text-white">Issued Date: <?php echo $date; ?></h3>

                                        <!-- Right side: Checkbox -->

                                    </div>


                                    <?php foreach ($books_group as $index => $book): ?>
                                        <?php
                                        $category = $book['Category'];
                                        $book_id = $book['book_id'];

                                        // Fetch the Title, Author, and record_cover from conn2 based on book_id
                                        $titleQuery = "SELECT * FROM `$category` WHERE id = ?";
                                        $stmt2 = $conn2->prepare($titleQuery);
                                        $stmt2->bind_param('i', $book_id);
                                        $stmt2->execute();
                                        $result = $stmt2->get_result();

                                        // Initialize variables
                                        $title = 'Unknown Title';
                                        $author = 'Unknown Author';
                                        $status = 'Unknown Status';

                                        $record_cover = null; // Initialize with null

                                        if ($row = $result->fetch_assoc()) {
                                            $title = $row['Title']; // Get the title
                                            $author = $row['Author']; // Get the author
                                            $status = $row['Status']; // Get the author
                                            $record_cover = $row['record_cover']; // Get the record cover
                                        }

                                        $stmt2->close();
                                        ?>
                                        <?php
                                        include '../connection.php';

                                        // Get the fines value from the database
                                        $fines_value = 0;
                                        $sql = "SELECT fines FROM library_fines LIMIT 1";
                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $fines_value = (int)$row['fines'];
                                        }

                                        // Get the issued date from the book array
                                        $issued_date = $book['Issued_Date'];

                                        // Get the issued date from the book array

                                        // Calculate the due date (3 days after the issued date)
                                        $due_date = date('Y-m-d', strtotime($issued_date . ' + 3 days'));

                                        // Calculate the fines based on the due date
                                        $current_date = date('Y-m-d');
                                        $fine_amount = 0;
                                        $daily_fine_rate = 5; // Define the daily fine rate

                                        if ($current_date > $due_date) {
                                            // Calculate overdue days
                                            $overdue_days = (strtotime($current_date) - strtotime($due_date)) / (60 * 60 * 24);
                                            $fine_amount = $overdue_days * $fines_value; // Multiply overdue days by the fine rate (₱5 per day)
                                        }
                                        ?>

                                        <li class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mb-2 flex flex-col">
                                            <div class="flex-1">
                                                <div class="flex flex-col md:flex-row justify-between mb-6">
                                                    <div class="flex-1 mb-4 md:mb-0">
                                                        <h1 class="text-2xl font-bold mb-1">Title:</h1>
                                                        <p class="text-xl mb-4"> <?php echo $title; ?>
                                                        </p>
                                                        <div class="mb-4">
                                                            <h2 class="text-lg font-semibold text-gray-600 mb-1">Borrow Category:</h2>
                                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($book['Category']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="w-full md:w-32 h-40 bg-gray-200 border border-gray-300 flex items-center justify-center mb-4 md:mb-0">
                                                        <?php
                                                        if (!empty($book['record_cover'])) {
                                                            $imageData = base64_encode($book['record_cover']);
                                                            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                                        } else {
                                                            $imageSrc = 'path/to/default/image.jpg'; // Provide a default image source
                                                        }
                                                        ?>
                                                        <img src="<?php echo $imageSrc; ?>" alt="Book Cover" class="w-full h-full border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                                    </div>
                                                </div>
                                                <div class="bg-blue-100 p-4 rounded-lg">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                                        <div>
                                                            <p class="text-sm font-semibold">Issued Date:</p>
                                                            <p class="text-sm"><?php echo htmlspecialchars($book['Issued_Date']); ?></p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold">Due Date:</p>
                                                            <p class="due-date" data-index="<?php echo $index; ?>"><?php echo htmlspecialchars($due_date); ?></p>

                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold">Fines: ₱ <span id="fine-amount-<?php echo $index; ?>"><?php echo $fine_amount; ?></span>.00</p>
                                                        </div>
                                                    </div>


                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                                        <!-- Row 1 -->
                                                        <div>
                                                            <p class="text-sm font-semibold">Renew</p>
                                                            <select class="renew-dropdown" data-index="<?php echo $index; ?>" data-due-date="<?php echo htmlspecialchars($due_date); ?>">
                                                                <option value="0">0 Days</option>
                                                                <option value="3">3 Days</option>
                                                                <option value="6">6 Days</option>
                                                                <option value="9">9 Days</option>
                                                                <option value="12">12 Days</option>
                                                                <option value="15">15 Days</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold">Book Status:</p>
                                                            <select id="statusSelect-<?php echo $index; ?>" class="border border-gray-300 rounded p-1 mr-16">
                                                                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                                <option value="Damage">Damage</option>
                                                                <option value="Lost">Lost</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold">Fines:</p>
                                                            <div class="flex items-center">
                                                                P:<input id="finesInput-<?php echo $index; ?>" class="border border-gray-300 rounded p-1 w-32" type="number" disabled placeholder="Disabled">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Duplicate the above div block for additional rows, updating the $index variable accordingly -->

                                                  <!-- Inside your form, just before the closing </form> tag -->
                                                   

                                                  








                                                </div>
                                            </div>
                                            <div class="flex justify-end space-x-2 mt-4">
                                                <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Renew</button>
                                                <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Return</button>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </div>

                            <?php endforeach; ?>

                            <div class="flex items-center justify-end">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Done</button>
                            </div>
                        </form>

                        <script>
                            function toggleSelectAll(date) {
                                // Get the "Select All" checkbox
                                const selectAllCheckbox = document.getElementById('select-all-' + date);

                                // Get all individual book checkboxes for this date group
                                const bookCheckboxes = document.querySelectorAll('.book-checkbox-' + date);

                                // Toggle the checked state of each individual checkbox
                                bookCheckboxes.forEach(function(checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });
                            }
                        </script>



                    <?php else: ?>
                        <div class="p-4 bg-white flex items-center border-b-2 border-black">
                            <div class="text-gray-600">No books found for this student.</div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <script src="./src/components/header.js"></script>
    <script>
        // Function to automatically show the dropdown if on book_request.php
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownRequest = document.getElementById('dropdown-request');

            // Open the dropdown menu for 'Request'
            dropdownRequest.classList.remove('hidden');
            dropdownRequest.classList.add('block'); // Make the dropdown visible

        });
    </script>
</body>

</html>
<!-- 
                                                                                                                                            <script>
                                                                                                                                            
                                                                                                                                            
                                                                                                                                            
                                                                                                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                                        const form = document.getElementById('book-request-form');

                                                                                        form.addEventListener('change', function(event) {
                                                                                            // Handle renewal dropdown changes
                                                                                            if (event.target.classList.contains('renew-dropdown')) {
                                                                                                const renewalDropdown = event.target;
                                                                                                const renewalDays = parseInt(renewalDropdown.value);
                                                                                                const dueDateStr = renewalDropdown.getAttribute('data-due-date');
                                                                                                const currentDueDate = new Date(dueDateStr + 'T00:00:00');

                                                                                                // Calculate the new due date
                                                                                                const newDueDate = new Date(currentDueDate);
                                                                                                newDueDate.setDate(currentDueDate.getDate() + renewalDays);

                                                                                                const options = {
                                                                                                    year: 'numeric',
                                                                                                    month: '2-digit',
                                                                                                    day: '2-digit'
                                                                                                };
                                                                                                const formattedDueDate = newDueDate.toLocaleDateString('en-CA', options);

                                                                                                const index = renewalDropdown.getAttribute('data-index');
                                                                                                const dueDateElement = form.querySelector(`.due-date[data-index="${index}"]`);

                                                                                                if (dueDateElement) {
                                                                                                    dueDateElement.innerText = formattedDueDate;
                                                                                                }
                                                                                            }

                                                                                            // Handle status select changes
                                                                                            if (event.target.matches('[id^="statusSelect-"]')) {
                                                                                                const index = event.target.id.split('-')[1]; // Get the index from the element ID
                                                                                                const finesInput = document.getElementById(`finesInput-${index}`);

                                                                                                // Enable or disable the fines input based on the selected status
                                                                                                if (event.target.value === 'Damage' || event.target.value === 'Lost') {
                                                                                                    finesInput.disabled = false; // Enable the fines input
                                                                                                    finesInput.placeholder = ''; // Clear the placeholder when enabled
                                                                                                } else {
                                                                                                    finesInput.disabled = true; // Disable the fines input
                                                                                                    finesInput.value = ''; // Clear the input value when disabled
                                                                                                    finesInput.placeholder = 'Disabled'; // Set placeholder to 'Disabled'
                                                                                                }
                                                                                            }
                                                                                        });
                                                                                    });


                                                                                    </script> -->