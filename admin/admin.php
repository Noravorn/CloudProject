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
                    $query = "SELECT COUNT(User_ID) as cU FROM USERS";
                    $stmt = $pdo->query($query);
                    $userCount = $stmt->fetch();

                    $query = "SELECT COUNT(Pet_ID) as cP FROM PETS";
                    $stmt = $pdo->query($query);
                    $petCount = $stmt->fetch();

                    $query = "SELECT COUNT(Clinic_ID) as cC FROM CLINICS";
                    $stmt = $pdo->query($query);
                    $clinicCount = $stmt->fetch();

                    $counts = [
                        ['title' => 'Total Users', 'icon' => 'group', 'value' => $userCount, 'class' => 'primary'],
                        ['title' => 'Total Pets', 'icon' => 'paw', 'value' => $petCount, 'class' => 'success'],
                        ['title' => 'Total Clinics', 'icon' => 'hospital', 'value' => $clinicCount, 'class' => 'danger']
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
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <th>Donor Name</th>
                            <th>Donor Pet</th>
                            <th>Receiver Name</th>
                            <th>Receiver Pet</th>
                            <th>Clinic</th>
                            <th>Date</th>
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
                                        c.Clinic_Name,
                                        dh.Donation_Date
                                    FROM DONATION_HISTORY dh
                                    JOIN PETS dp ON dh.Donor_Pet_ID = dp.Pet_ID
                                    JOIN USERS du ON du.User_ID = dh.Donor_ID
                                    JOIN PETS rp ON dh.Receiver_Pet_ID = rp.Pet_ID
                                    JOIN USERS ru ON ru.User_ID = dh.Receiver_ID
                                    JOIN CLINICS c ON c.Clinic_ID = dh.Clinic_ID
                                    ORDER BY Donation_Date DESC
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
                                            <td><?php echo $row['Donation_Date']; ?></td>
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
</body>

<script>
    // Script for rendering charts
    const dogChartCanvas = document.getElementById('dog-blood-types-chart');
    const catChartCanvas = document.getElementById('cat-blood-types-chart');
    <?php
    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 1.1'";
    $stmt = $pdo->query($query);
    $TypeCountD1 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 1.2'";
    $stmt = $pdo->query($query);
    $TypeCountD2 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 3'";
    $stmt = $pdo->query($query);
    $TypeCountD3 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 4'";
    $stmt = $pdo->query($query);
    $TypeCountD4 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 5'";
    $stmt = $pdo->query($query);
    $TypeCountD5 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 6'";
    $stmt = $pdo->query($query);
    $TypeCountD6 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 7'";
    $stmt = $pdo->query($query);
    $TypeCountD7 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
								JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'DEA 8'";
    $stmt = $pdo->query($query);
    $TypeCountD8 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
                    JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
                    JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'A'";
    $stmt = $pdo->query($query);
    $TypeCountC1 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
                    JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
                    JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'B'";
    $stmt = $pdo->query($query);
    $TypeCountC2 = $stmt->fetch();

    $query = "SELECT COUNT(Pet_ID) FROM PETS p
                    JOIN USERS u ON u.User_Pet_ID = p.Pet_ID 
                    JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID WHERE bt.Blood_Type_Name = 'AB'";
    $stmt = $pdo->query($query);
    $TypeCountC3 = $stmt->fetch();
    ?>

    const dogChart = new Chart(dogChartCanvas, {
        type: 'pie',
        data: {
            labels: ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'],
            datasets: [{
                // data: [$TypeCountD1, $TypeCountD2, $TypeCountD3, $TypeCountD4, $TypeCountD5, $TypeCountD6, $TypeCountD7, $TypeCountD8],
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
                // data: [$TypeCountC1, $TypeCountC2, $TypeCountC3],
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