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
					<form action="edit_clinic.php?id=<?php echo $clinic['Clinic_ID']; ?>" method="post">
						<label for="Name">Clinic Name</label>
						<input type="text" name="Name" value="<?php echo htmlspecialchars($clinic['Clinic_Name']); ?>" required>

						<label for="City">Clinic City</label>
						<input type="text" name="City" value="<?php echo htmlspecialchars($clinic['City_Name']); ?>" required>

						<label for="Address">Clinic Address</label>
						<input type="text" name="Address" value="<?php echo htmlspecialchars($clinic['Clinic_Address']); ?>" required>

						<label for="PhoneNumber">Phone Number</label>
						<input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($clinic['Clinic_Phone_Number']); ?>" required>

						<label for="OpenTime">Open Time</label>
						<input type="time" name="OpenTime" value="<?php echo htmlspecialchars($clinic['Clinic_Open_Time']); ?>" required>

						<label for="CloseTime">Close Time</label>
						<input type="time" name="CloseTime" value="<?php echo htmlspecialchars($clinic['Clinic_Close_Time']); ?>" required>

						<div class="center">
							<input type="submit" name="sub" value="Add">
						</div>
					</form>
			</main>
		</div>
	</div>
</body>

</html>