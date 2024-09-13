
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
   
        .active-borrow {
    background-color: #f0f0f0; /* Example for light mode */
    color: #000; /* Example for light mode */
}




     

    </style>

</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content" class="">


    <div class="p-4 sm:ml-64">
        
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
     
    


   <!-- Title Box -->
<!-- Title and Button Box -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 mb-4 flex items-center justify-between">
    <h1 class="text-3xl font-semibold">Borrow</h1> <!-- Adjusted text size -->
    <!-- Button beside the title -->
</div>

<div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-700 dark:text-gray-300">
The Borrow Page is your gateway to accessing and managing book loans efficiently. On this page, you can search for and borrow books from our collection with ease. Simply browse or search for the titles you wish to borrow, select your preferred books, and follow the streamlined borrowing process. The page also provides a clear overview of the available books and their details.
</div>

<!-- Main Content Box -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
<div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
    <div class="flex items-center space-x-4">
        <!-- Dropdown Button -->
        <div>
            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <span class="sr-only">Action button</span>
                Action
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownAction" class="z-20 hidden  bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 p-2">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Checkbox -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="checkboxOption" name="checkboxGroup" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-lg focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 transition-transform transform hover:scale-105 checked:bg-blue-600 checked:border-transparent">
            <label for="checkboxOption" class="text-sm text-gray-900 dark:text-gray-300">Option</label>
        </div>
    </div>

    <!-- Search Input and Button -->
    

    <div class="relative flex items-center">
  <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>        <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
        <button class="ml-2 px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button>
    </div>
    
</div>


<style>
        .scrollable-table-container {
            /* max-height: 560px; Adjust height as needed */
            overflow-y: auto;
            /* min-height: 200px; */
            height: 900px;

        }
        

    </style>




    <div class="overflow-x-auto">





        <div class="scrollable-table-container border border-gray-200 dark:border-gray-700">

        <div class="container mx-auto px-4 py-6">
        <ul class="flex flex-col space-y-4">
            <!-- First LI -->
            <li id="result1" class="bg-gray-200 p-4 flex items-center border-b-2 border-black" data-record-number="1">
                <div class="flex flex-row items-start w-full space-x-6 overflow-x-auto">
                    <!-- Number and Hidden Inputs -->
                    <div class="flex-none w-12">
                        <div class="text-lg font-semibold text-gray-800">1</div>
                        <input type="hidden" value="UP-99796217611190788" class="hiddenId">
                        <input type="hidden" value="Solr" class="hiddenSource">
                    </div>
                    
                    <!-- Text Content -->
                    <div class="flex-1">
    <h2 class="text-lg font-semibold mb-2">
        <a href="/Record/UP-99796217611190788?sid=130584744" class="text-blue-600 hover:underline">
            Broadband reflectometry for enhanced diagnostics and monitoring applications
        </a>
    </h2>
    <span class="block text-base mb-2">
        by <a href="/Author/Home?author=Cataldo%2C+Andrea&amp;" class="text-blue-600 hover:underline">Cataldo, Andrea</a>
    </span>
    
    <!-- Published and 2011 beside each other -->
    <div class="flex items-center space-x-2 mb-2">
        <div class="text-sm text-gray-600">Published</div>
        <div class="text-sm text-gray-600">2011</div>
    </div>

    <!-- Thesis bmr at the bottom -->
    <div class="bg-blue-200 p-2 text-left mt-auto inline-block">
        thesis bmr
    </div>
</div>


                    <!-- Add to Book Bag Link -->
                    
                    <div class="flex-shrink-0">
                        <a href="#" class="text-green-600 hover:underline">
                            <span class="fa fa-plus"></span> Add to Book Bag
                        </a>
                    </div>
                    
                    <!-- Image -->
                    <div class="flex-shrink-0">
                        <a href="/Record/UP-99796217611190788?sid=130584744" class="block">
                            <img src="/Cover/Show?author=Cataldo%2C+Andrea&amp;callnumber=&amp;size=medium&amp;title=Broadband+reflectometry+for+enhanced+diagnostics+and+monitoring+applications&amp;recordid=UP-99796217611190788&amp;source=Solr&amp;isbns%5B0%5D=3642202330" 
                                 alt="Broadband reflectometry for enhanced diagnostics" 
                                 class="w-28 h-40 border-2 border-gray-400 rounded-lg object-cover">
                        </a>
                    </div>
                </div>
            </li>
           
            <!-- Add more list items here -->

        </ul>
    </div>

    

        

        </div>










        
    </div>

















  </div>















</div>



    


    
    </div>
</div>

    </main>


 
    <script src="./src/components/header.js"></script>
   

</body>
</html>
