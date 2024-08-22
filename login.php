<?php include("require/header.php");

    if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == "2") {
        header("location: index.php");
    }elseif (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == "1") {
        header("location: admin/index.php");
    }

?>

<div class="container-fluid py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6"> 
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>
                    <p class="card-text text-center">Please enter your Email and Password!</p>
                    <form class="form" action="require/login_process.php" method="POST">
                        <div class="form-group my-4">
                        	<label class="text-muted">Email </label>
                            <input type="email" placeholder="Email Address" name="email" class="form-control form-control-lg"> 
                        </div>
                        <div class="form-group">
                        	<label class="text-muted">Password</label>
                            <input type="password" placeholder="Password" name="password" class="form-control form-control-lg"> 
                        </div>

                        <div class="form-group my-3 d-grid">
                            <button type="submit" name="login" class="btn btn-info btn-lg btn-block">Login </button>
                        </div>

                        <!-- Alert -->         
                        <?php if (isset($_GET["message"])) { ?>
                         <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <span> <?php echo $_GET['message']; ?> </span> 
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>
                        <!-- Alert -->         

                    </form>
                    <div class="my-3">
                        <p class="mb-2 text-center"> Don't have an account? <a class="fw-bold" href="register.php">Sign up</a></p>
                    </div>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>

  

<?php 

include("require/footer.php");


?>