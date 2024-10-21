<?php
session_start();
include '../connection2.php'; // Connection to the database

// Get JSON input from the request
$data = json_decode(file_get_contents('php://input'), true);

// Extract book ID and table name from the request
$book_id = $data['book_id'];
$table = $data['table'];

// Prepare and execute the SQL query to check the number of copies
$sql = "SELECT No_Of_Copies FROM `$table` WHERE id = ?";
if ($stmt = $conn2->prepare($sql)) {
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->bind_result($noOfCopies);
    $stmt->fetch();
    $stmt->close();

    // Check if the book is available
    if ($noOfCopies > 1) {
        // Return a success response
        echo json_encode(['success' => true]);
    } else {
        // Return an error if no copies are available
        echo json_encode(['success' => false, 'message' => 'Someone else borrowed this book before you, it is now unavailable.']);
    }
} else {
    // Handle errors in preparing the statement
    echo json_encode(['success' => false, 'message' => 'Error checking book availability.']);
}
?>
