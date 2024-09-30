<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session cookie, also delete it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to index.php
header("Location: ../index.php");
exit();
?>
<script>
     $(document).ready(function () {
            $("#toggleLogin").click(function () {
                const currentText = $(this).val();
                if (currentText === "Register") {
                    $(this).val("Login");
                    $(".register-right").show();
                    $(".login-right").hide();
                } else {
                    $(this).val("Register");
                    $(".register-right").hide();
                    $(".login-right").show();
                }
            });

            $("#forgot_password").click(function (event) {
                event.preventDefault();
                $(".login-right").hide();
                $(".forgot-password-right").show();
                $("#toggleLogin").val("Login");
            });

            $("#forgotPassword").submit(function (event) {
                event.preventDefault();
                // Here you would handle the password reset logic
                alert("Password reset link sent to your email.");
                $(".forgot-password-right").hide();
                $(".login-right").show();
            });

            $("#proceedToRegister").click(function () {
                // Validate Student ID No.
                const studentId = $("#student_id").val();
                if (studentId === "") {
                    $("#accessDeniedAlert").show();
                } else {
                    $("#accessDeniedAlert").hide();
                    $(".validation-right").hide();
                    $(".register-right").show();
                }
            });
        });
</script>