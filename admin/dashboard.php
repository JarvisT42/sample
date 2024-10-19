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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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



                <div class="col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">



                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm ">
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





                <div class="col-span-1 grid grid-cols-1 md:grid-cols-2 gap-4">



                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-muted-foreground">MOST BORROWED BOOKS</p>
            <div class="flex items-center text-red-600">
                <i class="fas fa-arrow-down mr-1 h-4 w-4"></i>
                <span class="text-sm font-medium">5.12%</span>
            </div>
        </div>
        <canvas id="pendingBooksChart" class="mt-4"></canvas>
        <?php
        // Query to count borrowed books
        $sql = "SELECT COUNT(*) AS total_borrowed FROM borrow WHERE status = 'pending'";
        $result = $conn->query($sql);
        $total = 0;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total = $row['total_borrowed'];
        }
        ?>
        <h3 class="text-2xl font-bold mt-2"><?php echo $total; ?></h3> <!-- Display total count -->
        <div class="mt-4 flex items-center justify-between">
            <a href="#" class="text-sm font-medium text-primary hover:underline">View pending requests</a>
            <div class="bg-green-400 h-12 w-12 flex items-center justify-center rounded-full"> <!-- Circle background with fixed width and height -->
                <i class="fas fa-book text-white"></i> <!-- Icon size -->
            </div>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('pendingBooksChart').getContext('2d');
    var pendingBooksChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending Books'],
            datasets: [{
                label: 'Total',
                data: [<?php echo $total; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Books'
                    }
                }
            }
        }
    });
</script>





<div class="rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="p-8"> <!-- Increased padding for the container -->
        <div class="bg-white rounded-lg shadow-sm p-6"> <!-- Increased padding for the inner box -->
            <h2 class="font-semibold text-xl mb-6 flex items-center justify-between"> <!-- Increased font size -->
                Borrow Activity
                <span class="text-md font-normal text-gray-500">3 Today</span> <!-- Increased font size -->
            </h2>
            <div class="space-y-6"> <!-- Increased space between items -->
                <!-- Activity Items -->
                <div class="flex justify-between items-center">
                    <div class="flex items-start">
                        <span class="bg-green-500 w-3 h-3 rounded-full mt-1.5 mr-3 flex-shrink-0"></span> <!-- Increased dot size -->
                        <p class="text-lg">Due Soon</p> <!-- Increased font size -->
                    </div>
                    <span class="text-md text-gray-500">32 min</span> <!-- Increased font size -->
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-start">
                        <span class="bg-red-500 w-3 h-3 rounded-full mt-1.5 mr-3 flex-shrink-0"></span> <!-- Increased dot size -->
                        <p class="text-lg">Due Today</p> <!-- Increased font size -->
                    </div>
                    <span class="text-md text-gray-500">56 min</span> <!-- Increased font size -->
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-start">
                        <span class="bg-blue-500 w-3 h-3 rounded-full mt-1.5 mr-3 flex-shrink-0"></span> <!-- Increased dot size -->
                        <p class="text-lg">Due Soon</p> <!-- Increased font size -->
                    </div>
                    <span class="text-md text-gray-500">2 hrs</span> <!-- Increased font size -->
                </div>
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