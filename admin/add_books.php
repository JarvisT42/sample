<?php
session_start();
// if ($_SESSION["loggedin"] !== TRUE) {
//     echo "<script>window.location.href='../index.php';</script>";
//     exit;
// }



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="borrow.css">
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <style>
        .active-books {
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

                <!-- Title Box -->
                <!-- Title and Button Box -->
                <?php include './src/components/books.php'; ?>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <ul class="flex flex-wrap gap-2 p-5 border border-dashed rounded-md w-full">


                        <li><a class="px-4 py-2 " href="books.php">All</a></li>
                        <br>
                        <li><a class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" href="add_books.php">Add Books</a></li>
                        <br>
                        <li><a href="#">Old Books</a></li>
                        <br>
                        <li><a href="#">Lost Books</a></li>
                        <br>
                        <li class="#"><a href="damage.php">Damage Books</a></li>
                        <br>
                        <li><a href="#">Subject for Replacement</a></li>
                    </ul> <!-- Button beside the title -->


                </div>

                <!-- Main Content Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 ">

                    <div class="w-full max-w-2xl mx-auto border border-black  rounded-t-lg">
                        <div class="bg-red-800 text-white rounded-t-lg">
                            <h2 class="text-lg font-semibold p-4">Please Enter Details Below</h2>
                        </div>
                        <div class="p-6 bg-white rounded-b-lg shadow-md">
                            <form class="space-y-4">

                            <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="category" class="text-right">CATEGORY:</label>
                                    <select id="category" class="col-span-2 border rounded px-3 py-2">
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="fiction">Fiction</option>
                                        <option value="non-fiction">Non-Fiction</option>
                                        <option value="science">Science</option>
                                        <option value="history">History</option>
                                    </select>
                                </div>

                                
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="call_number" class="text-right">CALL NUMBER:</label>
                                    <input id="call_number" placeholder="Call Number" class="col-span-2 border rounded px-3 py-2" />


                                    <label for="department" class="text-right">DEPARTMENT:</label>
                                    <input id="department" placeholder="Department" class="col-span-2 border rounded px-3 py-2" />


                                    <label for="book_title" class="text-right">BOOK_TITLE:</label>
                                    <input id="book_title" placeholder="Book Title" class="col-span-2 border rounded px-3 py-2" />
                                </div>
                               
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="author" class="text-right">AUTHOR:</label>
                                    <input id="author" placeholder="Author" class="col-span-2 border rounded px-3 py-2" />
                                </div>
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="book_copies" class="text-right">BOOK COPIES:</label>
                                    <input id="book_copies" type="number" class="col-span-2 border rounded px-3 py-2" />
                                </div>
                                <!-- <div class="grid grid-cols-3 items-center gap-4">
                                    
                                    <label for="book_publication" class="text-right">BOOK PUBLICATION:</label>
                                    <input id="book_publication" placeholder="book_pub" class="col-span-2 border rounded px-3 py-2" />
                                </div> -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="publisher_name" class="text-right">PUBLISHER NAME:</label>
                                    <input id="publisher_name" placeholder="Publisher Name" class="col-span-2 border rounded px-3 py-2" />
                                </div>
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="subject" class="text-right">SUBJECT:</label>
                                    <input id="subject" placeholder="SUBJECT" class="col-span-2 border rounded px-3 py-2" />
                                </div>
                                <!-- <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="date_encoded" class="text-right">DATE ENCODED:</label>
                                    <input id="date_encoded" placeholder="Date Encoded" class="col-span-2 border rounded px-3 py-2" />
                                </div> -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="status" class="text-right">STATUS:</label>
                                    <select id="status" class="col-span-2 border rounded px-3 py-2">
                                        <option value="" disabled selected>Select status</option>
                                        <option value="new">New</option>
                                        <option value="old">Old</option>
                                        <option value="damage">Damage</option>
                                    </select>
                                </div>
                                <div class="flex justify-end">
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

        </div>
        </div>

    </main>

    <script src="./src/components/header.js"></script>

</body>

</html>