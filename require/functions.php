<?php

/*$mysqli_driver = new mysqli_driver();
$mysqli_driver->report_mode = MYSQLI_REPORT_OFF;*/


$localhost ="localhost";
$username  ="root";
$password  ="";
$database  ="21442_hyder_alam";	


$connection=mysqli_connect($localhost,$username,$password,$database);

if (mysqli_connect_errno()) {
	echo "<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error()."</p>";	
}

	function excecute_query($query){
		global $connection;
		$sql=$query;
		$result=mysqli_query($connection,$sql) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error()."</p>");
		return $result;
	}


	function login($email,$password) {
			global $connection;		
			$query="SELECT * FROM user WHERE email = '".$email."' AND password = '".$password."' ";
			$result=mysqli_query($connection,$query) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error($connection)."</p>");
				
			if($result->num_rows > 0)
			{
			
			session_start();
			$data = mysqli_fetch_assoc($result);
			
			$_SESSION["user"] = $data;
			
			 if ($_SESSION["user"]["role_id"] == 1 && $_SESSION['user']['is_active']) {
                header("Location: ../admin/index.php");
                
            } elseif ($_SESSION["user"]["role_id"] == 2 && $_SESSION['user']['is_active'] == 'Active' && $_SESSION['user']['is_approved'] == 'Approved') {
                header("Location: ../index.php");
                
            } elseif ($_SESSION["user"]["role_id"] == 2 && $_SESSION['user']['is_approved'] == 'Pending') {
                header("Location: ../login.php?message=Your Request is Pending. Kindly wait for Admin response.");
                
            } elseif ($_SESSION["user"]["role_id"] == 2 && $_SESSION['user']['is_active'] == 'InActive') {
                header("Location: ../login.php?message=Your Account is Inactive. Please contact the admin.");
                
            } else {
                header("Location: ../login.php?message=Incorrect email or password.");
              
            }
				
			}else{

				header("location: ../login.php?message=Incorrect email or password");				
			}	
	
	
	}


	function addblog($user_id,$blog_title,$post_per_page,$blog_background_image,$blog_status){
				global $connection;	
				$folder = "Blogpics";
				if (!is_dir($folder) && !mkdir($folder)) {
				            echo "Could Not Create $folder";
				}
				    $tmp_name = $_FILES['blog_image']['tmp_name'];
				    $file_name= $blog_background_image;
				    $path     = $folder ."/". rand()."_".$file_name;
			
			if(move_uploaded_file($tmp_name, $path)){ 
			$query="INSERT into blog(user_id,blog_title,post_per_page,blog_background_image,blog_image_path,blog_status) VALUES 
			('".$user_id."','".$blog_title."','".$post_per_page."','".$file_name."','".$path."','".$blog_status."')";	
        		
        		}
        		
			$result=mysqli_query($connection,$query) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error($connection)."</p>");   
                       
        		return $result;
	}





	function addbcategory($category_title,$category_description,$category_status){
		global $connection;
		$query="INSERT into category(category_title,category_description,category_status) VALUES
		('".htmlspecialchars($category_title)."','".htmlspecialchars($category_description)."','".htmlspecialchars($category_status)."')";
		$result=mysqli_query($connection,$query) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error($connection)."</p>");
		return $result;
	}


	function addpost($blog_id, $post_title,$post_summary,$post_description,$post_image,$post_status,$is_comment_allowed){
		global $connection;
		$folder = "Postpics";
				if (!is_dir($folder) && !mkdir($folder)) {
				            echo "Could Not Create $folder";
				}
				    $tmp_name = $_FILES['post_image']['tmp_name'];
				    $file_name= $post_image;
				    $path     = $folder ."/". rand()."_".$file_name;
				    			

        $query="INSERT INTO post(blog_id, post_title, post_summary, post_description,featured_image,post_image_path,post_status,is_comment_allowed)
		VALUES('".htmlspecialchars($blog_id)."','".htmlspecialchars($post_title)."','".htmlspecialchars($post_summary)."','".htmlspecialchars($post_description)."','".htmlspecialchars($file_name)."','".htmlspecialchars($path)."','".htmlspecialchars($post_status)."','".htmlspecialchars($is_comment_allowed)."')";
			if(move_uploaded_file($tmp_name, $path)){   
		$result=mysqli_query($connection,$query) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error($connection)."</p>");
        	
        	}
              return $result;
	}

	function addpost_category($category,$postid){
		global $connection;
		foreach ($category as $key) {
			$query="INSERT INTO post_category(post_id,category_id) VALUES ('".htmlspecialchars($postid)."','".htmlspecialchars($key)."') ";
			$result=mysqli_query($connection,$query) or die("<p style='color: red;'><b>Error Message: </b>".mysqli_connect_error($connection)."</p>");
			}	
			return $result;
	}




	function add_attachment($post_id, $post_attachment_title, $post_attachment_paths, $is_active) {
    global $connection;
    
    $folder = "Attachment";
    if (!is_dir($folder) && !mkdir($folder)) {
        echo "Could Not Create $folder";
    }
    
    foreach ($post_attachment_paths as $key => $path) {
        $tmp_name = $_FILES['attachment']['tmp_name'][$key];
        $file_name = $_FILES['attachment']['name'][$key];
        $path = $folder."/" .rand(). "_".$file_name; 
        if (move_uploaded_file($tmp_name, $path)) {
            $query = "INSERT INTO post_atachment (post_id, post_attachment_title, post_attachment_path, is_active)
             VALUES ('".htmlspecialchars($post_id)."','".htmlspecialchars($post_attachment_title)."','".htmlspecialchars($path)."','".htmlspecialchars($is_active)."')"; 
            $result = mysqli_query($connection, $query);
    		}
		}

            	return $result;
	}



	function adduser($role_id,$first_name,$last_name,$email,$password,$gender,$date_of_birth,$user_pic,$address){
	
		global $connection;
		$folder = "ProfilePics";
	    $tmp_name = $_FILES['profile_pic']['tmp_name'];
	    $file_name= $user_pic;
	    $path     =  "../".$folder ."/". rand()."_".$file_name; 
	    move_uploaded_file($tmp_name, $path);
	    $query="INSERT INTO user(role_id,first_name,last_name,email,password,gender,date_of_birth,user_image,user_image_path,address,is_approved ,is_active) VALUES ('".htmlspecialchars($role_id)."','".htmlspecialchars($first_name)."','".htmlspecialchars($last_name)."','".htmlspecialchars($email)."','".htmlspecialchars($password)."',
	     '".htmlspecialchars($gender)."','".htmlspecialchars($date_of_birth)."','".htmlspecialchars($file_name)."','".htmlspecialchars($path)."','".htmlspecialchars($address)."' , 'Approved' , 'Active')";
		
	            $result=mysqli_query($connection,$query);
				return $result;

	}







?>