<?php
session_start();
include '../connection.php'; // Ensure you have your database connection
include '../connection2.php'; // Ensure you have your database connection

if (isset($_GET['student_id'])) {
    $student_id = htmlspecialchars($_GET['student_id']);

    // Check if student_id is set in the query parameters




    // Fetch the category, book_id, and student details based on the student_id
    $categoryQuery = "
    SELECT a.Category, a.book_id, a.Date_To_Claim
    FROM GFI_Library_Database.borrow AS a
    WHERE a.student_id = ? and status ='pending'";

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
        .active-book-request {
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
                            $date_to_claim = htmlspecialchars($book['Date_To_Claim']);
                            $grouped_books[$date_to_claim][] = $book;
                        }
                        ?>

                        <form id="book-request-form" class="space-y-6" method="POST" action="book_request_2_save.php">
                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

                            <?php foreach ($grouped_books as $date => $books_group): ?>




                                <div class="bg-blue-200 p-4 rounded-lg">





                                    <div class="bg-blue-200 rounded-lg flex items-center justify-between ">
                                        <!-- Left side: Date to Claim -->
                                        <h3 class="text-lg font-semibold text-white">Date to Claim: <?php echo $date; ?></h3>

                                        <!-- Right side: Checkbox -->
                                        <div class="flex items-center">
                                            
                                            <input type="checkbox" id="select-all-<?php echo $date; ?>" class="select-all-checkbox ml-2" onclick="toggleSelectAll('<?php echo $date; ?>')">
                                            <label for="select-all-<?php echo $date; ?>" class="ml-1 text-sm">Select All</label>
                                        </div>
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
                                        $record_cover = null; // Initialize with null

                                        if ($row = $result->fetch_assoc()) {
                                            $title = $row['Title']; // Get the title
                                            $author = $row['Author']; // Get the author
                                            $record_cover = $row['record_cover']; // Get the record cover
                                        }

                                        $stmt2->close();
                                        ?>

                                        <li class="p-4 bg-white flex flex-col md:flex-row items-start border-b-2 border-black">
                                            <div class="flex flex-col md:flex-row items-start w-full space-y-4 md:space-y-0 md:space-x-6">
                                                <div class="flex-1 w-full md:w-auto">
                                                    <h2 class="text-lg font-semibold mb-2">
                                                        <a href="#" class="text-blue-600 hover:underline max-w-xs break-words">
                                                            <?php echo $title; ?>
                                                        </a>
                                                    </h2>
                                                    <div class="mt-4">
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 text-sm text-gray-600">
                                                            <div class="font-medium bg-gray-200 p-2">Main Author:</div>
                                                            <div class="bg-gray-100 p-2"><?php echo $author; ?></div>
                                                            <div class="font-medium bg-gray-100 p-2">Published:</div>
                                                            <div class="bg-gray-200 p-2"><?php echo htmlspecialchars($book['publication_date']); ?></div>
                                                            <div class="font-medium bg-gray-200 p-2">Table:</div>
                                                            <div class="bg-gray-100 p-2"><?php echo htmlspecialchars($book['Category']); ?></div>
                                                            <div class="font-medium bg-gray-100 p-2">Copies:</div>
                                                            <div class="bg-gray-100 p-2"><?php echo htmlspecialchars($book['book_id']); ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex-shrink-0">
                                                    <?php
                                                    // Handle the image display
                                                    if (!empty($record_cover)) { // Use the fetched record_cover
                                                        $imageData = base64_encode($record_cover);
                                                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                                    } else {
                                                        $imageSrc = 'path/to/default/image.jpg'; // Provide a default image source
                                                    }
                                                    ?>
                                                    <img src="<?php echo $imageSrc; ?>" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                                </div>

                                                <div class="flex-shrink-0 ml-2">
    <input type="checkbox" 
           id="book-checkbox-<?php echo $date . '-' . $index; ?>" 
           name="selected_books[]" 
           value="<?php echo $book['book_id'] . '|' . htmlspecialchars($book['Category']); ?>" 
           class="book-checkbox-<?php echo $date; ?> mr-1">
    <label for="book-checkbox-<?php echo $date . '-' . $index; ?>" class="text-sm text-gray-600">Select</label>
</div>

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