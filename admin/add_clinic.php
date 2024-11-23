<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
	$Name = htmlspecialchars(filter_input(INPUT_POST, 'Name'));
	$City = htmlspecialchars(filter_input(INPUT_POST, 'City'));
	$Address = htmlspecialchars(filter_input(INPUT_POST, 'Address'));
	$PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));
	$OpenTime = htmlspecialchars(filter_input(INPUT_POST, 'OpenTime'));
	$CloseTime = htmlspecialchars(filter_input(INPUT_POST, 'CloseTime'));

	// Update query
	$stmt = $pdo->prepare("INSERT INTO CLINICS(Clinic_Name, Clinic_City_ID, Clinic_Address, Clinic_Phone_Number, Clinic_Open_Time, Clinic_Close_Time) VALUES (?, ?, ?, ?, ?, ?)");
	if ($stmt->execute([$Name, $City, $Address, $PhoneNumber, $OpenTime, $CloseTime])) {
		header("Location: clinic_manage.php");
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
				<h2>Add Clinic Data</h2>
				<form action="add_clinic.php" method="post">
					<label for="Name">Clinic Name</label>
					<input type="text" id="Name" required>

					<label for="City">Clinic City</label>
					<select name="City" id="City" required>
						<?php
						$stmt = $pdo->prepare("SELECT * FROM CITIES");
						$stmt->execute();
						$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($cities as $cities) {
							echo "<option value='" . htmlspecialchars($cities["City_ID"]) . "'>" . htmlspecialchars($cities["City_Name"]) . "</option>";
						}
						?>
					</select>

					<label for="Address">Clinic Address</label>
					<input type="text" id="Address" required>

					<label for="PhoneNumber">Phone Number</label>
					<input type="text" id="PhoneNumber" required>

					<label for="OpenTime">Open Time</label>
					<input type="time" id="OpenTime" required>

					<label for="CloseTime">Close Time</label>
					<input type="time" id="CloseTime" required>

						<input type="submit" id="sub" value="Add">
				</form>
			</main>
		</div>
	</div>
</body>
<style>
	main h2 {
		text-align: center;
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