<?php include("require/header_sidebar.php");
require_once('../require/functions.php');


?>
<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<div class="col-lg-10" onload="show_comment()" id="show_comment" >
            <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>   
                                <th>Post</th>
                                <th>comment</th>
                                <th>comment_on</th>
                                <th>user_comment</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT post_comment.post_comment_id, user.first_name, user.last_name ,post.post_title,  post_comment.post_id , post_comment.user_id , post_comment.comment , post_comment.is_active, post_comment.created_at FROM user,blog,post,post_comment WHERE post.post_id =post_comment.post_id AND post_comment.user_id= user.user_id AND post.blog_id=blog.blog_id AND blog.user_id =  '".$_SESSION['user']['user_id']."'   "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $rows['post_title'] ?></td>  
                                <td><?= $rows['comment']?></td>
                                <td><?= $rows['created_at'] ?></td>
                                <td><?= $rows['first_name']." ".$rows['last_name']?></td>
                                <td><?= $rows['is_active']?></td>
                                <td>
                                <?php if ($rows['is_active'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_comment(<?= $rows['post_comment_id']; ?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_comment(<?= $rows['post_comment_id']; ?>)" >InActive</button></td>
                               <?php } ?>
                                
                                </tr>
                                <?php }} ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js" ></script>
 
 <script type="text/javascript">

        $(document).ready( function () {
            $('#table_id').DataTable();
        } );


        function show_comment(){
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
                        document.getElementById("show_comment").innerHTML = ajax_request.responseText;
                            $(document).ready( function () {
                                $('#table_id').DataTable();
                            } );
                     

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=show_comment");
                ajax_request.send();
        }


        function active_comment(comment_id) {

            var is_confirm = confirm("Do You want to Active this Comment");     
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
                    show_comment();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=active_comment&comment_id="+ comment_id);
            ajax_request.send();
            }
        }

        function inactive_comment(comment_id) {

            var is_confirm = confirm("Do You want to InActive this Comment");     
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
                      
                    show_comment();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=inactive_comment&comment_id="+ comment_id);
            ajax_request.send();
            }
        }

 
   </script>

<?php include("require/footer.php")?>
