<?php
session_start();
include '../connection2.php'; // Ensure you have your database connection

// Check if `id` and `table` (category) exist in the URL
if (isset($_GET['id']) && isset($_GET['table'])) {
    $book_id = $_GET['id'];
    $category = $_GET['table'];
} else {
    // If no ID or table is provided, redirect to another page (like books.php)
    echo "<script>window.location.href='books.php';</script>";
    exit;
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form data
    $tracking_id = htmlspecialchars($_POST['tracking_id']);
    $call_number = htmlspecialchars($_POST['call_number']);
    $department = htmlspecialchars($_POST['department']);
    $title = htmlspecialchars($_POST['book_title']);
    $author = htmlspecialchars($_POST['author']);
    $publisher = htmlspecialchars($_POST['publisher_name']);
    $no_of_copies = intval($_POST['book_copies']);
    $date_of_publication = htmlspecialchars($_POST['date_of_publication_copyright']);
    $subjects = htmlspecialchars($_POST['subject']);
    $status = htmlspecialchars($_POST['status']);

    // Handle image upload
    $cover_image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Read the image file
        $cover_image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepare the SQL update query
    if ($cover_image) {
        // If a new image is uploaded, include record_cover in the update
        $sql = "UPDATE `$category` SET 
                    Tracking_Id = ?, 
                    Call_Number = ?, 
                    Department = ?, 
                    Title = ?, 
                    Author = ?, 
                    Publisher = ?, 
                    No_Of_Copies = ?, 
                    Date_Of_Publication_Copyright = ?, 
                    Subjects = ?, 
                    Status = ?, 
                    record_cover = ?
                WHERE id = ?";
        
        $stmt = $conn2->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssissssi", $tracking_id, $call_number, $department, $title, $author, $publisher, $no_of_copies, $date_of_publication, $subjects, $status, $cover_image, $book_id);
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error preparing update statement: " . $conn2->error]);
        }
    } else {
        // If no image is uploaded, update all fields except record_cover
        $sql = "UPDATE `$category` SET 
                    Tracking_Id = ?, 
                    Call_Number = ?, 
                    Department = ?, 
                    Title = ?, 
                    Author = ?, 
                    Publisher = ?, 
                    No_Of_Copies = ?, 
                    Date_Of_Publication_Copyright = ?, 
                    Subjects = ?, 
                    Status = ?
                WHERE id = ?";
        
        $stmt = $conn2->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssisssi", $tracking_id, $call_number, $department, $title, $author, $publisher, $no_of_copies, $date_of_publication, $subjects, $status, $book_id);
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error preparing update statement: " . $conn2->error]);
        }
    }

    // Execute the query and check if it was successful
    if ($stmt && $stmt->execute()) {
        echo "<script>alert('Book details updated successfully!'); window.location.href='books.php';</script>";
    } else {
        echo "<script>alert('Error updating book details.');</script>";
    }
}

// Prepare and execute the SQL query to fetch book details for the form (if not already POST request)
$sql = "SELECT * FROM `$category` WHERE id = ?";
$stmt = $conn2->prepare($sql);
$stmt->bind_param("i", $book_id); // Bind the book ID as an integer
$stmt->execute();
$result = $stmt->get_result();

// Fetch the book details if the record exists
if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
    $tracking_id = $book['Tracking_Id'];
    $call_number = $book['Call_Number'];
    $department = $book['Department'];
    $title = $book['Title'];
    $author = $book['Author'];
    $publisher = $book['Publisher'];
    $no_of_copies = $book['No_Of_Copies'];
    $date_of_publication = $book['Date_Of_Publication_Copyright'];
    $date_encoded = $book['Date_Encoded'];
    $subjects = $book['Subjects'];
    $status = $book['Status'];
} else {
    echo "<script>alert('No book found with this ID'); window.location.href='books.php';</script>";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<?php include 'admin_header.php'; ?>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <!-- Title Box -->
                <?php include './src/components/books.php'; ?>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
                    <ul class="flex flex-wrap gap-2 p-5 border border-dashed rounded-md w-full">
                        <li><a class="px-4 py-2" href="books.php">All</a></li>
                        <br>
                        <li><a class="px-4 py-2" href="add_books.php">Add Books</a></li>                        <br>

                        <li><a class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" href="edit_records.php">Edit Records</a></li>
                        <br>
                        <li><a href="damage.php">Damage Books</a></li>                        <br>

                        <li><a href="#">Subject for Replacement</a></li>
                    </ul>
                </div>

                <!-- Main Content Box -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 ">
                    <div class="w-full max-w-2xl mx-auto border border-black  rounded-t-lg">
                        <div class="bg-red-800 text-white rounded-t-lg">
                            <h2 class="text-lg font-semibold p-4">Edit Book Details</h2>
                        </div>
                        <div class="p-6 bg-white rounded-b-lg shadow-md">
                            <form id="editBookForm" class="space-y-4" method="POST" enctype="multipart/form-data">
                                <!-- Category -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="category" class="text-left">Category</label>
                                    <input id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" class="col-span-2 border rounded px-3 py-2" readonly />
                                </div>

                                <!-- Tracking ID -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="tracking_id" class="text-left">Tracking Id</label>
                                    <input id="tracking_id" name="tracking_id" value="<?php echo htmlspecialchars($tracking_id); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Call Number -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="call_number" class="text-left">CALL NUMBER:</label>
                                    <input id="call_number" name="call_number" value="<?php echo htmlspecialchars($call_number); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Department -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="department" class="text-left">DEPARTMENT:</label>
                                    <input id="department" name="department" value="<?php echo htmlspecialchars($department); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Book Title -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="book_title" class="text-left">BOOK TITLE:</label>
                                    <input id="book_title" name="book_title" value="<?php echo htmlspecialchars($title); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Author -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="author" class="text-left">AUTHOR:</label>
                                    <input id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Date of Publication -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                <label for="date_of_publication_copyright" class="text-left">Date of Publication:</label>
                                    <input id="date_of_publication_copyright" name="date_of_publication_copyright" value="<?php echo htmlspecialchars($date_of_publication); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Number of Copies -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="book_copies" class="text-left">BOOK COPIES:</label>
                                    <input id="book_copies" name="book_copies" type="number" value="<?php echo htmlspecialchars($no_of_copies); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Publisher Name -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="publisher_name" class="text-left">PUBLISHER NAME:</label>
                                    <input id="publisher_name" name="publisher_name" value="<?php echo htmlspecialchars($publisher); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Subject -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="subject" class="text-left">SUBJECT:</label>
                                    <input id="subject" name="subject" value="<?php echo htmlspecialchars($subjects); ?>" class="col-span-2 border rounded px-3 py-2" />
                                </div>

                                <!-- Image Upload -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="image" class="text-left">UPLOAD IMAGE:</label>
                                    <input type="file" id="image" name="image" accept="image/*" class="col-span-2 border rounded" />
                                </div>

                                <!-- Status -->
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="status" class="text-left">STATUS:</label>
                                    <select id="status" name="status" class="col-span-2 border rounded px-3 py-2">
                                        <option value="" disabled>Select status</option>
                                        <option value="new" <?php echo $status == 'new' ? 'selected' : ''; ?>>New</option>
                                        <option value="old" <?php echo $status == 'old' ? 'selected' : ''; ?>>Old</option>
                                        <option value="damage" <?php echo $status == 'damage' ? 'selected' : ''; ?>>Damage</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./src/components/header.js"></script>
</body>
</html>
