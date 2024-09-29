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
    SELECT a.student_id, a.book_id, a.Category,  a.No_Of_Copies, b.First_Name, b.Middle_Initial, b.Last_Name, a.Date_To_Claim, c.Title, c.Author, c.record_cover    
    FROM GFI_Library_Database.borrow AS a 
    JOIN GFI_Library_Database.students AS b ON a.student_id = b.id
    JOIN gfi_library_database_books_records.$category AS c ON a.book_id = c.id
    WHERE a.student_id = ? AND a.status = 'pending'";

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
                            $date_to_claim = htmlspecialchars($book['Date_To_Claim']);
                            $grouped_books[$date_to_claim][] = $book;
                        }
                        ?>
                        <form id="book-request-form" class="space-y-6" method="POST" action="book_request_2_save.php">
                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                            <?php foreach ($grouped_books as $date => $books_group): ?>
                                <div class="bg-blue-200 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-white">Date to Claim: <?php echo $date; ?></h3>
                                    <?php foreach ($books_group as $index => $book): ?>
                                        <li class="p-4 bg-white flex flex-col md:flex-row items-start border-b-2 border-black">
                                            <div class="flex flex-col md:flex-row items-start w-full space-y-4 md:space-y-0 md:space-x-6">
                                                <div class="flex-1 w-full md:w-auto">
                                                    <h2 class="text-lg font-semibold mb-2">
                                                        <a href="#" class="text-blue-600 hover:underline max-w-xs break-words">
                                                            <?php echo htmlspecialchars($book['Title']); ?>
                                                        </a>
                                                    </h2>
                                                    <div class="mt-4">
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 text-sm text-gray-600">
                                                            <div class="font-medium bg-gray-200 p-2">Main Author:</div>
                                                            <div class="bg-gray-100 p-2"><?php echo htmlspecialchars($book['Author']); ?></div>
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
                                                    if (!empty($book['record_cover'])) {
                                                        $imageData = base64_encode($book['record_cover']);
                                                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                                    } else {
                                                        $imageSrc = 'path/to/default/image.jpg'; // Provide a default image source
                                                    }
                                                    ?>
                                                    <img src="<?php echo $imageSrc; ?>" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                                </div>

                                                <div class="flex-shrink-0 ml-2">
                                                    <input type="checkbox" id="book-checkbox-<?php echo $date . '-' . $index; ?>" name="selected_books[]" value="<?php echo $book['book_id']; ?>" class="mr-1">
                                                    <label for="book-checkbox-<?php echo $date . '-' . $index; ?>" class="text-sm text-gray-600">Select</label>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Submit Selected Books</button>
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