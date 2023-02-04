<?php include "includes/header.php"; ?>

<div class="container pt-5">
    <?php 
    if(isset($_GET["page"]) && !empty($_GET["page"])){
        include "folders/".$_GET["page"].".php"; 
    }
    ?>
</div>

<?php include "includes/footer.php"; ?>