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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


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





                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">

                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-muted-foreground">TOTAL PENDING BORROW BOOKS</p>
                                <div class="flex items-center text-red-600">
                                    <i class="fas fa-arrow-down mr-1 h-4 w-4"></i>
                                    <span class="text-sm font-medium">5.12%</span>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <?php


                                // Query to count borrowed books
                                $sql = "SELECT COUNT(*) AS total_borrowed FROM borrow WHERE status = 'pending'"; // Replace 'books' with your table name and 'status' with your field
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output the count
                                    $row = $result->fetch_assoc();
                                    $total =  $row['total_borrowed'];
                                }

                                ?>

                                <h3 class="text-2xl font-bold"><?php echo $total; ?></h3> <!-- Example number for registered students -->
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="#" class="text-sm font-medium text-primary hover:underline">View pending requests</a>
                                <div class="bg-green-400 h-12 w-12 flex items-center justify-center rounded-full"> <!-- Circle background with fixed width and height -->
                                    <i class="fas fa-book  text-white"></i> <!-- Icon size -->
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-muted-foreground">REGISTERED STUDENTS</p>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <?php

                                // Query to count all students
                                $sql = "SELECT COUNT(*) AS total_students FROM students"; // No WHERE clause, counting all rows
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output the count
                                    $row = $result->fetch_assoc();
                                    $total =  $row['total_students'];
                                } else {
                                    $total = 0; // Fallback in case no rows are found
                                }

                                ?>

                                <h3 class="text-2xl font-bold"><?php echo $total; ?></h3> <!-- Display total count of students -->
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="#" class="text-sm font-medium text-primary hover:underline">View student details</a>
                                <div class="bg-yellow-400 h-12 w-12 flex items-center justify-center rounded-full"> <!-- Circle background with fixed width and height -->
                                    <i class="fas fa-user-graduate text-white text-xl"></i> <!-- Icon for students -->
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-muted-foreground">BOOKS IN INVENTORY</p>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <?php
                                // Database connection
                                $conn2 = mysqli_connect("localhost", "root", "", "gfi_library_database_books_records");

                                if (!$conn2) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                // Query to fetch all table names
                                $tablesResult = $conn2->query("SHOW TABLES");

                                $total = 0; // Initialize total count

                                // Loop through each table
                                if ($tablesResult->num_rows > 0) {
                                    while ($table = $tablesResult->fetch_array()) {
                                        $tableName = $table[0];
                                        // Count rows in the current table
                                        $countResult = $conn2->query("SELECT COUNT(*) AS total FROM `$tableName`");

                                        if ($countResult) {
                                            $countRow = $countResult->fetch_assoc();
                                            $total += $countRow['total']; // Sum the counts
                                        }
                                    }
                                }

                                $conn2->close(); // Close the connection
                                ?>

                                <h3 class="text-2xl font-bold"><?php echo $total; ?></h3> <!-- Display total count of rows in all tables -->
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="#" class="text-sm font-medium text-primary hover:underline">View inventory</a>
                                <div class="bg-blue-400 h-12 w-12 flex items-center justify-center rounded-full">
                                    <i class="fas fa-book-open text-white text-xl"></i> <!-- Icon for inventory -->
                                </div>
                            </div>
                        </div>
                    </div>



                </div>












                <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>