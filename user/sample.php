<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Bag</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-4">Books in Your Bag</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="border-b-2 border-gray-300 px-4 py-2">ID</th>
                    <th class="border-b-2 border-gray-300 px-4 py-2">Title</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['book_bag']) && !empty($_SESSION['book_bag'])): ?>
                    <?php foreach ($_SESSION['book_bag'] as $book): ?>
                        <tr>
                            <td class="border-b border-gray-300 px-4 py-2"><?php echo htmlspecialchars($book['id']); ?></td>
                            <td class="border-b border-gray-300 px-4 py-2"><?php echo htmlspecialchars($book['title']); ?></td>

                            <td class="border-b border-gray-300 px-4 py-2"><?php echo htmlspecialchars($book['title']); ?></td>
  <div class="flex-shrink-0">
                                        <img src="<?php echo htmlspecialchars($book['coverImage']); ?>" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                    </div>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="border-b border-gray-300 px-4 py-2 text-center">No books in your bag.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
