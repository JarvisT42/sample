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
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-300">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">

                                <tr>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">
                                        <i class="fas fa-user"></i> Full Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/3">
                                        <i class="fas fa-book"></i> Role
                                    </th>

                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/3">
                                        <i class="fas fa-book"></i> Course
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                                        <i class="fas fa-list-ol"></i> Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">
                                        <i class="fas fa-calendar-alt"></i> Date To Claim
                                    </th>
                                    <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">
                                        <i class="fas fa-tasks"></i> Action
                                    </th>
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

                                // Query to get student records
                                $studentSql = "SELECT s.First_Name, b.role, s.Middle_Initial, s.Last_Name, c.course, b.student_id, b.Time, COUNT(b.student_id) AS borrow_count, 
                     MIN(b.Date_To_Claim) AS nearest_date 
              FROM borrow b 
              JOIN students s ON b.student_id = s.Student_Id  
              JOIN course c ON s.course_id = c.course_id  

              WHERE b.status = 'pending' 
              GROUP BY b.student_id";
                                $studentResult = $conn->query($studentSql);

                                // Query to get faculty records
                                $facultySql = "SELECT f.First_Name, b.role, f.Middle_Initial, f.Last_Name, b.faculty_id, b.Time, COUNT(b.faculty_id) AS borrow_count, 
                     MIN(b.Date_To_Claim) AS nearest_date 
              FROM borrow b 
              JOIN faculty f ON b.faculty_id = f.Faculty_Id  
              WHERE b.status = 'pending' 
              GROUP BY b.faculty_id";
                                $facultyResult = $conn->query($facultySql);

                                // Array to store combined records
                                $records = [];
                                if ($studentResult->num_rows > 0) {
                                    while ($row = $studentResult->fetch_assoc()) {
                                        $row['user_type'] = 'student'; // Mark as student
                                        $records[] = $row;
                                    }
                                }
                                if ($facultyResult->num_rows > 0) {
                                    while ($row = $facultyResult->fetch_assoc()) {
                                        $row['user_type'] = 'faculty'; // Mark as faculty
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
                                            <td class="px-6 py-4"><?php echo htmlspecialchars($record['role']); ?></td>

                                            <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                <?php
                                                // Display S_Course only if it exists (for students)
                                                echo $record['user_type'] === 'student' ? htmlspecialchars($record['course']) : 'N/A';
                                                ?>
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
                                                    onclick="redirectToBookRequest('<?php echo htmlspecialchars($record['user_type']); ?>', '<?php echo htmlspecialchars($record['user_type'] === 'student' ? $record['student_id'] : $record['faculty_id']); ?>')">
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
        function redirectToBookRequest(userType, userId) {
            // Redirect to book_request_2.php with appropriate ID parameter based on user type
            const param = userType === 'student' ? 'student_id' : 'faculty_id';
            window.location.href = 'book_request_2.php?' + param + '=' + userId;
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