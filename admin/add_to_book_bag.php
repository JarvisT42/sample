<?php
session_start();
include '../connection.php'; // Include your database connection script

$data = json_decode(file_get_contents('php://input'), true);




// Calculate the total number of books in the book bag
$totalBooksCount = (isset($_SESSION['book_bag']) ? count($_SESSION['book_bag']) : 0);

// Check if the total exceeds the limit of 3 books
if ($totalBooksCount >= 3) {
    echo json_encode(['status' => 'error', 'message' => 'You can only borrow 3 books total.']);
    exit;
}

// Check if the 'book_bag' session exists
if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

// Include the 'id' in the book array
$book = [
    'id' => $data['id'], // Include the 'id' field
    'title' => $data['title'],
    'author' => $data['author'],
    'publicationDate' => $data['publicationDate'],
    'table' => $data['table'],
    'coverImage' => $data['coverImage'],
    'copies' => $data['copies']
];

// Check if the book already exists in the session to prevent duplicates based on title and author
$bookExists = false;
foreach ($_SESSION['book_bag'] as $existingBook) {
    if ($existingBook['title'] === $book['title'] && $existingBook['author'] === $book['author']) {
        $bookExists = true;
        break;
    }
}

if (!$bookExists) {
    $_SESSION['book_bag'][] = $book;
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'This book is already in your bag']);
}
?>