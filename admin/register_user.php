<?php
include("require/header_sidebar.php");
require('../require/functions.php');


?>

<div class="container">
    <div class="row justify-content-center ">
        <div class="col-sm-12 col-md-8 col-lg-6" style="margin-left: 80px;"> 
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Register</h5>
                    <p class="card-text text-center">Please Register your Account! </p>
                    <form class="form" action="process.php" method="POST" enctype="multipart/form-data" >
                        <div class="form-group my-2">
                            <label class="text-muted">First Name <span style="color: red;">*</span></label>
                            <input required type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control form-control-lg" >
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Last Name <span style="color: red;">*</span></label>
                            <input required type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control form-control-lg">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Email <span style="color: red;">*</span> <span id="emailError"></span></label>
                            <input required type="email" name="email" id="email" placeholder="Email Address" class="form-control form-control-lg" onblur="verify_email()">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Password <span style="color: red;">*</span></label>
                            <input required type="password" name="password" id="password" placeholder="Password" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Gender <span style="color: red;">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">DATE <span style="color: red;">*</span></label>
                            <input required type="date" name="date_of_birth" id="date_of_birth" class="form-control form-control-lg"> 
                        </div>
                        <div class="my-2">
                            <label class="text-muted">SELECT USER ROLE<span style="color: red;">*</span></label>
                            <select required name="role_id"  class="form-select" aria-label="Default select example">
                                      <option value="1">ADMIN</option>
                                      <option value="2">USER</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Upload profile  <span style="color: red;">*</span></label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label class="text-muted">Lives in <span style="color: red;">*</span></label>
                            <input type="text" name="address" placeholder="Address" id="address" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="add_user" id="register" value="Register" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                    </form>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>
            <script type="text/javascript">
             function verify_email() {
            var email = document.getElementById('email').value;
            var ajax_request = null;
            if(window.XMLHttpRequest)
            {
                ajax_request = new XMLHttpRequest();
            }
            else
            {
                ajax_request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            ajax_request.onreadystatechange = function() {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    var response = ajax_request.responseText;
                    var emailError = document.getElementById('emailError');
                    var submit = document.getElementById('register');
                    if (response === 'exists') {
                        emailError.innerHTML = 'Email already exists in database';
                        emailError.style.color = 'red';
                        submit.disabled = true;
                    } else {
                        emailError.innerHTML = '';
                        submit.disabled = false;
                    }
                }
            }
            ajax_request.open('POST', 'ajax_procesess.php', true);
            ajax_request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            ajax_request.send('email=' + email);
        }
            </script>



<?php include("require/footer.php");



?>