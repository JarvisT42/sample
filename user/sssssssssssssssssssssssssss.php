<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Selected Date and Time</title>
</head>
<body>
    <h1>Selected Appointment Details</h1>
    
    <?php if (isset($_SESSION['selected_date'], $_SESSION['selected_time'], $_SESSION['appointment_id'])): ?>
        <p><strong>Appointment ID:</strong> <?php echo htmlspecialchars($_SESSION['appointment_id']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($_SESSION['selected_date']); ?></p>
        <p><strong>Time:</strong> <?php echo htmlspecialchars($_SESSION['selected_time']); ?></p>
    <?php else: ?>
        <p>No appointment details selected.</p>
    <?php endif; ?>
</body>
</html>
