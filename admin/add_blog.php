<?php include("require/header_sidebar.php");

?>

<div class="container " style="margin-left: 80px;">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">Add Blog</h5>
                    <form class="form" action="process.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group my-2">
                            <label class="text-muted">Title</label>
                            <input type="text" name="blog_title" placeholder="Enter Title" class="form-control form-control-lg" required>
                        </div>
                        <div class="form-group my-2">
                        <label class="text-muted">Post Per Page</label>
                        <input type="number" name="blog_per_page" placeholder="Enter number" class="form-control form-control-lg" required min="1">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Background Image</label>
                            <input type="file" name="blog_image" class="form-control form-control-lg" required>
                        </div>
                        <div class="my-2">
                            <select class="form-select" name="blog_status" aria-label="Select Category" required>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="add_blog" value="ADD BLOG" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                        <div class="my-2">
                        <?php if (isset($_GET['message'])){?> 
                            <div class="alert alert-info" role="alert">
                                <?= ($_GET['message']); ?>
                            </div> <?php }?>
                        </div>
                        </div>
                    </form>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>

<?php include("require/footer.php"); ?>
