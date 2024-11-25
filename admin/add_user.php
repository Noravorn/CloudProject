<?php 
include '../connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
    // Sanitize and validate inputs
    $title = filter_var($_POST['title'], FILTER_SANITIZE_NUMBER_INT);
    $role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
    $fname = htmlspecialchars(filter_var($_POST['Fname']));
    $lname = htmlspecialchars(filter_var($_POST['Lname']));
    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['PhoneNumber']);
    $password = filter_var($_POST['Password']);
    $clinic = filter_var($_POST['clinic'], FILTER_SANITIZE_NUMBER_INT);
    $city = filter_var($_POST['City'], FILTER_SANITIZE_NUMBER_INT);
    $address = filter_var($_POST['Address']);
    $pet_id = isset($_POST['pet']) && !empty($_POST['pet']) ? $_POST['pet'] : null;

    if (!$email) {
        echo "Invalid email format.";
        exit();
    }

    try {
        // Prepare SQL for inserting user data
        $stmt = $pdo->prepare("INSERT INTO USERS 
            (User_Title_ID, User_Role_ID, User_Fname, User_Lname, User_Email, User_Phone_Number, User_Password, User_Clinic_ID, User_City_ID, User_Address, User_Pet_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $role, $fname, $lname, $email, $phone, $password, $clinic, $city, $address, $pet_id]);

        // Redirect after successful insertion
        header("location: user_manage.php");
        exit();
    } catch (PDOException $e) {
        // Log the error and display a user-friendly message
        error_log("Error inserting user: " . $e->getMessage());
        echo "Error: Failed to add user. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Add User</title>
</head>

<body>

    <div class="container-fluid vh-100">
        <div class="row vh-100">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Add User Data</h2>
                <form action="add_user.php" method="post">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM ROLES");
                        while ($role = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($role['Role_ID']) . "'>" . htmlspecialchars($role['Role_Title']) . "</option>";
                        }
                        ?>
                    </select>

                    <label for="title">Title</label>
                    <select name="title" id="title" required>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM TITLES");
                        while ($title = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($title['Title_ID']) . "'>" . htmlspecialchars($title['Title_Name']) . "</option>";
                        }
                        ?>
                    </select>

                    <label for="Fname">First Name</label>
                    <input type="text" name="Fname" id="Fname" required>

                    <label for="Lname">Last Name</label>
                    <input type="text" name="Lname" id="Lname" required>

                    <label for="Email">Email</label>
                    <input type="email" name="Email" id="Email" required>

                    <label for="PhoneNumber">Phone Number</label>
                    <input type="text" name="PhoneNumber" id="PhoneNumber" required>

                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" required>

                    <label for="City">City</label>
                    <select name="City" id="City" required>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM CITIES");
                        while ($city = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($city['City_ID']) . "'>" . htmlspecialchars($city['City_Name']) . "</option>";
                        }
                        ?>
                    </select>

                    <label for="Address">Address</label>
                    <input type="text" name="Address" id="Address" required>

                    <label for="clinic">Clinic</label>
                    <select name="clinic" id="clinic" required>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM CLINICS");
                        while ($clinic = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($clinic['Clinic_ID']) . "'>" . htmlspecialchars($clinic['Clinic_Name']) . "</option>";
                        }
                        ?>
                    </select>

                    <label for="pet">Pet (Optional)</label>
                    <select name="pet" id="pet">
                        <option value= "">None</option>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM PETS");
                        while ($pet = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($pet['Pet_ID']) . "'>" . htmlspecialchars($pet['Pet_Name']) . "</option>";
                        }
                        ?>
                    </select>

                    <input type="submit" id="add_user_button" name="sub" class="btn btn-primary" value="Add User">
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
