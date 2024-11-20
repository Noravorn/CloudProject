<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php

    // Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate input
    $Title = htmlspecialchars(filter_input(INPUT_POST, 'Title'));
    $Role = htmlspecialchars(filter_input(INPUT_POST, 'Role'));
    $Fname = htmlspecialchars(filter_input(INPUT_POST, 'Fname'));
    $Lname = htmlspecialchars(filter_input(INPUT_POST, 'Lname'));
    $Email = htmlspecialchars(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL));
    $PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));
    $Password = htmlspecialchars(filter_input(INPUT_POST, 'Password'));

    // Prepare and execute the INSERT query
    $stmt = $pdo->prepare("INSERT INTO USERS (User_Title, User_Role, User_Fname, User_Lname, User_Email, User_Phone_Number, User_Password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$Title, $Role, $Fname, $Lname, $Email, $PhoneNumber, $Password]);    
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
                            <label for="Title">Title</label>
                            <input type="text" class="form-control" name="Title" id="Title" value="" required>
                        </div>

                        <div class="form-group">
                            <label for="Role">Role</label>
                            <input type="text" class="form-control" name="Role" id="Role" value="" required>
                        </div>

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

                        <div class="form-group text-center">
                            <input type="submit" name="sub" class="btn btn-primary" value="Update">
                        </div>
                    </form>
            </main>
        </div>
    </div>

</body>

</html>
