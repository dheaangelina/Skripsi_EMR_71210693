<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr';

// Koneksi ke MySQL dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
?>

<?php
    // Query ENUM 'kelompokUsia'
    $usia = "SHOW COLUMNS FROM pasien LIKE 'kelompokUsia'";
    $view = new cView();
    $arrayUsia = $view->vViewData($usia);
    $enumKelompokUsia = [];
    if (!empty($arrayUsia)) {
        $row = $arrayUsia[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumKelompokUsia = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'jenisKelamin'
    $jk = "SHOW COLUMNS FROM pasien LIKE 'jenisKelamin'";
    $view = new cView();
    $arrayJK = $view->vViewData($jk);
    $enumJK = [];
    if (!empty($arrayJK)) {
        $row = $arrayJK[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumJK = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'golonganDarah'
    $goldar = "SHOW COLUMNS FROM pasien LIKE 'golonganDarah'";
    $view = new cView();
    $arrayGoldar = $view->vViewData($goldar);
    $enumGoldar = [];
    if (!empty($arrayGoldar)) {
        $row = $arrayGoldar[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumGoldar = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'agama'
    $agama = "SHOW COLUMNS FROM pasien LIKE 'agama'";
    $view = new cView();
    $arrayAgama = $view->vViewData($agama);
    $enumAgama = [];
    if (!empty($arrayAgama)) {
        $row = $arrayAgama[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumAgama = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'pendidikan'
    $pendidikan = "SHOW COLUMNS FROM pasien LIKE 'pendidikan'";
    $view = new cView();
    $arrayPendidikan = $view->vViewData($pendidikan);
    $enumPendidikan = [];
    if (!empty($arrayPendidikan)) {
        $row = $arrayPendidikan[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumPendidikan = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'pekerjaan'
    $pekerjaan = "SHOW COLUMNS FROM pasien LIKE 'pekerjaan'";
    $view = new cView();
    $arrayPekerjaan = $view->vViewData($pekerjaan);
    $enumPekerjaan = [];
    if (!empty($arrayPekerjaan)) {
        $row = $arrayPekerjaan[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumPekerjaan = explode(",", str_replace("'", "", $matches[1]));
        }
    }

    // Query ENUM 'statusPernikahan'
    $statusPernikahan = "SHOW COLUMNS FROM pasien LIKE 'statusPernikahan'";
    $view = new cView();
    $arrayStatusNikah = $view->vViewData($statusPernikahan);
    $enumNikah = [];
    if (!empty($arrayStatusNikah)) {
        $row = $arrayStatusNikah[0]; // Ambil hasil pertama
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $enumNikah = explode(",", str_replace("'", "", $matches[1]));
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Pasien</title>
    
    <script src="../manajemen/js/jquery.min.js" type="text/javascript"></script>
    <script src="../manajemen/js/config.js?v=<?php echo time(); ?>" type="text/javascript"></script>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <figure>
                    <blockquote class="blockquote"><p>DATA PASIEN</p></blockquote>
                    <figcaption class="blockquote-footer">Entri Data Pasien</figcaption>
                </figure>
            </div>

            <div class="row">
                <div class="col-md-12">
                <?php
                $sqlpasien = "SELECT p.*, sd.*, jd.*, prov.*, kk.*, kec.*, kel.* FROM pasien p
                            JOIN sub_disabilitas sd ON p.idSubDisabilitas = sd.idSubDisabilitas
                            JOIN jenis_disabilitas jd ON sd.idJenisDisabilitas = jd.idJenisDisabilitas
                            LEFT JOIN kelurahan kel ON p.idKelurahanDomisili = kel.idKelurahan
                            LEFT JOIN kecamatan kec ON kel.idKecamatan = kec.idKecamatan
                            LEFT JOIN kotakabupaten kk ON kec.idKotaKabupaten = kk.idKotaKabupaten
                            LEFT JOIN provinsi prov ON kk.idProvinsi = prov.idProvinsi
                            ORDER BY idPasien DESC";
                $view = new cView();
                $arraypasien = $view->vViewData($sqlpasien);
                ?>
                <div id="" class='table-responsive'>
                    <table id="example" class="table table-condensed">
                        <thead>
                            <tr class=''>
                                <!-- <th width='5%'>ID Pasien</th> -->
                                <th width='5%'>No.</th>
                                <th width='10%'>Nama Pasien</th>
                                <th width='15%'>Usia</th>
                                <th width='15%'>Jenis Kelamin</th>
                                <th width=''>Alamat Domisili</th>
                                <th width=''>Disabilitas</th>
                                <th width='5%'>VIEW</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $cnourut = 0;
                                foreach ($arraypasien as $datapasien) { 
                                    $cnourut = $cnourut + 1;
                            ?>
                                <tr class=''>
                                    <td><?= $cnourut; ?></td>
                                    <!-- <td><?= $datapasien["idPasien"]; ?></td> -->
                                    <td><?= $datapasien["namaLengkap"]; ?></td>
                                    <td><?= $datapasien["kelompokUsia"]; ?></td>
                                    <td><?= $datapasien["jenisKelamin"]; ?></td>
                                    <td><?= $datapasien["alamatDomisili"]; ?></td>
                                    <td><?= $datapasien["namaDisabilitas"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#formview<?= $datapasien["idPasien"]; ?>" style="border-radius: 8px;">
                                            <i class="fa-regular fa-eye" style="color: #000000;"></i>
                                        </button>

                                        <!-- Modal View Detil -->
                                        <div class="modal fade" id="formview<?= $datapasien["idPasien"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog text-start modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <figure class="text-left">
                                                            <blockquote class="blockquote">DETAIL PASIEN <?= $datapasien["idPasien"]; ?></blockquote>
                                                        </figure>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-condensed">
                                                            <tr>
                                                                <td width="39%">Nama Lengkap</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaLengkap"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Nama Panggilan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaPanggilan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">NIK</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["nik"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Tempat Lahir</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["tempatLahir"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Tanggal Lahir</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["tanggalLahir"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kelompok Usia</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["kelompokUsia"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Jenis Kelamin</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["jenisKelamin"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Golongan Darah</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["golonganDarah"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Nomor Telepon Pasien</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["noTeleponPasien"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Alamat Lengkap (KTP)</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["alamatLengkap"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Alamat Domisili</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["alamatDomisili"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Tanggal Mulai Aktif</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["tanggalAktif"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Status Pasien</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["statusPasien"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Alasan Tidak Aktif</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["alasanTidakAktif"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Jenis Disabilitas</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["jenisDisabilitas"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Subjenis Disabilitas</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaDisabilitas"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Alat Bantu</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["alatBantu"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kebutuhan Khusus</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["kebutuhanKhusus"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Riwayat Penyakit Pribadi</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["riwayatPenyakitPribadi"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Riwayat Penyakit Keluarga</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["riwayatPenyakitKeluarga"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Alergi</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["alergi"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Trauma/Cedera</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["trauma"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Nama Orang Tua</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaOrangTua"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">No Telepon Orang Tua</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["noTelpOrangTua"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Nama Pendamping</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaPendamping"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">No Telepon Pendamping</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["noTelpPendamping"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Nama Jalan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaJalan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Provinsi</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaProvinsi"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kota/Kabupaten</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaKotaKabupaten"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kecamatan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaKecamatan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kelurahan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["namaKelurahan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Kode Pos Domisili</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["kodePosDomisili"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">RT/RW Domisili</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["RTDomisili"]; ?>/<?= $datapasien["RWDomisili"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Agama</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["agama"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Suku</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["suku"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Bahasa Dikuasai</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["bahasaDikuasai"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Pendidikan Terakhir</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["pendidikan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Pekerjaan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["pekerjaan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Status Pernikahan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["statusPernikahan"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="39%">Keterangan</td><td width="1%">:</td>
                                                                <td width="60%"><?= $datapasien["keterangan"]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<p></p>
<div class="row">
    <div class="col-md-12">
        <p><br><br><br><br><br></p>
    </div>
</div>