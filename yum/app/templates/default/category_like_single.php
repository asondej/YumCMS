
<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<?php foreach($page['posts'] as $post_slug=>$post_title): ?>
<a href="<?php echo "http://".$_SERVER['SERVER_NAME']. "/recipe/$post_slug" ?>"><?php  echo $post_title;?></a> <br/>
<?php endforeach; ?>

single category like: meals and diets

<?php include('commons/footer.php'); ?>
