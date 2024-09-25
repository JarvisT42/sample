<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#4285F4',
                        'custom-green': '#34A853',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 p-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-2">Our Services</h1>
        <p class="text-center text-gray-600 mb-8">Explore what we offer and learn more about our mission, policies, and more.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-custom-green rounded-lg p-4 flex flex-col items-center">
                <div class="w-full h-48 bg-custom-blue rounded-lg mb-4"></div>
                <h2 class="text-xl font-semibold mb-4">About Us</h2>
                <button class="bg-custom-blue text-white px-4 py-2 rounded-full text-sm mt-auto">READ MORE</button>
            </div>
            <div class="bg-custom-green rounded-lg p-4 flex flex-col items-center">
                <div class="w-full h-48 bg-custom-blue rounded-lg mb-4"></div>
                <h2 class="text-xl font-semibold mb-4">Mission and Vision</h2>
                <button class="bg-custom-blue text-white px-4 py-2 rounded-full text-sm mt-auto">READ MORE</button>
            </div>
            <div class="bg-custom-green rounded-lg p-4 flex flex-col items-center">
                <div class="w-full h-48 bg-custom-blue rounded-lg mb-4"></div>
                <h2 class="text-xl font-semibold mb-4">Policy</h2>
                <button class="bg-custom-blue text-white px-4 py-2 rounded-full text-sm mt-auto">READ MORE</button>
            </div>
            <div class="bg-custom-green rounded-lg p-4 flex flex-col items-center">
                <div class="w-full h-48 bg-custom-blue rounded-lg mb-4"></div>
                <h2 class="text-xl font-semibold mb-4">Books</h2>
                <button class="bg-custom-blue text-white px-4 py-2 rounded-full text-sm mt-auto">READ MORE</button>
            </div>
        </div>
    </div>
</body>
</html>