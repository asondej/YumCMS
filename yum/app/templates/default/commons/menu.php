
<!--========================================
=            Navigation Section            =
=========================================-->

<nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
  <div class="container-fluid p-0">
      <!-- logo -->
      <a class="navbar-brand" href="<?php echo homepage_url() ?>" id="logo">
        <img src="<?php echo template_path(); ?>images/yum-logo.svg" alt="logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fa fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">

        <li class="nav-item dropdown active dropdown-slide">
          <a class="nav-link" href="#"  data-toggle="dropdown">Meals
            <span>/</span>
          </a>
          <!-- Dropdown list -->
          <div class="dropdown-menu">
            <?php echo generate_tax_menu('meals'); ?>
          </div>
        </li>

        <li class="nav-item dropdown active dropdown-slide">
          <a class="nav-link" href="#"  data-toggle="dropdown">Diet
            <span>/</span>
          </a>
          <!-- Dropdown list -->
          <div class="dropdown-menu">
            <!-- <a class="dropdown-item" href="index.html">Vege</a>
            <a class="dropdown-item" href="homepage-two.html">Pescovege</a>
            <a class="dropdown-item" href="index.html">Meat</a> -->
            <?php echo generate_tax_menu('diets'); ?>
          </div>
        </li>
		
        <li class="nav-item dropdown active dropdown-slide">
          <a class="nav-link" href="#"  data-toggle="dropdown">Dish type
            <span>/</span>
          </a>
          <!-- Dropdown list -->
          <div class="dropdown-menu">
           <?php echo generate_tax_menu('types'); ?>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo tax_list_url('tags'); ?>">Tags
          </a>
        </li>
      </ul>
      <a href="#" class="ticket yum-add-new">
        <i class="fas fa-plus-circle"></i>
        <span>Add new</span>
      </a>
      </div>
  </div>
</nav>

<!--====  End of Navigation Section  ====-->