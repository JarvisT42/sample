<?php
session_start();
echo json_encode([
    'selected_date' => isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : null,
    'selected_time' => isset($_SESSION['selected_time']) ? $_SESSION['selected_time'] : null,
]);
?>
