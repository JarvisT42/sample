<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'user_header.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<button data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6 text-yellow-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="separator-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 flex flex-col bg-red-800 text-yellow-100" aria-label="Sidebar">
    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <div class="flex items-center p-2 mb-4 mt-4 bg-yellow-100 rounded-lg">
            <img class="w-12 h-12 rounded-full" src="https://via.placeholder.com/100" alt="Profile Picture">
            <div class="ms-4">
                <p class="text-red-800 text-sm">Student</p>
            </div>
        </div>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="dashboard.php" class="flex items-center p-2 rounded-lg hover:bg-yellow-500 hover:text-red-800 group">
                    <svg class="w-5 h-5 text-yellow-300 group-hover:text-red-800" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="books.php" class="flex items-center p-2 rounded-lg hover:bg-yellow-500 hover:text-red-800 group">
                    <svg class="w-5 h-5 text-yellow-300 group-hover:text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3h10a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm0 2v12h10V5H5zM8 6h4v2H8V6zm0 3h4v2H8V9z" />
                    </svg>
                    <span class="ms-3">Books</span>
                </a>
            </li>
            <li>
                <a href="borrow.php" class="flex items-center p-2 rounded-lg hover:bg-yellow-500 hover:text-red-800 group">
                    <svg class="w-5 h-5 text-yellow-300 group-hover:text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 7h6v6H7V7zm2-5a1 1 0 0 0-1 1v1H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1V8h1a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-1V1a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1z" />
                    </svg>
                    <span class="ms-3">Borrow</span>
                </a>
            </li>
            <li>
                <a href="activity_log.php" class="flex items-center p-2 rounded-lg hover:bg-yellow-500 hover:text-red-800 group">
                    <svg class="w-5 h-5 text-yellow-300 group-hover:text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 2h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zm0 2v12h4V4H8z" />
                    </svg>
                    <span class="ms-3">Activity Log</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="px-3 py-4 border-t border-yellow-500 bg-red-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="settings.php" class="flex items-center p-2 text-yellow-100 rounded-lg hover:bg-yellow-500 hover:text-red-800">
                    <span class="ms-3">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="flex items-center p-2 text-yellow-100 rounded-lg hover:bg-yellow-500 hover:text-red-800">
                    <span class="ms-3">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<main id="content" class="sm:ml-64 bg-gray-100 min-h-screen">
    <div class="p-4">
        <div class="p-4 border-2 border-red-700 border-dashed rounded-lg bg-yellow-50 min-h-screen">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <!-- Cards and Content here -->
            </div>
        </div>
    </div>
</main>

<script src="./src/components/header.js"></script>
</body>
</html>
