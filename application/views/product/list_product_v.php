    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Barang_c') ?>"><i class="fas fa-cubes"></i> Barang</a></li>
              <li class="breadcrumb-item active">Daftar Barang</li>
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
                <h5 class="m-0 card-title">Daftar Barang</h5>
                <a class="btn btn-sm btn-success float-right" href=""> <i class="fas fa-plus"></i> Tambah Barang</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-barang" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Nama Barang</th>
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
                            <td><?php echo $showPrd['prd_nama'] ?></td>
                            <td><?php echo $showPrd['ktgr_nama'] ?></td>
                            <td><?php echo $showPrd['prd_harga_beli'] ?></td>
                            <td><?php echo $showPrd['prd_harga_jual'] ?></td>
                            <td><?php echo $showPrd['satuan_nama'] ?></td>
                            <td>0</td>
                            <td>
                              <a class="btn btn-xs btn-info" href=""><i class="fas fa-search"></i></a>
                              <a class="btn btn-xs btn-warning" href="<?php echo site_url('Product_c/editProductPage').'/'.urlencode(base64_encode($showPrd['prd_id'])) ?>"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-xs btn-danger" href=""><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Nama Barang</th>
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