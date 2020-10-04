<!-- Core JS Goes here -->
	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>

<!-- Addritional library needed -->
	<!-- DataTables -->
	<?php if(in_array('datatables',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<?php } ?>

	<!-- SweetAlert 2 -->
	<?php if(in_array('sweetalert2',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<?php } ?>

	<!-- JQuery UI -->
	<?php if(in_array('jqueryui',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
	<?php } ?>

<!-- additional Page script goes here -->
	<!-- Page Kategori & Satuan -->
	<?php if(in_array('page_katsat',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/katsat_assets.js"></script>
	<?php } ?>	

	<!-- Page Add Product -->
	<?php if(in_array('page_addprd',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/addprd_assets.js"></script>
	<?php } ?>	

	<!-- Page Add Product -->
	<?php if(in_array('page_contact',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/contact_assets.js"></script>
	<?php } ?>	

	<!-- Page Add Trans Pembelian -->
	<?php if(in_array('page_addtb',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/addpembelian_assets.js"></script>
		<script type="text/javascript">
			autocompleteUrl = "<?php echo site_url('Product_c/autocompleteProduct') ?>";
		</script>
	<?php } ?>

	<!-- Untuk session input -->
	<?php if($this->session->flashdata('flashStatus')){ ?>
		<script type="text/javascript">
			var flashStatus = "<?php echo $this->session->flashdata('flashStatus') ;?>";
			var flashMsg = "<?php echo ($this->session->flashdata('flashMsg'))? $this->session->flashdata('flashMsg') : '' ;?>";
			<?php if($this->session->flashdata('flashInput')){ ?> // Khusus page kategori & Satuan 
				var flashInput = "<?php echo $this->session->flashdata('flashInput') ?>";
			<?php } ?>
			<?php if($this->session->flashdata('flashRedirect')){ ?> // Khusus page kategori & Satuan 
				var site_url = "<?php echo site_url($this->session->flashdata('flashRedirect')) ?>";
			<?php } ?>
		</script>
	<?php } ?>