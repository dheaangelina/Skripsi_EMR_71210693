<?php
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cInsert.php");
include_once("../_function_i/cUpdate.php");
include_once("../_function_i/cDelete.php");
include_once("../_function_i/inc_f_object.php");

// Ambil URL path dari permintaan
$request = $_SERVER['REQUEST_URI'];
$request = trim($request, '/');
$segments = explode('/', $request);

if (empty($segments[3])) {
    $segments[3] = 0;
} else {
    $segments[3] = $segments[3];
}
$idJadwal = $segments[3];

$conn = new cConnect();
$conn->goConnect();

$view = new cView();

// Ambil data jadwal berdasarkan ID
$sqlDetail = "SELECT jp.*, prog.*, u.* FROM jadwal_program jp
              JOIN program prog ON jp.idProgram = prog.idProgram
              JOIN user u ON jp.idUser = u.idUser
              WHERE jp.idJadwal = $idJadwal";
$datajadwal = $view->vViewData($sqlDetail);

if (empty($datajadwal)) {
    die("Data tidak ditemukan.");
}

$datajadwal = $datajadwal[0]; // Ambil hasil pertama
?>

<div class="row mx-2">
    <div class="col-md-1" style="width: min-content; align-content: center;">
        <a href="../32"><ion-icon name="chevron-back-outline" size="large" style="color: black;"></ion-icon></a>
    </div>
    <div class="col-md-11">
        <?php
            _myHeader("DETAIL KINESIOTERAPI", "Detail Hasil Kinesioterapi");
        ?>
    </div>
    <div class="col-md-12">
        <div class="card border-success border border-4">
            <div class="card-body">
                <table class="table">
                <tr>
                        <th>Tanggal Kegiatan</th>
                        <td><?= $datajadwal['tanggalKegiatan'] ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Mulai</th>
                        <td><?= $datajadwal['waktuMulai'] ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Selesai</th>
                        <td><?= $datajadwal['waktuSelesai'] ?></td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td><?= $datajadwal['lokasi'] ?></td>
                    </tr>
                    <tr>
                        <th>Instansi</th>
                        <td><?= $datajadwal['instansi'] ?></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td><?= nl2br($datajadwal['catatan']) ?></td>
                    </tr>
                </table>
            </div>
        </div>    
    </div>
</div>

<?php
// Query ENUM 'waktuMunculKeluhan'
$waktuMunculKeluhan = "SHOW COLUMNS FROM hasil_layanan LIKE 'waktuMunculKeluhan'";
$view = new cView();
$arrayWaktuMunculKeluhan = $view->vViewData($waktuMunculKeluhan);
$enumWaktuMunculKeluhan = [];
if (!empty($arrayWaktuMunculKeluhan)) {
    $row = $arrayWaktuMunculKeluhan[0]; // Ambil hasil pertama
    if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
        $enumWaktuMunculKeluhan = explode(",", str_replace("'", "", $matches[1]));
    }
}
?>

<p></p>
<div class="row">
    <div class="col-md-12">
        <br><br>
    </div>
</div>
<div class="row mx-2">
    <div class="col-md-11">
        <?php
            _myHeader("HASIL KINESIOTERAPI", "Hasil Kinesioterapi");
        ?>
    </div>
</div>

<p></p>
<div class="row mx-2">
    <div class="col-md-12">
        <?php
        $sqlhasil = "SELECT hasil.*, jp.*, u.*, p.*, t.* FROM hasil_layanan hasil 
                    JOIN jadwal_program jp ON jp.idJadwal = hasil.idJadwal 
                    JOIN user u ON jp.idUser = u.idUser
                    JOIN pasien p ON p.idPasien = hasil.idPasien
                    JOIN terapis t ON t.idTerapis = hasil.idTerapis
                    WHERE hasil.idJadwal = $idJadwal
                    ORDER BY hasil.idHasilLayanan DESC";
        $view = new cView();
        $arrayhasil = $view->vViewData($sqlhasil);
        ?>
        <div id="" class='table-responsive'>
            <table id='example' class='table table-condensed'>
                <thead>
                    <tr>
                        <th width='5%' class="text-right">No.</th>
                        <th width=''>Pasien</th>
                        <th width=''>Keluhan</th>
                        <th width=''>Hasil Pemeriksaan</th>
                        <th width=''>Diagnosis</th>
                        <th width='5%'>VIEW</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnourut = 0;
                    foreach ($arrayhasil as $datahasil) {
                        $cnourut = $cnourut + 1;
                    ?>
                        <tr class=''>
                            <td class="text-right"><?= $cnourut; ?></td>
                            <td><?= $datahasil["namaLengkap"]; ?></td>
                            <td><?= $datahasil["keluhan"]; ?></td>
                            <td><?= $datahasil["hasilPemeriksaan"]; ?></td>
                            <td><?= $datahasil["diagnosis"]; ?></td>
                            <td>
                                <?php
                                    $datadetail = array(
                                        array("NAMA PASIEN", "idPasien", $datahasil["namaLengkap"], 1),
                                        array("NAMA TERAPIS", "idTerapis", $datahasil["namaTerapis"], 1),
                                        array("KELUHAN", "keluhan", $datahasil["keluhan"], 1),
                                        array("TINGKAT NYERI (0-10)", "tingkatNyeri", $datahasil["tingkatNyeri"], 1),
                                        array("WAKTU MUNCUL KELUHAN", "waktuMunculKeluhan", $datahasil["waktuMunculKeluhan"], 1),
                                        array("SIFAT SAKIT", "sifatSakit", $datahasil["sifatSakit"], 1),
                                        array("OBAT", "obat", $datahasil["obat"], 1),
                                        array("POSTUR TUBUH", "posturTubuh", $datahasil["posturTubuh"], 1),
                                        array("ROM", "ROM", $datahasil["ROM"], 1),
                                        array("POSITIVE", "positive", $datahasil["positive"], 1),
                                        array("MANAGEMENT", "management", $datahasil["management"], 1),
                                        array("HASIL PEMERIKSAAN", "hasilPemeriksaan", $datahasil["hasilPemeriksaan"], 3),
                                        array("DIAGNOSIS", "diagnosis", $datahasil["diagnosis"], 1),
                                        array("CATATAN RENCANA TINDAKAN", "catatanTindakan", $datahasil["catatanTindakan"], 1),
                                    );
                                    _CreateWindowModalDetil($datahasil["idHasilLayanan"], "view", "viewsasaran-form", "viewsasaran-button", "", 600, "DETAIL#HASIL KINESIOTERAPI " . $datahasil["idHasilLayanan"], "", $datadetail, "", $idJadwal, "");
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-md-12">
        <p><br><br><br><br><br></p>
    </div>
</div>