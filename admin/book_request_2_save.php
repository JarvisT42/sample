<?php
session_start();
include '../connection.php'; // Ensure you have your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_books'])) {
    // Get the selected book IDs from the form
    $selected_books = $_POST['selected_books'];

    // Get today's date in the desired format (e.g., 'Y-m-d')
    $issued_date = date('Y-m-d'); // Adjust the format if necessary

    // Calculate the due date (3 days after the issued date)
    $due_date = date('Y-m-d', strtotime('+3 days')); // 3 days in advance

    // Prepare the update statement
    $query = "UPDATE borrow SET status = 'borrowed', Issued_date = ?, Due_Date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Loop through each selected book ID and update the status, issued date, and due date
    foreach ($selected_books as $book_id) {
        $book_id = (int)$book_id; // Ensure the ID is an integer
        $stmt->bind_param("ssi", $issued_date, $due_date, $book_id); // Bind the issued date, due date, and book ID
        $stmt->execute(); // Execute the update
    }

    $stmt->close(); // Close the statement

    // Optionally, set a session message or return success response
    $_SESSION['message'] = "Books successfully borrowed.";
    
    // Show alert and redirect back to dashboard.php
    echo "<script>
            alert('Books successfully borrowed.');
            window.location.href = 'dashboard.php';
          </script>";
    exit;
} else {
    // Handle the case where no books were selected
    echo "<script>alert('No books were selected.');</script>";
    exit; // Stop execution
}
?>
