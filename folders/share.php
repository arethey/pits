<?php
 require_once "config.php";

if(isset($_POST["users"]) && !empty($_POST["users"])){
    // Get hidden input value
    $file_id = $_POST["file_id"];
    $shared_by = $_POST["shared_by"];
    $document_id = $_POST["document_id"];
    $users= $_POST['users'];
    
    for($i=0; $i < count($users); $i++)
    {   
        $user = $users[$i];

        $sql = "SELECT id FROM sharedFiles WHERE file_id = ? AND shared_to = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ss", $file_id, $user);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $shared_err = "This file is already shared.";
                } else{
                    $shared_err = "";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }

        if(empty($shared_err)){
            $sql = "INSERT INTO sharedFiles (file_id, shared_by, shared_to) VALUES (?,?,?)";
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sss", $file_id, $shared_by, $user);
                if($stmt->execute()){
                    echo "Shared successfully.";
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            $stmt->close();
        }
    }

    header("location: documents.php?page=read&id=".$document_id);
    exit();
    
    $mysqli->close();
}else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $id =  trim($_GET["id"]);
        $user_id = $_SESSION["id"];

        // Prepare a select statement
        $sql = "SELECT * FROM files WHERE id = ?";

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
                    $file_name = $row["file_name"];
                    $document_id = $row["document_id"];
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
}
?>

<div class="col-4 mx-auto">
    <form class="bg-white shadow-sm rounded p-3" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <h2 class="mb-4">Share File</h2>

        <?php
            $sql = "SELECT * FROM users";
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_array()){
                        if($row['id'] != $user_id){
                            echo '<div class="mb-3">
                                <input type="checkbox" class="btn-check" id="'.$row['id'].'" autocomplete="off" name="users[]" value="'.$row['id'].'">
                                <label class="btn btn-outline-primary w-100 rounded-0" for="'.$row['id'].'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                                '.$row['username'].'</label><br>
                            </div>';
                        }
                    }
                    // Free result set
                    $result->free();
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
         ?>

        <input type="hidden" name="file_id" value="<?php echo trim($_GET["id"]); ?>">
        <input type="hidden" name="shared_by" value="<?php echo $user_id; ?>">
        <input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
        
        <input type="submit" class="btn btn-dark" value="Share">
        <a href="documents.php?page=read&id=<?php echo $document_id; ?>" class="btn btn-outline-dark ml-2">Cancel</a>
    </form>
</div>