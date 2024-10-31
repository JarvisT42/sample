<?php
// Start session
session_start();

// If book_bag session is not set, initialize it as an empty array
if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

// Get book bag data
$bookBag = $_SESSION['book_bag'];

// Count of items in the book bag
$bookBagCount = count($bookBag);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Bag Contents</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h1>Your Book Bag</h1>
    <p>Total books in your bag: <strong><?php echo $bookBagCount; ?></strong></p>

    <?php if ($bookBagCount > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Date</th>
                    <th>Table</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookBag as $index => $book): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['publicationDate']); ?></td>
                        <td><?php echo htmlspecialchars($book['table']); ?></td>
                        <td><?php echo htmlspecialchars($book['copies']); ?></td>

                        <td>
                            <!-- Display cover image if it's a valid URL or base64 encoded string -->
                            <img src="<?php echo htmlspecialchars($book['coverImage']); ?>" alt="Cover Image">
                        </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Your book bag is currently empty.</p>
    <?php endif; ?>

</body>
</html>



<?php foreach ($bookBag as $index => $book): ?>
              
                       <?php echo $index + 1; ?>
                       <?php echo htmlspecialchars($book['title']); ?>
                        <?php echo htmlspecialchars($book['author']); ?>
                        <?php echo htmlspecialchars($book['publicationDate']); ?>
                        <?php echo htmlspecialchars($book['table']); ?>
                        <?php echo htmlspecialchars($book['copies']); ?>

                        
                            <!-- Display cover image if it's a valid URL or base64 encoded string -->
                            <img src="<?php echo htmlspecialchars($book['coverImage']); ?>" alt="Cover Image">
                       


            
                <?php endforeach; ?>