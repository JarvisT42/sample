<?php
session_start();
include '../connection.php'; // Ensure you have your database connection
include '../connection2.php'; // Ensure you have your database connection

if (isset($_GET['student_id']) || isset($_GET['faculty_id']) || isset($_GET['walk_in_id'])) {
    $user_type = ''; // Initialize user type

    // Determine which ID is present and set the corresponding user type and ID
    if (isset($_GET['student_id'])) {
        $user_type = 'student';
        $user_id = htmlspecialchars($_GET['student_id']);
    } elseif (isset($_GET['faculty_id'])) {
        $user_type = 'faculty';
        $user_id = htmlspecialchars($_GET['faculty_id']);
    } elseif (isset($_GET['walk_in_id'])) {
        $user_type = 'walk_in';
        $user_id = htmlspecialchars($_GET['walk_in_id']);
    }

    // Fetch the category, book_id, issued date, and due date based on the user type
    $categoryQuery = "
        SELECT a.Category, a.book_id, a.Issued_Date, a.Due_Date, a.role, a.Way_Of_Borrow, a.accession_no
        FROM borrow AS a
        WHERE " . ($user_type === 'student' ? "a.student_id" : ($user_type === 'faculty' ? "a.faculty_id" : "a.walk_in_id")) . " = ? 
        AND status = 'lost'";

    $stmt = $conn->prepare($categoryQuery);
    $stmt->bind_param('i', $user_id); // Assuming user_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $books = $result->fetch_all(MYSQLI_ASSOC) ?: [];

    // Fetch user details for full name based on the user type
    if ($user_type === 'student') {
        // For students
        $userQuery = "
            SELECT First_Name, Middle_Initial, Last_Name 
            FROM students
            WHERE Student_Id = ?";
        $stmtUser = $conn->prepare($userQuery);
        $stmtUser->bind_param('i', $user_id);
        $stmtUser->execute();
        $userResult = $stmtUser->get_result();

        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $fullName = $userRow['First_Name'] . ' ' . $userRow['Middle_Initial'] . ' ' . $userRow['Last_Name'];
            $displayRole = "Student";
        } else {
            $fullName = 'Unknown Student';
            $displayRole = "Student";
        }
        $stmtUser->close();
    } elseif ($user_type === 'faculty') {
        // For faculty, include employment_status
        $userQuery = "
            SELECT First_Name, Middle_Initial, Last_Name, employment_status 
            FROM faculty
            WHERE Faculty_Id = ?";
        $stmtUser = $conn->prepare($userQuery);
        $stmtUser->bind_param('i', $user_id);
        $stmtUser->execute();
        $userResult = $stmtUser->get_result();

        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $fullName = $userRow['First_Name'] . ' ' . $userRow['Middle_Initial'] . ' ' . $userRow['Last_Name'];
            $displayRole = "Faculty (" . htmlspecialchars($userRow['employment_status']) . ")";
        } else {
            $fullName = 'Unknown Faculty';
            $displayRole = "Faculty";
        }
        $stmtUser->close();
    } else {
        // For walk-in users, get the name from the borrow table
        $fullNameQuery = "SELECT Full_Name, role FROM borrow WHERE walk_in_id = ?";
        $stmtWalkIn = $conn->prepare($fullNameQuery);
        $stmtWalkIn->bind_param('i', $user_id);
        $stmtWalkIn->execute();
        $walkInResult = $stmtWalkIn->get_result();

        if ($walkInResult->num_rows > 0) {
            $walkInRow = $walkInResult->fetch_assoc();
            $fullName = $walkInRow['Full_Name'];
            $displayRole = $walkInRow['role'];
        } else {
            $fullName = 'Unknown Walk-In';
            $displayRole = "Walk-In";
        }
        $stmtWalkIn->close();
    }
    $stmt->close();
} else {
    echo "No student, faculty, or walk-in ID provided.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['returnall'])) {
    if (isset($_POST['books']) && isset($_POST['user_id']) && isset($_POST['user_role'])) {


        $books = json_decode($_POST['books'], true);
        $userId = htmlspecialchars($_POST['user_id']);
        $userRole = htmlspecialchars($_POST['user_role']);
        $userColumn = ($userRole === 'student') ? 'student_id' : (($userRole === 'faculty') ? 'faculty_id' : 'walk_in_id');
        $success = true;
        $returnedDate = date('Y-m-d');

        $updateQuery = "UPDATE borrow 
                    SET status = 'returned', Return_Date = ? 
                    WHERE $userColumn = ? AND book_id = ? AND category = ? AND status = 'lost'";
        $stmt = $conn->prepare($updateQuery);

        $updateAccessionQuery = "UPDATE accession_records 
                             SET status = 'available', walk_in_id = NULL, user_id = NULL 
                             WHERE accession_no = ? AND " . ($userRole === 'walk-in' ? "walk_in_id" : "user_id") . " = ? AND status = 'lost'";
        $stmtAccession = $conn->prepare($updateAccessionQuery);

        foreach ($books as $book) {
            $book_id = $book['book_id'];
            $category = $book['category'];
            $accession_no = $book['accession_no'];

            if (!$stmt->bind_param('sisi', $returnedDate, $userId, $book_id, $category) || !$stmt->execute()) {
                $success = false;
                break;
            }

            if (!$stmtAccession->bind_param('si', $accession_no, $userId) || !$stmtAccession->execute()) {
                $success = false;
                break;
            }

            $bookAdditionSql = "UPDATE `$category` SET No_Of_Copies = No_Of_Copies + 1 WHERE id = ?";
            $stmtBookAddition = $conn2->prepare($bookAdditionSql);
            if (!$stmtBookAddition->bind_param('i', $book_id) || !$stmtBookAddition->execute()) {
                $success = false;
                break;
            }
            $stmtBookAddition->close();
        }

        $stmt->close();
        $stmtAccession->close();

        if ($success) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?{$userColumn}={$userId}&success=1");
        } else {
            echo 'Failed to return all books and update accession records.';
        }
    } else {
        echo 'Invalid request data.';
    }
} else {
    echo 'No action performed.';
}





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>

    <style>
        .active-replacement-books {
            background-color: #f0f0f0;
            color: #000;
        }

        .active-request {
            background-color: #f0f0f0;
            color: #000;
        }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>
    <main id="content" class="">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="bg-gray-100 p-6 w-full mx-auto">
                    <div class="bg-white p-4 shadow-sm rounded-lg mb-2">
                        <div class="bg-gray-100 p-2 flex justify-between items-center">
                            <h1 class="m-0">Student Name: <?php echo $fullName; ?></h1>

                        </div>
                    </div>

                    <?php if (!empty($books)): ?>
                        <?php
                        // Group books by Date_To_Claim
                        $grouped_books = [];
                        foreach ($books as $book) {
                            $date_to_claim = htmlspecialchars($book['Issued_Date']);
                            $grouped_books[$date_to_claim][] = $book;
                        }
                        ?>

                        <div id="book-request-form" class="space-y-6">

                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

                            <?php
                            // Initialize the overall index counter
                            $overall_index = 0;
                            ?>

                            <?php foreach ($grouped_books as $date => $books_group): ?>
                                <div class="bg-blue-200 p-4 rounded-lg">
                                    <div class="bg-blue-200 rounded-lg flex items-center justify-between ">
                                        <!-- Left side: Date to Claim -->
                                        <!-- <h3 class="text-lg font-semibold text-white">Issued Date: <?php echo $date; ?></h3> -->
                                    </div>

                                    <?php foreach ($books_group as $book): ?>
                                        <?php
                                        $category = $book['Category'];
                                        $book_id = $book['book_id'];

                                        // Fetch the Title, Author, and record_cover from conn2 based on book_id
                                        $titleQuery = "SELECT * FROM `$category` WHERE id = ?";
                                        $stmt2 = $conn2->prepare($titleQuery);
                                        $stmt2->bind_param('i', $book_id);
                                        $stmt2->execute();
                                        $result = $stmt2->get_result();

                                        // Initialize variables
                                        $title = 'Unknown Title';
                                        $author = 'Unknown Author';
                                        $status = 'Unknown Status';

                                        $record_cover = null; // Initialize with null

                                        if ($row = $result->fetch_assoc()) {
                                            $title = $row['Title']; // Get the title
                                            $author = $row['Author']; // Get the author
                                            $status = $row['Status']; // Get the author
                                            $record_cover = $row['record_cover']; // Get the record cover
                                        }

                                        $stmt2->close();
                                        include '../connection.php';

                                        // Get the fines value from the database
                                        $fines_value = 0;
                                        $sql = "SELECT fines FROM library_fines LIMIT 1";
                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $fines_value = (int)$row['fines'];
                                        }






                                        // Get the issued date from the book array
                                        $issued_date = $book['Issued_Date'];

                                        if (empty($book['Due_Date'])) {
                                            // Calculate the due date (3 days after the issued date)
                                            $due_date = date('Y-m-d', strtotime($issued_date . ' + 3 days'));
                                        } else {
                                            // Use the existing due date from $book['Due_Date']
                                            $due_date = $book['Due_Date'];
                                        }

                                        // Now $due_date has the correct value based on the conditions



                                        // Calculate the fines based on the due date
                                        $current_date = date('Y-m-d');
                                        $fine_amount = 0;

                                        if ($current_date > $due_date) {
                                            // Calculate overdue days
                                            $overdue_days = (strtotime($current_date) - strtotime($due_date)) / (60 * 60 * 24);
                                            $fine_amount = $overdue_days * $fines_value;
                                        }
                                        ?>

                                        <li class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mb-2 flex flex-col">
                                            <div class="flex-1">
                                                <div class="flex flex-col md:flex-row justify-between mb-6">
                                                    <div class="flex-1 mb-4 md:mb-0">
                                                        <h1 class="text-2xl font-bold mb-1">Title:</h1>
                                                        <p class="text-xl mb-4"><?php echo $title; ?> </p>
                                                        <h1 class="text-2xl font-bold mb-1">Author:</h1>
                                                        <p class="text-xl mb-4"><?php echo $author; ?> </p>
                                                        <div class="mb-4">
                                                            <h2 class="text-lg font-semibold text-gray-600 mb-1">Borrow Category:</h2>
                                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($book['Category']); ?></p>
                                                            <h3 class="text-lg font-semibold text-gray-600 mb-1">Accession no:</h3>
                                                            <p id="accession_no-<?php echo $overall_index; ?>" class="text-sm text-gray-500"><?php echo htmlspecialchars($book['accession_no']); ?></p>


                                                        </div>
                                                    </div>
                                                    <div class="w-full md:w-32 h-40 bg-gray-200 border border-gray-300 flex items-center justify-center mb-4 md:mb-0">
                                                        <?php
                                                        // Handle the image display
                                                        if (!empty($record_cover)) { // Use the fetched record_cover
                                                            $imageData = base64_encode($record_cover);
                                                            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                                        } else {
                                                            $imageSrc = 'path/to/default/image.jpg'; // Provide a default image source
                                                        }
                                                        ?>
                                                        <img src="<?php echo $imageSrc; ?>" alt="Book Cover" class="w-full h-full border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                                    </div>
                                                </div>
                                                <div class="bg-blue-100 p-4 rounded-lg">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4 hidden">
                                                        <div>
                                                            <p class="text-sm font-semibold">Issued Date:</p>
                                                            <p class="text-sm"><?php echo htmlspecialchars($book['Issued_Date']); ?></p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold">Due Date:</p>
                                                            <p class="text-sm due-date" data-index="<?php echo $overall_index; ?>"><?php echo htmlspecialchars($due_date); ?></p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end space-x-2 mt-4">


                                                        <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm return-button"
                                                            data-index="<?php echo $overall_index; ?>"
                                                            onclick="console.log('Replace clicked'); openReturnModal('<?php echo htmlspecialchars($title); ?>', '<?php echo htmlspecialchars($author); ?>', '<?php echo htmlspecialchars($category); ?>', '<?php echo $fine_amount; ?>', 'fineInput-<?php echo $overall_index; ?>', '<?php echo htmlspecialchars($student_id); ?>', '<?php echo htmlspecialchars($book_id); ?>', '<?php echo htmlspecialchars($book['accession_no']); ?>')">
                                                            Replace
                                                        </button>


                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                                        <div style="display: none;">
                                                            <p class="text-sm font-semibold">Renew</p>
                                                            <select class="renew-dropdown border border-gray-300 rounded p-1 mr-16" data-index="<?php echo $overall_index; ?>" data-due-date="<?php echo htmlspecialchars($due_date); ?>">
                                                                <option value="0">0 Days</option>
                                                                <option value="3">3 Days</option>
                                                                <option value="6">6 Days</option>
                                                                <option value="9">9 Days</option>
                                                                <option value="12">12 Days</option>
                                                                <option value="15">15 Days</option>
                                                            </select>
                                                        </div>
                                                        <div style="display: none;">
                                                            <p class="text-sm font-semibold">Book Status:</p>
                                                            <select id="statusSelect-<?php echo $overall_index; ?>" class="border border-gray-300 rounded p-1 mr-16" onchange="toggleFinesInput(<?php echo $overall_index; ?>)">
                                                                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                                <option value="Damage">Damage</option>
                                                                <option value="Lost">Lost</option>
                                                            </select>
                                                        </div>
                                                        <div style="display: none;">
                                                            <p class="text-sm font-semibold">Fines:</p>
                                                            <div class="flex items-center">
                                                                P:<input id="fineInput-<?php echo $overall_index; ?>" class="border border-gray-300 rounded p-1 w-32 finesInput" type="number" disabled placeholder="Disabled">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="damageTextArea-<?php echo $overall_index; ?>" style="display: none;" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                                        <div class="col-span-3">
                                                            <p class="text-sm font-semibold">Describe the Damage:</p>
                                                            <textarea id="damageDescription-<?php echo $overall_index; ?>" class="border border-gray-300 rounded p-2 w-full" rows="4" placeholder="Provide a description of the damage"></textarea>
                                                        </div>
                                                    </div>


                                                    <!-- Text area for damage description -->

                                                </div>
                                            </div>


                                        </li>





                                        <?php
                                        // Increment overall index for each book displayed
                                        $overall_index++;
                                        ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="flex items-center justify-end">
                                <button type="button" onclick="openReturnModal()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Return All</button>
                            </div>
                        </div>

                    <?php else: ?>
                        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                            <div id="alert" class="alert alert-success" role="alert">
                                Department added successfully!
                            </div>
                        <?php endif; ?>

                        <p>No books available.</p>
                    <?php endif; ?>


                </div>
            </div>
        </div>



        <div id="returnModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-semibold mb-4">Return Book(s)</h2>

                <!-- Form starts here -->
                <form id="returnForm" action="" method="post">
                    <!-- Display user ID and role in the modal -->
                    <p><strong>User ID:</strong> <span id="userIdDisplay"></span></p>
                    <input type="hidden" name="user_id" id="userIdInput">

                    <p><strong>User Role:</strong> <span id="userRoleDisplay"></span></p>
                    <input type="hidden" name="user_role" id="userRoleInput">

                    <p><strong>Number of Books to Replace:</strong> <span id="bookCount"></span></p>
                    <input type="hidden" name="book_count" id="bookCountInput">

                    <!-- Container for list of books -->
                    <div id="modalBookList" class="mt-4 mb-4"></div>
                    <input type="hidden" name="books" id="booksInput">

                    <!-- Form buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeReturnModal()" class="bg-red-500 text-white py-2 px-4 rounded">Close</button>
                        <button type="submit" name="returnall" class="bg-blue-500 text-white py-2 px-4 rounded">Confirm Return</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openReturnModal() {
                const userId = "<?php echo $user_id; ?>";
                const userRole = "<?php echo $user_type; ?>";
                const books = <?php echo json_encode($books); ?>;

                document.getElementById("returnModal").classList.remove("hidden");

                // Populate User ID and Role
                document.getElementById("userIdDisplay").textContent = userId || "Not Available";
                document.getElementById("userIdInput").value = userId;

                document.getElementById("userRoleDisplay").textContent = userRole.charAt(0).toUpperCase() + userRole.slice(1); // Capitalize first letter
                document.getElementById("userRoleInput").value = userRole;

                // Display the count of books
                document.getElementById("bookCount").textContent = books.length;
                document.getElementById("bookCountInput").value = books.length;

                // Populate the book details
                const modalBookList = document.getElementById("modalBookList");
                modalBookList.innerHTML = ''; // Clear previous entries
                books.forEach(book => {
                    const bookItem = document.createElement('p');
                    bookItem.innerHTML = `<strong>Title:</strong> ${book.Category} - <strong>Accession No:</strong> ${book.accession_no}`;
                    modalBookList.appendChild(bookItem);
                });

                // Serialize books data, including the book_id for each book
                document.getElementById("booksInput").value = JSON.stringify(books.map(book => ({
                    book_id: book.book_id,
                    category: book.Category,
                    accession_no: book.accession_no
                })));
            }

            function closeReturnModal() {
                document.getElementById("returnModal").classList.add("hidden");
            }
        </script>












    </main>


    <script>
    // Set a timeout to hide the alert after 3 seconds (3000 ms)
    setTimeout(function() {
        var alertElement = document.getElementById('alert');
        if (alertElement) {
        alertElement.style.display = 'none';
        }
    }, 4000);
    </script>
    <script src="./src/components/header.js"></script>

</body>

</html>