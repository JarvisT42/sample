  // Function to wrap long text into multiple lines
  function wrapText(text, maxLineLength) {
    const words = text.split(' ');
    let lines = [];
    let currentLine = words[0];

    for (let i = 1; i < words.length; i++) {
        if (currentLine.length + words[i].length + 1 <= maxLineLength) {
            currentLine += ' ' + words[i];
        } else {
            lines.push(currentLine);
            currentLine = words[i];
        }
    }
    lines.push(currentLine); // Add the last line
    return lines;
}

// Prepare data for Chart.js
const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const dataset = {
    labels: labels,
    datasets: [{
        label: 'Borrowings',
        data: [],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)', // Colors for each bar
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)',
            'rgba(83, 102, 255, 0.2)',
            'rgba(170, 102, 255, 0.2)',
            'rgba(255, 202, 86, 0.2)',
            'rgba(99, 132, 255, 0.2)',
            'rgba(54, 235, 162, 0.2)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)',
            'rgba(83, 102, 255, 1)',
            'rgba(170, 102, 255, 1)',
            'rgba(255, 202, 86, 1)',
            'rgba(99, 132, 255, 1)',
            'rgba(54, 235, 162, 1)'
        ],
        borderWidth: 1
    }]
};

// Populate the data from the PHP results
labels.forEach((month, index) => {
    const monthData = chartData[index + 1]; // Month numbers in PHP are 1-indexed (January is 1, not 0)
    if (monthData) {
        // Push the borrow count for each month
        dataset.datasets[0].data.push(monthData.quantity);
    } else {
        dataset.datasets[0].data.push(0); // If no data for the month, push 0
    }
});

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: dataset,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true, // Start at zero
                title: {
                    display: true,
                    text: 'Times Borrowed'
                },
                ticks: {
                    stepSize: 1, // Set the interval for each step to 1
                    callback: function(value) { // Format the labels as integers
                        if (value % 1 === 0) {
                            return value;
                        }
                    }
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Months'
                }
            }
        },
        plugins: {
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: `Most Borrowed Books per Month for ${currentYear}`
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const monthIndex = tooltipItem.dataIndex + 1; // Get the 1-indexed month
                        const monthData = chartData[monthIndex]; // Get data for that month
                        if (monthData && monthData.titles.length > 0) {
                            const maxLineLength = 30; // Max characters per line before wrapping
                            const wrappedTitles = monthData.titles.map(title => wrapText(title, maxLineLength));
                            const flatTitles = wrappedTitles.flat(); // Flatten array of arrays
                            return flatTitles.concat(`${tooltipItem.raw} times borrowed`);
                        } else {
                            return `No data for this month`;
                        }
                    }
                }
            }
        }
    }
});