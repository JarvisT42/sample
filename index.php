



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    <style>
        /* If you prefer inline styles, you can include them directly */
        .h-200 {
            height: 600px;
        }



     

    </style>
    
<script>
    // Clear local storage for book bag when the user visits the login page or after logging out
    window.addEventListener('DOMContentLoaded', (event) => {
        // Clear book bag related localStorage items
        localStorage.removeItem('bookBagCount');
        // Optionally, clear all items related to books
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('book-')) {
                localStorage.removeItem(key);
            }
        });
    });
</script>

</head>

<body>
    <?php include './src/components/header.php'; ?>
    
    
    <main id="content" class="blur-background">
        <?php include './src/components/background.php'; ?>
        <?php include './src/components/search_engine.php'; ?>
        <?php include './src/components/card.php'; ?>

        <?php include './src/components/card_news.php'; ?>


    </main>

    <?php include './src/components/footer.php'; ?>

 
    <script src="./src/components/header.js"></script>
   

</body>
</html>
