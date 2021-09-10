    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a><i class="fas fa-home"></i></a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $infoPurchases ?></h3>

                <p>Total Trans. Pembelian Anda hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-cash-register"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="small-box-footer">Daftar Produk &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $infoRevenues ?></h3>

                <p>Total Trans. Pendapatan Anda hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-donate"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listCatUnitPage/') ?>" class="small-box-footer">Kategori dan Satuan &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $infoExpenses ?></h3>

                <p>Total Trans. Pengeluaran Anda hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-hand-holding-usd"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listMutationPage/') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->