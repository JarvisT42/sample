<?php
session_start();
include '../connection.php'; // Database connection
include '../connection2.php'; // Additional database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DataTables with TailwindCSS</title>

  
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Flowbite CSS -->
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- DataTables TailwindCSS CSS -->
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" rel="stylesheet">
</head>

<body>
  <?php include './src/components/sidebar.php'; ?>

  <main id="content" class="">
    <div class="p-4 sm:ml-64">
      <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <table id="example" class="stripe hover w-full text-sm text-left text-gray-500">
          <thead class="bg-gray-50 text-gray-700 uppercase">
            <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Office</th>
              <th>Age</th>
              <th>Start date</th>
              <th>Salary</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Airi Satou</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>33</td>
              <td>2008-11-28</td>
              <td>$162,700</td>
            </tr>
            <tr>
              <td>Brielle Williamson</td>
              <td>Integration Specialist</td>
              <td>New York</td>
              <td>61</td>
              <td>2012-12-02</td>
              <td>$372,000</td>
            </tr>
            <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr>
            <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr> <tr>
              <td>Herrod Chandler</td>
              <td>Sales Assistant</td>
              <td>San Francisco</td>
              <td>59</td>
              <td>2012-08-06</td>
              <td>$137,500</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Office</th>
              <th>Age</th>
              <th>Start date</th>
              <th>Salary</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </main>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

  <!-- DataTables Core JS -->
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

  <!-- DataTables TailwindCSS Integration -->
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize DataTables
      $('#example').DataTable();
    });
  </script>
</body>

</html>
