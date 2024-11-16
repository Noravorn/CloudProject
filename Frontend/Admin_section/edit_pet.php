<?php 
    session_start();
	include("connect.php");
	if (isset($_POST['sub'])) {
		$id = $_GET['id'];
		$Name = filter_input(INPUT_POST, 'Name');
		$BloodType = filter_input(INPUT_POST, 'BloodType');
		$Type = filter_input(INPUT_POST, 'Type');
        $Breed = filter_input(INPUT_POST, 'Breed');
        $Age = filter_input(INPUT_POST, 'Age');

		$stmt = $conn->prepare("UPDATE PETS SET Pet_Name = ?, Pet_Blood_Type = ?, Pet_Type = ?, Pet_Breed = ?, Pet_Age WHERE Pet_ID = ?");
		$stmt->bind_param("ssssii", $Name, $BloodType, $Type,$Breed, $Age, $id);
			
		if ($stmt->execute()) {
			header("location:  pet_page.php");
			} else {
			$error = "Update failed";
		}
			
		$stmt->close();
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
          rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="style.css">
    <title>Edit Pet</title>
</head>
<body>
    <div class="container">
    <?php include 'sideBar.php'; ?>
        <!-- END OF SIDEBAR -->
				<div id="div_content" class="form">
					<div class="add_pet">
						<h2>Add Pet Data</h2>
						<label for="user_Fname">Owner Name: <input type="text" name="user_Fname"></label>
						<input type="text" name="user_Fname">
						<label for="user_Lname">Owner Last Name: <input type="text" name="user_Lname"></label>
						<input type="text" name="user_Lname">
						<label for="pet_name">Pet Name: <input type="text" name="pet_name"></label>
						<input type="text" name="pet_name">
						<label for="pet_type">Pet Type: <input type="text" name="pet_type"></label>
						<input type="text" name="pet_type">
						<label for="blood-type">Blood Type: <input type="text" name="blood-type"></label>
						<input type="text" name="blood-type">
						<label for="pet_breed">Pet Breed: <input type="text" name="pet_breed"></label>
						<input type="text" name="pet_breed">
						<label for="pet_age">Pet Age: <input type="number" name="pet_age"></label>
						<input type="number" name="pet_age">
						<input type="submit" name="sub" value="Update">
					</div>
					<!-- END OF ADD PET -->
					<div class="edit_pet">
						<h2>Edit Pet Data</h2>
						<?php
							$id = $_GET['id'];
							$q = "SELECT * FROM PETS where Pet_ID = $id";
							$result = $conn->query($q);
							$row = $result->fetch_assoc();
							echo "<form action='edit_pet.php' method='post'>";
							echo "<label>Name</label>";
							echo "<input type='text' name='Name' value=" . $row['Pet_Name'] . ">";
							
							echo "<label>Type</label>";
							echo "<input type='text' name='Type' value=" . $row['Pet_Type'] . ">";

							echo "<label>Blood Type</label>";
							echo "<input type='text' name='Breed Type' value=" . $row['Pet_Blood_Type'] . ">";

													echo "<label>Breed</label>";
							echo "<input type='text' name='Breed' value=" . $row['Pet_Breed'] . ">";

													echo "<label>Age</label>";
							echo "<input type='number' name='Age' value=" . $row['Pet_Age'] . ">";
							
							
							echo "<div class='center'>";
							echo "<input type='submit' name='sub' value='Update'>";
							echo "</div>";
							echo "</form>"
						?>
					</div>
				</div>
    </div>
    
</body>
</html>