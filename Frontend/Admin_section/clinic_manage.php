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
    <title>Clinic Management</title>
</head>
<body>
    <div class="container">
    <?php include 'sideBar.php'; ?>
        <!-- END OF SIDEBAR -->
				<div id="ClinicTable" class="DisplayTable">
					<div class="top">
						<h2>Clinic Information</h2>
						<button><a href="edit_clinic.php">Edit Clinic</a></button>
					</div>
				<table>
									<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
									<col width="10%">
									<col width="10%">
							
					<tr>
						<th>Name</th>
						<th>City</th>
						<th>Address</th>
						<th>Phone Number</th>
						<th>Open Time</th>
											<th>Close Time</th>
											<th>Edit</th>
						<th>Delete</th>
					</tr>
									<?php
								$q = "select * from CLINICS";
								$result = $conn->query($q);
								if (!$result) {
									echo "Select failed. Error: " . $conn->error;
									return false;
								}
								while ($row = $result->fetch_array()) { ?>
								<tr>
									<td>
										<? echo $row['Clinic_Name'];?>
									</td>
									<td>
										<? echo $row['Clinic_City'];?>
									</td>
									<td>
										<? echo $row['Clinic_Address'];?>
									</td>
									<td>
										<? echo $row['Clinic_Phone_Number'];?>
									</td>
									<td>
										<? echo $row['Clinic_Open_Time'];?>
									</td>
																	<td>
										<? echo $row['Clinic_Close_Time'];?>
									</td>
									<td><a href='edit_clinic.php?id=<? echo $row['Clinic_ID']; ?>'> <!--<img src="images/.png"
									width="24" height="24">-->Edit</a></td>
									<td><a href='deleteInfo.php?id=<? echo $row['Clinic_ID']; ?>'> <!--<img src="images/.png"
									width="24" height="24">-->Delete</a></td>
								</tr>
							<?php } ?>
					</div>
    </div>
</body>
</html>