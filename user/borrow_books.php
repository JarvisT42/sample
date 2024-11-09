<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../connection.php';  // Assuming you have a connection script
include '../connection2.php';  // Assuming you have a connection script for book update

// Get the student name, selected time, date, and email from session
$id = $_SESSION["Student_Id"];
$email = $_SESSION["email"];
$selectedDate = $_SESSION["selected_date"];
$selectedTime = $_SESSION["selected_time"];
$appointment_id = $_SESSION["appointment_id"];

// Save book IDs (assuming you have book IDs in your session for each book)
$bookBag = $_SESSION['book_bag']; // Books in session

if (!empty($bookBag)) {
    // Iterate through the books and check the number of copies before borrowing
    foreach ($bookBag as $book) {
        $book_id = $book['id'];  // Assuming 'id' exists in the book session data
        $table = $book['table'];  // Assuming 'table' exists in the book session data
        $role = 'Student';
        $status = 'pending';
        $way_of_borrow = 'online';

        // Query to check the number of copies
        $checkCopiesSql = "SELECT No_Of_Copies FROM `$table` WHERE id = ?";
        
        if ($stmtCheck = $conn2->prepare($checkCopiesSql)) {
            $stmtCheck->bind_param("i", $book_id);
            $stmtCheck->execute();
            $stmtCheck->bind_result($noOfCopies);
            $stmtCheck->fetch();
            $stmtCheck->close();

            // Check if there are sufficient copies available
            if ($noOfCopies <= 1) {
                // Alert the user if the book has no available copies
                $_SESSION['error_message'] = "Someone borrowed this book: " . htmlspecialchars($book['title']);
                continue; // Skip the insert for this book
            }
        } else {
            $_SESSION['error_message'] = 'Error preparing book check query: ' . $conn->error;
            continue;
        }

        // Proceed with the insert if copies are available
        $sql = "INSERT INTO borrow (role, student_id, book_id, Category, appointment_id, Date_to_claim, time, Way_Of_Borrow, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("siisissss", $role, $id, $book_id, $table, $appointment_id, $selectedDate, $selectedTime, $way_of_borrow, $status);
            
            // Execute the query
            if ($stmt->execute()) {
                // Deduct the number of calendar slots based on the selected time
                $columnToUpdate = ($selectedTime === 'morning') ? 'morning' : 'afternoon';
                $calendarUpdateSql = "UPDATE calendar_appointment SET $columnToUpdate = $columnToUpdate - 1 WHERE calendar = ?";

                if ($stmt2 = $conn->prepare($calendarUpdateSql)) {
                    $stmt2->bind_param("s", $selectedDate);
                    if (!$stmt2->execute()) {
                        $_SESSION['error_message'] = 'Error updating calendar slots: ' . $stmt2->error;
                    }
                    $stmt2->close();
                } else {
                    $_SESSION['error_message'] = 'Error preparing calendar update query: ' . $conn->error;
                }

                // Now deduct the number of book copies
                $bookDeductionSql = "UPDATE `$table` SET No_Of_Copies = No_Of_Copies - 1 WHERE id = ?";
                if ($stmt3 = $conn2->prepare($bookDeductionSql)) {
                    $stmt3->bind_param("i", $book_id);
                    if (!$stmt3->execute()) {
                        $_SESSION['error_message'] = 'Error updating number of book copies: ' . $stmt3->error;
                    }
                    $stmt3->close();
                } else {
                    $_SESSION['error_message'] = 'Error preparing book deduction query: ' . $conn2->error;
                }

            } else {
                $_SESSION['error_message'] = 'Error saving borrow record: ' . $stmt->error;
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
$email = $_SESSION["email"];
$phoneNo = $_SESSION["phoneNo."];

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
header("Location: success_booked.php?firstName=$firstName&lastName=$lastName&email=$email&phoneNo=$phoneNo&date=$selectedDate&time=$selectedTime&books=$bookBagTitlesStr");
exit();
?>
