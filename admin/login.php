<!DOCTYPE html>
<html>

<?php session_start(); ?>
<?php include('../connect.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Login</title>
</head>

<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        try {
            // Use prepared statements to prevent SQL injection
            $query = "SELECT User_ID, User_Email, User_Role_ID FROM USERS WHERE User_Email = :email AND User_Password = :password";
            $stmt = $pdo->prepare($query);

            $stmt->execute([
                ':email' => $email,
                ':password' => $password, // Ideally, hash passwords before storage and verification
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Set session variables
                $_SESSION['User_ID'] = $user['User_ID'];
                $_SESSION['User_Email'] = $user['User_Email'];
                $_SESSION['User_Role_ID'] = $user['User_Role_ID'];

                session_regenerate_id(true);

                // Redirect based on user role
                $redirectUrl = $user['User_Role_ID'] == 1
                    ? "admin.php"
                    : null;

                if ($redirectUrl) {
                    header("Location: $redirectUrl");
                    exit();
                } else {
                    $error = "Invalid user role";
                    session_destroy();
                }
            } else {
                $error = "Invalid email or password";
            }
        } catch (Exception $e) {
            $error = "System error. Please try again later.";
        }
    }
}
?>


<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card">
            <div class="card-header">
                <h2>Log In</h2>
                <!-- <p>Login here using your username and password</p> -->
            </div>
            <!-- Error Notification -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="col mb-3">
                        <input type="text" class="form-control" name="email" placeholder="email" id="email" required>
                    </div>
                    <div class="col mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>
<style>
    body h2 {
        text-align: center;
    }

    .card-body {
        width: 20rem;
    }

    form button[type="submit"] {
        cursor: pointer;
        width: 100%;
        height: 40px;
        border-radius: 5px;
        margin: 0 auto;
        display: block;
    }
</style>

</html>