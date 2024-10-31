<?php
// book_bag.php

// Start session if not already started
session_start();

// Check if there are any books in the book bag
$bookTitles = [];
foreach ($_SESSION['book_bag'] ?? [] as $bookTitle) {
    $bookTitles[] = htmlspecialchars($bookTitle, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Book Bag</h1>
        <ul class="list-disc pl-5">
            <?php if (!empty($bookTitles)) : ?>
                <?php foreach ($bookTitles as $title) : ?>
                    <li class="text-lg"><?= $title ?></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="text-lg">Your book bag is empty.</li>
            <?php endif; ?>
        </ul>
        <a href="index.php" class="mt-4 inline-block text-blue-600 hover:underline">Back to Books</a>
    </div>
</body>
</html>
