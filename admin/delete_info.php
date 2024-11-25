<?php
include('../connect.php');

// Get the id and type from the URL parameters
$id = isset($_GET['id']) ? intval($_GET['id']) : null; // Ensure ID is numeric
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : null;

// Get the referring page
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin.php'; // Default to 'admin.php' if no referrer

if ($id && $type) {
    try {
        // Start transaction
        $pdo->beginTransaction();

        // Determine table and handle foreign key constraints based on type
        switch ($type) {
            case 'clinic':
                // Delete related records in DONATION_HISTORY and STORAGE
                $stmt = $pdo->prepare("DELETE FROM DONATION_HISTORY WHERE Clinic_ID = ?");
                $stmt->execute([$id]);

                // Delete related records in STORAGE
                $stmt = $pdo->prepare("DELETE FROM STORAGE WHERE Clinic_ID = ?");
                $stmt->execute([$id]);

                // Delete from CLINICS
                $sql = "DELETE FROM CLINICS WHERE Clinic_ID = ?";
                break;

            case 'pet':
                // Update DONATION_HISTORY to set Donor_Pet_ID and Receiver_Pet_ID to NULL for the deleted pet
                $stmt = $pdo->prepare("UPDATE DONATION_HISTORY SET Donor_Pet_ID = NULL WHERE Donor_Pet_ID = ?");
                $stmt->execute([$id]);

                // Update DONATION_HISTORY to set Receiver_Pet_ID to NULL for the deleted pet
                $stmt = $pdo->prepare("UPDATE DONATION_HISTORY SET Receiver_Pet_ID = NULL WHERE Receiver_Pet_ID = ?");
                $stmt->execute([$id]);

                // Update USERS table to set User_Pet_ID to NULL for the deleted pet
                $stmt = $pdo->prepare("UPDATE USERS SET User_Pet_ID = NULL WHERE User_Pet_ID = ?");
                $stmt->execute([$id]);

                // Delete from PETS
                $sql = "DELETE FROM PETS WHERE Pet_ID = ?";
                break;

            case 'user':
                // Update DONATION_HISTORY to set Donor_ID and Receiver_ID to NULL for the user
                $stmt = $pdo->prepare("UPDATE DONATION_HISTORY SET Donor_ID = NULL WHERE Donor_ID = ?");
                $stmt->execute([$id]);

                // Update DONATION_HISTORY to set Receiver_ID to NULL for the user
                $stmt = $pdo->prepare("UPDATE DONATION_HISTORY SET Receiver_ID = NULL WHERE Receiver_ID = ?");
                $stmt->execute([$id]);

                // Update STORAGE to set Donor_ID to NULL for the user
                $stmt = $pdo->prepare("UPDATE STORAGE SET Donor_ID = NULL WHERE Donor_ID = ?");
                $stmt->execute([$id]);

                // Delete from USERS
                $sql = "DELETE FROM USERS WHERE User_ID = ?";
                break;

            case 'storage':
                // Direct deletion from STORAGE
                $sql = "DELETE FROM STORAGE WHERE Storage_ID = ?";
                break;

            default:
                throw new Exception("Invalid deletion type.");
        }

        // Execute the main deletion query
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            // Commit the transaction
            $pdo->commit();

            // Redirect back to the referring page
            header("Location:$referrer");
            exit();
        } else {
            throw new Exception("Deletion failed. ID not found.");
        }
    } catch (Exception $e) {
        // Roll back the transaction on error
        $pdo->rollBack();
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request. No ID or type provided.";
}
