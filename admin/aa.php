<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Borrowed Books per Month</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: green;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
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

    <div class="container">
        <h2>Most Borrowed Books Per Month</h2>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',  // Bar chart
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months of the year
                datasets: [{
                    label: 'Most Borrowed Book',
                    data: [40, 30, 50, 25, 60, 35, 55, 40, 45, 50, 30, 20],  // Times borrowed per month
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',  // Colors per bar
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(199, 199, 199, 0.2)',
                        'rgba(83, 102, 255, 0.2)',
                        'rgba(170, 102, 255, 0.2)',
                        'rgba(255, 202, 86, 0.2)',
                        'rgba(99, 132, 255, 0.2)',
                        'rgba(54, 235, 162, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(170, 102, 255, 1)',
                        'rgba(255, 202, 86, 1)',
                        'rgba(99, 132, 255, 1)',
                        'rgba(54, 235, 162, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Times Borrowed'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,  // Hide the legend, since each bar corresponds to one book
                    },
                    title: {
                        display: true,
                        text: 'Most Borrowed Book per Month'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                // Array to hold the book titles corresponding to each month
                                const books = [
                                    'Algebra Made Easy',
                                    'Filipino for Beginners',
                                    'Advanced Calculus',
                                    'World History 101',
                                    'Introduction to Physics',
                                    'Chemistry Basics',
                                    'Geometry for Everyone',
                                    'Biology Explained',
                                    'Literature Classics',
                                    'Modern Programming',
                                    'Environmental Science',
                                    'Business Management'
                                ];
                                return books[tooltipItem.dataIndex] + ': ' + tooltipItem.raw + ' times borrowed';
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>

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
            max-width: 600px;
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
                            <div class="container">
                                <h2>Most Borrowed Books Per Month</h2>
                                <canvas id="myChart"></canvas>
                            </div>

                            <script>
                                const ctx = document.getElementById('myChart').getContext('2d');
                                const myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                        datasets: [{
                                            label: 'Most Borrowed Book',
                                            data: [40, 30, 50, 25, 60, 35, 55, 40, 45, 50, 30, 20],
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)',
                                                'rgba(199, 199, 199, 0.2)',
                                                'rgba(83, 102, 255, 0.2)',
                                                'rgba(170, 102, 255, 0.2)',
                                                'rgba(255, 202, 86, 0.2)',
                                                'rgba(99, 132, 255, 0.2)',
                                                'rgba(54, 235, 162, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(199, 199, 199, 1)',
                                                'rgba(83, 102, 255, 1)',
                                                'rgba(170, 102, 255, 1)',
                                                'rgba(255, 202, 86, 1)',
                                                'rgba(99, 132, 255, 1)',
                                                'rgba(54, 235, 162, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Times Borrowed'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Months'
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            title: {
                                                display: true,
                                                text: 'Most Borrowed Book per Month'
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        const books = [
                                                            'Algebra Made Easy',
                                                            'Filipino for Beginners',
                                                            'Advanced Calculus',
                                                            'World History 101',
                                                            'Introduction to Physics',
                                                            'Chemistry Basics',
                                                            'Geometry for Everyone',
                                                            'Biology Explained',
                                                            'Literature Classics',
                                                            'Modern Programming',
                                                            'Environmental Science',
                                                            'Business Management'
                                                        ];
                                                        return books[tooltipItem.dataIndex] + ': ' + tooltipItem.raw + ' times borrowed';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>






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