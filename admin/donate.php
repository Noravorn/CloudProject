<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	// Sanitize input using htmlspecialchars to prevent XSS
	$UserID = htmlspecialchars(filter_input(INPUT_POST, 'user-name'));
    $stmt = $pdo->prepare("SELECT Pet_Blood_type_ID FROM PETS p JOIN USERS u ON u.User_Pet_ID = p.Pet_ID WHERE u.User_ID = ?");
    $stmt->execute([$UserID]);
	$PetBloodId = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$Clinic = htmlspecialchars(filter_input(INPUT_POST, 'clinic'));

	// Update query
    $stmt = $pdo->prepare("INSERT INTO STORAGE(Clinic_ID, Donor_ID, Blood_Type_ID) VALUES (?, ?, ?)");
    $stmt->execute([$Clinic, $UserID, $PetBloodId]);
    
    if ($stmt->rowCount() > 0) {
        header("Location: admin.php");
        exit();
    } else {
        $error = "Insert failed";
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
                    <form action="donate.php" method="post">
                        <!-- Owner Name -->
                        <label for="user-name">Owner Name: </label>
                        <select id="user-name" name="user-name" required>
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
                        <input type="submit" name="submit" value="Submit">
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
