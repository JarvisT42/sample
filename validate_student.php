<?php
session_start();
require 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    if (!empty($student_id)) {
        // Prepare and execute query to check the student_id and status
        $stmt = $conn->prepare("SELECT status FROM students_id WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the status of the student_id
            $row = $result->fetch_assoc();
            $status = $row['status'];

            if ($status === 'Taken') {
                // Return message if the student ID is already registered
                echo 'already_registered';
            } else {
                // Return 'valid' if the student ID is not taken
                echo 'valid';
            }
        } else {
            // Return 'invalid' if the student_id does not exist
            echo 'invalid';
        }

        $stmt->close();
    } else {
        echo 'invalid';
    }

    $conn->close();
}
?>
