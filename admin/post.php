<?php include("require/header_sidebar.php");
require('../require/functions.php'); 

?>

<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

  
 <div class="col-lg-10" onload="show_posts()" id="show_posts" >
       
         <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="add_post.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" style="height: auto;" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Post Title</th>
                                <th>Blog</th>
                                <th>Publish On</th>
                                <th>Status</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody >
                                   <?php  $query="SELECT post.updated_at ,post.post_id, post.created_at, post.post_title,blog.blog_title, post.post_status, post.is_comment_allowed
                                        FROM blog, post
                                        WHERE post.blog_id = blog.blog_id
                                        AND blog.user_id = '".$_SESSION['user']['user_id']."' ORDER BY post.post_id DESC";

                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['post_title'] ?></td>  
                                <td><?= $rows['blog_title'] ?></td> 
                                <td><?= date('Y-m-d', strtotime( $rows['created_at']))?></td>
                                <td><?=$rows['is_comment_allowed'] == 1 ? 'ON' : 'OFF'  ?></td>
                                <td>
                                <?php if ($rows['is_comment_allowed'] == 0 ) { ?>
                                <button type="button" class="btn btn-success" onclick="active_comment(<?= $rows['post_id']; ?>)">On</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_comment(<?= $rows['post_id']; ?>)" >Off</button></td>
                               <?php } ?>
                               <td><?=$rows['post_status']?></td>
                                <td>
                                <?php if ($rows['post_status'] == 'InActive' ) { ?>
                                <button type="button" class="btn btn-success" onclick="active_post(<?= $rows['post_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_post(<?= $rows['post_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                               <td><?= $rows['updated_at'] ?></td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_post(<?= $rows['post_id']?>)">Edit </button>
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
        
         function show_posts(){
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
                        document.getElementById("show_posts").innerHTML = ajax_request.responseText;
                            $(document).ready( function () {
                                $('#table_id').DataTable();
                            } );
                     

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=show_posts");
                ajax_request.send();
        }


         function active_comment(post_id) {

            var is_confirm = confirm("Do You want to allow comment on post");     
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
                    show_posts();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=allow_comment&post_id="+ post_id);
            ajax_request.send();
            }
        }


        function inactive_comment(post_id) {

            var is_confirm = confirm("Do You want to deactive comment on post");     
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
 
                    show_posts();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=deactive_comment&post_id="+ post_id);
            ajax_request.send();
            }
        }

         function active_post(post_id) {

            var is_confirm = confirm("Do You want to active this post");     
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
                    
                    show_posts();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=active_post&post_id="+ post_id);
            ajax_request.send();
            }
        }


        function inactive_post(post_id) {

            var is_confirm = confirm("Do You want to deactive this post");     
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
                    show_posts();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=inactive_post&post_id="+ post_id);
            ajax_request.send();
            }
        }




        function edit_post(post_id){
           
            var ajax_request = null;    

            var is_confirm = confirm("Do You want to Edit this Post");     
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

                document.getElementById("show_posts").innerHTML = ajax_request.responseText;     
                
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=edit_post&post_id="+ post_id);
            ajax_request.send();
            }
        
        }



   </script>

<?php include("require/footer.php")?>
