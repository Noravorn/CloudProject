<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
    // Sanitize and validate input
    $Title = htmlspecialchars(filter_input(INPUT_POST, 'Title'));
    $Role = htmlspecialchars(filter_input(INPUT_POST, 'Role'));
    $Fname = htmlspecialchars(filter_input(INPUT_POST, 'Fname'));
    $Lname = htmlspecialchars(filter_input(INPUT_POST, 'Lname'));
    $Email = htmlspecialchars(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL));
    $PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));
    $Password = htmlspecialchars(filter_input(INPUT_POST, 'Password'));
    $Clinic = htmlspecialchars(filter_input(INPUT_POST, 'clinic'));

    $stmt = $pdo->prepare("INSERT INTO USERS (User_Title, User_Role, User_Fname, User_Lname, User_Email, User_Phone_Number, User_Password, User_Clinic_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$Title, $Role, $Fname, $Lname, $Email, $PhoneNumber, $Password, $Clinic]);

    if ($stmt->rowCount() > 0) {
        // Successful insertion, redirect and exit
        header("location: user_manage.php");
        exit();
    } else {
        // Display an error message
        echo "Error: Failed to insert user data.";
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
                        <div class="form-group">
                            <label for="Role">Role</label>
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
                        </div>
                        <div class="form-group">
                            <label for="Title">Title</label>
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

                    <div class="form-group">
                        <label for="Fname">First Name</label>
                        <input type="text" class="form-control" name="Fname" id="Fname" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="Lname">Last Name</label>
                        <input type="text" class="form-control" name="Lname" id="Lname" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="Email" id="Email" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="PhoneNumber">Phone Number</label>
                        <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="text" class="form-control" name="Password" id="Password" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="Pet">Pet</label>
                        <input type="text" class="form-control" name="Pet" id="Pet" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="Address">Address</label>
                        <input type="text" class="form-control" name="Address" id="Address" value="" required>
                    </div>
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

                    <div class="form-group text-center">
                        <input type="submit" name="sub" class="btn btn-primary" value="Add">
                    </div>
                </form>
            </main>
        </div>
    </div>

</body>

</html>