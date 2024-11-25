<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
	$Name = htmlspecialchars($_POST['Name']);
	$BloodType = htmlspecialchars($_POST['bloodType']);
	$Type = htmlspecialchars($_POST['petType']);
	$Breed = htmlspecialchars($_POST['Breed']);
	$Age = htmlspecialchars($_POST['Age']);

	$stmt = $pdo->prepare("UPDATE PETS SET Pet_Name = ?, Pet_Blood_type_ID = ?, Pet_Type = ?, Pet_Breed = ?, Pet_Age = ? WHERE Pet_ID = ?");
	$stmt->execute([$Name, $BloodType, $Type, $Breed, $Age, $id]);

	if ($stmt->rowCount() > 0) {
		header("Location: pet_page.php");
		exit();
	} else {
		$error = "Update failed or no changes made.";
	}
}

// Fetch pet data if ID is set
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
	$stmt = $pdo->prepare("SELECT * FROM PETS WHERE Pet_ID = ?");
	$stmt->execute([$id]);
	$pet = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$pet) {
		echo "<p>Pet not found.</p>";
		exit();
	}
}

// Fetch Pet Types from the database
$petTypesStmt = $pdo->query("SELECT DISTINCT Pet_Type FROM PETS");
$petTypes = $petTypesStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Blood Types from the BLOOD_TYPES table
$bloodTypesStmt = $pdo->query("SELECT Blood_Type_ID, Blood_Type_Name FROM BLOOD_TYPES");
$bloodTypes = $bloodTypesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include('../header.php'); ?>
	<title>Edit Pet</title>
	</head>

	<body>
		<div class="container-fluid vh-100">
			<div class="row vh-100">
				<?php include 'sidebar.php'; ?>

				<main class="col-md-10 p-4">
					<h2>Edit Pet Data</h2>
					<form action="edit_pet.php?id=<?php echo $id; ?>" method="post">

						<label for="Name">Pet Name</label>
						<input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($pet['Pet_Name']); ?>" required>

						<label for="petType">Pet Type</label>
						<select id="petType" name="petType" required>
							<?php foreach ($petTypes as $type): ?>
								<option value="<?php echo htmlspecialchars($type['Pet_Type']); ?>" <?php echo ($type['Pet_Type'] === $pet['Pet_Type']) ? 'selected' : ''; ?>>
									<?php echo htmlspecialchars($type['Pet_Type']); ?>
								</option>
							<?php endforeach; ?>
						</select>

						<label for="bloodType">Blood Type</label>
						<select id="bloodType" name="bloodType" required>
							<?php foreach ($bloodTypes as $bloodType): ?>
								<option value="<?php echo $bloodType['Blood_Type_ID']; ?>" <?php echo ($bloodType['Blood_Type_ID'] == $pet['Pet_Blood_type_ID']) ? 'selected' : ''; ?>>
									<?php echo htmlspecialchars($bloodType['Blood_Type_Name']); ?>
								</option>
							<?php endforeach; ?>
						</select>

						<label for="Breed">Breed</label>
						<input type="text" id="Breed" name="Breed" value="<?php echo htmlspecialchars($pet['Pet_Breed']); ?>" required>

						<label for="Age">Age</label>
						<input type="number" id="Age" name="Age" value="<?php echo htmlspecialchars($pet['Pet_Age']); ?>" required>

						<input type="submit" id="edit_pet_button" name="sub" value="Update">
					</form>
					<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
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
			grid-template-columns: 1fr;
			gap: 1.1rem;
			margin-bottom: 2rem;
			border: 4px solid rgba(0, 0, 0, 0.2);
			border-radius: 10px;
			padding: 20px;
			background: var(--secondary-color);
		}

		form input,
		form select {
			width: 100%;
			height: 40px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}
	</style>

</html>