    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Pelanggan</h1>
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
        <div class="card card-info card-solid card-outline">
          <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE ){ ?>
          <div class="card-header">
            <div class="btn-group float-right" role="group" aria-label="Basic example">
              <a class="btn btn-sm btn-info text-white" data-toggle="modal" data-placement="top" title="Tambah Customer" data-target="#modal-add-customer"> 
                <i class="fas fa-plus"></i>
              </a>
            </div>
          </div>
          <?php } ?>
          <div class="card-body pb-0">
            <div class="col-12 row">
              <div class="col-10 input-group input-group-sm">
                <input type="text" name="postSearch" class="form-control" onkeyup="getRowData(0)">
                <span class="input-group-append">
                  <button type="button" class="btn btn-secondary btn-flat" onclick="getRowData(0)"><i class="fas fa-search"></i></button>
                </span>
              </div>
              <div class="col-2 input-group-sm">
                <select name="postOrder" id="contactOrder" class="form-control" onchange="getRowData(0)">
                  <option value="asc">Ascending</option>
                  <option value="desc">Descending</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row d-flex align-items-stretch" id="list-ctm">  
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

    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE ){ ?>
    <!-- Modal -->
      <!-- Modal Tambah Pelanggan -->
      <div class="modal fade" id="modal-add-customer">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('Customer_c/addCustomerProses') ?>" id="form-add-customer">
              <div class="modal-body">
                
                <!-- Form-part input Pelanggan nama -->
                  <div class="form-group row">
                    <label for="input-ctm-name" class="col-sm-3 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmName" id="input-ctm-name" placeholder="Nama Pelanggan" required>
                      <small id="error-ctm-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Telp -->
                  <div class="form-group row">
                    <label for="input-ctm-phone" class="col-sm-3 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmPhone" id="input-ctm-phone" placeholder="Nomor telepone pelanggan">
                      <small id="error-ctm-phone" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Email -->
                  <div class="form-group row">
                    <label for="input-ctm-email" class="col-sm-3 col-form-label">E - mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control float-right" name="postCtmEmail" id="input-ctm-email" placeholder="Alamat E - mail">
                      <small id="errorCtmEmail" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Alamat -->
                  <div class="form-group row">
                    <label for="input-ctm-address" class="col-sm-3 col-form-label">Alamat Pengiriman <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="postCtmAddress" id="input-ctm-address" rows="3"></textarea>
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
      <div class="modal fade" id="modal-edit-customer">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('Customer_c/editCustomerProses') ?>" id="form-edit-customer">
              <div class="modal-body">
                <input type="hidden" name="postCtmID" id="edit-ctm-ID" required readonly>
                
                <!-- Form-part input Pelanggan nama -->
                  <div class="form-group row">
                    <label for="edit-ctm-name" class="col-sm-3 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmName" id="edit-ctm-name" placeholder="Nama Pelanggan" required>
                      <small id="error-ctm-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Telp -->
                  <div class="form-group row">
                    <label for="edit-ctm-phone" class="col-sm-3 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtmPhone" id="edit-ctm-phone" placeholder="Nomor telepone pelanggan">
                      <small id="error-ctm-phone" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Email -->
                  <div class="form-group row">
                    <label for="edit-ctm-email" class="col-sm-3 col-form-label">E - mail <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control float-right" name="postCtmEmail" id="edit-ctm-email" placeholder="Alamat E - mail">
                      <small id="error-ctm-email" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Pelanggan Alamat -->
                  <div class="form-group row">
                    <label for="edit-ctm-address" class="col-sm-3 col-form-label">Alamat <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <textarea class="form-control" name="postCtmAddress" id="edit-ctm-address" rows="3"></textarea>
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
    <?php } ?>