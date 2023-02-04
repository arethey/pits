<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id =  trim($_POST["id"]);
    $document_id =  trim($_POST["document_id"]);
    // Include config file
    // require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $id);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            header("location: users.php?page=list");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: users.php?page=list");
        exit();
    }
}
?>

<div class="col-4 mx-auto">
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <div class="alert alert-danger">
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
            <input type="hidden" name="document_id" value="<?php echo trim($_GET["document_id"]); ?>"/>
            <p>Are you sure you want to delete this user?</p>
            <p>
                <input type="submit" value="Yes" class="btn btn-danger">
                <a href="users.php?page=list" class="btn btn-outline-dark ml-2">No</a>
            </p>
        </div>
    </form>
</div>