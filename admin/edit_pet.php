<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>
<?php
// Fetch user data if ID is set
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
	// Prepare and execute SQL to fetch user data
	$stmt = $pdo->prepare("SELECT * FROM PETS WHERE Pet_ID = ?");
	$stmt->execute([$id]);
	$pet = $stmt->fetch();
}
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
	$stmt = $conn->prepare("UPDATE PETS SET Pet_Name = ?, Pet_Blood_Type_ID = ?, Pet_Type = ?, Pet_Breed = ?, Pet_Age = ? WHERE Pet_ID = ?");
	if ($stmt->execute([$Name, $BloodType, $Type, $Breed, $Age, $id])) {
		header("Location: pet_page.php");
		exit();
	} else {
		$error = "Update failed";
	}
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
					<form action="edit_pet.php?id=<?php echo $pet['Pet_ID']; ?>" method="post" enctype="multipart/form-data">
						<label for="Name">Pet Name</label>
						<input type="text" name="Name" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" required>

						<label for="Type">Pet Type</label>
						<select id="Type" name="pet_type">
							<option value="dog" <?php if ($pet['Pet_Type'] == 'dog') echo 'selected'; ?>>Dog</option>
							<option value="cat" <?php if ($pet['Pet_Type'] == 'cat') echo 'selected'; ?>>Cat</option>
						</select>

						<label for="bloodType">Blood Type</label>
						<select id="bloodType" name="blood_type" required></select>
						<script>
							const petTypeSelect = document.getElementById('petType');
							const bloodTypeSelect = document.getElementById('bloodType');
							const dogBloodTypes = ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'];
							dogBloodTypes.forEach(bloodType => {
								const option = document.createElement('option');
								option.value = BloodType;
								option.text = bloodType;
								bloodTypeSelect.appendChild(option);
							});

							petTypeSelect.addEventListener('change', () => {
								const selectedPetType = petTypeSelect.value;
								bloodTypeSelect.innerHTML = ''; // Clear previous options

								if (selectedPetType === 'cat') {
									const catBloodTypes = ['A', 'B', 'AB'];
									catBloodTypes.forEach(bloodType => {
										const option = document.createElement('option');
										option.value = BloodType;
										option.text = bloodType;
										bloodTypeSelect.appendChild(option);
									});
								} else if (selectedPetType === 'dog') {
									const dogBloodTypes = ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'];
									dogBloodTypes.forEach(bloodType => {
										const option = document.createElement('option');
										option.value = BloodType;
										option.text = bloodType;
										bloodTypeSelect.appendChild(option);
									});
								}
							});
						</script>

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