<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

require('../require/functions.php');
session_start();

function redirect($url) {
    header("Location: $url");
    
}

//add blog____________________________________________________________________________
if (isset($_POST['add_blog']) && $_POST['add_blog']) {
   		 $user_id = $_SESSION['user']['user_id'];
    	 $blog_title = $_POST['blog_title'];
    	 $blog_per_page = $_POST['blog_per_page'];
         $blog_status = $_POST['blog_status'];
         $blog_image = $_FILES['blog_image']['name'];

    $result=addblog($user_id,$blog_title,$blog_per_page,$blog_image,$blog_status);

    if ($result) {
        header("Location: add_blog.php?message=Blog added successfully...!");
    } else {
        header("Location: add_blog.php?message=Blog was not added...!");
    }
} 


//Add category_______________________________________________________________________


if (isset($_POST['add_catg']) && $_POST['add_catg']) {

$result=addbcategory($_POST['catg_name'],$_POST['catg_description'],$_POST['catg_status']);
 
	 if ($result) {
        header("Location: add_category.php?message=Category added successfully...!");
    } else {
        header("Location: add_category.php?message=Category was not added...!");
    }

} 

//Register_user Admin panel____________________________________________________________________

if (isset($_POST['add_user']) && $_POST['add_user']) {

    extract($_POST);
    $password=sha1($password);
      $result =adduser($role_id,$first_name,$last_name,$email,$password,$gender,$date_of_birth,$_FILES['profile_pic']['name'],$address);
       if ($result) {
        header("Location: users.php?message=User Added successfully");     
       } else {
        header("Location: users.php?message=User was not Added ");     
       }

} 

//Add_Post___________________________________________________________________________________________________

if (isset($_POST['add_post']) && $_POST['add_post'] ) {

    // Add post
    $result = addpost($_POST['blog_id'], $_POST['post_title'], $_POST['summary'], $_POST['description'], $_FILES['post_image']['name'], $_POST['status'], $_POST['is_comment']);


            if (isset($result)) {
             // Add post category
            $postid=mysqli_insert_id($connection);
            $result1 = addpost_category($_POST['category_id'], $postid);
            header("Location: add_post.php?message=post added successfully");
          }
   			
 
        if (isset($_FILES['posts_attachments']) && count($_FILES['posts_attachments']['name']) > 0) {
 
            $folder = "post_attachment";
            if (!is_dir($folder) && !mkdir($folder)) {
                echo "Could Not Create $folder";
            }
            
            for ($i = 0; $i < count($_FILES['posts_attachments']['name']); $i++) {
                $file_name = $_FILES['posts_attachments']['name'][$i];
                $tmp_name = $_FILES['posts_attachments']['tmp_name'][$i];
                $attachment_title = $_POST['attachment_title'][$i];
                $attactment_status= $_POST['attactment_status'][$i];
                $path = $folder . "/" . rand() . "_" . $file_name;
                if (move_uploaded_file($tmp_name, $path)) {
                    $query = "INSERT INTO post_atachment (post_id, post_attachment_title, post_attachment_path, is_active) VALUES ('" . $postid . "', '" . htmlspecialchars($attachment_title) . "', '" . htmlspecialchars($path) . "', '" . htmlspecialchars($attactment_status) . "')";
                    $result2 = excecute_query($query);
                }
            }
        }
            
            if (isset($result2)) {
                header("Location: add_post.php?message=post added successfully with attachments");
            }

            $follow= "SELECT user.email ,user.first_name ,blog.blog_title FROM blog,user,following_blog WHERE following_blog.follower_id =user.user_id AND following_blog.blog_following_id = blog.blog_id AND  following_blog.blog_following_id = '".$_POST['blog_id']."' AND following_blog.status = 'Followed' " ;
                $users=excecute_query($follow);        
    

                    if ($users->num_rows > 0) {
    
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hyderalam444@gmail.com';
                    $mail->Password = 'qfcgbxrtowodostd';

                    //Set who the message is to be sent from
                    $mail->setFrom('hyderalam444@gmail.com', 'Blog management system');

                    //Set an alternative reply-to address
                    $mail->addReplyTo('hyderalam444@gmail.com', 'Admin');

                        while($send = mysqli_fetch_assoc($users)){
                    //Set who the message is to be sent to
                    $mail->addAddress($send['email'], $send['first_name']);
                    $mail->Subject = "New Post is updated on :".$send['blog_title'] ;
                    $mail->isHTML(true);
                    $mail->Body    = "<p>" .substr($_POST['summary'], 0, 200) . "</p>";
                      }  
                        if (!$mail->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                           
                        }                      
                                                    

                    }


}

