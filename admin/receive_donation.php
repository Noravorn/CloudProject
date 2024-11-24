<!DOCTYPE html>
<html lang="en">

<?php
include '../header.php';
include '../connect.php';
?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    // Sanitize inputs to prevent XSS
    $DonorID = htmlspecialchars(filter_input(INPUT_POST, 'donor-name', FILTER_SANITIZE_NUMBER_INT));
    $ReceiverID = htmlspecialchars(filter_input(INPUT_POST, 'receiver-name', FILTER_SANITIZE_NUMBER_INT));
    $ClinicID = htmlspecialchars(filter_input(INPUT_POST, 'clinic', FILTER_SANITIZE_NUMBER_INT));
    $currentTimestamp = date('Y-m-d H:i:s'); // Use proper timestamp format

    try {
        // Fetch donor pet ID
        $stmt = $pdo->prepare("SELECT Pet_ID FROM PETS p JOIN USERS u ON u.User_Pet_ID = p.Pet_ID WHERE u.User_ID = ?");
        $stmt->execute([$DonorID]);
        $DonorPetId = $stmt->fetchColumn();

        if (!$DonorPetId) {
            echo "<p style='color: red;'>Error: Donor pet not found.</p>";
            exit;
        }

        // Fetch receiver pet ID
        $stmt = $pdo->prepare("SELECT Pet_ID FROM PETS p JOIN USERS u ON u.User_Pet_ID = p.Pet_ID WHERE u.User_ID = ?");
        $stmt->execute([$ReceiverID]);
        $ReceiverPetId = $stmt->fetchColumn();

        if (!$ReceiverPetId) {
            echo "<p style='color: red;'>Error: Receiver pet not found.</p>";
            exit;
        }

        // Insert into donation history
        $stmt = $pdo->prepare("INSERT INTO DONATION_HISTORY 
            (Clinic_ID, Donor_ID, Donor_Pet_ID, Receiver_ID, Receiver_Pet_ID, Donation_Date) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$ClinicID, $DonorID, $DonorPetId, $ReceiverID, $ReceiverPetId, $currentTimestamp]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>Donation history successfully added!</p>";
            header("Location: history.php");
            exit();
        } else {
            echo "<p style='color: red;'>Error: Failed to add donation history.</p>";
        }

    } catch (PDOException $e) {
        // Handle database errors
        echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
    } catch (Exception $e) {
        // Handle general errors
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Receive Donation</h2>
                <div class="donate_form">
                    <form action="receive_donation.php" method="post">
                        <!-- Donor Name -->
                        <label for="donor-name">Donor Name: </label>
                        <select id="donor-name" name="donor-name" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM STORAGE s JOIN USERS u ON u.User_ID = s.Donor_ID JOIN PETS p ON u.User_Pet_ID = p.Pet_ID JOIN BLOOD_TYPES bt ON bt.Blood_Type_ID = p.Pet_Blood_type_ID");
                            $stmt->execute();
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($users as $user) {
                                echo "<option value='" . htmlspecialchars($user['Donor_ID']) . "'>" . htmlspecialchars($user['User_Fname'] . " " . $user['User_Lname'] . " : "
                                    . $user['Pet_Name'] . " : " . $user['Blood_Type_Name']) . "</option>";
                            }
                            ?>
                        </select>

                        <!-- Receiver Name -->
                        <label for="receiver-name">Receiver Name: </label>
                        <select id="receiver-name" name="receiver-name" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM USERS u JOIN PETS p ON u.User_Pet_ID = p.Pet_ID JOIN BLOOD_TYPES bt ON bt.Blood_Type_ID = p.Pet_Blood_type_ID");
                            $stmt->execute();
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($users as $user) {
                                echo "<option value='" . htmlspecialchars($user['User_ID']) . "'>" . htmlspecialchars($user['User_Fname'] . " " . $user['User_Lname'] . " : "
                                    . $user['Pet_Name'] . " : " . $user['Blood_Type_Name']) . "</option>";
                            }
                            ?>
                        </select>

                        <!-- Clinic Selection -->
                        <label for="clinic">From Clinic: </label>
                        <select name="clinic" id="clinic" required>
                            <?php
                            // Fetch clinic names from the database using PDO
                            $stmt = $pdo->prepare("SELECT * FROM CLINICS");
                            $stmt->execute();
                            $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($clinics as $clinic) {
                                echo "<option value='" . htmlspecialchars($clinic['Clinic_ID']) . "'>" . htmlspecialchars($clinic['Clinic_Name']) . "</option>";
                            }
                            ?>
                        </select>

                        <!-- Submit Button -->
                        <input type="submit" id="submit" name="submit" value="Submit">
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

<style>
    main h2 {
        text-align: center;
    }

    .donate_form {
        display: flex;
        flex-direction: column;
        align-items: left;
        padding-left: 20%;
        padding-right: 20%;
        background: var(--secondary-color);
    }

    form {
        display: grid;
        grid-template-columns: repeat(1, 7fr);
        gap: 1.1rem;
        margin-bottom: 2rem;
        border: 4px solid rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 20px;
        background: var(--secondary-color);
    }

    form input, form select {
        width: auto;
        height: 40px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    form input[type="submit"] {
        cursor: pointer;
        width: auto;
        height: 40px;
        border-radius: 5px;
    }
</style>

</html>
