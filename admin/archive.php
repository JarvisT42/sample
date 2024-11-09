<?php
# Initialize the session
require '../connection.php';

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'admin_header.php'; ?>

   
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 h-screen">

            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>