<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $document_id = $_GET["id"];
    $user_id = $_SESSION["id"];

    // Include config file
    // require_once "config.php";
    
    // Define variables and initialize with empty values
    $name = "";
    $name_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate name
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $input_name)){
            $name_err = "Name can only contain letters, numbers, and underscores.";
        } else{
            $name = $input_name;
        }
        
        // Check input errors before inserting in database
        if(empty($name_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO folders (document_id, name, created_by) VALUES (?,?,?)";
    
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $document_id, $param_name, $user_id);
                
                // Set parameters
                $param_name = $name;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    $last_id = $mysqli->insert_id;

                    // Records created successfully. Redirect to landing page
                    header("location: folders.php?page=read&id=$last_id");
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
    }
}else{
    header("location: documents.php");
    exit();
}
?>

<div class="col-4 mx-auto">
    <form class="bg-white shadow-sm rounded p-3" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <h2>Create Folder</h2>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
            <span class="invalid-feedback"><?php echo $name_err;?></span>
        </div>
        <input type="submit" class="btn btn-dark" value="Submit">
        <a href="documents.php?page=read&id=<?php echo $document_id; ?>" class="btn btn-outline-dark ml-2">Cancel</a>
    </form>
</div>