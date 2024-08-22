<?php include("require/header_sidebar.php");
require('../require/functions.php'); 

?>
      
        <div class="col-lg-10">
             <!-- Alert -->         
              <?php if (isset($_GET["message"])) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span> <?php echo $_GET['message']; ?> </span> 
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
             <?php } ?>
     <!-- Alert --> 
            <h5 class="text-gray-800 fw-bold ">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"/>
              </svg>DashBoard</h3>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <?php $query="SELECT count(*) AS 'user_count' FROM user WHERE user.is_approved = 'Approved' AND role_id = 2 " ;
                             $result =excecute_query($query);
                          if ($result->num_rows > 0) { 
                                $count_user=mysqli_fetch_assoc($result);  ?>          
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text fw-bold"><?= $count_user['user_count'] ?>  </p>
                        <a href="users.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                    <?php }?>
                  </div>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <?php $query1= "SELECT count(post.post_id) AS 'total_post' , count(blog.blog_id) AS 'total_blog'  FROM post,blog,user WHERE post.blog_id =blog.blog_id AND user.user_id = blog.user_id AND user.user_id = '".$_SESSION['user']['user_id']."' " ; 
                              $result =excecute_query($query1);
                              if ($result->num_rows > 0) {
                                $count=mysqli_fetch_assoc($result);
                              
                        ?>
                        <h5 class="card-title">Total Post</h5>
                        <p class="card-text fw-bold"><?= $count['total_post'] ?></p>
                        <a href="post.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
                  <?php  } ?>

                  <?php 
                    $blog="SELECT count(blog.blog_id) AS 'Total_blog' FROM blog,user WHERE blog.user_id=user.user_id AND blog.user_id = 
                    '".$_SESSION['user']['user_id']."' ";
                             $blog_result =excecute_query($blog);
                          if ($blog_result->num_rows > 0) {
                            $blogs_total=mysqli_fetch_assoc($blog_result);       
                  ?>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Total Blogs</h5>
                        <p class="card-text fw-bold"><?= $blogs_total['Total_blog'] ?></p>
                        <a href="blog.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
                  
                  <?php }?>
                  <?php  
                  
                    $query2= "SELECT count(*) AS 'request' FROM user WHERE user.is_approved = 'Pending'  ";
                         $result =excecute_query($query2);
                          if ($result->num_rows > 0) {
                          $request=mysqli_fetch_assoc($result); ?>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Pending Request</h5>
                        <p class="card-text fw-bold"><?= $request['request'] ?></p>
                        <a href="request.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                </div>

                <?php  $query3 = "SELECT count(*) AS 'category' FROM category" ; 
                      $result =excecute_query($query3);
                      if ($result->num_rows > 0) {
                      $catg=mysqli_fetch_assoc($result);
                ?>
                <div class="row mt-5">
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text fw-bold"><?= $catg['category'] ?></p>
                        <a href="category.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  <?php } ?>
                  </div>
                  <?php $query4 = "SELECT count(*) AS 'feedback' FROM user_feedback " ;  
                      $result =excecute_query($query4);
                      if ($result->num_rows > 0) {
                      $fback=mysqli_fetch_assoc($result);

                  ?>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Total Feedback</h5>
                        <p class="card-text fw-bold"><?= $fback['feedback'] ?></p>
                        <a href="feedback.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
                <?php } 
                      $query5= "SELECT count(post_comment.post_comment_id) AS 'comments' FROM user,blog,post,post_comment WHERE  blog.blog_id =post.blog_id AND post_comment.post_id =post.post_id AND  
                      blog.user_id = user.user_id AND blog.user_id = '".$_SESSION['user']['user_id']."' ";
                      $result =excecute_query($query5);
                      if ($result->num_rows > 0) {
                      $comm=mysqli_fetch_assoc($result);
                ?>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title"> Total Post Comments</h5>
                        <p class="card-text fw-bold"><?= $comm['comments']?></p>
                        <a href="comment.php" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
                <?php } 
                    $query6="SELECT count(following_blog.follow_id) AS 'followers' FROM following_blog,user,blog WHERE following_blog.blog_following_id=blog.blog_id AND blog.user_id =user.user_id AND blog.user_id = '".$_SESSION['user']['user_id']."' AND following_blog.status = 'Followed'  ";
                    $result =excecute_query($query6);
                    if ($result->num_rows > 0) {
                    $folw=mysqli_fetch_assoc($result);
                ?>
                  <div class="col-sm-3">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Blog Page Followers</h5>
                        <p class="card-text fw-bold"><?= $folw['followers'] ?></p>
                        <a href="#" class="btn btn-dark text-light">View All</a>
                      </div>
                    </div>
                  </div>
              </div>
            <?php }?>
            </div>
        </div>
<?php include("require/footer.php")?>
