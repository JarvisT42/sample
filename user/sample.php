<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flexbox Example</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            border: 2px solid #333;
            height: 100vh;
            padding: 10px;
            box-sizing: border-box;
            background-color: grey; /* Darker green color */

        }

        .box {
            background-color: #2e7d32; /* Darker green color */
            color: white;
            padding: 10px; /* Reduced padding */
            margin: 5px;
            text-align: center;
            flex: 1 1 75px; /* flex-grow: 1, flex-shrink: 1, flex-basis: 75px */
            border: 1px solid #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">Item 1</div>
        <div class="box">Item 2</div>
        <div class="box">Item 3</div>
    </div>
</body>
</html>
