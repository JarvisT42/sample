<?php
session_start(); // Start the session

if (!isset($_SESSION['Id'])) {
    die("Student ID not set in session.");
}

$studentId = $_SESSION['Id']; // Assuming student_id is stored in session

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

if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

$connOg = mysqli_connect("localhost", "root", "", "GFI_Library_Database");

if (!$connOg) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check for borrowed books


$borrowedBooksQuery = "SELECT Title, Author, Category FROM borrow WHERE student_id = ? AND status = 'pending'";
$stmt = $connOg->prepare($borrowedBooksQuery);
$stmt->bind_param("i", $studentId);
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

                    $isInBag = in_array($tableRow['title'] . '|' . $tableRow['author'] . '|' . $tableRow['Date_Of_Publication_Copyright'] . '|' . $tableName, $bookBagTitles);
                    $isCurrentlyBorrowed = in_array($tableRow['title'] . '|' . $tableRow['author'] . '|' . $tableName, $borrowedBooks);

                    $allData[] = [
                        'id' => $tableRow['id'],
                        'title' => $tableRow['title'],
                        'author' => $tableRow['author'],
                        'publicationDate' => $tableRow['Date_Of_Publication_Copyright'],
                        'table' => $tableName,
                        'coverImage' => $coverImageDataUrl,
                        'copies' => $tableRow['No_Of_Copies'],
                        'inBag' => $isInBag,
                        'currentlyBorrowed' => $isCurrentlyBorrowed,
                        'status' => $tableRow['status'] // Add this line to include status

                    ];
                }
            }
        }
    }

    echo json_encode(['data' => $allData, 'bookBagCount' => $bookBagCount]);
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

            $isInBag = in_array($row['title'] . '|' . $row['author'] . '|' . $row['Date_Of_Publication_Copyright'] . '|' . $table, $bookBagTitles);
            $isCurrentlyBorrowed = in_array($row['title'] . '|' . $row['author'] . '|' . $table, $borrowedBooks);

            $data[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'publicationDate' => $row['Date_Of_Publication_Copyright'],
                'table' => $table,
                'coverImage' => $coverImageDataUrl,
                'copies' => $row['No_Of_Copies'],
                'inBag' => $isInBag,
                'currentlyBorrowed' => $isCurrentlyBorrowed,
                'status' => $row['status'], // Add this line to include status
            ];
            
        }
    }

    echo json_encode(['data' => $data, 'bookBagCount' => $bookBagCount]);
}
?>
