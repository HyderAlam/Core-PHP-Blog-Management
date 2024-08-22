<?php include("require/header.php"); 
$query= "SELECT * FROM blog WHERE blog.blog_status = 'Active' " ;
		$result=excecute_query($query);

?>
	
	

<div class="container mt-5">	
	 	<div class="row ">
	 		<div class="col-sm-12 mt-5">
	 		


	 			<?php if (isset($_GET['message'])) { ?>
  	
					<div class="alert alert-success alert-dismissible fade show" role="alert">
				  	<strong><?= htmlspecialchars($_GET['message'])?></strong>
				  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php } ?>
	 		


	 				<h2 class="display-6">All Blogs Pages</h2>
	 				<hr class="col-sm-12" >
		 		</div>
			 			<?php if ($result->num_rows > 0) {
			 				while($rows=mysqli_fetch_assoc($result)){
			 			 ?>
			 			<div class="col-md-4 mt-5 ml-5">
					    <div class="card">
					      <img width="500px" height="400px" src="<?='admin/'.$rows['blog_image_path']?>" class="card-img-top" alt="Blog image">
					      <div class="card-body">
					        <a href="view_blog.php?blog_id=<?=$rows['blog_id']?>"><h3 class="card-title"><?=$rows['blog_title']?></h3></a>
					       	<?php if (isset($_SESSION['user']) && $_SESSION['user']['is_approved'] == 'Approved' && $_SESSION['user']['is_active'] == 'Active') {
                            $follow =  "SELECT * FROM following_blog WHERE follower_id='" . $_SESSION['user']['user_id'] . "' AND blog_following_id = '" . $rows['blog_id'] . "'";
                            	$user_id=$_SESSION['user']['user_id'];
                            $follow_result = excecute_query($follow);
                                $status = mysqli_fetch_assoc($follow_result);      
                            if ($status && $status['status'] == 'Followed') { ?>
                                <a href="require/ajax_process.php?action=unflw&blog_id=<?=$rows['blog_id']?>&user_id=<?=$user_id?>"><button type="button" class="btn btn-danger">Unfollow</button></a>
                            <?php
                            } elseif ($status && $status['status'] == 'Unfollowed') {
                                ?>
                                <a href="require/ajax_process.php?action=flw&blog_id=<?=$rows['blog_id']?>&user_id=<?=$user_id?>"><button type="button" class="btn btn-success">Follow</button></a>
                            <?php
                        } else {
                                ?>
                                <a href="require/ajax_process.php?action=newflw&&blog_id=<?=$rows['blog_id']?>&user_id=<?=$user_id?>"><button type="button" class="btn btn-success">Follow</button></a>
                      <?php  }}  ?>    
					      </div>
					    </div> 
					  </div>
			 	<?php }

			 			} else{	?>
	 				<h2>No Record Found....!</h2>
	 			<?php	} ?>
	 		</div>
	 	</div>
	 



<?php include("require/footer.php")?>
