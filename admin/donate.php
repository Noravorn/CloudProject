<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>
<?php include '../connect.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-10 p-4">
                <div class="donate_form">
                    <h2>Donate Blood</h2>
                    <form action="donate.php" method="post">
                        <!-- Owner First Name -->
                        <label for="user_Fname">Owner First Name: </label>
                        <input type="text" id="user_Fname" name="owner_first_name" required>
                        
                        <!-- Owner Last Name -->
                        <label for="user_Lname">Owner Last Name: </label>
                        <input type="text" id="user_Lname" name="owner_last_name" required>
                        
                        <!-- Pet Name -->
                        <label for="pet_name">Pet Name:</label>
                        <input type="text" id="pet_name" name="pet_name" required>
                        
                        <!-- Pet Type -->
                        <label for="pet_type">Pet Type: </label>
                        <select name="pet_type" id="pet_type" required>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                        </select>
                        
                        <!-- Blood Type -->
                        <label for="blood-type">Blood Type: </label>
                        <select id="blood-type" name="blood_type" required>
                            <?php 
                                // Default pet type if form is not submitted
                                $pet_type = isset($_POST['pet_type']) ? $_POST['pet_type'] : 'dog';
                                
                                if ($pet_type == "cat") { ?>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                            <?php } elseif ($pet_type == "dog") { ?>
                                    <option value="dea_11">DEA 1.1</option>
                                    <option value="dea_12">DEA 1.2</option>
                                    <option value="dea_3">DEA 3</option>
                                    <option value="dea_4">DEA 4</option>
                                    <option value="dea_5">DEA 5</option>
                                    <option value="dea_6">DEA 6</option>
                                    <option value="dea_7">DEA 7</option>
                                    <option value="dea_8">DEA 8</option>
                            <?php } ?>
                        </select>
                        
                        <!-- Clinic Selection -->
                        <label for="clinic">From Clinic: </label>
                        <select name="clinic" id="clinic" required>
                            <?php
                                // Fetch clinic names from the database using PDO
                                $stmt = $pdo->prepare("SELECT Clinic_Name FROM CLINICS");
                                $stmt->execute();
                                $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($clinics as $clinic) {
                                    echo "<option value='" . htmlspecialchars($clinic['Clinic_Name']) . "'>" . htmlspecialchars($clinic['Clinic_Name']) . "</option>";
                                }
                            ?>
                        </select>
                        
                        <!-- Submit Button -->
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>