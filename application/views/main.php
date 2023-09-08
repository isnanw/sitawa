<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DMS Pemerintah Provinsi Papua</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url("favicon.ico"); ?>">

  <!-- Google Font: Source Sans Pro -->
  <link href="<?=base_url();?>assets/AdminLTE-3.1.0/plugins/fonts/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2" rel="stylesheet">
  <link href="<?=base_url();?>assets/AdminLTE-3.1.0/plugins/fonts/6xKydSBYKcSV-LCoeQqfX1RYOo3ik4zwlxdu.woff2" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/toastr/toastr.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/jquery/md5.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
	<!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-phone"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php
            $hotline = $this->db->get('hotline')->result_array();
            foreach ($hotline as $data) {
          ?>
          <div class="dropdown-divider"></div>
          <a href="<?= $data['link'] ?>" target="_blank" class="dropdown-item">
            <i class="<?= $data['icon'] ?> mr-2"></i> <?= $data['urai'] ?> <br>
            <i class="fa fa-envelo mr-4"></i>
            <span class="small"><i><?= $data['keterangan'] ?></i></span>
          </a>
          <?php
            }
          ?>
          <!-- <div class="dropdown-divider"></div>
          <a href="tel:081515952136" class="dropdown-item">
            <i class="fas fa-phone mr-2"></i> No Telephone <br>
            <i class="fa fa-envelo mr-4"></i>
            <span class="small"><i>081515952136</i></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="https://wa.me/6281515952136" class="dropdown-item">
            <i class="fab fa-whatsapp mr-2"></i> Link WA <br>
            <i class="fa fa-envelo mr-4"></i>
            <span class="small"><i>wa.me/6281515952136</i></span>
          </a>
          <div class="dropdown-divider"></div> -->

        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
		    <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?=base_url('assets');?>/AdminLTE-3.1.0/dist/img/avatar5.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?=$this->session->userdata('user')['nama']?>
                </h3>
                <p class="text-sm"><?=$this->session->userdata('user')['uname']?></p>
                <p class="text-sm text-muted"><i class="far fa-id-card mr-1"></i><?=$this->session->userdata('user')['role']?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>
		    </span>
          <div class="dropdown-divider"></div>
          <a href="<?=base_url('index.php/profil');?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?=base_url('index.php/auth/logout');?>" class="dropdown-item dropdown-footer">Logout</a>
        </div>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?=base_url('assets');?>/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DMS Papua</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
			<a href="<?=base_url('index.php/main/dashboard');?>" class="nav-link <?= $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Dashboard</p>
            </a>
          </li>
		  <?php
			foreach ($this->session->userdata('menu') as $menu) {
      $link = $menu['url'];
      $aktive = $this->uri->segment(1) == $link;
		  ?>
          <li class="nav-item">
            <a href="<?=base_url($menu['url']);?>" class="nav-link <?= $aktive ? 'active' : ''; ?>">
              <i class="nav-icon <?=$menu['icon'];?>"></i>
              <p><?=$menu['title'];?></p>
            </a>
          </li>
		  <?php
			}
          ?>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	    <?=$content;?>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/toastr/toastr.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/moment/moment.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js"></script>
<!-- QRcode -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/qrcode/qrcode.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/AdminLTE-3.1.0/dist/js/adminlte.min.js"></script>
</body>
</html>
