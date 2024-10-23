<?php
# Initialize the session
session_start();

// Check if the session for the book bag is set
if (!isset($_SESSION['book_bag'])) {
  $_SESSION['book_bag'] = [];
}

// Redirect to borrow.php if selected_date or selected_time is empty
if (empty($_SESSION['selected_date']) || empty($_SESSION['selected_time'])) {
  header("Location: dashboard.php");
  exit(); // Make sure to exit after a redirect
}

// Populate bookBagTitles
$bookBag = $_SESSION['book_bag'];
$bookBagTitles = array_map(function ($book) {
  return $book['title'] . '|' . $book['author'];
}, $bookBag);

// Get session data
$selectedDate = $_SESSION['selected_date'];
$selectedTime = $_SESSION['selected_time'];

// Format the date
$formattedDate = (new DateTime($selectedDate))->format('l, F j, Y');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="path/to/your/styles.css">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
</head>

<body>
  <?php include './src/components/sidebar.php'; ?>

  <main id="content">
    <div class="p-4 sm:ml-64">
      <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="w-full mx-auto bg-white shadow-md rounded-lg overflow-hidden">
          <div class="p-6">

            <form id="borrowForm" method="POST" action="borrow_books.php">




              <h1 class="text-2xl font-bold mb-4">Appointment Details</h1>
              <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mb-6">
                <p class="text-gray-700">Please review the details of your appointment. Keep in mind that this appointment is non-transferable.</p>
              </div>

              <h2 class="text-xl font-semibold mb-2">Appointment Details</h2>
              <div class="mb-6">
                <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-lg overflow-hidden">
                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="user" class="w-4 h-4 mr-2"></i>Student Name</div>
                  <div class="p-2 border-b border-gray-300">
                    <?php echo htmlspecialchars($_SESSION["First_Name"]) . ' ' . htmlspecialchars($_SESSION["Last_Name"]); ?>
                  </div>
                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="book" class="w-4 h-4 mr-2"></i>Books</div>
                  <div class="p-1 border-b border-gray-300">
                    <?php
                    if (empty($bookBagTitles)) {
                      echo 'No books added';
                    } else {
                      foreach ($bookBagTitles as $index => $bookTitle) {
                        list($title, $author) = explode('|', $bookTitle);
                        // Alternate row colors
                        $rowClass = $index % 2 === 0 ? 'bg-gray-300' : 'bg-gray-200';
                        echo "<div class=\"{$rowClass} p-2 m-1 rounded border border-gray-400\">" . 
                        "Title: " . htmlspecialchars($title) . " | Author: " . htmlspecialchars($author) . 
                        "</div>";
                                         }
                    }
                    ?>
                  </div>

                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="calendar" class="w-4 h-4 mr-2"></i>Date To Claim</div>
                  <div class="p-2 border-b border-gray-300"><?php echo htmlspecialchars($selectedDate); ?></div>
                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="clock" class="w-4 h-4 mr-2"></i>Schedule</div>
                  <div class="p-2 border-b border-gray-300"><?php echo htmlspecialchars($selectedTime); ?></div>
                </div>
              </div>

              <h2 class="text-xl font-semibold mb-2">Contact Information</h2>
              <div class="mb-6">
                <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-lg overflow-hidden">
                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="mail" class="w-4 h-4 mr-2"></i>Email</div>
                  <div class="p-2 border-b border-gray-300"> <?php echo htmlspecialchars($_SESSION["email"]); ?></div>

                  <div class="bg-gray-100 p-2 font-semibold flex items-center border-b border-gray-300"><i data-lucide="phone" class="w-4 h-4 mr-2"></i>Mobile Number</div>
                  <div class="p-2 border-b border-gray-300"> <?php echo htmlspecialchars($_SESSION["phoneNo."]); ?></div>
                </div>
              </div>

              <div class="flex justify-between">
                <a href="schedule.php" class="bg-blue-700 text-white px-6 py-2 rounded-md hover:bg-blue-800 transition duration-300 flex items-center border border-blue-600">
                  <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back
                </a>



                <button type="button" onclick="borrowBooks()" class="bg-blue-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition duration-300 flex items-center border border-green-600">
                  <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>Confirm
                </button>








              </div>


            </form>

          </div>
        </div>
      </div>


    </div>
  </main>
  <script>
    function checkBookAvailability(bookId, tableName, callback) {
      fetch('check_book_availability.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            book_id: bookId,
            table: tableName
          })
        })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            callback(true); // Book is available
          } else {
            alert(result.message); // Display error if book is unavailable

            // After the alert, unset session variables and redirect
            fetch('unset_session_and_redirect.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              }
            }).then(() => {
              window.location.href = 'borrow.php'; // Redirect to borrow.php
            });

            callback(false); // Book is not available
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while checking book availability.');

          // After the error, unset session variables and redirect
          fetch('unset_session_and_redirect.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            }
          }).then(() => {
            window.location.href = 'borrow.php'; // Redirect to borrow.php
          });

          callback(false); // Treat as unavailable in case of error
        });
    }

    function borrowBooks() {
      const bookBag = <?php echo json_encode($bookBag); ?>;
      let allAvailable = true;

      // Check each book for availability
      bookBag.forEach((book, index) => {
        checkBookAvailability(book.id, book.table, function(isAvailable) {
          if (!isAvailable) {
            allAvailable = false;
          }

          // Once all books have been checked, submit the form if available
          if (index === bookBag.length - 1) {
            if (allAvailable) {
              document.getElementById('borrowForm').submit();
            }
          }
        });
      });
    }
  </script>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>