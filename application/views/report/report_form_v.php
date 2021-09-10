    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Laporan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active">Laporan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card card-info card-outline">
            <form action="">
                <div class="card-body">
                    <section>
                        <div class="row">
                            <h5 class="col-md-3 col-sm-12 border border-solid text-uppercase">Jenis Laporan</h5>
                            <hr class="col">
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputRpType">Periode</label>
                                    <select class="form-control" name="postRpType" id="inputRpType">
                                        <option value="RD">Laporan Harian</option>
                                        <option value="RD">Laporan Mingguan</option>
                                        <option value="RD">Laporan Bulanan</option>
                                        <option value="RD">Laporan Triwulan</option>
                                        <option value="RD">Laporan Caturwulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Rentang Waktu </label>
                                    <div class="input-group sm-3">
                                        <input type="date" class="form-control" name="" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-minus"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="" required="required">                                        
                                    </div>
                                    <small class="font-italic" style="color:red">* kosongkan kolom kanan untuk bayar 1 periode</small>
                                    <small id="error-is-periode" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                    <small id="error-is-periodeb" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </section>
                    <section>
                        <div class="row">
                            <h5 class="col-md-3 col-sm-12 border border-solid text-uppercase">Isi Laporan</h5>
                            <hr class="col">
                        </div>
                        <div class="row">
                          <div class="col-md-4 col-sm-6">
                            <!-- Penjualan / Sales -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRS">
                                <label for="inputRS">Laporan Penjualan</label>
                              </div>
                            </div>

                            <!-- Pembelian / Purchases -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRP">
                                <label for="inputRP">Laporan Pembelian</label>
                              </div>
                            </div>

                            <!-- Pemasukan / Revenues -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRR">
                                <label for="inputRR">Laporan Pemasukan Lainnya</label>
                              </div>
                            </div>

                            <!-- Pengeluaran / Expenses -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRE">
                                <label for="inputRE">Laporan Pengeluaran Lainnya</label>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-6">
                            <!-- Barang / Product -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRPrd">
                                <label for="inputRPrd">Laporan Produk</label>
                              </div>
                            </div>

                            <!-- per Supplier -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRSupp">
                                <label for="inputRSupp">Laporan Transaksi per Supplier</label>
                              </div>
                            </div>

                            <!-- per Customer -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputRCtm">
                                <label for="inputRCtm">Laporan Transaksi per Perlanggan</label>
                              </div>
                            </div>
                          </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->