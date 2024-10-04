<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$loginError = false; // Flag for login error

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_login'])) {

    include 'connection.php'; // Include your database connection file

    // Get form input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE Email_Address = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password']; // Assuming the column name is 'Password'

        // Verify the hashed password
        if (password_verify($password, $hashed_password)) {
            // If a match is found, set session variables and redirect to gg.php
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["Id"] = $row['Id'];
            $_SESSION["First_Name"] = $row['First_Name'];
            $_SESSION["Middle_Initial"] = $row['Middle_Initial'];
            $_SESSION["Last_Name"] = $row['Last_Name'];
            $_SESSION['email'] = $row['Email_Address'];

            header("Location: user/dashboard.php");
            exit();
        } else {
            $loginError = true; // Set login error flag
        }
    } else {
        $loginError = true; // Set login error flag if no user found
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_login'])) {

    include 'connection.php'; // Include your database connection file

    // Get form input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin_account WHERE Email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password']; // Assuming the column name is 'Password'

        // Verify the hashed password
        if (password_verify($password, $hashed_password)) {
            // If a match is found, set session variables and redirect to gg.php
            $_SESSION["logged_Admin"] = TRUE;
            $_SESSION["Id"] = $row['Id'];
            $_SESSION["Full_Name"] = $row['Full_Name'];



            header("Location: admin/dashboard.php");
            exit();
        } else {
            $loginError = true;
        }
    } else {
        $loginError = true;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="container sign-in-up">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="src/assets/images/icon-gfi-book.png" alt="" />
                <h3>Welcome</h3>
                <p>GFI's Online Library</p>
                <input type="button" id="toggleLogin" value="Register" /><br />
            </div>



            <div class="col-md-9 login-right">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Admin</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                        <form id="loginForm" class="student" method="POST" action="">
                            <h3 class="login-heading">Login As Student</h3>
                            <div class="row login-form">
                                <div class="col-md-6">
                                    <!-- Email input -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Your Email *" required />
                                        </div>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-group">
                                        <div class="input-group">


                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Your Password *" required />



                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <div class="input-group d-flex justify-content-between">
                                            <label class="form-check-label">

                                                <input type="checkbox" id="rememberMe" name="rememberMe" />
                                                Remember Me
                                            </label>
                                            <div class="">
                                                <a id="forgot_password" href="#" role="tab" aria-controls="ForgotPassword" aria-selected="false">Forgot Password?</a>


                                            </div>
                                        </div>
                                    </div>



                                    <!-- Remember Me checkbox -->

                                    <!-- Incorrect login alert -->
                                    <div class="alert alert-danger" style="display: <?php echo $loginError ? 'block' : 'none'; ?>;">
                                        Incorrect email or password. Please try again.
                                    </div>
                                    <!-- Login button -->
                                    <input type="submit" class="btnlogin" name="student_login" value="Login" />
                                    <!-- Forgotten password link -->

                                </div>
                            </div>
                        </form>





                    </div>



                    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                        <form id="loginForm " class="admin" method="POST" action="">
                            <h3 class="login-heading">Login As Admin</h3>
                            <div class="row login-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Your Email *" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Your Password *" required />
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" style="display: <?php echo $loginError ? 'block' : 'none'; ?>;">Incorrect email or password. Please try again.</div>
                                    <input type="submit" class="btnlogin" name="admin_login" value="Login" />
                                </div>
                            </div>
                        </form>




                    </div>
                </div>





            </div>


            <div class="col-md-9 forgot-password-right" style="display: none;">
                <form id="forgotPassword">
                    <h3 class="forgot-password-heading">Forgot Password</h3>
                    <div class="row forgot-password-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Your Email *" required />
                                </div>
                            </div>

                            <input type="submit" class="btnlogin" name="forgot_password" value="Send Email" />

                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-9 validation-right" style="display: none;">
                <form id="validationForm">
                    <h3 class="validation-heading">Validation</h3>
                    <div class="row validation-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <p class="validation-message alert alert-warning d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Before you proceed, make sure that your Student ID No. belongs to you.
                                    </p>

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" name="student_id" id="student_id" class="form-control" placeholder="Enter Student ID No." required />
                                </div>
                            </div>

                            <div id="accessDeniedAlert" class="alert alert-danger" style="display: none;">Incorrect Student ID No.</div>

                            <input type="button" class="btnRegister" id="proceedToRegister" value="Proceed" />
                        </div>
                    </div>
                </form>

            </div>





            <div class="col-md-9 register-right" style="display: none;">
                <form id="registrationForm">
                    <h3 class="register-heading">Student Registration</h3>
                    <div class="row register-form">
                        <!-- First Name and Last Name Fields -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="First Name *" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Last Name *" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Your Email *" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" minlength="10" maxlength="10" name="txtEmpPhone" class="form-control" placeholder="Your Phone *" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" required>
                                    <option class="hidden" selected disabled>Year Level</option>
                                    <option>1st Year</option>
                                    <option>2nd Year</option>
                                    <option>3rd Year</option>
                                    <option>4th Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <select class="form-control" required>
                                    <option class="hidden" selected disabled>Department</option>
                                    <option>Business Administration</option>
                                    <option>Engineering</option>
                                    <option>Education</option>
                                    <option>Arts and Sciences</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="maxl">
                                    <label class="radio inline">
                                        <input type="radio" name="gender" value="male" checked>
                                        <span class="radio-label"> Male </span>
                                    </label>
                                    <label class="radio inline">
                                        <input type="radio" name="gender" value="female">
                                        <span class="radio-label"> Female </span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" placeholder="Birth Date *" required />
                                </div>
                            </div>
                        </div>

                        <!-- Password Fields -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password *" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Confirm Password *" required />
                                </div>
                            </div>
                        </div>
             

                        <div class="col-md-12">
                            <input type="submit" class="btnRegister" value="Register" />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle between login and registration forms
            $("#toggleLogin").click(function() {
                // Hide forms and reset input fields
                $(".validation-right").hide();
                $(".register-right").hide();
                $(".forgot-password-right").hide(); // Hide forgot password form
                $("#validationForm")[0].reset(); // Reset validation form
                $("#registrationForm")[0].reset(); // Reset registration form

                // Toggle visibility of login and validation forms
                if ($(".login-right").is(":visible")) {
                    $(".login-right").hide();
                    $(".validation-right").show();
                    $(this).val("Login");
                } else {
                    $(".login-right").show();
                    $(".validation-right").hide();
                    $(this).val("Register");
                }
            });
            // Show forgot password form
            $("#forgot_password").click(function(e) {
                e.preventDefault(); // Prevent default anchor click behavior
                $(".login-right").hide(); // Hide login form
                $(".forgot-password-right").show(); // Show forgot password form
                $("#toggleLogin").val("Log In"); // Change register button text to "Log In"
            });

            // Show registration form after clicking Proceed
            $("#proceedToRegister").click(function() {
                var student_id = $("#student_id").val();

                // AJAX request to check if student ID exists
                $.ajax({
                    url: 'validate_student.php',
                    type: 'POST',
                    data: {
                        student_id: student_id
                    },
                    success: function(response) {
                        if (response === 'valid') {
                            $(".validation-right").hide();
                            $(".register-right").show();
                        } else {
                            $("#accessDeniedAlert").show();
                        }
                    }
                });
            });


        });
    </script>
    <script>

    </script>
</body>

</html>