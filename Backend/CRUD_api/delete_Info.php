<?php
	$Pid = $_GET['Pet_ID'];
	$Cid = $_GET['Clinic_ID'];
	$Uid = $_GET['User_ID'];
	include('connect.php');
	if (isset($Pid)) {
		$q="DELETE FROM PETS where Pet_ID=$Pid";
			if(!$conn->query($q)){
				echo "DELETE failed. Error: ".$conn->error ;
		   }
		   $conn->close();
		   //redirect
		   header("Location: admin.php");
	}
	elseif(isset($Cid)) {
		$q2="DELETE FROM CLINICS where Clinic_ID=$Cid";
			if(!$conn->query($q2)){
				echo "DELETE failed. Error: ".$conn->error ;
		   }
		   $conn->close();
		   //redirect
		   header("Location: admin.php");
	}
	elseif(isset($Uid)) {
		$q3="DELETE FROM USERS where User_ID=$Uid";
			if(!$conn->query($q3)){
				echo "DELETE failed. Error: ".$conn->error ;
		   }
		   $conn->close();
		   //redirect
		   header("Location: admin.php");
	}
?>
