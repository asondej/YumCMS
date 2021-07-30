
<!--========================================
=            Navigation Section            =
=========================================-->

<nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
  <div class="container-fluid p-0">
      <!-- logo -->
      <a class="navbar-brand" href="<?php echo ABS_PATH; ?>" id="logo">
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
            <a class="dropdown-item" href="index.html">Breakfast</a>
            <a class="dropdown-item" href="homepage-two.html">Lunch</a>
            <a class="dropdown-item" href="index.html">Dinner</a>
            <a class="dropdown-item" href="homepage-two.html">Evening snack</a>
            <a class="dropdown-item" href="index.html">Supper</a>
            <a class="dropdown-item" href="homepage-two.html">Dessert</a>
          </div>
        </li>

        <li class="nav-item dropdown active dropdown-slide">
          <a class="nav-link" href="#"  data-toggle="dropdown">Diet
            <span>/</span>
          </a>
          <!-- Dropdown list -->
          <div class="dropdown-menu">
            <a class="dropdown-item" href="index.html">Vege</a>
            <a class="dropdown-item" href="homepage-two.html">Pescovege</a>
            <a class="dropdown-item" href="index.html">Meat</a>
          </div>
        </li>
		
        <li class="nav-item dropdown active dropdown-slide">
          <a class="nav-link" href="#"  data-toggle="dropdown">Dish type
            <span>/</span>
          </a>
          <!-- Dropdown list -->
          <div class="dropdown-menu">
            <a class="dropdown-item" href="index.html">eintopf</a>
            <a class="dropdown-item" href="homepage-two.html">soup</a>
            <a class="dropdown-item" href="index.html">pasta</a>
            <a class="dropdown-item" href="index.html">lorem</a>
            <a class="dropdown-item" href="homepage-two.html">ipsum</a>
            <a class="dropdown-item" href="index.html">dolor</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="speakers.html">Tags
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