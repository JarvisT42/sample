<?php
session_start();
include '../connection2.php'; // Ensure you have your database connection
include '../connection.php'; // Ensure you have your database connection

// Retrieve the book_id and category from the URL parameters
if (isset($_GET['id']) && isset($_GET['table'])) {
    $book_id = $_GET['id'];
    $category = $_GET['table'];
} else {
    // Redirect or show error if parameters are missing
    echo "Error: Missing book ID or category.";
    exit;
}



if (isset($_POST['mark_as_repaired'])) {
    // Get data from the POST request
    $book_id = $_POST['book_id'];
    $category = $_POST['category'];
    $accession_no = $_POST['accession_no'];
    $repair_description = $_POST['repair_description'];

    // Update the accession record with the repair status and description
    $repair_sql = "UPDATE accession_records SET repaired = 'yes', repair_description = ?, available = 'yes' WHERE accession_no = ? AND book_id = ? AND book_category = ?";
    $repair_stmt = $conn->prepare($repair_sql);
    $repair_stmt->bind_param("ssis", $repair_description, $accession_no, $book_id, $category);
    $repair_stmt->execute();

    // Redirect to the current page with success message
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $book_id . "&table=" . $category . "&repair_success=1");
    exit();
} else {
    // Return error if 'mark_as_repaired' is not set
    echo 'Invalid request.';
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

                <?php if (isset($_GET['repair_success']) && $_GET['repair_success'] == 1): ?>
    <div id="alert" class="alert alert-success" role="alert" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        Update successful!
    </div>
<?php endif; ?>


                <!-- Form for displaying accession numbers only -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                    <div class="w-full max-w-2xl mx-auto border border-black rounded-t-lg">
                        <div class="bg-red-800 text-white rounded-t-lg">
                            <h2 class="text-lg font-semibold p-4">Accession Numbers</h2>
                        </div>
                        <div class="p-6 bg-white rounded-b-lg shadow-md">


                        <form id="accessionNumbersForm" class="space-y-4" method="POST" enctype="multipart/form-data">
    <div class="grid grid-cols-3 items-start gap-4">
        <label for="accession_no" class="text-left">ACCESSION NUMBERS:</label>
        <div class="col-span-2 border rounded px-3 py-2 bg-gray-50 space-y-2">
            <?php
            // Query to fetch accession numbers and repair descriptions based on book_id and category
            $accession_sql = "SELECT accession_no, repair_description FROM accession_records WHERE book_id = ? AND book_category = ? AND repaired != 'yes'";
            $accession_stmt = $conn->prepare($accession_sql);

            if ($accession_stmt) {
                $accession_stmt->bind_param("is", $book_id, $category);
                $accession_stmt->execute();
                $accession_result = $accession_stmt->get_result();

                if ($accession_result->num_rows > 0) {
                    // Display each accession number with a "Repair" button and repair description textarea
                    while ($accession_row = $accession_result->fetch_assoc()) {
                        $accession_no = htmlspecialchars($accession_row['accession_no']);
                        $repair_description = htmlspecialchars($accession_row['repair_description']); // Get the repair description

                        echo "<div class='flex flex-col gap-2'>";
                        
                        // Display Accession Number
                        echo "<input type='text' name='accession_no[]' value='$accession_no' class='w-full border rounded px-2 py-1' readonly />";
                        
                        // Repair Description Textarea - pre-fill with the existing description if available
                        echo "<textarea name='repair_description[]' placeholder='Enter repair description here...' class='w-full border rounded px-2 py-1'>$repair_description</textarea>";
                        
                        // Repair Button
                        echo "<button type='button' onclick='markAsRepaired(\"$accession_no\")' class='px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600'>Repair</button>";
                        
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-gray-500'>No accession numbers available.</p>";
                }
            } else {
                echo "<p class='text-red-500'>Error fetching accession numbers.</p>";
            }

            $accession_stmt->close();
            ?>
        </div>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./src/components/header.js"></script>

    <script>
    // Set a timeout to hide the alert after 4 seconds
    setTimeout(function() {
        var alertElement = document.getElementById('alert');
        if (alertElement) {
            alertElement.style.display = 'none';
        }
    }, 4000);

    
    // JavaScript function to handle the "Repair" button
    function markAsRepaired(accessionNo) {
        if (confirm('Are you sure you want to mark this book as being repaired?')) {
            // Get the corresponding repair description
            const repairDescription = document.querySelector(`textarea[name='repair_description[]']`).value;

            // Perform the AJAX request to mark the book as repaired
            var bookId = <?php echo json_encode($book_id); ?>; // Use PHP to get the current book_id
            var category = <?php echo json_encode($category); ?>; // Use PHP to get the current category

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Prepare the data to send
            var data = 'mark_as_repaired=true&book_id=' + bookId + '&category=' + category + '&accession_no=' + accessionNo + '&repair_description=' + repairDescription;

            // Send the data
            xhr.send(data);

            // Handle the response
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Redirect to the current page with success message
                    window.location.href = window.location.href + '&repair_success=1';
                } else {
                    alert('Error marking the book as repaired.');
                }
            };
        }
    }

</script>



</body>
</html>
