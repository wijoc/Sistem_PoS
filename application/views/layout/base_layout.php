<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $title ?></title>

  <!-- head css and/or js file -->
  <?php if($head_load){ echo $head_load; } ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
 <!-- wrapper -->
  <div class="wrapper">

    <!-- Main Header -->
    <?php if($header){ echo $header; } ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php if($sidebar){ echo $sidebar; } ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php if($content){ echo $content; } ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar
    <?php // if($control){ echo $control; } ?> -->
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php if($footer){ echo $footer; } ?>

  </div>
 <!-- ./wrapper -->

 <!-- REQUIRED SCRIPTS -->
  <?php if($foot_load){ echo $foot_load; } ?>

</body>
</html>