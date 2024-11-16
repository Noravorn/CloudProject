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
    <title>Donation History</title>
</head>
<body>
    <div class="container">
    <?php include 'sideBar.php'; ?>
        <!-- END OF SIDEBAR -->
        <div id="DonationTable" class="DisplayTable">
        <h2>Donation History</h2>
            <table>
                <col width="15%">
                <col width="15%">
                <col width="15%">
                <col width="15%">
                <col width="15%">
                <col width="15%">
                <col width="10%">
                <col width="10%">
                <tr>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Type</th>
                    <th>Blood Type</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                    $q = "select * from DONATION_HISTORY dh JOIN BLOOD_TYPES bt ON dh.BloodTypeID = bt.BloodTypeID JOIN PETS p ON dh.PetID = p.PetID;";
                    $result = $conn->query($q);
                    if (!$result) {
                        echo "Select failed. Error: " . $conn->error;
                        return false;
                    }
                    while ($row = $result->fetch_array()) { ?>
                    <tr>
                        <td>
                            <? echo $row['Pet_Name'];?>
                        </td>
                        <td>
                            <? echo $row['User_Fname'] . " " . $row['User_Lname'];?>
                        </td>
                        <td>
                            <? echo $row['Pet_Type'];?>
                        </td>
                        <td>
                            <? echo $row['Blood_Type_Name'];?>
                        </td>
                        <td>
                            <? echo $row['Pet_Breed'];?>
                        </td>
                        <td>
                            <? echo $row['Pet_Age'];?>
                        </td>
                        <td><a href='edit_pet.php?id=<? echo $row['Pet_ID']; ?>'> <!--<img src="images/.png" alt="Edit">--> Edit</a></td>
                        <td><a href='delete_pet.php?id=<? echo $row['Pet_ID']; ?>'> <!--<img src="images/.png" alt="Delete">--> Delete</a></td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</body>
</html>