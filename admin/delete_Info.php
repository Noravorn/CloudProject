<?php
include('connect.php');

// Get the ID from the URL parameters
$Pid = isset($_GET['Pet_ID']) ? $_GET['Pet_ID'] : null;
$Cid = isset($_GET['Clinic_ID']) ? $_GET['Clinic_ID'] : null;
$Uid = isset($_GET['User_ID']) ? $_GET['User_ID'] : null;

if ($Pid) {
	$sql = "DELETE FROM PETS WHERE Pet_ID = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$Pid]);
} elseif ($Cid) {
	$sql = "DELETE FROM CLINICS WHERE Clinic_ID = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$Cid]);
} elseif ($Uid) {
	$sql = "DELETE FROM USERS WHERE User_ID = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$Uid]);
}

if ($stmt->rowCount() > 0) {
	header("Location: admin.php");
	exit();
} else {
	echo "DELETE failed. Error: " . $stmt->errorInfo()[2];
}
