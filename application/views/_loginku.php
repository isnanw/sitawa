<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
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

  <!-- Bootstrap CSS [ REQUIRED ] -->
  <link rel="stylesheet"
    href="<?= base_url(); ?>assets/v3.0.1/assets/css/bootstrap.min.75a07e3a3100a6fed983b15ad1b297c127a8c2335854b0efc3363731475cbed6.css">

  <!-- Nifty CSS [ REQUIRED ] -->
  <link rel="stylesheet"
    href="<?= base_url(); ?>assets/v3.0.1/assets/css/nifty.min.4d1ebee0c2ac4ed3c2df72b5178fb60181cfff43375388fee0f4af67ecf44050.css">

  <style>
    body,
    html {
      height: 100%;
      margin: 0;
    }

    .bg {
      /* The image used */
      background-image: url("<?= base_url('assets/background.jpg') ?>");

      /* Full height */
      height: 100%;

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>

</head>

<body class="">

  <!-- PAGE CONTAINER -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <div id="root" class="root front-container bg">

    <!-- CONTENTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <section id="content" class="content">
      <div class="content__boxed w-100 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="content__wrap">

          <!-- Login card -->
          <div class="card bg shadow-lg">
            <div class="card-body">

              <div class="text-center">
                <h1 style="color: white;" class="h1">LOGIN | SITAWA</h1>
                <p style="color: white;">SISTEM INFORMASI KEPEGAWAIAN BERBASIS DIGITAL</p>
                <hr style="color: white;">
                <br><small style='color:red'><?= $this->session->flashdata('login_msg'); ?></small>
              </div>

              <form id="loginform" action="<?= base_url(); ?>index.php/auth/dologin" method="post">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Username" id="userX" autofocus>
                  <input type='hidden' name='username' id='user'>

                </div>
                <div class="mb-5">
                  <input type="password" class="form-control" placeholder="Password" id="passX">
                  <input type='hidden' name='password' id='pass'>
                </div>

                <div class="row">
                  <div class="d-grid mb-3">
                    <button class="btn btn-primary btn-lg" type="submit">Masuk</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
          </div>
          <!-- END : Login card -->

        </div>
      </div>
    </section>

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - CONTENTS -->


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - CONTENTS -->
  </div>
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <!-- END - PAGE CONTAINER -->

  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets'); ?>/AdminLTE-3.1.0/plugins/jquery/md5.js"></script>

  <!-- Bootstrap JS [ OPTIONAL ] -->
  <script
    src="<?= base_url(); ?>assets/v3.0.1/assets/js/bootstrap.min.bdf649e4bf3fa0261445f7c2ed3517c3f300c9bb44cb991c504bdc130a6ead19.js"
    defer></script>

  <!-- Nifty JS [ OPTIONAL ] -->
  <script
    src="<?= base_url(); ?>assets/v3.0.1/assets/js/nifty.min.b53472f123acc27ffd0c586e4ca3dc5d83c0670a3a5e120f766f88a92240f57b.js"
    defer></script>

  <script type="text/javascript">
    $("#loginform").submit(function (event) {
      str = $("#userX").val().replace(/\s+/g, '');
      $("#userX").val(str);
      $("#user").val($.md5($("#userX").val().toLowerCase())); //escape case sesitive username
      $("#pass").val($.md5($("#passX").val()));
      //event.preventDefault();
    });
  </script>

</body>

</html>

<!-- CONTENTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->