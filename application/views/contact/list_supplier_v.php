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
              <li class="breadcrumb-item active">Kontak Supplier</li>
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
            <h5 class="m-0 card-title">Daftar Kontak Supplier</h5>
            <a class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-tambah-supplier"> <i class="fas fa-plus"></i> Tambah kontak supplier</a>
          </div>
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              <?php foreach($dataSupplier as $showSupp) : ?>
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      <?php echo $showSupp['supp_contact_name'] ?>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?php echo $showSupp['supp_name'] ?></b></h2>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-md fa-building"></i></span> Alamat: <?php echo $showSupp['supp_address'] ?>
                            </li>
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-md fa-phone"></i></span> Phone : <?php echo $showSupp['supp_telp'] ?>
                            </li>
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-md fa-envelope-open-text"></i></span> Email : <?php echo $showSupp['supp_email'] ?>
                            </li>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img src="<?php echo base_url() ?>assets/dist/img/user1-128x128.jpg" alt="" class="img-circle img-fluid">
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
                        <a class="btn btn-sm btn-warning contactEdit" data-toggle="modal" data-target="#modal-edit-supplier" data-type="supp" data-id="<?php echo urlencode(base64_encode($showSupp['supp_id'])) ?>" data-href="<?php echo site_url('Supplier_c/getSupplier') ?>">
                          <i class="fas fa-edit"></i>
                        </a>
                        <!-- Soft Delete -->
                        <a class="btn btn-sm btn-danger" onclick="confirmDelete('soft-supp', '<?php echo urlencode(base64_encode($showSupp['supp_id'])) ?>', '<?php echo site_url('Supplier_c/deleteSupplier/soft') ?>')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
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
      <!-- Modal Tambah Supplier -->
      <div class="modal fade" id="modal-tambah-supplier">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kontak Supplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Supplier_c/addSupplierProses') ?>" id="formSupplier">
              <div class="modal-body">
                
                <!-- Form-part input Supplier nama -->
                  <div class="form-group row">
                    <label for="inputSuppNama" class="col-sm-3 col-form-label">Nama Supplier <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppNama" id="inputSuppNama" placeholder="Nama Supplier" required>
                    </div>
                  </div>

                <!-- Form-part input Supplier nama Kontak-->
                  <div class="form-group row">
                    <label for="inputSuppKontak" class="col-sm-3 col-form-label">Nama Kontak <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppKontak" id="inputSuppKontak" placeholder="Nama untuk kontak supplier" required>
                    </div>
                  </div>

                <!-- Form-part input Supplier telp -->
                  <div class="form-group row">
                    <label for="inputSuppTelp" class="col-sm-3 col-form-label">No. Telp <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppTelp" id="inputSuppTelp" placeholder="Nomor Telephone">
                    </div>
                  </div>

                <!-- Form-part input Supplier email -->
                  <div class="form-group row">
                    <label for="inputSuppEmail" class="col-sm-3 col-form-label">E-mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppEmail" id="inputSuppEmail" placeholder="Alamat email">
                    </div>
                  </div>

                <!-- Form-part input Supplier alamat -->
                  <div class="form-group row">
                    <label for="inputSuppAlamat" class="col-sm-3 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppAlamat" id="inputSuppAlamat" placeholder="Alamat">
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

      <!-- Modal Edit Supplier -->
      <div class="modal fade" id="modal-edit-supplier">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Kontak Supplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Supplier_c/editSupplierProses') ?>" id="formEditSupplier">
              <div class="modal-body">
                <input type="hidden" name="postSuppID" id="editSuppID" required readonly>
                
                <!-- Form-part input Supplier nama -->
                  <div class="form-group row">
                    <label for="editSuppNama" class="col-sm-3 col-form-label">Nama Supplier <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppNama" id="editSuppNama" placeholder="Nama Supplier" required>
                    </div>
                  </div>

                <!-- Form-part input Supplier nama Kontak-->
                  <div class="form-group row">
                    <label for="editSuppKontak" class="col-sm-3 col-form-label">Nama Kontak <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppKontak" id="editSuppKontak" placeholder="Nama untuk kontak supplier" required>
                    </div>
                  </div>

                <!-- Form-part input Supplier telp -->
                  <div class="form-group row">
                    <label for="editSuppTelp" class="col-sm-3 col-form-label">No. Telp <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppTelp" id="editSuppTelp" placeholder="Nomor Telephone">
                    </div>
                  </div>

                <!-- Form-part input Supplier email -->
                  <div class="form-group row">
                    <label for="editSuppEmail" class="col-sm-3 col-form-label">E-mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppEmail" id="editSuppEmail" placeholder="Alamat email">
                    </div>
                  </div>

                <!-- Form-part input Supplier alamat -->
                  <div class="form-group row">
                    <label for="editSuppAlamat" class="col-sm-3 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppAlamat" id="editSuppAlamat" placeholder="Alamat">
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