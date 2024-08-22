<?php 
include("require/header_sidebar.php");
require('../require/functions.php'); 

?>
<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <div class="col-lg-10"   onload="show_all_users()" id="get_all_users" >   
            <h5 class="text-gray-800">Welcome : <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'] ; ?> </h5>
            <div class="card shadow" >
             <div class="card-header d-flex justify-content-between">
            <div>
                 <a href="rejected_user.php">
                    <h6 class="font-weight-bold text-primary mt-2">Show Rejected Users</h6>
                </a>
            </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table_id" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Sr# </th>
                                <th>ProfliePic</th>   
                                <th>Full_name</th>
                                <th>Email</th>
                                <th>D_O_B</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Requested on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT * FROM user WHERE user.is_approved = 'Pending' AND user.role_id = 2 ORDER BY user.user_id DESC "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                            	<tr>
                                <td><?= $counter++ ?></td>
                                <td><img width="80px" src="<?=$rows['user_image_path']?>" alt=""></td>
                                <td><?= $rows['first_name']." ".$rows['last_name'] ?></td>  
                            	<td><?= $rows['email'] ?></td>
                                <td><?= $rows['date_of_birth'] ?></td>
                                <td><?= $rows['gender'] ?></td>
                                <td><?= $rows['address'] ?></td>
                                <td><?= $rows['created_at'] ?></td>
                                <td><button type="button" class="btn btn-success" onclick="accept_req(<?= $rows['user_id']?>)">Accept</button>  <button type="button" class="btn btn-danger" onclick="reject_req(<?= $rows['user_id'] ?>)" >Reject</button></td>
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
 

        function show_all_users(){
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
                        document.getElementById("get_all_users").innerHTML = ajax_request.responseText;
                            $(document).ready( function () {
                                $('#table_id').DataTable();
                            } );
                     

                    }
                }
                
                ajax_request.open("GET", "ajax_procesess.php?action=show_req");
                ajax_request.send();
        }

        function accept_req(user_id) {

            var is_confirm = confirm("Do You want to accept request");     
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
                        
                    show_all_users();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=accept_req&user_id="+ user_id);
            ajax_request.send();
            }
        }

         function reject_req(user_id) {

            var is_confirm = confirm("Do You want to Reject request");     
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
                    show_all_users();
                }
            }
            ajax_request.open("GET", "ajax_procesess.php?action=reject_req&user_id="+ user_id);
            ajax_request.send();
            }
        }
        
        
</script>


<?php include("require/footer.php")?>
