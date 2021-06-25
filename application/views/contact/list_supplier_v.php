    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c/contactsIndex') ?>"><i class="fas fa-address-book"></i> Kontak</a></li>
              <li class="breadcrumb-item active">Data Supplier</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Default box -->
        <div class="card card-info card-solid card-outline">
          <div class="card-header">
            <a class="btn btn-sm btn-info text-white font-weight-bold float-right" data-toggle="modal" data-target="#modal-tambah-supplier"> <i class="fas fa-plus"></i>&nbsp; Supplier Baru</a>
          </div>
          <div class="card-body pb-0">
            <div class="col-12 row">
              <div class="col-10 input-group input-group-sm">
                <input type="text" name="postSearch" class="form-control" onkeyup="getRowData(0)">
                <span class="input-group-append">
                  <button type="button" class="btn btn-secondary btn-flat" onclick="getRowData(0)"><i class="fas fa-search"></i></button>
                </span>
              </div>
              <div class="col-2 input-group-sm">
                <select name="postOrder" id="contact-order" class="form-control" onchange="getRowData(0)">
                  <option value="asc">Ascending</option>
                  <option value="desc">Descending</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row d-flex align-items-stretch" id="list-supp">  
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation" id="pagination">
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
            <form method="POST" action="<?php echo site_url('Supplier_c/addSupplierProses/') ?>" id="form-supplier">
              <div class="modal-body">
                
                <!-- Form-part input Supplier nama -->
                  <div class="form-group row">
                    <label for="input-supp-name" class="col-sm-4 col-form-label">Nama Supplier <font color="red">*</font><a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppNama" id="input-supp-name" placeholder="Nama Supplier" required>
                      <small id="error-supp-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier nama Kontak-->
                  <div class="form-group row">
                    <label for="input-supp-contact" class="col-sm-4 col-form-label">Nama Kontak <font color="red">*</font><a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppKontak" id="input-supp-contact" placeholder="Nama untuk kontak supplier" required>
                      <small id="error-supp-contact" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier telp -->
                  <div class="form-group row">
                    <label for="input-supp-phone" class="col-sm-4 col-form-label">No. Telp <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control float-right" name="postSuppTelp" id="input-supp-phone" placeholder="Nomor Telephone">
                      <small id="error-supp-phone" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier email -->
                  <div class="form-group row">
                    <label for="input-supp-email" class="col-sm-4 col-form-label">E-mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppEmail" id="input-supp-email" placeholder="Alamat email">
                      <small id="error-supp-email" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier alamat -->
                  <div class="form-group row">
                    <label for="input-supp-address" class="col-sm-4 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppAlamat" id="input-supp-address" placeholder="Alamat">
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
            <form method="POST" action="<?php echo site_url('Supplier_c/editSupplierProses') ?>" id="form-edit-supplier">
              <div class="modal-body">
                <input type="hidden" name="postSuppID" id="editSuppID" required readonly>
                
                <!-- Form-part input Supplier nama -->
                  <div class="form-group row">
                    <label for="editSuppNama" class="col-sm-3 col-form-label">Nama Supplier <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppNama" id="editSuppNama" placeholder="Nama Supplier" required>
                      <small id="errorSuppNama" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier nama Kontak-->
                  <div class="form-group row">
                    <label for="editSuppKontak" class="col-sm-3 col-form-label">Nama Kontak <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppKontak" id="editSuppKontak" placeholder="Nama untuk kontak supplier" required>
                      <small id="errorSuppKontak" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier telp -->
                  <div class="form-group row">
                    <label for="editSuppTelp" class="col-sm-3 col-form-label">No. Telp <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppTelp" id="editSuppTelp" placeholder="Nomor Telephone">
                      <small id="errorSuppTelp" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Supplier email -->
                  <div class="form-group row">
                    <label for="editSuppEmail" class="col-sm-3 col-form-label">E-mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSuppEmail" id="editSuppEmail" placeholder="Alamat email">
                      <small id="errorSuppEmail" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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