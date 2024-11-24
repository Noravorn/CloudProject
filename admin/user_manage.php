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
					<h1>User Management</h1>
					<a href="add_user.php" class="btn btn-primary">Add User</a>
				</div>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="table-dark">
							<tr>
								<th>Role</th>
								<th>Title</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Phone Number</th>
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
								$query = "
									SELECT 
										r.Role_Title, 
										t.Title_Name, 
										u.User_Fname, 
										u.User_Lname, 
										u.User_Email, 
										u.User_Phone_Number, 
										p.Pet_Name, 
										cl.Clinic_Name, 
										c.City_Name, 
										u.User_Address, 
										u.User_ID
									FROM USERS u
									JOIN TITLES t ON u.User_Title_ID = t.Title_ID  
									JOIN ROLES r ON u.User_Role_ID = r.Role_ID 
									JOIN CITIES c ON u.User_City_ID = c.City_ID 
									JOIN CLINICS cl ON u.User_Clinic_ID = cl.Clinic_ID 
									JOIN PETS p ON u.User_Pet_ID = p.Pet_ID;
								";
								$stmt = $pdo->query($query);

								if ($stmt->rowCount() > 0) {
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
										<tr>
											<td><?php echo htmlspecialchars($row['Role_Title']); ?></td>
											<td><?php echo htmlspecialchars($row['Title_Name']); ?></td>
											<td><?php echo htmlspecialchars($row['User_Fname']); ?></td>
											<td><?php echo htmlspecialchars($row['User_Lname']); ?></td>
											<td><?php echo htmlspecialchars($row['User_Email']); ?></td>
											<td><?php echo htmlspecialchars($row['User_Phone_Number']); ?></td>
											<td><?php echo htmlspecialchars($row['Pet_Name']); ?></td>
											<td><?php echo htmlspecialchars($row['Clinic_Name']); ?></td>
											<td><?php echo htmlspecialchars($row['City_Name']); ?></td>
											<td><?php echo htmlspecialchars($row['User_Address']); ?></td>
											<td><a href='edit_user.php?id=<?php echo $row['User_ID']; ?>'>Edit</a></td>
											<td><a href='delete_info.php?id=<?php echo $row['User_ID']; ?>'>Delete</a></td>
										</tr>
							<?php   }
								} else {
									echo "<tr><td colspan='12' class='text-center text-muted'>No users found.</td></tr>";
								}
							} catch (PDOException $e) {
								echo "<tr><td colspan='12' class='text-danger'>Error fetching users: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
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