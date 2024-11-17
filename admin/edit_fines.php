<?php
# Initialize the session
session_start();
if (!isset($_SESSION['logged_Admin']) || $_SESSION['logged_Admin'] !== true) {
    header('Location: ../index.php');

    exit;
}

// Include your database connection
include '../connection.php';

// Fetch current fines from the 'library_fines' table
$query = "SELECT fines FROM library_fines LIMIT 1";
$result = $conn->query($query);

// Initialize a variable to store the current fine amount
$currentFines = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentFines = $row['fines']; // Store the fines amount
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'admin_header.php'; ?>
    <style>
        /* If you prefer inline styles, you can include them directly */
        .active-edit-fines {
            background-color: #f0f0f0;
            color: #000;
        }

        .active-setting {
            background-color: #f0f0f0;
            color: #000;
        }
    </style>


    
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">
        <div class="p-4 sm:ml-64 ">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 ">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Edit Fines</h1>
                </div>

                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                    The Edit Fines page allows administrators to manage and adjust fines for overdue items in the library system. This page provides an intuitive interface for updating fine amounts, setting thresholds for different types of media, and reviewing any existing penalties. With this feature, administrators can ensure that fine structures are flexible, fair, and up to date, promoting an organized and efficient library system.
                </div>


                <div class="flex items-center justify-center pt-20 px-52 pb-20">

                    <div class="w-full max-w-lg mx-auto p-8 border-2 border-gray-300 bg-white shadow-lg rounded-lg h-auto">
                        <div class="p-6 border border-gray-300 rounded-lg bg-gray-50 w-full">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Fines</h2>

                            <div class="space-y-6">
                                <!-- Current Fines Section -->
                                <div class="space-y-2">
                                    <label for="current-fines" class="text-lg font-semibold text-gray-700">Current Fines</label>
                                    <div class="relative">
                                        <input id="current-fines" value="<?php echo htmlspecialchars($currentFines); ?>" type="text" class="input w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" readonly />
                                        <i class="fas fa-dollar-sign absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                </div>

                                <!-- Edit Fines Section -->
                                <div class="space-y-2">
                                    <label for="edit-fines" class="text-lg font-semibold text-gray-700">Edit Fines</label>
                                    <div class="relative">
                                        <input id="edit-fines" placeholder="Edit fines" type="text" class="input w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                                        <i class="fas fa-pencil-alt absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="text-center">
                                    <button class="bg-blue-500 text-white font-semibold px-6 py-3 rounded-md hover:bg-blue-600 transition duration-300" onclick="updateFines()">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="./src/components/header.js"></script>

    <script>
        function updateFines() {
            const newFines = document.getElementById('edit-fines').value;

            if (newFines === '' || isNaN(newFines)) {
                alert("Please enter a valid fine amount.");
                return;
            }

            fetch('edit_fines_update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        fines: newFines
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Fines updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating fines.');
                });
        }
    </script>
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