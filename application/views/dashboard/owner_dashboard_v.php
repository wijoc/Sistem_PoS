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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $infoSales ?></h3>

                <p>Total Trans. Penjualan hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-cash-register"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="small-box-footer">Daftar Produk &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $infoPurchases ?></h3>

                <p>Total Trans. Pembelian hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-cash-register"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="small-box-footer">Daftar Produk &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $infoRevenues ?></h3>

                <p>Pendapatan (non-penjualan) hari ini</p>
              </div>
              <div class="icon">
                <i class="fa fa-donate"></i>
              </div>
              <a href="<?php echo site_url('Product_c/listCatUnitPage/') ?>" class="small-box-footer">Kategori dan Satuan &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $infoExpenses ?></h3>

                <p>Pengeluaran (non-pembelian) hari ini</p>
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

        <!-- Chart row -->
        <div class="row">
            <div class="col-lg-7" id="div-chart">
                <div class="card card-info card-outline">
                    <div class="card-header border-0">
                        <h3 class="card-title" id="chart-title">
                          <i class="fas fa-th mr-1"></i>
                          <span>Grafik Penjualan - Pembelian per Bulan</span>
                        </h3>
                        <div class="card-tools" id="nav-o-chart">
                          <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                              <a class="nav-link active" href="#snp-chart" data-name="Penjualan - Pembelian" data-toggle="tab">Jual - Beli</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#rne-chart" data-name="Revenue - Expense" data-toggle="tab">Rev - Expe</a>
                            </li>
                          </ul>
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="snp-chart" style="position: relative; height: 300px;">
                          <canvas class="chart" id="trans-chart-canvas" style="min-height: 250px; height: 350px; max-height: 500px; max-width: 100%;"></canvas>
                        </div>
                        <div class="chart tab-pane" id="rne-chart" style="position: relative; height: 300px;">
                          <canvas class="chart" id="rne-chart-canvas" style="min-height: 250px; height: 350px; max-height: 500px; max-width: 100%;"></canvas>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-5">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    5 Stok paling sedikit
                  </h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table-product" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th class="align-middle" rowspan="2">Product</th>
                          <th class="align-middle" colspan="3">Stok</th>
                          <th class="align-middle" rowspan="2">Detail</th>
                        </tr>
                        <tr>
                          <td>Bagus</td>
                          <td>Rusak</td>
                          <td>Opname</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($FEStock as $show): ?>
                          <tr>
                            <td><?php echo "<small>".$show['prd_name']."</small>" ?></td>
                            <td class="text-center"><?php echo $show['stk_good'] ?></td>
                            <td class="text-center"><?php echo $show['stk_not_good'] ?></td>
                            <td class="text-center"><?php echo $show['stk_opname'] ?></td>
                            <td class="text-center">
                              <a class="btn btn-xs btn-info" href="<?php echo site_url('Product_c/detailProductPage/').$show['prd_id'] ?>">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <tr class="text-center">
                          <th>ProduK</th>
                          <th colspan="3">Stok</th>
                          <th>Detail</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->