 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-orange navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link text-white font-weight-bold" data-toggle="dropdown">
          <img src="<?php echo base_url() ?>assets/dist/img/user2-160x160.jpg" style="width: 30px;" class="img-circle" alt="User Image">&nbsp;&nbsp; 
          <?php echo $this->session->userdata('logedInUser') ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?php echo site_url('Auth_c/logoutProses/') ?>" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i>
            Log Out
          </a>
        </div>
      </li>
    </ul>
  </nav>