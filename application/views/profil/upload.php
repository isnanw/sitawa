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
                    <!-- Table with toolbar -->
                    <div class="card">
                        <div class="card-header -4 mb-3">
                            <!-- <h5 class="card-title mb-3">Table with toolbar</h5> -->
                            <div class="row">

                                <!-- Left toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center mb-3">
                                 <h3>Upload Poto Profil</h3>
                                </div>
                                <!-- END : Left toolbar -->

                            </div>
                        </div>

                        <div class="card-body">
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
                          <form action="<?php echo base_url().'profil/upload_aksi'; ?>" method="POST" enctype="multipart/form-data">
                            <label for="berkas">Berkas</label>
                          <!-- <div class="input-group"> -->
                            <div class="custom-file">
                            <input type="hidden" name="id" class="form-control" value="<?php echo $this->session->userdata('user')['uname'] ?>">
                            <input name="photo_home" type="file" accept=".jpg,.png" class="custom-file-input form-control" id="photo_home">
                            <!-- <label class="custom-file-label" for="berkas">Pilih file</label> -->
                            </div>
                            <?php if (isset($error)) : ?>
                                <div class="invalid-feedback"><?= $error ?></div>
                            <?php endif; ?>
                            <hr>
                            <div>
                                <button type="submit" name="save" class="btn btn-primary">Upload</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- END : Table with toolbar -->

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