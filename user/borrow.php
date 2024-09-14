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

</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                <!-- Title Box -->
                <!-- Title and Button Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <h1 class="text-3xl font-semibold">Borrow</h1> <!-- Adjusted text size -->
                    <!-- Button beside the title -->
                </div>

                <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                    The Borrow Page is your gateway to accessing and managing book loans efficiently. On this page, you can search for and borrow books from our collection with ease. Simply browse or search for the titles you wish to borrow, select your preferred books, and follow the streamlined borrowing process. The page also provides a clear overview of the available books and their details.
                </div>

                <!-- Main Content Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                        <div class="flex items-center space-x-4">
                            <!-- Dropdown Button -->

                            <?php
                            // Database connection
                            require '../connection2.php';

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Query to fetch all table names
                            $sql = "SHOW TABLES FROM gfi_library_database_books_records";
                            $result = $conn->query($sql);
                            ?>

                            <div class="relative inline-block text-left">
                                <!-- Dropdown button -->
                                <button id="dropdownActionButton" type="button" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    <span id="selectedField">All fields</span>
                                    <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownAction" class="z-10 hidden absolute mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                        <!-- Default "All fields" option -->
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-table="All fields">All fields</a></li>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_array()) {
                                                echo '<li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-table="' . htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8') . '</a></li>';
                                            }
                                        } else {
                                            echo '<li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">No tables found</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Checkbox -->
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="checkboxOption" name="checkboxGroup" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-lg focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 transition-transform transform hover:scale-105 checked:bg-blue-600 checked:border-transparent">
                                <label for="checkboxOption" class="text-sm text-gray-900 dark:text-gray-300">Available</label>
                            </div>
                        </div>
                        <!-- Search Input and Button -->
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div> <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">

                            <button type="button" class="relative ml-2 inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 whitespace-nowrap">
                                Book Bag
                                <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-500 rounded-full">
                                    0
                                </span>
                            </button>


                        </div>

                    </div>
                  <!-- Display Table Data -->
                    <div class="overflow-x-auto">
                        <div class="scrollable-table-container border border-gray-200 dark:border-gray-700">
                            <div class="container mx-auto px-4 py-6">
                                <ul id="tableData" class="flex flex-col space-y-4">
                                    <!-- Table data will be inserted here -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <script>
               document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('dropdownActionButton');
    const menu = document.getElementById('dropdownAction');
    const dropdownItems = document.querySelectorAll('#dropdownAction a');
    const selectedField = document.getElementById('selectedField');
    const tableDataContainer = document.getElementById('tableData');
    const bookBagButton = document.querySelector('button.relative.ml-2'); // The "Book Bag" button
    let bookBagCount = 0; // Counter for the number of items in the book bag
    const BOOK_BAG_LIMIT = 3; // Limit for the number of books

    // Load default data (All fields) on page load
    function loadTableData(tableName) {
        fetch(`fetch_table_data.php?table=${encodeURIComponent(tableName)}`)
            .then(response => response.json())
            .then(data => {
                tableDataContainer.innerHTML = data.map((record, index) => `
                    <li class="bg-gray-200 p-4 flex items-center border-b-2 border-black">
                        <div class="flex flex-row items-start w-full space-x-6 overflow-x-auto">
                            <!-- Automatic Number -->
                            <div class="flex-none w-12">
                                <div class="text-lg font-semibold text-gray-800">${index + 1}</div>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-1 border-l-2 border-black p-4">
                                <h2 class="text-lg font-semibold mb-2">
                                    ${record.title}
                                </h2>
                                <span class="block text-base mb-2">
                                    by ${record.author}
                                </span>
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="text-sm text-gray-600">Published</div>
                                    <div class="text-sm text-gray-600">${record.publicationDate}</div>
                                    <div class="text-sm text-gray-600">copies ${record.copies}</div>
                                </div>

                                <div class="bg-blue-200 p-2 rounded-lg shadow-md text-left mt-auto inline-block border border-blue-300">
                                    ${record.table}
                                </div>
                            </div>

                            <!-- Add to Book Bag Link or Not Available -->
                            <div class="flex-shrink-0">
                                ${record.copies <= 1
                                    ? `<span class="text-red-600">Not Available</span>`
                                    : `<a href="#" class="text-green-600 hover:underline book-bag-toggle" data-in-bag="false"><span class="fa fa-plus"></span> Add to Book Bag</a>`}
                            </div>

                            <!-- Image -->
                            <div class="flex-shrink-0">
                                <a href="#" class="block">
                                    <img src="${record.coverImage}" alt="Book Cover" class="w-28 h-40 border-2 border-gray-400 rounded-lg object-cover">
                                </a>
                            </div>
                        </div>
                    </li>
                `).join('');
            });
    }

    // Initialize with "All fields" data
    loadTableData('All fields');

    button.addEventListener('click', function() {
        menu.classList.toggle('hidden');
    });

    dropdownItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const tableName = this.getAttribute('data-table');
            selectedField.textContent = tableName;
            menu.classList.add('hidden'); // Hide dropdown after selection

            // Fetch and display table data
            loadTableData(tableName);
        });
    });

    // Toggle book bag status and update count
    tableDataContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('book-bag-toggle')) {
            event.preventDefault();
            const link = event.target;
            const inBag = link.getAttribute('data-in-bag') === 'true';

            if (!inBag) {
                if (bookBagCount >= BOOK_BAG_LIMIT) {
                    alert(`You can only add up to ${BOOK_BAG_LIMIT} books to the book bag.`);
                    return; // Do not proceed if the limit is exceeded
                }
                link.textContent = 'Remove from Book Bag';
                link.classList.remove('text-green-600');
                link.classList.add('text-red-600');
                link.setAttribute('data-in-bag', 'true');
                bookBagCount++;
            } else {
                link.textContent = 'Add to Book Bag';
                link.classList.remove('text-red-600');
                link.classList.add('text-green-600');
                link.setAttribute('data-in-bag', 'false');
                bookBagCount--;
            }

            // Update the Book Bag button count
            bookBagButton.querySelector('span').textContent = bookBagCount;

            // Optionally, you can add code here to handle updating the book bag state on the server
        }
    });

    // Hide dropdown if clicking outside
    document.addEventListener('click', function(event) {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
});


                    </script>

                </div>

            </div>

        </div>
        </div>

    </main>

    <script src="./src/components/header.js"></script>

</body>

</html>