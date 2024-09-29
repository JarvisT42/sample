<?php
session_start();
include '../connection.php'; // Ensure you have your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected book IDs from the form
    $selected_books = $_POST['selected_books'] ?? [];
    $student_id = $_POST['student_id'] ?? null; // Ensure this is properly fetched

    // Check if any books were selected
    if (empty($selected_books) || !$student_id) {
        echo "<script>alert('No books were selected or no student ID provided.');</script>";
        exit; // Stop execution
    }

    // Get today's date in the desired format (e.g., 'Y-m-d')
    $issued_date = date('Y-m-d'); // Adjust the format if necessary

    // Prepare the update statement without the due date
    $query = "UPDATE GFI_Library_Database.borrow SET status = 'borrowed', Issued_date = ? WHERE student_id = ? AND book_id = ? AND status = 'pending'";
    $stmt = $conn->prepare($query);

    // Loop through each selected book ID and update the status and issued date
    foreach ($selected_books as $book_id) {
        $book_id = (int)$book_id; // Ensure the ID is an integer
        $stmt->bind_param("sii", $issued_date, $student_id, $book_id); // Bind parameters
        $stmt->execute(); // Execute the update
    }

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        // Optionally, redirect to a success page or refresh
        echo "<script>alert('Books successfully borrowed!');</script>";
        
        // Use exit after header to ensure the script stops executing
        header("Location: dashboard.php");
        exit(); // Make sure to exit after header redirection
    }

    exit; // Stop execution after processing
}
?>
