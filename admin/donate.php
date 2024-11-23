<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {

	// Sanitize input using htmlspecialchars to prevent XSS
	$Name = htmlspecialchars(filter_input(INPUT_POST, 'Name'));
	$BloodType = htmlspecialchars(filter_input(INPUT_POST, 'BloodType'));
	$Type = htmlspecialchars(filter_input(INPUT_POST, 'Type'));
	$Breed = htmlspecialchars(filter_input(INPUT_POST, 'Breed'));
	$Age = htmlspecialchars(filter_input(INPUT_POST, 'Age'));

	// Update query
	$stmt = $conn->prepare("INSERT INTO PETS(Pet_Name, Pet_Blood_Type_ID, Pet_Type, Pet_Breed, Pet_Age) VALUES (?, ?, ?, ?, ?) ");
	if ($stmt->execute([$Name, $BloodType, $Type, $Breed, $Age])) {
		header("Location: pet_page.php");
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
                        <label for="user_name">Owner Name: </label>
                        <select id="user-name" name="user_name" required>
                            <?php
                            
                            ?>
                        </select>
                        
                        <!-- Pet Name -->
                        <label for="pet_name">Pet Name:</label>
                        <input type="text" id="pet_name" name="pet_name" required>
                        
                        <!-- Pet Type -->
                        <label for="pet_type">Pet Type: </label>
                        <select name="pet_type" id="pet_type" required>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                        </select>
                        
                        <!-- Blood Type -->
                        <label for="blood-type">Blood Type: </label>
                        <select id="blood-type" name="blood_type" required>
                            <?php 
                                // Default pet type if form is not submitted
                                $pet_type = isset($_POST['pet_type']) ? $_POST['pet_type'] : 'dog';
                                
                                if ($pet_type == "cat") { ?>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                            <?php } elseif ($pet_type == "dog") { ?>
                                    <option value="dea_11">DEA 1.1</option>
                                    <option value="dea_12">DEA 1.2</option>
                                    <option value="dea_3">DEA 3</option>
                                    <option value="dea_4">DEA 4</option>
                                    <option value="dea_5">DEA 5</option>
                                    <option value="dea_6">DEA 6</option>
                                    <option value="dea_7">DEA 7</option>
                                    <option value="dea_8">DEA 8</option>
                            <?php } ?>
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
