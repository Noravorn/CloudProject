<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>
<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
	// Sanitize and validate input
	$user_id = filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT);
	$name = filter_var($_POST['Name']);
	$blood_type = filter_var($_POST['bloodType']);
	$pet_type = filter_var($_POST['petType']);
	$breed = filter_var($_POST['Breed']);
	$age = filter_var($_POST['Age'], FILTER_SANITIZE_NUMBER_INT);

	// Prepare and execute the SQL query
	$stmt = $pdo->prepare("INSERT INTO PETS (Pet_Name, Pet_Blood_Type_ID, Pet_Type, Pet_Breed, Pet_Age) VALUES (?, ?, ?, ?, ?)");
	try {
		$stmt->execute([$name, $blood_type, $pet_type, $breed, $age]);
		$last_inserted_id = $pdo->lastInsertId();

		$update_stmt = $pdo->prepare("UPDATE USERS SET User_Pet_ID = ? WHERE User_ID = ?");
		$update_stmt->execute([$last_inserted_id, $user_id]);

		header("Location: pet_page.php");
		exit();
	} catch (PDOException $e) {
		// Handle errors gracefully
		echo "Error: " . $e->getMessage();
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
				<h2>Add Pet Data</h2>
				<form action="add_pet.php" method="post">

					<label for="user">User</label>
					<select name="user" id="user" required>
						<?php
						$stmt = $pdo->prepare("SELECT * FROM USERS WHERE User_Pet_ID IS NULL ");
						$stmt->execute();
						$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($user as $user) {
							echo "<option value='" . htmlspecialchars($user["User_ID"]) . "'>" . htmlspecialchars($user['User_Fname'] . " " . $user['User_Lname']) . "</option>";
						}
						?>
					</select>
					<label for="Name">Pet Name</label>
					<input type="text" id="Name" required>

					<label for="petType">Pet Type</label>
					<select id="petType" name="petType">
						<option value="dog" selected>Dog</option>
						<option value="cat">Cat</option>
					</select>

					<label for="bloodType">Blood Type</label>
					<select id="bloodType" name="bloodType" required>
					</select>
					<script>
						const petTypeSelect = document.getElementById('petType');
						const bloodTypeSelect = document.getElementById('bloodType');

						function populateBloodTypes(petType) {
							// Clear existing options
							bloodTypeSelect.innerHTML = '';

							// Fetch blood types based on pet type using AJAX
							fetch(`/get_blood_types?pet_type=${petType}`)
								.then(response => response.json())
								.then(data => {
									data.forEach(bloodType => {
										const option = document.createElement('option');
										option.value = bloodType.Blood_Type_ID;
										option.text = bloodType.Blood_Type_Name;
										bloodTypeSelect.appendChild(option);
									});
								})
								.catch(error => {
									console.error('Error fetching blood types:', error);
									// Handle errors gracefully, e.g., display an error message
								});
						}

						// Initial population of blood types
						populateBloodTypes(petTypeSelect.value);

						// Event listener for pet type changes
						petTypeSelect.addEventListener('change', () => {
							populateBloodTypes(petTypeSelect.value);
						});
					</script>

					<label for="Breed">Breed</label>
					<input type="text" id="Breed" required>

					<label for="Age">Age</label>
					<input type="number" id="Age" required>

					<div class="center">
						<input type="submit" id="sub" value="Add">
					</div>
				</form>
			</main>
		</div>
	</div>
</body>

</html>