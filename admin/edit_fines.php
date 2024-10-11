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
        .active-dashboard {
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



            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 h-screen flex items-center justify-center">
            <div class="w-full max-w-lg mx-auto p-8 border-2 border-gray-300 bg-white shadow-lg rounded-lg h-4/6 flex items-center justify-center">
            <div class="p-4 border border-gray-300 rounded-lg">
                        <div class="space-y-4">
                            <!-- Current Fines Section -->
                            <div class="space-y-2 flex flex-col">
                                <label for="current-fines" class="text-lg font-semibold text-gray-700">Current Fines</label>
                                <div class="relative">
                                    <input id="current-fines" placeholder="Enter current fines" type="text" class="input w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                                    <i class="fas fa-dollar-sign absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <!-- Edit Fines Section -->
                            <div class="space-y-2 flex flex-col">
                                <label for="edit-fines" class="text-lg font-semibold text-gray-700">Edit Fines</label>
                                <div class="relative">
                                    <input id="edit-fines" placeholder="Edit fines" type="text" class="input w-full p-3 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                                    <i class="fas fa-pencil-alt absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>