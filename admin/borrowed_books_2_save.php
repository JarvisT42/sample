<?php
include '../connection.php'; // Include your database connection

// Retrieve the posted JSON data
$data = json_decode(file_get_contents('php://input'), true);
// Check if student_id or walkIn_id is set and prepare the update query
if (isset($data['student_id']) && !empty($data['student_id'])) {
    // Prepare and bind the update query for student_id and book_id
    $updateQuery = "UPDATE borrow SET Due_Date = ? WHERE student_id = ? AND book_id = ? AND category = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssss', $data['due_date'], $data['student_id'], $data['book_id'], $data['category']);
}
elseif (isset($data['walk_in_id']) && !empty($data['walk_in_id'])) {  // Use 'walk_in_id' here
    // Prepare and bind the update query for walk_in_id and book_id
    $updateQuery = "UPDATE borrow SET Due_Date = ? WHERE walk_in_id = ? AND book_id = ? AND category = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssss', $data['due_date'], $data['walk_in_id'], $data['book_id'], $data['category']);
}
 else {
    // If neither ID is provided, return an error response
    echo json_encode(['success' => false, 'message' => 'No valid ID provided.']);
    exit; // Exit the script
}

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed.']);
}

// Close statement and connection
$stmt->close();
$conn->close();
