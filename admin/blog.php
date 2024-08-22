<?php include("require/header_sidebar.php");
require('../require/functions.php'); 


?>

<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
   
 <div class="col-lg-10" onload="show_blogs()" id="show_blogs" >
            <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="add_blog.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Blog Title</th>
                                <th>Post Per Page</th>
                                <th>Author Name</th>
                                <th>Publish</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT blog.updated_at , blog.blog_title, user.user_id, blog.blog_id, user.first_name, user.last_name ,blog.post_per_page, blog.created_at , blog.blog_status FROM user,blog WHERE user.user_id = blog.user_id AND blog.user_id = '".$_SESSION['user']['user_id']."'
                                        ORDER BY blog.blog_id DESC   "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['blog_title'] ?></td>  
                                <td><?= $rows['post_per_page'] ?></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                                <td><?= $rows['created_at'] ?></td>
                                <td><?=$rows['blog_status']?></td>
                                <td>
                                <?php if ($rows['blog_status'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_blog(<?= $rows['blog_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_blog(<?= $rows['blog_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                                <td><?= $rows['updated_at']?> </td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_blog(<?= $rows['blog_id']?>)">Edit </button>
                                </td>
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                          <?php if (isset($_GET['message'])){?> 
                        <div class="alert alert-info text-center" role="alert">
                            <?= ($_GET['message']); ?>
                        </div> <?php }?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    

<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js" ></script>
 
 <script type="text/javascript">

        $(document).ready( function () {
            $('#table_id').DataTable();
        } );

        function show_blogs(){
            var ajax_request = null;
                
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
                        document.getElementById("show_blogs").innerHTML = ajax_request.responseText;
                            $(document).ready( function () {
                                $('#table_id').DataTable();
                            } );
                     

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=show_blogs");
                ajax_request.send();
        }

        function active_blog(blog_id) {

            var is_confirm = confirm("Do You want to Active this Blog");     
            if(is_confirm)
            {
            var ajax_request = null;
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
                      
                    show_blogs();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=active_blog&blog_id="+ blog_id);
            ajax_request.send();
            }
        }


          function inactive_blog(blog_id) {

            var is_confirm = confirm("Do You want to InActive this Blog");     
            if(is_confirm)
            {
            var ajax_request = null;
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

                    show_blogs();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=inactive_blog&blog_id="+ blog_id);
            ajax_request.send();
            }
        }


        function edit_blog(blog_id){
            var ajax_request = null;    
                /*alert(blog_id);*/

            var is_confirm = confirm("Do You want to Edit this Blog");     
            if(is_confirm)
            {
            var ajax_request = null;
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

                document.getElementById("show_blogs").innerHTML = ajax_request.responseText;     
                
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=edit_blog&blog_id="+ blog_id);
            ajax_request.send();
            }
        }



           
   </script>

<?php include("require/footer.php")?>
