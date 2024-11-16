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
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
    <?php include 'sideBar.php'; ?>
        <!-- END OF SIDEBAR -->
        <div id="PetTable" class="DisplayTable">
        <h2>Pet Information</h2>
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
							$q = "select * from PETS";
							$result = $conn->query($q);
							if (!$result) {
								echo "Select failed. Error: " . $conn->error;
								return false;
							}
							while ($row = $result->fetch_array()) { ?>
							<tr>
								<td>
									<? echo $row['Pet_Name'];?>
								</td>
								<td>
									<? echo $row['Pet_Blood_Type'];?>
								</td>
								<td>
									<? echo $row['Pet_Type'];?>
								</td>
								<td>
									<? echo $row['Pet_Breed'];?>
								</td>
								<td>
									<? echo $row['Pet_Age'];?>
								</td>
								<td><a href='edit_pet.php?id=<? echo $row['Pet_ID']; ?>'> <!--<img src="images/.png"
								width="24" height="24">-->Edit</a></td>
								<td><a href='deleteInfo.php?id=<? echo $row['Pet_ID']; ?>'> <!--<img src="images/.png"
								width="24" height="24">-->Delete</a></td>
							</tr>
						<?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./script.js"></script>
</body>
</html>