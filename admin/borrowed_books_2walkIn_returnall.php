<?php
include '../connection.php'; // Ensure you have your database connection

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['walk_in_id']) && !empty($data['books'])) {
    $walk_in_id = $data['walk_in_id'];
    $books = $data['books']; // Array of books containing book_id, category, and total_fines

    $success = true;
    
    $returnedDate = date('Y-m-d');


    // Prepare the update query
    $updateQuery = "UPDATE borrow SET status = 'returned', Total_Fines = ?, Return_Date = ? WHERE walk_in_id = ? AND book_id = ? AND category = ?";
    $stmt = $conn->prepare($updateQuery);

    foreach ($books as $book) {
        $total_fines = $book['total_fines'];
        $book_id = $book['book_id'];
        $category = $book['category'];

        // Bind the parameters and execute the query
        if (!$stmt->bind_param('dsisi', $total_fines, $returnedDate, $walk_in_id, $book_id, $category) || !$stmt->execute()) {

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
