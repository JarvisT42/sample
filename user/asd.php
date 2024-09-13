
<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gfi_library_database_books_records");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a file was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO alegbra (record_cover) VALUES (?)");
    $stmt->bind_param("b", $null);

    // Get the file content
    $fileContent = file_get_contents($_FILES['image']['tmp_name']);

    // Bind the file content to the parameter
    $null = NULL;
    $stmt->send_long_data(0, $fileContent);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Image uploaded and stored in database successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "No file uploaded or there was an upload error.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="file"] {
            width: 100%;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Image</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Choose an image to upload:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Save Image">
            </div>
        </form>
    </div>
</body>
</html>
