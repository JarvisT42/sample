<?php
session_start(); // Start the session

if (!isset($_SESSION['Faculty_Id'])) {
    die("Student ID not set in session.");
}

$facultyId = $_SESSION['Faculty_Id']; // Assuming student_id is stored in session

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

$sqlborrowedBooksQuery = "SELECT faculty_id, book_id, Category FROM borrow WHERE faculty_id = ? AND status = 'pending'";
$stmtcheck = $connOg->prepare($sqlborrowedBooksQuery);
$stmtcheck->bind_param("i", $facultyId);
$stmtcheck->execute();
$result = $stmtcheck->get_result();

$borrowedBooks = [];

// Create a connection to the second database
$conn2 = mysqli_connect("localhost", "root", "", "gfi_library_database_books_records");
if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all borrowed books
while ($row = $result->fetch_assoc()) {
    $table = $row['Category']; // Assuming 'Category' is the table name
    $bookId = $row['book_id']; // Use the correct column for book ID

    // Prepare the query to get book details
    $borrowedBooksQuery = "SELECT Title, Author FROM `$table` WHERE id = ?";
    $stmt2 = $conn2->prepare($borrowedBooksQuery);
    if ($stmt2) {
        $stmt2->bind_param("i", $bookId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        // Fetch book details
        while ($bookRow = $result2->fetch_assoc()) {
            $borrowedBooks[] = $bookRow['Title'] . '|' . $bookRow['Author'] . '|' . $table; // Added category for checking
        }

        // Close the statement
        $stmt2->close();
    } else {
        // Handle error with preparing statement
        echo "Error preparing statement: " . $conn2->error;
    }
}

// Now $borrowedBooks contains the titles, authors, and categories of the borrowed books

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
            $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies, status, Available_To_Borrow  FROM `$tableName`";

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
                        'status' => $tableRow['status'],
                        'availableToBorrow' => $tableRow['Available_To_Borrow']

                    ];
                }
            }
        }
    }

    echo json_encode(['data' => $allData, 'bookBagCount' => $bookBagCount]);
} else {
    $table = $conn2->real_escape_string($table);
    $sql = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies, status, Available_To_Borrow FROM `$table`";

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
                'status' => $row['status'],
                'availableToBorrow' => $row['Available_To_Borrow']

            ];
        }
    }

    echo json_encode(['data' => $data, 'bookBagCount' => $bookBagCount]);
}
?>
