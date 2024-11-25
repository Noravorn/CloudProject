<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
    $id = $_GET['id'];

    // Sanitize inputs
    $Name = htmlspecialchars(filter_var($_POST['Name']));
    $City = filter_var($_POST['City'], FILTER_SANITIZE_NUMBER_INT); // Assuming City_ID is an integer
    $Address = htmlspecialchars(filter_var($_POST['Address']));
    $PhoneNumber = htmlspecialchars(filter_var($_POST['PhoneNumber']));
    $OpenTime = htmlspecialchars(filter_var($_POST['OpenTime']));
    $CloseTime = htmlspecialchars(filter_var($_POST['CloseTime']));

    // Update query
    $stmt = $pdo->prepare("UPDATE CLINICS SET Clinic_Name = ?, Clinic_City_ID = ?, Clinic_Address = ?, Clinic_Phone_Number = ?, Clinic_Open_Time = ?, Clinic_Close_Time = ? WHERE Clinic_ID = ?");

    try {
        $stmt->execute([$Name, $City, $Address, $PhoneNumber, $OpenTime, $CloseTime, $id]);
        header("Location:clinic_manage.php");
        exit();
    } catch (PDOException $e) {
        // Log the error and display a user-friendly message
        error_log("Update failed: " . $e->getMessage());
        $error = "An error occurred while updating the clinic. Please try again later.";
    }
}

// Fetch clinic data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM CLINICS WHERE Clinic_ID = ?");
    $stmt->execute([$id]);
    $clinic = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Edit Clinic</title>
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row vh-100">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Edit Clinic Data</h2>
                <?php if (isset($clinic)): ?>
                    <div class="clinic_form">
                        <form action="edit_clinic.php?id=<?php echo $clinic['Clinic_ID']; ?>" method="post">
                            <label for="Name">Clinic Name</label>
                            <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($clinic['Clinic_Name']); ?>" required>

                            <label for="City">Clinic City</label>
                            <select name="City" id="City" required>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM CITIES");
                                $stmt->execute();
                                $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($cities as $city) {
                                    $selected = $city["City_ID"] == $clinic["Clinic_City_ID"] ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($city["City_ID"]) . "' $selected>" . htmlspecialchars($city["City_Name"]) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="Address">Clinic Address</label>
                            <input type="text" id="Address" name="Address" value="<?php echo htmlspecialchars($clinic['Clinic_Address']); ?>" required>

                            <label for="PhoneNumber">Phone Number</label>
                            <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo htmlspecialchars($clinic['Clinic_Phone_Number']); ?>" required>

                            <label for="OpenTime">Open Time</label>
                            <input type="time" id="OpenTime" name="OpenTime" value="<?php echo htmlspecialchars($clinic['Clinic_Open_Time']); ?>" required>

                            <label for="CloseTime">Close Time</label>
                            <input type="time" id="CloseTime" name="CloseTime" value="<?php echo htmlspecialchars($clinic['Clinic_Close_Time']); ?>" required>

                            <input type="submit" id="edit_clinic_button" name="sub" value="Update">
                        </form>
                    </div>
                <?php else: ?>
                    <p>Clinic not found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>

<style>
	main h2 {
		text-align: center;
	}

	.clinic_form {
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