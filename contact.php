<?php
include("require/header.php");
?>
	<form method="POST" action="require/ajax_process.php">
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-12 my-5">
				<h4 class="display-1 text-center fw-bold">Contact</h4>
				 <hr class="mb-12">
			</div>
			<div class="col-md-12">
				<?php
					if (isset($_GET['message'])) { ?>
						<div class="alert alert-primary" role="alert">
					<p class="text-center"> <?=	$_GET['message'];?> </p>
						</div>
			<?php }	?>	
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-8">
			<?php if (isset($_SESSION['user']) && $_SESSION['user']['is_approved'] == 'Approved' && $_SESSION['user']['is_active'] == 'Active') { 
				$user_id=$_SESSION['user']['user_id']
				?>	
				<div class="mb-3">
				  <label for="exampleFormControlTextarea1" class="form-label">Your FeedBack</label>
				  <textarea class="form-control" name="feedback"  id="exampleFormControlTextarea1" rows="3"></textarea>
				</div>
				<input type="hidden" name="user_id" value="<?=$user_id?>">
			<?php }else{ ?>	
				<div class="mb-3">
				  <label for="exampleFormControlInput1" class="form-label"> Your Email</label>
				  <input required type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
				</div>
				<div class="mb-3">
				  <label for="username" class="form-label">Your name</label>
				  <input required type="text" class="form-control" name="username" id="username" placeholder="username">
				</div>
				<div class="mb-3">
				  <label for="exampleFormControlTextarea1" class="form-label">Your FeedBack</label>
				  <textarea required class="form-control" name="feedback" id="exampleFormControlTextarea1" rows="3"></textarea>
				</div>
			<?php  } ?>
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-8 ">
				<input class="btn btn-primary" name="submit_feedback" value="Submit Feedback" type="submit"></input>
			</div>
			</form>
			<div class="col-md-2 my-5">
			</div>
		</div>
	</div>
<?php
include("require/footer.php");
?>