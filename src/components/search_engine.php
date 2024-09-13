<style>
        /* Tab Header */
        .tab_header {
            border: 2px solid red;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            background-color: red;
            color: #ffffff;
            padding: 0.1em 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tab_header .title {
            flex: 1;
            text-align: center;
            padding: 0.125rem;
        }

        .tab_header .search-icon {
            padding-left: 0.125rem;
        }

        /* Tabs Container */
        .tab {
            overflow: hidden;
            border: 1px solid red;
            border-bottom: none;
            background-color: red;
            text-align: center;
        }

        /* Tab Buttons */
        .tab button {
            background-color: inherit;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 10px 10px 0 0;
            font-size: 16px;
            color: #fff;
            padding: 0.9em 0.29em;
        }

        /* Hover Effect */
        .tab button:hover {
            background-color: #ddd;
            color: #014420;
        }

        /* Active Tab */
        .tab button.active {
            background-color: #fff;
            color: #014420;
        }

        /* Tab Content */
        .tabcontent {
            display: none;
            padding: 12px;
            border: 1px solid #014420;
            border-top: none;
            background-color: #fff;
            animation: fadeEffect 1s;
        }

        /* Fade Effect */
        @keyframes fadeEffect {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Centered List */
        .centered_list {
            font-size: 0.75rem;
            text-align: center;
        }

        .centered_link {
            display: inline-block;
            padding: 0 0.5em;
        }

        /* Input Field */
        input[type="text"] {
            border-radius: 10px;
            padding: 0.5em;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .tab_header {
                flex-direction: column;
                align-items: center;
            }

            .tab button {
                font-size: 14px;
                padding: 0.6em 0.2em;
            }

            input[type="text"] {
                width: 100%;
            }

            .tabcontent {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .tab button {
                font-size: 12px;
                padding: 0.4em 0.1em;
            }

            input[type="text"] {
                padding: 0.4em;
            }

            .tabcontent {
                padding: 6px;
            }

            .tab_header {
                font-size: 0.9em;
            }
        }
    </style>

<div class=" p-10">
  <!-- Content goes here -->


    <div class="tab_header">
        <div class="title text-2xl">Saliktroniko</div>
        <span class="fas fa-search search-icon"></span>
    </div>

    <!-- Tab links -->
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'local')" id="defaultOpen">Journals</button>
        <button class="tablinks" onclick="openCity(event, 'subs')">Databases</button>
        <button class="tablinks" onclick="openCity(event, 'journals')">E-Books</button>
    </div>

    <!-- Tab content -->
    <div id="local" class="tabcontent">
        <p class="text-4xl text-center mt-0 mb-10">Search UPD Library Collection</p>

        <form id="searchFormLocal" method="get" action="https://tuklas.up.edu.ph/Search/Results" name="searchForm" target="_blank" style="justify-content: center; display: flex;">
            <input id="searchForm_lookfor" placeholder="Books, serials, theses, and multimedia" type="text" name="lookfor" style="width: 80%;">
            <button type="submit" style="font-size: 28px; padding: 0 0.4em;"><i class="fas fa-search"></i></button>
        </form>
        <p style="text-align: center; margin-top: 0; font-size: 14px;">Browse Local Collections</p>
    </div>

    <div id="subs" class="tabcontent">
    <p class="text-4xl text-center mt-0 mb-10">Search Subscribed e-Resources</p>

        <form id="searchFormSubs" action="https://searchbox.ebsco.com/search/" target="_blank" class="ebsco-single-search" style="justify-content: center; display: flex;">
            <input id="searchForm_lookfor" placeholder="Books, serials, theses, and multimedia" type="text" name="lookfor" style="width: 80%;">

            <button type="submit" style="font-size: 28px; padding: 0 0.4em;"><i class="fas fa-search"></i></button>
        </form>
        <p style="text-align: center; margin-top: 0; font-size: 14px;">Browse Subscribed e-Resources</p>
    </div>

    <div id="journals" class="tabcontent">
    <p class="text-4xl text-center mt-0 mb-10">Search Subscribed Online Journals</p>

        <form id="searchFormJournals" class="ebscohostCustomSearchBox75251" action="" onsubmit="return ebscoHostSearchGo(this,75251);" method="post" style="justify-content: center; display: flex;">
            <input id="searchForm_lookfor" placeholder="Books, serials, theses, and multimedia" type="text" name="lookfor" style="width: 80%;">

            <button type="submit" style="font-size: 28px; padding: 0 0.4em;"><i class="fas fa-search"></i></button>
        </form>
        <p style="text-align: center; margin-top: 0; font-size: 14px;">Browse Subscribed e-Resources</p>
    </div>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Prevent form submission on Enter key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        document.getElementById("defaultOpen").click();
    </script>
    </div>
