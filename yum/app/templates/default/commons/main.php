
<!--================================
=            Page Title            =
=================================-->

<section class="page-title bg-title overlay-dark <?php if(isset($page['taxonomy'])): ?>recipe-bg<?php endif; ?>" style="<?php if(isset($page['type']) && $page['type'] === 'page' ): ?>background-image: url(<?php echo $page['meta']['image']; ?>);<?php endif; ?>"">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="title">
					<h3><?php echo $page['meta']['title'] ?></h3>
				</div>

			</div>
		</div>
	</div>
</section>

<!--====  End of Page Title  ====-->