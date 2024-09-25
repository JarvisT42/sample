<?php
# Initialize the session
session_start();


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
      
      <div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg">
  <div class="flex justify-between mb-6">
    <div class="flex-1">
      <h1 class="text-2xl font-bold mb-1">Title:</h1>
      <p class="text-xl mb-4">sample sample By: author</p>
      <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-600 mb-1">Borrow Category:</h2>
        <p class="text-sm text-gray-500">list of existing filipiniana books and references</p>
      </div>
    </div>
    <div class="w-32 h-40 bg-gray-200 border border-gray-300 flex items-center justify-center">
      <span class="text-gray-400">Book Cover</span>
    </div>
  </div>
  <div class="bg-blue-100 p-4 rounded-lg">
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div>
        <p class="text-sm font-semibold">Issued Date:</p>
        <p class="text-sm">Monday, March 18, 2024</p>
      </div>
      <div>
        <p class="text-sm font-semibold">Due Date:</p>
        <p class="text-sm">Friday, March 22, 2024</p>
      </div>
    </div>
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-semibold">Fines:</p>
        <p class="text-sm">₱340</p>
      </div>
      <div class="flex items-center space-x-2">
        <select class="border border-gray-300 rounded p-1">
          <option>0 Days</option>
          <!-- Add more options as needed -->
        </select>
        <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Renew</button>
        <button class="bg-gray-300 text-gray-700 rounded px-2 py-1 text-sm">Return</button>
      </div>
    </div>
  </div>
</div>













      </div>


    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>