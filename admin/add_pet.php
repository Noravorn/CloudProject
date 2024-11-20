<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>
<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {

    // Sanitize input using htmlspecialchars to prevent XSS
    $Name = htmlspecialchars(filter_input(INPUT_POST, 'Name'));
    $BloodType = htmlspecialchars(filter_input(INPUT_POST, 'bloodType'));
    $Type = htmlspecialchars(filter_input(INPUT_POST, 'Type'));
    $Breed = htmlspecialchars(filter_input(INPUT_POST, 'Breed'));
    $Age = htmlspecialchars(filter_input(INPUT_POST, 'Age'));

    // Update query
    $stmt = $conn->prepare("INSERT INTO PETS(Pet_Name, Pet_Blood_Type_ID, Pet_Type, Pet_Breed, Pet_Age) VALUES (?, ?, ?, ?, ?) ");
    if ($stmt->execute([$Name, $BloodType, $Type, $Breed, $Age])) {
        header("Location: pet_page.php");
        exit();
    } else {
        $error = "Insert failed";
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
                    <label for="Name">Pet Name</label>
                    <input type="text" name="Name" value="" required>

                    <label for="Type">Pet Type</label>
						<select id="Type" name="pet_type">
							<option value="dog" selected>Dog</option>
							<option value="cat">Cat</option>
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
                    <input type="text" name="Breed" value="" required>

                    <label for="Age">Age</label>
                    <input type="number" name="Age" value="" required>

                    <div class="center">
                        <input type="submit" name="sub" value="Add">
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>

</html>