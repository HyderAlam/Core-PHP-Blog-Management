<!-- header -->
<?php include("require/header.php");
require_once ('require/functions.php'); 


include('require/slider.php');


?>





<?php $total="SELECT count(post.post_id) AS 'total' FROM post,blog WHERE post.blog_id=blog.blog_id AND post.post_status ='Active' AND blog.blog_status = 'Active' ";
    $result1=excecute_query($total);
        //_____________________________ 
        $limit=4;
        $total_post=mysqli_fetch_assoc($result1);
        $totalrecords  = $total_post['total'];
        $totalpages = ceil($totalrecords / $limit);
        //_____________________________ 
   if (isset($_GET['page'])) {
    $page = $_GET['page'];
        } else {
            $page = 1;
        }
    $offset = ($page - 1) * $limit;     


?>

<div class="container mt-5">
    <!-- Alert -->         
  <?php if (isset($_GET["message"])) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span> <?php echo $_GET['message']; ?> </span> 
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
 <?php } ?>
     <!-- Alert -->   
    
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-success">ALL POSTS</h2>
            <hr class="mb-4">
           <?php $query= "SELECT  post.post_id, post.post_image_path, post.post_title , blog.blog_title, post.created_at , post.post_summary FROM 21442_hyder_alam.post_category
    INNER JOIN 21442_hyder_alam.category 
        ON (post_category.category_id = category.category_id)
    INNER JOIN 21442_hyder_alam.post 
        ON (post_category.post_id = post.post_id)
    INNER JOIN 21442_hyder_alam.blog 
        ON (post.blog_id = blog.blog_id)
    INNER JOIN 21442_hyder_alam.user 
        ON (blog.user_id = user.user_id) WHERE post.post_status= 'Active' AND blog.blog_status = 'Active' AND category.category_status = 'Active'
GROUP BY post.post_id ORDER BY post.post_id DESC LIMIT $offset, $limit";  


                   $result =excecute_query($query);     
                   if ($result->num_rows > 0) {
                      
                   
           ?>
            <!--  post cards -->
            <div class="row">
                <?php  while($rows=mysqli_fetch_assoc($result)){ ?>


                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col-auto">
                            <img style="width: 400px ;" src="<?='admin/'.$rows['post_image_path']?>" alt="Image" class="img-fluid">
                        </div>
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-success"><?=$rows['blog_title']?></strong>
                            <h3 class="mb-0"><?=substr($rows['post_title'],0,100)?></h3>
                            <div class="mb-1 text-muted"><?=date('d-M-Y', strtotime($rows['created_at'])) ?></div>
                            <p class="mb-auto"><?=substr($rows['post_summary'], 0, 150)?></p>
                            <a href="view.php?post_id=<?=$rows['post_id']?>" class="stretched-link">Continue reading</a>
                        </div>
                    </div>
                </div>

                <?php }?>
                
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?page=<?=($page - 1)?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?page=<?=$i?>"><?=$i?></a>
                    </li>
                    <?php } ?>
                    <?php if ($page < $totalpages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?page=<?=($page + 1)?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>

            </div>
        </div>

        <?php }?>
        <!-- Sidebar -->
        <div class="col-md-4 mt-5">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Search form -->
                    <form action="require/ajax_process.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="search_result" class="form-control" placeholder="Search...">
                        </div>
                        <input type="submit" value="Search" name="search" class="btn btn-success"></input>
                    </form>
                </div>
            </div>
            <!-- Recent Posts -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Posts</h5>
                    <?php $recent = "SELECT  post.post_id, post.post_title , post.created_at , post.post_summary FROM 21442_hyder_alam.post_category
                 INNER JOIN 21442_hyder_alam.category 
                ON (post_category.category_id = category.category_id)
                    INNER JOIN 21442_hyder_alam.post 
                ON (post_category.post_id = post.post_id)
                    INNER JOIN 21442_hyder_alam.blog 
                ON (post.blog_id = blog.blog_id)
                    INNER JOIN 21442_hyder_alam.user 
                ON (blog.user_id = user.user_id) WHERE post.post_status= 'Active' AND blog.blog_status = 'Active' AND category.category_status = 'Active'
                GROUP BY post.post_id ORDER BY post.post_id DESC LIMIT 5";
                    $result=excecute_query($recent);
                    if ($result->num_rows > 0) {
                         while($post=mysqli_fetch_assoc($result)){
                        ?>    
                        <div class="mb-3">
                        <h6><a href="view.php?post_id=<?=$post['post_id']?>" class="text-success"><?=$post['post_title']?></a></h6>
                        <p class="text-muted mb-0"><?=date('d-M-Y', strtotime($post['created_at'])) ?></p>
                        <p class="mb-1"><?=substr( $post['post_summary'], 0,100 )?></p>
                        <a href="view.php?post_id=<?=$post['post_id']?>" class="btn btn-sm btn-success">Read more</a>
                        </div>
                      <?php }} ?>
                  
                  
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>


<!-- main -->

<!-- footer -->
<?php include("require/footer.php")?>