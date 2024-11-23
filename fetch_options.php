<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'] ?? '';

    try {
        $query = '';
        if ($type === 'cities') {
            $query = "SELECT DISTINCT City_Name FROM CITIES";
        } elseif ($type === 'bloodTypes') {
            $query = "SELECT DISTINCT Blood_Type_Name FROM BLOOD_TYPES";
        } elseif ($type === 'petSpecies') {
            $query = "SELECT DISTINCT Pet_Type FROM PETS";
        }

        if ($query) {
            $stmt = $pdo->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
            header('Content-Type: application/json');
            echo json_encode($results);
        } else {
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
}

?>
