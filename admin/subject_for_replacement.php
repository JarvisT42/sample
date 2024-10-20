<?php
session_start();
// if ($_SESSION["loggedin"] !== TRUE) {
//     echo "<script>window.location.href='../index.php';</script>";
//     exit;
// }



?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include 'admin_header.php'; ?>

    <style>
        .active-books {
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

                <!-- Title Box -->
                <!-- Title and Button Box -->
                <?php include './src/components/books.php'; ?>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <ul class="flex flex-wrap gap-2 p-5 border border-dashed rounded-md w-full">


                        <li><a class="px-4 py-2 " href="books.php">All</a></li>
                        <br>
                        <li><a class="px-4 py-2 " href="add_books.php">Add Books</a></li>
                        <br>
                        <li><a class="px-4 py-2 " href="edit_records.php">Edit Records</a></li>

                        <br>

                        <li class="#"><a href="damage.php">Damage Books</a></li>
                        <br>
                        <li><a class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" href="subject_for_replacement.php">Subject for Replacement</a></li>
                    </ul> <!-- Button beside the title -->


                </div>

                <!-- Main Content Box -->




                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
    <?php
    // Include database connection files
    include '../connection.php';
    include '../connection2.php';

    // Query to get book_id and category where status is empty
    $query = "SELECT book_id, category FROM GFI_Library_Database.book_replacement WHERE status = ''";
    $result = $conn->query($query);
    ?>

    <div class="overflow-y-auto max-h-screen">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">
                <tr>
                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">
                        <i class="fas fa-book"></i> Book Title
                    </th>
                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/3">
                        <i class="fas fa-user"></i> Author
                    </th>
                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                        <i class="fas fa-list-ol"></i> Quantity
                    </th>
                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">
                        <i class="fas fa-tags"></i> Category
                    </th>
                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">
                        <i class="fas fa-tasks"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) :
                    $category = $row['category'];
                    $book_id = $row['book_id'];

                    // Fetch the book details from the respective category table
                    $titleQuery = "SELECT Title, Author, No_Of_Copies FROM `$category` WHERE id = $book_id";
                    $bookResult = $conn2->query($titleQuery);

                    if ($bookResult->num_rows > 0) :
                        while ($bookRow = $bookResult->fetch_assoc()) :
                ?>
                           <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-300">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words" style="max-width: 300px;">
                                                    <?php echo htmlspecialchars($bookRow['Title']); ?>
                                                </th>
                                                <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                    <?php echo htmlspecialchars($bookRow['Author']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($bookRow['No_Of_Copies']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($category); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="redirectToBookRequest('<?php echo $book_id; ?>')">
                                                        Next
                                                    </button>
                                                </td>
                                            </tr>
                <?php
                        endwhile;
                    endif;
                endwhile;
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function redirectToBookRequest(bookId) {
            // Replace with actual redirection logic
            alert('Redirecting to book request for Book ID: ' + bookId);
        }
    </script>
</div>










            </div>

        </div>
        </div>

    </main>

    <script src="./src/components/header.js"></script>

</body>

</html>