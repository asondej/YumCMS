<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<p><?php echo $page['content']?></p>
<p><?php echo $page['taxonomy']['meals']?></p>
<p><?php echo $page['taxonomy']['diets']?></p>

<?php include('commons/footer.php'); ?>