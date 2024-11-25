<?php 
include '../connect.php'; 

// Handle form submission first to ensure headers are not sent after output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
    try {
        // Sanitize and validate form data
        $Title = filter_var($_POST['title'], FILTER_SANITIZE_NUMBER_INT);
        $Role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
        $Fname = htmlspecialchars($_POST['Fname']);
        $Lname = htmlspecialchars($_POST['Lname']);
        $Email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
        $PhoneNumber = htmlspecialchars($_POST['PhoneNumber']);
        $City = filter_var($_POST['city'], FILTER_SANITIZE_NUMBER_INT);
        $Clinic = filter_var($_POST['clinic'], FILTER_SANITIZE_NUMBER_INT);
        $Pet = isset($_POST['pet']) && !empty($_POST['pet']) ? $_POST['pet'] : null;
        $Address = htmlspecialchars($_POST['address']);

        // Validate inputs
        if (!$Email) {
            throw new Exception("Invalid email format.");
        }

        // Fetch user data if ID is set
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            // Prepare and execute update query
            $stmt = $pdo->prepare("UPDATE USERS 
                SET User_Title_ID = ?, User_Role_ID = ?, User_Fname = ?, User_Lname = ?, User_Email = ?, 
                    User_Phone_Number = ?, User_City_ID = ?, User_Clinic_ID = ?, User_Pet_ID = ?, User_Address = ? 
                WHERE User_ID = ?");
            $stmt->execute([$Title, $Role, $Fname, $Lname, $Email, $PhoneNumber, $City, $Clinic, $Pet, $Address, $id]);

            // Check if any row was updated
            if ($stmt->rowCount() > 0) {
                // Redirect on success
                header("Location: user_manage.php");
                exit;
            } else {
                throw new Exception("No changes made or user not found.");
            }
        }
    } catch (Exception $e) {
        // Display error
        echo "<p style='color: red;'>Error updating user data: " . $e->getMessage() . "</p>";
    }
} 

// Fetch user data if ID is set
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = null;
if ($id) {
    try {
        // Prepare and execute SQL to fetch user data
        $stmt = $pdo->prepare("SELECT * FROM USERS WHERE User_ID = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found.");
        }
    } catch (Exception $e) {
        // Handle error and display message
        die("Error fetching user data: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../header.php'); ?>
    <title>Edit User</title>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row vh-100">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <h2>Edit User Data</h2>

                <?php if (isset($user)): ?>
                    <div class="user_form">
                        <!-- Form to edit user data -->
                        <form action="edit_user.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                            <label for="Role">Role</label>
                            <select name="role" id="role" required>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM ROLES");
                                while ($role = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $role['Role_ID'] == $user['User_Role_ID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($role["Role_ID"]) . "' $selected>" . htmlspecialchars($role["Role_Title"]) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="Title">Title</label>
                            <select name="title" id="title" required>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM TITLES");
                                while ($title = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $title['Title_ID'] == $user['User_Title_ID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($title["Title_ID"]) . "' $selected>" . htmlspecialchars($title["Title_Name"]) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="Fname">First Name</label>
                            <input type="text" class="form-control" name="Fname" id="Fname" value="<?php echo htmlspecialchars($user['User_Fname']); ?>" required>

                            <label for="Lname">Last Name</label>
                            <input type="text" class="form-control" name="Lname" id="Lname" value="<?php echo htmlspecialchars($user['User_Lname']); ?>" required>

                            <label for="Email">Email</label>
                            <input type="email" class="form-control" name="Email" id="Email" value="<?php echo htmlspecialchars($user['User_Email']); ?>" required>

                            <label for="PhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="<?php echo htmlspecialchars($user['User_Phone_Number']); ?>" required>

                            <label for="City">City</label>
                            <select name="city" id="city" required>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM CITIES");
                                while ($city = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $city['City_ID'] == $user['User_City_ID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($city["City_ID"]) . "' $selected>" . htmlspecialchars($city["City_Name"]) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="Clinic">Clinic</label>
                            <select name="clinic" id="clinic" required>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM CLINICS");
                                while ($clinic = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $clinic['Clinic_ID'] == $user['User_Clinic_ID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($clinic["Clinic_ID"]) . "' $selected>" . htmlspecialchars($clinic["Clinic_Name"]) . "</option>";
                                }
                                ?>
                            </select>

                            <label for="Pet">Pet (Optional)</label>
                            <select name="pet" id="pet">
                                <option value="">None</option>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM PETS");
                                while ($pet = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $pet['Pet_ID'] == $user['User_Pet_ID'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($pet["Pet_ID"]) . "' $selected>" . htmlspecialchars($pet["Pet_Name"]) . "</option>";
                                }
                                ?>
                            </select>
                            
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo htmlspecialchars($user['User_Address']); ?>" required>

                            <input type="submit" id="edit_user_button" name="sub" class="btn btn-primary" value="Update">
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

    form input,
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