<?php
include '../connection.php'; // Include your database connection

// Retrieve the posted JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data was received correctly
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit();
}

// Prepare and bind the update query
$updateQuery = "UPDATE borrow SET status = 'returned', Over_Due_Fines = ?, Book_Fines = ? WHERE walk_in_id = ? AND book_id = ? AND category = ?";

$stmt = $conn->prepare($updateQuery);

// Check if the statement preparation was successful
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Statement preparation failed: ' . $conn->error]);
    exit();
}

// Bind parameters (adjust data types accordingly)
$fines = $data['fines'];
$bookFines = $data['book_fines']; // Ensure you include this in the fetch data from JS
$walkinId = $data['walkin_id']; // Change to walkin_id
$bookId = $data['book_id'];
$category = $data['category'];

// Change the bind_param types if necessary
$stmt->bind_param('ddsss', $fines, $bookFines, $walkinId, $bookId, $category); // 'ddsss' for two doubles and three strings

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed: ' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
