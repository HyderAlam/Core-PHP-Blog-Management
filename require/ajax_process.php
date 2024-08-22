<?php
require_once("functions.php");
session_start();

if (isset($_POST['email']) && !empty($_POST['email'])) {

$email = $_POST['email'];

$query = "SELECT * FROM user WHERE email = '$email'";
$result = excecute_query($query);

if ($result->num_rows > 0) {
    echo 'exists';
} else {
    echo 'not_exists';
}


}

if (isset($_POST['add_comment']) && $_POST['add_comment'] ) {
            extract($_POST);
          $query= "INSERT INTO post_comment(post_id,user_id,comment,is_active) VALUES ('".$post_id."','".$user_id."','".$comment_message."', 'Active') ";
            $result=excecute_query($query);
            if (isset($result)) {
                header("Location: ../view.php?post_id=$post_id&message=Comment added");
            }else{
                header("Location: ../view.php?post_id=$post_id&message=Comment not added try again");
            }
}

if (isset($_GET['action']) && $_GET['action'] == 'newfollow') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];
    $post_id = $_GET['post'];

    $query = "INSERT INTO following_blog (follower_id, blog_following_id, status) VALUES ('" . $user_id . "','" . $blog_id . "', 'Followed')";
    $result = excecute_query($query);

    if ($result) {
        header("Location: ../view.php?post_id=$post_id&message=Successfully followed");
    } else {
        header("Location: ../view.php?post_id=$post_id&message=request failed try again");
    }
  
}

if (isset($_GET['action']) && $_GET['action'] == 'unfollow') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];
    $post_id = $_GET['post'];

    $query = "UPDATE following_blog SET status = 'Unfollowed', updated_at = NOW() WHERE follower_id = '" . $user_id . "' AND blog_following_id = '" . $blog_id . "'";
    $result = excecute_query($query);

    if ($result) {
        header("Location: ../view.php?post_id=$post_id&message=Unfollowed");
    } else {
        header("Location: ../view.php?post_id=$post_id&message=request failed try again");
    }
 
 }


 if (isset($_GET['action']) && $_GET['action'] == 'follow') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];
    $post_id = $_GET['post'];

    $query = "UPDATE following_blog SET status = 'followed', updated_at = NOW() WHERE follower_id = '" . $user_id . "' AND blog_following_id = '" . $blog_id . "'";
    $result = excecute_query($query);
    if ($result) {
        header("Location: ../view.php?post_id=$post_id&message=followed");
    } else {
        header("Location: ../view.php?post_id=$post_id&message=request failed try again");
    }
 
 }


if (isset($_POST['submit_feedback']) && $_POST['submit_feedback'] ) {
      extract($_POST);
    
    if (isset($user_id)) {
    $query="SELECT first_name, email FROM user WHERE user.user_id ='".$user_id."' ";
    $result = excecute_query($query);
    $user=mysqli_fetch_assoc($result);
    $user_name=$user['first_name'];
    $user_email=$user['email'];
    $insert="INSERT INTO user_feedback (user_id,user_name,user_email,feedback) VALUES ('".$user_id."','".$user_name."','".$user_email."','".$feedback."')";
    $result2=excecute_query($insert);
            if ($result2) {
                header("Location: ../contact.php?message=Your feedback Submit Successfully"); 
            } else {
                header("Location: ../contact.php?message=Your feedback Not Submit try again"); 
            }

    } else {

     $insert="INSERT INTO user_feedback (user_name,user_email,feedback) VALUES ('".$username."','".$email."','".$feedback."')";
     $result2=excecute_query($insert);
             if ($result2) {
                    header("Location: ../contact.php?message=Your feedback Submit Successfully"); 
                } else {
                    header("Location: ../contact.php?message=Your feedback Not Submit try again"); 
                }


    }

}



   if (isset($_POST['update_account']) && $_POST['update_account'] ) {
           extract($_POST); 
          if (isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name'] !== '' ) {
            $select="SELECT * FROM user WHERE user.user_id = $user_id";
            $result= excecute_query($select); 
            $unlink=mysqli_fetch_assoc($result);
            $existing_path=$unlink['user_image_path'];
            if (file_exists($existing_path)) {
                unlink($existing_path);
            }
            $folder = "../ProfilePics";
            $tmp_name = $_FILES['profile_pic']['tmp_name'];
            $file_name = rand() . "_" . $_FILES['profile_pic']['name'];
            $path =  $folder . "/" . $file_name;              
            move_uploaded_file($tmp_name, $path); 
            $query = "UPDATE user SET first_name = '".$first_name."', last_name = '".$last_name."', gender = '".$gender."', user_image = '".$file_name."', user_image_path = '".$path."', date_of_birth = '".$date_of_birth."' , address = '".$address."' , updated_at = NOW() WHERE user_id = '".$user_id."' ";
        } else {
            $query = "UPDATE user SET first_name = '".$first_name."', last_name = '".$last_name."', gender = '".$gender."', date_of_birth = '".$date_of_birth."' , address = '".$address."' , updated_at = NOW() WHERE user_id = '".$user_id."' ";
        }

                $result=excecute_query($query);   
                if ($result) {
                    header('location: ../index.php?message=Profile Updated Sucessfully');
                } else {
                    header('location: ../index.php?message=Profile was not Updated');    
                }       

    } 




//Blog Page Following---------------------------------------------------------------


    if (isset($_GET['action']) && $_GET['action'] == 'newflw') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];

    $query = "INSERT INTO following_blog (follower_id, blog_following_id, status) VALUES ('" . $user_id . "','" . $blog_id . "', 'Followed')";
    $result = excecute_query($query);

    if ($result) {
        header("Location: ../blog.php?message=Successfully followed");
    } else {
        header("Location: ../blog.php?message=request failed try again");
    }
  
}

if (isset($_GET['action']) && $_GET['action'] == 'unflw') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];
    $query = "UPDATE following_blog SET status = 'Unfollowed', updated_at = NOW() WHERE follower_id = '" . $user_id . "' AND blog_following_id = '" . $blog_id . "'";
    $result = excecute_query($query);

    if ($result) {
        header("Location: ../blog.php?message=You Unfollowed blog");
    } else {
        header("Location: ../blog.php?message=request failed try again");
    }
 
 }


 if (isset($_GET['action']) && $_GET['action'] == 'flw') {
    $user_id = $_GET['user_id'];
    $blog_id = $_GET['blog_id'];

    $query = "UPDATE following_blog SET status = 'followed', updated_at = NOW() WHERE follower_id = '" . $user_id . "' AND blog_following_id = '" . $blog_id . "'";
    $result = excecute_query($query);
    if ($result) {
        header("Location: ../blog.php?message=Successfully followed");
    } else {
        header("Location: ../blog.php?message=request failed try again");
    }
 
 }



//_________SEARCH RESULT_______________________________________________________

if (isset($_POST['search']) && $_POST['search'] ) {
    extract($_POST);

    
      header("Location: ../search.php?search_term=$search_result");
     





}

























?>

