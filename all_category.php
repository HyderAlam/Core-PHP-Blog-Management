<?php include("require/header.php");

$query = "SELECT * FROM category WHERE category_status = 'Active' ";
$result = excecute_query($query);
?>
 <div class="container" style="margin-top: 100px">   
    <div class="row">

    <?php 
    $counter= 0;
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <a href="category.php?catg_id=<?=$row['category_id']?>"><h5 class="card-title">(<?= ++$counter?>) <?=($row['category_title']); ?></h5></a>
                    <p class="card-text"><?= ($row['category_description']); ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>




<?php include("require/footer.php");?>