<?php include("require/header.php");

if (isset($_GET['search_term'])) {
    $search_term = $_GET['search_term'];
} 
$name = "SELECT count(post.post_id) as 'Total' FROM user, post, blog WHERE user.user_id = blog.user_id AND post.blog_id = blog.blog_id AND post.post_status= 'Active' AND blog.blog_status= 'Active' AND (user.first_name LIKE '%".$search_term."%' 
     OR user.last_name LIKE '%".$search_term."%'  
     OR post.created_at LIKE '%".$search_term."%') ";

$result1 = excecute_query($name);
$title = mysqli_fetch_assoc($result1);

$limit = 4;
$totalrecords = $title['Total'];
$totalpages = ceil($totalrecords / $limit);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;


$show = "SELECT post.post_title, user.user_image_path, post.post_summary, post.post_id, post.post_image_path, post.created_at, user.first_name, user.last_name, post.post_image_path FROM user, post, blog WHERE user.user_id = blog.user_id AND post.blog_id = blog.blog_id AND post.post_status= 'Active' AND blog.blog_status= 'Active' AND (user.first_name LIKE '%".$search_term."%' 
     OR user.last_name LIKE '%".$search_term."%'  
     OR post.created_at LIKE '%".$search_term."%') ORDER BY post.post_id DESC LIMIT $offset, $limit ";

$result = excecute_query($show);

?>

<div class="container mt-5">
    <?php if ($result->num_rows > 0) { ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 col-md-12 mt-5">
            <h3 class="category-title">Search result </h3>
            <hr>
            <div class="row">
                <?php while($rows = mysqli_fetch_assoc($result)) { ?>
                <div class="col-lg-4 col-md-6 mt-2">
                    <img src="<?='admin/'.$rows['post_image_path']?>" class="img-thumbnail" alt="img">
                </div>
                <div class="col-lg-8 col-md-6 mt-2">
                    <a href="view.php?post_id=<?=$rows['post_id']?>">
                        <p class="text-capitalize fw-bold"><?=$rows['post_title']?></p>
                    </a>
                    <p class="text-start"><?=substr($rows['post_summary'], 0, 200)?></p>
                    <p class="text-muted">Publish on <?=date("d-M-Y",strtotime($rows['created_at'])) ?></p>
                    <div class="d-flex align-items-center author">
                    <span class="m-0 p-0 " >Author : <?=$rows['first_name']." ".$rows['last_name']?> </span>
                    <img class="rounded-circle" width="40px" src="<?='ProfilePics/'.$rows['user_image_path']?>" alt="" class="img-fluid">
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="search.php?search_term=<?=$search_term?>&page=<?=($page - 1)?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="search.php?search_term=<?=$search_term?>&page=<?=$i?>"><?=$i?></a>
                    </li>
                    <?php } ?>
                    <?php if ($page < $totalpages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="search.php?search_term=<?=$search_term?>&page=<?=($page + 1)?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 col-md-12 mt-5">
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
                           <?php $query="SELECT  post.post_id, post.post_title , post.created_at , post.post_summary FROM post, blog WHERE post.blog_id=blog.blog_id AND post.post_status = 'Active' AND blog.blog_status = 'Active' ORDER BY post_id DESC limit 5 ";  
                            $recent=excecute_query($query);
                           
                            while($post=mysqli_fetch_assoc($recent)){
                           ?>                                
                    <div class="mb-3">
                        <h6><?=$post['post_title']?></h6>
                        <p class="mb-1"><?=substr($post['post_summary'], 0 ,100)?></p>
                        <p class="text-muted mb-0"><?=date("d-M-Y",strtotime($post['created_at'])) ?> </p>
                        <a href="view.php?post_id=<?=$post['post_id']?>" class="btn btn-sm btn-success">Read more</a>
                    </div>
                    <?php } ?>
                                      
                </div>
            </div>
        </div>
    </div>

   <?php }else { ?>
        <h1>No Rocord Found....!</h1>
<?php } ?>
</div>  

<?php include("require/footer.php")?>