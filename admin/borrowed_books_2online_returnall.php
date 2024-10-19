<?php
include '../connection.php'; // Ensure you have your database connection

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['student_id']) && !empty($data['books'])) {
    $student_id = $data['student_id'];
    $books = $data['books']; // Array of books containing book_id, category, and total_fines

    $success = true;
    
    // Prepare the update query
    $updateQuery = "UPDATE borrow SET status = 'returned', Total_Fines = ? WHERE student_id = ? AND book_id = ? AND category = ?";
    $stmt = $conn->prepare($updateQuery);

    foreach ($books as $book) {
        $total_fines = $book['total_fines'];
        $book_id = $book['book_id'];
        $category = $book['category'];

        // Bind the parameters and execute the query
        if (!$stmt->bind_param('diis', $total_fines, $student_id, $book_id, $category) || !$stmt->execute()) {
            $success = false;
            break;
        }
    }

    $stmt->close();

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to return all books.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
}
?>
