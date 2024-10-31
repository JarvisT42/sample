
<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $_SESSION['selected_date'] = $data['date'];
    $_SESSION['selected_time'] = $data['time'];

    // Return the selected data as a JSON response
    echo json_encode([
        'date' => $_SESSION['selected_date'],
        'time' => $_SESSION['selected_time']
    ]);
    exit;
}



?>