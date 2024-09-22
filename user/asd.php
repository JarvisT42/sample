<?php
session_start();

if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

$bookBag = $_SESSION['book_bag'];

// Display the book bag with cover images
foreach ($bookBag as $book) {
    echo '<li>';
    echo '<img src="' . $book['coverImage'] . '" alt="Book Cover" class="w-28 h-40 border-2 border-gray-400 rounded-lg object-cover">';
    echo '<div>' . $book['title'] . ' by ' . $book['author'] . '</div>';
    echo '</li>';
}
?>
