<?php
session_start();
include '../connection.php';  // Ensure you have your database connection

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .active-replacement-books {
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
            <div class="p-4 border-2 min-h-screen border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="relative min-h-screen overflow-x-auto shadow-md sm:rounded-lg p-6">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                        <h1 class="text-3xl font-semibold">Book Request</h1>
                    </div>

                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                        The Book Request page allows administrators to view and manage requests submitted by students for library materials. This interface provides a comprehensive list of all online requests, enabling admins to efficiently track requested books and streamline the lending process. By centralizing this information, administrators can ensure timely processing of requests and maintain an organized library system.
                    </div>



                    <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for names">
                        </div>
                    </div>

                    <div class="overflow-y-auto max-h-screen">

                    <table id="borrowed-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">Student Name</th>
                                        <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">Way of Borrow</th>
                                        <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/3">Course</th>
                                        <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">Number of Books Borrowed</th>
                                   
                                        <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="borrowed-table-body">
                                    <!-- Borrowed books data will be displayed here -->
                                    <?php
                                    include '../connection.php';  // Ensure you have your database connection

                                    // Get today's date
                                    $today = date('Y-m-d');

                                    // Fetch book_id and category for entries that exceed 3 days





                                    // Query to fetch all pending borrow entries along with student names and their borrowing method
                                    $sql = "SELECT 
                                b.student_id,  -- Add this line
                                b.Way_Of_Borrow,
                                 b.walk_in_id,
                                CASE 
                                    WHEN b.Way_Of_Borrow = 'online' THEN CONCAT(s.First_Name, ' ', s.Last_Name) 
                                    WHEN b.Way_Of_Borrow = 'walk-in' THEN b.Full_Name 
                                    ELSE '' 
                                END AS First_Name,
                                CASE 
                                    WHEN b.Way_Of_Borrow = 'online' THEN s.S_Course
                                    WHEN b.Way_Of_Borrow = 'walk-in' THEN '' 
                                    ELSE '' 
                                END AS Course,
                                b.Due_Date,
                                b.Issued_Date,
                                COUNT(b.student_id) AS borrow_count,
                                MIN(CASE 
                                    WHEN b.Due_Date = '' THEN DATE_ADD(b.Issued_Date, INTERVAL 3 DAY)
                                    ELSE b.Due_Date
                                END) AS nearest_date,
                                MIN(b.Time) AS Time  
                            FROM borrow b
                            LEFT JOIN students s ON b.student_id = s.id  
                            WHERE b.status = 'lost'
                            GROUP BY b.Way_Of_Borrow, b.student_id, b.Full_Name, b.Return_Date";





                                    $borrowData = $conn->query($sql);
                                    $conn->close(); // Close the database connection
                                    ?>
                                    <?php if ($borrowData && $borrowData->num_rows > 0): ?>
                                        <?php while ($row = $borrowData->fetch_assoc()): ?>
                                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-300">
                                           

                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words student-name" style="max-width: 300px;">
                                                    <?php echo htmlspecialchars($row['First_Name']); ?> </td>

                                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['Way_Of_Borrow']); ?></td>




                                                <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                    <?php echo htmlspecialchars($row['Course']); ?> </td>
                                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['borrow_count']); ?></td>
                                            


                                            


                                                <td class="px-6 py-4">
                                                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                                        onclick="redirectToBookRequest('<?php echo htmlspecialchars($row['Way_Of_Borrow']); ?>', '<?php echo htmlspecialchars($row['walk_in_id'] ?? ''); ?>', '<?php echo htmlspecialchars($row['student_id'] ?? ''); ?>')">
                                                        Next
                                                    </button>
                                                </td>





                                            </tr>



                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center">No records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <script>
                                function redirectToBookRequest(wayOfBorrow, walkInId, studentId) {
                                    let url;
                                    if (wayOfBorrow === 'online') {
                                        url = 'lost_book_online.php?student_id=' + studentId; // Append student_id if needed
                                    } else if (wayOfBorrow === 'walk-in') {
                                        url = 'lost_book_walkiln.php?walk_in_id=' + walkInId; // Append walk_in_id if needed
                                    }
                                    if (url) {
                                        window.location.href = url; // Redirect to the chosen URL
                                    }
                                }
                            </script>

                            
                    </div>
                </div>
            </div>
        </div>
    </main>

 


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

<?php
$conn->close(); // Close the database connection
?>