
<?php
// check-code.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library"; // Replace with your database name
$conn = new mysqli($servername, $username, $password, $dbname);


header('Content-Type: application/json');

$code = $_POST['code'];

// Prepare and execute the query
$sql = "SELECT COUNT(*) AS count FROM code WHERE code_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['valid' => true]);
} else {
    echo json_encode(['valid' => false]);
}

$stmt->close();
$conn->close();
?>

