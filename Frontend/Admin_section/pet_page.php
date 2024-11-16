<?php 
	include("connect.php");
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
    <title>Pet Data</title>
</head>
<body>
    <div class="container">
		<?php include 'sideBar.php'; ?>
					<!-- END OF SIDEBAR -->
					<div id="PetTable" class="DisplayTable">
						<div class="top">
							<h2>Pet Information</h2>
							<button><a href="edit_pet.php">Edit Pet</a></button>
						</div>
						<table>
							<col width="10%">
							<col width="20%">
							<col width="20%">
							<col width="20%">
							<col width="20%">
							<col width="20%">
							<col width="10%">

							<tr>
								<th>Name</th>
								<th>Blood Type</th>
								<th>Type</th>
								<th>Breed</th>
								<th>Age</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							<?php
							$query = "SELECT * FROM PETS";
							$result = $conn->query($query);
							if (!$result) {
								echo "Select failed. Error: " . $conn->error;
								return false;
							}
							while ($row = $result->fetch_assoc()) {
							?>
							<tr>
								<td><?= $row['Pet_Name'] ?></td>
								<td><?= $row['Pet_Blood_Type'] ?></td>
								<td><?= $row['Pet_Type'] ?></td>
								<td><?= $row['Pet_Breed'] ?></td>
								<td><?= $row['Pet_Age'] ?></td>
								<td><a href='edit_pet.php?id=<?= $row['Pet_ID'] ?>'>Edit</a></td>
								<td><a href='deleteInfo.php?id=<?= $row['Pet_ID'] ?>'>Delete</a></td>
							</tr>
							<?php } ?>
						</table>
					</div>
    </div>
</body>
</html>