<?php 
require_once('require/functions.php'); 

$query = "SELECT * FROM post WHERE post_status = 'Active' ORDER BY post_id DESC ";
$result = excecute_query($query);
?>

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php if ($result->num_rows > 0) { 
           $first = mysqli_fetch_assoc($result);
      ?>
      
    <div class="carousel-item active">
      <img height="700px"  src="<?= 'admin/'.$first['post_image_path'] ?>" class="d-block w-100" alt="...">
    </div>
        <?php while($rows = mysqli_fetch_assoc($result)) { ?>
    <div class="carousel-item">
      <img height="700px" src="<?= 'admin/'.$rows['post_image_path'] ?>" class="d-block w-100" alt="...">
    </div>
    <?php } }?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
