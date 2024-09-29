<?php
# Initialize the session
session_start();

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

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">


                <div class="bg-gray-100 p-6 w-full mx-auto">

                    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
                        <h1 class="text-2xl font-bold text-center mb-4">Gensantos Foundation College Inc.</h1>
                        <p class="text-sm text-center mb-4">Bulaong Extension Brgy. Dadiangas West General Santos City</p>

                        <h2 class="text-xl font-semibold text-center mb-6">LIBRARY OVERDUE SLIP</h2>

                        <form class="space-y-4">
                            <div class="flex justify-between">
                                <div class="w-1/2 pr-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">NAME:</label>
                                    <input type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                </div>
                                <div class="w-1/2 pl-2">
  <label for="date" class="block text-sm font-medium text-gray-700">DATE:</label>
  <input type="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly />
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
  });
</script>


                            </div>

                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="status"
                                        value="student" />
                                    <span class="ml-2">STUDENT</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="status"
                                        value="faculty-fulltime" />
                                    <span class="ml-2">FACULTY (FULLTIME)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="status"
                                        value="faculty-parttime" />
                                    <span class="ml-2">FACULTY (PARTTIME)</span>
                                </label>
                            </div>

                            <div>
                                <label for="books" class="block text-sm font-medium text-gray-700">NO. OF BOOK/S BORROWED:</label>
                                <input type="number" id="books" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>

                            <div>
                                <label for="overdue" class="block text-sm font-medium text-gray-700">DAY/S OVERDUE:</label>
                                <input type="number" id="overdue" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">TOTAL AMOUNT TO BE PAID:</label>
                                <input type="number" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>