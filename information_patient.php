<?php include 'connect.php'; ?>
<?php session_start(); ?>
<?php

// Fetch data from the database
try {

    $user_id = $_SESSION['User_ID'];

    $query = "
        SELECT 
            users.User_Title_ID AS title_id,
            titles.Title_Name AS title_name,
            users.User_Fname AS first_name,
            users.User_Lname AS last_name,
            users.User_Email AS email,
            users.User_Phone_Number AS phone,
            users.User_Address AS address
        FROM 
            USERS AS users
        JOIN 
            TITLES AS titles ON users.User_Title_ID = titles.Title_ID
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
    <div id="patient-info">
        <h3 class="mb-3">Patient Information</h3>
        <?php foreach ($data as $row): ?>
            <p>Owner Title: <span><?= htmlspecialchars($row['title_name']) ?></span></p>
            <p>Owner Name: <span><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></span></p>
            <p>Owner Email: <span><?= htmlspecialchars($row['email']) ?></span></p>
            <p>Owner Phone: <span><?= htmlspecialchars($row['phone']) ?></span></p>
            <p>Address: <span><?= htmlspecialchars($row['address']) ?></span></p>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No data found.</p>
<?php endif; ?>