<?php
ob_start();
require("functions.php");

if (isset($_POST['login'])) {
        $email = $_POST['email'];           
        $password = (sha1($_POST['password']));        
       login($email,$password);

} else {
    
    header("Location: ../login.php?message=Login your account first");
   
}




?>
