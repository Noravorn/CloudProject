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
    </div>
    <div id="ClinicTable" class="DisplayTable">
        <h2>Clinic Information</h2>
			<table>
                <col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="7%">
                <col width="7%">
                <col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="7%">
				<col width="9%">
                <col width="9%">

						
				<tr>
					<th>Title</th>
					<th>Role</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
                    <th>Phone Number</th>
                    <th>Password</th>
                    <th>Pet</th>
                    <th>Clinic</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Edit</th>
					<th>Delete</th>
				</tr>
                <?php
							$q = "select * FROM USERS u JOIN ROLES r ON u.UserRoleID = r.RoleID JOIN CITIES c ON u.UserCityID = c.CityID JOIN CLINICS cl ON u.UserClinicID = cl.ClinicID JOIN DONATION_HISTORY dh ON u.UserID = dh.DonorID JOIN BLOOD_TYPES bt ON dh.BloodTypeID = bt.BloodTypeID JOIN PETS p ON u.UserID = p.OwnerID;";
							$result = $conn->query($q);
							if (!$result) {
								echo "Select failed. Error: " . $conn->error;
								return false;
							}
							while ($row = $result->fetch_array()) { ?>
							<tr>
								<td>
									<? echo $row['Title_Name'];?>
								</td>
								<td>
									<? echo $row['Role_Name'];?>
								</td>
								<td>
									<? echo $row['User_Fname'];?>
								</td>
								<td>
									<? echo $row['User_Lname'];?>
								</td>
								<td>
									<? echo $row['User_Email'];?>
								</td>
                                <td>
									<? echo $row['User_Phone_Number'];?>
								</td>
								<td>
									<? echo $row['Pet_Name'];?>
								</td>
								<td>
									<? echo $row['Clinic_Name'];?>
								</td>
                                <td>
									<? echo $row['City_Name'];?>
								</td>
								<td><a href='edit_user.php?id=<? echo $row['User_ID']; ?>'> <!--<img src="images/.png"
								width="24" height="24">-->Edit</a></td>
								<td><a href='deleteInfo.php?id=<? echo $row['User_ID']; ?>'> <!--<img src="images/.png"
								width="24" height="24">-->Delete</a></td>
							</tr>
						<?php } ?>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./script.js"></script>
</body>
</html>