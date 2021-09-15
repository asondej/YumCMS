
<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');

//dump($post_details);
?>

<section class="news section">
	<!-- <div class="row"> -->
		<div class="col-10 mx-auto">
			<div class="container-wide">
				<div class="row">
					<!-- main column -->
					<div class="col-md-12 mx-auto">
							<div class="row equal-parent row-eq-height">


                            <?php foreach($page['posts'] as $post_slug=>$post_details): 
                            $title = $post_details['title'];
                            $slug = $post_slug;
                            $image = $post_details['image'];
                            $meal = $post_details['meal'];
                            $diet = $post_details['diet'];
                            $types = $post_details['types'];
                            $tags = $post_details['tags'];
                            //dump($image);
                            ?>

								<div class="col-xl-4 col-lg-6 col-md-6 col-12 equal-item">
									<div class="blog-post h-100 ">
										<div class="post-thumb">
											<a href="<?php echo "http://".$_SERVER['SERVER_NAME']. "/recipe/$post_slug" ?>">
												<img src="<?php echo $image; ?>" alt="post-image" class="img-fluid">
											</a>
										</div>
										<div class="post-content">
											<div class="date yum-diet <?php echo get_taxonomy_icon('diets', $diet); ?>">
											</div>
											<div class="date yum-meal <?php echo get_taxonomy_icon('meals', $meal); ?>"><span><?php echo $meal; ?></span></div>
											<div class="post-title">
												<h2><a href="<?php echo "http://".$_SERVER['SERVER_NAME']. "/recipe/$post_slug" ?>"><?php echo $title; ?></a></h2>
											</div>
											<div class="post-meta">
												<ul class="list-inline">
													<li class="list-inline-item">
														Type: 
                                                        <?php echo get_taxonomy($types,'type');?>
													</li>
													<li class="">
														Tags: 
                                                        <?php echo get_taxonomy($tags,'tag');?>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>


                            <?php endforeach; ?>

                            </div>
					</div>
				</div>
			</div>
		</div>

</section>


<?php include('commons/footer.php'); ?>
