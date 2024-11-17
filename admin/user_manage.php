<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<body>
	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<?php include 'sidebar.php'; ?>

			<!-- Main Content -->
			<main class="col-md-10 p-4">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<h2>User Information</h2>
					<a href="edit_user.php" class="btn btn-primary">Edit User</a>
				</div>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="table-dark">
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
						</thead>

						<tbody>
							<?php
							try {
								$query = "select * FROM USERS u 
									JOIN ROLES r ON u.UserRoleID = r.RoleID 
									JOIN CITIES c ON u.UserCityID = c.CityID 
									JOIN CLINICS cl ON u.UserClinicID = cl.ClinicID 
									JOIN DONATION_HISTORY dh ON u.UserID = dh.DonorID 
									JOIN BLOOD_TYPES bt ON dh.BloodTypeID = bt.BloodTypeID 
									JOIN PETS p ON u.UserID = p.OwnerID;";
								$stmt = $pdo->query($query);

								if ($stmt->rowCount() > 0) {
									while ($row = $stmt->fetch()) { ?>
										<tr>
											<td>
												<? echo $row['Title_Name']; ?>
											</td>
											<td>
												<? echo $row['Role_Name']; ?>
											</td>
											<td>
												<? echo $row['User_Fname']; ?>
											</td>
											<td>
												<? echo $row['User_Lname']; ?>
											</td>
											<td>
												<? echo $row['User_Email']; ?>
											</td>
											<td>
												<? echo $row['User_Phone_Number']; ?>
											</td>
											<td>
												<? echo $row['Pet_Name']; ?>
											</td>
											<td>
												<? echo $row['Clinic_Name']; ?>
											</td>
											<td>
												<? echo $row['City_Name']; ?>
											</td>
											<td><a href='edit_user.php?id=<? echo $row['User_ID']; ?>'> <!--<img src="images/.png"
									width="24" height="24">-->Edit</a></td>
											<td><a href='deleteInfo.php?id=<? echo $row['User_ID']; ?>'> <!--<img src="images/.png"
									width="24" height="24">-->Delete</a></td>
										</tr>
							<?php }
								} else {
									echo "<tr><td colspan='8' class='text-center text-muted'>No clinics found.</td></tr>";
								}
							} catch (PDOException $e) {
								echo "<tr><td colspan='8' class='text-danger'>Error fetching clinics: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>

			</main>
		</div>
	</div>
</body>

</html>