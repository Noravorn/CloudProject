<?php include 'connect.php'; ?>
<?php
// Fetch data from the database
try {

    session_start();
    if (!isset($_SESSION['User_ID'])) {
        // Redirect or show an error if User_ID is not set
        echo "User ID not found in session.";
        exit;
    }

    $user_id = $_SESSION['User_ID'];

    $query = "
        SELECT 
            pets.Pet_Name AS pet_name,
            pets.Pet_Age AS pet_age,
            blood_types.Blood_Type_Name AS blood_type_name,
            pets.Pet_Breed AS pet_breed,
            clinics.Clinic_Name AS clinic_name
        FROM 
            USERS AS users
        LEFT JOIN 
            PETS AS pets ON users.User_Pet_ID = pets.Pet_ID
        LEFT JOIN 
            BLOOD_TYPES AS blood_types ON pets.Pet_Blood_Type_ID = blood_types.Blood_Type_ID
        LEFT JOIN 
            CLINICS AS clinics ON users.User_Clinic_ID = clinics.Clinic_ID
        WHERE 
            users.User_ID = :user_id";

    // Prepare the query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $data = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Data fetch failed: " . $e->getMessage();
    $data = [];
}

?>

<?php if (!empty($data)): ?>
    <div id="pet-info">
        <h3 class="mb-3">Pet Information</h3>
        <?php foreach ($data as $row): ?>
            <p>Pet Name: <span><?= htmlspecialchars($row['pet_name']) ?></span></p>
            <p>Pet Age: <span><?= htmlspecialchars($row['pet_age']) ?></span></p>
            <p>Pet Blood Type: <span><?= htmlspecialchars($row['blood_type_name']) ?></span></p>
            <p>Pet Breed: <span><?= htmlspecialchars($row['pet_breed']) ?></span></p>
            <p>Registered Clinic: <span><?= htmlspecialchars($row['clinic_name']) ?></span></p>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No data found.</p>
<?php endif; ?>