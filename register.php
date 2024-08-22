<?php 
ob_start();

include("require/header.php");

  if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == "2") {
        header("location: index.php");
    }elseif (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == "1") {
        header("location: admin/index.php");
   }


if (isset($_POST['register']) && $_POST['register']) {   
        extract($_POST);
    require("require/php_validation.php");
    if ($flag) {
         $first_name    =$first_name;
         $last_name     =$last_name;
         $email         =$email;
         $passwordb     =(sha1($password));
         $gender        =$gender;
         $date_of_birth =$date_of_birth;
         $user_image    =$_FILES['profile_pic']['name'];
         $address       =$address;

            
            $folder = "ProfilePics";
            if (!is_dir($folder) && !mkdir($folder)) {
                    echo "Could Not Create $folder";
            }

            $tmp_name = $_FILES['profile_pic']['tmp_name'];
            $file_name= $_FILES['profile_pic']['name'];
            $path     = $folder ."/". rand()."_".$file_name; 
            if(move_uploaded_file($tmp_name, $path)){   
               
            }
                
                $_SESSION['data']=[
                "first_name"  =>    $first_name,
                "last_name"   =>    $last_name,
                "email"       =>    $email,
                "password"    =>    $password,
                "date_of_birth"=>   $date_of_birth,
                "user_image"  =>    $path,
                "address"     =>    $address
                ];
        
        $query="INSERT INTO user(role_id,first_name,last_name,email,password,gender,date_of_birth,user_image,user_image_path,address) VALUES (2,'".$first_name."','".$last_name."','".$email."','".$passwordb."',
        '".$gender."','".$date_of_birth."','".$user_image."','".'../'.$path."','".$address."')";
        $result=excecute_query($query);
            if ($result) {  
                 header("location:login.php?message=Your Account successfuly created wait for admin email <a href='require/reporting.php'>Download File</a>");
            }
      
     }
 }

?>

<script type="text/javascript" src="require/validation.js"></script>
<div class="container-fluid py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6"> 
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Register</h5>
                    <p class="card-text text-center">Please Register your Account! </p>
                    <form class="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return form_validation()" >
                        <div class="form-group my-2">
                            <label class="text-muted">First Name <span style="color: red;">*</span>
                            <span id="first_name_msg" style="color: red;"><?= isset($first_name_msg)?$first_name_msg:""; ?></span> </label>
                            <input type="text" placeholder="First Name" name="first_name" id="first_name" value="<?= ($first_name)?? "" ; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Last Name <span style="color: red;">*</span>
                            <span id="last_name_msg" style="color: red;" ><?= isset($last_name_msg)?$last_name_msg:""; ?></span></label>
                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?= ($last_name)?? "" ; ?>"  class="form-control form-control-lg">                            
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Email <span style="color: red;">*</span>
                            <span id="email_msg" style="color: red;"><?= isset($email_msg)?$email_msg:""; ?></span> <span id="emailError"></span> </label>
                            <input type="email" placeholder="Email Address" name="email" id="email" value="<?= ($email)?? "" ; ?>" class="form-control form-control-lg" onblur="verify_email()" >
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Password <span style="color: red;">*</span>
                                <span id="password_msg" style="color: red;"><?= isset($password_msg)?$password_msg:""; ?></span></label>
                            <input type="password" placeholder="Password" name="password" id="password" value="<?= ($password)?? "" ; ?>" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Gender <span style="color: red;">*</span>
                                <span id="gender_msg" style="color: red;"><?= isset($gender_msg)?$gender_msg:""; ?></span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" <?= isset($gender) && $gender == "male"?  'checked' :"";?>  id="male" value="male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" <?= isset($gender) && $gender == "female"?  'checked' :"";?>  id="female" value="female">
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Date_of_birth <span style="color: red;">*</span>
                            <span id="birth_msg" style="color: red;"><?= isset($birth_msg)?$birth_msg:""; ?></span></label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="<?= ($date_of_birth)?? "" ; ?>" 
                            class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Upload profile  <span style="color: red;">*</span>
                            <span id="profile_msg" style="color: red;"><?= isset($profile_msg)?$profile_msg:""; ?></span></label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Lives in <span style="color: red;">*</span>
                            <span id="address_msg" style="color: red;"><?= isset($address_msg)?$address_msg:""; ?></span></label>
                            <input type="text" placeholder="Address" name="address" value="<?= ($address)?? "" ; ?>" id="address" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-3 d-grid">
                            <input class="btn btn-info btn-lg btn-block" id="register" type="submit" name="register" value="Register" >
                        </div>
                    </form>
                    <div class="my-3">
                        <p class="mb-2 text-center"> Already have an account? <a class="fw-bold" href="login.php">Login</a></p>
                    </div>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("require/footer.php");







?>

