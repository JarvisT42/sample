<?php
session_start();

if (!isset($_SESSION['book_bag'])) {
    $_SESSION['book_bag'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $bookId = $_POST['bookId'] ?? '';

    if ($action === 'add' && !empty($bookId)) {
        if (!in_array($bookId, $_SESSION['book_bag'])) {
            $_SESSION['book_bag'][] = $bookId;
        }
    } elseif ($action === 'remove' && !empty($bookId)) {
        $_SESSION['book_bag'] = array_diff($_SESSION['book_bag'], [$bookId]);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
