<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<!--================================
=            CONTENT            =
=================================-->

<section class="news section">
	<!-- <div class="row"> -->
		<div class="col-10 mx-auto">
			<div class="container-wide">
				<div class="row mt-30">
					
					<!-- main column -->
					<div class="col-xl-9 col-lg-8 col-md-7 col-sm-7 mx-auto order-2">
						<div class="block">

                        <article class="blog-post single row">
                            <div class="post-thumb col-md-6">
                                <img src="<?php echo $page['meta']['image']; ?>" alt="post-image" class="img-fluid">
                            </div>
                            <div class=" col-md-6">
                                taxonomy
                            </div>
                            <div class="post-content">

                                <!-- <div class="post-title">
                                    <h3><?php echo $page['meta']['title'];?></h3>
                                </div> -->

                                <div class="post-details">
                                    <?php
                                     //dump($page); 
                                     echo $page['content'];
                                     ?>
                                    <!-- <div class="share-block">
                                        <div class="tag">
                                            <p>
                                                Tags: 
                                            </p>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="#">Event,</a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#">Conference,</a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#">Business</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="share">
                                            <p>
                                                Share: 
                                            </p>
                                            <ul class="social-links-share list-inline">
                                            <li class="list-inline-item">
                                                <a href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><i class="fa fa-rss"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><i class="fa fa-vimeo"></i></a>
                                            </li>
                                            </ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </article>

						</div>
					</div>
                    <!-- main column end -->

                    <!-- sidebar -->
					<?php include('commons/sidebar.php'); ?>
                    <!-- sidebar end-->
				</div>
			</div>
		</div>
	<!-- </div> -->
</section>

<!--====  End of News Posts  ====-->



<?php include('commons/footer.php'); ?>