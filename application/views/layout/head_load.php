<!-- Core CSS / JS goes here -->

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- Additional lib or plugin goes here -->
  <?php if(in_array('datatables',$assets)){ ?> 
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <?php } ?>

  <?php if(in_array('sweetalert2',$assets)){ ?> 
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <?php } ?>