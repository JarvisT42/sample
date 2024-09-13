<section class="container mx-auto px-4 py-20 ">
        <div class="bg-white p-8 rounded-lg shadow-lg  border border-blue-500">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Search Library</h2>
            <div class="flex justify-center space-x-8 mb-6">
                <label class="flex items-center space-x-2 text-gray-700">
                    <i class="fas fa-database text-indigo-600"></i>
                    <input type="radio" name="search-type" value="database" class="text-indigo-600">
                    <span>Database</span>
                </label>
                <label class="flex items-center space-x-2 text-gray-700">
                    <i class="fas fa-book text-indigo-600"></i>
                    <input type="radio" name="search-type" value="journal" class="text-indigo-600">
                    <span>Journal</span>
                </label>
                <label class="flex items-center space-x-2 text-gray-700">
                    <i class="fas fa-book-reader text-indigo-600"></i>
                    <input type="radio" name="search-type" value="e-books" class="text-indigo-600">
                    <span>E-Books</span>
                </label>
            </div>
            <!-- Dynamic title below radio buttons -->
            <h2 id="search-title" class="text-xl font-semibold mb-6 text-center text-gray-800">Select a category to search</h2>
            <div class="flex">
                <input type="text" placeholder="Search for books, journals, or e-books..." class="flex-grow p-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700">
                <button class="bg-indigo-600 text-white px-5 py-3 rounded-r-lg hover:bg-indigo-700 flex items-center">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
            </div>
        </div>
    </section>



    <style>
        /* Hide the default radio button appearance */
        input[type="radio"] {
            -webkit-appearance: none; /* Remove default appearance in WebKit browsers */
            -moz-appearance: none; /* Remove default appearance in Firefox */
            appearance: none; /* Remove default appearance in modern browsers */
            border-radius: 50%; /* Make it a circle */
            border: 2px solid #4a90e2; /* Border color */
            width: 20px; /* Size of the radio button */
            height: 20px; /* Size of the radio button */
            outline: none; /* Remove outline */
            cursor: pointer; /* Pointer cursor on hover */
            position: relative; /* Position relative for the inner dot */
        }

        /* Style the inner dot when the radio button is checked */
        input[type="radio"]:checked::before {
            content: ''; /* Empty content */
            position: absolute; /* Position absolute inside the radio button */
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Center dot */
            width: 12px; /* Size of the inner dot */
            height: 12px; /* Size of the inner dot */
            border-radius: 50%; /* Make it a circle */
            background-color: #4a90e2; /* Dot color */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleElement = document.getElementById('search-title');
            
            document.querySelectorAll('input[name="search-type"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    switch (this.value) {
                        case 'database':
                            titleElement.textContent = 'Search Subscribed e-Resources';
                            break;
                        case 'journal':
                            titleElement.textContent = 'Search Subscribed Online Journals';
                            break;
                        case 'e-books':
                            titleElement.textContent = 'Search Subscribed e-books';
                            break;
                    }
                });
            });
        });
    </script>
