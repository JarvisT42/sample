<?php
session_start();

$count = isset($_SESSION['book_bag']) ? count($_SESSION['book_bag']) : 0;

echo json_encode(['count' => $count]);
?>
