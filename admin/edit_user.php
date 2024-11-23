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
        $Title = htmlspecialchars(filter_input(INPUT_POST, 'title'));
        $Role = htmlspecialchars(filter_input(INPUT_POST, 'role'));
        $Fname = htmlspecialchars(filter_input(INPUT_POST, 'Fname'));
        $Lname = htmlspecialchars(filter_input(INPUT_POST, 'Lname'));
        $Email = htmlspecialchars(filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL));
        $PhoneNumber = htmlspecialchars(filter_input(INPUT_POST, 'PhoneNumber'));

        // Prepare and execute update query
        $stmt = $pdo->prepare("UPDATE USERS SET User_Title_ID = ?, User_Role_ID = ?, User_Fname = ?, User_Lname = ?, User_Email = ?, User_Phone_Number = ? WHERE User_ID = ?");
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
                <div class="user_form">
                    <!-- Form to edit user data -->
                    <form action="edit_user.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
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

                        <input type="submit" id="sub" class="btn btn-primary" value="Update">
                    </form>
                </div>
                <?php else: ?>
                    <p>User not found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>

</body>
<style>
    main h2 {
        text-align: center;        
    }
    .user_form {
        display: flex;
        flex-direction: column;
        align-items: left;
        padding-left: 20%;
        padding-right: 20%;
        background: var(--secondary-color);
    }

    form {
        display: grid;
        grid-template-columns: repeat(1, 7fr);
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

    form input[type="submit"] {
        cursor: pointer;
        width: auto;
        height: 40px;
        border-radius: 5px;
    }
</style>
</html>
