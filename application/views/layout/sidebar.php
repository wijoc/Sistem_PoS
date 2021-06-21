  <aside class="main-sidebar sidebar-dark-orange elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link navbar-orange">
      <img src="<?php echo base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-dark">Nama APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <!-- Menu : Dashboard -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">Master Data</li>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG', 'uK', 'uP'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="nav-link">
              <i class="fas fa-circle fa-cubes nav-icon"></i>
              <p>Produk</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Product_c/stockProductPage') ?>" class="nav-link">
              <i class="fas fa-boxes nav-icon"></i>
              <p>Stok Produk</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Product_c/listCatUnitPage') ?>" class="nav-link">
              <i class="fas fa-box nav-icon"></i>
              <p>Kategori & Satuan</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Supplier_c') ?>" class="nav-link">
              <i class="fas fa-truck-moving nav-icon"></i>
              <p>Supplier</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Customer_c') ?>" class="nav-link">
              <i class="fas fa-user nav-icon"></i>
              <p>Pelanggan</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK', 'uP'])){ ?>
          <li class="nav-header">Transaksi</li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listPurchasesPage') ?>" class="nav-link">
              <i class="fas fa-dolly-flatbed nav-icon"></i>
              <p>Trans. Pembelian</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listSalesPage') ?>" class="nav-link">
              <i class="fas fa-cash-register nav-icon"></i>
              <p>Trans. Penjualan</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP', 'uK'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listExpensesPage') ?>" class="nav-link">
              <i class="fas fa-hand-holding-usd nav-icon"></i>
              <p>Pengeluaran Lainnya</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listRevenuesPage') ?>" class="nav-link">
              <i class="fas fa-donate nav-icon"></i>
              <p>Pendapatan Lainnya</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listRSPage') ?>" class="nav-link">
              <i class="fas fa-exchange-alt nav-icon"></i>
              <p>Retur Pembelian</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Transaction_c/listRCPage') ?>" class="nav-link">
              <i class="fas fa-sync-alt nav-icon"></i>
              <p>Retur Pelanggan</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG'])){ ?>
          <li class="nav-header">Laporan</li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Report_c') ?>" class="nav-link">
              <i class="fas fa-file-signature nav-icon"></i>
              <p>Laporan</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uG'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Report_c') ?>" class="nav-link">
              <i class="fas fa-file-signature nav-icon"></i>
              <p>Laporan Stok Produk</p>
            </a>
          </li>
          <?php } ?>
          
          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO'])){ ?>
          <li class="nav-header">Pengaturan</li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('Setting_c/listAccountPage') ?>" class="nav-link">
              <i class="fas fa-university nav-icon"></i>
              <p>Pengaturan Rekening Bank</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('Setting_c/settingProfile') ?>" class="nav-link">
              <i class="fas fa-cogs nav-icon"></i>
              <p>Pengaturan Profil Toko</p>
            </a>
          </li>
          <?php } ?>

          <?php if(in_array($this->session->userdata('logedInLevel'), ['uAll'])){ ?>
          <li class="nav-item">
            <a href="<?php echo site_url('User_c/listUserPage') ?>" class="nav-link">
              <i class="fas fa-users-cog nav-icon"></i>
              <p>Pengaturan Pengguna</p>
            </a>
          </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>