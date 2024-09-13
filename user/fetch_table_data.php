<?php
require '../connection2.php'; // Update with your actual path

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'] ?? '';

if ($table === 'All fields') {
    // Fetch all table names
    $sql = "SHOW TABLES FROM gfi_library_database_books_records";
    $result = $conn->query($sql);

    $allData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $tableName = $row[0];
            $tableName = $conn->real_escape_string($tableName);
            $sql = "SELECT title, author, Date_Of_Publication_Copyright, record_cover FROM `$tableName`"; // Include 'record_cover'
            $tableResult = $conn->query($sql);

            if ($tableResult->num_rows > 0) {
                while ($tableRow = $tableResult->fetch_assoc()) {
                    $coverImage = $tableRow['record_cover'];
                    $coverImageBase64 = base64_encode($coverImage); // Convert image to Base64

                    $allData[] = [
                        'title' => $tableRow['title'],
                        'author' => $tableRow['author'],
                        'publicationDate' => $tableRow['Date_Of_Publication_Copyright'],
                        'table' => $tableName,
                        'coverImage' => 'data:image/jpeg;base64,' . $coverImageBase64 // Prefix with MIME type
                    ];
                }
            }
        }
    }

    echo json_encode($allData);
} else {
    // Fetch data for specific table
    $table = $conn->real_escape_string($table);
    $sql = "SELECT title, author, Date_Of_Publication_Copyright, record_cover FROM `$table`"; // Include 'record_cover'

    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coverImage = $row['record_cover'];
            $coverImageBase64 = base64_encode($coverImage); // Convert image to Base64

            $data[] = [
                'title' => $row['title'],
                'author' => $row['author'],
                'publicationDate' => $row['Date_Of_Publication_Copyright'],
                'table' => $table,
                'coverImage' => 'data:image/jpeg;base64,' . $coverImageBase64 // Prefix with MIME type
            ];
        }
    }

    echo json_encode($data);
}
?>
