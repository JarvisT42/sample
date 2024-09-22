<?php
session_start(); // Start the session

if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

$bookBag = $_SESSION['book_bag'];
$bookBagTitles = array_map(function($book) {
    return $book['title'] . '|' . $book['author'] . '|' . $book['publicationDate'] . '|' . $book['table'];
}, $bookBag);

// Count of items in the book bag
$bookBagCount = count($bookBag);

require '../connection2.php'; // Update with your actual path


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'] ?? '';

if ($table === 'All fields') {
    $sql = "SHOW TABLES FROM gfi_library_database_books_records";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error fetching tables: " . $conn->error);
    }

    $allData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $tableName = $row[0];
            $tableName = $conn->real_escape_string($tableName);
            $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies FROM `$tableName`";

            $tableResult = $conn->query($sql);

            if (!$tableResult) {
                die("Error fetching data from table $tableName: " . $conn->error);
            }

            if ($tableResult->num_rows > 0) {
                while ($tableRow = $tableResult->fetch_assoc()) {
                    $coverImage = $tableRow['record_cover'];
                    $coverImageBase64 = base64_encode($coverImage);
                    $coverImageDataUrl = 'data:image/jpeg;base64,' . $coverImageBase64;

                    $isInBag = in_array($tableRow['title'] . '|' . $tableRow['author'] . '|' . $tableRow['Date_Of_Publication_Copyright'] . '|' . $tableName, $bookBagTitles);

                    $allData[] = [
                        'id' => $tableRow['id'], // Include the ID
                        'title' => $tableRow['title'],
                        'author' => $tableRow['author'],
                        'publicationDate' => $tableRow['Date_Of_Publication_Copyright'],
                        'table' => $tableName,
                        'coverImage' => $coverImageDataUrl,
                        'copies' => $tableRow['No_Of_Copies'],
                        'inBag' => $isInBag
                    ];
                }
            }
        }
    }

    echo json_encode(['data' => $allData, 'bookBagCount' => $bookBagCount]);
} else {
    $table = $conn->real_escape_string($table);
    $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies FROM `$table`";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error fetching data from table $table: " . $conn->error);
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coverImage = $row['record_cover'];
            $coverImageBase64 = base64_encode($coverImage);
            $coverImageDataUrl = 'data:image/jpeg;base64,' . $coverImageBase64;

            $isInBag = in_array($row['title'] . '|' . $row['author'] . '|' . $row['Date_Of_Publication_Copyright'] . '|' . $table, $bookBagTitles);

            $data[] = [
                'id' => $row['id'], // Include the ID
                'title' => $row['title'],
                'author' => $row['author'],
                'publicationDate' => $row['Date_Of_Publication_Copyright'],
                'table' => $table,
                'coverImage' => $coverImageDataUrl,
                'copies' => $row['No_Of_Copies'],
                'inBag' => $isInBag
            ];
        }
    }

    echo json_encode(['data' => $data, 'bookBagCount' => $bookBagCount]);
}
?>
