<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<?php foreach($page['values'] as $name=>$link) : ?>
<a href="<?php echo $link; ?>"> <?php echo $name; ?> </a><br/>
<?php endforeach; ?>

all from category like: meals and diets

<?php include('commons/footer.php'); ?>