//Update blog_____________________________________________________________________________


 if (isset($_POST['update_blog']) && $_POST['update_blog']  ) {
            extract($_POST);              
        
        if (isset($_FILES['blog_image']['name']) && $_FILES['blog_image']['name'] !== '' ) { 
            $select="SELECT * FROM blog WHERE blog.blog_id = $blog_id";
            $result= excecute_query($select); 
            $unlink=mysqli_fetch_assoc($result);
            $existing_path=$unlink['blog_image_path'];
            if (file_exists($existing_path)) {
                unlink($existing_path);
            }
            $folder = "Blogpics";
            $tmp_name = $_FILES['blog_image']['tmp_name'];
            $file_name = rand() . "_" . $_FILES['blog_image']['name'];
            $path = $folder . "/" . $file_name;              
            move_uploaded_file($tmp_name, $path); 
            $query = "UPDATE blog SET blog_title = '".htmlspecialchars($blog_title)."', post_per_page = '".htmlspecialchars($blog_per_page)."', blog_background_image = '".htmlspecialchars($file_name)."', blog_image_path = '".htmlspecialchars($path)."', blog_status = '".htmlspecialchars($blog_status)."', updated_at = NOW() WHERE blog_id = '".$blog_id."' ";
        } else {
            $query = "UPDATE blog SET blog_title = '".htmlspecialchars($blog_title)."', post_per_page = '".htmlspecialchars($blog_per_page)."', blog_status = '".htmlspecialchars($blog_status)."', updated_at = NOW()  WHERE blog_id = '".$blog_id."' ";
        }
                $result=excecute_query($query);   
                if (isset($result)) {
                    header('location: blog.php?message=blog Updated Sucessfully');
                } else {
                    header('location: blog.php?message=blog was not Updated');    
                }        
        
        }


//Update Category_____________________________________________________________

    if (isset($_POST['update_catg']) && $_POST['update_catg'] ) {
        extract($_POST);

        $query="UPDATE category SET category_title = '".htmlspecialchars($catg_name)."' , category_description = '".htmlspecialchars($catg_description)."' , 
        category_status = '".htmlspecialchars($catg_status)."' , updated_at = NOW() WHERE category_id = '".$category_id."'  " ;
        $result=excecute_query($query);

        if ($result) {
              header('location: category.php?message=Category Updated Sucessfully');
        } else {
            
              header('location: category.php?message=Category was not Updated ');
        }
   

    } 

//Update User____________________________________________________________________________________________

     if (isset($_POST['edit_user']) && $_POST['edit_user'] ) {
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
            $path =   $folder . "/" . $file_name;              
            move_uploaded_file($tmp_name, $path); 
            $query = "UPDATE user SET first_name = '".$first_name."', last_name = '".$last_name."', gender = '".$gender."', user_image = '".$file_name."', user_image_path = '".$path."', date_of_birth = '".$date_of_birth."' , address = '".$address."'  , role_id = '".$role_id."' , is_active = '".$status."' , updated_at = NOW() WHERE user_id = '".$user_id."' ";
        } else {
            $query = "UPDATE user SET first_name = '".$first_name."', last_name = '".$last_name."', gender = '".$gender."', role_id = '".$role_id."', date_of_birth = '".$date_of_birth."' , address = '".$address."' , is_active = '".$status."' , updated_at = NOW() WHERE user_id = '".$user_id."' ";
        }

                $result=excecute_query($query);   
                if ($result) {
                    header('location: users.php?message=User Updated Sucessfully');
                } else {
                    header('location: users.php?message=User was not Updated');    
                }       

    } 


