<?php
session_start();
include '../connection.php'; // Ensure you have your database connection

// Check if student_id is set in the query parameters
if (isset($_GET['student_id'])) {
    $student_id = htmlspecialchars($_GET['student_id']);

    // Fetch data from the database based on student_id
    $query = "SELECT * FROM borrow WHERE student_id = ? AND status = 'borrowed'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id); // Assuming student_id is an integer
    $stmt->execute();
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
        .drop_active{
            display: block; /* or inline, inline-block, etc., depending on your layout needs */

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
                            <h1 class="m-0">Student Name:
                                <?php if (!empty($books)) {
                                    echo htmlspecialchars($books[0]['Student']);
                                } ?>
                            </h1>
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

                        <form id="book-request-form" class="space-y-6">
                            <?php foreach ($grouped_books as $date => $books_group): ?>
                                <div class="bg-blue-200 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-white">Date to Claim: <?php echo $date; ?></h3>
                                    <ul class="space-y-4"> <!-- Added <ul> for better structure -->
                                        <?php foreach ($books_group as $index => $book): ?>
                                            <li class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mb-2 flex flex-col">
                                                <div class="flex-1">
                                                    <div class="flex justify-between mb-6">
                                                        <div class="flex-1">
                                                            <h1 class="text-2xl font-bold mb-1">Title:</h1>
                                                            <p class="text-xl mb-4"><?php echo htmlspecialchars($book['Title']); ?></p>
                                                            <div class="mb-4">
                                                                <h2 class="text-lg font-semibold text-gray-600 mb-1">Borrow Category:</h2>
                                                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($book['Category']); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="w-32 h-40 bg-gray-200 border border-gray-300 flex items-center justify-center">
                                                          
                                                      
                                                <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Book Cover" class="w-32 h-40 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">

                                               

                                                        </div>
                                                    </div>
                                                    <div class="bg-blue-100 p-4 rounded-lg">
                                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <p class="text-sm font-semibold">Issued Date:</p>
                                                                <p class="text-sm"><?php echo htmlspecialchars($book['Issued_Date']); ?></p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold">Due Date:</p>
                                                                <p class="text-sm"><?php echo htmlspecialchars($book['Due_Date']); ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <p class="text-sm font-semibold">Fines:</p>
                                                                <p class="text-sm">₱<?php echo htmlspecialchars($book['Fines']); ?></p>
                                                            </div>
                                                            <div>
                                                                <select class="border border-gray-300 rounded p-1 mr-16">
                                                                    <option>0 Days</option>
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
                                    </ul> <!-- End of <ul> -->
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
</body>

</html>