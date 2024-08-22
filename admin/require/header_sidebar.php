<?php
session_start();
if (isset($_SESSION['user'])) {
if(!($_SESSION['user']['role_id'] == 1)){
    header("location:../logout.php");
    }
    }else if (!(isset($_SESSION['user']))) {
    header("location:../logout.php");
    }

$user_id=$_SESSION['user']['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 30px 0; 
            width: 220px;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        body {
          font-family: 'PT Serif', serif;
        }

        .sidebar .nav-link {
            padding: 10px 15px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1); 
        }

        .sidebar .active {
            background-color: rgba(255, 255, 255, 0.2); 
        }

        .sidebar-heading {
            padding: 10px 15px;
            font-size: 18px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.9); 
        }

       
        
        .nav-item:hover{
            
            background-color: rgba(255, 255, 255, 0.1); 

        }
        
    </style>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ml-auto"> 
                    <li class="nav-item">
                        <a class="nav-link" href="edit_profile.php?user_id=<?=$user_id?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row mt-4">
        <div class="col-lg-2">
            <div class="sidebar bg-success">
                <h6 class="sidebar-heading">Menu</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Categories</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="post.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="request.php">User Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback.php">View Feedback</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="comment.php">View Comments</a>
                    </li>
                </ul>
            </div>
        </div>

