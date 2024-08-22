<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

require('../require/functions.php'); 
session_start();


//user Request Page__________________________________


if (isset($_GET['action']) && $_GET['action'] == 'show_req') {
		?> 
         <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
            <div>
                 <a href="rejected_user.php">
                    <h6 class="font-weight-bold text-primary mt-2">Show Rejected Users</h6>
                </a>
            </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>
                                <th>ProfliePic</th>   
                                <th>Full_name</th>
                                <th>Email</th>
                                <th>D_O_B</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Requested on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT * FROM user WHERE user.is_approved = 'Pending' AND user.role_id = 2 ORDER BY user.user_id DESC "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><img width="80px" src="<?=$rows['user_image_path']?>" alt=""></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                                <td><?= $rows['email'] ?></td>
                                <td><?= $rows['date_of_birth'] ?></td>
                                <td><?= $rows['gender'] ?></td>
                                <td><?= $rows['address'] ?></td>
                                <td><?= $rows['created_at'] ?></td>
                                <td><button type="button" class="btn btn-success" onclick="accept_req(<?= $rows['user_id']?>)">Accept</button>  <button type="button" class="btn btn-danger" onclick="reject_req(<?= $rows['user_id'] ?>)" >Reject</button></td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>

                    </div>
                </div> 
            </div>
    
 		<?php

//user Request Accept action__________________________________

	}elseif (isset($_GET['action']) && $_GET['action'] == "accept_req"){

		$query="UPDATE user SET user.is_approved = 'Approved' , user.is_active = 'Active' WHERE user.user_id = '".$_GET['user_id']."' ";
		$result=excecute_query($query);
        $email="SELECT * FROM user WHERE user_id =  '".$_GET['user_id']."' ";
        $result2=excecute_query($email);
        $rows= mysqli_fetch_assoc($result2);
		if ($result) {
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
            $mail->addReplyTo('hyderalam444@gmail.com', '');

            //Set who the message is to be sent to
            $mail->addAddress($rows['email'], $rows['first_name']);
            $mail->Subject = "Registration Request Accepted";
            $mail->isHTML(true);
            $mail->Body    = "<h5>Your request is acceped </h5> 
            <p> You can login now and visit recent and latest blogs </p>";
                
                if (!$mail->send()) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Request Accepted Sucessfully';
                }           

            
		} else {
            
		}

