<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Documents</li>
        </ol>
    </nav>

    <?php
        // Include config file
        // require_once "config.php";
        
        // Attempt select query execution
        $sql = "SELECT * FROM documents";
        if($result = $mysqli->query($sql)){
            if($result->num_rows > 0){
                echo '<div class="row">';
                    while($row = $result->fetch_array()){
                        // echo $row['name'];
                        // echo '<li><a class="dropdown-item" href="index.php?page=documents&id='. $row['id'] .'">'. $row['name'] .'</a></li>';
                        echo '<div class="col-md-2">';
                            echo '<div class="bg-white rounded shadow-sm py-2 text-center">';
                                echo '<a class="d-block text-dark text-decoration-none font-monospace" href="documents.php?page=read&id='. $row['id'] .'">';
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                        <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                    </svg>';
                                    echo "<h4>".$row['name']."</h4>";
                                echo '</a>';
                            echo "</div>";
                        echo '</div>';
                    }
                echo '</div>';

            
                // Free result set
                $result->free();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        // Close connection
        // $mysqli->close();
    ?>
</div>