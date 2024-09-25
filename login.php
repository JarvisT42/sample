<?php
session_start();
include("connection.php");
require 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the SQL statement to avoid SQL injection
        $query = "SELECT * FROM students WHERE User_Name = ?";
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            // Bind the parameter (username) to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $username);
            
            // Execute the statement
            mysqli_stmt_execute($stmt);
            
            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch the user data
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['Password'];
                $registerStatus = $row['Register_Status'];

                // Verify entered password with the hashed password from the database
                if (password_verify($password, $hashedPassword)) {
                    if ($registerStatus === "Approve") {
                        // Registration is approved, set session variables and redirect
                        
                        $_SESSION["loggedin"] = true;
                        $_SESSION["Id"] = $row['Id'];
                        $_SESSION["First_Name"] = $row['First_Name'];
                        $_SESSION["Middle_Initial"] = $row['Middle_Initial'];
                        $_SESSION["S_Course"] = $row['S_Course'];

                        $_SESSION["Last_Name"] = $row['Last_Name'];
                        $_SESSION["User_Name"] = $row['User_Name'];
                        $_SESSION["Email_Address"] = $row['Email_Address'];
                        $_SESSION["Mobile_Number"] = $row['Mobile_Number'];

                        // Redirect to the user dashboard
                        echo "<script type='text/javascript'> alert('Successfully logged in'); window.location.href = 'user/dashboard.php'; </script>";
                        exit;
                    } else {
                        // Registration is not approved
                        echo "<script type='text/javascript'> alert('Your registration is not yet approved.'); </script>";
                    }
                } else {
                    // Incorrect password
                    echo "<script type='text/javascript'> alert('Invalid credentials.'); </script>";
                }
            } else {
                // No user found with the given username
                echo "<script type='text/javascript'> alert('Invalid credentials.'); </script>";
            }
        } else {
            echo "<script type='text/javascript'> alert('Error preparing the SQL statement.'); </script>";
        }
    } else {
        // Username or password is missing
        echo "<script type='text/javascript'> alert('Please enter both username and password.'); </script>";
    }
}
?>
