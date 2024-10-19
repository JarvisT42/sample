<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-pink-100 p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-pink-900">
        <div class="col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- First 3 Divs with Plus Icon -->
            <div class="bg-white rounded-lg shadow-sm p-4 flex items-center justify-center">
                <i icon-name="plus" class="text-gray-400"></i>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 flex items-center justify-center">
                <i icon-name="plus" class="text-gray-400"></i>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 flex items-center justify-center">
                <i icon-name="plus" class="text-gray-400"></i>
            </div>
            <!-- Full-Width Div with Plus Icon -->
            <div class="col-span-1 md:col-span-3 bg-white rounded-lg shadow-sm p-4 flex items-center justify-center h-48">
                <i icon-name="plus" class="text-gray-400"></i>
            </div>
        </div>
        <!-- Right Panel (Recent Activity) -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h2 class="font-semibold text-lg mb-4 flex items-center justify-between">
                Recent Activity
                <span class="text-sm font-normal text-gray-500">1 Today</span>
            </h2>
            <ul class="space-y-4">
                <!-- Activity Items -->
                <li class="flex items-start">
                    <span class="bg-green-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Quia quae rerum explicabo officiis beatae</p>
                        <span class="text-xs text-gray-500">32 min</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="bg-red-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Voluptatem blanditiis blanditiis eveniet</p>
                        <span class="text-xs text-gray-500">56 min</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="bg-blue-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Voluptates corrupti molestias voluptatem</p>
                        <span class="text-xs text-gray-500">2 hrs</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="bg-cyan-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Tempore autem saepe occaecati voluptatem tempore</p>
                        <span class="text-xs text-gray-500">1 day</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="bg-yellow-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Est sit eum reiciendis exercitationem</p>
                        <span class="text-xs text-gray-500">2 days</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="bg-gray-500 w-2 h-2 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm">Dicta dolorem harum nulla eius. Ut quidem quidem sit quas</p>
                        <span class="text-xs text-gray-500">4 weeks</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>










