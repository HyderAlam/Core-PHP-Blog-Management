<?php include("require/header.php");

if (isset($_GET['catg_id'])) {
    $catg_id = $_GET['catg_id'];
} 
$name = "SELECT count(post.post_id) as 'Total', category.category_title FROM post, category, post_category WHERE category.category_id =post_category.category_id AND  post_category.post_id = post.post_id AND category.category_id = '".$catg_id."' AND category.category_status = 'Active' AND post.post_status = 'Active'";

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


$show = "SELECT category.category_title, post.post_image_path, post.post_id, post.created_at, user.first_name, user.last_name, post.post_title, post.post_summary, user.user_image_path FROM user, blog,post_category,category,post WHERE blog.user_id = user.user_id AND post.blog_id = blog.blog_id AND post_category.post_id = post.post_id AND post_category.category_id = category.category_id  AND blog.blog_status = 'Active' AND category.category_status = 'Active' AND post.post_status = 'Active' AND category.category_id = '".$catg_id."' ORDER BY post.post_id DESC LIMIT $offset, $limit ";

$result = excecute_query($show);

?>

<div class="container mt-5">
    <?php if ($result->num_rows > 0) { ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 col-md-12 mt-5">
            <h3 class="category-title">Category: <?= $title['category_title']?> </h3>
            <hr>
            <div class="row">
                <?php while($rows = mysqli_fetch_assoc($result)) { ?>
                <div class="col-lg-4 col-md-6 mt-2">
                    <img src="<?='admin/'.$rows['post_image_path']?>" class="img-thumbnail" alt="img">
                </div>
                <div class="col-lg-8 col-md-6 mt-2">
                    <p class="text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                            <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
                            <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>
                        </svg> <?=$rows['category_title']?>
                    </p>
                    <a href="view.php?post_id=<?=$rows['post_id']?>">
                        <p class="text-capitalize fw-bold"><?=$rows['post_title']?></p>
                    </a>
                    <p class="text-start"><?=substr($rows['post_summary'], 0, 200)?></p>
                    <p class="text-muted">Publish on <?=date("d-M-Y",strtotime($rows['created_at'])) ?></p>
                    <div class="d-flex align-items-center author">
                    <span class="m-0 p-0">Author : <?=$rows['first_name']." ".$rows['last_name']?></span>
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
                        <a class="page-link" href="category.php?catg_id=<?=$catg_id?>&page=<?=($page - 1)?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="category.php?catg_id=<?=$catg_id?>&page=<?=$i?>"><?=$i?></a>
                    </li>
                    <?php } ?>
                    <?php if ($page < $totalpages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="category.php?catg_id=<?=$catg_id?>&page=<?=($page + 1)?>">Next</a>
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
                    <h5 class="card-title">Category Recent Posts</h5>
                           <?php $cat="SELECT category.category_title, post.post_image_path, post.post_id, user.first_name, user.last_name, post.post_title, post.created_at, post.post_summary, user.user_image_path FROM user, blog,post_category,category,post WHERE blog.user_id = user.user_id AND post.blog_id = blog.blog_id AND post_category.post_id = post.post_id AND post_category.category_id = category.category_id AND blog.blog_status = 'Active' AND category.category_status = 'Active' AND post.post_status = 'Active' AND category.category_id = '".$catg_id."' ORDER BY post.post_id DESC LIMIT 5 ";  
                            $recent=excecute_query($cat);
                           
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