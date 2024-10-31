<?php
include 'start_session.php';

// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "files";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the selected option from the session
$selectedOption = isset($_SESSION['selectedOption']) ? $_SESSION['selectedOption'] : '';

if ($selectedOption) {
    // Insert the selected option into the database
    $sql = "INSERT INTO files (file_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedOption);

    if ($stmt->execute()) {
        echo "Selection saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Clear the session data
session_unset();
session_destroy();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Page</title>
</head>
<body>
    <a href="page1.php">Go Back to Selection Page</a>
</body>
</html>
