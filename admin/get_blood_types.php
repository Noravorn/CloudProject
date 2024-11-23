<?php
include '../connect.php';

// Sanitize input to prevent SQL injection
$petType = filter_var($_GET['pet_type']);

// Prepare and execute the query based on pet type
try {
    if ($petType === 'dog') {
        $query = "SELECT * FROM BLOOD_TYPES WHERE Blood_Type_Name LIKE '%DES%'";
    } else {
        $query = "SELECT * FROM BLOOD_TYPES WHERE Blood_Type_Name NOT LIKE '%DES%'";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $bloodTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($bloodTypes);
} catch (PDOException $e) {
    // Handle errors gracefully, e.g., log the error and send an error response
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}