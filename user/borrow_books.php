<?php
session_start();
include '../connection.php';  // Assuming you have a connection script

// Get the student name, selected time, date, and email from session
$id = $_SESSION["Id"];
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
        // Assuming 'author' exists in the book session data
        $role = 'Student';

        $status = 'pending';
        $way_of_borrow = 'online';

        // Insert the data into the `borrow` table
        $sql = "INSERT INTO borrow (role, student_id, book_id, Category,  Date_to_claim, time, Way_Of_Borrow, status) 
                VALUES (?, ?, ?, ?,  ?, ?,  ?,  ?)"; // Add cover_image to the SQL query
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("siisssss",     $role,  $id, $book_id, $table,  $selectedDate, $selectedTime, $way_of_borrow, $status);
            
            // Execute the query
            if ($stmt->execute()) {
                // Deduct the number of copies
                include '../connection2.php';  // Assuming you have a connection script for book update

                $bookDeduction = "UPDATE  `$table`  SET No_Of_Copies = No_Of_Copies - 1 WHERE id = ?";
                if ($stmt2 = $conn2->prepare($bookDeduction)) {
                    $stmt2->bind_param("i", $book_id);
                    
                    if ($stmt2->execute()) {
                        // Optional: You can set a success message here
                    } else {
                        $_SESSION['error_message'] = 'Error updating book copies: ' . $stmt2->error;
                    }

                    $stmt2->close();
                } else {
                    $_SESSION['error_message'] = 'Error preparing book deduction query: ' . $conn2->error;
                }
            } else {
                $_SESSION['error_message'] = 'Error saving data: ' . $stmt->error;
            }

            $stmt->close();
        }
    }
} else {
    $_SESSION['error_message'] = "No books in your bag.";
}

// Clear the session variables but before that, store necessary data in variables
$firstName = $_SESSION["First_Name"];
$lastName = $_SESSION["Last_Name"];
$email = $_SESSION["Email_Address"];
$selectedDate = $_SESSION["selected_date"];
$selectedTime = $_SESSION["selected_time"];
$bookBagTitles = array_map(function ($book) {
    return $book['title'] . '|' . $book['author'];
}, $_SESSION['book_bag']);

// Convert book titles and authors into a query string
$bookBagTitlesStr = urlencode(serialize($bookBagTitles));

// Clear the session variables
unset($_SESSION['book_bag']);
unset($_SESSION['selected_date']);
unset($_SESSION['selected_time']);

// Redirect to the success page, passing data via URL parameters
header("Location: success_booked.php?firstName=$firstName&lastName=$lastName&email=$email&date=$selectedDate&time=$selectedTime&books=$bookBagTitlesStr");
exit();
?>




// Clear the session variables but before that, store necessary data in variables
$firstName = $_SESSION["First_Name"];
$lastName = $_SESSION["Last_Name"];
$email = $_SESSION["Email_Address"];
$selectedDate = $_SESSION["selected_date"];
$selectedTime = $_SESSION["selected_time"];
$bookBagTitles = array_map(function ($book) {
    return $book['title'] . '|' . $book['author'];
}, $_SESSION['book_bag']);

// Convert book titles and authors into a query string
$bookBagTitlesStr = urlencode(serialize($bookBagTitles));

// Clear the session variables
unset($_SESSION['book_bag']);
unset($_SESSION['selected_date']);
unset($_SESSION['selected_time']);

// Redirect to the success page, passing data via URL parameters
header("Location: success_booked.php?firstName=$firstName&lastName=$lastName&email=$email&date=$selectedDate&time=$selectedTime&books=$bookBagTitlesStr");
exit();





?>
