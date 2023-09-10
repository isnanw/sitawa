<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section id="content" class="content">
		<div class="content__header content__boxed overlapping">
			<div class="content__wrap">
				<h1 class="page-title mb-0 mt-2"><?= $judul; ?></h1>
					<p class="lead">
            <?= $diskripsi; ?>
							<button class="btn btn-danger"> Status Kepegawaian</button>
					</p>
			</div>
		</div>
    <div class="content__boxed">
			<div class="content__wrap">
					<!-- Table with toolbar -->
					<div class="card">
              <div class="card">
                <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
                </div>

                <div class="card-body">
                <table id="example1" class="table ">
                  <thead>
                    <tr>
                    <th>Nomor</th>
                    <th>Status Kepegawaian</th>
                    <th>Jumlah Pegawai</th>
                  </thead>
                <tbody>
                  <tr>
                    <th>1</th>
                    <th><a href="<?= base_url('managedocument/pns')?>"><i class="fa fa-folder"></i> PNS</a></th>
                    <th><?= $jumlahpns; ?></th>
                  </tr>
                  <tr>
                    <th>2</th>
                    <th><a href="<?= base_url('managedocument/cpns')?>"><i class="fa fa-folder"></i> CPNS</a></th>
                    <th><?= $jumlahcpns; ?></th>
                    <tr>
                    <th>3</th>
                    <th><a href="<?= base_url('managedocument/honorer')?>"><i class="fa fa-folder"></i> HONORER</a></th>
                    <th><?= $jumlahhonorer; ?></th>
                  </tr>
                  </tr>
                </tbody>
                </table>
                </div>
              </div>
          </div>
			</div>
		</div>


      <!-- FOOTER -->
			<footer class="mt-auto">
					<div class="content__boxed">
							<div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
									<div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#" class="ms-1 btn-link fw-bold">SITAWA Kab Mimika</a></div>
									<nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto" style="row-gap: 0 !important;">
											<!-- <a class="nav-link px-0" href="#">Policy Privacy</a>
											<a class="nav-link px-0" href="#">Terms and conditions</a>
											<a class="nav-link px-0" href="#">Contact Us</a> -->
									</nav>
							</div>
					</div>
			</footer>
			<!-- END - FOOTER -->
	</section>