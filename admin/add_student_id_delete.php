<?php
// Include the database connection
include '../connection.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the ID is set in the incoming request
if (isset($data['id'])) {
    $userId = $data['id'];

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM students_id WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // If the deletion was successful, return success response
        echo json_encode(['success' => true]);
    } else {
        // If there was an error, return failure response
        echo json_encode(['success' => false, 'error' => 'Database deletion failed']);
    }

    $stmt->close();
    $conn->close();
} else {
    // If no ID was provided, return an error
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>