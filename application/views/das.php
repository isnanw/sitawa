<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<style>
    .highcharts-figure,
    .highcharts-data-table table {
        /* min-width: 310px; */
        /* max-width: 1800px; */
        width: 100%;
        margin: 1em auto;
    }

    #container {
        height: 400px;
        width: 100%;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!-- CONTENTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section id="content" class="content">
    <div class="content__header content__boxed overlapping">
        <div class="content__wrap">

            <!-- Page title and information -->
            <h1 class="page-title mb-2">
                <?php echo $judul; ?>
            </h1>
            <h2 class="h5"><b>SI_TAWA</b> (Sistem Informasi Data Kepegawaian) Dalam Percepatan Layanan Kepegawaian Pada
                Distrik Kuala Kencana</h2>
            <p>Penggunaan SI_TAWA ini dalam rangka peningkatan kualitas pelayanan publik pada <b><u>Distrik Kuala
                        Kencana Kabupaten Mimika</u></b> dengan memanfaatkan teknologi informasi berupa Aplikasi
                berbasis Website.</p>
            <hr>
            <!-- END : Page title and information -->

        </div>

    </div>

    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-warning text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <i
                                    class="d-flex align-items-center justify-content-center demo-pli-male-female display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">
                                    <?= $jumlahpegawai; ?>
                                </h5>
                                <p class="mb-0">Jumlah Pegawai</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <i
                                    class="d-flex align-items-center justify-content-center demo-pli-male-female display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">
                                    <?= $jumlahpns; ?>
                                </h5>
                                <p class="mb-0">Jumlah PNS/ASN</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <i
                                    class="d-flex align-items-center justify-content-center demo-pli-male-female display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">
                                    <?= $jumlahcpns; ?>
                                </h5>
                                <p class="mb-0">Jumlah CPNS</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <i
                                    class="d-flex align-items-center justify-content-center demo-pli-male-female display-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">
                                    <?= $jumlahhonorer; ?>
                                </h5>
                                <p class="mb-0">Jumlah Honorer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                    </figure>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <figure class="highcharts-figure">
                            <div id="container_pns"></div>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <figure class="highcharts-figure">
                            <div id="container_cpns"></div>
                        </figure>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <figure class="highcharts-figure">
                            <div id="container_honorer"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="content__boxed">
            <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
                <div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#"
                        class="ms-1 btn-link fw-bold">SITAWA Kab Mimika</a></div>
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
$sql = "SELECT tgl_kenaikan_pangkat,tgl_kgb FROM pns WHERE tgl_kenaikan_pangkat >= now() AND tgl_kenaikan_pangkat < CURRENT_DATE + INTERVAL '3 months' OR
        tgl_kgb >= now() AND
        tgl_kgb < CURRENT_DATE + INTERVAL '3 months' ";
// die($sql);
$query = $this->db->query($sql);
if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
        $tanggalpanggkat = $row->tgl_kenaikan_pangkat;
        $tanggalkgb = $row->tgl_kgb;
    }
}
?>

<?php
if (@$tanggalpanggkat != Null or @$tanggalkgb != Null) {
    ?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pemberitahuan!!!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="tblData1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php }
?>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - CONTENTS -->

<?php
$dataCategories = array();
$dataSeries1 = array();

$dataArray = [];
$dataPNS = [];
$dataCPNS = [];
$dataHONORER = [];

$name = array(
    "PNS/ASN",
    "CPNS",
    "HONORER",
);
$color = array(
    "#FF1744",
    "#FFB300",
    "#009688",
);

foreach ($jenisdokumen as $data):
    $dataArray[] = [$data['kodeberkas'], (float) $data['jumlah']];
endforeach;

foreach ($dokumenpns as $pns):
    $dataPNS[] = [
        'name' => $pns['kodeberkas'],
        'y' => $pns['jumlah']
    ];
endforeach;

foreach ($dokumencpns as $cpns):
    $dataCPNS[] = [
        'name' => $cpns['kodeberkas'],
        'y' => $cpns['jumlah']
    ];
endforeach;

foreach ($dokumenhonorer as $honor):
    $dataHONORER[] = [
        'name' => $honor['kodeberkas'],
        'y' => $honor['jumlah']
    ];
endforeach;

?>

<script language="javascript">
    // $(function () {
    //     $('#myModal').modal('show');
    //     $("#tblData").DataTable({
    //         "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    //         "responsive": true, "lengthChange": true, "autoWidth": false,
    //         "processing": true, "serverSide": true, "ordering": false,
    //         "ajax": { "url": "<?= base_url('index.php/' . $this->router->class . '/list'); ?>", "type": "POST" },
    //         "columns": [
    //             { "data": "nip" },
    //             { "data": "nama" },
    //             { "data": "tanggal" },
    //         ],
    //         "buttons": ["copy", "csv", "excel", "pdf", "print"],
    //     }).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

    //     $("#tblData1").DataTable({
    //         "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    //         "responsive": true, "lengthChange": true, "autoWidth": false,
    //         "processing": true, "serverSide": true, "ordering": false,
    //         "ajax": { "url": "<?= base_url('index.php/' . $this->router->class . '/list'); ?>", "type": "POST" },
    //         "columns": [
    //             { "data": "nip" },
    //             { "data": "nama" },
    //             { "data": "tanggal" },
    //         ],
    //         "buttons": ["copy", "csv", "excel", "pdf", "print"],
    //     }).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

    //     $('#tanggal').datetimepicker({
    //         format: 'YYYY-MM-DD'
    //     });
    // });
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Rekap Dokumen'
        },
        subtitle: {
            text: 'Yang Terunggah di SI_TAWA'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah (Dokumen)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Jumlah: <b>{point.y:.0f} Dokumen</b>'
        },
        series: [{
            name: 'Population',
            colorByPoint: true,
            groupPadding: 0,
            data: <?= json_encode($dataArray, JSON_NUMERIC_CHECK); ?>,
            dataLabels: {
            enabled: false,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.0f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

Highcharts.chart('container_pns', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Dokumen PNS',
        align: 'center'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f} Dokumen</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Dokumen'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: <?= json_encode($dataPNS, JSON_NUMERIC_CHECK); ?>
    }]
});

Highcharts.chart('container_cpns', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Dokumen CPNS',
        align: 'center'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f} Dokumen</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Dokumen'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: <?= json_encode($dataCPNS, JSON_NUMERIC_CHECK); ?>
    }]
});


Highcharts.chart('container_honorer', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Dokumen Honorer',
        align: 'center'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f} Dokumen</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Dokumen'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: <?= json_encode($dataHONORER, JSON_NUMERIC_CHECK); ?>
    }]
});
</script>