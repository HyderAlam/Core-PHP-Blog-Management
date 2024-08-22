<?php include("require/header.php");

if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];
} 


$query = "SELECT blog.blog_id, blog.post_per_page, blog.blog_title, blog.blog_image_path FROM blog WHERE blog.blog_id = '".$blog_id."' AND blog_status = 'Active'";

$blog_result = excecute_query($query);

if ($blog_result->num_rows > 0) {
    $blog = mysqli_fetch_assoc($blog_result);
    $limit = $blog['post_per_page'];
    $blog_title = $blog['blog_title'];
    $blog_image_path = $blog['blog_image_path'];
} 

$query = "SELECT COUNT(*) AS total FROM post WHERE blog_id = '".$blog_id."' AND post_status = 'Active'";

$post_result = excecute_query($query);
$total	=mysqli_fetch_assoc($post_result);
$totalrecords=$total['total'];
$totalpages = ceil($totalrecords / $limit);


if (isset($_GET['page'])) {
		$page=$_GET['page'];
	}else{
		$page=1;
	}
	$offset=($page-1)*$limit;

$query = "SELECT post.post_id, post.post_title, post.created_at, post.post_summary, post.post_image_path FROM post WHERE post.blog_id = '$blog_id'  AND post_status = 'Active' ORDER BY post.post_id DESC LIMIT $offset, $limit";

$result = excecute_query($query);

if ($result->num_rows > 0) {
?>

<div class="container-fluid " style="background-image: url('admin/<?php echo $blog_image_path; ?>'); background-repeat: no-repeat; background-size: cover; background-position: center; margin-top: 50px;">
    <div class="row mt-5">
        <h1 class="text-start text-light "><?=$blog_title?> </h1>
        <?php while($rows = mysqli_fetch_assoc($result)) { ?>
        <div class="col-sm-4">
            <div class="card mt-5" style="width: 18rem; margin-left: 50px;">
                <img width="400px" src="<?='admin/'.$rows['post_image_path']?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$rows['post_title']?></h5>
                    <p class="card-text"><?=substr($rows['post_summary'], 0, 100)?></p>
                    <p class="text-muted">Published on <?=date('d-M-Y', strtotime($rows['created_at']))?></p>
                    <a href="view.php?post_id=<?=$rows['post_id']?>" class="btn btn-dark">Read Post</a>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="col-sm-12 mt-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="view_blog.php?blog_id=<?=$blog_id?>&page=<?=($page - 1)?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="view_blog.php?blog_id=<?=$blog_id?>&page=<?=$i?>"><?=$i?></a>
                    </li>
                    <?php } ?>

                    <?php if ($page < $totalpages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="view_blog.php?blog_id=<?=$blog_id?>&page=<?=($page + 1)?>">Next</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php 
} else { 
?> 
    <h2>No Record Found....!</h2>
<?php 
}

include("require/footer.php");
?>
