<?php
require_once "config.php";
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];
    $isArchived = $_GET["isArchived"];
    $redirect = "archivedFiles.php?page=list";

    if(isset($_GET["document_id"]) && !empty($_GET["document_id"])){
        $redirect = "documents.php?page=read&id=".$_GET["document_id"];
    }
    
    $sql = "UPDATE files SET isArchived=? WHERE id=?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("si", $isArchived, $id);
        if($stmt->execute()){
            header("location: $redirect");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    $stmt->close();
    $mysqli->close();
}
?>