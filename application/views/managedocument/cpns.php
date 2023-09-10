<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section id="content" class="content">
		<div class="content__header content__boxed overlapping">
			<div class="content__wrap">
				<h1 class="page-title mb-0 mt-2"><?= $judul; ?></h1>
					<p class="lead">
							<?= $diskripsi; ?>
              <a type="button" href="<?= base_url('managedocument')?>" class="btn btn-danger"> Status Kepegawaian</a>
              <a type="button" href="" class="btn btn-warning"> Pegawai</a>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jumlah Dokumen</th>
                    <th>Aksi</th>
                  </thead>
                <tbody>

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

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "lengthChange": true,
      "ordering": false,
      "destroy": true,
		  "processing": true,
      "serverSide": true,
      "ajax": {
                    "url": "<?= base_url('index.php/'.$this->router->class.'/ambildatacpns') ?>",
                    "type": "POST"
                },

    })

  });
</script>