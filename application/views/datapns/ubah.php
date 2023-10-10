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
                <div class="card-body ">
                  <h3 class="card-title">Form Ubah Pegawai</h3><hr>
                    <!-- Block styled form -->
                    <!-- <form class="row g-3" action="<?= base_url('datapns/ubahData') ?>"> -->
                    <form class="row g-3" id="frm">
                      <div class="col-md-6">
                          <label for="nip" class="form-label">NIP <sub><small>PNS</small></sub> / NIK <sub><small>Honorer</small></sub></label>
                          <input readonly id="nip" name="nip" type="text" class="form-control" value="<?= $list['nip']?>">
                      </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input required id="nama" name="nama" type="text" class="form-control" value="<?= $list['nama']?>">
                        </div>


                        <div class="col-md-6">
                            <label for="opd" class="form-label">OPD</label>
                            <input required id="opd" name="opd" type="text" class="form-control" value="Distrik Kuala Kencana" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="statuspegawai" class="form-label">Status Kepegawaian</label>
                            <!-- <input required id="statuspegawai" name="statuspegawai" type="text" class="form-control" value="<?= $list['status_kepegawaian'] ?>"> -->
                            <select id="statuspegawai" name="statuspegawai" class="form-select">
                                <!-- <option selected>Choose...</option> -->
                                <?php
                                  if($list['status_kepegawaian'] == 'PNS'){
                                    $seleted = 'selected';
                                  }

                                  if($list['status_kepegawaian'] == 'CPNS'){
                                    $seleted1 = 'selected';
                                  }

                                  if($list['status_kepegawaian'] == 'Honorer'){
                                    $seleted2 = 'selected';
                                  }
                                ?>
                                <option value="PNS" <?= @$seleted ?>>PNS</option>
                                <option value="CPNS" <?= @$seleted1 ?>>CPNS</option>
                                <option value="Honorer" <?= @$seleted2 ?>>Honorer</option>
                            </select>
                        </div>
                        <hr>
                        <div class="col-md-4">
                            <label for="pangkat" class="form-label">Pangkat Golongan</label>
                            <input required id="pangkat" name="pangkat" type="text" class="form-control" value="<?= $list['pangkat_golongan'] ?>">
                        </div>

                        <div class="col-md-4">
                          <?php
                          $tanggal_databasetmtpg = $list['tmt_pangkat_golongan'];
                          // Membagi tanggal menjadi komponen (hari, bulan, tahun)
                          list($hari, $bulan, $tahun) = explode('/', $tanggal_databasetmtpg);
                          // Mengonversi format tanggal ke "YYYY-MM-DD"
                          $tanggal_tmtpg = "$tahun-$bulan-$hari";
                          ?>
                            <label for="tmt_pangkat_golongan" class="form-label">TMT Pangkat Golongan</label>
                            <input id="tmt_pangkat_golongan" name="tmt_pangkat_golongan" type="date" class="form-control" value="<?= $tanggal_tmtpg ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="ruang" class="form-label">Ruang</label>
                            <input id="ruang" name="ruang" type="text" class="form-control" value="<?= $list['ruang'] ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="jabatan" class="form-label">Jabatan Pekerjaan</label>
                            <input required id="jabatan" name="jabatan" type="text" class="form-control" value="<?= $list['jabatan_pekerjaan'] ?>">
                        </div>

                        <div class="col-md-4">
                          <?php
                          $tanggal_databasetmtjp = $list['tmt_jabatan_pekerjaan'];
                          // Membagi tanggal menjadi komponen (hari, bulan, tahun)
                          list($hari, $bulan, $tahun) = explode('/', $tanggal_databasetmtjp);
                          // Mengonversi format tanggal ke "YYYY-MM-DD"
                          $tanggal_tmtjp = "$tahun-$bulan-$hari";
                          ?>
                            <label for="tmt_jabatan_pekerjaan" class="form-label">TMT Jabatan Pekerjaan</label>
                            <input id="tmt_jabatan_pekerjaan" name="tmt_jabatan_pekerjaan" type="date" class="form-control" value="<?= $tanggal_tmtjp ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                            <input id="pendidikan" name="pendidikan" type="text" class="form-control" value="<?= $list['pendidikan'] ?>">
                        </div>
                        <hr>
                        <div class="col-md-4">
                            <label for="tempatlahir" class="form-label">Tempat Lahir</label>
                            <input required id="tempatlahir" name="tempatlahir" type="text" class="form-control" value="<?= $list['tempat_lahir'] ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                            <?php
                            $tanggal_database = $list['tgl_lahir'];
                            // Membagi tanggal menjadi komponen (hari, bulan, tahun)
                            list($hari, $bulan, $tahun) = explode('/', $tanggal_database);
                            // Mengonversi format tanggal ke "YYYY-MM-DD"
                            $tanggal_dikonversi = "$tahun-$bulan-$hari";
                            ?>
                            <input id="tgllahir" name="tgllahir" type="date" class="form-control" value="<?= $tanggal_dikonversi ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jeniskelamin" name="jeniskelamin" class="form-select">
                                <!-- <option selected>Choose...</option> -->
                                <option value="Laki - laki" <?php if ($list['jenis_kelamin'] == 'Laki - laki')
                                  echo 'selected'; ?>>Laki - laki</option>
                                <option value="Perempuan" <?php if ($list['jenis_kelamin'] == 'Perempuan')
                                  echo 'selected'; ?>>Perempuan</option>
                                <option value="Lainnya" <?php if ($list['jenis_kelamin'] == 'Lainnya')
                                  echo 'selected'; ?>>Lainnya</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input id="alamat" name="alamat" type="text" class="form-control" value="<?= $list['alamat'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="agama" class="form-label">Agama</label>
                            <input id="agama" name="agama" type="text" class="form-control" value="<?= $list['agama'] ?>">
                        </div>
                        <hr>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary"> Simpan </button>
                        </div>

                    </form>
                    <!-- END : Block styled form -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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

</section>

<script language="javascript">
  $(function () {
    $('#frm')
		  .submit( function( e ) {
			$.ajax( {
			  url: '<?=base_url($this->router->class.'/ubahData');?>',
			  type: 'POST',
			  data: new FormData( this ),
			  processData: false,
			  contentType: false,
			  success: function(data){
				var json = $.parseJSON(data);
				if (json.status=="ok") {
					toastr.success(json.msg);
					location.href = '<?=base_url($this->router->class);?>';
				} else toastr.error(json.msg);
			  }
			});
			e.preventDefault();
		  });
  });
</script>