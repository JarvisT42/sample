<?php
session_start();

include '../connection.php'; // Ensure this defines $conn
include '../connection2.php'; // Ensure this defines $conn2 for the second database

// Log request data for debugging
file_put_contents('debug_log.txt', print_r(file_get_contents('php://input'), true), FILE_APPEND);

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if essential fields are provided
    if (!isset($data['book_id'], $data['category'], $data['user_type'], $data['user_id'], $data['accession_no'])) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
        exit;
    }

    // Sanitize input data
    $bookId = htmlspecialchars($data['book_id']);
    $category = htmlspecialchars($data['category']);
    $fineAmount = isset($data['fineAmount']) ? (float)$data['fineAmount'] : 0;
    $userId = htmlspecialchars($data['user_id']);
    $userType = htmlspecialchars($data['user_type']);
    $accessionNo = htmlspecialchars($data['accession_no']);
    $expectedReplacementDate = htmlspecialchars($data['expected_replacement_date']);

    // Determine the user column and binding type based on user type
    $userColumn = '';
    $bindType = ''; // Variable to set the bind type for user_id

    if ($userType === 'student') {
        $userColumn = 'student_id';
        $bindType = 'i'; // integer
    } elseif ($userType === 'faculty') {
        $userColumn = 'faculty_id';
        $bindType = 'i'; // integer
    } elseif ($userType === 'walk_in') {
        $userColumn = 'walk_in_id';
        $bindType = 's'; // string
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user type.']);
        exit;
    }

    // Prepare the query to update the borrow table
    $updateBorrowQuery = "
        UPDATE borrow 
        SET status = 'lost', Total_Fines = ?, expected_replacement_date = ? 
        WHERE $userColumn = ? AND book_id = ? AND category = ? AND status = 'borrowed'
    ";

    $stmtBorrow = $conn->prepare($updateBorrowQuery);
    if ($stmtBorrow === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing the borrow update statement.']);
        exit;
    }

    // Bind parameters for the borrow update based on user type
    if ($bindType === 'i') {
        $stmtBorrow->bind_param('dsiis', $fineAmount, $expectedReplacementDate, $userId, $bookId, $category);
    } else {
        $stmtBorrow->bind_param('dsssi', $fineAmount, $expectedReplacementDate, $userId, $bookId, $category);
    }

    // Prepare the query to update the accession table
    $updateAccessionQuery = "
        UPDATE accession_records 
        SET status = 'lost', available = 'no' 
        WHERE accession_no = ? AND borrower_id = ? AND book_id = ? AND status = 'borrowed'
    ";

    $stmtAccession = $conn->prepare($updateAccessionQuery);
    if ($stmtAccession === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing the accession update statement.']);
        $stmtBorrow->close();
        exit;
    }

    // Bind parameters and execute the accession update
    $stmtAccession->bind_param('sii', $accessionNo, $userId, $bookId);

    // Execute both statements and check success
    if ($stmtBorrow->execute() && $stmtAccession->execute()) {
        echo json_encode(['success' => true, 'message' => 'Replacement processed successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing the replacement update.']);
    }

    // Close statements
    $stmtBorrow->close();
    $stmtAccession->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
