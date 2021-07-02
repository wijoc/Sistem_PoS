<!-- Core JS Goes here -->
	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
	<!-- Regex format for float input (for Firefox)
	<script src="<?php echo base_url() ?>assets/dist/js/regex_format.js"></script>  -->
	<!-- Tooltip -->
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>

<!-- Addritional library needed -->
	<?php if(in_array('sweetalert2',$assets)){ ?>
		<!-- SweetAlert 2 -->
		<script src="<?php echo base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<?php } ?>
	
	<?php if(in_array('datatables',$assets)){ ?>
	  <!-- DataTables -->
		<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<!-- Default datatable -->
		<script src="<?php echo base_url() ?>assets/extra/datatables_default.js"></script>
	<?php } ?>

	<?php if(in_array('jqueryui',$assets)){ ?>
		<!-- JQuery UI -->
		<script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
	<?php } ?>

	<?php if(in_array('custominput',$assets)){ ?>
		<!-- bs-custom-file-input -->
		<script src="<?php echo base_url() ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
			  bsCustomFileInput.init()
			});
		</script>
	<?php } ?>

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

	<?php if(in_array('dropify', $assets)){ ?>
		<!-- Dropify -->
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

	<?php if(in_array('toastr', $assets)){ ?>
		<!-- Toastr -->
		<script src="<?php echo base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
	<?php } ?>

	<?php if(in_array('chart', $assets)){ ?>
		<!-- ChartJS -->
		<script src="<?php echo base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
	<?php } ?>

<!-- additional Page script goes here -->
	<?php if(in_array('add_product',$assets)){ ?>
		<!-- Page Add Product -->
		<script src="<?php echo base_url() ?>assets/dist/js/product/add_product_assets.js"></script>
	<?php } ?>

	<?php if(in_array('edit_product',$assets)){ ?>
		<!-- Page edit Product -->
		<script src="<?php echo base_url() ?>assets/dist/js/product/edit_product_assets.js"></script>
	<?php } ?>

	<?php if(in_array('list_product',$assets)){ ?>
		<!-- List Produk Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/product/list_product_assets.js"></script>
		<script>
			let product_url = "<?php echo $prdAjaxUrl ?>"
		</script>
	<?php } ?>

	<?php if(in_array('stock_product',$assets)){ ?>
		<!-- Stock Produk Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/product/stock_product_assets.js"></script>
		<script>
			let stk_product_url = "<?php echo site_url('Product_c/stockProductAjax') ?>"
		</script>
	<?php } ?>

	<?php if(in_array('ctgr_unit', $assets)){ ?>
		<!-- Page Kategori & Satuan -->
		<script src="<?php echo base_url() ?>assets/dist/js/product/ctgr_unit_assets.js"></script>
		<script>
			var ctgr_url = "<?php echo site_url('Product_c/listCategoryAjax') ?>"
			var unit_url = "<?php echo site_url('Product_c/listUnitAjax') ?>"
		</script>
	<?php } ?>

	<?php if(in_array('contact',$assets)){ ?>
		<!-- Page Contact Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/pages/contact_assets.js"></script>
		<script>
			var contact_url = "<?php echo $contact_url ?>"
		</script>
	<?php } ?>

	<?php if(in_array('list_transaction',$assets)){ ?>
		<!-- List Transaction Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/list_transaction_assets.js"></script>
		<script>
			let transaction_url = "<?php echo $transactionUrl; ?>"
		</script>
	<?php } ?>

	<?php if(in_array('add_transaction',$assets)){ ?>
		<!-- Add Transaction Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/add_transaction_assets.js"></script>
		<script>
			cart_url = "<?php echo $cartUrl ?>"
			prd_url	 = "<?php echo site_url('Product_c/autocompleteProduct/') ?>"
		</script>
	<?php } ?>

	<?php if(in_array('add_sales',$assets)){ ?>
		<!-- Page Add Trans Sales -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/add_sales_assets.js"></script>
		<script type="text/javascript">
			var ctmSearchUrl = "<?php echo site_url('Customer_c/searchCustomer/1') ?>"
			var ctmDataUrl = "<?php echo site_url('Customer_c/getCustomer') ?>"
		</script>
	<?php } ?>	

	<?php if(in_array('installment',$assets)){ ?>
		<!-- Installment Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/installment_assets.js"></script>
		<script>
			var installment_url = "<?php echo $iListUrl ?>"
			var min_tenor	= "<?php echo $minLimitI ?>"
			var max_tenor	= "<?php echo $maxLimitI ?>"
		</script>
	<?php } ?>

	<?php if(in_array('add_revenues_expenses', $assets)){ ?>
		<!-- Add Expenses Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/add_revenues_expenses_assets.js"></script>
	<?php } ?>

	<?php if(in_array('account',$assets)){ ?>
		<!-- Account Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/pages/account_assets.js"></script>
		<script>
			var account_url = "<?php echo $accountUrl ?>"
		</script>
	<?php } ?>

	<?php if(in_array('add_return',$assets)){ ?>
		<!-- Add Return Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/transaction/add_return_assets.js"></script>
	<?php } ?>

	<?php if(in_array('list_user', $assets)){ ?>
		<!-- List User Assets -->
		<script src="<?php echo base_url() ?>assets/dist/js/settings/user_assets.js"></script>
		<script>
			let users_url = "<?php echo $userAjaxUrl; ?>"
		</script>
	<?php } ?>

	<?php if(in_array('f_confirm', $assets)){ ?>
		<!-- Delete Confirmation Assets -->
		<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/pages/f_confirm.js"></script>
	<?php } ?>

	<?php if(in_array('dashboard', $assets)){ ?>
		<!-- Dashboard Assets -->
		<script type="text/javascript" src="<?php echo base_url() ?>assets/dist/js/pages/dashboard_assets.js"></script>
		<script>
			var chart_url = '<?php echo $chartUrl; ?>'
		</script>
	<?php } ?>

	<!-- belum -->

	<?php if(in_array('p_setting', $assets)){ ?>
		<script src="<?php echo base_url() ?>assets/dist/js/product/setting_assets.js"></script>
		<script>
			var setting_list_url = "<?php echo $ajaxUrl ?>"
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
