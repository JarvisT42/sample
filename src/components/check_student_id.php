<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['valid' => false, 'error' => 'Database connection failed']);
    exit();
}

// Get the student ID from the POST data
$student_id = $_POST['student_id'];

// Prepare and execute the query to check if student ID exists
$sql = "SELECT * FROM code WHERE code_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id); // 's' for string (VARCHAR)
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows are returned
$response = ['valid' => false]; // Default response
if ($result->num_rows > 0) {
    $response['valid'] = true; // Student ID already exists
} else {
    $response['valid'] = false; // Student ID can register
}

// Close the connection
$stmt->close();
$conn->close();

// Send the response as JSON
echo json_encode($response);
?>
