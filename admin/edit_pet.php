<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>
<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
	$id = $_GET['id'];

	// Sanitize input using htmlspecialchars to prevent XSS
	$Name = htmlspecialchars(filter_input(INPUT_POST, 'Name'));
	$BloodType = htmlspecialchars(filter_input(INPUT_POST, 'BloodType'));
	$Type = htmlspecialchars(filter_input(INPUT_POST, 'Type'));
	$Breed = htmlspecialchars(filter_input(INPUT_POST, 'Breed'));
	$Age = htmlspecialchars(filter_input(INPUT_POST, 'Age'));

	// Update query
	$stmt = $conn->prepare("UPDATE PETS SET Pet_Name = ?, Pet_Blood_Type = ?, Pet_Type = ?, Pet_Breed = ?, Pet_Age = ? WHERE Pet_ID = ?");
	if ($stmt->execute([$Name, $BloodType, $Type, $Breed, $Age, $id])) {
		header("Location: pet_page.php");
		exit();
	} else {
		$error = "Update failed";
	}
}

// Fetch pet data for editing
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$stmt = $conn->prepare("SELECT * FROM PETS WHERE Pet_ID = ?");
	$stmt->execute([$id]);
	$pet = $stmt->fetch();
}
?>

</html>

<body>
	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<?php include 'sidebar.php'; ?>

			<!-- Main Content -->
			<main class="col-md-10 p-4">
				<h2>Edit Pet Data</h2>
				<?php if (isset($pet)): ?>
					<form action="edit_pet.php?id=<?php echo $pet['Pet_ID']; ?>" method="post">
						<label for="Name">Pet Name</label>
						<input type="text" name="Name" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" required>

						<label for="Type">Pet Type</label>
						<input type="text" name="Type" value="<?php echo htmlspecialchars($pet['Pet_Type']); ?>" required>

						<label for="BloodType">Blood Type</label>
						<input type="text" name="BloodType" value="<?php echo htmlspecialchars($pet['Pet_Blood_Type']); ?>" required>

						<label for="Breed">Breed</label>
						<input type="text" name="Breed" value="<?php echo htmlspecialchars($pet['Pet_Breed']); ?>" required>

						<label for="Age">Age</label>
						<input type="number" name="Age" value="<?php echo htmlspecialchars($pet['Pet_Age']); ?>" required>

						<div class="center">
							<input type="submit" name="sub" value="Update">
						</div>
					</form>
				<?php else: ?>
					<p>Pet not found.</p>
				<?php endif; ?>
			</main>
		</div>
	</div>
</body>

</html>