//user Request Rejected action__________________________________


	}elseif (isset($_GET['action']) && $_GET['action'] == "reject_req"){

        $query="UPDATE user SET user.is_approved = 'Rejected' WHERE user.user_id = '".$_GET['user_id']."' ";
        $result=excecute_query($query);
        
        if ($result) {          
            echo "User request has been rejected";
            
        }else{
            echo "Some thing went wrong";
        }

//Show All users In the website registred__________________________________  
   
}elseif (isset($_GET['action']) && $_GET['action'] == "show_users"){
   
    ?>
           <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="register_user.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>
                                <th>ProfilePic</th>   
                                <th>Full_name</th>
                                <th>Email</th>
                                <th>D_O_B</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>User Role</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody >
                                    <?php $query="SELECT user.user_id, user.updated_at, user.first_name,user.last_name, user.email, user.date_of_birth,user.gender,user.address,role.role_type,user.created_at,user.is_active,user.user_image_path  FROM user,role WHERE user.role_id=role.role_id AND user.is_approved = 'Approved' AND user.user_id != '".$_SESSION['user']['user_id']."' ORDER BY user.user_id DESC"; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr align="center">
                                <td><?= $counter++ ?></td>
                                <td><img width="80px" src="<?=$rows['user_image_path']?>" alt=""></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                                <td><?= $rows['email'] ?></td>
                                <td><?=date("d-m-Y" ,strtotime($rows['date_of_birth']))?></td>
                                <td><?= $rows['gender'] ?></td>
                                <td><?= $rows['address'] ?></td>
                                <td><?= $rows['role_type'] ?></td>
                                <td><?= $rows['created_at']?></td>
                                <td><?=$rows['is_active']?></td>
                                <td>
                                <?php if ($rows['is_active'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_user(<?= $rows['user_id']?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_user(<?= $rows['user_id'] ?>)" >InActive</button></td>
                               <?php } ?>
                               <td><?= $rows['updated_at']?></td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_user(<?= $rows['user_id']?>)">Edit </button>
                                </td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                          <?php if (isset($_GET['message'])){?> 
                        <div class="alert alert-info text-center" role="alert">
                            <?= ($_GET['message']); ?>
                        </div> <?php }?>
                        </div>
                     </div> 
                 </div>
            </div>
    <?php


//Action active User__________________________________  
}elseif (isset($_GET['action']) && $_GET['action'] == "active"){
        
        $query="UPDATE user SET  user.is_active = 'Active' WHERE user.user_id = '".$_GET['user_id']."' ";
        $result=excecute_query($query);
        $email="SELECT * FROM user WHERE user_id =  '".$_GET['user_id']."' ";
        $result2=excecute_query($email);
        $rows= mysqli_fetch_assoc($result2);
        if ($result) {
            
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
            $mail->addReplyTo('hyderalam444@gmail.com', '');

            //Set who the message is to be sent to
            $mail->addAddress($rows['email'], $rows['first_name']);
            $mail->Subject = "Account activation";
            $mail->isHTML(true);
            $mail->Body    = "<p> Your accout is active now can login and visit our latest blogs </p>"; 

              if (!$mail->send()) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'User account was Activeted';
                } 

        } else {
            
    }

    
//Action Inactive User__________________________________  

}elseif (isset($_GET['action']) && $_GET['action'] == "inactive"){
        
        $query="UPDATE user SET  user.is_active = 'InActive' WHERE user.user_id = '".$_GET['user_id']."' ";
        $result=excecute_query($query);
        $email="SELECT * FROM user WHERE user_id =  '".$_GET['user_id']."' ";
        $result2=excecute_query($email);
        $rows= mysqli_fetch_assoc($result2);
        if ($result) {
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
            $mail->addReplyTo('hyderalam444@gmail.com', '');

            //Set who the message is to be sent to
            $mail->addAddress($rows['email'], $rows['first_name']);
            $mail->Subject = "Deactivated Account";
            $mail->isHTML(true);
            $mail->Body    = "<h5>Your Account is deactived now </h5> 
            <p>For further query contact with admin </p>"; 

              if (!$mail->send()) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'User account was Dectiveted';
                } 

        }else{
            
        }


//Show blogs page___________________________________________________________

    }elseif (isset($_GET['action']) && $_GET['action'] == 'show_blogs'){
    ?>

           <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="add_blog.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Blog Title</th>
                                <th>Post Per Page</th>
                                <th>Author Name</th>
                                <th>Publish</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT blog.updated_at , blog.blog_title, user.user_id, blog.blog_id, user.first_name, user.last_name ,blog.post_per_page, blog.created_at , blog.blog_status FROM user,blog WHERE user.user_id = blog.user_id AND blog.user_id = '".$_SESSION['user']['user_id']."'
                                        ORDER BY blog.blog_id DESC   "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['blog_title'] ?></td>  
                                <td><?= $rows['post_per_page'] ?></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                                <td><?= $rows['created_at'] ?></td>
                                <td><?=$rows['blog_status']?></td>
                                <td>
                                <?php if ($rows['blog_status'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_blog(<?= $rows['blog_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_blog(<?= $rows['blog_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                                <td><?= $rows['updated_at']?> </td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_blog(<?= $rows['blog_id']?>)">Edit </button>
                                </td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                          <?php if (isset($_GET['message'])){?> 
                        <div class="alert alert-info text-center" role="alert">
                            <?= ($_GET['message']); ?>
                        </div> <?php }?>
                        </div>
                    </div>
                </div> 
            </div>
   
  <?php
//Active blog Action______________________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'active_blog'){
        $query="UPDATE blog SET blog.blog_status = 'Active' WHERE blog.blog_id = '".$_GET['blog_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Your Blog was Activeted Now";
        }else{
            echo "Something Wents Wrong";
        }

//INactive blog Action______________________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'inactive_blog'){
        $query="UPDATE blog SET blog.blog_status = 'InActive' WHERE blog.blog_id = '".$_GET['blog_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Your Blog was InActiveted Now";
        }else{
            echo "Something Wents Wrong";
        }


//Show Categories____________________________________________________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'show_category'){
        ?>   
             <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="add_category.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Category Title</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT * FROM category ORDER BY category_id DESC"; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['category_title'] ?></td>  
                                <td><?= $rows['created_at']?></td>
                                <td><?= $rows['category_status'] ?></td>
                                <td>
                                <?php if ($rows['category_status'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_category(<?= $rows['category_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_category(<?= $rows['category_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                               <td><?=$rows['updated_at']?></td>
                               <td>
                                <button type="button" class="btn btn-info" onclick="edit_category(<?= $rows['category_id']?>)">Edit </button>
                                </td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                         <div class="col-lg-12">
                          <?php if (isset($_GET['message'])){?> 
                        <div class="alert alert-info text-center" role="alert">
                            <?= ($_GET['message']); ?>
                        </div> <?php }?>
                        </div>
                    </div>
                </div> 
            </div>
    <?php

//Action Active Categories________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'active_category'){
        $query="UPDATE category SET category.category_status = 'Active' WHERE category.category_id = '".$_GET['category_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Categery was Activeted";
        }else{
            echo "Something Wents Wrong";
        }
//Action InActive Categories________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'inactive_category'){
        $query="UPDATE category SET category.category_status = 'InActive' WHERE category.category_id = '".$_GET['category_id']."' ";
        $result=excecute_query($query);
        if ($result) {
             echo "Categery was deactiveted";
        }else{
            echo "Something Wents Wrong";
        }
 

//Attachments Fields_________________________________________________________________
 } elseif (isset($_GET['action']) && $_GET['action'] == 'num_of_fields'){
                $fields = $_GET['fields'];

           for ($i=1;   $i <= $fields ; $i++) { 
                    ?>        
        <div class="row">     
            <div class="form-group col-md-4">
                 <label class="text-muted">Attachement title</label>
                 <input type="text" placeholder="Enter Attachement Title" name="attachment_title[]" class="form-control form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label for="formFileMultiple" class="text-muted" class="form-label">Attachments</label>
                <input class="form-control" type="file" id="formFileMultiple" name="posts_attachments[]" required>
            </div>
             <div class="form-group col-md-4">
                    <label class="text-muted" >Attachment Status</label>
                    <select required class="form-select" name="attactment_status[]" aria-label="Select Category">
                        <option selected value="Active">Active</option>
                        <option value="InActive">Deactive</option>
                    </select>
                </div>
        </div>
<?php
        }
                
//Verify email when admin______________________________
    }elseif (isset($_POST['email']) && !empty($_POST['email'])) {

        $email = $_POST['email'];
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = excecute_query($query);

        if ($result->num_rows > 0) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }

//______________________________________________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'show_posts'){  ?>
       
 <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="add_post.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" style="height: auto;" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Post Title</th>
                                <th>Blog</th>
                                <th>Publish On</th>
                                <th>Status</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody >
                                   <?php  $query="SELECT post.updated_at ,post.post_id, post.created_at, post.post_title,blog.blog_title, post.post_status, post.is_comment_allowed
                                        FROM blog, post
                                        WHERE post.blog_id = blog.blog_id
                                        AND blog.user_id = '".$_SESSION['user']['user_id']."' ORDER BY post.post_id DESC";

                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['post_title'] ?></td>  
                                <td><?= $rows['blog_title'] ?></td> 
                                <td><?= date('Y-m-d', strtotime( $rows['created_at']))?></td>
                                <td><?=$rows['is_comment_allowed'] == 1 ? 'ON' : 'OFF'  ?></td>
                                <td>
                                <?php if ($rows['is_comment_allowed'] == 0 ) { ?>
                                <button type="button" class="btn btn-success" onclick="active_comment(<?= $rows['post_id']; ?>)">On</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_comment(<?= $rows['post_id']; ?>)" >Off</button></td>
                               <?php } ?>
                               <td><?=$rows['post_status']?></td>
                                <td>
                                <?php if ($rows['post_status'] == 'InActive' ) { ?>
                                <button type="button" class="btn btn-success" onclick="active_post(<?= $rows['post_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_post(<?= $rows['post_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                               <td><?= $rows['updated_at'] ?></td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_post(<?= $rows['post_id']?>)">Edit </button>
                                </td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                          <?php if (isset($_GET['message'])){?> 
                        <div class="alert alert-info text-center" role="alert">
                            <?= ($_GET['message']); ?>
                        </div> <?php }?>
                        </div>
                    </div>
                </div> 
            </div>
    <?php
//Action Comment On______________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'allow_comment'){

        $query="UPDATE post SET post.is_comment_allowed = 1 WHERE post.post_id = '".$_GET['post_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Comment Status is allowed on Post";
        }else{
            echo "Something Wents Wrong";
        }

//Action Comment OFF______________________________________

    }elseif (isset($_GET['action']) && $_GET['action'] == 'deactive_comment'){

        $query="UPDATE post SET post.is_comment_allowed = 0 WHERE post.post_id = '".$_GET['post_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Comment Status is allowed on Post";
        }else{
            echo "Something Wents Wrong";
        }

//Action Active Post______________________________________

    }elseif (isset($_GET['action']) && $_GET['action'] == 'active_post'){    

        $query="UPDATE post SET post.post_status = 'Active' WHERE post.post_id = '".$_GET['post_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Your Post is activeted now";
        }else{
            echo "Something Wents Wrong";
        }

//Action InActive Post______________________________________
    }elseif (isset($_GET['action']) && $_GET['action'] == 'inactive_post'){

    $query="UPDATE post SET post.post_status = 'InActive' WHERE post.post_id = '".$_GET['post_id']."' ";
        $result=excecute_query($query);
        if ($result) {
            echo "Your Post is deactiveted now";
        }else{
            echo "Something Wents Wrong";
        }
   

//Edit Blog Form_______________________________________________________________________
}elseif (isset($_GET['action']) && $_GET['action'] =='edit_blog'){
        
        $blog_id=$_GET['blog_id'];             
        $query="SELECT * FROM blog WHERE blog.blog_id= '".$blog_id."' ";
        $update=excecute_query($query);
        $rows=mysqli_fetch_assoc($update);
    ?>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Edit Blog</h5>
                        <form class="form" action="process.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group my-2">
                                <label class="text-muted">Title</label>
                                <input type="text" name="blog_title" placeholder="Enter Title" class="form-control form-control-lg" value="<?=$rows['blog_title']?>" required>
                            </div>
                            <div class="form-group my-2">
                                <label class="text-muted">Post Per Page</label>
                                <input type="number" name="blog_per_page" placeholder="Enter number" class="form-control form-control-lg" value="<?=$rows['post_per_page']?>" required min="1">
                            </div>
                            <div class="form-group my-2">
                                <label class="text-muted">Background Image</label>
                                <input type="file" name="blog_image" class="form-control form-control-lg" >
                                <img width="80px" src="<?=$rows['blog_image_path']?>" >
                            </div>
                            <div class="my-2">
                                <select class="form-select" name="blog_status" aria-label="Select Category" required>
                                    <option value="Active" <?=$rows['blog_status']== 'Active'? 'selected': "";  ?> >Active</option>
                                    <option value="InActive"  <?=$rows['blog_status']== 'InActive'? 'selected': "";  ?> >Inactive</option>
                                </select>
                            </div>
                                <input type="hidden" name="blog_id" value="<?=$blog_id?>" >
                            <div class="form-group my-3 d-grid">
                                <input type="submit" name="update_blog" value="Edit Blog" class="btn btn-info btn-lg btn-block"></input>
                            </div>
                        </form>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    
//Edit Category Form_______________________________________________________________________

  }elseif (isset($_GET['action']) && $_GET['action'] =='edit_category'){

    $category_id=$_GET['category_id'];             
    $query="SELECT * FROM category WHERE category.category_id= '".$category_id."' ";
    $update=excecute_query($query);
    $rows=mysqli_fetch_assoc($update);
    
    ?>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">Update Category</h5>
                    <form class="form" action="process.php" method="POST">
                        <div class="form-group my-2">
                            <label class="text-muted">Category Name</label>
                            <input type="text" name="catg_name" placeholder="Enter Title" value="<?=$rows['category_title']?>" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-muted">Description</label>
                            <textarea name="catg_description" class="form-control" id="description" rows="3" required> <?=$rows['category_description']?></textarea>
                        </div>
                        <div class="my-2">
                             <label for="status" class="form-label text-muted">Status</label>
                            <select class="form-select" name="catg_status" aria-label="Select Category" required>
                                <option value="Active" <?=$rows['category_status']=='Active'? 'selected' : "" ; ?> >Active</option>
                                <option value="InActive" <?=$rows['category_status']=='InActive'? 'selected' : "" ; ?> >Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" name="category_id" value="<?=$rows['category_id']?>">
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="update_catg" value="Update Category" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                    </form>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Edit User Form_______________________________________________________________________

    }elseif (isset($_GET['action']) && $_GET['action'] =='edit_user') {

    $user_id=$_GET['user_id'];
    $query="SELECT * FROM user WHERE user.user_id ='".$user_id."' ";
    $result=excecute_query($query);
    $rows=mysqli_fetch_assoc($result);

   ?>


<div class="container">
    <div class="row justify-content-center ">
        <div class="col-sm-12 col-md-10 col-lg-6" > 
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Update User</h5>
                    <p class="card-text text-center">Update User Account! </p>
                    <form class="form" action="process.php" method="POST" enctype="multipart/form-data" >
                        <div class="form-group my-2">
                            <label class="text-muted">First Name <span style="color: red;">*</span></label>
                            <input required type="text" value="<?=$rows['first_name']?>" name="first_name" id="first_name" placeholder="First Name" class="form-control form-control-lg" >
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Last Name <span style="color: red;">*</span></label>
                            <input required type="text" value="<?=$rows['last_name']?>" name="last_name" id="last_name" placeholder="Last Name" class="form-control form-control-lg">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Email <span style="color: red;">*</span></label>
                            <input disabled type="email" value="<?=$rows['email']?>" name="email" id="email" placeholder="Email Address" class="form-control form-control-lg">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Gender <span style="color: red;">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male" <?=$rows['gender']=='Male' ? 'checked' : "" ?> >
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female" <?=$rows['gender']=='Female' ? 'checked' : "" ?> >
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">DATE <span style="color: red;">*</span></label>
                            <input required type="date" name="date_of_birth" id="date_of_birth" value="<?=$rows['date_of_birth']?>" class="form-control form-control-lg"> 
                        </div>
                        <div class="my-2">
                            <label class="text-muted">Status<span style="color: red;">*</span></label>
                            <select required name="status"  class="form-select" aria-label="Default select example">
                                      <option value="Active" <?=$rows['is_active'] == 'Active' ? 'selected' : ""  ?> >Active</option>
                                      <option value="InActive" <?=$rows['is_active'] == 'InActive' ? 'selected' : ""  ?> >InActive</option>
                            </select>
                        </div>
                        <div class="my-2">
                            <label class="text-muted">SELECT USER ROLE<span style="color: red;">*</span></label>
                            <select required name="role_id"  class="form-select" aria-label="Default select example">
                                      <option value="1" <?=$rows['role_id'] == 1 ? 'selected' : ""  ?> >ADMIN</option>
                                      <option value="2" <?=$rows['role_id'] == 2 ? 'selected' : ""  ?> >USER</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Upload profile  <span style="color: red;">*</span></label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control form-control-lg">
                            <img width="80px" src="<?=$rows['user_image_path']?>" > 
                        </div>
                        <input type="hidden" name="user_id" value="<?=$rows['user_id'] ?>">
                        <div class="form-group">
                            <label class="text-muted">Lives in <span style="color: red;">*</span></label>
                            <input required type="text" name="address" value="<?=$rows['address']?>"  placeholder="Address" id="address" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="edit_user" id="register" value="Update User" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                    </form>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Edit Post Form_______________________________________________________________________

  }elseif (isset($_GET['action']) && $_GET['action'] == 'edit_post') {
    $post_id = $_GET['post_id'];
    $query = "SELECT * FROM post WHERE post.post_id = '$post_id'";
    $result = excecute_query($query);
    if ($result->num_rows > 0) {
        $post = mysqli_fetch_assoc($result);
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-10 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold">Edit Post</h5>
                            <form class="form" method="POST" action="process.php" enctype="multipart/form-data">
                                <div class="form-group my-2">
                                    <label class="text-muted">Title</label>
                                    <input required type="text" value="<?= ($post['post_title']) ?>" placeholder="Enter Title" name="post_title" class="form-control form-control-lg">
                                </div>
                                <div class="mb-2">
                                    <label for="summary" class="form-label">Summary</label>
                                    <textarea required class="form-control" name="summary" id="summary" rows="3"><?= ($post['post_summary']) ?></textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea required class="form-control" name="description" id="description" rows="3"><?= ($post['post_description']) ?></textarea>
                                </div>
                                <?php
                                $blog_query = "SELECT * FROM blog WHERE blog.user_id = '" . $_SESSION['user']['user_id'] . "' AND blog.blog_status = 'Active'";
                                $blog_result = excecute_query($blog_query);
                                if ($blog_result->num_rows > 0) {
                                    $query = "SELECT blog.blog_id, post.post_id FROM post, blog WHERE post.blog_id = blog.blog_id AND post.post_id = '$post_id'";
                                    $result = excecute_query($query);
                                    $view_blog = mysqli_fetch_assoc($result);
                                    ?>
                                    <div class="my-2">
                                        <label class="text-muted">Select Blog Page</label>
                                        <select required class="form-select" name="blog_id" aria-label="Select Blog Page">
                                            <?php while ($blogs = mysqli_fetch_assoc($blog_result)) { ?>
                                                <option value="<?= $blogs['blog_id'] ?>" <?= $view_blog['blog_id'] == $blogs['blog_id'] ? 'selected' : "" ?>><?= ($blogs['blog_title']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="my-2">
                                    <label class="text-muted">Comments status</label>
                                    <select required class="form-select" name="is_comment" aria-label="Select Category">
                                        <option value="1" <?= $post['is_comment_allowed'] == 1 ? 'selected' : "" ?>>On</option>
                                        <option value="2" <?= $post['is_comment_allowed'] == 2 ? 'selected' : "" ?>>Off</option>
                                    </select>
                                </div>
                                <div class="my-2">
                                    <?php
                                    $category_query = "SELECT * FROM category WHERE category_status = 'Active' ";
                                    $category_result = excecute_query($category_query);
                                    
                                    if ($category_result->num_rows > 0) {
                                        $query = "SELECT post_category.category_id FROM post_category, post,category WHERE category.category_id=post_category.category_id AND post.post_id = post_category.post_id AND post_category.post_id = '$post_id' ";
                                        $result = excecute_query($query);
                                        $selected = [];
                                        while ($rows = mysqli_fetch_assoc($result)) {
                                            $selected[] = $rows['category_id'];
                                        }
                                        ?>
                                        <label class="text-muted">Select Category</label>
                                        <select required class="form-select" name="category_id[]" aria-label="Select Category" multiple>
                                                
                                            <?php while ($categories = mysqli_fetch_assoc($category_result)) { ?>            
                                                <option value="<?= $categories['category_id'] ?>" <?= in_array($categories['category_id'], $selected) ? 'selected' : "" ?>> <?= ($categories['category_title']) ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div class="form-group my-2">
                                    <label class="text-muted">Feature Image</label>
                                    <input type="file" name="post_image" class="form-control form-control-lg">
                                    <img width="80px" src="<?= ($post['post_image_path']) ?>">
                                </div>
                                <?php
                                $attachment_query = "SELECT * FROM post_atachment WHERE post_atachment.post_id = '$post_id'";
                                $sql = excecute_query($attachment_query);
                                if ($sql->num_rows > 0) {
                                    while ($rows = mysqli_fetch_assoc($sql)) {
                                        ?>
                                        <div class="my-2">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-muted">Attachment title</label>
                                                    <input required type="text" value="<?= ($rows['post_attachment_title']) ?>" placeholder="Enter Attachment Title" name="attachment_title[]" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="formFileMultiple" class="text-muted">Attachments</label>
                                                    <input class="form-control" type="file" id="formFileMultiple" name="posts_attachments[]">
                                                    <?= ($rows['post_attachment_path']) ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="text-muted">Attachment Status</label>
                                                    <select required class="form-select" name="attachment_status[]" aria-label="Select Category">
                                                        <option value="Active" <?= $rows['is_active'] == 'Active' ? 'selected' : "" ?>>Active</option>
                                                        <option value="InActive" <?= $rows['is_active'] == 'InActive' ? 'selected' : "" ?>>Deactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                                <div class="my-2">
                                    <label class="text-muted">Post Status</label>
                                    <select required class="form-select" name="status" aria-label="Select Category">
                                        <option value="Active" <?= $post['post_status'] == 'Active' ? 'selected' : "" ?>>Active</option>
                                        <option value="InActive" <?= $post['post_status'] == 'InActive' ? 'selected' : "" ?>>Deactive</option>
                                    </select>
                                </div>
                                <input type="hidden" name="post_id" value="<?= ($post_id) ?>">
                                <div class="form-group my-3 d-grid">
                                    <input type="submit" name="edit_post" value="Update Post" class="btn btn-info btn-lg btn-block">
                            </form>
                                </div>
                            <hr class="my-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
//Show_comments________________________________________________________________________________________________

}elseif (isset($_GET['action']) && $_GET['action'] == 'show_comment') { ?>

 <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Post</th>
                                <th>comment</th>
                                <th>comment_on</th>
                                <th>user_comment</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT post_comment.post_comment_id, user.first_name, user.last_name ,post.post_title,  post_comment.post_id , post_comment.user_id , post_comment.comment , post_comment.is_active, post_comment.created_at FROM user,blog,post,post_comment WHERE post.post_id =post_comment.post_id AND post_comment.user_id= user.user_id AND post.blog_id=blog.blog_id AND blog.user_id =  '".$_SESSION['user']['user_id']."'   "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['post_title'] ?></td>  
                                <td><?= $rows['comment']?></td>
                                <td><?= $rows['created_at'] ?></td>
                                <td><?= $rows['first_name']." ".$rows['last_name']?></td>
                                <td><?= $rows['is_active']?></td>
                                <td>
                                <?php if ($rows['is_active'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_comment(<?= $rows['post_comment_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_comment(<?= $rows['post_comment_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                                
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
  <?php  

//Active user comment___________________________________________________________--
}elseif (isset($_GET['action']) && $_GET['action'] == 'active_comment') {
        $comment_id = $_GET['comment_id'];
        $query="UPDATE post_comment SET is_active = 'Active' WHERE post_comment_id = '".$comment_id."' ";
        $result=excecute_query($query);            
                if ($result) {
                    echo "Comment activeted";
                }else{
                    echo "Try again";
                }


//Inactive user comment__________________________________________________
}elseif (isset($_GET['action']) && $_GET['action'] == 'inactive_comment') {


        $comment_id = $_GET['comment_id'];
        $query="UPDATE post_comment SET is_active = 'InActive' WHERE post_comment_id = '".$comment_id."' ";
        $result=excecute_query($query);            
                if ($result) {
                    echo "Comment activeted";
                }else{
                    echo "Try again";
                }

}



?>