//update post________________________________________________________________________________

    if (isset($_POST['edit_post']) && $_POST['edit_post']) {
            extract($_POST);
         if (isset($_FILES['post_image']['name']) && $_FILES['post_image']['name'] !== '' && isset($_FILES['posts_attachments']['name']) && count($_FILES['posts_attachments']['name']) > 0  ){       
            $folder = "Postpics";
            $tmp_name = $_FILES['post_image']['tmp_name'];
            $file_name = rand() . "_" . $_FILES['post_image']['name'];
            $path =  $folder . "/" . $file_name;              
            move_uploaded_file($tmp_name, $path); 

             $query = "UPDATE post SET blog_id = '".htmlspecialchars($blog_id)."', post_title = '".htmlspecialchars($post_title)."', post_summary = '".htmlspecialchars($summary)."', post_description = '".htmlspecialchars($description)."', featured_image = '".$_FILES['post_image']['name']."', post_image_path = '".$path."', post_status = '".$status."', is_comment_allowed = '".$is_comment."', updated_at = NOW() WHERE post_id = '".$post_id."'";
             $update=excecute_query($query);
             if (isset($update)) {
                foreach ($_POST['category_id'] as $key ) {
                $query1= "UPDATE post_category SET category_id = '".$key."' , updated_at= NOW() WHERE post_category.post_id = '".$post_id."' " ;
                 $update1=excecute_query($query1);
                } 
            }
            
             foreach ($_FILES['posts_attachments']['name'] as $key => $value) {
                $folder = "post_attachment";
                $tmp_name = $_FILES['posts_attachments']['tmp_name'][$key];
                $file_name = rand() . "_" . $_FILES['posts_attachments']['name'][$key];
                $attachment_title = $_POST['attachment_title'][$key];
                $attachment_status = $_POST['attactment_status'][$key];
                $path = $folder . "/" . $file_name;
                move_uploaded_file($tmp_name, $path);
                $query2 = "UPDATE post_atachment SET post_attachment_title = '".htmlspecialchars($attachment_title)."', post_attachment_path = '".htmlspecialchars($path)."',  is_active = '".htmlspecialchars($attachment_status)."',  updated_at = NOW()  WHERE post_id = '".$post_id."'";
                $update2 = excecute_query($query2);
            }
            if ($update2) {
                header("Location: post.php?message=post Update successfully with attachments and post pic");
            } else {
                header("Location: post.php?message=post Not Updated try again");
            }

        } elseif (isset($_FILES['post_image']['name']) && $_FILES['post_image']['name'] !== '') {               
                $folder = "Postpics";
                $tmp_name = $_FILES['post_image']['tmp_name'];
                $file_name = rand() . "_" . $_FILES['post_image']['name'];
                $path = $folder . "/" . $file_name;
                move_uploaded_file($tmp_name, $path);
                $query = "UPDATE post SET blog_id = '".htmlspecialchars($blog_id)."',  post_title = '".htmlspecialchars($post_title)."', post_summary = '".htmlspecialchars($summary)."',  post_description = '".htmlspecialchars($description)."', featured_image = '".$_FILES['post_image']['name']."', post_image_path = '".$path."',  post_status = '".$status."', is_comment_allowed = '".$is_comment."', 
                    updated_at = NOW()  WHERE post_id = '".$post_id."'";
                $update = excecute_query($query);
                if ($update) {
                    foreach ($_POST['category_id'] as $key) {
                        $query1 = "UPDATE post_category SET category_id = '".$key."', updated_at = NOW() WHERE post_id = '".$post_id."'";
                        $update1 = excecute_query($query1);
                    }

                    header("Location: post.php?message=Post updated successfully with image");
                } else {
                    header("Location: post.php?message=Post not updated try again");
                }               
   
    } elseif (isset($_FILES['posts_attachments']['name']) && count($_FILES['posts_attachments']['name']) > 0) {
            foreach ($_FILES['posts_attachments']['name'] as $key => $value) {
            $folder = "post_attachment";
            $tmp_name = $_FILES['posts_attachments']['tmp_name'][$key];
            $file_name = rand() . "_" . $_FILES['posts_attachments']['name'][$key];
            $attachment_title = $_POST['attachment_title'][$key];
            $attachment_status = $_POST['attactment_status'][$key];
            $path =  $folder . "/" . $file_name;
            move_uploaded_file($tmp_name, $path);
            $query2 = "UPDATE post_atachment SET post_attachment_title = '".htmlspecialchars($attachment_title)."',  post_attachment_path = '".htmlspecialchars($path)."', is_active = '".htmlspecialchars($attachment_status)."', updated_at = NOW() WHERE post_id = '".$post_id."'";
            $update2 = excecute_query($query2);
            }
            $query = "UPDATE post  SET blog_id = '".htmlspecialchars($blog_id)."', post_title = '".htmlspecialchars($post_title)."', post_summary = '".htmlspecialchars($summary)."', post_description = '".htmlspecialchars($description)."', post_status = '".$status."', 
            is_comment_allowed = '".$is_comment."', updated_at = NOW()  WHERE post_id = '".$post_id."'";
            $update = excecute_query($query);
            if ($update2) {
                foreach ($_POST['category_id'] as $key) {
                $query1 = "UPDATE post_category SET category_id = '".$key."', updated_at = NOW() WHERE post_id = '".$post_id."'";
                $update1 = excecute_query($query1);
                header("Location: post.php?message=Post updated successfully");
                 }
            } else {
                header("Location: post.php?message=Post not updated try again");
            }

    } else {
          
             $query = "UPDATE post  SET blog_id = '".htmlspecialchars($blog_id)."', post_title = '".htmlspecialchars($post_title)."', post_summary = '".htmlspecialchars($summary)."',  post_description = '".htmlspecialchars($description)."', post_status = '".$status."', is_comment_allowed = '".$is_comment."', 
            updated_at = NOW()  WHERE post_id = '".$post_id."'";
            $update = excecute_query($query);

        if ($update) {
            
            foreach ($_POST['category_id'] as $key) {
                $query1 = "UPDATE post_category SET category_id = '".$key."', updated_at = NOW() WHERE post_id = '".$post_id."'";
                $update1 = excecute_query($query1);
            }
              

            header("Location: post.php?message=Post updated successfully");
        } else {
            header("Location: post.php?message=Post not updated try again");
        }

    }

}


//_update profile______________________________________________________

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
                    header('location: index.php?message=Profile Updated Sucessfully');
                } else {
                    header('location: index.php?message=Profile was not Updated');    
                }       

    } 


?>
