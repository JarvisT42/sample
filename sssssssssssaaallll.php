<?php
# Initialize the session
session_start();
require '../connection.php';


if ($_SESSION["loggedin"] !== TRUE) {
    //echo "<script type='text/javascript'> alert ('Iasdasdasd.')</script>";
    echo "<script>" . "window.location.href='../index.php';" . "</script>";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'user_header.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">

                    









                    







                </div>



               





            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>


</body>

</html>