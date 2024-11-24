<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Pet Page</title>
</head>

<?php include '../connect.php'; ?>

<body>
	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<?php include 'sidebar.php'; ?>

			<!-- Main Content -->
			<main class="col-md-10 p-4">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<h1>Pet Data</h1>
					<a href="add_pet.php" class="btn btn-primary">Add Pet</a>
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
								$query = "SELECT * FROM PETS p
								JOIN BLOOD_TYPES bt ON p.Pet_Blood_type_ID = bt.Blood_Type_ID";
								$stmt = $pdo->query($query);

								if ($stmt->rowCount() > 0) {
									while ($row = $stmt->fetch()) { ?>
										<tr>
											<td><?= $row['Pet_Name'] ?></td>
											<td><?= $row['Blood_Type_Name'] ?></td>
											<td><?= $row['Pet_Type'] ?></td>
											<td><?= $row['Pet_Breed'] ?></td>
											<td><?= $row['Pet_Age'] ?></td>
											<td>
												<a href='edit_pet.php?id=<?= $row['Pet_ID'] ?>' class="btn btn-sm btn-warning">
													<i class="bi bi-pencil"></i> Edit
												</a>
											</td>
											<td>
												<a href='delete_info.php?id=<?= $row['Pet_ID'] ?>&type=pet' class="btn btn-sm btn-danger">
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