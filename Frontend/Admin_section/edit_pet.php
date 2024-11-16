<?php 
    session_start();
	include("connect.php");
    $uid = $_SESSION['uid'];
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
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
    <?php include 'sideBar.php'; ?>
        <!-- END OF SIDEBAR -->
    </div>
    <div id="div_content" class="form">
					<h2>Edit Pet Data</h2>
					<?php
						$id = $_GET['id'];
						$q = "SELECT * FROM PETS where Pet_ID = $id";
						$result = $conn->query($q);
						$row = $result->fetch_assoc();
						echo "<form action='edit_pet.php' method='post'>";
						echo "<label>Name</label>";
						echo "<input type='text' name='Name' value=" . $row['Pet_Name'] . ">";
						
						echo "<label>Blood Type</label>";
						echo "<input type='text' name='Breed Type' value=" . $row['Pet_Blood_Type'] . ">";
						
						
						echo "<label>Type</label>";
						echo "<input type='text' name='Type' value=" . $row['Pet_Type'] . ">";

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./script.js"></script>
</body>
</html>