<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Appointment Details</h1>
            
            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mb-6">
                <p class="text-gray-700">Please review the details of your appointment. Keep in mind that this appointment is non-transferable.</p>
            </div>
            
            <h2 class="text-xl font-semibold mb-2">Appointment Details</h2>
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="user" class="w-4 h-4 mr-2"></i>Student Name</div>
                    <div class="p-2">kent joshua daborbor</div>
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="book" class="w-4 h-4 mr-2"></i>Book</div>
                    <div class="p-2">456 by 456</div>
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="calendar" class="w-4 h-4 mr-2"></i>Date</div>
                    <div class="p-2">Friday, September 27, 2024</div>
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="clock" class="w-4 h-4 mr-2"></i>Time</div>
                    <div class="p-2">Morning</div>
                </div>
            </div>
            
            <h2 class="text-xl font-semibold mb-2">Contact Information</h2>
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i>Email</div>
                    <div class="p-2">kentjoshuazamoradaborbor@gmail.com</div>
                    <div class="bg-gray-100 p-2 font-semibold flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i>Mobile Number</div>
                    <div class="p-2"></div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <button class="bg-red-700 text-white px-6 py-2 rounded-md hover:bg-red-800 transition duration-300 flex items-center">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back
                </button>
                <button class="bg-red-700 text-white px-6 py-2 rounded-md hover:bg-red-800 transition duration-300 flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</body>
<script>
    lucide.createIcons();
</script>
</html>
