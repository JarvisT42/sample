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
            <div class="p-4 border-2 min-h-screen border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="relative min-h-screen overflow-x-auto shadow-md sm:rounded-lg p-6">
                    <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                        </div>
                    </div>

                    <div class="overflow-y-auto max-h-screen">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-300">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">

                                <tr>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">Student Name</th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/3">Course</th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">Borrow Count</th> <!-- Reduced width -->
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">Date To Claim</th> <!-- Adjusted width -->
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">Action</th>
                                </tr>





                            </thead>
                            <tbody>
                            <?php
include '../connection.php';  // Ensure you have your database connection

// Get today's date
$today = date('Y-m-d');

// Fetch book_id and category for entries that exceed 3 days
$fetchSql = "SELECT book_id, Category FROM borrow 
             WHERE Date_To_Claim < DATE_SUB('$today', INTERVAL 3 DAY) AND status = 'pending'";
$fetchResult = $conn->query($fetchSql);

if ($fetchResult->num_rows > 0) {
    while ($row = $fetchResult->fetch_assoc()) {
        $book_id = $row['book_id'];
        $category = $row['Category'];

        // Update the book record in the corresponding category table
        $updateBookSql = "UPDATE gfi_library_database_books_records.$category
                          SET No_Of_Copies = No_Of_Copies + 1
                          WHERE id = $book_id";
        $conn->query($updateBookSql);
    }
}

// Update the status to 'Failed' for borrow entries that exceed 3 days
$updateSql = "UPDATE borrow
              SET status = 'failed-to-claim'
              WHERE Date_To_Claim < DATE_SUB('$today', INTERVAL 3 DAY) AND status = 'pending'";
$conn->query($updateSql);

// Query to get the updated records
$sql = "SELECT s.First_Name, s.Middle_Initial, s.Last_Name, s.S_Course, b.student_id, b.Time, COUNT(b.student_id) AS borrow_count, 

MIN(b.Date_To_Claim) AS nearest_date 
        FROM borrow b 
        JOIN students s ON b.student_id = s.id  -- Assuming the primary key in students is 'id'
        WHERE b.status = 'pending' 
        GROUP BY b.student_id";

$result = $conn->query($sql);

// Array to store records
$records = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}
?>

                                <?php if (!empty($records)): ?>
    <?php foreach ($records as $record): ?>
        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-300">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words" style="max-width: 300px;">
            <?php echo htmlspecialchars($record['First_Name'] . ' ' . $record['Middle_Initial'] . ' ' . $record['Last_Name']); ?>
            </th>
            <td class="px-6 py-4 break-words" style="max-width: 300px;">
                <?php echo htmlspecialchars($record['S_Course']); ?>
            </td>
            <td class="px-6 py-4"><?php echo htmlspecialchars($record['borrow_count']); ?></td>
            <td class="px-6 py-4">
                <?php
                // Format the nearest date
                $nearestDate = new DateTime($record['nearest_date']);
                // Format the date as 'F j, Y' and get the day of the week
                $formattedDate = $nearestDate->format('F j, Y') . ' - ' . $nearestDate->format('l');

                // Output the formatted date along with the Time value if available
                echo htmlspecialchars($formattedDate) . ' ' . htmlspecialchars($record['Time']);
                ?>
            </td>
            <td class="px-6 py-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    onclick="redirectToBookRequest('<?php echo htmlspecialchars($record['student_id']); ?>')">
                    Next
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="px-6 py-4 text-center">No records found.</td>
    </tr>
<?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function redirectToBookRequest(studentId) {
            // Redirect to book_request_2.php with student_id as a query parameter
            window.location.href = 'book_request_2.php?student_id=' + studentId;
        }
    </script>

  
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