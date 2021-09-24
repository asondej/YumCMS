<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
//dump($page);
?>

<!--================================
=            CONTENT            =
=================================-->

<section class="news section">
	<!-- <div class="row"> -->
		<div class="col-10 mx-auto">
			<div class="container-wide">
				<div class="row mt-30">
					<!-- sidebar -->
					<?php include('commons/sidebar.php'); ?>
					<!-- main column -->
					<div class="col-xl-9 col-lg-8 col-md-7 col-sm-7 mx-auto order-1 order-sm-2">
						<div class="block">
							<div class="row equal-parent row-eq-height">
								<?php foreach($page['recipes'] as $title=>$recipe) : ?>
								<div class="col-xl-4 col-lg-6 col-md-12 col-12 equal-item">
									<div class="blog-post h-100 ">
										<div class="post-thumb">
											<a href="<?php echo $recipe['url'];?>">
												<img src="<?php echo $recipe['details']['meta']['image']; ?>" alt="post-image" class="img-fluid">
											</a>
										</div>
										<div class="post-content">
											<div class="date yum-diet <?php echo get_taxonomy_icon('diets', $recipe['details']['taxonomy']['diet']); ?>">
											</div>
											<div class="date yum-meal <?php echo get_taxonomy_icon('meals', $recipe['details']['taxonomy']['meal']); ?>"><span>
												<?php echo $recipe['details']['taxonomy']['meal'];?></span></div>
											<div class="post-title">
												<h2><a href="<?php echo $recipe['url'];?>"><?php echo $recipe['details']['meta']['title']; ?></a></h2>
											</div>
											<div class="post-meta">
												<ul class="list-inline">
													<li class="list-inline-item">
														Type:
														<?php echo get_taxonomy($recipe['details']['taxonomy']['types'],'type');?>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
									<!-- Pagination -->
									<div class="container">
										<?php echo $page['pagination']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- </div> -->
</section>

<!--====  End of News Posts  ====-->



<?php include('commons/footer.php'); ?>