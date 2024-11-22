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
                <h1 class="mb-4">Donation History</h1>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Type</th>
                        <th>Blood Type</th>
                        <th>Breed</th>
                        <th>Age</th>
                    </thead>
                    <?php

                    try {
                        $query = "select * from DONATION_HISTORY dh 
                            JOIN BLOOD_TYPES bt ON dh.BloodTypeID = bt.BloodTypeID 
                            JOIN PETS p ON dh.PetID = p.PetID;
                        ";
                        $stmt = $pdo->query($query);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) { ?>
                                <tr>
                                    <td>
                                        <? echo $row['Pet_Name']; ?>
                                    </td>
                                    <td>
                                        <? echo $row['User_Fname'] . " " . $row['User_Lname']; ?>
                                    </td>
                                    <td>
                                        <? echo $row['Pet_Type']; ?>
                                    </td>
                                    <td>
                                        <? echo $row['Blood_Type_Name']; ?>
                                    </td>
                                    <td>
                                        <? echo $row['Pet_Breed']; ?>
                                    </td>
                                    <td>
                                        <? echo $row['Pet_Age']; ?>
                                    </td>
                                </tr>
                    <?php }
                        } else {
                            echo "<tr><td colspan='8' class='text-center text-muted'>No history found.</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='8' class='text-danger'>Error fetching history: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </table>

            </main>
        </div>
    </div>
</body>

</html>