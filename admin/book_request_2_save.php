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

    // Prepare the update statement for borrowing status
    $query = "UPDATE GFI_Library_Database.borrow 
              SET status = 'borrowed', Issued_date = ? 
              WHERE student_id = ? AND book_id = ? AND Category = ? AND status = 'pending'";

    // Prepare the insert statement for the most_borrowed_books table
    $insert_most_borrowed = "INSERT INTO GFI_Library_Database.most_borrowed_books (book_id, category, date)
                             VALUES (?, ?, ?)";

    // Prepare both statements
    $stmt = $conn->prepare($query);
    $stmt_most_borrowed = $conn->prepare($insert_most_borrowed);

    // Loop through each selected book ID and update the status and issued date
    foreach ($selected_books as $book_info) {
        // Split the book_info to get book_id and category
        list($book_id, $category) = explode('|', $book_info);

        $book_id = (int)$book_id; // Ensure the ID is an integer
        $stmt->bind_param("ssis", $issued_date, $student_id, $book_id, $category); // Bind parameters for update

        // Execute the update for borrow status
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        }

        // Now insert into most_borrowed_books table
        $stmt_most_borrowed->bind_param("iss", $book_id, $category, $issued_date); // Bind parameters for insertion
        $stmt_most_borrowed->execute(); // Execute the insert

        if ($stmt_most_borrowed->error) {
            echo "Error: " . $stmt_most_borrowed->error;
        }
    }

    // After processing all selected books, you can redirect or show a message
    echo "<script>alert('Books successfully borrowed!');</script>";
    header("Location: dashboard.php");
    exit(); // Make sure to exit after header redirection
}
?>
c