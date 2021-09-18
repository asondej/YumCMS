<?php 
include('commons/header.php');
include('commons/menu.php');

?>

<!--===================================
=            Error Section            =
====================================-->

<section class="section error">
	<div class="container">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div class="block text-center">
					<img src="<?php echo template_path(); ?>images/404.webp" class="img-fluid" alt="404">
					<h3>Oops!... <span>Page Not Found.</span></h3>
					<a href="<?php echo homepage_url() ?>" class="btn btn-main-md">Go to home</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Error Section  ====-->



<?php include('commons/footer.php'); ?>