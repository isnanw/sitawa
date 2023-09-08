<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section id="content" class="content">
  <div class="content__header content__boxed overlapping">
			<div class="content__wrap">
				<h1 class="page-title mb-0 mt-2"><?= $judul; ?></h1>
					<p class="lead">
							<?= $diskripsi; ?>
					</p>
			</div>
		</div>
		<div class="content__boxed">
			<div class="content__wrap">
        <div class="card">
          <div class="card-header -4 mb-3">
						<div class="row">
							<div class="col-12">
							<div class="card">
								<div class="card-header">
								<h3 class="card-title">Profil Pengguna</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body ">
								<form id="edit">
									<div class="flex-shrink-0">
										<?php
											 	$sql = "SELECT uname,gambar FROM pengguna WHERE uname = '".$this->session->userdata('user')['uname']."'";
												// die($sql);
												$query = $this->db->query($sql);
												$gambar = "";
												if ($query->num_rows() > 0) {
														foreach ($query->result() as $row) {
																$gambar = $row->gambar;
														}
												}
												if($gambar != Null){
													$pp = $gambar;
												}else{
													$pp = '3.png';
												}

										?>
											<img class="img-xl rounded-circle" src="<?= base_url('uploads/').$pp ?>" alt="Profile Picture" loading="lazy">
									</div>

									<a href="<?= site_url('profil/upload/').$row->uname; ?>">Ubah Gambar</a>
									<hr>
									<div class="form-group">
									<label for="uname">Username</label>
									<input type="text" class="form-control" id="uname" readonly="readonly">
									</div>
									<div class="form-group">
									<label for="nama">Nama</label>
									<input name="nama" type="text" class="form-control" id="nama" placeholder="Nama">
									</div>
									<div class="form-group">
									<label for="nama">NIK</label>
									<input min="16" max="16" name="nik" type="text" class="form-control" id="nik" placeholder="NIK">
									</div>
									<div class="form-group">
									<label for="npwp">NPWP</label>
									<input min="15" max="15" name="npwp" type="text" class="form-control" id="npwp" placeholder="NPWP">
									</div>
									<div class="form-group">
									<label for="role">Role</label>
									<input type="text" class="form-control" id="role" placeholder="Role"  readonly="readonly">
									</div>
									<div class="form-group">
									<label for="pass1">Password</label>
									<input type="password" class="form-control" id="pass1" placeholder="">
									<input name="pass" type="hidden" class="form-control" id="pass" placeholder="">
									</div>
									<div class="form-group">
									<label for="pass2">Confirm Password</label>
									<input type="password" class="form-control" id="pass2" placeholder="">
									</div>
								<hr>
								<button type="submit" class="btn btn-success"><i class="nav-icon fas fa-disk"></i> Simpan</button>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="mt-auto">
      <div class="content__boxed">
          <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
              <div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#" class="ms-1 btn-link fw-bold">SIDKD Kab Mimika</a></div>
              <nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto" style="row-gap: 0 !important;">
                  <!-- <a class="nav-link px-0" href="#">Policy Privacy</a>
                  <a class="nav-link px-0" href="#">Terms and conditions</a>
                  <a class="nav-link px-0" href="#">Contact Us</a> -->
              </nav>
          </div>
      </div>
		</footer>
</section>


  <script language="javascript">
	$(function () {
	  $.ajax( {
		  url: '<?=base_url('index.php/'.$this->router->class.'/get/');?>',
		  type: 'GET',
		  success: function(data){
			  var json = $.parseJSON(data);
			  $("#edit").find("input[id=uname]").val(json.id);
			  $("#edit").find("input[name=nama]").val(json.nama);
				$("#edit").find("input[name=nik]").val(json.nik);
				$("#edit").find("input[name=npwp]").val(json.npwp);
			  $("#edit").find("input[id=role]").val(json.role);
			  $('#modal-edit').modal('show');

			}
	  });

		$('#edit' )
		  .submit( function( e ) {
			ok = true;
			if ($("#edit").find("#pass1").val()!='' || $("#edit").find("#pass2").val()!='') {
				if ($("#edit").find("#pass1").val()!=$("#edit").find("#pass2").val()) {
					toastr.error('Password tidak sama');
					ok = false;
				} else {
					$("#edit").find("#pass").val($.md5($("#edit").find("#pass1").val()) );
				}
			}

			if (ok) {
				$.ajax( {
				  url: '<?=base_url('index.php/'.$this->router->class.'/ubah');?>',
				  type: 'POST',
				  data: new FormData( this ),
				  processData: false,
				  contentType: false,
				  success: function(data){
					var json = $.parseJSON(data);
					if (json.status=="ok") {
						toastr.success(json.msg);
					} else if (json.status=="relogin") location.href='<?=base_url('index.php/auth/logout');?>';
					else toastr.error(json.msg);
				  }
				});
			}
			e.preventDefault();
		  });

	  });
  </script>