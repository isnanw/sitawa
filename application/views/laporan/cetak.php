<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>LAPORAN KARYAWAN STATUS KEPEGAWAIAN <?= $sfilter; ?></h3>
            <h4>Distrik Kuala Kencana</h4>
            <table border="1" width="100%" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($list as $b) : ?>
                    <tr>
                        <td style="width: 5%; vertical-align:top"><?= $i; ?></td>
                        <td style="width: 20%; vertical-align:top"><?= $b['nip']; ?></td>
                        <td style="width: 30%; vertical-align:top"><?= $b['nama']; ?></td>
                        <td style="width: 15%; vertical-align:top"><?= $b['tgl_lahir']; ?></td>
                        <td style="width: 15%; vertical-align:top"> <center><?= $b['jenis_kelamin']; ?></center></td>
                        <td style="width: 15%; vertical-align:top"><?= $b['jabatan_pekerjaan']; ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>