<?php
$host = "localhost";
$dbname = "GFI_Library_Database";
$username = "root";
$password = "";

// Optionally, you can establish the connection here too, if you want to keep using PDO
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
