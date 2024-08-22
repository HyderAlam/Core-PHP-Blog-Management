<?php include("require/header_sidebar.php");
require('../require/functions.php'); 

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
                                <th>user_name</th>
                                <th>user_email</th>
                                <th>Feedback</th>
                                <th>Created on</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php $query="SELECT * FROM user_feedback "; 
                                    $result=excecute_query($query);
                                    if ($result->num_rows > 0) {
                                        $counter=1;
                                        while ($rows=mysqli_fetch_assoc($result)) {    
                                    ?>
                                <tr>
                                <td><?= $counter++ ?></td>
                                <td><?=$rows['user_name'] ?></td>
                                <td><?= $rows['user_email'] ?></td>  
                                <td><?= $rows['feedback']?></td>
                                <td><?= $rows['created_at'] ?></td>
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

</script>







<?php include("require/footer.php")?>
