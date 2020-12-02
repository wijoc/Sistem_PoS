    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kontak</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c/contactsIndex') ?>"><i class="fas fa-address-book"></i> Kontak</a></li>
              <li class="breadcrumb-item active">Kontak Pelanggan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Default box -->
        <div class="card card-orange card-solid card-outline">
          <div class="card-header">
            <h5 class="m-0 card-title">Daftar Kontak Pelanggan</h5>
            <a class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-tambah-pelanggan"> <i class="fas fa-plus"></i> Tambah member</a>
          </div>
          <div class="card-body pb-0">
            <?php if(empty($dataCtm)){ ?>
              <div class="alert alert-danger text-center" style="opacity: 0.8; font-weight: bold;" role="alert">Data Pelanggan belum tersedia !</div>
            <?php } else { ?>
              <div class="row d-flex align-items-stretch">
                  <?php foreach($dataCtm as $showCtm) : ?>
                  <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                    <div class="card bg-light">
                      <div class="card-header text-muted border-bottom-0">
                      </div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-12">
                            <h5 class="lead"><b><?php echo $showCtm['ctm_name'] ?></b></h5>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small">
                                <span class="fa-li"><i class="fas fa-md fa-phone"></i></span> <?php echo ($showCtm['ctm_phone'] != '')? $showCtm['ctm_phone'] : '-' ?>
                              </li>
                            </ul>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small">
                                <span class="fa-li"><i class="fas fa-md fa-envelope"></i></span> <?php echo ($showCtm['ctm_email'] != '')? $showCtm['ctm_email'] : '-' ?>
                              </li>
                            </ul>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small">
                                <span class="fa-li"><i class="fas fa-md fa-map"></i></span> <?php echo ($showCtm['ctm_address'] != '')? $showCtm['ctm_address'] : '-' ?>
                              </li>
                            </ul>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                              <li class="small">
                                <span class="fa-li"><i class="fas fa-md fa-tag"></i></span> Diskon : <?php echo ($showCtm['ctm_discount_type'] == 'ptg')? 'Rp. '.number_format($showCtm['ctm_discount_price']) : $showCtm['ctm_discount_percent'].' %' ?>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="text-right">
                          <a href="" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync"></i>&nbsp; Lihat Transaksi
                          </a>
                          <a href="#" class="btn btn-sm bg-teal">
                            <i class="fas fa-search"></i>
                          </a>
                          <a class="btn btn-sm btn-warning contactEdit" data-toggle="modal" data-target="#modal-edit-pelanggan" data-type="ctm" data-id="<?php echo urlencode(base64_encode($showCtm['ctm_id'])) ?>" data-href="<?php echo site_url('Customer_c/getCustomer') ?>">
                            <i class="fas fa-edit"></i>
                          </a>
                          <!-- Soft Delete -->
                          <a class="btn btn-sm btn-danger" onclick="confirmDelete('soft-ctm', '<?php echo urlencode(base64_encode($showCtm['ctm_id'])) ?>', '<?php echo site_url('Customer_c/deleteCustomer/soft') ?>')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php } ?>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
              <?php echo $this->pagination->create_links(); ?>
            </nav>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>

    </section>
    <!-- /.content -->

    <!-- Modal -->
      <!-- Modal Tambah Pelanggan -->
      <div class="modal fade" id="modal-tambah-pelanggan">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Customer_c/addCustomerProses') ?>" id="formAddPelanggan">
              <div class="modal-body">
                
                <!-- Form-part input Pelanggan nama -->
                  <div class="form-group row">
                    <label for="inputCtmNama" class="col-sm-3 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmNama" id="inputCtmNama" placeholder="Nama Pelanggan" required>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Telp -->
                  <div class="form-group row">
                    <label for="inputCtmTelp" class="col-sm-3 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmTelp" id="inputCtmTelp" placeholder="Nomor telepone pelanggan">
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Email -->
                  <div class="form-group row">
                    <label for="inputCtmEmail" class="col-sm-3 col-form-label">E - mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control float-right" name="postCtmEmail" id="inputCtmEmail" placeholder="Alamat E - mail">
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Alamat -->
                  <div class="form-group row">
                    <label for="inputCtmEmail" class="col-sm-3 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="postCtmAddress" rows="3"></textarea>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Discount -->
                  <div class="form-group row">
                    <label for="inputCtmDiscount" class="col-sm-3 col-form-label">Diskon <a class="float-right"> : </a></label>
                    <div class="col-sm-3">
                      <select class="form-control float-right disc-type" name="postCtmDiscountType" id="inputCtmDiscountType">
                        <option value="prc">Persen</option>
                        <option value="ptg">Potongan Harga</option>
                      </select>
                    </div>
                    <div class="col-sm-5">
                      <input type="number" class="form-control float-right disc" name="postCtmDiscount" id="inputCtmDiscount" step="0.01" max="100" placeholder="Besar diskon">
                      <small><font color="red" style="font-style: italic">kosongkan jika tidak ada diskon</font></small>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Modal Edit Pelanggan -->
      <div class="modal fade" id="modal-edit-pelanggan">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Customer_c/editCustomerProses') ?>" id="formEditCustomer">
              <div class="modal-body">
                <input type="hidden" name="postCtmID" id="editCtmID" required readonly>
                
                <!-- Form-part input Pelanggan nama -->
                  <div class="form-group row">
                    <label for="editCtmNama" class="col-sm-3 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmNama" id="editCtmNama" placeholder="Nama Pelanggan" required>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Telp -->
                  <div class="form-group row">
                    <label for="editCtmTelp" class="col-sm-3 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmTelp" id="editCtmTelp" placeholder="Nomor telepone pelanggan">
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Email -->
                  <div class="form-group row">
                    <label for="editCtmEmail" class="col-sm-3 col-form-label">E - mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control float-right" name="postCtmEmail" id="editCtmEmail" placeholder="Alamat E - mail">
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Alamat -->
                  <div class="form-group row">
                    <label for="editCtmEmail" class="col-sm-3 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="postCtmAddress" id="editCtmAddress" rows="3"></textarea>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Discount -->
                  <div class="form-group row">
                    <label for="inputCtmDiscount" class="col-sm-3 col-form-label">Diskon <a class="float-right"> : </a></label>
                    <div class="col-sm-3">
                      <select class="form-control float-right disc-type" name="postCtmDiscountType" id="editCtmDiscountType">
                        <option value="prc">Persen</option>
                        <option value="ptg">Potongan Harga</option>
                      </select>
                    </div>
                    <div class="col-sm-5">
                      <input type="number" class="form-control float-right disc" name="postCtmDiscount" id="editCtmDiscount" step="0.01" placeholder="Besar diskon">
                      <small><font color="red" style="font-style: italic">kosongkan jika tidak ada diskon</font></small>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>