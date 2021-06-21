    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Stok Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Stok Produk</li>
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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <a class="btn btn-sm btn-info float-right text-white" href="<?php echo site_url('Product_c/addProductPage') ?>"> <i class="fas fa-plus"></i> Tambah Produk</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-stock-product" class="table table-bordered table-striped">
                      <thead>
                      	<tr class="text-center">
	                        <th rowspan="2" class=" align-middle">Barcode</th>
	                        <th rowspan="2" class=" align-middle">Nama Produk</th>
	                        <th colspan="2">Stock Bagus</th>
	                        <th colspan="2">Stock Rusak</th>
	                        <th colspan="2">Stock Opname</th>
	                        <th rowspan="2" class=" align-middle">Aksi</th>
                      	</tr>
                      	<tr class="text-center">
	                        <td>Awal</td>
	                        <td>Sekarang</td>
	                        <td>Awal</td>
	                        <td>Sekarang</td>
	                        <td>Awal</td>
	                        <td>Sekarang</td>
                    	</tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot class="text-center">
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th colspan="2">Good</th>
                        <th colspan="2">Damaged</th>
                        <th colspan="2">Opname</th>
                        <th>Aksi</th>
                      </tfoot>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->