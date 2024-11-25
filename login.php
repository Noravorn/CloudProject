<?php session_start(); ?>
<?php session_regenerate_id(true); ?>

<!DOCTYPE html>
<html lang="en">

<?php include('connect.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('header.php'); ?>
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

                // Redirect based on user role
                $redirectUrl = $user['User_Role_ID'] == 2 
                    ? "information.php" 
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

<body id="login">

    <div class="position-absolute top-0 start-0 m-3">
        <a href="index.php" class="text-decoration-none text-secondary d-flex align-items-center">
            <i class='bx bx-left-arrow-circle fs-4 me-2'></i>
            <span>Back</span>
        </a>
    </div>

    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h1>Login</h1>
            <!-- Error Notification -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Email -->
            <div class="input-box">
                <input type="text" placeholder="Email" id="email" name="email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <!-- Password -->
            <div class="input-box">
                <input type="password" placeholder="Password" id="password" name="password" required>
                <i class='bx bxs-lock'></i>
            </div>

            <!-- Forgot Password -->
            <div class="rem-forget">
                <a href="#">Forgot password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn" id="login_button" name="submit">Login</button>
        </form>
    </div>
</body>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: var(--main-color) url('src/images/login_background.jpg') no-repeat center center;
        background-size: cover;
        color: var(--text-color);
    }

    /* Login Wrapper */
    .wrapper {
        width: 420px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(20px);
        padding: 30px 40px;
        border-radius: 10px;
        color: var(--main-color);
    }

    .wrapper h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Input Box */
    .input-box {
        position: relative;
        width: 100%;
        height: 50px;
        margin: 20px 0;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 40px;
        font-size: 16px;
        color: var(--main-color);
        padding: 0 45px 0 20px;
    }

    .input-box input::placeholder {
        color: var(--main-color);
    }

    .input-box i {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: var(--main-color);
    }

    /* Links and Button */
    .rem-forget {
        font-size: 14.5px;
        margin: -15px 0 15px;
        text-align: right;
    }

    .rem-forget a {
        color: var(--main-color);
    }

    .rem-forget a:hover {
        color: var(--link-hovered-color);
    }

    .btn {
        width: 100%;
        height: 45px;
        background: var(--main-color);
        border: none;
        border-radius: 40px;
        cursor: pointer;
        font-size: 16px;
        color: var(--text-color);
        font-weight: 600;
    }
</style>

</html>