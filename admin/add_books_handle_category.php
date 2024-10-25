<?php
include("../connection.php");
include("../connection2.php");
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetching form data
    $table = isset($_POST['table']) ? $_POST['table'] : '';
    $add_category = isset($_POST['add_category']) ? $_POST['add_category'] : '';
    $tracking_id = isset($_POST['tracking_id']) ? $_POST['tracking_id'] : '';
    $date_of_publication_copyright = isset($_POST['date_of_publication_copyright']) ? $_POST['date_of_publication_copyright'] : '';
    $call_number = isset($_POST['call_number']) ? $_POST['call_number'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $book_title = isset($_POST['book_title']) ? $_POST['book_title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $book_copies = isset($_POST['book_copies']) ? $_POST['book_copies'] : '';
    $publisher_name = isset($_POST['publisher_name']) ? $_POST['publisher_name'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $image = isset($_FILES['image']) ? $_FILES['image'] : null; // Get image file info
    $available_to_borrow = isset($_POST['available_to_borrow']) ? 'Yes' : 'No'; // Get available to borrow checkbox value

    // Add new category to the database
    if (!empty($add_category)) {
        $add_category_sanitized = mysqli_real_escape_string($conn2, $add_category);

        // Check if the table already exists
        $check_table_sql = "SHOW TABLES LIKE '$add_category_sanitized'";
        $result = $conn2->query($check_table_sql);

        if ($result->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => "Table \"$add_category\" already exists."]);
        } else {
            // SQL to create table with columns including Available_To_Borrow
            $sql = "CREATE TABLE `$add_category_sanitized` (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                Tracking_Id VARCHAR(250) NOT NULL,
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

            // Execute the table creation query
            if ($conn2->query($sql) === TRUE) {
                // Handle image upload
                $imageData = null;
                if ($image && $image['error'] === UPLOAD_ERR_OK) {
                    // Read the image file
                    $imageData = file_get_contents($image['tmp_name']);
                }

                // Prepare the insert statement with Available_To_Borrow
                $insert_sql = "INSERT INTO `$add_category_sanitized` 
                (Tracking_Id, Call_Number, Department, Title, Author, Publisher, Date_Of_Publication_Copyright, No_Of_Copies, Subjects, Status, record_cover, Available_To_Borrow) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn2->prepare($insert_sql);
                if ($stmt) {
                    // Bind parameters (ensure correct types)
                    $stmt->bind_param("ssssssssssss", $tracking_id, $call_number, $department, $book_title, $author, $publisher_name, $date_of_publication_copyright, $book_copies, $subject, $status, $imageData, $available_to_borrow);

                    // Execute the insert query
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => "Data inserted successfully."]);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => "Error creating category: " . $conn2->error]);
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => "Error preparing insert statement: " . $conn2->error]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => "Error creating category: " . $conn2->error]);
            }
        }
    } elseif (!empty($table)) {
        // Handle image upload
        $imageData = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            // Read the image file
            $imageData = file_get_contents($image['tmp_name']);
        }

        // Prepare the insert statement with Available_To_Borrow
        $insert_sql = "INSERT INTO `$table` 
        (Tracking_Id, Call_Number, Department, Title, Author, Publisher, Date_Of_Publication_Copyright, No_Of_Copies, Subjects, Status, record_cover, Available_To_Borrow) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn2->prepare($insert_sql);
        if ($stmt) {
            // Bind parameters (ensure correct types)
            $stmt->bind_param("ssssssssssss", $tracking_id, $call_number, $department, $book_title, $author, $publisher_name, $date_of_publication_copyright, $book_copies, $subject, $status, $imageData, $available_to_borrow);

            // Execute the insert query
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => "Data inserted successfully."]);
            } else {
                echo json_encode(['status' => 'error', 'message' => "Error inserting data: " . $stmt->error]);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error preparing insert statement: " . $conn2->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "No category selected or added."]);
    }
}
