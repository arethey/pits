<?php
// Initialize the session
ob_start();
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$page = isset($_GET["page"]) && !empty($_GET["page"]) ? $_GET["page"] : "FMS";

require_once "config.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  
    <style>
      .nav-link:hover{
        background-color: #f8f9fa;
      }
    </style>
  </head>
  <body class="bg-light">

  <div class="d-flex w-100 min-vh-100">
    <div class="col-2 border-end bg-white">
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-android" viewBox="0 0 16 16">
          <path d="M2.76 3.061a.5.5 0 0 1 .679.2l1.283 2.352A8.94 8.94 0 0 1 8 5a8.94 8.94 0 0 1 3.278.613l1.283-2.352a.5.5 0 1 1 .878.478l-1.252 2.295C14.475 7.266 16 9.477 16 12H0c0-2.523 1.525-4.734 3.813-5.966L2.56 3.74a.5.5 0 0 1 .2-.678ZM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
        </svg>
      </div>

      <?php include 'links.php' ?>
    </div>

    <div class="flex-grow-1">
      <nav class="navbar bg-white border-bottom">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1">File Management System</span>

          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Welcome <?php echo $_SESSION["username"]; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              <li><a class="dropdown-item" href="users.php?page=reset">Reset password</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="container py-5">
        
