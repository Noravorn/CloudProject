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
			header("location:  clinic_manage.php");
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
						$q = "SELECT * FROM CLINICS where Clinic_ID = $id";
						$result = $conn->query($q);
						$row = $result->fetch_assoc();
						echo "<form action='edit_clinic.php' method='post'>";
						echo "<label>Name</label>";
						echo "<input type='text' name='Name' value=" . $row['Clinic_Name'] . ">";
						
						echo "<label>City</label>";
						echo "<input type='text' name='City' value=" . $row['Clinic_City'] . ">";
						
						echo "<label>Address</label>";
						echo "<input type='text' name='Address' value=" . $row['Clinic_Address'] . ">";

                        echo "<label>Phone Number</label>";
						echo "<input type='text' name='PhoneNumber' value=" . $row['Clinic_Phone_Number'] . ">";

                        echo "<label>Open Time</label>";
						echo "<input type='time' name='OpenTime' value=" . $row['Clinic_Open_Time'] . ">";

                        echo "<label>Close Time</label>";
						echo "<input type='time' name='CloseTime' value=" . $row['Clinic_Open_Time'] . ">";						
						
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