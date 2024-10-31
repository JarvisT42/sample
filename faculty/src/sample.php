<?php
session_start();

// Check if the book_bag session is set and contains books
if (isset($_SESSION['book_bag']) && count($_SESSION['book_bag']) > 0) {
    // Return the book bag data as a JSON response
    echo json_encode(['status' => 'success', 'books' => $_SESSION['book_bag']]);
    exit;
} else {
    // If no books are found, return an empty book bag
    echo json_encode(['status' => 'empty', 'message' => 'No books in the book bag']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Bag</title>
    <style>
        .book-item {
            margin-bottom: 20px;
        }
        .book-item img {
            width: 100px;
        }
    </style>
</head>
<body>

    <h1>Your Books Bag</h1>

    <div id="bookBag">
        <!-- Book items will be dynamically inserted here -->
    </div>

    <script>
        // Function to fetch the book bag from the session and display it
        function fetchBookBag() {
            fetch(window.location.href) // Fetch the same file
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Display books in the book bag
                        displayBookBag(data.books);
                    } else if (data.status === 'empty') {
                        // Handle the case where the book bag is empty
                        document.getElementById('bookBag').innerHTML = "<p>No books in the book bag</p>";
                    }
                })
                .catch(error => console.error('Error fetching book bag:', error));
        }

        // Function to display the book bag
        function displayBookBag(books) {
            const bookBagContainer = document.getElementById('bookBag');
            bookBagContainer.innerHTML = ''; // Clear any previous content

            books.forEach(book => {
                const bookItem = `
                    <div class="book-item">
                        <img src="${book.coverImage}" alt="Cover image of ${book.title}" />
                        <h3>${book.title}</h3>
                        <p>Author: ${book.author}</p>
                        <p>Published: ${book.publicationDate}</p>
                        <p>Copies: ${book.copies}</p>
                        <hr>
                    </div>
                `;
                bookBagContainer.innerHTML += bookItem;
            });
        }

        // Fetch and display the book bag on page load
        document.addEventListener('DOMContentLoaded', fetchBookBag);
    </script>

</body>
</html>
