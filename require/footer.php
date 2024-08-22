<!-- footer -->
<div class="footer bg-success text-white py-5 mt-5">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-12 col-sm-12">
        <h3 class="footer-heading">About</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
        <p><a href="about.php" class="footer-link-more text-white">Learn More</a></p>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-2">
        <h3 class="footer-heading">Navigation</h3>
        <ul class="footer-links list-unstyled">
          <li><a href="index.php" class="text-white"><i class="bi bi-chevron-right"></i> Home</a></li>
          <li><a href="about.php" class="text-white"><i class="bi bi-chevron-right"></i> About</a></li>
          <li><a href="contact.php" class="text-white"><i class="bi bi-chevron-right"></i> Contact</a></li>
        </ul>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-2">
        <h3 class="footer-heading">Categories</h3>
        <?php
        $query = "SELECT category.category_id, category.category_title FROM category LIMIT 4";
        $catg = excecute_query($query);
        ?>
        <ul class="footer-links list-unstyled">
          <?php if ($catg->num_rows > 0) {
            while ($rows = mysqli_fetch_assoc($catg)) { ?>
              <li><a href="category.php?catg_id=<?= $rows['category_id'] ?>" class="text-white"><i class="bi bi-chevron-right"></i><?= $rows['category_title'] ?></a></li>
          <?php }
          } ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- footer -->
