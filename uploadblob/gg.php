
<?php
$host = 'localhost';
$dbname = 'files';
$username = 'root';
$password = '';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];

  
  
    $fileContent = file_get_contents($fileTmpPath);

    $sql = "INSERT INTO files ( file_content) VALUES ( ?)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fileContent]);
        echo "File uploaded successfully.";
    } catch (PDOException $e) {
        echo "Error uploading file: " . $e->getMessage();
    }
} else {
    echo "No file uploaded or an error occurred.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h2>File Upload Form</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">Choose file to upload:</label>
        <input type="file" name="file" id="file" required>
        <br><br>
        <input type="submit" name="submit" value="Save">
    </form>
</body>
</html>
