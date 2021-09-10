    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Daftar Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Setting_c') ?>"><i class="fas fa-cogs"></i> Pengaturan</a></li>
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
                <div class="float-right" role="group" aria-label="Basic example">
                  <a class="btn btn-sm btn-info text-white" data-toggle="modal" data-placement="top" title="Tambah Pengguna" data-target="#modal-add-user"> 
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <?php } ?>

              <div class="card-body">
                <table id="table-users" class="table table-bordered table-striped">
                  <thead>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Level</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Level</th>
                    <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
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

    <!-- Modal-->
      <!-- Modal Add User -->
      <div class="modal fade" id="modal-add-user">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('User_c/addUserProses') ?>" id="form-add-user">
              <div class="modal-body">
                <!-- Form-part input Nama User -->
                  <div class="form-group row">
                    <label for="input-user-name" class="col-sm-3 col-form-label">Nama <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUserName" id="input-user-name" placeholder="Nama Pengguna" required>
                      <small id="error-user-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Username -->
                  <div class="form-group row">
                    <label for="input-user-username" class="col-sm-3 col-form-label">Username <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUserUsername" id="input-user-username" placeholder="Username Pengguna" required>
                      <small id="error-user-username" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Password User -->
                  <div class="form-group row">
                    <label for="input-user-password" class="col-sm-3 col-form-label">Password <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control float-right" name="postUserPassword" id="input-user-password" placeholder="Password" required>
                      <small id="error-user-password" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input -Re-Password User -->
                  <div class="form-group row">
                    <label for="input-user-repassword" class="col-sm-3 col-form-label">Ulang Password <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control float-right" name="postUserRePassword" id="input-user-repassword" placeholder="Masukkan Kembali Password" required>
                      <small id="error-user-repassword" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Level User -->
                  <div class="form-group row">
                    <label for="input-user-level" class="col-sm-3 col-form-label">Level <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <select name="postUserLevel" id="input-user-level" class="form-control">
                        <option value=""> -- Pilih Level User --</option>
                        <option value="O">Owner</option>
                        <option value="G">Admin Gudang</option>
                        <option value="P">Admin Purchasing</option>
                        <option value="K">Kasir</option>
                      </select>
                      <small id="error-user-level" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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

      <!-- Modal Edit User -->
      <div class="modal fade" id="modal-edit-user">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Data User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('User_c/editUserProses') ?>" id="form-edit-user">
              <div class="modal-body">
                <!-- Form-part user id -->
                  <input type="hidden" name="postUserID" id="edit-user-id" readonly>

                <!-- Form-part edit Nama User -->
                  <div class="form-group row">
                    <label for="edit-user-name" class="col-sm-3 col-form-label">Nama <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUserName" id="edit-user-name" placeholder="Nama Pengguna" required>
                      <small id="error-user-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part edit Username -->
                  <div class="form-group row">
                    <label for="edit-user-username" class="col-sm-3 col-form-label">Username <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUserUsername" id="edit-user-username" placeholder="Username Pengguna" required>
                      <small id="error-user-username" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part edit Level User -->
                  <div class="form-group row" id="div-edit-level">
                    <label for="edit-user-level" class="col-sm-3 col-form-label">Level <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <select name="postUserLevel" id="edit-user-level" class="form-control" required="" disabled="">
                        <option value=""> -- Pilih Level User --</option>
                        <option value="O">Owner</option>
                        <option value="G">Admin Gudang</option>
                        <option value="P">Admin Purchasing</option>
                        <option value="K">Kasir</option>
                      </select>
                      <small id="error-user-level" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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

      <!-- Modal Edit User -->
      <div class="modal fade" id="modal-change-password">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('User_c/changePasswordProses/') ?>" id="form-change-password">
              <div class="modal-body">
                <!-- Form-part user id -->
                  <input type="text" name="postUserID" id="change-user-id" readonly>

                <!-- Form-part input Password User -->
                  <div class="form-group row">
                    <label for="change-user-password" class="col-sm-3 col-form-label">Password <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control float-right" name="postUserPassword" id="change-user-password" placeholder="Password" required>
                      <small id="error-user-password" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input -Re-Password User -->
                  <div class="form-group row">
                    <label for="change-user-repassword" class="col-sm-3 col-form-label">Ulang Password <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control float-right" name="postUserRePassword" id="change-user-repassword" placeholder="Masukkan Kembali Password" required>
                      <small id="error-user-repassword" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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
      <?php echo $this->session->userdata('logedInLevel'); ?>