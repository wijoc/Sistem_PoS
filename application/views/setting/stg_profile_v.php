    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-weight: bold;">Halaman Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Setting_c') ?>" ><i class="fas fa-cogs"></i> Pengaturan</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title" style="font-weight: bold;">Detail Profile Toko</h5>
                <a class="float-right btn btn-xs btn-warning" id="triggerEditProfile" data-toggle="modal" data-target="#modal-edit-profile"><i class="fas fa-edit"></i></a>
              </div>
              <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('Setting_c/editProfileProses').'/'.urlencode(base64_encode($dataProfile[0]['pfl_id'])) ?>">
	              <div class="card-body">
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Logo<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                  	<?php if ($dataProfile[0]['pfl_logo']){ ?>
	                  		<img src="<?php echo base_url().$dataProfile[0]['pfl_logo'] ?>" style="width: 150px;">
	                  	<?php } else { ?>
	                  		<img src="<?php echo base_url().'/assets/dist/img/image_not_available.jpeg' ?>" style="width: 150px;">
	                  	<?php } ?>
	                  	<input type="hidden" name="postPflOldLogo" value="<?php echo $dataProfile[0]['pfl_logo'] ?>">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label"></label>
	                  <div class="col-sm-8">
	                  	<div class="custom-file">
	                        <input type="file" class="form-control float-right custom-file-input" name="postPflLogo" id="inputPflLogo">
	                    	<label class="custom-file-label" for="inputPflLogo"><p>Pilih Logo</p></label>
	                    </div>
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Nama Toko<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="postPflName" value="<?php echo $dataProfile[0]['pfl_name'] ?>" placeholder="Input Nama Toko">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">No. Telp<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="postPflTelp" value="<?php echo $dataProfile[0]['pfl_telp'] ?>" placeholder="Input Nomor Telp">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Fax<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="postPflFax" value="<?php echo $dataProfile[0]['pfl_fax'] ?>" placeholder="Input No Fax">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">E - mail<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                    <input type="email" class="form-control" name="postPflEmail" value="<?php echo $dataProfile[0]['pfl_email'] ?>" placeholder="Input E-mail Toko">
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label class="col-sm-3 col-form-label">Alamat<a class="float-right"> : </a></label>
	                  <div class="col-sm-8">
	                  	<textarea class="form-control" rows="3" name="postPflAddress" id="inputPflAddress"><?php echo $dataProfile[0]['pfl_address']?></textarea>
	                  </div>
	                </div>
	              </div>
	              <div class="card-footer">
	                <div class="float-right">
	                	<button type="reset" class="btn btn-secondary"><b> Reset </b></button>
	                    <button type="submit" class="btn btn-success"><b> Simpan </b></button>
	              	</div>
	              </div>
	          </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <?php print("<pre>".print_r($dataProfile, true)."</pre>") ?>