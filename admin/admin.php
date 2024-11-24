<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Admin</title>
</head>

<?php include '../connect.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>

            <main class="col-md-10 p-4">

                <h1 class="mb-4">Dashboard</h1>

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

                <div class="row g-4 mt-4">
                    <?php
                    try {
                        // Fetch count of users, pets, and clinics
                        $query = "SELECT COUNT(*) AS user_count FROM USERS";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $userCount = $stmt->fetchColumn();

                        $query = "SELECT COUNT(*) AS pet_count FROM PETS";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $petCount = $stmt->fetchColumn();

                        $query = "SELECT COUNT(*) AS clinic_count FROM CLINICS";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $clinicCount = $stmt->fetchColumn();

                        // Prepare data for display
                        $counts = [
                            ['title' => 'Total Users', 'icon' => 'group', 'value' => $userCount, 'class' => 'primary'],
                            ['title' => 'Total Pets', 'icon' => 'paw', 'value' => $petCount, 'class' => 'success'],
                            ['title' => 'Total Clinics', 'icon' => 'hospital', 'value' => $clinicCount, 'class' => 'danger']
                        ];

                        // Display the cards
                        foreach ($counts as $count) { ?>
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
                    <?php }
                    } catch (PDOException $e) {
                        // Handle exceptions gracefully
                        echo "Error fetching data: " . $e->getMessage();
                    } ?>
                </div>

                <div class="mt-5">
                    <h2>Recent Donations</h2>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <th>Donor Name</th>
                            <th>Donor Pet</th>
                            <th>Receiver Name</th>
                            <th>Receiver Pet</th>
                            <th>Clinic</th>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $query = "SELECT 
                                        du.User_Fname AS Donor_FName,
                                        du.User_Lname AS Donor_LName,
                                        dp.Pet_Name AS Donor_Pet,
                                        ru.User_Fname AS Receiver_FName,
                                        ru.User_Lname AS Receiver_LName,
                                        rp.Pet_Name AS Receiver_Pet,
                                        c.Clinic_Name
                                    FROM DONATION_HISTORY dh
                                    JOIN PETS dp ON dh.Donor_Pet_ID = dp.Pet_ID
                                    JOIN USERS du ON du.User_ID = dh.Donor_ID
                                    JOIN PETS rp ON dh.Receiver_Pet_ID = rp.Pet_ID
                                    JOIN USERS ru ON ru.User_ID = dh.Receiver_ID
                                    JOIN CLINICS c ON c.Clinic_ID = dh.Clinic_ID
                                    LIMIT 5";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td><?php echo $row['Donor_FName'] . " " . $row['Donor_LName']; ?></td>
                                            <td><?php echo $row['Donor_Pet']; ?></td>
                                            <td><?php echo $row['Receiver_FName'] . " " . $row['Receiver_LName']; ?></td>
                                            <td><?php echo $row['Receiver_Pet']; ?></td>
                                            <td><?php echo $row['Clinic_Name']; ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No history found.</td>
                                    </tr>
                                <?php }
                            } catch (PDOException $e) { ?>
                                <tr>
                                    <td colspan="6" class="text-danger">Error fetching history: <?php echo htmlspecialchars($e->getMessage()); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Function to fetch blood type counts from the server
        async function fetchBloodTypeCounts(petType) {
            const response = await fetch(`fetch_blood_type_counts.php?pet_type=${petType}`);
            const data = await response.json();
            return data;
        }

        // Fetch data for dog and cat blood types
        async function loadCharts() {
            const dogBloodTypes = await fetchBloodTypeCounts('dog');
            const catBloodTypes = await fetchBloodTypeCounts('cat');

            // Create charts using the fetched data
            const dogChartCanvas = document.getElementById('dog-blood-types-chart');
            const catChartCanvas = document.getElementById('cat-blood-types-chart');

            const dogChart = new Chart(dogChartCanvas, {
                type: 'pie',
                data: {
                    labels: dogBloodTypes.labels,
                    datasets: [{
                        data: dogBloodTypes.counts,
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
                    labels: catBloodTypes.labels,
                    datasets: [{
                        data: catBloodTypes.counts,
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
        }

        // Load charts on page load
        window.onload = loadCharts;
    </script>
</body>

</html>