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
        .active-students {
            background-color: #f0f0f0;
            /* Example for light mode */
            color: #000;
            /* Example for light mode */
        }
    </style>

</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">



                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Students</h1> <!-- Adjusted text size -->
                    <!-- Button beside the title -->
                </div>

                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                    The Students page displays all currently registered students. This page provides administrators with an easy-to-use interface to view and manage student information, such as full name, email, and student ID. It ensures that all registered students are properly documented and accessible for efficient tracking and management.
                </div>



                <?php
// Include database connection file
include '../connection.php';

// Query to get student data
$query = "SELECT * FROM students";
$result = $conn->query($query);
?>

<div class="overflow-y-auto max-h-screen">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-300">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">
            <tr>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">
                    <i class="fas fa-user"></i> Name
                </th>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                    <i class="fas fa-venus-mars"></i> Gender
                </th>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/4">
                    <i class="fas fa-map-marker-alt"></i> Email
                </th>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">
                    <i class="fas fa-phone-alt"></i> Contact
                </th>
                <!-- <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                    <i class="fas fa-user-tag"></i> Type
                </th> -->
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                    <i class="fas fa-graduation-cap"></i> Year Level
                </th>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/12">
                    <i class="fas fa-check-circle"></i> Status
                </th>
                <th scope="col" class="px-6 py-3 border-b border-gray-300 w-1/6">
                    <i class="fas fa-tasks"></i> Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-300">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words" style="max-width: 300px;">
                            <?php echo htmlspecialchars($row['First_Name']); ?>
                        </th>
                        <td class="px-6 py-4">
                            <?php echo htmlspecialchars($row['S_Gender']); ?>
                        </td>
                        <td class="px-6 py-4 break-words" style="max-width: 300px;">
                            <?php echo htmlspecialchars($row['Email_Address']); ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo htmlspecialchars($row['Mobile_Number']); ?>
                        </td>
                        <!-- <td class="px-6 py-4">
                            Student
                        </td> -->
                        <td class="px-6 py-4">
                            <?php echo htmlspecialchars($row['Year_Level']); ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </td>
                        <td class="px-6 py-4">
    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" onclick="openModal('<?php echo htmlspecialchars($row['Id']); ?>', '<?php echo htmlspecialchars($row['First_Name']); ?>', '<?php echo htmlspecialchars($row['S_Gender']); ?>', '<?php echo htmlspecialchars($row['Email_Address']); ?>', '<?php echo htmlspecialchars($row['Mobile_Number']); ?>', '<?php echo htmlspecialchars($row['Year_Level']); ?>', '<?php echo htmlspecialchars($row['status']); ?>')">
        Edit
    </button>
</td>

                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center">
                        No students found.
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal with Dark Background Overlay -->
<div id="modalOverlay" class="fixed inset-0 hidden z-40 bg-black bg-opacity-50"></div> <!-- Dark Background -->

<div id="editModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg mx-auto">

            <!-- Modal Header -->
            <div class="bg-red-800 text-white rounded-t-lg">
                <h2 class="text-lg font-semibold p-4">Please Enter Details Below</h2>
            </div>

            <!-- Modal Body -->
            <div class="p-6 bg-white rounded-b-lg shadow-md">
                <form id="studentForm" class="space-y-4" method="POST">
                    <!-- Example Input Fields -->
                     
                    <div class="grid grid-cols-3 items-center gap-4 mt-3">
                        <label for="name" class="text-left">Name:</label>
                        <input id="name" name="name" placeholder="Name" class="col-span-2 border rounded px-3 py-2" readonly />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label for="gender" class="text-left">Gender:</label>
                        <input id="gender" name="gender" placeholder="Gender" class="col-span-2 border rounded px-3 py-2" readonly />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label for="email" class="text-left">Email:</label>
                        <input id="email" name="email" placeholder="Email" class="col-span-2 border rounded px-3 py-2" readonly />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label for="contact" class="text-left">Contact:</label>
                        <input id="contact" name="contact" placeholder="Contact" class="col-span-2 border rounded px-3 py-2" readonly />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label for="year_level" class="text-left">Year Level:</label>
                        <input id="year_level" name="year_level" placeholder="Year Level" class="col-span-2 border rounded px-3 py-2" readonly />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label for="status" class="text-left">Status:</label>
                        <select id="status" name="status" class="col-span-2 border rounded px-3 py-2" >
                            <option value="" disabled selected>Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">banned</option>

                        </select>
                    </div>

                    <input type="hidden" id="student_id" name="student_id" /> <!-- Hidden input to store the student ID -->

                    <!-- Submit and Close Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal()" class="bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 flex items-center">
                            Close
                        </button>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Open the modal and add a dark background
function openModal(id, name, gender, email, contact, yearLevel, status) {
    document.getElementById('name').value = name;
    document.getElementById('gender').value = gender;
    document.getElementById('email').value = email;
    document.getElementById('contact').value = contact;
    document.getElementById('year_level').value = yearLevel;
    document.getElementById('status').value = status;
    document.getElementById('modalOverlay').classList.remove('hidden'); // Show the dark background
    document.getElementById('editModal').classList.remove('hidden'); // Show the modal

    // Store the ID in a hidden field or in a variable
    document.getElementById('studentForm').setAttribute('data-id', id);
}

// Close the modal and hide the dark background
function closeModal() {
    document.getElementById('modalOverlay').classList.add('hidden'); // Hide the dark background
    document.getElementById('editModal').classList.add('hidden'); // Hide the modal
}

// Save form data when 'Save' button is clicked
document.getElementById('studentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission default action

    const studentId = this.getAttribute('data-id'); // Get the student ID from the data attribute
    const formData = {
        id: studentId, // Include the student ID
        status: document.getElementById('status').value // Include the status
    };

    // Perform the POST request to save the data
    fetch('student_edit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status updated successfully!');
            closeModal(); // Close the modal if save was successful
            location.reload(); // Reload the page to reflect changes

        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the status');
    });
});

</script>



















            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>