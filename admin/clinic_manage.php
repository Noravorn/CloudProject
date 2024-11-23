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
				<h1 class="mb-4">Clinic Management</h1>
				<a href="add_clinic.php" class="btn btn-primary">Add Clinic</a>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="table-dark">
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
						</thead>
						<tbody>
							<?php
							try {
								$query = "SELECT * FROM CLINICS 
								JOIN CITIES ON CITIES.City_ID = CLINICS.Clinic_City_ID";
								$stmt = $pdo->query($query);

								if ($stmt->rowCount() > 0) {
									while ($row = $stmt->fetch()) { ?>
										<tr>
											<td><?= htmlspecialchars($row['Clinic_Name']); ?></td>
											<td><?= htmlspecialchars($row['City_Name']); ?></td>
											<td><?= htmlspecialchars($row['Clinic_Address']); ?></td>
											<td><?= htmlspecialchars($row['Clinic_Phone_Number']); ?></td>
											<td><?= htmlspecialchars($row['Clinic_Open_Time']); ?></td>
											<td><?= htmlspecialchars($row['Clinic_Close_Time']); ?></td>
											<td>
												<a href="edit_clinic.php?id=<?= htmlspecialchars($row['Clinic_ID']); ?>" class="btn btn-sm btn-warning">
													<i class="bi bi-pencil"></i> Edit
												</a>
											</td>
											<td>
												<a href="delete_Info.php?id=<?= htmlspecialchars($row['Clinic_ID']); ?>" class="btn btn-sm btn-danger">
													<i class="bi bi-trash"></i> Delete
												</a>
											</td>
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