<?php
// Include your database connection file
include '../connection.php';

// Get the raw POST data from the request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if the data exists and is valid
if (isset($data['fullname'], $data['username'], $data['email'], $data['password'], $data['confirm_password'])) {
    $fullname = mysqli_real_escape_string($conn, $data['fullname']);
    $username = mysqli_real_escape_string($conn, $data['username']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $confirm_password = mysqli_real_escape_string($conn, $data['confirm_password']);

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match!']);
        exit();
    }

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkUserQuery = "SELECT * FROM admin_account WHERE Username='$username' OR Email='$email'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username or Email already exists!']);
    } else {
        // Insert the new user into the database
        $query = "INSERT INTO admin_account (Full_Name, Username, Email, Password, Confirm_Password) VALUES ('$fullname', '$username', '$email', '$hashed_password', '$hashed_password')";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data!']);
}
?>
