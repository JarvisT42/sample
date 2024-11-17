<button data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="separator-sidebar" class="fixed  top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 flex flex-col" aria-label="Sidebar">
    <div class="flex-1 px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">


        <div class="flex items-center p-2 mb-4 mt-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <img class="w-12 h-12 rounded-full" src="https://via.placeholder.com/100" alt="Profile Picture">
            <div class="ms-4">
                <p class="text-gray-900 dark:text-white text-lg font-medium">
                    <?php echo htmlspecialchars($_SESSION["Full_Name"]); ?>
                </p>
                <!-- <p class="text-gray-900 dark:text-white text-lg font-medium">John Doe</p> -->
                <p class="text-gray-500 dark:text-gray-400 text-sm">Admin</p>
            </div>
        </div>

        <ul class="space-y-2 font-medium">
            <!-- Other sidebar items here -->
            <li>
                <a href="dashboard.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group active-dashboard">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>


            




            <li>
                <a href="books.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group active-books">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 7h6v6H7V7zm2-5a1 1 0 0 0-1 1v1H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1V8h1a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-1V1a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Books</span>
                </a>
            </li>

            



            



            <!-- Add other sidebar links here -->
        </ul>
    </div>





    <div class="px-3 py-4 border-t border-gray-200 bg-gray-50 dark:border-gray-700">
        <ul class="space-y-2 font-medium">
        

            <li>
                <a href="logout.php" class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 16l-4-4 4-4v3h4v2h-4v3zm6-12h-6v2h6v-2zm2 0c1.1 0 2 .9 2 2v16c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2h12z" />
                    </svg>
                    <span class="ms-3">Log Out</span>
                </a>
            </li>

        </ul>
    </div>
</aside>