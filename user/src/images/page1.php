<?php
include 'start_session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 1</title>
</head>
<body>
    <form action="page2.php" method="post">
        <h1>Select an Option</h1>
        <input type="radio" name="option" value="Option1"> Option 1<br>
        <input type="radio" name="option" value="Option2"> Option 2<br>
        <input type="radio" name="option" value="Option3"> Option 3<br>
        <button type="submit">Next</button>
    </form>
</body>
</html>
