  <aside class="main-sidebar sidebar-dark-orange elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link navbar-orange">
      <img src="<?php echo base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-dark">Nama APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Nama User</a>
        </div>
      </div>

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

          <!-- Menu : Pegawai -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Produk
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Product_c/addProductPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Product_c/listCatUnitPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori & Satuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Product_c/listStockProductPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stok</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Menu : Contact -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Kontak
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Supplier_c') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Customer_c') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pelanggan</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Menu : Transaksi -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('Transaction_c/listPurchasesPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trans Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Transaction_c/listSalesPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trans Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Retur_c/listReturBuyPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retur Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Retur_c/listReturSellPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retur Pelanggan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Transaksi_c/listExpensePage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran Lainnya</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Transaksi_c/listRevenuesPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pendapatan Lainnya</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Menu : Laporan -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pembelian</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Menu : Setting -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('User_c/listUserPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengaturan Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Setting_c/settingProfile') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengaturan Profil Toko</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('Setting_c/listAccountPage') ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengaturan Rekening Bank</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>