<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<?php foreach($page['posts'] as $pos_slug=>$post_title): ?>
<a href="<?php echo ABS_PATH."recipe/$pos_slug" ?>"><?php  echo $post_title;?></a> <br/>
<?php endforeach; ?>


single tag like: types and tags

<?php include('commons/footer.php'); ?>