<?php include("require/header_sidebar.php");

?>
	<div class="container" style="margin-left: 80px;">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">Add Category</h5>
                    <form class="form" action="process.php" method="POST">
                        <div class="form-group my-2">
                            <label class="text-muted">Category Name</label>
                            <input type="text" name="catg_name" placeholder="Enter Title" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label text-muted">Description</label>
                            <textarea name="catg_description" class="form-control" id="description" rows="3" required></textarea>
                        </div>
                        <div class="my-2">
                             <label for="status" class="form-label text-muted">Status</label>
                            <select class="form-select" name="catg_status" aria-label="Select Category" required>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="add_catg" value="Add Category" class="btn btn-info btn-lg btn-block"></input>
                        </div>
                        <div class="my-2">
                        <?php if (isset($_GET['message'])){?> 
                            <div class="alert alert-info" role="alert">
                                <?= ($_GET['message']); ?>
                            </div> <?php }?>
                        </div>
                    </form>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("require/footer.php"); ?>
