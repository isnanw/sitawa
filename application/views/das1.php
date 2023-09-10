<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- CONTENTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section id="content" class="content">
    <div class="content__header content__boxed overlapping">
        <div class="content__wrap">

            <!-- Page title and information -->
            <h1 class="page-title mb-2"><?php echo $judul; ?></h1>
            <h2 class="h5">Sistem Informasi Kepegawaian Berbasis Digital (SITAWA)</h2>
            <p>Penggunaan SITAWA ini dalam rangka peningkatan kualitas pelayanan publik pada <b><u>Dinas Perumahan, Kawasan Pemukiman dan Pertanahan Kabupaten Mimika</u></b> dengan memanfaatkan teknologi informasi berupa Aplikasi Website.</p>
            <!-- END : Page title and information -->

        </div>

    </div>

    <?php
        $sql = "SELECT tgl_kenaikan_pangkat FROM pns WHERE nip = '".$this->session->userdata('user')['uname']."' AND tgl_kenaikan_pangkat >= now() AND tgl_kenaikan_pangkat < CURRENT_DATE + INTERVAL '3 months'";
        // die($sql);
        $query = $this->db->query($sql);
        $tanggalpanggkat = "";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $tanggalpanggkat = $row->tgl_kenaikan_pangkat;
            }
        }
    ?>

    <div class="content__boxed">
        <?php
            if($tanggalpanggkat != Null){
        ?>
        <div class="content__wrap">
            <div class="row">
                <div class="alert alert-info" role="alert">
                    Kepada Bapak/Ibu (<b><?=$this->session->userdata('user')['nama']?></b>), anda akan melaksanakan kenaikan pangkat pada <b class="alert-link btn-link text-decoration-underline"><?= mediumdate_indonesia($tanggalpanggkat) ?></b>
                </div>
            </div>
        </div>
        <?php }
        ?>
    </div>
    <!-- <div class="card"> -->
    <div class="content__wrap">
        <div class="card">
            <div class="content__wrap d-md-flex align-items-start">
                <figure class="m-2">
                    <div class="d-inline-flex align-items-center position-relative pt-xl-2 mb-3">
                        <!-- <div class="flex-shrink-0">
                            <img class="img-xl rounded-circle" src="<?= base_url('assets/v3.0.1')?>/assets/img/profile-photos/3.png" alt="Profile Picture" loading="lazy">
                        </div> -->
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
                        <div class="flex-grow-1 ms-4">
                            <a href="#" class="h3 btn-link"><?=$this->session->userdata('user')['nama']?></a>
                            <p class="text-muted m-0"><?=$this->session->userdata('user')['uname']?></p>

                            <!-- Social network button -->
                            <div class="mt-3 text-reset">
                                <a href="#" class="btn btn-icon btn-hover bg-blue-700 text-white">
                                    <i class="demo-psi-facebook fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-hover bg-blue-400 text-white">
                                    <i class="demo-psi-twitter fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-hover bg-red text-white">
                                    <i class="demo-psi-google-plus fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-hover bg-orange text-white">
                                    <i class="demo-psi-instagram fs-4"></i>
                                </a>
                            </div>
                            <!-- END : Social network button -->

                        </div>
                    </div>

                    <blockquote class="blockquote">
                        <p>DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</p>
                    </blockquote>
                    <figcaption class="blockquote-footer mb-xl-0">
                        Kabupaten Mimika
                    </figcaption>
                </figure>
                <!-- <div class="d-inline-flex justify-content-end pt-xl-5 gap-2 ms-auto">
                    <button class="btn btn-light text-nowrap">Edit Profile</button>
                    <button class="btn btn-success text-nowrap">Send Message</button>
                </div> -->
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

<?php
    if($tanggalpanggkat != Null){
?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pemberitahuan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Kepada Bapak/Ibu (<b><?=$this->session->userdata('user')['nama']?></b>), anda akan melaksanakan kenaikan pangkat pada <b class="alert-link btn-link text-decoration-underline"><?= mediumdate_indonesia($tanggalpanggkat) ?></b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php } ?>

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - CONTENTS -->


<script language="javascript">
    $(function () {
        $('#myModal').modal('show');
		$("#tblData").DataTable({
		  "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
		  "responsive": true, "lengthChange": true, "autoWidth": false,
		  "processing": true, "serverSide": true,  "ordering": false,
		  "ajax": {"url":"<?=base_url('index.php/'.$this->router->class.'/list');?>", "type": "POST"},
		  "columns": [
				{ "data": "nip" },
				{ "data": "nama" },
				{ "data": "tanggal" },
			],
		   "buttons": ["copy", "csv", "excel", "pdf", "print"],
		}).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

		$('#tanggal').datetimepicker({
			format: 'YYYY-MM-DD'
		});
});
</script>


