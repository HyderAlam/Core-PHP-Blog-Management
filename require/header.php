<?php session_start();
require_once("require/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog_Management_System</title>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <style type="text/css">
    .navbar-nav .nav-link {
      transition: background-color 0.3s;
      border-radius: 10px;
    }

    .navbar-nav .nav-link:hover {
      background-color: #61d6fa;
      color: #fff; 
    }

    a {
      text-decoration: none;
      color: black;
    }

    body {
      font-family: 'PT Serif', serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }


    .content {
      flex: 1;
    }

    .footer {
      background-color: #198754;
      color: white;
      padding: 20px;
      width: 100%;
    }

    .footer .footer-heading {
      font-size: 1.2rem;
      margin-bottom: 15px;
    }

    .footer .footer-links {
      list-style: none;
      padding: 0;
    }

    .footer .footer-links li {
      margin-bottom: 10px;
    }

    .footer .footer-links a {
      color: white;
      text-decoration: none;
    }

    .footer .footer-links a:hover {
      text-decoration: underline;
    }



  </style>
   
  

</head>
<body>
  

<!-- Navbar -->
<nav id="nav" class="navbar fixed-top navbar-expand-lg bg-body-tertiary bg-success navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="index.php">BLOGs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="background-color: #ffffff;"></span> 
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="text-light  nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light"  href="blog.php">Blogs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light"  href="about.php">About</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <?php $query="SELECT category.category_id, category.category_title FROM category LIMIT 4" ;
                $catg=excecute_query($query);
                if ($catg->num_rows > 0) {
           ?>
          <ul class="dropdown-menu">
            <?php while ($rows=mysqli_fetch_assoc($catg)) {
             ?>
            <li><a class="dropdown-item" href="category.php?catg_id=<?=$rows['category_id']?>"><?=$rows['category_title']?></a></li>
             <?php }?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="all_category.php">All Categories</a></li>
         
          </ul>
        <?php } ?>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_approved']=='Approved' && $_SESSION['user']['is_active']=='Active') {
           $user_id = $_SESSION['user']['user_id'] ;
          ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="edit_profile.php?user_id=<?=$user_id?>">Update profile</a>
        </li>
         <li class="nav-item">
          <a class="nav-link text-light" href="logout.php">Logout</a>
        </li>
        <?php
        }else{ 
        ?>
        <li class="nav-item">
          <a class="nav-link text-light" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="register.php">Register</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

