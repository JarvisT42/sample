<?php
// Include your database connection
include '../connection.php';

// Get the raw POST data from the request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if the 'fines' data is set
if (isset($data['fines'])) {
    $newFines = floatval($data['fines']); // Convert to float for safety

    // Update the fines in the 'library_fines' table
    $query = "UPDATE library_fines SET fines = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('d', $newFines); // 'd' stands for double (decimal)
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Fines updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update fines']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}

$conn->close();
?>
