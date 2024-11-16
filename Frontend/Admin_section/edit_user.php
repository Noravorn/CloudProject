<?php 
    session_start();
	include("connect.php");
	if (isset($_POST['sub'])) {
		$id = $_GET['id'];
		$Name = filter_input(INPUT_POST, 'Name');
		$City = filter_input(INPUT_POST, 'City');
		$Address = filter_input(INPUT_POST, 'Address');
        $PhoneNumber = filter_input(INPUT_POST, 'PhoneNumber');
        $OpenTime = filter_input(INPUT_POST, 'OpenTime');
        $CloseTime = filter_input(INPUT_POST, 'CloseTime');

		$stmt = $conn->prepare("UPDATE CLINICS SET Clinic_Name = ?, Clinic_City = ?, Clinic_Address = ?, Clinic_Phone_Number = ?, Clinic_Open_Time = ?, Clinic_Close_Time = ? WHERE Clinic_ID = ?");
		$stmt->bind_param("ssssssi", $Name, $City, $Address, $PhoneNumber, $OpenTime, $CloseTime, $id);
			
		if ($stmt->execute()) {
			header("location:  user_manage.php");
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
    <title>Edit User</title>
</head>
<body>
    <div class="container">
			<?php include 'sideBar.php'; ?>
					<!-- END OF SIDEBAR -->

					<div class="add_user">
						<div id="div_content" class="form">
							<h2>Add User Data</h2>
							<form action="add_user.php" method="post">
								<input type="text" name="Title" placeholder="Title">
								<input type="text" name="Role" placeholder="Role">
								<input type="text" name="Fname" placeholder="First Name">
								<input type="text" name="Lname" placeholder="Last Name">
								<input type="text" name="Email" placeholder="Email">
								<input type="text" name="PhoneNumber" placeholder="Phone Number">
								<div class="center">
									<input type="submit" name="sub" value="Add">
								</div>
							</form>
						</div>

					<div class="edit_user">
							<div id="div_content" class="form">
								<h2>Edit User Data</h2>
								<?php
									$id = $_GET['id'];
									$q = "SELECT * FROM USERS where User_ID = $id";
									$result = $conn->query($q);
									$row = $result->fetch_assoc();
									echo "<form action='edit_user.php' method='post'>";
									echo "<label>Title</label>";
									echo "<input type='text' name='Title' value=" . $row['User_Title'] . ">";
									
									echo "<label>Role</label>";
									echo "<input type='text' name='Role' value=" . $row['User_Role'] . ">";
									
									echo "<label>First Name</label>";
									echo "<input type='text' name='Fname' value=" . $row['User_Fname'] . ">";

															echo "<label>Last Name</label>";
									echo "<input type='text' name='Lname' value=" . $row['USer_Lname'] . ">";

															echo "<label>Email</label>";
									echo "<input type='text' name='Email' value=" . $row['User_Email'] . ">";

															echo "<label>Phone Number</label>";
									echo "<input type='text' name='PhoneNumber' value=" . $row['User_Phone_Number'] . ">";
															
															echo "<label>Phone Number</label>";
									echo "<input type='text' name='PhoneNumber' value=" . $row['User_Phone_Number'] . ">";	

															echo "<label>Phone Number</label>";
									echo "<input type='text' name='PhoneNumber' value=" . $row['User_Phone_Number'] . ">";	
									
									echo "<div class='center'>";
									echo "<input type='submit' name='sub' value='Update'>";
									echo "</div>";
									echo "</form>"
									
								?>
							</div>
					</div>
				</div>
		</div>
</body>
</html>