<?php
session_start();
require 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    if (!empty($student_id)) {
        $stmt = $conn->prepare("SELECT * FROM students_id WHERE student_id = ? AND status = '' ");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo 'valid';
        } else {
            echo 'invalid';
        }
        $stmt->close();
    } else {
        echo 'invalid';
    }

    $conn->close();
}
?>
