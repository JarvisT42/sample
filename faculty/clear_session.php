<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Check current session variables before unsetting
    error_log('Before clear: ' . json_encode($_SESSION));

    unset($_SESSION['selected_date']); // Clear selected_date
    unset($_SESSION['selected_time']); // Clear selected_time

    // Debug: Check session variables after unsetting
    error_log('After clear: ' . json_encode($_SESSION));

    // Return a response indicating the variables were cleared
    echo json_encode(['message' => 'Selected session variables cleared']);
    exit;
}
?>
