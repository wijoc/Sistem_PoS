    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Daftar Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Daftar Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-info card-outline">
              <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?>
              <div class="card-header">
                <h5 class="m-0 card-title"><?php echo (!empty($dataCtgr))? 'Produk dalam kategori <b class="text-uppercase">"'.$dataCtgr[0]['ctgr_name'].'"</b>' : '' ?></h5>
                <div class="float-right" role="group" aria-label="Basic example">
                  <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Tambah produk" href="<?php echo site_url('Product_c/addProductPage') ?>"> 
                    <i class="fas fa-plus"></i>
                  </a>
                  <a class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Stok produk" href="<?php echo site_url('Product_c/stockProductPage') ?>"> 
                    <i class="fas fa-cubes"></i>
                  </a>
                </div>
              </div>
              <?php } ?>

              <div class="card-body">
                <table id="table-product" class="table table-bordered table-striped">
                  <thead>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP']) == TRUE ){ ?> <th>Harga Beli</th> <?php } ?>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE ){ ?> <th>Harga Jual</th> <?php } ?>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP']) == TRUE ){ ?> <th>Harga Beli</th> <?php } ?>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE ){ ?> <th>Harga Jual</th> <?php } ?>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->