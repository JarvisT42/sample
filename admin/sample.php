<?php
session_start();
include '../connection.php'; // Ensure you have your database connection

// Check if student_id is set in the query parameters
if (isset($_GET['student_id'])) {
    $student_id = htmlspecialchars($_GET['student_id']);

    // Fetch the category based on the student_id
    $categoryQuery = "SELECT Category FROM GFI_Library_Database.borrow WHERE student_id = ?";
    $stmt = $conn->prepare($categoryQuery);
    $stmt->bind_param('i', $student_id); // Assuming student_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the category
    if ($row = $result->fetch_assoc()) {
        $category = $row['Category']; // Get the category for the student
    } else {
        echo "No category found for this student.";
        exit;
    }

    $stmt->close(); // Close the category statement

    // Prepare the SQL statement safely using placeholders
    $query = "
    SELECT a.student_id, a.book_id, a.Category,   b.First_Name, b.Middle_Initial, b.Last_Name, a.Issued_Date, c.Title, c.Author, c.record_cover, c.status  
    FROM GFI_Library_Database.borrow AS a 
    JOIN GFI_Library_Database.students AS b ON a.student_id = b.id
    JOIN gfi_library_database_books_records.$category AS c ON a.book_id = c.id
    WHERE a.student_id = ? AND a.status = 'borrowed'";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    // Bind parameters (integer type for student_id)
    $stmt->bind_param('i', $student_id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all data into an array
    $books = $result->fetch_all(MYSQLI_ASSOC) ?: []; // Use short-circuit evaluation for empty check

    $stmt->close(); // Close statement


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
    <title>Borrowed Books</title>
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

        li {
            list-style-type: none;
            /* Remove bullets from list items */
        }

        .drop_active {
            display: block;
            /* or inline, inline-block, etc., depending on your layout needs */

        }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>
    <main id="content">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="bg-gray-100 p-6 w-full mx-auto">
                    <div class="bg-white p-4 shadow-sm rounded-lg mb-2">
                        <div class="bg-gray-100 p-2 flex justify-between items-center">
                            <h1 class="m-0">Student Name: <?php
                                                            // Display Student Name if available
                                                            if (!empty($books)) {
                                                                // Access the student's data correctly
                                                                $firstName = htmlspecialchars($books[0]['First_Name']);
                                                                $middleInitial = htmlspecialchars($books[0]['Middle_Initial']);
                                                                $lastName = htmlspecialchars($books[0]['Last_Name']);

                                                                // Concatenate names
                                                                $fullName = trim("$firstName $middleInitial $lastName"); // Trim to remove any extra spaces

                                                                echo $fullName; // Display the full name
                                                            }

                                                            ?></h1>
                            <input type="checkbox" id="book-checkbox" value="" class="ml-2">
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


                        <form id="book-request-form" class="space-y-6">
                            <?php foreach ($grouped_books as $date => $books_group): ?>
                                <div class="bg-blue-200 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-white">Date to Claim: <?php echo $date; ?></h3>
                                    <ul class="space-y-4">
                                        <?php foreach ($books_group as $index => $book): ?>
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

                                            // Calculate the due date (3 days after the issued date)
                                            $due_date = date('Y-m-d', strtotime($issued_date . ' + 3 days'));

                                            // Calculate the fines based on the due date
                                            $current_date = date('Y-m-d');
                                            $fine_amount = 0;

                                            if ($current_date > $due_date) {
                                                // Calculate overdue days
                                                $overdue_days = (strtotime($current_date) - strtotime($due_date)) / (60 * 60 * 24);
                                                $fine_amount = $overdue_days * $fines_value;
                                            }
                                            ?>

                                            <li class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mb-2 flex flex-col">
                                                <div class="flex-1">
                                                    <div class="flex flex-col md:flex-row justify-between mb-6">
                                                        <div class="flex-1 mb-4 md:mb-0">
                                                            <h1 class="text-2xl font-bold mb-1">Title:</h1>
                                                            <p class="text-xl mb-4"><?php echo htmlspecialchars($book['Title']); ?></p>
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
                                                                <p class="text-sm"><?php echo htmlspecialchars($due_date); ?></p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold">Fines: ₱ <span id="fine-amount-<?php echo $index; ?>"><?php echo $fine_amount; ?></span>.00</p>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <p class="text-sm font-semibold">Renew</p>
                                                                <select class="border border-gray-300 rounded p-1 mr-16 renew-dropdown" onchange="updateDueDate(<?php echo $index; ?>)">
                                                                    <option value="0">0 Days</option>
                                                                    <option value="3">3 Days</option>
                                                                    <option value="6">6 Days</option>
                                                                    <option value="9">9 Days</option>
                                                                    <option value="12">12 Days</option>
                                                                    <option value="15">15 Days</option>
                                                                    <!-- Add more options as needed -->
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold">Book Status: <?php echo htmlspecialchars($book['status']); ?></p>
                                                                <select class="border border-gray-300 rounded p-1 mr-16">
                                                                    <option><?php echo htmlspecialchars($book['status']); ?></option>
                                                                    <option>Old</option>
                                                                    <option>Damage</option>
                                                                    <option>Lost</option>
                                                                    <!-- Add more options as needed -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end space-x-2 mt-4">
                                                    <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Renew</button>
                                                    <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Return</button>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        </form>






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
</body>

</html>