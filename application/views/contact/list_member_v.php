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
              <li class="breadcrumb-item active">Kontak Member</li>
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
            <h5 class="m-0 card-title">Daftar Kontak Member</h5>
            <a class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-tambah-member"> <i class="fas fa-plus"></i> Tambah member</a>
          </div>
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              <?php foreach($dataMember as $showMember) : ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      <?php echo ($showMember['member_status'] === 'Y')? 'Aktif' : 'Non-Aktif' ?>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?php echo $showMember['member_nama'] ?></b></h2>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-md fa-percent"></i></span> Discount : <?php echo $showMember['member_discount'] ?> %
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
                        <a href="" class="btn btn-sm btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">8</a></li>
              </ul>
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
      <div class="modal fade" id="modal-tambah-member">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Member</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Member_c/addMemberProses') ?>" id="formMember">
              <div class="modal-body">
                
                <!-- Form-part input Member nama -->
                  <div class="form-group row">
                    <label for="inputMemberNama" class="col-sm-3 col-form-label">Nama Member <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postMemberNama" id="inputMemberNama" placeholder="Nama Member" required>
                    </div>
                  </div>

                <!-- Form-part input Member status -->
                  <div class="form-group row">
                    <label for="inputMemberTelp" class="col-sm-3 col-form-label">Status <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <select class="form-control" name="postMemberStatus" id="inputMemberStatus">
                        <option value="Y">Aktif</option>
                        <option value="N">Tidak Aktif</option>
                      </select>
                    </div>
                  </div>

                <!-- Form-part input Member discount -->
                  <div class="form-group row">
                    <label for="inputMemberDiscount" class="col-sm-3 col-form-label">Discount <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control float-right" name="postMemberDiscount" id="inputMemberDiscount" placeholder="Besaran Discount">
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