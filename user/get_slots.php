<?php
# Initialize the session
session_start();
include("../connection.php");

// Get the request body (the date passed from the frontend)
$data = json_decode(file_get_contents('php://input'), true);
$selected_date = $data['date'];

// Prepare response data
$response = [
    'morning' => 0,
    'afternoon' => 0
];

// Fetch available morning and afternoon slots from the database for the selected date
$sql = "SELECT morning, afternoon FROM calendar_appointment WHERE calendar = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selected_date); // Bind the selected date
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['morning'] = $row['morning']; // Get morning slots
    $response['afternoon'] = $row['afternoon']; // Get afternoon slots
}

$stmt->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
