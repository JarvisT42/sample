<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS -->
    <title>Book Request</title>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>
    <main id="content">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="bg-gray-100 p-6 w-full mx-auto">
                    <div class="bg-white p-4 shadow-sm rounded-lg mb-2">
                        <div class="bg-gray-100 p-2 flex justify-between items-center">
                            <h1 class="m-0">Book Request for: Unknown Student</h1>
                        </div>
                    </div>
                    <div class="bg-blue-200 p-4 rounded-lg">
                        <div class="bg-blue-200 rounded-lg flex items-center justify-end">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all-date-placeholder" class="select-all-checkbox ml-2" onclick="toggleSelectAll('date-placeholder')">
                                <label for="select-all-date-placeholder" class="ml-1 text-sm">Select All</label>
                            </div>
                        </div>

                        <ul>
                            <li class="p-4 bg-white flex flex-col md:flex-row items-start border-b-2 border-black">
                                <div class="flex flex-col md:flex-row items-start w-full space-y-4 md:space-y-0 md:space-x-6">
                                    <div class="flex-1 w-full md:w-auto">
                                        <h2 class="text-lg font-semibold mb-2">
                                            <a href="#" class="text-blue-600 hover:underline max-w-xs break-words">
                                                Book Title Placeholder
                                            </a>
                                        </h2>
                                        <div class="mt-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 text-sm text-gray-600">
                                                <div class="font-medium bg-gray-200 p-2">Main Author:</div>
                                                <div class="bg-gray-100 p-2">Book Author Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Published:</div>
                                                <div class="bg-gray-200 p-2">Publication Date Placeholder</div>
                                                <div class="font-medium bg-gray-200 p-2">Table:</div>
                                                <div class="bg-gray-100 p-2">Category Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Copies:</div>
                                                <div class="bg-gray-100 p-2">Book ID Placeholder</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <img src="path/to/default/image.jpg" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                    </div>

                                    <div class="flex-shrink-0 ml-2">
                                        <input type="checkbox" id="book-checkbox-placeholder" name="selected_books[]" value="book-id-placeholder" class="book-checkbox-placeholder mr-1">
                                        <label for="book-checkbox-placeholder" class="text-sm text-gray-600">Select</label>
                                    </div>
                                </div>
                            </li>
                            <li class="p-4 bg-white flex flex-col md:flex-row items-start border-b-2 border-black">
                                <div class="flex flex-col md:flex-row items-start w-full space-y-4 md:space-y-0 md:space-x-6">
                                    <div class="flex-1 w-full md:w-auto">
                                        <h2 class="text-lg font-semibold mb-2">
                                            <a href="#" class="text-blue-600 hover:underline max-w-xs break-words">
                                                Book Title Placeholder
                                            </a>
                                        </h2>
                                        <div class="mt-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 text-sm text-gray-600">
                                                <div class="font-medium bg-gray-200 p-2">Main Author:</div>
                                                <div class="bg-gray-100 p-2">Book Author Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Published:</div>
                                                <div class="bg-gray-200 p-2">Publication Date Placeholder</div>
                                                <div class="font-medium bg-gray-200 p-2">Table:</div>
                                                <div class="bg-gray-100 p-2">Category Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Copies:</div>
                                                <div class="bg-gray-100 p-2">Book ID Placeholder</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <img src="path/to/default/image.jpg" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                    </div>

                                    <div class="flex-shrink-0 ml-2">
                                        <input type="checkbox" id="book-checkbox-placeholder" name="selected_books[]" value="book-id-placeholder" class="book-checkbox-placeholder mr-1">
                                        <label for="book-checkbox-placeholder" class="text-sm text-gray-600">Select</label>
                                    </div>
                                </div>
                            </li>
                            <li class="p-4 bg-white flex flex-col md:flex-row items-start border-b-2 border-black">
                                <div class="flex flex-col md:flex-row items-start w-full space-y-4 md:space-y-0 md:space-x-6">
                                    <div class="flex-1 w-full md:w-auto">
                                        <h2 class="text-lg font-semibold mb-2">
                                            <a href="#" class="text-blue-600 hover:underline max-w-xs break-words">
                                                Book Title Placeholder
                                            </a>
                                        </h2>
                                        <div class="mt-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 text-sm text-gray-600">
                                                <div class="font-medium bg-gray-200 p-2">Main Author:</div>
                                                <div class="bg-gray-100 p-2">Book Author Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Published:</div>
                                                <div class="bg-gray-200 p-2">Publication Date Placeholder</div>
                                                <div class="font-medium bg-gray-200 p-2">Table:</div>
                                                <div class="bg-gray-100 p-2">Category Placeholder</div>
                                                <div class="font-medium bg-gray-100 p-2">Copies:</div>
                                                <div class="bg-gray-100 p-2">Book ID Placeholder</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <img src="path/to/default/image.jpg" alt="Book Cover" class="w-36 h-56 border-2 border-gray-400 rounded-lg object-cover transition-transform duration-200 transform hover:scale-105">
                                    </div>

                                    <div class="flex-shrink-0 ml-2">
                                        <input type="checkbox" id="book-checkbox-placeholder" name="selected_books[]" value="book-id-placeholder" class="book-checkbox-placeholder mr-1">
                                        <label for="book-checkbox-placeholder" class="text-sm text-gray-600">Select</label>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Done</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
