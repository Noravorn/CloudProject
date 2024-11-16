<?php 
	include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
          rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="style.css">
    <title>Donate</title>
</head>
<body>
    <div class="container">
      <?php include 'sideBar.php'; ?>
          <!-- END OF SIDEBAR -->
          <div class="donate_form">
            <h2>Donate Blood</h2>
            <form action="donate.php" method="post">
                <label for="user_Fname">Owner Name: </label>
                <input type="text" id="user_Fname" name="name">
                <label for="user_Lname">Owner Last Name: </label>
                <input type="text" id="user_Lname" name="user_Lname">
                <label for="pet_name">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name">
                <label for="pet_type">Pet Type: </label>
                <select name="pet_type" id="">
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                </select>
                <label for="blood-type">Blood Type: </label>
                <select id="blood-type" name="blood-type">
                  <?php if ($animal == "cat") { ?>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="AB">AB</option>
                  <?php } elseif ($animal == "dog") { ?>
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
                <label for="clinic">From Clinic: </label>
                <select name="clinic" id="clinic">
                    <?php
                    // Connect to the database
                    $conn = mysqli_connect("localhost", "username", "password", "database");

                    // Query the database for clinic names
                    $query = "SELECT name FROM clinics";
                    $result = mysqli_query($conn, $query);

                    // Loop through the results and generate options for the select element
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }

                    // Close the database connection
                    mysqli_close($conn);
                  ?>
                </select>
                <input type="submit" name="submit" value="Submit">
            </form>
          </div>
    </div>
  </body>
</html>