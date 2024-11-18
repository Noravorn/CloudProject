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
					<h2>Pet Information</h2>
					<a href="edit_pet.php" class="btn btn-primary">Edit Pet</a>
				</div>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="table-dark">
							<tr>
								<th>Name</th>
								<th>Blood Type</th>
								<th>Type</th>
								<th>Breed</th>
								<th>Age</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>

						<tbody>
							<?php
							try {
								$query = "SELECT * FROM PETS";
								$stmt = $pdo->query($query);

								if ($stmt->rowCount() > 0) {
									while ($row = $stmt->fetch()) { ?>
										<tr>
											<td><?= $row['Pet_Name'] ?></td>
											<td><?= $row['Pet_Blood_Type'] ?></td>
											<td><?= $row['Pet_Type'] ?></td>
											<td><?= $row['Pet_Breed'] ?></td>
											<td><?= $row['Pet_Age'] ?></td>
											<td><a href='edit_pet.php?id=<?= $row['Pet_ID'] ?>'>Edit</a></td>
											<td><a href='deleteInfo.php?id=<?= $row['Pet_ID'] ?>'>Delete</a></td>
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