<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>DETAIL PEGAWAI</h3>
            <h4>Distrik Kuala Kencana</h4>
            <table width="100%" style="border-collapse:collapse;">
                <tr>
                    <td width="45%">NIP</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['nip']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Nama</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['nama']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Jenis Kelamin</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['jenis_kelamin']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Tampat/Tanggal Lahir</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['tempat_lahir']; ?>, <?= $tgl_lahir; ?></td>
                </tr>
                <tr>
                    <td width="45%">Alamat</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['alamat']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Pendidikan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['pendidikan']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Agama</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['agama']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Pangkat Golongan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['pangkat_golongan']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Jabatan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['jabatan_pekerjaan']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Status Kepegawaian</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['status_kepegawaian']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Terhitung Mulai Tanggal Pangkat Golongan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $tglpangkat; ?></td>
                </tr>
                <tr>
                    <td width="45%">Terhitung Mulai Tanggal Jabatan Pekerjaan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $tgljabatan; ?></td>
                </tr>
            </tr>
        </table>
    </center>

    <br>

    <center>
        <h4>Daftar Dokumen</h4>
        <table border="1" width="100%" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Dokumen</th>
                    <th>Tanggal</th>
                    <th>Uraian</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dokumen)) { ?>
                    <?php $i = 1; ?>
                    <?php foreach ($dokumen as $b) : ?>
                        <tr>
                            <td style="width: 5%; vertical-align:top"><?= $i; ?></td>
                            <td style="width: 25%; vertical-align:top"><?= $b['kodeberkas']; ?></td>
                            <td style="width: 30%; vertical-align:top"><?= $b['tanggal']; ?></td>
                            <td style="width: 40%; vertical-align:top"><?= $b['uraian']; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php } else {?>
                    <tr>
                        <td colspan="4" align="center">NIHIL</td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </center>
</div>
</body>

</html>