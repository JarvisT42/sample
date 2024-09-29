<?php
include '../connection.php'; // Ensure you have your database connection

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = intval($_GET['id']); // Ensure it's an integer to prevent SQL injection
    $category = intval($_GET['category']); // Ensure it's an integer to prevent SQL injection

    // Query to get the image data
    $query = "SELECT record_cover FROM $category WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($record_cover);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        header("Content-Type: image/jpeg"); // Set the correct content type
        echo $record_cover; // Output the binary data
    } else {
        // Handle no image found
        http_response_code(404);
        echo "Image not found.";
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo "No ID provided.";
}
?>
