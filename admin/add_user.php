<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
    // Sanitize and validate input more rigorously
    $title = filter_var($_POST['title'], FILTER_SANITIZE_NUMBER_INT);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($_POST['Fname']);
    $lname = filter_var($_POST['Lname']);
    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['PhoneNumber']);
    $password = filter_var($_POST['Password']);
    $clinic = filter_var($_POST['clinic'], FILTER_SANITIZE_NUMBER_INT);
    $city = filter_var($_POST['City'], FILTER_SANITIZE_NUMBER_INT);
    $address = filter_var($_POST['Address']);

    $stmt = $pdo->prepare("INSERT INTO USERS (User_Title_ID, User_Role_ID, User_Fname, User_Lname, User_Email, User_Phone_Number, User_Password, User_Clinic_ID, User_City_ID, User_Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$title, $role, $fname, $lname, $email, $phone, $password, $clinic, $city, $address]);
        header("location: user_manage.php");
        exit();
    } catch (PDOException $e) {
        // Log the error and display a user-friendly message
        error_log("Error inserting user: " . $e->getMessage());
        echo "Error: Failed to insert user data. Please try again.";
    }
}
?>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Add User Data</h2>
                <!-- Form to edit user data -->
                <form action="add_user.php" method="post" enctype="multipart/form-data">
                        <label for="role">Role</label>
                        <select name="role" id="role" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM ROLES");
                            $stmt->execute();
                            $role = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($role as $role) {
                                echo "<option value='" . htmlspecialchars($role["Role_ID"]) . "'>" . htmlspecialchars($role["Role_Title"]) . "</option>";
                            }
                            ?>
                        </select>
                        <label for="title">Title</label>
                        <select name="title" id="title" required>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM TITLES");
                            $stmt->execute();
                            $title = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($title as $title) {
                                echo "<option value='" . htmlspecialchars($title["Title_ID"]) . "'>" . htmlspecialchars($title["Title_Name"]) . "</option>";
                            }
                            ?>
                        </select>

                            <label for="Fname">First Name</label>
                            <input type="text" class="form-control" name="Fname" id="Fname" value="" required>

                            <label for="Lname">Last Name</label>
                            <input type="text" class="form-control" name="Lname" id="Lname" value="" required>

                            <label for="Email">Email</label>
                            <input type="email" class="form-control" name="Email" id="Email" value="" required>

                            <label for="PhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="" required>

                            <label for="Password">Password</label>
                            <input type="text" class="form-control" name="Password" id="Password" value="" required>
                        <label for="City">Clinic City</label>
							<select name="City" id="City" required>
								<?php
								$stmt = $pdo->prepare("SELECT * FROM CITIES");
								$stmt->execute();
								$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($cities as $cities) {
									echo "<option value='" . htmlspecialchars($cities["City_ID"]) . "'>" . htmlspecialchars($cities["City_Name"]) . "</option>";
								}
								?>
							</select>

                            <label for="Address">Address</label>
                            <input type="text" class="form-control" name="Address" id="Address" value="" required>
                        <label for="clinic">Clinic </label>
                        <select name="clinic" id="clinic" required>
                            <?php
                            // Fetch clinic names from the database using PDO
                            $stmt = $pdo->prepare("SELECT * FROM CLINICS");
                            $stmt->execute();
                            $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($clinics as $clinic) {
                                echo "<option value='" . htmlspecialchars($clinic['Clinic_ID']) . "'>" . htmlspecialchars($clinic['Clinic_Name']) . "</option>";
                            }
                            ?>
                        </select>

                        <input type="submit" name="sub" class="btn btn-primary" value="Add">
                    </div>
                </form>
            </main>
        </div>
    </div>

</body>
<style>
	main h2 {
		text-align: center;
	}

	form {
		display: grid;
		grid-template-columns: repeat(1, 21fr);
		gap: 1.1rem;
		margin-bottom: 2rem;
		border: 4px solid rgba(0, 0, 0, 0.2);
		border-radius: 10px;
		padding: 20px;
		background: var(--secondary-color);
	}

	form input {
		width: auto;
		height: 40px;
		border: 1px solid #ccc;
		border-radius: 5px;
	}

	form select {
		width: auto;
		height: 40px;
		border: 1px solid #ccc;
		border-radius: 5px;
	}

</style>

</html>