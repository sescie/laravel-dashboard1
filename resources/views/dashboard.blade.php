<x-layout>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }
    </style>
    <div class="main-dash-container">
        <h5 class="side-menu-headings">Building Analysis</h5>

        <div class="visualization-section">
            <div class="energy-summary">
                <h4 class="energy-consumption-heading">Energy Consumption</h4>
                <div class="summary-data">
                    <div class="data-item">
                        <small class="summary-sub-heading">Last 24 Hours</small>
                        <strong class="summary-kWh">{{ $last24 }} KW</strong>
                    </div>
                    <div class="data-item">
                        <small class="summary-sub-heading">Last 7 days</small>
                        <strong class="summary-kWh">{{ $lastWeek }} kW</strong>
                    </div>
                    <div class="data-item">
                        <small class="summary-sub-heading">Last 30 days</small>
                        <strong class="summary-kWh">{{ $lastMonth }} KW</strong>
                    </div>
                </div>
            </div>

            <div class="energy-summary">
                <h4 class="energy-consumption-heading">Alert Type</h4>
                <div class="summary-data">
                    <div class="data-item">
                        <small class="summary-sub-heading">High Energy Consumption</small>
                        <strong class="summary-kWh">24</strong>
                    </div>
                    <div class="data-item">
                        <small class="summary-sub-heading">Temperature Alert</small>
                        <strong class="summary-kWh">12</strong>
                    </div>
                    <div class="data-item">
                        <small class="summary-sub-heading">Humidity Alert</small>
                        <strong class="summary-kWh">5</strong>
                    </div>
                    <div class="data-item">
                        <small class="summary-sub-heading">Maintenance Required</small>
                        <strong class="summary-kWh">9</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="visualization-detail-section">
            <div class="graph-section">
                <div class="graph-header">
                    <h4 class="energy-consumption-heading">Energy Consumption by
                        <div class="filter-btns">
                            <button class="filters" id="last24-button">last 24 Hrs</button>
                            <button class="filters" id="last168-button">last 7 Days</button>
                            <button class="filters" id="last720-button">last month</button>
                        </div>
                    </h4>
                </div>
                <div class="graph-images">
                    <canvas id="myChart" width="800" height="400"></canvas>
                    <input type="hidden" id="energyUsedTotal" value="{{ json_encode($energyUsedTotal) }}">
                </div>
            </div>
        </div>

        <div class="details-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Current Usage</th>
                        <th>Average Daily Consumption</th>
                        <th>Deviation from Average</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($energyUsed as $energy)
                        <tr>
                            <td>{{ $energy->appliance->name }}</td>
                            <td>{{ $energy->KW }} KW</td>
                            <td>{{ number_format($averageDaily, 2) }} KW</td>
                            <td>
                                <span>{{ number_format((($energy->KW - $averageDaily) / $averageDaily) * 100, 2) }}&#37</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const energyUsed = JSON.parse(document.getElementById('energyUsedTotal').value);

            function array_chunk(arr, size) {
                const chunked = [];
                for (let i = 0; i < arr.length; i += size) {
                    chunked.push(arr.slice(i, i + size));
                }
                return chunked;
            }

            const last24 = array_chunk(energyUsed, 24).map(chunk => chunk.reduce((a, b) => a + b.KW, 0));
            const last168 = array_chunk(energyUsed, 168).map(chunk => chunk.reduce((a, b) => a + b.KW, 0));
            const last720 = array_chunk(energyUsed, 720).map(chunk => chunk.reduce((a, b) => a + b.KW, 0));

            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [...Array(last24.length).keys()].map(i => `Hour ${i + 1}`),
                    datasets: [{
                        label: 'KW',
                        data: last24,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Energy Consumption (Last 24 Hours)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'KW'
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)',
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Hours'
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)',
                            }
                        }
                    }
                }
            });

            const last24Button = document.getElementById('last24-button');
            const last168Button = document.getElementById('last168-button');
            const last720Button = document.getElementById('last720-button');

            last24Button.addEventListener('click', () => {
                updateChartData(last24, 'Energy Consumption (Last 24 Hours)', 'Hours');
            });

            last168Button.addEventListener('click', () => {
                updateChartData(last168, 'Energy Consumption (Last 7 Days)', 'Days');
            });

            last720Button.addEventListener('click', () => {
                updateChartData(last720, 'Energy Consumption (Last 30 Days)', 'Days');
            });

            function updateChartData(data, title, xLabel) {
                chart.data.labels = [...Array(data.length).keys()].map(i => `${xLabel} ${i + 1}`);
                chart.data.datasets[0].data = data;
                chart.options.plugins.title.text = title;
                chart.options.scales.x.title.text = xLabel;
                chart.update();
            }
        });
    </script>
</x-layout>
