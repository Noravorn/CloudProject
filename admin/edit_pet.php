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
	$stmt = $pdo->prepare("UPDATE PETS SET Pet_Name = ?, Pet_Blood_Type_ID = ?, Pet_Type = ?, Pet_Breed = ?, Pet_Age = ? WHERE Pet_ID = ?");
	$stmt->execute([$Name, $BloodType, $Type, $Breed, $Age, $id]);
	
	if ($stmt->rowCount() > 0) {
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
						<input type="text" id="Name" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" required>

						<label for="petType">Pet Type</label>
						<select id="petType" name="pet_type">
							<option value="dog" <?php if ($pet['Pet_Type'] == 'dog') echo 'selected'; ?>>Dog</option>
							<option value="cat" <?php if ($pet['Pet_Type'] == 'cat') echo 'selected'; ?>>Cat</option>
						</select>

						<label for="bloodType">Blood Type</label>
						<select id="bloodType" name="bloodType" required></select>
						<script>
							const petTypeSelect = document.getElementById('petType');
							const bloodTypeSelect = document.getElementById('bloodType');

							// Function to populate blood type options based on pet type
							function populateBloodTypes(petType) {
								bloodTypeSelect.innerHTML = ''; // Clear previous options

								if (petType === 'dog') {
									const dogBloodTypes = ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'];
									dogBloodTypes.forEach(bloodType => {
										const option = document.createElement('option');
										option.value = bloodType;
										option.text = bloodType;
										bloodTypeSelect.appendChild(option);
									});
								} else if (petType === 'cat') {
									const catBloodTypes = ['A', 'B', 'AB'];
									catBloodTypes.forEach(bloodType => {
										const option = document.createElement('option');
										option.value = bloodType;
										option.text = bloodType;
										bloodTypeSelect.appendChild(option);
									});
								}
							}

							// Initial population of blood types for the default "dog" selection
							populateBloodTypes(petTypeSelect.value);

							// Event listener for pet type changes
							petTypeSelect.addEventListener('change', () => {
								populateBloodTypes(petTypeSelect.value);
							});
						</script>

						<label for="Breed">Breed</label>
						<input type="text" id="Breed" value="<?php echo htmlspecialchars($pet['Pet_Breed']); ?>" required>

						<label for="Age">Age</label>
						<input type="number" id="Age" value="<?php echo htmlspecialchars($pet['Pet_Age']); ?>" required>

						<input type="submit" id="sub" value="Update">
					</form>
				</div>
				<?php else: ?>
					<p>Pet not found.</p>
				<?php endif; ?>
			</main>
		</div>
	</div>
</body>
<style>
    main h2 {
        text-align: center;        
    }
    .pet_form {
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