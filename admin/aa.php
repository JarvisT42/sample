<?php
session_start();
include '../connection.php'; // Ensure you have your database connection
include '../connection2.php'; // Ensure you have your database connection


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>

    <style>
        .active-borrowed-books {
            background-color: #f0f0f0;
            color: #000;
        }

        .active-request {
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
                <div class="w-[400px] border-4 border-purple-700">
                    <div class="space-y-1 text-center p-4">
                        <h2 class="text-xl font-semibold">Gensantos Foundation College Inc.</h2>
                        <p class="text-sm text-muted-foreground">Bulaong Extension Brgy. Dadiangas West General Santos City</p>
                        <p class="text-lg font-semibold">LIBRARY OVERDUE SLIP</p>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="name">NAME:</label>
                                <input id="name" placeholder="_____________" class="w-full border border-gray-300 rounded p-2" />
                            </div>
                            <div class="space-y-2">
                                <label for="date">DATE:</label>
                                <input id="date" placeholder="_____________" class="w-full border border-gray-300 rounded p-2" />
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="student" />
                                <label for="student">STUDENT</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="faculty-full" />
                                <label for="faculty-full">FACULTY (FULLTIME)</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="faculty-part" />
                                <label for="faculty-part">FACULTY (PARTTIME)</label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="books">NO. OF BOOK/S BORROWED:</label>
                            <input id="books" placeholder="_____________" class="w-full border border-gray-300 rounded p-2" />
                        </div>
                        <div class="space-y-2">
                            <label for="days">DAY/S OVERDUE:</label>
                            <input id="days" placeholder="_____________" class="w-full border border-gray-300 rounded p-2" />
                        </div>
                        <div class="space-y-2">
                            <label for="amount">TOTAL AMOUNT TO BE PAID:</label>
                            <input id="amount" placeholder="_____________" class="w-full border border-gray-300 rounded p-2" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>


        <!-- Modal for "Return All" -->
        <!-- Modal for "Return All" -->
        <div id="returnAllModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-semibold mb-4">Return All Books</h2>

                <!-- Display No. of Books Borrowed -->
                <p id="booksBorrowedCount" class="mb-4 font-semibold"></p>

                <!-- Display Total Overdue Fines -->
                <p id="totalOverdueFines" class="mb-4 font-semibold"></p>

                <div class="flex justify-end space-x-2">
                    <button id="closeReturnAllModal" class="bg-red-500 text-white py-2 px-4 rounded">Close</button>
                    <button id="confirmReturnAll" class="bg-blue-500 text-white py-2 px-4 rounded">Confirm Return All</button>
                </div>
            </div>
        </div>



        <script>
            // Function to open the 'Return All' modal
            // Function to open the 'Return All' modal
            // Function to open the 'Return All' modal
            function openReturnAllModal() {
                // Get all the book titles and fines from the displayed list
                const bookTitles = document.querySelectorAll('li .text-2xl.font-bold + p'); // Select all title elements
                const fineSpans = document.querySelectorAll('[id^="fine-amount-"]'); // Select all spans with ID starting with "fine-amount-"
                const fineInputs = document.querySelectorAll('.finesInput'); // Select all fine inputs (e.g., for damage or lost books)
                const booksBorrowedCount = document.getElementById('booksBorrowedCount'); // Element to display the book count
                const totalOverdueFines = document.getElementById('totalOverdueFines'); // Element to display the total overdue fines

                // Calculate the number of books
                const numberOfBooks = bookTitles.length;
                booksBorrowedCount.innerText = `NO. OF BOOK/S BORROWED: ${numberOfBooks}`;

                // Calculate the total fines from both span elements and fine input fields
                let totalFines = 0;

                // Add fines from the span elements (fines already displayed)
                fineSpans.forEach(fineSpan => {
                    const fineAmount = parseFloat(fineSpan.innerText) || 0; // Parse the fine value or default to 0
                    totalFines += fineAmount;
                });

                // Add fines from the input fields (for damage/lost fines)
                fineInputs.forEach(fineInput => {
                    const fineAmount = parseFloat(fineInput.value) || 0; // Parse the fine value or default to 0
                    totalFines += fineAmount;
                });

                // Display the total overdue fines in the modal
                totalOverdueFines.innerText = `TOTAL ALL FINES: ₱ ${totalFines.toFixed(2)}`;

                // Show the modal
                document.getElementById('returnAllModal').classList.remove('hidden');
            }

            // Close the modal when the "Close" button is clicked
            document.getElementById('closeReturnAllModal').onclick = function() {
                document.getElementById('returnAllModal').classList.add('hidden');
            };

            // Confirm return logic for 'Return All'
            document.getElementById('confirmReturnAll').onclick = function() {
                // Get the walk_in_id (assuming it's available in the page somewhere)
                const walkInId = <?php echo json_encode($walk_in_id); ?>;

                // Gather all book data: book IDs, categories, and fines
                const books = [];
                const fineSpans = document.querySelectorAll('[id^="fine-amount-"]'); // Select all fine amount spans
                const fineInputs = document.querySelectorAll('.finesInput'); // Select all fine inputs (for damage or lost)

                fineSpans.forEach((fineSpan, index) => {
                    const bookId = fineSpan.closest('li').querySelector('.renew-button').getAttribute('data-book-id'); // Get book_id
                    const category = fineSpan.closest('li').querySelector('.renew-button').getAttribute('data-category'); // Get category
                    const fineAmount = parseFloat(fineSpan.innerText) || 0; // Get fine amount from span

                    // Check if there's an additional fine from input (damage or lost)
                    const inputFine = fineInputs[index] ? parseFloat(fineInputs[index].value) || 0 : 0;
                    const totalFines = fineAmount + inputFine; // Sum both fine values

                    // Add this book's data to the books array
                    books.push({
                        book_id: bookId,
                        category: category,
                        total_fines: totalFines
                    });
                });

                // Create the data object to send
                const data = {
                    walk_in_id: walkInId, // Use walk_in_id instead of student_id
                    books: books
                };

                // Send the data to the backend using fetch
                fetch('borrowed_books_2walkIn_returnall.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('All books returned successfully!');
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Error: ' + result.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred while returning the books.');
                    });

                // Close the modal after sending the request
                document.getElementById('returnAllModal').classList.add('hidden');
            };
        </script>



        <script>
            function toggleFinesInput(index) {
                const statusSelect = document.getElementById(`statusSelect-${index}`);
                const fineInput = document.getElementById(`fineInput-${index}`);
                const returnButton = document.querySelector(`.return-button[data-index="${index}"]`); // Get the related return button

                // Enable fine input for "Damage" or "Lost"
                if (statusSelect.value === "Damage" || statusSelect.value === "Lost") {
                    fineInput.disabled = false; // Enable the fine input
                    fineInput.placeholder = ""; // Clear the placeholder
                    console.log(`Enabling fine input for index: ${index}`);
                } else {
                    fineInput.disabled = true; // Disable the fine input
                    fineInput.value = ""; // Clear the input value
                    fineInput.placeholder = "Disabled"; // Reset the placeholder
                    console.log(`Disabling fine input for index: ${index}`);
                }

                // Change the button label to 'Next' if 'Lost' is selected
                if (statusSelect.value === "Lost") {
                    returnButton.innerText = "Next";
                } else {
                    returnButton.innerText = "Return"; // Reset to 'Return' for other statuses
                }
            }
        </script>










        <!-- Modal Structure -->
        <div id="returnModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-semibold mb-4">Return Book</h2>
                <p id="modalBookTitle" class="mb-2"></p>
                <p id="modalBookAuthor" class="mb-2"></p>
                <p id="modalBookCategory" class="mb-2"></p>

                <!-- Original fines display (unchanged) -->
                <p id="OverDueFines" class="mb-4"></p>

                <!-- Updated fines display -->
                <p id="BookFines" class="mb-4"></p>

                <!-- Display for walk-in ID and book ID -->
                <p id="modalWalkinId" class="mb-2"></p>
                <p id="modalBookId" class="mb-2"></p>

                <div class="flex justify-end space-x-2">
                    <button id="closeModal" class="bg-red-500 text-white py-2 px-4 rounded">Close</button>
                    <button id="confirmReturn" class="bg-blue-500 text-white py-2 px-4 rounded">Confirm Return</button>
                </div>
            </div>
        </div>



    </main>












    <script>
        function openReturnModal(title, author, category, fines, fineInputId, walkinId, bookId) {
            // Set the book details in the modal
            document.getElementById('modalBookTitle').innerText = 'Title: ' + title;
            document.getElementById('modalBookAuthor').innerText = 'Author: ' + author;
            document.getElementById('modalBookCategory').innerText = 'Category: ' + category;

            // Display the original fines value (read-only)
            document.getElementById('OverDueFines').innerText = 'Over Due Fines: ₱ ' + fines;

            // Get the value from the fine input field and display it in the modal
            let updatedFines = document.getElementById(fineInputId).value; // Get value from the specific fines input field
            document.getElementById('BookFines').innerText = 'Book Fines: ₱ ' + (updatedFines || '0'); // Display updated fines or 0 if none

            // Display the walkin ID and book ID in the modal
            document.getElementById('modalWalkinId').innerText = 'Walkin ID: ' + walkinId; // Correct ID usage
            document.getElementById('modalBookId').innerText = 'Book ID: ' + bookId;

            // Check if the button clicked was "Next" (which means the book is marked as "Lost")
            const statusSelect = document.getElementById(`statusSelect-${fineInputId.split('-')[1]}`).value; // Get the status of the book

            // Update the label of the "Confirm Return" button to "Pay" if the status is "Lost"
            const confirmButton = document.getElementById('confirmReturn');
            if (statusSelect === "Lost") {
                confirmButton.innerText = 'Pay'; // Change the label to 'Pay'
            } else {
                confirmButton.innerText = 'Confirm Return'; // Reset to default
            }

            // Display the modal
            document.getElementById('returnModal').classList.remove('hidden');
        }


        // Close modal when the close button is clicked
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('returnModal').classList.add('hidden');
        }

        // Confirm return logic
        // Confirm return logic
        document.getElementById('confirmReturn').onclick = function() {
            // Get the values from the modal
            const overdueFines = document.getElementById('OverDueFines').innerText.replace('Over Due Fines: ₱ ', ''); // Extract overdue 
            const bookFines = document.getElementById('BookFines').innerText.replace('Book Fines: ₱ ', ''); // Correct extraction of book 
            const walkinId = document.getElementById('modalWalkinId').innerText.replace('Walkin ID: ', ''); // Use correct ID
            const bookId = document.getElementById('modalBookId').innerText.replace('Book ID: ', '');
            const category = document.getElementById('modalBookCategory').innerText.replace('Category: ', ''); // Extract category text

            // Create the data object to send
            const data = {
                fines: parseFloat(overdueFines) || 0, // Ensure it's a number, default to 0 if not available
                book_fines: parseFloat(bookFines) || 0, // Ensure it's a number, default to 0 if not available
                walkin_id: walkinId,
                book_id: bookId,
                category: category
            };

            // Check if the button label is "Pay" or "Confirm Return"
            const confirmButton = document.getElementById('confirmReturn');
            if (confirmButton.innerText === 'Pay') {
                // If "Pay" is clicked, send the data to `borrowed_books_2online_pay.php`
                fetch('borrowed_books_2walkIn_pay.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data) // Send the data in JSON format
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('Payment processed successfully!');
                            location.reload(); // Reload the page after successful payment
                        } else {
                            alert('Error: ' + result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing the payment.');
                    });
            } else {
                // If "Confirm Return" is clicked, use the existing return logic
                fetch('borrowed_books_2walkIn_save.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data) // Send the data in JSON format
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('Book returned successfully!');
                            location.reload(); // Reload the page
                        } else {
                            alert('Error: ' + result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while returning the book.');
                    });
            }

            // Close the modal after the action
            document.getElementById('returnModal').classList.add('hidden');
        };
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('book-request-form');

            form.addEventListener('change', function(event) {
                // Handle renewal dropdown changes
                if (event.target.classList.contains('renew-dropdown')) {
                    const renewalDropdown = event.target;
                    const renewalDays = parseInt(renewalDropdown.value, 10);
                    const dueDateStr = renewalDropdown.getAttribute('data-due-date');
                    const finesValue = <?php echo $fines_value; ?>; // Get the fines value from PHP

                    // Parse the due date
                    const currentDueDate = new Date(dueDateStr + 'T00:00:00');

                    // Calculate the new due date
                    const newDueDate = new Date(currentDueDate);
                    newDueDate.setDate(currentDueDate.getDate() + renewalDays);

                    const options = {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit'
                    };
                    const formattedDueDate = newDueDate.toLocaleDateString('en-CA', options);

                    // Get the index and update the due date display
                    const index = renewalDropdown.getAttribute('data-index');
                    const dueDateElement = form.querySelector(`.due-date[data-index="${index}"]`);

                    if (dueDateElement) {
                        dueDateElement.innerText = formattedDueDate;
                    }

                    // Calculate the fine amount based on the new due date
                    const currentDate = new Date();
                    let fineAmount = 0;

                    if (currentDate > newDueDate) {
                        // Calculate overdue days
                        const overdueDays = Math.floor((currentDate - newDueDate) / (1000 * 60 * 60 * 24));
                        fineAmount = overdueDays * finesValue;
                    }

                    // Update the fine amount display
                    const fineAmountElement = document.getElementById(`fine-amount-${index}`);
                    if (fineAmountElement) {
                        fineAmountElement.innerText = Math.floor(fineAmount); // Use Math.floor to remove decimal places
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const renewButtons = document.querySelectorAll('.renew-button');

            renewButtons.forEach(button => {
                button.addEventListener('click', function() {

                    const walkInId = this.getAttribute('data-walk-in-id');
                    const bookId = this.getAttribute('data-book-id'); // replaced title and author with book_id
                    const category = this.getAttribute('data-category');
                    const newDueDate = this.parentElement.parentElement.querySelector('.due-date').innerText;

                    // Create the data to send
                    const data = {
                        walk_in_id: walkInId,
                        book_id: bookId, // updated to book_id
                        category: category,
                        due_date: newDueDate
                    };

                    // Make an AJAX request to borrowed_books_2_save.php
                    fetch('borrowed_books_2_save.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Renewed successfully!');

                                location.reload(); // Reload the page

                            } else {
                                alert('Error renewing book: ' + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>

    <script src="./src/components/header.js"></script>
    <script>
        // Function to automatically show the dropdown if on book_request.php
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownRequest = document.getElementById('dropdown-request');

            // Open the dropdown menu for 'Request'
            dropdownRequest.classList.remove('hidden');
            dropdownRequest.classList.add('block'); // Make the dropdown visible

        });
    </script>
</body>

</html>