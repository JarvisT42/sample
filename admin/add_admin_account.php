<?php
# Initialize the session
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <!-- Include Tailwind CSS -->
    <!-- Latest Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">

    <!-- Latest Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Latest Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        /* If you prefer inline styles, you can include them directly */
        .active-add-account {
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


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Create Account</h1> <!-- Adjusted text size -->
                    <!-- Button beside the title -->
                </div>

                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                The Create Account page allows administrators to set up new accounts with the required privileges. This page makes it easy to add new admins, ensuring that all necessary information—such as full name, email, and password—is gathered securely. Once an admin account is created, they will have access to the system's management features, providing them with the tools they need to maintain and organize the library efficiently.
                </div>


                <div class="grid grid-cols-2 gap-4 mb-4">

                
                    <div class="flex items-center justify-center rounded   dark:bg-gray-800">



                        <div class="w-full md:w-1/2 border border-gray-300 rounded-lg shadow-md ">

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <form id="createAccountForm" class="space-y-4">

                                    <!-- Full Name Field -->
                                    <div class="space-y-2">
                                        <label for="fullname" class="font-semibold text-gray-700">Full Name</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" id="fullname" name="fullname" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Username Field -->
                                    <div class="space-y-2">
                                        <label for="username" class="font-semibold text-gray-700">Username</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-user-circle"></i>
                                            </span>
                                            <input type="text" id="username" name="username" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="space-y-2">
                                        <label for="email" class="font-semibold text-gray-700">Email</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" id="email" name="email" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="space-y-2">
                                        <label for="password" class="font-semibold text-gray-700">Password</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" id="password" name="password" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div class="space-y-2">
                                        <label for="confirm-password" class="font-semibold text-gray-700">Confirm Password</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <span class="px-3 text-gray-500">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" id="confirm-password" name="confirm-password" required
                                                class="w-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-400 rounded-r-lg">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:bg-blue-800">
                                        <i class="fas fa-user-plus"></i> Create Account
                                    </button>
                                </form>
                            </div>

                        </div>



                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 dark:bg-gray-800">



                        <div class="w-full md:w-1/2 border border-gray-300 rounded-lg h-full shadow-md">
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse">
                                        <thead>
                                            <tr class="border-b">
                                                <th class="text-left p-2">ID</th>
                                                <th class="text-left p-2">Full Name</th>
                                                <th class="text-left p-2">Email</th>
                                                <th class="text-left p-2">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTableBody">
                                            <!-- Example Row with Data -->
                                            <tr class="border-b">
                                                <td class="p-2">1</td>
                                                <td class="p-2">John Doe</td>
                                                <td class="p-2">johndoe@example.com</td>
                                                <td class="p-2">
                                                    <!-- Delete Button with Icon -->
                                                    <button class="text-red-600 hover:text-red-800 focus:outline-none">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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