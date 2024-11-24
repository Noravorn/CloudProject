<?php
include('../connect.php');

// Get the `id` and `type` from the URL parameters
$id = isset($_GET['id']) ? intval($_GET['id']) : null; // Ensure ID is numeric
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : null;

// Get the referring page
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin.php'; // Default to 'admin.php' if no referrer

if ($id && $type) {
    try {
        // Determine table based on `type`
        switch ($type) {
            case 'clinic':
                $sql = "DELETE FROM CLINICS WHERE Clinic_ID = ?";
                break;
            case 'pet':
                
                try {
                    $pdo->beginTransaction();
                
                    // Update users to remove reference to the pet
                    $update_stmt = $pdo->prepare("UPDATE USERS SET User_Pet_ID = NULL WHERE User_Pet_ID = ?");
                    $update_stmt->execute([$id]);
                
                    $pdo->commit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    echo "Error: " . $e->getMessage();
                }

                $sql = "DELETE FROM PETS WHERE Pet_ID = ?";
                break;
            case 'user':
                $sql = "DELETE FROM USERS WHERE User_ID = ?";
                break;
            case 'storage':
                $sql = "DELETE FROM STORAGE WHERE Storage_ID = ?";
                break;
            default:
                throw new Exception("Invalid deletion type.");
        }

        // Execute the deletion query
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            // Redirect back to the referring page
            header("Location: $referrer");
            exit();
        } else {
            throw new Exception("Deletion failed. ID not found.");
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request. No ID or type provided.";
}
