<?php
	
$flag=true;
//_______________patterns______________________
$firstpattern 	 = "/^[A-Z][a-z]{2,}$/";
$lastpattern 	 = "/^[a-zA-Z]{2,}$/";
$emailpattern    = "/^[a-z]+\d*[@]{1}[a-z]+[.]{1}(com|net){1}$/";
$addresspattern  = '/^.{1,}$/';
$passwordpattern = '/^.{8,}$/';


//________________________________________________________
$first_name_msg=null;
$last_name_msg=null;
$email_msg=null;
$address_msg=null;
$gender_msg=null;
$profile_msg=null;
$birth_msg=null;
$size = 1 * 1024 * 1024;


	$file_type = $_FILES['profile_pic']['type'];
	$file_size =$_FILES["profile_pic"]["size"];
	$error	   = $_FILES['profile_pic']['error'];
 
	
	if ($error !== UPLOAD_ERR_OK) {
		$flag=false;
		$profile_msg= "Kindly upload your pic";
	} else {
		if ($file_type !== 'image/jpeg' && $file_type !== 'image/png') {
			$flag = false;
			$profile_msg = "Only JPG and PNG images are allowed";
		}elseif ($file_size > $size) {
			$flag=false;
			$profile_msg= "Your image size must be less then 1 Mb";
		} else {
			$profile_msg="";
		}

	}

	
		if ($first_name == "") {
    	$flag = false;
    	$first_name_msg = "Required field";
		} else {
		    if (preg_match($firstpattern, $first_name) == 0) {
		        $flag = false;
		        $first_name_msg = "Name start with capital letter";
		    } else {
		        $first_name_msg = "";
		    }
		}




	if ($last_name == "") {
		$flag=false;
		$last_name_msg="Required field";	
	
	} else {
		
		if(preg_match($lastpattern,$last_name) == 0) {
			$flag=false;
			$last_name_msg="Enter your last name";
		} else {
			$last_name_msg= "";		
		}
		
	}



	if ($email == "") {
		$flag=false;
		$email_msg="Required field";	
	
	} else {
		
		if(preg_match($emailpattern,$email) == 0) {
			$flag=false;
			$email_msg="Please enter a valid email address like (example@example.com) Or (example@example.com)";
		} else {
			$email_msg= "";						
		}
		
	}



		if ($password == "") {
		    $flag = false;
		    $password_msg = "Required field";
		} else {
		    if (preg_match($passwordpattern,$password) == 0) {
		        $flag = false;
		        $password_msg = "Password must be at least 8 characters long";
		    }else{
		        $password_msg = "";

		    }
		}


	if ($address == "") {
		$flag=false;
		$address_msg="Required field";	
	
	} else {
		
		if(preg_match($addresspattern,$address) == 0) {
			$flag=false;
			$address_msg="Please Enter your proper address";
		} else {
			$address_msg= "";		
		}
		
	}




	if ($date_of_birth === "") {
		$flag=false;
		$birth_msg="Required field";	
	} else {
			$birth_msg="";
	}		
	

	
	if (!isset($gender)) {
	$flag=false;
	$gender_msg="Required field";
	} else {
		$gender_msg="";
	}


?>