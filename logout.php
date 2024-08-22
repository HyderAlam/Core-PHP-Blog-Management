<?php
session_start();
if (isset($_SESSION)) {

    session_destroy();
    $_SESSION = array(); 
    header("location: login.php?message=Your account was logged out successfully");
   
} else {
    header("location: login.php");
}
?>
