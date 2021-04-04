<!-- Core CSS / JS goes here -->
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- Additional lib or plugin goes here -->
  <?php if(in_array('datatables',$assets)){ ?>
    <!-- DataTables CSS--> 
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <?php if(in_array('datatables_button',$assets)){ ?>
      <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.css">
    <?php } ?>
  <?php } ?>

  <?php if(in_array('sweetalert2',$assets)){ ?> 
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <?php } ?>

  <?php if(in_array('jqueryui',$assets)){ ?>
    <!-- JQuery UI CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.css">
  <?php } ?>

  <?php if(in_array('daterangepicker', $assets)){ ?>
    <!-- Daterange-picker CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <?php } ?>

  <?php if(in_array('dropify', $assets)){ ?>
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropify/css/dropify.min.css">
  <?php } ?>

  <?php if(in_array('toastr', $assets)){ ?>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/toastr/toastr.min.css">
  <?php } ?>

<!-- Extra CSS / JS file goes here -->
  <?php if(in_array('receipt',$assets)){ ?>
    <!-- Small Receipt / Struk thermal -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/pages/receipt_style.css">
  <?php } ?>