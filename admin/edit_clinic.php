<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
	$id = $_GET['id'];
	$Name = htmlspecialchars(filter_input(INPUT_POST, 'Name'));
	$City = htmlspecialchars(filter_input(INPUT_POST, 'City'));
	$Address = htmlspecialchars(filter_input(INPUT_POST, 'Address'));
	$PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));
	$OpenTime = htmlspecialchars(filter_input(INPUT_POST, 'OpenTime'));
	$CloseTime = htmlspecialchars(filter_input(INPUT_POST, 'CloseTime'));

	// Update query
	$stmt = $pdo->prepare("UPDATE CLINICS SET Clinic_Name = ?, Clinic_City = ?, Clinic_Address = ?, Clinic_Phone_Number = ?, Clinic_Open_Time = ?, Clinic_Close_Time = ? WHERE Clinic_ID = ?");
	if ($stmt->execute([$Name, $City, $Address, $PhoneNumber, $OpenTime, $CloseTime, $id])) {
		header("Location: clinic_manage.php");
		exit();
	} else {
		$error = "Update failed";
	}
}

// Fetch clinic data for editing
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$stmt = $pdo->prepare("SELECT * FROM CLINICS JOIN CITIES ON CITIES.City_ID = CLINICS.Clinic_City_ID WHERE Clinic_ID = ?");
	$stmt->execute([$id]);
	$clinic = $stmt->fetch();
}
?>

<body>
	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<?php include 'sidebar.php'; ?>

			<!-- Main Content -->
			<main class="col-md-10 p-4">
				<h2>Edit Clinic Data</h2>
				<?php if (isset($clinic)): ?>
				<div class="clinic_form">
					<form action="edit_clinic.php?id=<?php echo $clinic['Clinic_ID']; ?>" method="post">
						<label for="Name">Clinic Name</label>
						<input type="text" name="Name" value="<?php echo htmlspecialchars($clinic['Clinic_Name']); ?>" required>

						<label for="City">Clinic City</label>
						<select name="City" id="City" required>
                            <?php
                                $stmt = $pdo->prepare("SELECT * FROM CITIES");
                                $stmt->execute();
                                $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($clinics as $clinic) {
                                    echo "<option value='" . htmlspecialchars($cities["City_ID"]) . "'>" . htmlspecialchars($cities["City_Name"]) . "</option>";
                                }
                            ?>
                        </select>

						<label for="Address">Clinic Address</label>
						<input type="text" name="Address" value="<?php echo htmlspecialchars($clinic['Clinic_Address']); ?>" required>

						<label for="PhoneNumber">Phone Number</label>
						<input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($clinic['Clinic_Phone_Number']); ?>" required>

						<label for="OpenTime">Open Time</label>
						<input type="time" name="OpenTime" value="<?php echo htmlspecialchars($clinic['Clinic_Open_Time']); ?>" required>

						<label for="CloseTime">Close Time</label>
						<input type="time" name="CloseTime" value="<?php echo htmlspecialchars($clinic['Clinic_Close_Time']); ?>" required>

						<input type="submit" name="sub" value="Update">
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