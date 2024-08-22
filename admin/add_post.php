<?php 
    /*echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    die();*/
include("require/header_sidebar.php");
require('../require/functions.php');


?>

<div class="container" style="margin-left: 80px;">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">Add Post</h5>
                    <form class="form" method="POST" action="process.php" enctype="multipart/form-data">
                        <div class="form-group my-2">
                            <label class="text-muted">Title</label>
                            <input required type="text" placeholder="Enter Title" name="post_title" class="form-control form-control-lg" >
                        </div>
                        <div class="mb-2">
                            <label for="summary" class="form-label">Summary</label>
                            <textarea required class="form-control" name="summary"  id="summary" rows="3" ></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea required class="form-control" name="description" id="description" rows="3" ></textarea>
                        </div>
                        <?php $blog="SELECT * FROM blog WHERE blog.user_id = '".$_SESSION['user']['user_id']."' AND blog.blog_status= 'Active' ";   
                                $blog_result=excecute_query($blog);
                                   if ($blog_result->num_rows > 0) {                                             
                         ?>           
                        <div class="my-2">
                            <label class="text-muted">Select Blog Page</label>
                            <select required class="form-select" name="blog_id" aria-label="Select Blog Page" >
                                <?php while ($blogs=mysqli_fetch_assoc($blog_result)) { ?> 
                                   <option value="<?= $blogs['blog_id'] ?>"><?= $blogs['blog_title'] ?></option>
                               <?php } }?>
                            </select>
                            
                       
                        </div>
                        <div class="my-2">
                            <label class="text-muted">Comments status</label>
                            <select required class="form-select" name="is_comment" aria-label="Select Category" >
                                <option selected value="1">On</option>
                                <option value="2">Off</option>
                            </select>
                        </div> 
                        <div class="my-2">
                            <?php $category="SELECT * FROM Category WHERE category_status = 'Active' "; 
                                $category_result=excecute_query($category);
                                if ($category_result->num_rows > 0) {
                             ?>
                            <label class="text-muted">Select Category</label>
                            <select required class="form-select" name="category_id[]" aria-label="Select Category" multiple>
                             <?php  while ($categorys=mysqli_fetch_assoc($category_result)) { ?>
                                <option value="<?= $categorys['category_id'] ?>"><?= $categorys['category_title'] ?></option>
                           <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted">Feature Image</label>
                            <input required type="file" name="post_image" class="form-control form-control-lg">
                        </div>
                        <div class="form-group my-2">
                            <label class="text-muted"> Add attachments </label>
                            <input type="number" name="enter_fields" id="enter_fields" onblur="attachments(this)"  class="form-control form-control-lg" min="0" >
                        </div>
                        <div>
                        <div class="my-2" id="num_of_fields">

                        </div> 
                        </div>
                        <div class="my-2">
                            <label class="text-muted" >Post Status</label>
                            <select required class="form-select" name="status" aria-label="Select Category">
                                <option selected value="Active">Active</option>
                                <option value="InActive">Deactive</option>
                            </select>
                        </div>
                        <div class="form-group my-3 d-grid">
                            <input type="submit" name="add_post" value="AddPost" class="btn btn-info btn-lg btn-block"></input>
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


        <script type="text/javascript">

             function attachments(fields){

                var ajax_request = null;
                var fields = fields.value;
                // console.log(fields)
                if(window.XMLHttpRequest)
                {
                    ajax_request = new XMLHttpRequest();
                }
                else
                {
                    ajax_request = new ActiveXObject("Microsoft.XMLHTTP");
                }
                
                ajax_request.onreadystatechange = function(){
                    if(ajax_request.readyState == 4 && ajax_request.status == 200 && ajax_request.statusText == "OK")
                    {
                        document.getElementById("num_of_fields").innerHTML = ajax_request.responseText;

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=num_of_fields&fields="+fields);
                ajax_request.send();
          }   

        </script>

<?php include("require/footer.php"); ?>
