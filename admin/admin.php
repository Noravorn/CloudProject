<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                
                <h1 class="mb-4">Dashboard</h1>

                <!-- Insights -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <i class="bi bi-paw"></i> Total Dog Blood Types
                            </div>
                            <div class="card-body">
                                <canvas id="dog-blood-types-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <i class="bi bi-paw"></i> Total Cat Blood Types
                            </div>
                            <div class="card-body">
                                <canvas id="cat-blood-types-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counts -->
                <div class="row g-4 mt-4">
                    <?php
                    $counts = [
                        ['title' => 'Total Users', 'icon' => 'group', 'value' => 233, 'class' => 'primary'],
                        ['title' => 'Total Pets', 'icon' => 'paw', 'value' => 657, 'class' => 'success'],
                        ['title' => 'Total Clinics', 'icon' => 'hospital', 'value' => 211, 'class' => 'danger']
                    ];

                    foreach ($counts as $count):
                    ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-<?= $count['class']; ?> text-white">
                                    <i class="bi bi-<?= $count['icon']; ?>"></i> <?= $count['title']; ?>
                                </div>
                                <div class="card-body text-center">
                                    <h1><?= $count['value']; ?></h1>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- End of Counts -->

                <!-- Recent Donations -->
                <div class="mt-5">
                    <h2>Recent Donations</h2>
                    <!-- Add dynamic table or list for recent donations -->
                </div>
            </main>
        </div>
    </div>
</body>

<script>
    // Script for rendering charts
    const dogChartCanvas = document.getElementById('dog-blood-types-chart');
    const catChartCanvas = document.getElementById('cat-blood-types-chart');

    const dogChart = new Chart(dogChartCanvas, {
        type: 'pie',
        data: {
            labels: ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'],
            datasets: [{
                data: [90, 50, 25, 10, 5, 2, 1],
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#7E57C2', '#C9CBCE'
                ]
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Dog Blood Types'
                }
            }
        }
    });

    const catChart = new Chart(catChartCanvas, {
        type: 'pie',
        data: {
            labels: ['A', 'B', 'AB'],
            datasets: [{
                data: [30, 20, 15],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Cat Blood Types'
                }
            }
        }
    });
</script>

</html>