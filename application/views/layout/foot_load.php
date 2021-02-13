<!-- Core JS Goes here -->
	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
	<!-- Regex format for float input -->
	<script src="<?php echo base_url() ?>assets/dist/js/regex_format.js"></script>
	<!-- Tooltip -->
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>

<!-- Addritional library needed -->
	<!-- DataTables -->
	<?php if(in_array('datatables',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<!-- Default datatable -->
		<script src="<?php echo base_url() ?>assets/extra/datatables_default.js"></script>
	<?php } ?>

	<!-- SweetAlert 2 -->
	<?php if(in_array('sweetalert2',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<?php } ?>

	<!-- JQuery UI -->
	<?php if(in_array('jqueryui',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
	<?php } ?>

	<!-- bs-custom-file-input -->
	<?php if(in_array('custominput',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
			  bsCustomFileInput.init()
			});
		</script>
	<?php } ?>

	<!-- Datepicker -->
	<?php if(in_array('daterangepicker', $assets)){ ?>
		<!-- moment js -->
		<script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
		<!-- date-range-picker -->
		<script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
		<script>
			$(function (){
				//Date range picker with time picker
				$('#datepicker').daterangepicker({
					timePicker: true,
					timePickerIncrement: 30,
					locale: {
						format: 'MM/DD/YYYY hh:mm A'
					}
				})
			})
		</script>	
	<?php } ?>
	
	<!-- Dropify -->
	<?php if(in_array('dropify', $assets)){ ?>
        <script src="<?php echo base_url() ?>assets/plugins/dropify/js/dropify.min.js"></script>
        <script>
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
	<?php } ?>

<!-- additional Page script goes here -->
	<!-- Page Add Produk -->
	<?php if(in_array('p_add_product',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/add_product_assets.js"></script>
	<?php } ?>

	<!-- Page Kategori & Satuan -->
	<?php if(in_array('page_catunit',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/cat_unit_assets.js"></script>
	<?php } ?>

	<!-- Page Add Product -->
	<?php if(in_array('page_contact',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/contact_assets.js"></script>
	<?php } ?>	

	<!-- Page Add Trans -->
	<?php if(in_array('page_add_trans',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/add_transaction_assets.js"></script>
		<script type="text/javascript">
			prdAutocompleteUrl = "<?php echo site_url('Product_c/autocompleteProduct') ?>"
		</script>
	<?php } ?>	

	<!-- Page Add Trans Purchase / Pembelian -->
	<?php if(in_array('page_add_purchases',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/add_purchases_assets.js"></script>
	<?php } ?>

	<!-- Page Add Trans -->
	<?php if(in_array('page_add_sales',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/add_sales_assets.js"></script>
		<script type="text/javascript">
			var ctmSearchUrl = "<?php echo site_url('Customer_c/searchCustomer/1') ?>"
			var ctmDataUrl = "<?php echo site_url('Customer_c/getCustomer') ?>"
		</script>
	<?php } ?>	

	<!-- Page Add Trans Installment / Angsuran -->
	<?php if(in_array('page_installment',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/add_installment_assets.js"></script>
	<?php } ?>

	<!-- Page setting profile -->
	<?php if(in_array('page_profile', $assets)){ ?>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/pages/setting_profile_assets.js"></script>
	<?php } ?>

	<!-- Page List Trans -->
	<?php if(in_array('page_list_trans',$assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/pages/list_transaction_assets.js"></script>
	<?php } ?>

	<!-- Page Konfirmasi Delete -->
	<?php if(in_array('f_confirm', $assets)){ ?>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/pages/f_confirm.js"></script>
	<?php } ?>

	<!-- Alert -->
	<?php if(in_array('alert', $assets)){ ?>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/pages/alert.js"></script>
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