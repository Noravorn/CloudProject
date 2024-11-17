<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<?php
    // Fetch user data if ID is set
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id) {
        // Prepare and execute SQL to fetch user data
        $stmt = $pdo->prepare("SELECT * FROM USERS WHERE User_ID = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
        // Sanitize and validate form data
        $Title = htmlspecialchars(filter_input(INPUT_POST, 'Title'));
        $Role = htmlspecialchars(filter_input(INPUT_POST, 'Role'));
        $Fname = htmlspecialchars(filter_input(INPUT_POST, 'Fname'));
        $Lname = htmlspecialchars(filter_input(INPUT_POST, 'Lname'));
        $Email = htmlspecialchars(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL));
        $PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));

        // Prepare and execute update query
        $stmt = $pdo->prepare("UPDATE USERS SET User_Title = ?, User_Role = ?, User_Fname = ?, User_Lname = ?, User_Email = ?, User_Phone_Number = ? WHERE User_ID = ?");
        $stmt->execute([$Title, $Role, $Fname, $Lname, $Email, $PhoneNumber, $id]);

        // Redirect to user management page
        header("Location: user_manage.php");
        exit;
    }
    ?>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Edit User Data</h2>

                <?php if (isset($user)): ?>
                    <!-- Form to edit user data -->
                    <form action="edit_user.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Title">Title</label>
                            <input type="text" class="form-control" name="Title" id="Title" value="<?php echo htmlspecialchars($user['User_Title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Role">Role</label>
                            <input type="text" class="form-control" name="Role" id="Role" value="<?php echo htmlspecialchars($user['User_Role']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Fname">First Name</label>
                            <input type="text" class="form-control" name="Fname" id="Fname" value="<?php echo htmlspecialchars($user['User_Fname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Lname">Last Name</label>
                            <input type="text" class="form-control" name="Lname" id="Lname" value="<?php echo htmlspecialchars($user['User_Lname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" name="Email" id="Email" value="<?php echo htmlspecialchars($user['User_Email']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="PhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="<?php echo htmlspecialchars($user['User_Phone_Number']); ?>" required>
                        </div>

                        <div class="form-group text-center">
                            <input type="submit" name="sub" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                <?php else: ?>
                    <p>User not found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>

</body>

</html>
