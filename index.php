<?php 
include "includes/header.php";
require_once "config.php";
$user_id = $_SESSION["id"];
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-4">
      <div class="h-100 bg-primary text-center text-white p-3 rounded">
        <?php
        $sql = "SELECT * FROM documents";
        if($result = $mysqli->query($sql)){
          echo '<h1>'.$result->num_rows.'</h1>';
          echo '<p class="mb-0">Total Documents</p>';
        }
        ?>
      </div>
    </div>

    <div class="col-md-4">
      <div class="h-100 bg-primary text-center text-white p-3 rounded">
        <?php
        $sql = "SELECT * FROM files WHERE created_by = $user_id AND isArchived = 0";
        if($result = $mysqli->query($sql)){
          echo '<h1>'.$result->num_rows.'</h1>';
          echo '<p class="mb-0">Total Files</p>';
        }
        ?>
      </div>
    </div>

    <div class="col-md-4">
      <div class="h-100 bg-primary text-center text-white p-3 rounded">
        <?php
        $sql = "SELECT * FROM folders WHERE created_by = $user_id";
        if($result = $mysqli->query($sql)){
          echo '<h1>'.$result->num_rows.'</h1>';
          echo '<p class="mb-0">Total Folders</p>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>