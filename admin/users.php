<?php include("require/header_sidebar.php");
require('../require/functions.php'); 
?>


<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <div class="col-lg-10" onload="show_users()" id="show_users" >
            <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
                <div>
                        <a href="register_user.php">
                            <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                        </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>
                                <th>ProfilePic</th>   
                                <th>Full_name</th>
                                <th>Email</th>
                                <th>D_O_B</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>User Role</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody >
                                    <?php $query="SELECT user.user_id, user.updated_at, user.first_name,user.last_name, user.email, user.date_of_birth,user.gender,user.address,role.role_type,user.created_at,user.is_active,user.user_image_path  FROM user,role WHERE user.role_id=role.role_id AND user.is_approved = 'Approved' AND user.user_id != '".$_SESSION['user']['user_id']."' ORDER BY user.user_id DESC"; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr align="center">
                                <td><?= $counter++ ?></td>
                                <td><img width="80px" src="<?=$rows['user_image_path']?>" alt=""></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                                <td><?= $rows['email'] ?></td>
                                <td><?=date("d-m-Y" ,strtotime($rows['date_of_birth']))?></td>
                                <td><?= $rows['gender'] ?></td>
                                <td><?= $rows['address'] ?></td>
                                <td><?= $rows['role_type'] ?></td>
                                <td><?= $rows['created_at']?></td>
                                <td><?=$rows['is_active']?></td>
                                <td>
                                <?php if ($rows['is_active'] == 'InActive') { ?>
                                <button type="button" class="btn btn-success" onclick="active_user(<?= $rows['user_id']?>)">Active</button>      
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger" onclick="inactive_user(<?= $rows['user_id'] ?>)" >InActive</button></td>
                               <?php } ?>
                               <td><?= $rows['updated_at']?></td>
                                <td>
                                <button type="button" class="btn btn-info" onclick="edit_user(<?= $rows['user_id']?>)">Edit </button>
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
    
        function show_users(){
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
                        document.getElementById("show_users").innerHTML = ajax_request.responseText;
                            $(document).ready( function () {
                                $('#table_id').DataTable();
                            } );
                     

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=show_users");
                ajax_request.send();
        }


        function active_user(user_id) {

            var is_confirm = confirm("Do You want to Active this user");     
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
                    
                    show_users();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=active&user_id="+ user_id);
            ajax_request.send();
            }
        }

        function inactive_user(user_id) {

            var is_confirm = confirm("Do You want to InActive this user");     
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
                    
                        show_users();  
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=inactive&user_id="+ user_id);
            ajax_request.send();
            }
        }


          function edit_user(user_id){
           
            var ajax_request = null;    

            var is_confirm = confirm("Do You want to Edit this User");     
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

                document.getElementById("show_users").innerHTML = ajax_request.responseText;     
                
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=edit_user&user_id="+ user_id);
            ajax_request.send();
            }
        
        }




   </script>

<?php include("require/footer.php")?>
