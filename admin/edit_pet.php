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
				<div class="pet_form">
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

						<input type="submit" name="sub" value="Update">
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