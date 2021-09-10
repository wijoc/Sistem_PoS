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

                <p>Product</p>
              </div>
              <div class="icon">
                <i class="fa fa-cubes"></i>
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

                <p>Kategori</p>
              </div>
              <div class="icon">
                <i class="fa fa-box"></i>
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

                <p>Mutasi Stok</p>
              </div>
              <div class="icon">
                <i class="fa fa-boxes"></i>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Product per Kategori
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 425px;">
                  <canvas id="category-chart-canvas" height="425" style="height: 425px;"></canvas>                         
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>

          <!-- Right coloumn -->
          <section class="col-lg-6">
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
          </section>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <?php print("<pre>".print_r($infoPrd, true)."</pre>") ?>