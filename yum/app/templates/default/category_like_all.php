<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>



<section class="news section">
	<!-- <div class="row"> -->
		<div class="col-10 mx-auto">
			<div class="container-wide">
				<div class="row">
					<!-- main column -->
					<div class="col-md-12 mx-auto">
							<div class="row">


                            <?php foreach($page['values'] as $name=>$link) : ?>
                            <a class="taglike_single col-md-3" href="<?php echo $link; ?>"><span> <?php echo $name; ?> </span></a>
                            <?php endforeach; ?>
                        </div>
					</div>
				</div>
			</div>
		</div>

</section>

<?php include('commons/footer.php'); ?>