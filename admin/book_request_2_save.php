<?php
session_start();
include '../connection.php'; // Ensure you have your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected book IDs from the form
    $selected_books = $_POST['selected_books'] ?? [];
    $user_id = $_POST['student_id'] ?? $_POST['faculty_id'] ?? null; // Get either student_id or faculty_id
    $isStudent = isset($_POST['student_id']); // Determine if the user is a student
    $due_date = $_POST['due_date'] ?? null; // Get the due date

    // Check if any books were selected and if a valid user ID and due date are provided
    if (empty($selected_books) || !$user_id || !$due_date) {
        echo "<script>alert('No books were selected, no user ID provided, or no due date selected.');</script>";
        exit; // Stop execution if validation fails
    }

    // Get today's date in the desired format (e.g., 'Y-m-d')
    $issued_date = date('Y-m-d'); // Adjust the format if necessary

    // Prepare the update statement for borrowing status
    $query = "UPDATE GFI_Library_Database.borrow 
              SET status = 'borrowed', Issued_date = ?, Due_Date = ? 
              WHERE " . ($isStudent ? "student_id" : "faculty_id") . " = ? AND book_id = ? AND Category = ? AND status = 'pending'";

    // Prepare the insert statement for the most_borrowed_books table
    $insert_most_borrowed = "INSERT INTO GFI_Library_Database.most_borrowed_books (book_id, category, date)
                             VALUES (?, ?, ?)";

    // Prepare both statements
    $stmt = $conn->prepare($query);
    $stmt_most_borrowed = $conn->prepare($insert_most_borrowed);

    // Loop through each selected book ID and update the status, issued date, and due date
    foreach ($selected_books as $book_info) {
        // Split the book_info to get book_id and category
        list($book_id, $category) = explode('|', $book_info);

        $book_id = (int)$book_id; // Ensure the ID is an integer
        $stmt->bind_param("sssis", $issued_date, $due_date, $user_id, $book_id, $category); // Bind parameters for update

        // Execute the update for borrow status
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        }

        // Insert into most_borrowed_books table
        $stmt_most_borrowed->bind_param("iss", $book_id, $category, $issued_date); // Bind parameters for insertion
        $stmt_most_borrowed->execute();

        if ($stmt_most_borrowed->error) {
            echo "Error: " . $stmt_most_borrowed->error;
        }
    }

    // After processing all selected books, redirect or show a message
    echo "<script>alert('Books successfully borrowed!');</script>";
    header("Location: dashboard.php");
    exit(); // Make sure to exit after header redirection
}
?>
