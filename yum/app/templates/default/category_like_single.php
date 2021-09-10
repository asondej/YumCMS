
<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<?php foreach($page['posts'] as $post_slug=>$post_details): ?>

<?php 
    
dump($post_details);
    
?>

//TODO: create html structure and use elements from $post_details
<a href="<?php //echo "http://".$_SERVER['SERVER_NAME']. "/recipe/$post_slug" ?>"><?php  //echo $post_title;?></a> <br/>


<?php endforeach; ?>

single category like: meals and diets

<?php include('commons/footer.php'); ?>
