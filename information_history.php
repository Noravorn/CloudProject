<?php include 'connect.php'; ?>
<?php session_start(); ?>

<?php
try {
    $user_id = $_SESSION['User_ID'];

    // Query to fetch donation history
    $query = "
        SELECT 
            donation_history.Donation_Date AS donation_date,
            donors.User_Fname AS donor_first_name,
            donors.User_Lname AS donor_last_name,
            donor_pets.Pet_Name AS donor_pet_name,
            receivers.User_Fname AS receiver_first_name,
            receivers.User_Lname AS receiver_last_name,
            receiver_pets.Pet_Name AS receiver_pet_name,
            clinics.Clinic_Name AS clinic_name
        FROM 
            DONATION_HISTORY AS donation_history
        LEFT JOIN 
            USERS AS donors ON donation_history.Donor_ID = donors.User_ID
        LEFT JOIN 
            PETS AS donor_pets ON donation_history.Donor_Pet_ID = donor_pets.Pet_ID
        LEFT JOIN 
            USERS AS receivers ON donation_history.Receiver_ID = receivers.User_ID
        LEFT JOIN 
            PETS AS receiver_pets ON donation_history.Receiver_Pet_ID = receiver_pets.Pet_ID
        LEFT JOIN 
            CLINICS AS clinics ON donation_history.Clinic_ID = clinics.Clinic_ID
        WHERE 
            donation_history.Donor_ID = :user_id
            OR donation_history.Receiver_ID = :user_id
        ORDER BY 
            donation_history.Donation_Date DESC";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Data fetch failed: " . $e->getMessage();
    $data = [];
}
?>

<?php if (!empty($data)): ?>
    <div id="donation-history">
        <h3 class="mb-3">Donation History</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Donor</th>
                    <th>Donor's Pet</th>
                    <th>Receiver</th>
                    <th>Receiver's Pet</th>
                    <th>Clinic</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['donation_date']) ?></td>
                        <td><?= htmlspecialchars($row['donor_first_name'] . ' ' . $row['donor_last_name']) ?></td>
                        <td><?= htmlspecialchars($row['donor_pet_name']) ?></td>
                        <td><?= htmlspecialchars($row['receiver_first_name'] . ' ' . $row['receiver_last_name']) ?></td>
                        <td><?= htmlspecialchars($row['receiver_pet_name']) ?></td>
                        <td><?= htmlspecialchars($row['clinic_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No donation history found.</p>
<?php endif; ?>
