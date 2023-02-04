<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand" href="index.php">FMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Documents
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="documents.php?page=list">All</a></li>
                <?php
                    // Include config file
                    // require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM documents";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                          while($row = $result->fetch_array()){
                            echo '<li><a class="dropdown-item" href="documents.php?page=read&id='. $row['id'] .'">'. $row['name'] .'</a></li>';
                          }
                            // Free result set
                            $result->free();
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    // $mysqli->close();
                ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="documents.php?page=create">New Document</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sharedFiles.php?page=list">Shared Files</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="archivedFiles.php?page=list">Archived Files</a>
        </li>
      </ul>
      <p class="mb-0">Welcome <?php echo $_SESSION["username"]; ?>, </p>
      <a href="logout.php" class="btn btn-light ms-2">Logout</a>
    </div>
  </div>
</nav>