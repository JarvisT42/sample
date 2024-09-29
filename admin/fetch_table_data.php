<?php
require '../connection2.php'; // Update with your actual path

if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

$connOg = mysqli_connect("localhost", "root", "", "GFI_Library_Database");

if (!$connOg) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check for borrowed books
$borrowedBooksQuery = "SELECT Title, Author, Category FROM borrow WHERE status = 'pending'";
$stmt = $connOg->prepare($borrowedBooksQuery);
$stmt->execute();
$result = $stmt->get_result();

$borrowedBooks = [];
while ($row = $result->fetch_assoc()) {
    $borrowedBooks[] = $row['Title'] . '|' . $row['Author'] . '|' . $row['Category'];
}
$stmt->close();

$table = $_GET['table'] ?? '';

if ($table === 'All fields') {
    $sql = "SHOW TABLES FROM gfi_library_database_books_records";
    $result = $conn2->query($sql);

    if (!$result) {
        die("Error fetching tables: " . $conn2->error);
    }

    $allData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $tableName = $row[0];
            $tableName = $conn2->real_escape_string($tableName);
            $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies, status FROM `$tableName`";

            $tableResult = $conn2->query($sql);

            if (!$tableResult) {
                die("Error fetching data from table $tableName: " . $conn2->error);
            }

            if ($tableResult->num_rows > 0) {
                while ($tableRow = $tableResult->fetch_assoc()) {
                    $coverImage = $tableRow['record_cover'];
                    $coverImageBase64 = base64_encode($coverImage);
                    $coverImageDataUrl = 'data:image/jpeg;base64,' . $coverImageBase64;

                    $isCurrentlyBorrowed = in_array($tableRow['title'] . '|' . $tableRow['author'] . '|' . $tableName, $borrowedBooks);

                    $allData[] = [
                        'id' => $tableRow['id'],
                        'title' => $tableRow['title'],
                        'author' => $tableRow['author'],
                        'publicationDate' => $tableRow['Date_Of_Publication_Copyright'],
                        'table' => $tableName,
                        'coverImage' => $coverImageDataUrl,
                        'copies' => $tableRow['No_Of_Copies'],
                        'currentlyBorrowed' => $isCurrentlyBorrowed,
                        'status' => $tableRow['status']

                    ];
                }
            }
        }
    }

    echo json_encode(['data' => $allData]);
} else {
    $table = $conn2->real_escape_string($table);
    $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies, status FROM `$table`";

    $result = $conn2->query($sql);

    if (!$result) {
        die("Error fetching data from table $table: " . $conn2->error);
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coverImage = $row['record_cover'];
            $coverImageBase64 = base64_encode($coverImage);
            $coverImageDataUrl = 'data:image/jpeg;base64,' . $coverImageBase64;

            $isCurrentlyBorrowed = in_array($row['title'] . '|' . $row['author'] . '|' . $table, $borrowedBooks);

            $data[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'publicationDate' => $row['Date_Of_Publication_Copyright'],
                'table' => $table,
                'coverImage' => $coverImageDataUrl,
                'copies' => $row['No_Of_Copies'],
                'currentlyBorrowed' => $isCurrentlyBorrowed,
                'status' => $row['status']

            ];
        }
    }

    echo json_encode(['data' => $data]);
}
?>
