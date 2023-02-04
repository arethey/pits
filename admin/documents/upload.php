<?php
// require_once "config.php";
$file_err = "";

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["file"]["name"];
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];
    
        // Verify file extension
        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        // $maxsize = 5 * 1024 * 1024;
        // if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        // if(in_array($filetype, $allowed)){
        //     // Check whether file exists before uploading it
        //     if(file_exists("upload/" . $filename)){
        //         echo $filename . " is already exists.";
        //     } else{
        //         move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename);
        //         echo "Your file was uploaded successfully.";
        //     } 
        // } else{
        //     echo "Error: There was a problem uploading your file. Please try again."; 
        // }
        
        // if(file_exists("upload/" . $filename)){
        //     $file_err = $filename . " is already exists.";
        // }

        if(empty($file_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO files (document_id, folder_id, file_name, file_type, file_size, created_by) VALUES (?,?,?,?,?,?)";
    
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ssssss", $document_id, $folder_id, $filename, $filetype, $filesize, $created_by);
                
                // Set parameters
                $document_id = trim($_POST["document_id"]);
                $folder_id = trim($_POST["folder_id"]);
                $created_by = trim($_POST["created_by"]);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Records created successfully. Redirect to landing page
                    if($folder_id == "0"){
                        header("location: documents.php?page=read&id=".$document_id);
                    }else{
                        header("location: folders.php?page=read&id=".$folder_id);
                    }

                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename);
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            $stmt->close();
        }

        // Close connection
        $mysqli->close();
    } else{
        $file_err = "Error: " . $_FILES["file"]["error"];
    }
}
?>

<div class="col-4 mx-auto">
    <form class="bg-white shadow-sm rounded p-3" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <div class="mb-3">
            <label for="formFile" class="form-label">Filename:</label>
            <input class="form-control <?php echo (!empty($file_err)) ? 'is-invalid' : ''; ?>" type="file" id="formFile" name="file">
            <span class="invalid-feedback"><?php echo $file_err;?></span>
            <!-- <p class="form-text mt-3"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p> -->
        </div>

        <input type="hidden" name="document_id" value="<?php echo trim($_GET["id"]); ?>"/>
        <input type="hidden" name="folder_id" value="<?php echo isset($_GET["folder_id"]) && !empty(trim($_GET["folder_id"])) ? trim($_GET["folder_id"]) : "0"; ?>"/>
        <input type="hidden" name="created_by" value="<?php echo $_SESSION["id"]; ?>"/>
        <input class="btn btn-dark" type="submit" name="submit" value="Upload">
        <a href="documents.php?page=read&id=<?php echo trim($_GET["id"]); ?>" class="btn btn-outline-dark ml-2">Cancel</a>
    </form>
</div>