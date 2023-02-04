<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // require_once "config.php";

    $id =  trim($_GET["id"]);
    $user_id = $_SESSION["id"];
    
    // Prepare a select statement
    $sql = "SELECT * FROM documents WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $id);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $document_name = $row["name"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: documents.php?page=list");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    $stmt->close();
    
    // Close connection
    // $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: documents.php?page=list");
    exit();
}
?>

<div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="documents.php?page=list">Documents</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $document_name; ?></li>
            </ol>
        </nav>
        <div>
            <a href="documents.php?page=update&id=<?php echo $id ?>" class="btn btn-outline-dark btn-sm">Rename</a>
            <a href="documents.php?page=delete&id=<?php echo $id ?>" class="btn btn-danger btn-sm">Delete</a>
            <!-- <a href="documents.php?page=upload&id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Upload Files</a>
            <a href="folders.php?page=create&id=<?php echo $id ?>" class="btn btn-dark btn-sm">Create Folder</a> -->
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Size (kb)</th>
            <th scope="col">Total Share</th>
            <th scope="col">File Uploader</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT *, folders.id AS folder_id FROM folders INNER JOIN users ON folders.created_by = users.id WHERE document_id = $id";
                if($result = $mysqli->query($sql)){
                    if($result->num_rows > 0){
                        while($row = $result->fetch_array()){
                            echo '<tr>';
                                echo '<td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder me-2" viewBox="0 0 16 16">
                                <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                              </svg>' . $row['name'] . '</td>';
                                echo "<td>File Folder</td>";
                                echo "<td>-</td>";
                                echo "<td>-</td>";
                                echo '<td>'. $row['fullname'] .'</td>';
                                echo "<td>";
                                    echo '<a href="folders.php?page=read&id='. $row['folder_id'] .'">view</a>';
                                echo "</td>";
                            echo '</tr>';
                        }
                        // Free result set
                        $result->free();
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            ?>

            <?php
                $sql2 = "SELECT *, files.id AS file_id FROM files INNER JOIN users ON files.created_by = users.id WHERE document_id = $id  AND folder_id = 0 AND isArchived = 0";
                if($result2 = $mysqli->query($sql2)){
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_array()){
                            $total = 0;
                            $fileid = $row2['file_id'];
                            $shared_sql = "SELECT * FROM sharedfiles WHERE file_id = $fileid";
                            if($shared_result = $mysqli->query($shared_sql)){
                                $total = $shared_result->num_rows;
                            }

                            echo "<tr>";
                                echo '<td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark me-2" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                              </svg>' . $row2['file_name'] . '</td>';
                                echo "<td>" . $row2['file_type'] . "</td>";
                                echo "<td>" . ($row2['file_size'] * 0.001) . "</td>";
                                echo "<td>" . $total . "</td>";
                                echo "<td>" . $row2['fullname'] . "</td>";
                                echo "<td>";
                                    // echo '<a href="documents.php?page=share&id='.$row2['id'].'" class="me-3" title="Share" data-toggle="tooltip">
                                    //     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                    //     <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                                    //     </svg>
                                    // </a>';
                                    echo '<a href="download.php?file='.urlencode($row2['file_name']).'" class="me-3" title="Download" data-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                    </a>';
                                    // echo '<a href="archivedFiles.php?page=archived&isArchived=1&id='. $row2['id'] .'&document_id='.$id.'" class="me-3" title="Archive" data-toggle="tooltip">
                                    //     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                    //     <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    //     </svg>
                                    // </a>';
                                echo "</td>";
                            echo "</tr>";
                        }
                    // Free result set
                    $result2->free();
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            ?>
        </tbody>
    </table>
</div>