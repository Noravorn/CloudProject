<!DOCTYPE html>
<html>

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card">
            <div class="card-header">
                <h2>Log In</h2>
                <p>Login here using your username and password</p>
            </div>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="col mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="col mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>