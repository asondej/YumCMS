<?php 
include('commons/header.php');
include('commons/menu.php');
include('commons/main.php');

?>


<section class="section contact-form yum-form">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h3>Add new <span class="alternate">recipe</span></h3>
				</div>
			</div>
		</div>
		
		<form action="/add" class="row" method="post">

		<div class="col-md-12 success"><?php if( isset($page['url']) && !empty($page['url']) && empty($page['errors']) ) : ?><span>New recipe was successfully added. You can see it <a href="<?php echo $page['url'] ?>">here</a>.</span><?php endif; ?></div>

			<div class="col-md-6"><?php echo validationInfo($page, "title"); ?>
				<input type="text" class="form-control main <?php echo validationInfo($page, "title", "class"); ?>" name="title" id="title" placeholder="Recipe title*" value="<?php echo formAutocomplete("title"); ?>">
			</div>
			<div class="col-md-6"><?php echo validationInfo($page, "image"); ?>
				<input type="text" class="form-control main <?php echo validationInfo($page, "image", "class"); ?>" name="image" id="image" placeholder="Image url*"  value="<?php echo formAutocomplete("image"); ?>">
			</div>
            <div class="col-md-6"><?php echo validationInfo($page, "meal"); ?>
                <select name="meal" id="meal" class="form-control main <?php echo validationInfo($page, "meal", "class"); ?>" >
                    <option <?php echo selectAutocomplete("meal", ""); ?> disabled hidden>Choose meal*</option>
                    <option value="1_breakfast" <?php echo selectAutocomplete("meal", "1_breakfast"); ?> >Breakfast</option>
                    <option value="2_lunch" <?php echo selectAutocomplete("meal", "2_lunch"); ?>>Lunch</option>
                    <option value="3_dinner" <?php echo selectAutocomplete("meal", "3_dinner"); ?>>Dinner</option>
                    <option value="4_evening-snack" <?php echo selectAutocomplete("meal", "4_evening-snack"); ?>>Evening snack</option>
                    <option value="5_supper" <?php echo selectAutocomplete("meal", "5_supper"); ?>>Supper</option>
                    <option value="0_dessert" <?php echo selectAutocomplete("meal", "0_dessert"); ?>>Dessert</option>
                </select>
			</div>
			<div class="col-md-6"><?php echo validationInfo($page, "diet"); ?>
                <select name="diet" id="diet" class="form-control main <?php echo validationInfo($page, "diet", "class"); ?>">
                    <option <?php echo selectAutocomplete("diet", ""); ?> disabled hidden>Choose diet*</option>
                    <option value="with meat" <?php echo selectAutocomplete("diet", "with meat"); ?>>With meat</option>
                    <option value="vege" <?php echo selectAutocomplete("diet", "vege"); ?>>Vege</option>
                    <option value="pescovege" <?php echo selectAutocomplete("diet", "pescovege"); ?>>Pescovege</option>
                </select>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control main" name="types" id="types" placeholder="type (comma-separated)"  value="<?php echo formAutocomplete("types"); ?>">
			</div>

			<div class="col-md-6">
				<input type="text" class="form-control main" name="tags" id="tags" placeholder="Tags (comma-separated)"  value="<?php echo formAutocomplete("tags"); ?>">
			</div>
			<div class="col-md-12"><?php echo validationInfo($page,"content"); ?>
				<textarea  name="content" id="content" class="form-control main <?php echo validationInfo($page, "content", "class"); ?>" rows="19" placeholder="Recipe content*"><?php echo formAutocomplete("content"); ?></textarea>
			</div>
			<div class="col-12 text-center">
				<button type="submit" class="btn btn-main-md">create new recipe</button>
			</div>
		</form>
	</div>
</section>









<?php include('commons/footer.php'); ?>