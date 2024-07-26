<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .main-container {
        display: flex;
        gap: 10%;
        margin-top: 30px;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="main-container">

        <div class="card" style="width: 500px;">
            <div class="card-body">
                <h5 class="card-title">Monthly Rent Collections and Due</h5>
                <canvas id="myChart" height="200" width="300"></canvas>
            </div>
        </div>

        <div class="card" style="width: 500px;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Current Occupancy Rate</h5>
                    <canvas id="occupancyRateChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM fully loaded and parsed');

        // Dummy data for the graph
        const labels = ['January', 'February', 'March', 'April', 'May', 'June'];
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Rent Collected',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    data: [1200, 1900, 3000, 5000, 2000, 3000],
                    borderRadius: 5,
                },
                {
                    label: 'Rent Due',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    data: [1500, 2100, 3200, 4500, 2500, 3500],
                    borderRadius: 5,
                      
                }
            ]
        };

        // Data for Current Occupancy Rate
        const occupancyRateData = {
            labels: ['Occupied', 'Vacant'],
            datasets: [{
                data: [80, 20],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        };

        const barChartConfig = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        formatter: function (value) {
                            return '$' + value;
                        },
                        color: '#333',
                        font: {
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '$' + context.raw;
                                return label;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '$' + value;
                            }
                        }
                    }
                },
            }
        };


        const doughnutChartConfig = {
            type: 'doughnut',
            data: occupancyRateData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                animation: {
                    delay: 1,
                },
            }
        };


        // Render the bar chart
        console.log('Rendering bar chart');
        const myChart = new Chart(
            document.getElementById('myChart'),
            barChartConfig
        );

        // Render the doughnut chart
        console.log('Rendering doughnut chart');
        const occupancyRateChart = new Chart(
            document.getElementById('occupancyRateChart'),
            doughnutChartConfig
        );

        // Log chart instances to ensure they're created correctly
        console.log('Bar chart instance:', myChart);
        console.log('Doughnut chart instance:', occupancyRateChart);
    });
</script>