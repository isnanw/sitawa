<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
  <meta name="description"
    content="The login page allows a user to gain access to an application by entering their username and password or by authenticating using a social media login.">
  <title>Login | SITAWA</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("logo.png"); ?>">

  <!-- STYLESHEETS -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

  <!-- Fonts [ OPTIONAL ] -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap"
    rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>

<body>
  <img decoding="async" class="wave" src="<?= base_url(); ?>assets/img/bg.png" />
  <div class="container">
    <div class="img">
      <!-- <img decoding="async" src="<?= base_url(); ?>assets/img/login.png" /> -->
    </div>
    <div class="login-content">
      <form id="loginform" action="<?= base_url(); ?>auth/dologin" method="post">
        <img decoding="async" src="<?= base_url(); ?>assets/img/logo.png" />
        <h2 class="title">LOGIN</h2>
        <p style="color: #011970"><b>SISTEM INFORMASI DATA KEPEGAWAIAN</b></p>
        <p>Distrik Kuala Kencana Kabupaten Mimika</p>
        <small style='color:red'>
          <?= $this->session->flashdata('login_msg'); ?>
        </small><br><br>
        <div class="input-div one">
          <div class="i">
            <i class="fas fa-user"></i>
          </div>
          <div class="div">
            <h5>Username</h5>
            <input type="text" class="form-control"  id="userX" />
            <input type='hidden' name='username' id='user'>
          </div>
        </div>
        <div class="input-div mb-5">
          <div class="i">
            <i class="fas fa-lock"></i>
          </div>
          <div class="div mb-5">
            <h5>Password</h5>
            <input type="password" class="form-control" id="passX" />
            <input type='hidden' name='password' id='pass'>
          </div>
        </div>
        <!-- <a href="#">Forget Password?</a> --> <br>
        <!-- <input type="submit" class="btn" value="Login" /> -->
        <div class="row">
          <div class="d-grid mb-3">
                <button class="btn btn-primary btn-lg" type="submit">Masuk</button>
            </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
  </div>

  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/md5.js"></script>

  <script type="text/javascript" src="<?= base_url(); ?>assets/js/main.js"></script>

  <!-- Bootstrap JS [ OPTIONAL ] -->
    <script src="<?=base_url();?>assets/v3.0.1/assets/js/bootstrap.min.bdf649e4bf3fa0261445f7c2ed3517c3f300c9bb44cb991c504bdc130a6ead19.js" defer></script>

    <!-- Nifty JS [ OPTIONAL ] -->
    <script src="<?=base_url();?>assets/v3.0.1/assets/js/nifty.min.b53472f123acc27ffd0c586e4ca3dc5d83c0670a3a5e120f766f88a92240f57b.js" defer></script>

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