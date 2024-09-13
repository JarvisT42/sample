<?php
include 'start_session.php';

// Save the selected option in the session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['selectedOption'] = $_POST['option'];


}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['other'] = $_POST['bmr'];


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 2</title>
</head>
<body>
    <h1>Confirm Your Selection</h1>
    <p>Selected Option: <?php echo isset($_SESSION['selectedOption']) ? htmlspecialchars($_SESSION['selectedOption']) : 'None'; ?></p>
    <form action="save.php" method="post">
        <button type="submit">Save</button>
    </form>
</body>
</html>
