<?php
// Assuming you have already included your database connection file
include '../connection.php'; // Replace with your actual connection file

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Prepare an array to store the SQL placeholders and the values
$placeholders = [];
$values = [];

// Dynamically add only non-empty student IDs to the query
if (!empty($data['student1'])) {
    $placeholders[] = '(?)';
    $values[] = $data['student1'];
}
if (!empty($data['student2'])) {
    $placeholders[] = '(?)';
    $values[] = $data['student2'];
}
if (!empty($data['student3'])) {
    $placeholders[] = '(?)';
    $values[] = $data['student3'];
}
if (!empty($data['student4'])) {
    $placeholders[] = '(?)';
    $values[] = $data['student4'];
}
if (!empty($data['student5'])) {
    $placeholders[] = '(?)';
    $values[] = $data['student5'];
}

// Check if there are any values to insert
if (count($values) > 0) {
    // Create the SQL query dynamically with placeholders
    $sql = "INSERT INTO students_id (student_id) VALUES " . implode(', ', $placeholders);
    $stmt = $conn->prepare($sql);

    // Bind the values dynamically
    $types = str_repeat('s', count($values)); // 's' for each string (student_id)
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database insertion failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'No valid student IDs provided']);
}
?>
