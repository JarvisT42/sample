<?php
session_start();
include '../connection.php';  // Assuming you have a connection script

// Get the student name, selected time, date, and email from session
$id = $_SESSION["Id"];
$student_name = $_SESSION["First_Name"] . ' ' . $_SESSION["Last_Name"];
$email = $_SESSION["Email_Address"];
$selectedDate = $_SESSION["selected_date"];
$selectedTime = $_SESSION["selected_time"];

// Save book IDs (assuming you have book IDs in your session for each book)
$bookBag = $_SESSION['book_bag']; // Books in session

if (!empty($bookBag)) {
    // Iterate through the books and save each ID to the 'borrow' table
    foreach ($bookBag as $book) {
        $book_id = $book['id'];  // Assuming 'id' exists in the book session data
        $table = $book['table'];  // Assuming 'table' exists in the book session data
        $title = $book['title'];  // Assuming 'title' exists in the book session data
        $author = $book['author'];  // Assuming 'author' exists in the book session data
        $status = 'Pending';

        // Insert the data into the `borrow` table
        $sql = "INSERT INTO borrow (student_id, student, book_id, Category, Title, Author, Date_to_claim, time, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isissssss", $id, $student_name, $book_id, $table, $title, $author, $selectedDate, $selectedTime, $status);
            
            // Execute the query
            if ($stmt->execute()) {
                // Optional: You can set a session message here if you want
                $_SESSION['success_message'] = 'Data saved successfully!';
            } else {
                $_SESSION['error_message'] = 'Error saving data: ' . $stmt->error;
            }

            $stmt->close();
        }
    }
} else {
    $_SESSION['error_message'] = "No books in your bag.";
}

// Clear the session variables
unset($_SESSION['book_bag']);
unset($_SESSION['selected_date']);
unset($_SESSION['selected_time']);

$conn->close();

// Redirect to the success page after processing
header("Location: succe.php");
exit();
?>
