<?php include("require/header.php"); 

if (!(isset($_SESSION['user']))) {
    header("location:logout.php");
}


if (isset($_GET['user_id'])) {
	$user_id=$_GET['user_id'];
}

$query="SELECT * FROM user WHERE user.user_id= '".$user_id."' ";
$result=excecute_query($query);
$rows=mysqli_fetch_assoc($result);

?>


<script type="text/javascript" src="require/validation.js"></script>

<div class="container mt-5" id="change_password">
    <div class="row justify-content-center " >
        <div class="col-sm-12 col-md-10 col-lg-6 mt-5"> 
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Edit Profile</h5>
                    <p class="card-text text-center">Update Your Account!</p>
                    <form class="form" action="require/ajax_process.php" method="POST" enctype="multipart/form-data" >
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
                        <div class="form-group my-2">
                            <label class="text-muted">Upload profile  <span style="color: red;">*</span></label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control form-control-lg">
                           <img width="80px" src="<?='profilepics/'.$rows['user_image_path']?>"  > 
                        
                        </div>
                        <input type="hidden" name="user_id" value="<?=$rows['user_id'] ?>">
                        <div class="form-group">
                            <label class="text-muted">Lives in <span style="color: red;">*</span></label>
                            <input required type="text" name="address" value="<?=$rows['address']?>"  placeholder="Address" id="address" class="form-control form-control-lg"> 
                        </div>
                        <input type="hidden" name="user_id" value="<?=$user_id?>">
                        
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="update_account" id="register" value="Update Profile" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                            
                    </form>
                </div>
                    <hr class="my-4">
            </div>
        </div>
    </div>
</div>


<?php include("require/footer.php") ?>