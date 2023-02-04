<?php include "includes/header.php"; ?>

<?php 
    if(isset($_GET["page"]) && !empty($_GET["page"])){
        include "documents/".$_GET["page"].".php"; 
    }
?>

<?php include "includes/footer.php"; ?>