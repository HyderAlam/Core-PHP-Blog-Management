<?php 
include("require/header_sidebar.php");
require('../require/functions.php'); 

?>
<script type="text/javascript" src="jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <div class="col-md-10">
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
                                <th>ProfilePic</th>   
                                <th>Full_name</th>
                                <th>Email</th>
                                <th>D_O_B</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Requested on</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT * FROM user WHERE user.is_approved = 'Rejected' AND user.role_id = 2 ORDER BY user.user_id DESC "; 
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
                                <td><?= $rows['is_approved'] ?></td>
                            	<?php }} ?> 
                            </tbody>
                        </table>

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
 
        
</script>


<?php include("require/footer.php")?>
