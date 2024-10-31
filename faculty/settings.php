<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['Id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['Id'];

// Fetch user profile data from the database
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = null;
    echo "No user found with this ID.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <!-- Include Tailwind CSS -->
    <!-- Latest Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">

    <!-- Latest Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Latest Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .active-settings {
            background-color: #f0f0f0;
            /* Example for light mode */
            color: #000;
            /* Example for light mode */
        }
    </style>

</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


        <div class="p-4 sm:ml-64">

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">





                <div class="w-full mx-auto bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-6">Profile: <?php echo $user['First_Name'] . ' ' . $user['Last_Name']; ?></h1>


                        <div class="flex flex-col md:flex-row gap-8">




                            <div class="w-30 md:w-1/3">
                                <img src="https://v0.dev/placeholder.svg" alt="Profile Picture" class="w-full h-auto rounded-lg mb-4">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md w-full">Upload</button>

                                <div class="mt-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold">Status</span>
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Active</span>
                                    </div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold">User Rating</span>
                                        <div class="flex">

                                            <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                            <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                            <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                            <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                            <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold">Member Since</span>
                                        <span>Jan 07, 2014</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-2/3">


                                <h2 class="text-xl font-semibold mt-8 mb-4">Profile Setting</h2>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        
                               

                                    <input type="text" name="first_name" value="<?php echo $user['First_Name']; ?>" class="w-full border rounded-md px-3 py-2">
                                    <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="text" placeholder="Last Name" class="w-full border rounded-md px-3 py-2">
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="date" class="w-full border rounded-md px-3 py-2">
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>

                                    <div class="flex items-center">
                                        <select class="w-full border rounded-md px-3 py-2">
                                            <option>Bs information system</option>
                                            <option>Bs accountancy</option>
                                        </select>
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>
                                    <div class="flex items-center">
                                        <textarea placeholder="About" class="w-full border rounded-md px-3 py-2" rows="3"></textarea>
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>
                                </div>


                                <h2 class="text-xl font-semibold mt-8 mb-4">Contact Setting</h2>
                                <div class="space-y-4  mb-4">
                                    <div class="flex items-center">

                                        <input type="email" name="email" value="<?php echo $user['Email_Address']; ?>" class="w-full border rounded-md px-3 py-2">


                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>


                                    </div>

                                    <div class="flex items-center">
                                        <input type="tel" placeholder="Mobile Phone" class="w-full border rounded-md px-3 py-2">
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>

                                </div>

                                <h2 class="text-xl font-semibold mb-4">Account Setting</h2>
                                <div class="space-y-4">






                                    <div class="flex items-center">
                                        <input type="password" placeholder="Password" class="w-full border rounded-md px-3 py-2">
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="password" placeholder="Confirm Password" class="w-full border rounded-md px-3 py-2">
                                        <button class="ml-2 bg-orange-500 text-white p-2 rounded-md"><i data-lucide="pencil" class="w-5 h-5"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>







            </div>
        </div>

    </main>



    <script src="./src/components/header.js"></script>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>