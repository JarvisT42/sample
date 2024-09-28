<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Database Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error {
            color: red;
            background-color: #ffe6e6;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "gfi_library_database_books_records");

// Check connection
if (!$conn) {
    die("<div class='error'>Connection failed: " . mysqli_connect_error() . "</div>");
}

// SQL query to fetch all table names
$sql = "SHOW TABLES FROM gfi_library_database_books_records";
$result = $conn->query($sql);

if (!$result) {
    die("<div class='error'>Error fetching tables: " . $conn->error . "</div>");
}

$allData = [];
$columnNames = ['ID', 'Title', 'Author', 'Date of Publication/Copyright', 'Record Cover', 'No. of Copies'];

// Loop through each table and fetch data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $tableName = $row[0]; // Get the table name

        // Adjust the SELECT query according to your actual table structure
        $sqlData = "SELECT id, title, author, Date_Of_Publication_Copyright, record_cover, No_Of_Copies FROM `$tableName`";
        $dataResult = $conn->query($sqlData);

        if ($dataResult) {
            // Store data for the current table
            while ($dataRow = $dataResult->fetch_assoc()) {
                $allData[] = $dataRow; // Add each row to the combined data array
            }
        } else {
            echo "<div class='error'>Error fetching data from table `$tableName`: " . $conn->error . "</div>";
        }
    }
}

// Output the combined results
echo "<h2>All Data from Tables</h2>";
echo "<table>";
echo "<thead>";
echo "<tr>";
foreach ($columnNames as $columnName) {
    echo "<th>" . htmlspecialchars($columnName) . "</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Loop through the combined data
foreach ($allData as $dataRow) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($dataRow['id']) . "</td>";
    echo "<td>" . htmlspecialchars($dataRow['title']) . "</td>";
    echo "<td>" . htmlspecialchars($dataRow['author']) . "</td>";
    echo "<td>" . htmlspecialchars($dataRow['Date_Of_Publication_Copyright']) . "</td>";
    echo "<td>";
    if (!empty($dataRow['record_cover'])) {
        echo "<img src='" . htmlspecialchars($dataRow['record_cover']) . "' alt='Record Cover' style='width: 100px; height: auto;'/>";
    } else {
        echo "No image";
    }
    echo "</td>";
    echo "<td>" . htmlspecialchars($dataRow['No_Of_Copies']) . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";

// Close the database connection
$conn->close();
?>

</body>
</html>
