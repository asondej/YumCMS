<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');
?>

<!--================================
=            CONTENT            =
=================================-->

<section class="news section recipe">
	<!-- <div class="row"> -->
		<div class="col-10 mx-auto">
			<div class="container-wide">
				<div class="row mt-30">
					<!-- main column -->
					<div class="col-xl-9 col-lg-8 col-md-7 col-sm-7 mx-auto order-1 order-sm-2">
						<div class="block">

                        <article class="blog-post single row">

                            <div class="taxonomy col-xl-7 order-sm-2 order-xs-2">
                                <div class="row icontax">
                                    <a href="<?php echo $page['taxonomy']['meal_url']; ?>" class="col-md-6 col-sm-12 col-xs-6  <?php  echo get_taxonomy_icon("meal", $page['taxonomy']['meal']) ?>">
                                    <?php echo $page['taxonomy']['meal']; ?>
                                    </a> <br/>
                                    <a href="<?php echo $page['taxonomy']['diet_url']; ?>" class="col-md-6 col-sm-12 col-xs-6   <?php  echo get_taxonomy_icon("diet", $page['taxonomy']['diet']) ?>">
                                    <?php echo $page['taxonomy']['diet']; ?>
                                    </a>
                                </div>
                                <div class="line">
                                    <h4>Tags:</h4>
                                    <?php echo get_taxonomy($page['taxonomy']['tags']); ?>
                                </div>
                                <div class="line">
                                    <h4>Type:</h4>
                                    <?php  echo get_taxonomy($page['taxonomy']['types']);?>
                                </div>                
                                <a class="print" href="<?php echo $_SERVER['REQUEST_URI']; ?>/print">Print</a>              
                            </div>

                            <div class="post-thumb col-xl-5 order-sm-1 order-xs-1" style="background:url(<?php echo $page['meta']['image']; ?>); background-size:cover">
                                <!-- <img src="<?php echo $page['meta']['image']; ?>" alt="post-image" class="img-fluid"> -->
                            </div>

                            <div class="post-content order-3">

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