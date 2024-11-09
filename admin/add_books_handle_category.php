<?php
session_start();
include("../connection.php");
include("../connection2.php");
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetching form data
    $table = isset($_POST['table']) ? $_POST['table'] : '';
    $add_category = isset($_POST['add_category']) ? $_POST['add_category'] : '';
    $date_of_publication_copyright = isset($_POST['date_of_publication_copyright']) ? $_POST['date_of_publication_copyright'] : '';
    $call_number = isset($_POST['call_number']) ? $_POST['call_number'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $book_title = isset($_POST['book_title']) ? $_POST['book_title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $book_copies = isset($_POST['book_copies']) ? $_POST['book_copies'] : '';
    $publisher_name = isset($_POST['publisher_name']) ? $_POST['publisher_name'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;
    $available_to_borrow = isset($_POST['available_to_borrow']) ? 'Yes' : 'No'; // Set to "No" if unchecked

    // Handle category creation if 'add_category' is provided
    if (!empty($add_category)) {
        $add_category_sanitized = mysqli_real_escape_string($conn2, $add_category);

        // Check if table exists
        $check_table_sql = "SHOW TABLES LIKE '$add_category_sanitized'";
        $result = $conn2->query($check_table_sql);

        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => "Table \"$add_category\" already exists."]);
            exit;
        } else {
            // SQL to create the table
            $sql = "CREATE TABLE `$add_category_sanitized` (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                Call_Number VARCHAR(250) NOT NULL,
                Department VARCHAR(250) NOT NULL,
                Title VARCHAR(250) NOT NULL,
                Author VARCHAR(250) NOT NULL,
                Publisher VARCHAR(250) NOT NULL,
                Date_Of_Publication_Copyright VARCHAR(250) NOT NULL,
                No_Of_Copies INT(11) NOT NULL,
                Date_Encoded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                Subjects VARCHAR(250) NOT NULL,
                record_cover LONGBLOB,
                Status VARCHAR(250) NOT NULL,
                Available_To_Borrow VARCHAR(250) NOT NULL
            )";

            if ($conn2->query($sql) === TRUE) {
                $table = $add_category_sanitized;
            } else {
                echo json_encode(['status' => 'error', 'message' => "Error creating category: " . $conn2->error]);
                exit;
            }
        }
    }

    // Proceed if table is set
    if (!empty($table)) {
        // Handle image upload
        $imageData = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($image['tmp_name']);
        }

        // Insert into the main book table
        $insert_sql = "INSERT INTO `$table` 
        (Call_Number, Department, Title, Author, Publisher, Date_Of_Publication_Copyright, No_Of_Copies, Subjects, Status, record_cover, Available_To_Borrow) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn2->prepare($insert_sql);
        if ($stmt) {
            $stmt->bind_param("sssssssssss", $call_number, $department, $book_title, $author, $publisher_name, $date_of_publication_copyright, $book_copies, $subject, $status, $imageData, $available_to_borrow);

            // Execute the insert query for the main book data
            if ($stmt->execute()) {
                // Get the inserted book's ID to associate with accession numbers
                $book_id = $stmt->insert_id;
                $stmt->close();
                
                // Insert each accession number into the accesion_no table
                $success = true;
                for ($i = 1; $i <= $book_copies; $i++) {
                    $accession_key = "accession_no_$i";
                    if (isset($_POST[$accession_key]) && !empty($_POST[$accession_key])) {
                        $accession_no = htmlspecialchars($_POST[$accession_key]);

                        // Insert accession number into accesion_no table
                        $accession_insert_sql = "INSERT INTO accession_no 
                        (accession_no, call_number, book_id, book_category, available) 
                        VALUES (?, ?, ?, ?, ?)";

                        $accession_stmt = $conn->prepare($accession_insert_sql);
                        if ($accession_stmt) {
                            // Note: Passing the $available_to_borrow value for each accession entry
                            $accession_stmt->bind_param("ssiss", $accession_no, $call_number, $book_id, $table, $available_to_borrow);
                            
                            if (!$accession_stmt->execute()) {
                                $success = false;
                                echo json_encode(['status' => 'error', 'message' => "Error inserting accession number $accession_no: " . $accession_stmt->error]);
                                break;
                            }
                            $accession_stmt->close();
                        } else {
                            $success = false;
                            echo json_encode(['status' => 'error', 'message' => "Error preparing accession insert statement: " . $conn->error]);
                            break;
                        }
                    }
                }

                // If all accession numbers were successfully inserted
                if ($success) {
                    echo json_encode(['status' => 'success', 'message' => "Data and accession numbers inserted successfully."]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => "Error inserting main book data: " . $stmt->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error preparing main book insert statement: " . $conn2->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "No category selected or added."]);
    }
}
?>
