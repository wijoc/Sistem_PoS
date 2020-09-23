<!-- Core JS Goes here -->
	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>


<!-- additional Page script goes here -->
	<!-- Page Kategori & Satuan -->
	<?php if(in_array('katsat',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/page/js/katsat_assets.js"></script>
	<?php } ?>