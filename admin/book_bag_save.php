<?php
// Start session
session_start();

// Include database connection
include '../connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the role, full name, and due date from the POST request
    $role = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : '';
    $fullName = isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '';
    $dueDate = isset($_POST['due_date']) ? htmlspecialchars($_POST['due_date']) : '';

    // Check if there are any books in the book bag session
    if (isset($_SESSION['book_bag']) && count($_SESSION['book_bag']) > 0) {
        $bookBag = $_SESSION['book_bag'];
        $issued_date = date('Y-m-d'); // Adjust the format if necessary
    
        // Get the current maximum walk_in_id and increment it
        $sqlMaxId = "SELECT MAX(walk_in_id) AS max_id FROM borrow";
        $result = $conn->query($sqlMaxId);
        
        // Check if there are results
        if ($result) {
            $row = $result->fetch_assoc();
            // Get the current maximum walk_in_id and increment it
            $walk_in_id = $row['max_id'] ? $row['max_id'] + 1 : 1; // If max_id is NULL, set walk_in_id to 1
        } else {
            // Handle error
            die("Error fetching max walk_in_id: " . $conn->error);
        }

        $successfulInserts = 0; // Track successful inserts

        // Loop through the book bag and save each book to the database
        foreach ($bookBag as $book) {
            // Get book details
            $bookId = htmlspecialchars($book['id']);
            $title = htmlspecialchars($book['title']);
            $author = htmlspecialchars($book['author']);
            $publicationDate = htmlspecialchars($book['publicationDate']);
            $table = htmlspecialchars($book['table']);
            $copies = htmlspecialchars($book['copies']);
            $coverImage = htmlspecialchars($book['coverImage']);
            $wayOfBorrow = 'walk-in';  // example value
            $status = 'borrowed';  // example value
    
            // Prepare the SQL query to insert book details
            $sql = "INSERT INTO borrow (role, walk_in_id, Full_Name, book_id, Category, Date_To_Claim, Issued_Date, Due_Date, Way_Of_Borrow, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Use prepared statements to prevent SQL injection
            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param("sisissssss", $role, $walk_in_id, $fullName, $bookId, $table, $issued_date, $issued_date, $dueDate, $wayOfBorrow, $status);
                
                // Execute the statement
                if ($stmt->execute()) {
                    // Include the connection script for book update
                    include '../connection2.php';  
                    
                    // Prepare to update the number of copies
                    $bookDeduction = "UPDATE `$table` SET No_Of_Copies = No_Of_Copies - 1 WHERE id = ?";
    
                    if ($stmt2 = $conn2->prepare($bookDeduction)) {
                        $stmt2->bind_param("i", $bookId);
                        
                        if ($stmt2->execute()) {
                            // Insert into most_borrowed_books after successful deduction
                            $insert_most_borrowed = "INSERT INTO GFI_Library_Database.most_borrowed_books (book_id, category, date)
                                                     VALUES (?, ?, ?)";

                            if ($stmt3 = $conn2->prepare($insert_most_borrowed)) {
                                $stmt3->bind_param("iss", $bookId, $table, $issued_date);
                                if ($stmt3->execute()) {
                                    $successfulInserts++; // Count successful insertions
                                } else {
                                    $_SESSION['error_message'] = 'Error inserting into most_borrowed_books: ' . $stmt3->error;
                                }
                                $stmt3->close();
                            } else {
                                $_SESSION['error_message'] = 'Error preparing most_borrowed_books query: ' . $conn2->error;
                            }
                        } else {
                            $_SESSION['error_message'] = 'Error updating book copies: ' . $stmt2->error;
                        }

                        $stmt2->close();
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => "Error creating category: " . $stmt->error]);
                    return; // Exit if there was an error
                }

                // Close the statement
                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => "Error preparing statement: " . $conn->error]);
                return; // Exit if there was an error
            }
        }

        // After the loop, check if any books were successfully inserted
        if ($successfulInserts > 0) {
            // Clear the book bag and session variables after successful insertion
            $_SESSION['book_bag'] = []; // Clear the book bag
            unset($_SESSION['role']); // Clear role
            unset($_SESSION['full_name']); // Clear full name
            echo json_encode(['status' => 'success', 'message' => "$successfulInserts books borrowed successfully."]);                        
        } else {
            echo json_encode(['status' => 'error', 'message' => "No books were borrowed."]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "Book bag is empty!"]);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => "Invalid request method!"]);
}
?>
