    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Produk</h1>
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
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title">Daftar Produk</h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Product_c/addProductPage') ?>"> <i class="fas fa-plus"></i> Tambah Produk</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-barang" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                        <?php $no = 1; foreach ($dataProduct as $showPrd) : ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $showPrd['prd_name'] ?></td>
                            <td><?php echo $showPrd['ctgr_name'] ?></td>
                            <td><?php echo $showPrd['prd_purchase_price'] ?></td>
                            <td><?php echo $showPrd['prd_selling_price'] ?></td>
                            <td><?php echo $showPrd['unit_name'] ?></td>
                            <td>0</td>
                            <td>
                              <a class="btn btn-xs btn-warning" href="<?php echo site_url('Product_c/editProductPage').'/'.urlencode(base64_encode($showPrd['prd_id'])) ?>"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-xs btn-danger" onclick="confirmDelete('prd', '<?php echo urlencode(base64_encode($showPrd['prd_id'])) ?>', '<?php echo site_url('Product_c/deleteProductProses') ?>')"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Stok</th>
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