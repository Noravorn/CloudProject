<?php
session_start();

if (isset($_SESSION['User_ID'])) {
    header("Location: information.php");
} else {
    header("Location: login.php");
}
?>