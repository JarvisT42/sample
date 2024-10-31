<?php
# Initialize the session
session_start();
include("../connection.php");

$sql = "SELECT calendar, morning, afternoon FROM calendar_appointment";
$result = $conn->query($sql);

$selectedDate = $_SESSION['selected_date'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="gg.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <style>
        .hidden { display: none; }
        .highlight { background-color: lightblue; }
        .today { background-color: yellow; }
    </style>
</head>

<body>
    <?php include './src/components/sidebar.php'; ?>

    <main id="content">
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                <div class="container">
                    <div class="calendar">
                        <div class="header">
                            <div class="month"></div>
                            <div class="btns">
                                <div class="btn today">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="btn prev">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                                <div class="btn next">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="weekdays">
                            <div class="day">Sun</div>
                            <div class="day">Mon</div>
                            <div class="day">Tue</div>
                            <div class="day">Wed</div>
                            <div class="day">Thu</div>
                            <div class="day">Fri</div>
                            <div class="day">Sat</div>
                        </div>
                        <div class="days">
                            <!-- Days will be rendered by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    const daysContainer = document.querySelector(".days");
    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");
    const todayBtn = document.querySelector(".today");
    const monthDisplay = document.querySelector(".month");

    // Set the selected date from PHP
    const selectedDate = new Date("<?php echo $selectedDate; ?>");

    // Define the highlight range for November and a target for 15 days
    const highlightMonth = 10; // November (0-based index)
    const highlightStartDay = 1;
    const maxHighlightDays = 15;

    const months = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];

    let currentMonth = selectedDate.getMonth();
    let currentYear = selectedDate.getFullYear();

    const renderCalendar = () => {
        const date = new Date(currentYear, currentMonth, 1);
        const firstDay = date.getDay();
        const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();
        const prevLastDay = new Date(currentYear, currentMonth, 0).getDate();
        const nextDays = 7 - ((firstDay + lastDay - 1) % 7) - 1;

        monthDisplay.innerHTML = `${months[currentMonth]} ${currentYear}`;
        let days = "";
        let highlightedDays = 0;

        // Render previous month dates
        for (let x = firstDay; x > 0; x--) {
            days += `<div class="day prev">${prevLastDay - x + 1}</div>`;
        }

        // Render current month dates with November 1-15 highlighted, excluding Sundays
        for (let i = 1; i <= lastDay; i++) {
            const currentDate = new Date(currentYear, currentMonth, i);

            // Highlight days until we reach 15 non-Sunday days
            if (
                currentMonth === highlightMonth &&
                highlightedDays < maxHighlightDays &&
                currentDate.getDay() !== 0 // Exclude Sundays
            ) {
                days += `<div class="day highlight" style="background-color: lightblue;">${i}</div>`;
                highlightedDays++; // Increment count of highlighted days
            } 
            // Mark today's date
            else if (
                i === new Date().getDate() &&
                currentMonth === new Date().getMonth() &&
                currentYear === new Date().getFullYear()
            ) {
                days += `<div class="day today">${i}</div>`;
            } 
            else {
                days += `<div class="day">${i}</div>`;
            }
        }

        // Render next month dates
        for (let j = 1; j <= nextDays; j++) {
            days += `<div class="day next">${j}</div>`;
        }

        daysContainer.innerHTML = days;
        toggleTodayBtn();
    };

    // Event listeners for navigation
    nextBtn.addEventListener("click", () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    });

    prevBtn.addEventListener("click", () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    });

    todayBtn.addEventListener("click", () => {
        currentMonth = new Date().getMonth();
        currentYear = new Date().getFullYear();
        renderCalendar();
    });

    function toggleTodayBtn() {
        if (
            currentMonth === new Date().getMonth() &&
            currentYear === new Date().getFullYear()
        ) {
            todayBtn.style.display = "none";
        } else {
            todayBtn.style.display = "flex";
        }
    }

    renderCalendar();
</script>


</body>

</html>
