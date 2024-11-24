<?php
include '../connect.php';

$petType = $_GET['pet_type'];

if ($petType === 'dog') {
    // Query for dog blood types and counts
    $query = "SELECT bt.Blood_Type_Name, COUNT(p.Pet_ID) AS count
              FROM PETS p
              JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID
              WHERE p.Pet_Type = 'Dog'
              GROUP BY bt.Blood_Type_Name";
} else if ($petType === 'cat') {
    // Query for cat blood types and counts
    $query = "SELECT bt.Blood_Type_Name, COUNT(p.Pet_ID) AS count
              FROM PETS p
              JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID
              WHERE p.Pet_Type = 'Cat'
              GROUP BY bt.Blood_Type_Name";
}

$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$counts = [];
foreach ($results as $row) {
    $labels[] = $row['Blood_Type_Name'];
    $counts[] = $row['count'];
}

$response = ['labels' => $labels, 'counts' => $counts];
header('Content-Type: application/json');
echo json_encode($response);
