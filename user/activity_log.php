<?php
# Initialize the session
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');

    exit;
}

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
                                        Transaction
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
                            $id = intval($_SESSION["Student_Id"]);

                            // Fetch the category and book_id based on the student_id
                            $categoryQuery = "SELECT Category, book_id, accession_no, Date_To_Claim, Issued_Date, due_date, status 
                  FROM borrow 
                  WHERE student_id = ? 
                  AND status IN ('failed-to-claim', 'borrowed', 'pending', 'lost')";
                            $stmt = $conn->prepare($categoryQuery);
                            $stmt->bind_param('i', $id); // Assuming student_id is an integer
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Prepare the SQL to fetch book_condition from `accession_records`
                            $accessionQuery = "SELECT book_condition FROM `accession_records` WHERE accession_no = ? AND borrower_id = ? AND available = 'no'";
                            $stmt3 = $conn->prepare($accessionQuery);

                            // Initialize an array to hold the fetched book records
                            $books = [];

                            // Fetch all rows (there may be multiple books borrowed by the same student)
                            while ($row = $result->fetch_assoc()) {
                                $category = $row['Category'];
                                $bookId = $row['book_id'];
                                $accessionNo = $row['accession_no']; // Retrieve accession_no from borrow table
                                $dateToClaim = $row['Date_To_Claim'];
                                $issuedDate = $row['Issued_Date'];
                                $dueDate = $row['due_date']; // Retrieve due_date from database
                                $status = $row['status'];
                                $bookCondition = "N/A"; // Default value if no condition is found

                                // Fetch the book condition from `accession_records`
                                if ($stmt3) {
                                    $stmt3->bind_param('si', $accessionNo, $id); // Bind accession_no and borrower_id
                                    $stmt3->execute();
                                    $accessionResult = $stmt3->get_result();
                                    if ($accessionRow = $accessionResult->fetch_assoc()) {
                                        $bookCondition = $accessionRow['book_condition'];
                                    }
                                }

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
                                        'Category' => $category,
                                        'Date_To_Claim' => $dateToClaim,
                                        'Issued_Date' => $issuedDate,
                                        'Due_Date' => $dueDate, // Store the due date in the array
                                        'status' => $status,
                                        'book_condition' => $bookCondition // Include the book condition
                                    ];
                                }

                                $bookStmt->close();
                            }

                            $stmt->close();
                            $stmt3->close();
                            ?>


                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Book Title</th>
                                        <th scope="col" class="px-6 py-3">Author</th>
                                        <th scope="col" class="px-6 py-3">Date To Claim</th>
                                        <th scope="col" class="px-6 py-3">Issued Date</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                        <th scope="col" class="px-6 py-3">Action</th>

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
                                                } else {
                                                    echo 'Lost';
                                                }
                                                ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <button
                                                    type="button"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                                    onclick="openModal('<?php echo htmlspecialchars($row['Title']); ?>', '<?php echo htmlspecialchars($row['Category']); ?>', '<?php echo htmlspecialchars($row['status']); ?>', '<?php echo htmlspecialchars($row['Date_To_Claim']); ?>', '<?php echo htmlspecialchars($row['Issued_Date']); ?>', '<?php echo htmlspecialchars($row['Due_Date']); ?>', '<?php echo htmlspecialchars($row['book_condition'] ?? 'N/A'); ?>')">
                                                    View
                                                </button>
                                            </td>






                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>





                    </div>


                    <div id="bookModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md" onclick="closeOnOutsideClick(event)">
                        <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg mx-4 md:mx-0" onclick="event.stopPropagation()">
                            <!-- Header Section -->
                            <div class="flex items-center justify-between p-5 rounded-t-lg bg-gray-800 text-white">
                                <h5 class="text-xl font-semibold">Book Details</h5>
                                <button type="button" class="text-white hover:text-gray-200" onclick="closeModal()">
                                    <span class="text-2xl font-bold">&times;</span>
                                </button>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 text-gray-700">
                                <div class="mb-4">
                                    <p class="font-medium text-gray-600">Title:</p>
                                    <p id="modalTitle" class="pl-2 text-gray-800">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-600">Category:</p>
                                    <p id="modalCategory" class="pl-2 text-gray-800">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-600">Status:</p>
                                    <p id="modalStatus" class="pl-2 text-gray-800">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-600">Date to Claim:</p>
                                    <p id="modalDateToClaim" class="pl-2 text-gray-800">N/A</p>
                                </div>
                                <div id="dueDateContainer" class="mb-4 hidden">
                                    <p class="font-medium text-gray-600">Due Date:</p>
                                    <p id="modalDueDate" class="pl-2 text-gray-800">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-600">Book Condition:</p>
                                    <p id="modalBookCondition" class="pl-2 text-gray-800">N/A</p>
                                </div>
                            </div>


                            <!-- Footer Section -->
                            <div class="flex justify-end p-4 rounded-b-lg bg-gray-800">
                                <button type="button" class="bg-gray-600 text-white font-medium px-4 py-2 rounded-md hover:bg-gray-500" onclick="closeModal()">Close</button>
                            </div>
                        </div>
                    </div>






                    <script>
                        function closeOnOutsideClick(event) {
                            // Check if the click is outside the modal content
                            const modalContent = document.querySelector("#bookModal > div");
                            if (!modalContent.contains(event.target)) {
                                closeModal();
                            }
                        }

                        function closeModal() {
                            document.getElementById('bookModal').classList.add('hidden');
                        }

                        // Optional: Function to open the modal
                        function openModal(title, category, status, dateToClaim, issuedDate, dueDate, bookCondition) {
                            document.getElementById('modalTitle').textContent = title;
                            document.getElementById('modalCategory').textContent = category;
                            document.getElementById('modalStatus').textContent = status;
                            document.getElementById('modalDateToClaim').textContent = dateToClaim;
                            document.getElementById('modalBookCondition').textContent = bookCondition || 'N/A';

                            const dueDateContainer = document.getElementById('dueDateContainer');
                            if (status === 'borrowed') {
                                document.getElementById('modalDueDate').textContent = dueDate; // Show actual Due Date
                                dueDateContainer.style.display = 'block'; // Show Due Date section
                            } else {
                                dueDateContainer.style.display = 'none'; // Hide Due Date section
                            }

                            document.getElementById('bookModal').classList.remove('hidden');
                        }
                    </script>











                    <div id="table2-container" class="hidden">
                        <div id="table2" class="overflow-x-auto">
                            <div class="scrollable-table-container border border-gray-200 dark:border-gray-700">
                                <?php
                                // Query for books with status 'returned'
                                $categoryQueryReturned = "SELECT Category, book_id, Issued_Date, total_fines, status FROM GFI_Library_Database.borrow WHERE student_id = ? AND (status = 'returned' OR status = 'replaced')";

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
                                    $issuedDate = $rowReturned['Issued_Date'];
                                    $totalFines = number_format((float)$rowReturned['total_fines'], 2); // Ensure proper formatting
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
                                            'Issued_Date' => $issuedDate,
                                            'Total_Fines' => $totalFines,
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
                                            <th scope="col" class="px-6 py-3">Returned Date</th>
                                            <th scope="col" class="px-6 py-3">Total Fines</th>
                                            <th scope="col" class="px-6 py-3">Status</th>
                                            <th scope="col" class="px-6 py-3">Action</th>
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
                                                    <?php echo htmlspecialchars($rowReturned['Issued_Date']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['Total_Fines']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php echo htmlspecialchars($rowReturned['status']); ?>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <button
                                                        type="button"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                                        onclick="openModalReturned('<?php echo htmlspecialchars($rowReturned['Title']); ?>', '<?php echo htmlspecialchars($category); ?>', '<?php echo htmlspecialchars($rowReturned['status']); ?>', '<?php echo htmlspecialchars($rowReturned['Total_Fines']); ?>')">
                                                        View
                                                    </button>
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

                    <div id="bookModalReturned" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm" onclick="closeOnOutsideClickReturned(event)">
                        <div class="bg-yellow-50 rounded-lg shadow-lg w-full max-w-md mx-4 md:mx-0" onclick="event.stopPropagation()">
                            <!-- Header Section -->
                            <div class="flex items-center justify-between p-4 rounded-t-lg bg-red-700 text-yellow-100">
                                <h5 class="text-lg font-bold">Returned Book Details</h5>
                                <button type="button" class="text-yellow-200 hover:text-yellow-100" onclick="closeModalReturned()">
                                    <span class="text-2xl font-bold">&times;</span>
                                </button>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 text-gray-800">
                                <div class="mb-4">
                                    <p class="font-semibold text-red-800">Title:</p>
                                    <p id="modalReturnedTitle" class="pl-2 text-red-900">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-semibold text-red-800">Category:</p>
                                    <p id="modalReturnedCategory" class="pl-2 text-red-900">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-semibold text-red-800">Status:</p>
                                    <p id="modalReturnedStatus" class="pl-2 text-red-900">N/A</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-semibold text-red-800">Total Fines:</p>
                                    <p id="modalReturnedTotalFines" class="pl-2 text-red-900">N/A</p>
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="flex justify-end p-4 rounded-b-lg bg-red-700">
                                <button type="button" class="bg-yellow-600 text-red-900 font-semibold px-4 py-2 rounded-lg hover:bg-yellow-500" onclick="closeModalReturned()">Close</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        function closeOnOutsideClickReturned(event) {
                            const modalContent = document.querySelector("#bookModalReturned > div");
                            if (!modalContent.contains(event.target)) {
                                closeModalReturned();
                            }
                        }

                        function closeModalReturned() {
                            document.getElementById('bookModalReturned').classList.add('hidden');
                        }

                        function openModalReturned(title, category, status, totalFines) {
                            document.getElementById('modalReturnedTitle').textContent = title;
                            document.getElementById('modalReturnedCategory').textContent = category;
                            document.getElementById('modalReturnedStatus').textContent = status;
                            document.getElementById('modalReturnedTotalFines').textContent = totalFines;

                            document.getElementById('bookModalReturned').classList.remove('hidden');
                        }
                    </script>











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