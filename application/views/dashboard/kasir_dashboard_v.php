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
                <h3><?php echo $infoPrd ?></h3>

                <p>Penjualan Anda hari ini</p>
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
                <h3><?php echo $infoCtgr ?></h3>

                <p>Pendapatan lainnya hari ini</p>
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
                <h3><?php echo $infoMutasi ?></h3>

                <p>Pengeluaran lainnya hari ini</p>
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
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- /.card -->
          </section>

          <!-- Right coloumn -->
          <section class="col-lg-6">
          </section>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <?php print("<pre>".print_r($infoPrd, true)."</pre>") ?>