<?php
# Initialize the session
require '../connection.php';

session_start();
if ($_SESSION["logged_Admin"] !== TRUE) {
    //echo "<script type='text/javascript'> alert ('Iasdasdasd.')</script>";
    echo "<script>" . "window.location.href='../index.php';" . "</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'admin_header.php'; ?>

    <style>
        /* If you prefer inline styles, you can include them directly */
        .active-dashboard {
            background-color: #f0f0f0;
            /* Example for light mode */
            color: #000;
            /* Example for light mode */
        }
    </style>
    <style>
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 100%;
            width: 100%;

        }

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        canvas {
            margin-top: 20px;
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Students Id</h1> <!-- Adjusted text size -->
                    <!-- Button beside the title -->
                </div>

                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                    The Students page allows administrators to add student IDs. Administrators can easily input and assign student IDs to ensure all students are properly documented for efficient tracking and management.
                </div>





                <div class="grid grid-cols-2 gap-4 mb-4">








                    <div class="flex items-center justify-center rounded   dark:bg-gray-800">



                        <div class="w-full md:w-1/2 border border-gray-300 rounded-lg shadow-md ">

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <form id="createAccountForm" class="space-y-4">
                                    <!-- Student ID 1 -->
                                    <div class="space-y-2">
                                        <label for="student-id-1" class="font-semibold text-gray-700">Student ID 1</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" id="student-id-1" name="student-id-1" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Student ID 2 -->
                                    <div class="space-y-2">
                                        <label for="student-id-2" class="font-semibold text-gray-700">Student ID 2</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" id="student-id-2" name="student-id-2"
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Student ID 3 -->
                                    <div class="space-y-2">
                                        <label for="student-id-3" class="font-semibold text-gray-700">Student ID 3</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" id="student-id-3" name="student-id-3"
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Student ID 4 -->
                                    <div class="space-y-2">
                                        <label for="student-id-4" class="font-semibold text-gray-700">Student ID 4</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" id="student-id-4" name="student-id-4"
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Student ID 5 -->
                                    <div class="space-y-2">
                                        <label for="student-id-5" class="font-semibold text-gray-700">Student ID 5</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <input type="text" id="student-id-5" name="student-id-5"
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:bg-blue-800">
                                        <i class="fas fa-user-plus"></i> Add Student IDs
                                    </button>
                                </form>






                            </div>

                        </div>




                        <script>
                            document.getElementById('createAccountForm').addEventListener('submit', function(event) {
                                event.preventDefault(); // Prevent the form from submitting the default way

                                // Gather all student IDs but only keep those that are not empty
                                const studentIds = {};

                                const student1 = document.getElementById('student-id-1').value;
                                const student2 = document.getElementById('student-id-2').value;
                                const student3 = document.getElementById('student-id-3').value;
                                const student4 = document.getElementById('student-id-4').value;
                                const student5 = document.getElementById('student-id-5').value;

                                if (student1) studentIds.student1 = student1;
                                if (student2) studentIds.student2 = student2;
                                if (student3) studentIds.student3 = student3;
                                if (student4) studentIds.student4 = student4;
                                if (student5) studentIds.student5 = student5;

                                // Check if there's any non-empty student ID to send
                                if (Object.keys(studentIds).length > 0) {
                                    // Send the data via POST to the backend
                                    fetch('add_student_id_save.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify(studentIds), // Send only non-empty student IDs as JSON
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                alert('Student IDs saved successfully!');
                                                // Optionally clear the form or reload the page
                                                document.getElementById('createAccountForm').reset();
                                            } else {
                                                alert('Failed to save Student IDs: ' + data.error);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('An error occurred while saving the student IDs.');
                                        });
                                } else {
                                    alert('Please fill in at least one Student ID.');
                                }
                            });
                        </script>






                    </div>




                    <div class="flex items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                        <?php
                        // Include database connection
                        include '../connection.php';

                        // Fetch users from the database
                        $sql = "SELECT id, student_id, status FROM students_id";
                        $result = $conn->query($sql);

                        // Initialize an empty array to hold users
                        $users = [];

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $users[] = $row;
                            }
                        }

                        // Close the database connection
                        $conn->close();
                        ?>




                        <div class="w-full md:w-1/2 border border-gray-300 rounded-lg h-full shadow-md">
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b">
                                                <th class="text-left p-2">No.</th>

                                                <th class="text-left p-2">Student Id</th>
                                                <th class="text-left p-2">Status</th>
                                                <th class="text-left p-2">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="userTableBody">
                                            <?php
                                            if (!empty($users)) {
                                                // Loop through each user and display their data in the table
                                                foreach ($users as $user) {
                                            ?>
                                                    <tr class="border-b" data-user-id="<?php echo htmlspecialchars($user['id']); ?>">

                                                        <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                            <?php echo htmlspecialchars($user['id']); ?>
                                                        </td>
                                                        <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                            <?php echo htmlspecialchars($user['student_id']); ?>
                                                        </td>
                                                        <td class="px-6 py-4 break-words" style="max-width: 300px;">
                                                            <?php echo htmlspecialchars($user['status']); ?>
                                                        </td>

                                                        <td class="px-6 py-4">
                                                            <button class="text-red-600 hover:text-red-800 focus:outline-none" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="4" class="text-center p-2">No users found</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <script>
    // Function to delete a user by ID
    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            // Send the DELETE request via fetch to the backend
            fetch('add_student_id_delete.php', {
                method: 'POST', // Use POST method
                headers: {
                    'Content-Type': 'application/json', // Specify that we're sending JSON data
                },
                body: JSON.stringify({ id: userId }), // Send the user ID as JSON
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully!');
                    location.reload(); // Reload the page to update the table
                } else {
                    alert('Failed to delete user: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the user.');
            });
        }
    }
</script>



                    </div>
















                </div>













            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>
    <script>
        // Function to automatically show the dropdown if on book_request.php
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownRequest = document.getElementById('dropdown-setting');

            // Open the dropdown menu for 'Request'
            dropdownRequest.classList.remove('hidden');
            dropdownRequest.classList.add('block'); // Make the dropdown visible

        });
    </script>

</body>

</html>