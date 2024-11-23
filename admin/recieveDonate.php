<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    // Sanitize input using htmlspecialchars to prevent XSS
    $DonorID = htmlspecialchars(filter_input(INPUT_POST, 'donor-name'));
    $stmt = $pdo->prepare("SELECT Pet_ID FROM PETS p JOIN USERS u ON u.User_Pet_ID = p.Pet_ID WHERE u.User_ID = ?");
    $stmt->execute([$DonorID]);
    $DonorPetId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $RecieverID = htmlspecialchars(filter_input(INPUT_POST, 'receiver-name'));
    $stmt = $pdo->prepare("SELECT Pet_ID FROM PETS p JOIN USERS u ON u.User_Pet_ID = p.Pet_ID WHERE u.User_ID = ?");
    $stmt->execute([$DonorID]);
    $ReceiverPetId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $Clinic = htmlspecialchars(filter_input(INPUT_POST, 'clinic'));
    $currentTimestamp = date('d-m-Y');

    // Update query
    if ($DonorID == $RecieverID) {
        $error = "Donor and receiver cannot be the same person.";
        printf($error);
    } else {
        $stmt = $pdo->prepare("INSERT INTO DONATION_HISTORY(Clinic_ID, Donor_ID, Donor_Pet_ID, Receiver_ID, Receiver_Pet_ID, Donation_Date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$Clinic, $DonorID, $DonorPetId, $ReceiverID, $ReceiverPetId, $currentTimestamp]);

        if ($stmt->rowCount() > 0) {
            header("Location: history.php");
            exit();
        } else {
            $error = "Insert failed";
        }
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
                <h2>Donate Blood</h2>
                <div class="donate_form">
                    <form action="recieveDonate.php" method="post">
                        <!-- Donor Name -->
                        <label for="donor-name">Donor Name: </label>
                        <select id="donor-name" name="donor-name" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM USERS");
                            $stmt->execute();
                            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($user as $user) {
                                echo "<option value='" . htmlspecialchars($user['User_ID']) . "'>" . htmlspecialchars($user['User_Fname'] . " " . $user['User_Lname']) . "</option>";
                            }
                            ?>
                        </select>

                        <!-- Receiver Name -->
                        <label for="receiver-name">Receiver Name: </label>
                        <select id="receiver-name" name="receiver-name" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM USERS");
                            $stmt->execute();
                            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($user as $user) {
                                echo "<option value='" . htmlspecialchars($user['User_ID']) . "'>" . htmlspecialchars($user['User_Fname'] . " " . $user['User_Lname']) . "</option>";
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
                        <input type="submit" id="submit" value="Submit">
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

    form input {
        width: auto;
        height: 40px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    form select {
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