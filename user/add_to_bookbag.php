<?php
session_start();

// Initialize book bag session if not already initialized
if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

// Check if we received book data via POST request
if (isset($_POST['title'], $_POST['author'], $_POST['publicationDate'], $_POST['copies'], $_POST['coverImage'])) {
    $book = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publicationDate' => $_POST['publicationDate'],
        'copies' => $_POST['copies'],
        'coverImage' => $_POST['coverImage']
    ];

    // Add the selected book to the session array
    $_SESSION['book_bag'][] = $book;

    echo json_encode(['status' => 'success', 'message' => 'Book added to book bag']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid book data']);
}
