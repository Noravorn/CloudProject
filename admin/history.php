<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>

            <main class="col-md-10 p-4">
                <h1 class="mb-4">Current Storage</h1>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <th>Donor Name</th>
                        <th>Pet Name</th>
                        <th>Blood type</th>
                        <th>Clinic</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $query = "SELECT 
                                s.Storage_ID, 
                                du.User_Fname AS Donor_FName,
                                du.User_Lname AS Donor_LName,
                                dp.Pet_Name AS Donor_Pet,
                                bt.Blood_Type_Name AS Pet_Blood,
                                c.Clinic_Name
                            FROM STORAGE s
                            JOIN USERS du ON du.User_ID = s.Donor_ID
                            JOIN PETS dp ON du.User_Pet_ID = dp.Pet_ID
                            JOIN BLOOD_TYPES bt ON bt.Blood_Type_ID = dp.Pet_Blood_type_ID
                            JOIN CLINICS c ON c.Clinic_ID = s.Clinic_ID";

                            $stmt = $pdo->prepare($query);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?php echo $row['Donor_FName'] . " " . $row['Donor_LName']; ?></td>
                                        <td><?php echo $row['Donor_Pet']; ?></td>
                                        <td><?php echo $row['Pet_Blood']; ?></td>
                                        <td><?php echo $row['Clinic_Name']; ?></td>
                                        <td>
                                            <a href='delete_info.php?id=<?php echo $row['Storage_ID']; ?>&type=storage' class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this storage?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No history found.</td>
                                </tr>
                            <?php }
                        } catch (PDOException $e) { ?>
                            <tr>
                                <td colspan="6" class="text-danger">Error fetching storage: <?php echo htmlspecialchars($e->getMessage()); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h1 class="mb-4">Donation History</h1>
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
                                    JOIN CLINICS c ON c.Clinic_ID = dh.Clinic_ID";

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
            </main>
        </div>
    </div>
</body>

</html>