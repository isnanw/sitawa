<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DMS Provinsi Papua | Log in</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url("favicon.ico"); ?>">  
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link href="<?=base_url();?>assets/AdminLTE-3.1.0/plugins/ionicons/ionicons.min.css" rel="stylesheet">
  <!-- icheck bootstrap -->
  <link rel="stylesheet"
    href="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/AdminLTE-3.1.0/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="<?=base_url();?>assets/AdminLTE-3.1.0/plugins/fonts/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2" rel="stylesheet">
  <link href="<?=base_url();?>assets/AdminLTE-3.1.0/plugins/fonts/6xKydSBYKcSV-LCoeQqfX1RYOo3ik4zwlxdu.woff2" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
	  <b><img src="<?=base_url();?>assets/logo.png">&nbsp;DMS Papua</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Silakan masukkan akses Anda <br><small style='color:red'><?=$this->session->flashdata('login_msg'); ?></small></p>

        <form id="loginform" action="<?=base_url();?>index.php/auth/dologin" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" id="userX">
			<input type='hidden' name='username' id='user'>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="passX">
			<input type='hidden' name='password' id='pass'>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>		  
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/jquery/md5.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?=base_url('assets');?>/AdminLTE-3.1.0/dist/js/adminlte.min.js"></script>
  <script type="text/javascript">
	$("#loginform").submit(function(event) {
		str = $("#userX").val().replace(/\s+/g, '');
		$("#userX").val(str);
		$("#user").val($.md5($("#userX").val().toLowerCase()) ); //escape case sesitive username
		$("#pass").val($.md5($("#passX").val()) );   
		//event.preventDefault();					
	});
  </script>
</body>

</html>