<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : '';
    $fullName = isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '';
    $dueDate = isset($_POST['due_date']) ? htmlspecialchars($_POST['due_date']) : '';
    $accessionNos = isset($_POST['accession_no']) ? $_POST['accession_no'] : []; // array of accession numbers

    if (isset($_SESSION['book_bag']) && count($_SESSION['book_bag']) > 0) {
        $bookBag = $_SESSION['book_bag'];

        // Retrieve and increment the walk_in_id with a prefix "w-"
        $sqlMaxId = "SELECT MAX(CAST(SUBSTRING(walk_in_id, 3) AS UNSIGNED)) AS max_id FROM walk_in_borrowers WHERE walk_in_id LIKE 'w-%'";
        $result = $conn->query($sqlMaxId);
        if ($result) {
            $row = $result->fetch_assoc();
            $numeric_id = $row['max_id'] ? $row['max_id'] + 1 : 1;
            $walk_in_id = "w-" . $numeric_id; // Add the prefix
        } else {
            die("Error fetching walk_in_id: " . $conn->error);
        }

        // Insert into walk_in_borrowers table
        $sql = "INSERT INTO walk_in_borrowers (walk_in_id, full_name, Role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $walk_in_id, $fullName, $role);
        if (!$stmt->execute()) {
            die("Error inserting into walk_in_borrowers: " . $stmt->error);
        }

        // Insert each book from book bag into borrow table with the corresponding accession_no
        foreach ($bookBag as $index => $book) {
            $bookId = htmlspecialchars($book['id']);
            $category = htmlspecialchars($book['table']);
            $accessionNo = isset($accessionNos[$bookId]) ? htmlspecialchars($accessionNos[$bookId]) : null; // use specific accession_no for this book

            if ($accessionNo) {
                $sql = "INSERT INTO borrow (role, walk_in_id, accession_no, book_id, Category, date_to_claim, Issued_Date, Due_Date, Way_Of_Borrow, status) 
                VALUES (?, ?, ?, ?, ?, CURDATE(), CURDATE(), ?, 'Walk-in', 'Borrowed')";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $role, $walk_in_id, $accessionNo, $bookId, $category, $dueDate);

                if (!$stmt->execute()) {
                    die("Error inserting into borrow: " . $stmt->error);
                }
            } else {
                die("Error: Missing accession number for book ID $bookId.");
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Books successfully borrowed."]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "Book bag is empty!"]);
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => "Invalid request method!"]);
}
