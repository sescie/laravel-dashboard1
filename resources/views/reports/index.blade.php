<x-layout>
    <div class="report-container">
        <div class="report-head">
            <h3>Weekly Report (Week {{ $weekNumber }})</h3>
            <div class="report-scope">From - To</div>
        </div>

        <div class="heat-map-container">
            <h4 class="heat-map-heading">Energy Usage Heatmap (Last 7 Days)</h4>
            <div class="heat-map-graph">
                <canvas id="energy-usage-heatmap"></canvas>
            </div>
        </div>

        <div class="profit-or-loss-container">
            <p>You have used how many kilowatts more or less compared to last week.</p>
        </div>

        <div class="graphs-section">
            <div class="daily-usage-container">
                <div class="graph-header">
                    <h3>Daily Average Usage</h3>
                </div>
                <div class="daily-usage-graph">
                    <canvas id="daily-usage-chart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="peak-usage-map-container">
                <div class="graph-header">
                    <h3>Peak Usage Times</h3>
                </div>
                <div class="peak-usage-map">
                    <canvas id="peak-usage-map-chart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="predicted-usage-container">
            <div class="graph-header">
                <h3>Predicted Daily Average Usage</h3>
            </div>
            <div class="predicted-usage-graph">
                <canvas id="predicted-usage-chart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="most-used-appliances-container">
            <h2>Most Used Appliances</h2>
            <div class="appliance">Appliances go here</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Placeholder data for daily average usage, predicted usage, and peak usage times
            var energyUsageData = {!! json_encode($energyUsageData) !!};
            var predictedUsageData = {!! json_encode($predictedUsageData) !!};
            var peakUsageData = {!! json_encode($peakUsageData) !!};

            // Create line chart for daily average usage
            var ctx1 = document.getElementById('daily-usage-chart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: Array.from({ length: 7 }, (_, i) => 'Day ' + (i + 1)),
                    datasets: [{
                        label: 'Daily Average Usage (KW)',
                        data: energyUsageData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Create line chart for predicted daily average usage
            var ctx2 = document.getElementById('predicted-usage-chart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: Array.from({ length: 7 }, (_, i) => 'Day ' + (i + 1)),
                    datasets: [{
                        label: 'Predicted Daily Average Usage (KW)',
                        data: predictedUsageData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Create heatmap-like scatter plot for peak usage times
            var ctx3 = document.getElementById('peak-usage-map-chart').getContext('2d');
            var gradient = ctx3.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(255, 255, 255, 0)'); // Transparent at the top
            gradient.addColorStop(1, 'rgba(255, 0, 0, 1)');     // Red at the bottom
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: Array.from({ length: 24 }, (_, i) => i + ':00'), // X-axis labels from 0 to 23
                    datasets: [{
                        data: peakUsageData, // Peak usage data for each hour
                        backgroundColor: gradient,
                        borderWidth: 1,
                        borderColor: 'rgba(255, 0, 0, 1)',
                        barPercentage: 1, //
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                return tooltipItem.yLabel + ' KW';
                            }
                        }
                    }
                }
            });

            // Create heatmap-like scatter plot for energy usage
           

            // Function to generate scatter plot data
            function generateScatterData() {
                var data = [];
                // Loop through each day (7 days)
                for (var day = 0; day < 7; day++)
                {
                    // Loop through each hour (24 hours)
                    for (var hour = 0; hour < 24; hour++) {
                        // Calculate the index in the 1-dimensional array
                        var index = day * 24 + hour;
                        // Add the data point (hour, day, energy usage) to the array
                        data.push({
                            x: hour,
                            y: day + 1, // Add 1 to day to make it 1-based index
                            value: energyUsageData[index] // Energy usage value
                        });
                    }
                }
                return data;
            }

            // Function to generate colors for points based on energy usage
            function generatePointColors() {
                var colors = [];
                // Loop through each day (7 days)
                for (var day = 0; day < 7; day++) {
                    // Loop through each hour (24 hours)
                    for (var hour = 0; hour < 24; hour++) {
                        // Calculate the index in the 1-dimensional array
                        var index = day * 24 + hour;
                        // Get the energy usage value
                        var value = energyUsageData[index];
                        // Calculate color based on energy usage (example: brighter for higher usage)
                        var brightness = value / 100; // Adjust this value as needed
                        // Convert brightness to hex color (example: #FF0000 for red)
                        var hexColor = '#' + Math.floor(brightness * 255).toString(16).padStart(2, '0') + '0000'; // Red color
                        // Add the color to the colors array
                        colors.push(hexColor);
                    }
                }
                return colors;
            }
        });
    </script>
</x-layout>
