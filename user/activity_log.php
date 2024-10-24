<?php
# Initialize the session
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'user_header.php'; ?>

    <style>
        /* If you prefer inline styles, you can include them directly */



        .active-activity-logs {
            background-color: #f0f0f0;
            /* Example for light mode */
            color: #000;
            /* Example for light mode */
        }
    </style>
    <style>
        /* Force underline when the peer is checked */
        input:checked+label {
            text-decoration: underline;
        }

        /* Custom shadow and smooth transition */
        label {
            transition: color 0.3s ease, text-decoration 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Radio button appearance customization */
        input:checked+label {
            background-color: #3b82f6;
            /* Blue background for checked option */
            color: white;
            /* White text for checked option */
            border-color: #3b82f6;
        }
    </style>
    <style>
        .scrollable-table-container {
            overflow-y: auto;
            height: 560px;
        }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                <!-- Description Box -->


                <!-- Title Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Activity Log</h1> <!-- Adjusted text size -->
                    <!-- Button beside the title -->
                </div>



                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                    This feature provides a comprehensive summary of your book borrowing history. It includes a detailed log of all books you've borrowed in the past, along with a current overview of books you have on loan. </div>
                <!-- Main Content Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                        <div class="flex items-center space-x-4">




                            <div class="flex space-x-6">
                                <!-- First Radio Option -->
                                <div class="flex items-center">
                                    <input checked id="inline-checked-radio" type="radio" name="inline-radio-group" class="hidden peer">
                                    <label for="inline-checked-radio" class="ms-2 cursor-pointer text-sm font-semibold px-6 py-3 rounded-lg bg-gray-100 text-gray-900 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 peer-checked:underline peer-checked:bg-blue-500 peer-checked:text-white shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        Pending
                                    </label>
                                </div>

                                <!-- Second Radio Option -->
                                <div class="flex items-center">
                                    <input id="inline-radio" type="radio" name="inline-radio-group" class="hidden peer">
                                    <label for="inline-radio" class="ms-2 cursor-pointer text-sm font-semibold px-6 py-3 rounded-lg bg-gray-100 text-gray-900 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 peer-checked:underline peer-checked:bg-blue-500 peer-checked:text-white shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        History
                                    </label>
                                </div>
                            </div>







                            <!-- Dropdown and Button -->
                            <div class="relative hidden" id="dropdownContainer">
                                <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                                    </svg>
                                    Last 7 days
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdownRadio" class="z-20 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">

                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="filter-radio-example-2" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Last 7 days</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input id="filter-radio-example-3" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="filter-radio-example-3" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Last 30 days</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input id="filter-radio-example-4" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="filter-radio-example-4" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Last month</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input id="filter-radio-example-5" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="filter-radio-example-5" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Last year</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                        </div>

                        <!-- Search Input -->
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for Title">
                        </div>
                    </div>







                    <div id="table1" class="overflow-x-auto">

                        <div class="scrollable-table-container relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
                            <?php

                            include("../connection.php");
                            include("../connection2.php");

                            // Sanitize the student ID to prevent SQL injection
                            $id = intval($_SESSION["Id"]);

                            // Fetch the category and book_id based on the student_id
                            $categoryQuery = "SELECT Category, book_id, Date_To_Claim, Issued_Date, status 
                            FROM GFI_Library_Database.borrow 
                            WHERE student_id = ? 
                            AND status IN ('borrowed', 'pending')";
                            $stmt = $conn->prepare($categoryQuery);
                            $stmt->bind_param('i', $id); // Assuming student_id is an integer
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Initialize an array to hold the fetched book records
                            $books = [];

                            // Fetch all rows (there may be multiple books borrowed by the same student)
                            while ($row = $result->fetch_assoc()) {
                                $category = $row['Category'];
                                $bookId = $row['book_id'];
                                $dateToClaim = $row['Date_To_Claim'];
                                $issuedDate = $row['Issued_Date'];
                                $status = $row['status'];

                                // Prepare the SQL to fetch book details from the category-specific table
                                $query = "SELECT Title, Author FROM `$category` WHERE id = ?";

                                $bookStmt = $conn2->prepare($query);
                                $bookStmt->bind_param('i', $bookId);
                                $bookStmt->execute();
                                $bookResult = $bookStmt->get_result();

                                // Fetch the book details and store them in the $books array
                                if ($bookRow = $bookResult->fetch_assoc()) {
                                    $books[] = [
                                        'Title' => $bookRow['Title'],
                                        'Author' => $bookRow['Author'],
                                        'Date_To_Claim' => $dateToClaim,
                                        'Issued_Date' => $issuedDate,
                                        'status' => $status
                                    ];
                                }

                                $bookStmt->close();
                            }

                            $stmt->close();
                            ?>

                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Book Title</th>
                                        <th scope="col" class="px-6 py-3">Author</th>
                                        <th scope="col" class="px-6 py-3">Date To Claim</th>
                                        <th scope="col" class="px-6 py-3">Issued Date</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through the books to display them in the table
                                    foreach ($books as $row) {
                                    ?>
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo htmlspecialchars($row['Title']); ?>
                                            </th>
                                            <td class="px-6 py-4">
                                                <?php echo htmlspecialchars($row['Author']); ?>
                                            </td>

                                            <td class="px-6 py-4">
                                                <?php echo htmlspecialchars($row['Date_To_Claim']); ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <?php echo htmlspecialchars($row['Issued_Date']); ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <?php
                                                if (!empty($row['status']) && $row['status'] === 'failed-to-claim') {
                                                    echo 'Failed To Claim';
                                                } elseif (!empty($row['status']) && $row['status'] === 'borrowed') {
                                                    echo 'Borrowed';
                                                } elseif (!empty($row['status']) && $row['status'] === 'pending') {
                                                    echo 'Pending';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>





                    </div>

                    <!-- Table 2 and Dropdown (hidden initially) -->
                    <div id="table2-container" class="hidden">
                        <div id="table2" class="overflow-x-auto">
                            <div class="scrollable-table-container border border-gray-200 dark:border-gray-700">
                                <?php
                                // Query for books with status 'returned'
                                $categoryQueryReturned = "SELECT Category, book_id, Date_To_Claim, Issued_Date, status FROM GFI_Library_Database.borrow WHERE student_id = ? AND status = 'returned'";
                                $stmtReturned = $conn->prepare($categoryQueryReturned);
                                $stmtReturned->bind_param('i', $id); // Assuming student_id is an integer
                                $stmtReturned->execute();
                                $resultReturned = $stmtReturned->get_result();

                                // Initialize an array to hold the returned books
                                $returnedBooks = [];

                                // Fetch all rows for returned books
                                while ($rowReturned = $resultReturned->fetch_assoc()) {
                                    $category = $rowReturned['Category'];
                                    $bookId = $rowReturned['book_id'];
                                    $dateToClaim = $rowReturned['Date_To_Claim'];
                                    $issuedDate = $rowReturned['Issued_Date'];
                                    $status = $rowReturned['status'];

                                    // Prepare the SQL to fetch book details from the category-specific table
                                    $queryReturned = "SELECT Title, Author FROM `$category` WHERE id = ?";
                                    $bookStmtReturned = $conn2->prepare($queryReturned);
                                    $bookStmtReturned->bind_param('i', $bookId);
                                    $bookStmtReturned->execute();
                                    $bookResultReturned = $bookStmtReturned->get_result();

                                    // Fetch the book details and store them in the $returnedBooks array
                                    if ($bookRowReturned = $bookResultReturned->fetch_assoc()) {
                                        $returnedBooks[] = [
                                            'Title' => $bookRowReturned['Title'],
                                            'Author' => $bookRowReturned['Author'],
                                            'Date_To_Claim' => $dateToClaim,
                                            'Issued_Date' => $issuedDate,
                                            'status' => $status
                                        ];
                                    }

                                    $bookStmtReturned->close();
                                }

                                $stmtReturned->close();
                                ?>

                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book Title</th>
                                            <th scope="col" class="px-6 py-3">Author</th>
                                            <th scope="col" class="px-6 py-3">Date To Claim</th>
                                            <th scope="col" class="px-6 py-3">Returned Date</th>
                                            <th scope="col" class="px-6 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Loop through the returned books to display them in the table
                                        foreach ($returnedBooks as $rowReturned) {
                                        ?>
                                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <?php echo htmlspecialchars($rowReturned['Title']); ?>
                                                </th>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['Author']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['Date_To_Claim']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['Issued_Date']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['status']); ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>









                </div>
            </div>

        </div>

    </main>



    <script>
        // Event listener for the first radio button
        document.getElementById('inline-radio').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('table1').classList.add('hidden');
                document.getElementById('table2-container').classList.remove('hidden');
                document.getElementById('dropdownContainer').classList.remove('hidden');
            }
        });

        // Event listener for the second radio button
        document.getElementById('inline-checked-radio').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('table1').classList.remove('hidden');
                document.getElementById('table2-container').classList.add('hidden');
                document.getElementById('dropdownContainer').classList.add('hidden');
            }
        });

        // Toggle dropdown visibility
        document.getElementById('dropdownRadioButton').addEventListener('click', function() {
            const dropdown = document.getElementById('dropdownRadio');
            dropdown.classList.toggle('hidden');
        });
    </script>

</body>

</html>