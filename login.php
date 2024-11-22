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
    $loginError = false; // Flag to manage error display
    $loginMessage = ""; // Variable for custom error messages

    // Check in the students table first
    $stmt = $conn->prepare("SELECT * FROM students WHERE Email_Address = ? AND status != 'inactive' AND status != 'banned'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student found, verify password
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        if (password_verify($password, $hashed_password)) {
            // Successful student login
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["Student_Id"] = $row['Student_Id'];
            $_SESSION["First_Name"] = $row['First_Name'];
            $_SESSION["Middle_Initial"] = $row['Middle_Initial'];
            $_SESSION["Last_Name"] = $row['Last_Name'];
            $_SESSION['email'] = $row['Email_Address'];
            $_SESSION['phoneNo.'] = $row['mobile_number'];
            $_SESSION['first_login'] = true;



            header("Location: user/dashboard.php");
            exit();
        } else {
            $loginError = true;
            $loginMessage = "Incorrect password for student account.";
        }
    } else {
        // No student found, check in faculty table
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM faculty WHERE Email_Address = ? AND status != 'inactive' AND status != 'banned'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Faculty found, verify password
            $row = $result->fetch_assoc();
            $hashed_password = $row['Password'];

            if (password_verify($password, $hashed_password)) {
                // Successful faculty login
                $_SESSION["loggedin"] = TRUE;
                $_SESSION["Faculty_Id"] = $row['Faculty_Id'];
                $_SESSION["First_Name"] = $row['First_Name'];
                $_SESSION["Middle_Initial"] = $row['Middle_Initial'];
                $_SESSION["Last_Name"] = $row['Last_Name'];
                $_SESSION['email'] = $row['Email_Address'];
                $_SESSION['phoneNo.'] = $row['mobile_number'];

                header("Location: faculty/dashboard.php");
                exit();
            } else {
                $loginError = true;
                $loginMessage = "Incorrect password for faculty account.";
            }
        } else {
            // No faculty found, check in admin table
            $stmt->close();
            $stmt = $conn->prepare("SELECT * FROM admin_account WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Admin found, verify password
                $row = $result->fetch_assoc();
                $hashed_password = $row['Password'];

                if (password_verify($password, $hashed_password)) {
                    // Successful admin login
                    $_SESSION["logged_Admin"] = TRUE;
                    $_SESSION["Id"] = $row['id'];
                    $_SESSION["Full_Name"] = $row['Full_Name'];

                    // Check role_id in admin_account and retrieve role_name from roles table
                    $role_id = $row['role_id'];
                    $stmt->close();

                    // Fetch role_name from roles table
                    $stmt = $conn->prepare("SELECT role_name FROM roles WHERE role_id = ?");
                    $stmt->bind_param("i", $role_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $role_row = $result->fetch_assoc();
                        $role_name = $role_row['role_name'];

                        // Redirect based on role_name
                        if ($role_name === "super-admin" || $role_name === "admin") {
                            header("Location: admin/dashboard.php");
                        } elseif ($role_name === "assistant") {
                            header("Location: admin inventory manager/dashboard.php");
                        } else {
                            // Default redirection or error handling if role_name doesn't match
                            $loginError = true;
                            $loginMessage = "Role not recognized.";
                        }
                        exit();
                    } else {
                        // Role not found in roles table
                        $loginError = true;
                        $loginMessage = "Role not found for admin account.";
                    }
                } else {
                    $loginError = true;
                    $loginMessage = "Incorrect password for admin account.";
                }
            } else {
                // No student, faculty, or admin found with that email
                $loginError = true;
                $loginMessage = "No account found with that email.";
            }
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_register'])) {
    include 'connection.php';

    // Get form inputs
    $validated_student_id = $conn->real_escape_string($_POST['validated_student_id'] ?? '');
    $firstName = $conn->real_escape_string($_POST['First_Name'] ?? '');
    $middleInitial = $conn->real_escape_string($_POST['Middle_Initial'] ?? '');
    $lastName = $conn->real_escape_string($_POST['Last_Name'] ?? '');
    $suffixName = $conn->real_escape_string($_POST['Suffix_Name'] ?? '');
    $email = $conn->real_escape_string($_POST['Email_Address'] ?? '');
    $gender = $conn->real_escape_string($_POST['S_Gender'] ?? '');
    $dateOfJoining = date('Y-m-d');
    $course_id = (int) ($_POST['course_id'] ?? 0); // Ensure course_id is an integer
    $idNumber = $conn->real_escape_string($_POST['Id_Number'] ?? '');
    $mobileNumber = $conn->real_escape_string($_POST['Mobile_Number'] ?? '');
    $yearLevel = $conn->real_escape_string($_POST['Year_Level'] ?? '');
    $password = $_POST['Password'] ?? '';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Debugging: Echo the data being processed


    // Prepare SQL statement
    $sql = "INSERT INTO students (Student_Id, First_Name, Middle_Initial, Last_Name, Suffix_Name, Email_Address, course_id, S_Gender, date_of_joining, Mobile_Number, Year_Level, Password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param(
        "ssssssssssss",
        $validated_student_id,
        $firstName,
        $middleInitial,
        $lastName,
        $suffixName,
        $email,
        $course_id,
        $gender,
        $dateOfJoining,
        $mobileNumber,
        $yearLevel,
        $hashed_password
    );

    // Execute the query
    if ($stmt->execute()) {
        $updateStmt = $conn->prepare("UPDATE students_ids SET status = 'Taken' WHERE student_id = ?");
        $updateStmt->bind_param("s", $validated_student_id);

        if ($updateStmt->execute()) {
            echo "<script>alert('Student registered successfully ');</script>";
        } else {
            echo "Error updating student status: " . $updateStmt->error;
        }

        $updateStmt->close();
    } else {
        echo "Error registering student: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['faculty_register'])) {
    include 'connection.php';

    // Capture form input and validated faculty ID
    $faculty_id = $_POST['validated_faculty_id'] ?? null; // Capture validated faculty_id
    $firstName = $conn->real_escape_string($_POST['firstname']);
    $middleInitial = $conn->real_escape_string($_POST['middlename']);
    $lastName = $conn->real_escape_string($_POST['lastname']);
    $suffixName = $conn->real_escape_string($_POST['suffix']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobileNumber = $conn->real_escape_string($_POST['txtEmpPhone']);
    $department = $conn->real_escape_string($_POST['department']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dateOfJoining = date('Y-m-d'); // Auto set to current date
    $employmentStatus = $conn->real_escape_string($_POST['employment_status']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check for matching passwords
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the data, including faculty_id, into the faculty table
    $stmt = $conn->prepare("INSERT INTO faculty (Faculty_Id, First_Name, Middle_Initial, Last_Name, Suffix_Name, Email_Address, S_Gender, date_of_joining, S_Course, Mobile_Number, Password, employment_status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $faculty_id, $firstName, $middleInitial, $lastName, $suffixName, $email, $gender, $dateOfJoining, $department, $mobileNumber, $hashed_password, $employmentStatus);

    if ($stmt->execute()) {
        // Update faculty_id table with the validated faculty ID
        $updateStmt = $conn->prepare("UPDATE faculty_ids SET status = 'Taken' WHERE faculty_id = ?");
        $updateStmt->bind_param("s", $faculty_id);
        $updateStmt->execute();

        echo "<script>alert('Faculty registered successfully!');</script>";
        $updateStmt->close();
    } else {
        echo "Error: " . $stmt->error;
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
    <style>

    </style>

    </style>
</head>

<body>
    <div class="container sign-in-up">
        <div class="row">
            <div class="col-md-3 register-left ">
                <img src="src/assets/images/icon-gfi-book.png" alt="" />
                <h3>Welcome</h3>
                <p>GFI's Online Library</p>
                <input type="button" id="toggleLogin" value="Register" /><br />
            </div>

            <div class="col-md-9 login-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form id="loginForm" class="student" method="POST" action="">
                            <h3 class="login-heading">Login Account</h3>
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
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Your Password *" required />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePasswordVisibility()">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group d-flex justify-content-between">
                                            <label class="form-check-label">
                                                <input type="checkbox" id="rememberMe" name="rememberMe" onclick="handleRememberMe()" />
                                                Remember Me
                                            </label>
                                            <div class="">
                                                <a id="forgot_password" href="#" role="tab" aria-controls="ForgotPassword" aria-selected="false">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" style="display: <?php echo $loginError ? 'block' : 'none'; ?>;">
                                        <?php echo isset($loginMessage) ? $loginMessage : ''; ?>
                                    </div>

                                    <input type="submit" class="btnlogin" name="student_login" value="Login" />

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function togglePasswordVisibility() {
                    const passwordInput = document.getElementById('password');
                    const toggleIcon = document.getElementById('togglePasswordIcon');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                }

                function handleRememberMe() {
                    const rememberMeCheckbox = document.getElementById('rememberMe');

                    if (rememberMeCheckbox.checked) {
                        // Save email and password to localStorage for simplicity (avoid for sensitive data)
                        const email = document.querySelector('input[name="email"]').value;
                        const password = document.querySelector('input[name="password"]').value;

                        localStorage.setItem('rememberMe', 'true');
                        localStorage.setItem('email', email);
                        localStorage.setItem('password', password);
                    } else {
                        // Clear localStorage if "Remember Me" is unchecked
                        localStorage.removeItem('rememberMe');
                        localStorage.removeItem('email');
                        localStorage.removeItem('password');
                    }
                }

                // Populate email and password if "Remember Me" was previously checked
                window.onload = function() {
                    if (localStorage.getItem('rememberMe') === 'true') {
                        document.getElementById('rememberMe').checked = true;
                        document.querySelector('input[name="email"]').value = localStorage.getItem('email') || '';
                        document.querySelector('input[name="password"]').value = localStorage.getItem('password') || '';
                    }
                };
            </script>

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
                <form id="registrationStudentForm" class="register" method="POST" action="login.php">
                    <h3 class="register-heading">Student Library Registration</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="hidden" name="validated_student_id" id="validated_student_id" />

                                    <input type="text" name="First_Name" class="form-control" placeholder="First Name *" required />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="Middle_Initial" class="form-control" placeholder="MI" style="max-width: 50px;" />


                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="Last_Name" class="form-control" placeholder="Last Name *" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    </div>
                                    <input type="text" name="Suffix_Name" class="form-control" placeholder="Suffix (e.g., Jr., Sr.)" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="Email_Address" class="form-control" placeholder="Your Email *" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" minlength="10" maxlength="11" name="Mobile_Number" class="form-control" placeholder="Your Phone *" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="Year_Level" class="form-control">
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
        <select class="form-control" name="course_id" id="course_id" required>
            <option value="" disabled selected>Course</option>
            <?php
            // Include your database connection
            include 'connection.php';

            // Fetch all courses from the database
            $sql = "SELECT course_id, course FROM course";
            $result = $conn->query($sql);

            // Check if there are any courses available
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['course_id']) . '">' . htmlspecialchars($row['course']) . '</option>';
                }
            } else {
                echo '<option disabled>No courses available</option>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </select>
    </div>
</div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="maxl">
                                    <label class="radio inline">
                                        <input type="radio" name="S_Gender" value="male" checked>
                                        <span class="radio-label"> Male </span>
                                    </label>
                                    <label class="radio inline">
                                        <input type="radio" name="S_Gender" value="female">
                                        <span class="radio-label"> Female </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="Password" id="student_password" class="form-control" placeholder="Password *" />
                                </div>
                            </div>
                        </div>





                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>

                                    <input type="password" name="confirm_password" id="student_confirm_password" class="form-control" placeholder="Confirm Password *" required />
                                </div>
                            </div>
                        </div>

                        <div id="studentPasswordAlert" class="alert alert-danger" style="display: none;">
                            Passwords do not match. Please re-enter.
                        </div>

                        <div class="col-md-10">
                            <input type="hidden" name="Register_Status" value="Pending" />
                            <input type="submit" class="btnRegister" name="student_register" value="Register" />
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-9 registerFaculty-right" style="display: none;">
                <form id="registrationFacultyForm" class="register" method="POST" action="">
                    <h3 class="register-heading">Faculty Library Registration</h3>
                    <div class="row register-form">
                        <!-- First Name and Middle Name Fields -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="firstname" class="form-control" placeholder="First Name *" />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="middlename" class="form-control" placeholder="MI" style="max-width: 50px;" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="lastname" class="form-control" placeholder="Last Name *" />
                                </div>
                            </div>
                        </div>

                        <!-- Suffix Field -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    </div>
                                    <input type="text" name="suffix" class="form-control" placeholder="Suffix (e.g., Jr., Sr.)" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Your Email *" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" minlength="10" maxlength="10" name="txtEmpPhone" class="form-control" placeholder="Your Phone *" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?php
                            // Include your database connection
                            include 'connection.php'; // Adjust the path as needed

                            // Fetch all courses from the database
                            $sql = "SELECT course_id, course FROM course";
                            $result = $conn->query($sql);

                            // Check if there are any courses available
                            $courses = [];
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $courses[] = $row['course'];
                                }
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                            <div class="form-group">
                                <select class="form-control" name="department" id="department">
                                    <option class="hidden" selected disabled>Department</option>
                                    <?php
                                    // Loop through the courses array and display each course as an option
                                    if (!empty($courses)) {
                                        foreach ($courses as $course) {
                                            echo '<option>' . htmlspecialchars($course) . '</option>';
                                        }
                                    } else {
                                        echo '<option disabled>No courses available</option>';
                                    }
                                    ?>
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
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <select name="employment_status" class="form-control" required>
                                        <option class="hidden" selected disabled>Employment Status</option>
                                        <option value="full_time">Full-time</option>
                                        <option value="part_time">Part-time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="faculty_password" class="form-control" placeholder="Password *" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="confirm_password" id="faculty_confirm_password" class="form-control" placeholder="Confirm Password *" required />

                                </div>
                            </div>
                        </div>





                        <div id="facultyPasswordAlert" class="alert alert-danger" style="display: none;">
                            Passwords do not match. Please re-enter.
                        </div>


                        <div class="col-md-10">
                            <input type="hidden" name="validated_faculty_id" id="validated_faculty_id" />
                            <input type="submit" class="btnRegister" name="faculty_register" value="Register" />
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
    <script>
        // Student Form Validation
        document.getElementById('registrationStudentForm').addEventListener('submit', function(event) {
            var password = document.getElementById('student_password').value;
            var confirmPassword = document.getElementById('student_confirm_password').value;
            var passwordAlert = document.getElementById('studentPasswordAlert');

            if (password !== confirmPassword) {
                passwordAlert.style.display = 'block';
                event.preventDefault();
            } else {
                passwordAlert.style.display = 'none';
            }
        });

        // Faculty Form Validation
        document.getElementById('registrationFacultyForm').addEventListener('submit', function(event) {
            var password = document.getElementById('faculty_password').value;
            var confirmPassword = document.getElementById('faculty_confirm_password').value;
            var passwordAlert = document.getElementById('facultyPasswordAlert');

            if (password !== confirmPassword) {
                passwordAlert.style.display = 'block';
                event.preventDefault();
            } else {
                passwordAlert.style.display = 'none';
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            const lockoutDurations = [1, 3, 8, 60]; // Lockout durations in minutes
            let attempts = 0; // Number of failed attempts
            let lockoutEndTime = 0; // Timestamp when the user can retry

            // Toggle between login and registration forms
            $("#toggleLogin").click(function() {
                // Hide forms and reset input fields
                $(".validation-right").hide();
                $(".register-right").hide();
                $(".registerFaculty-right").hide(); // Ensure faculty registration is hidden
                $(".forgot-password-right").hide(); // Hide forgot password form
                $("#validationForm")[0].reset(); // Reset validation form
                $("#registrationStudentForm")[0].reset(); // Reset student registration form
                $("#registrationFacultyForm")[0].reset(); // Reset faculty registration form

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
                const student_id = $("#student_id").val();
                const currentTime = new Date().getTime(); // Current timestamp

                // Check if user is in lockout period
                if (currentTime < lockoutEndTime) {
                    const remainingTime = Math.ceil((lockoutEndTime - currentTime) / 1000);
                    $("#accessDeniedAlert").text(`Please wait ${remainingTime} seconds before retrying.`).show();
                    return;
                }

                // Reset lockout message
                $("#accessDeniedAlert").hide();

                // AJAX request to validate student ID
                $.ajax({
                    url: 'validate_student.php',
                    type: 'POST',
                    data: {
                        student_id: student_id
                    },
                    success: function(response) {
                        if (response === 'show_student_registration') {
                            // Show student registration form
                            $("#validated_student_id").val(student_id);
                            $(".validation-right").hide();
                            $(".register-right").show();
                            attempts = 0; // Reset attempts on successful validation
                        } else if (response === 'show_faculty_registration') {
                            // Show faculty registration form
                            $("#validated_faculty_id").val(student_id);
                            $(".validation-right").hide();
                            $(".registerFaculty-right").show();
                            attempts = 0; // Reset attempts on successful validation
                        } else if (response === 'already_registered') {
                            // Show already registered message
                            $("#accessDeniedAlert").text("Student ID is already registered").show();
                        } else {
                            // Increment attempts only after free attempts are exhausted
                            if (attempts >= 3) {
                                // Apply lockout durations
                                if (attempts - 3 >= lockoutDurations.length) {
                                    // Set lockout to max duration if attempts exceed the array length
                                    lockoutEndTime =
                                        currentTime +
                                        lockoutDurations[lockoutDurations.length - 1] * 60 * 1000;
                                    attempts = 3; // Keep attempts at 3 during max lockout period
                                } else {
                                    // Set lockout time based on the current attempt's lockout duration
                                    lockoutEndTime = currentTime + lockoutDurations[attempts - 3] * 60 * 1000;
                                }

                                // Show lockout message with time in minutes
                                const lockoutMinutes = Math.ceil(
                                    (lockoutEndTime - currentTime) / 1000 / 60
                                );
                                $("#accessDeniedAlert")
                                    .text(`Max attempts reached. Please wait ${lockoutMinutes} minute(s) before retrying.`)
                                    .show();
                            } else {
                                // Increment attempts during free attempts
                                attempts++;
                                $("#accessDeniedAlert").text("Incorrect  ID No.").show();
                            }
                        }
                    },
                    error: function() {
                        // Show error message
                        $("#accessDeniedAlert").text("An error occurred. Please try again.").show();
                    },
                });
            });

        });
    </script>




    <script>

    </script>
</body>

</html>