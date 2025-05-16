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
    $segments[3] = $segments[2];
} else {
    $segments[3] = $segments[3];
}
$idJadwal = $segments[3];

// echo $idJadwal;

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
        <a href="../31"><ion-icon name="chevron-back-outline" size="large" style="color: black;"></ion-icon></a>
    </div>
    <div class="col-md-11">
        <?php
            _myHeader("DETAIL FISIOTERAPI", "Detail Hasil Fisioterapi");
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

<p></p>
<div class="row">
    <div class="col-md-12">
        <br><br>
    </div>
</div>
<div class="row mx-2">
    <div class="col-md-11">
        <?php
            _myHeader("HASIL FISIOTERAPI", "Hasil Fisioterapi");
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
                                    $linkurl = $idJadwal;
                                    $datadetail = array(
                                        array("ID PASIEN", "idPasien", $datahasil["namaLengkap"], 1),
                                        array("ID TERAPIS", "idTerapis", $datahasil["namaTerapis"], 1),
                                        array("KELUHAN", "keluhan", $datahasil["keluhan"], 1),
                                        array("HASIL PEMERIKSAAN", "hasilPemeriksaan", $datahasil["hasilPemeriksaan"], 1),
                                        array("AREA TUBUH YANG DITERAPI", "areaTubuh", $datahasil["areaTubuh"], 1),
                                        array("DIAGNOSIS", "diagnosis", $datahasil["diagnosis"], 1),
                                        array("CATATAN RENCANA TINDAKAN", "catatanTindakan", $datahasil["catatanTindakan"], 1),
                                    );
                                    _CreateWindowModalDetil($datahasil["idHasilLayanan"], "view", "viewsasaran-form", "viewsasaran-button", "", 600, "DETAIL#HASIL FISIOTERAPI " . $datahasil['idHasilLayanan'], "", $datadetail, "", $linkurl, "");
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