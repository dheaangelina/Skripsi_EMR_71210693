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

// idJadwal pada index 3
// emr_pinilih = 0, role = 1, menu = 2
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
                    <th style="width: 200px;">Tanggal Kegiatan</th>
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
// insert
if (!empty($_POST["savebtn"])) {
    $idUser = $_SESSION["idUser"];
    $linkurl = $idJadwal;

    $tingkatNyeri = $_POST["tingkatNyeri"] ? $_POST['tingkatNyeri'] : NULL;
    if (!empty($_POST["sifatSakit"])) {
        $sifatSakitValue = implode(",", $_POST["sifatSakit"]); // Gabungkan nilai dengan koma
    } else {
        $sifatSakitValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }
    if (!empty($_POST["positive"])) {
        $positiveValue = implode(",", $_POST["positive"]); // Gabungkan nilai dengan koma
    } else {
        $positiveValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }
    if (!empty($_POST["management"])) {
        $managementValue = implode(",", $_POST["management"]); // Gabungkan nilai dengan koma
    } else {
        $managementValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }

    // field
    $datafield_hasil = array("idJadwal", "idUser", "idPasien", "idTerapis", "keluhan", "tingkatNyeri", "waktuMunculKeluhan", "sifatSakit", "obat", "posturTubuh", "ROM", "positive", "management", "hasilPemeriksaan", "diagnosis", "catatanTindakan");

    // value
    $datavalue_hasil = array($idJadwal, $idUser, $_POST["idPasien"], $_POST["idTerapis"], "'" . $_POST["keluhan"] . "'", $tingkatNyeri !== NULL ? $tingkatNyeri : "NULL", "'" . $_POST["waktuMunculKeluhan"] . "'", "'" . $sifatSakitValue . "'", "'" . $_POST["obat"] . "'", "'" . $_POST["posturTubuh"] . "'", "'" . $_POST["ROM"] . "'", "'" .$positiveValue. "'", "'" . $managementValue . "'", "'" . $_POST["hasilPemeriksaan"] . "'", "'" . $_POST["diagnosis"] . "'", "'" . $_POST["catatanTindakan"] . "'");

    $insert = new cInsert();
    // $insert->vInsertDataTrial($datafield_hasil, "hasil_layanan", $datavalue_hasil, $linkurl);
    $insert->vInsertData($datafield_hasil, "hasil_layanan", $datavalue_hasil, $linkurl);
}
?>

<?php
// update
if (!empty($_POST["editbtn"])) {
    $idUser = $_SESSION["idUser"];
    $linkurl = $idJadwal;

    $tingkatNyeri = $_POST["tingkatNyeri"] ? $_POST['tingkatNyeri'] : NULL;
    if (!empty($_POST["sifatSakit"])) {
        $sifatSakitValue = implode(",", $_POST["sifatSakit"]); // Gabungkan nilai dengan koma
    } else {
        $sifatSakitValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }
    if (!empty($_POST["positive"])) {
        $positiveValue = implode(",", $_POST["positive"]); // Gabungkan nilai dengan koma
    } else {
        $positiveValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }
    if (!empty($_POST["management"])) {
        $managementValue = implode(",", $_POST["management"]); // Gabungkan nilai dengan koma
    } else {
        $managementValue = ""; // Jika tidak ada yang dicentang, kosongkan
    }

    $datafield_hasil = array("idJadwal", "idUser", "idPasien", "idTerapis", "keluhan", "tingkatNyeri", "waktuMunculKeluhan", "sifatSakit", "obat", "posturTubuh", "ROM", "positive", "management", "hasilPemeriksaan", "diagnosis", "catatanTindakan");

    $datavalue_hasil = array($_POST["idJadwal"], $_POST["idUser"], $_POST["idPasien"], $_POST["idTerapis"], "'" . $_POST["keluhan"] . "'", $tingkatNyeri !== NULL ? $tingkatNyeri : "NULL", "'" . $_POST["waktuMunculKeluhan"] . "'", "'" . $sifatSakitValue . "'", "'" . $_POST["obat"] . "'", "'" . $_POST["posturTubuh"] . "'", "'" . $_POST["ROM"] . "'", "'" .$positiveValue. "'", "'" . $managementValue . "'", "'" . $_POST["hasilPemeriksaan"] . "'", "'" . $_POST["diagnosis"] . "'", "'" . $_POST["catatanTindakan"] . "'");

    $datakey = ' idHasilLayanan =' . $_POST["idHasilLayanan"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_hasil, "hasil_layanan", $datavalue_hasil, $datakey, $linkurl);
    $update->vUpdateData($datafield_hasil, "hasil_layanan", $datavalue_hasil, $datakey, $linkurl);
}
?>

<?php
// delete
if (!empty($_POST["btnhapus"])) {
    $delete = new cDelete();
    foreach ($_POST["hiddendeletevalue"] as $data) {
        // $delete->_dDeleteDataTrial($data["field"], $data["value"], $data["table"]);
        $delete->_dDeleteData($data["field"], $data["value"], $data["table"]);        
    }
}
?>

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
    <div class="col-md-1">
        <button type="button" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" 
                data-bs-toggle="modal" data-bs-target="#exampleModal" 
                style="border-radius: 10px; width: 50%; height: 60%; display: flex;">
            <i class="fa-solid fa-plus fa-lg" style="color: #ffffff;"></i>
        </button>

        <!-- Modal Insert -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            <blockquote class="blockquote">
                                <p>Tambah Hasil Kinesioterapi</p>
                            </blockquote>
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="" method="post" action="<?= $idJadwal ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="idPasien">ID Pasien <span class="required">*</span></label>
                                <select name="idPasien" id="idPasien" class="form-control" required>
                                    <option value="">- pilihan -</option>                                                                    
                                    <?php                                
                                    $sqlpasien = "SELECT * FROM pasien WHERE statusPasien = 'Aktif' ORDER BY idPasien";
                                    $view = new cView();
                                    $arraypasien = $view->vViewData($sqlpasien);
                                    
                                    foreach ($arraypasien as $datapasien) { // Ambil semua data dari hasil eksekusi $sql
                                        echo "<option value='".$datapasien['idPasien']."'>".$datapasien['namaLengkap']." - ".$datapasien['idPasien']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idTerapis">ID Terapis <span class="required">*</span></label>
                                <select name="idTerapis" id="idTerapis" class="form-control" required>
                                    <option value="">- pilihan -</option>                                                                    
                                    <?php                                
                                    $sqlterapis = "SELECT * FROM terapis WHERE statusTerapis = 'Aktif' ORDER BY idTerapis";
                                    $view = new cView();
                                    $arrayterapis = $view->vViewData($sqlterapis);
                                    
                                    foreach ($arrayterapis as $dataterapis) { // Ambil semua data dari hasil eksekusi $sql
                                        echo "<option value='".$dataterapis['idTerapis']."'>".$dataterapis['namaTerapis']." - ".$dataterapis['idTerapis']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="keluhan">Keluhan <span class="required">*</span></label>
                                <input class="form-control" type="text" name="keluhan" id="keluhan" value="" placeholder="Keluhan yang dirasakan pasien" maxlength="255" size="" required>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="tingkatNyeri">Tingkat Nyeri</label>
                                    <input class="form-control" type="number" name="tingkatNyeri" id="tingkatNyeri" value="" placeholder="Tingkat nyeri (0-10)" min="1" max="10" size="">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="waktuMunculKeluhan">Waktu Muncul Keluhan</label>
                                    <select name="waktuMunculKeluhan" id="waktuMunculKeluhan" class="form-control">
                                        <option value="">- pilihan -</option>
                                        <?php
                                            foreach ($enumWaktuMunculKeluhan as $option) {
                                                $trimmedValue = trim($option);
                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label mb-0" for="sifatSakit">Sifat Sakit</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Pegal" id="pegal">
                                            <label class="form-check-label" for="pegal">Pegal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Sakit" id="sakit">
                                            <label class="form-check-label" for="sakit">Sakit</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Tidak Nyaman" id="tidakNyaman">
                                            <label class="form-check-label" for="tidakNyaman">Tidak Nyaman</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Menjalar" id="menjalar">
                                            <label class="form-check-label" for="menjalar">Menjalar</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Mengganggu Aktivitas" id="menggangguAktivitas">
                                            <label class="form-check-label" for="menggangguAktivitas">Mengganggu Aktivitas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="obat">Obat</label>
                                <input class="form-control" type="text" name="obat" id="obat" value="" placeholder="Obat yang dikonsumsi pasien" maxlength="255" size="">
                            </div>
                            <div class="mb-3">
                                <label for="ROM">ROM</label>
                                <input class="form-control" type="text" name="ROM" id="ROM" value="" placeholder="ROM (Range of Motion) / Rentang Gerak Maksimum" maxlength="255" size="">
                            </div>
                            <div class="mb-3">
                                <label for="posturTubuh">Postur Tubuh</label>
                                <textarea class="form-control" id="posturTubuh" name="posturTubuh" placeholder="Hasil pemeriksaan postur tubuh oleh terapis" rows="3" cols="" id="floatingTextarea"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label mb-0" for="positive">Positive</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Trendelenberg" id="trendelenberg">
                                            <label class="form-check-label" for="trendelenberg">Trendelenberg</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Squat" id="squat">
                                            <label class="form-check-label" for="squat">Squat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Heel Walk" id="heelWalk">
                                            <label class="form-check-label" for="heelWalk">Heel Walk</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Toe Walk" id="toeWalk">
                                            <label class="form-check-label" for="toeWalk">Toe Walk</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="LLD" id="lld">
                                            <label class="form-check-label" for="lld">LLD</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Yeoman's" id="yeomans">
                                            <label class="form-check-label" for="yeomans">Yeoman's</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="SI Spring Test" id="siSpringTest">
                                            <label class="form-check-label" for="siSpringTest">SI Spring Test</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Palpasi Spine" id="palpasiSpine">
                                            <label class="form-check-label" for="palpasiSpine">Palpasi Spine</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="SLR" id="slr">
                                            <label class="form-check-label" for="slr">SLR</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Fabere Patrick" id="faberePatrick">
                                            <label class="form-check-label" for="faberePatrick">Fabere Patrick</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Mc Murray" id="mcMurray">
                                            <label class="form-check-label" for="mcMurray">Mc Murray</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Patella Dislocate" id="patellaDislocate">
                                            <label class="form-check-label" for="patellaDislocate">Patella Dislocate</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Cx Compression" id="cxCompression">
                                            <label class="form-check-label" for="cxCompression">Cx Compression</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="CTS" id="cts">
                                            <label class="form-check-label" for="cts">CTS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Lain-lain" id="lainlain">
                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label mb-0" for="management">Management</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="Posture" id="posture">
                                            <label class="form-check-label" for="posture">Posture</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="T Bar" id="tBar">
                                            <label class="form-check-label" for="tBar">T Bar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="NMT" id="nmt">
                                            <label class="form-check-label" for="nmt">NMT</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="MET" id="met">
                                            <label class="form-check-label" for="met">MET</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="PRT" id="prt">
                                            <label class="form-check-label" for="prt">PRT</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="Stretching" id="stretching">
                                            <label class="form-check-label" for="stretching">Stretching</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="Exercise" id="exercise">
                                            <label class="form-check-label" for="exercise">Exercise</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="Nutrisi" id="nutrisi">
                                            <label class="form-check-label" for="nutrisi">Nutrisi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="US" id="us">
                                            <label class="form-check-label" for="us">US</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="TENS" id="tens">
                                            <label class="form-check-label" for="tens">TENS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="management[]" value="Lain-lain" id="lainlain">
                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hasilPemeriksaan">Hasil Pemeriksaan <span class="required">*</span></label>
                                <textarea class="form-control" id="hasilPemeriksaan" name="hasilPemeriksaan" placeholder="Hasil pemeriksaan secara keseluruhan" rows="3" cols="" id="floatingTextarea" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="diagnosis">Diagnosis <span class="required">*</span></label>
                                <textarea class="form-control" id="diagnosis" name="diagnosis" placeholder="Diagnosis dari terapis" rows="3" cols="" id="floatingTextarea" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="catatanTindakan">Catatan dan Rencana Tindakan <span class="required">*</span></label>
                                <textarea class="form-control" id="catatanTindakan" name="catatanTindakan" placeholder="Catatan dan rekomendasi rencana tindakan dari terapis" rows="3" cols="" id="floatingTextarea" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 25px;" name="savebtn" value="true">Simpan</button>
                            <button type="reset" class="btn btn-warning btn-sm" style="border-radius: 25px;" name="" value="true">Ulang</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                        <th width='5%'>EDIT</th>
                        <th width='5%'>HAPUS</th>
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
                            <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formedit<?= $datahasil["idHasilLayanan"]; ?>" style="border-radius: 8px;">
                                <i class="fa-regular fa-pen-to-square" style="color: #000000;"></i>
                            </button>
                            <!-- Modal UPDATE -->
                            <div class="modal fade" id="formedit<?= $datahasil["idHasilLayanan"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content text-left">
                                        <div class="modal-header">
                                            <figure class="text-left">
                                                <blockquote class="blockquote">EDIT HASIL KINESIOTERAPI</blockquote>
                                                <figcaption class="blockquote-footer"><?= $datahasil["idHasilLayanan"]; ?></figcaption>                                     
                                                <figcaption class="blockquote-footer"><?= $datahasil["namaLengkap"]; ?> (<?= $datahasil["tanggalKegiatan"]; ?>)</figcaption>                                     
                                            </figure>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <FORM method="post" enctype="multipart/form-data" action="<?= $idJadwal ?>">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input class="form-control" type="text" name="idHasilLayanan" id="idHasilLayanan" value="<?= $datahasil["idHasilLayanan"]; ?>" maxlength="255" size="" hidden>
                                                <input class="form-control" type="text" name="idJadwal" id="idJadwal" value="<?= $datahasil["idJadwal"]; ?>" maxlength="255" size="" hidden>
                                                <input class="form-control" type="text" name="idUser" id="idUser" value="<?= $datahasil["idUser"]; ?>" maxlength="255" size="" hidden>
                                            </div>
                                            <div class="mb-3">
                                                <label for="idPasien">ID Pasien <span class="required">*</span></label>
                                                <select name="idPasien" id="idPasien" class="form-control" required>
                                                    <option value="<?= $datahasil["idPasien"]; ?>"><?= $datahasil["namaLengkap"] . " - " . $datahasil["idPasien"]; ?></option>                                                                    
                                                    <?php                                
                                                    $sqlpasien = "SELECT * FROM pasien WHERE statusPasien = 'Aktif' ORDER BY idPasien";
                                                    $view = new cView();
                                                    $arraypasien = $view->vViewData($sqlpasien);
                                                    
                                                    foreach ($arraypasien as $datapasien) { // Ambil semua data dari hasil eksekusi $sql
                                                        echo "<option value='".$datapasien['idPasien']."'>".$datapasien['namaLengkap']." - ".$datapasien['idPasien']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="idTerapis">ID Terapis <span class="required">*</span></label>
                                                <select name="idTerapis" id="idTerapis" class="form-control" required>
                                                    <option value="<?= $datahasil["idTerapis"]; ?>"><?= $datahasil["namaTerapis"] . " - " . $datahasil["idTerapis"]; ?></option>                                                                    
                                                    <?php                                
                                                    $sqlterapis = "SELECT * FROM terapis WHERE statusTerapis = 'Aktif' ORDER BY idTerapis";
                                                    $view = new cView();
                                                    $arrayterapis = $view->vViewData($sqlterapis);
                                                    
                                                    foreach ($arrayterapis as $dataterapis) { // Ambil semua data dari hasil eksekusi $sql
                                                        echo "<option value='".$dataterapis['idTerapis']."'>".$dataterapis['namaTerapis']." - ".$dataterapis['idTerapis']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keluhan">Keluhan <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="keluhan" id="keluhan" value="<?= $datahasil["keluhan"]; ?>" placeholder="Keluhan yang dirasakan pasien" maxlength="255" size="" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label for="tingkatNyeri">Tingkat Nyeri</label>
                                                    <input class="form-control" type="number" name="tingkatNyeri" id="tingkatNyeri" value="<?= $datahasil["tingkatNyeri"]; ?>" placeholder="Tingkat nyeri (0-10)" min="1" max="10" size="">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="waktuMunculKeluhan">Waktu Muncul Keluhan</label>
                                                    <select name="waktuMunculKeluhan" class="form-control">
                                                        <option value="<?= $datahasil["waktuMunculKeluhan"]; ?>"><?= $datahasil["waktuMunculKeluhan"]; ?></option>
                                                        <?php
                                                            foreach ($enumWaktuMunculKeluhan as $option) {
                                                                $trimmedValue = trim($option);
                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php
                                            $idHasilLayanan = $datahasil["idHasilLayanan"];
                                            // Query untuk mendapatkan riwayat penyakit pasien tertentu
                                            $sqlSifatSakit = "SELECT sifatSakit FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                            $view = new cView();
                                            $arraySifatSakit = $view->vViewData($sqlSifatSakit);
                                            // Pastikan data ditemukan
                                            $sifatSakitTerpilih = [];
                                            if (!empty($arraySifatSakit)) {
                                                $dataSifatSakit = $arraySifatSakit[0]; // Ambil baris pertama
                                                $sifatSakitTerpilih = explode(",", $dataSifatSakit["sifatSakit"]); // Ubah ke array
                                            } 
                                            ?>
                                            <div class="mb-3">
                                                <label class="form-label mb-0" for="sifatSakit">Sifat Sakit</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Pegal" id="pegal"
                                                            <?= in_array("Pegal", $sifatSakitTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="pegal">Pegal</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Sakit" id="sakit"
                                                            <?= in_array("Sakit", $sifatSakitTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="sakit">Sakit</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Tidak Nyaman" id="tidakNyaman"
                                                            <?= in_array("Tidak Nyaman", $sifatSakitTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="tidakNyaman">Tidak Nyaman</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Menjalar" id="menjalar"
                                                            <?= in_array("Menjalar", $sifatSakitTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="menjalar">Menjalar</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="sifatSakit[]" value="Mengganggu Aktivitas" id="menggangguAktivitas"
                                                            <?= in_array("Mengganggu Aktivitas", $sifatSakitTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="menggangguAktivitas">Mengganggu Aktivitas</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="obat">Obat</label>
                                                <input class="form-control" type="text" name="obat" id="obat" value="<?= $datahasil["obat"]; ?>" placeholder="Obat yang dikonsumsi pasien" maxlength="255" size="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ROM">ROM</label>
                                                <input class="form-control" type="text" name="ROM" id="ROM" value="<?= $datahasil["ROM"]; ?>" placeholder="ROM (Range of Motion) / Rentang Gerak Maksimum" maxlength="255" size="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="posturTubuh">Postur Tubuh</label>
                                                <textarea class="form-control" id="posturTubuh" name="posturTubuh" placeholder="Hasil pemeriksaan postur tubuh oleh terapis" rows="3" cols="" id="floatingTextarea"><?= $datahasil["posturTubuh"]; ?></textarea>
                                            </div>

                                            <?php
                                            $idHasilLayanan = $datahasil["idHasilLayanan"];
                                            // Query untuk mendapatkan riwayat penyakit pasien tertentu
                                            $sqlPositive = "SELECT positive FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                            $view = new cView();
                                            $arrayPositive = $view->vViewData($sqlPositive);
                                            // Pastikan data ditemukan
                                            $positiveTerpilih = [];
                                            if (!empty($arrayPositive)) {
                                                $dataPositive = $arrayPositive[0]; // Ambil baris pertama
                                                $positiveTerpilih = explode(",", $dataPositive["positive"]); // Ubah ke array
                                            } 
                                            ?>
                                            <div class="mb-3">
                                                <label class="form-label mb-0" for="positive">Positive</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Trendelenberg" id="trendelenberg"
                                                            <?= in_array("Trendelenberg", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="trendelenberg">Trendelenberg</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Squat" id="squat"
                                                            <?= in_array("Squat", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="squat">Squat</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Heel Walk" id="heelWalk"
                                                            <?= in_array("Heel Walk", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="heelWalk">Heel Walk</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Toe Walk" id="toeWalk"
                                                            <?= in_array("Toe Walk", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="toeWalk">Toe Walk</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="LLD" id="lld"
                                                            <?= in_array("LLD", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="lld">LLD</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Yeoman's" id="yeomans"
                                                            <?= in_array("Yeoman's", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="yeomans">Yeoman's</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="SI Spring Test" id="siSpringTest"
                                                            <?= in_array("SI Spring Test", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="siSpringTest">SI Spring Test</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Palpasi Spine" id="palpasiSpine"
                                                            <?= in_array("Palpasi Spine", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="palpasiSpine">Palpasi Spine</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="SLR" id="slr"
                                                            <?= in_array("SLR", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="slr">SLR</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Fabere Patrick" id="faberePatrick"
                                                            <?= in_array("Fabere Patrick", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="faberePatrick">Fabere Patrick</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Mc Murray" id="mcMurray"
                                                            <?= in_array("Mc Murray", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="mcMurray">Mc Murray</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Patella Dislocate" id="patellaDislocate"
                                                            <?= in_array("Patella Dislocate", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="patellaDislocate">Patella Dislocate</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Cx Compression" id="cxCompression"
                                                            <?= in_array("Cx Compression", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="cxCompression">Cx Compression</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="CTS" id="cts"
                                                            <?= in_array("CTS", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="cts">CTS</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="positive[]" value="Lain-lain" id="lainlain"
                                                            <?= in_array("Lain-lain", $positiveTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $idHasilLayanan = $datahasil["idHasilLayanan"];
                                            // Query untuk mendapatkan riwayat penyakit pasien tertentu
                                            $sqlManagement = "SELECT management FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                            $view = new cView();
                                            $arrayManagement = $view->vViewData($sqlManagement);
                                            // Pastikan data ditemukan
                                            $managementTerpilih = [];
                                            if (!empty($arrayManagement)) {
                                                $dataManagement = $arrayManagement[0]; // Ambil baris pertama
                                                $managementTerpilih = explode(",", $dataManagement["management"]); // Ubah ke array
                                            } 
                                            ?>
                                            <div class="mb-3">
                                                <label class="form-label mb-0" for="management">Management</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="Posture" id="posture"
                                                            <?= in_array("Posture", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="posture">Posture</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="T Bar" id="tBar"
                                                            <?= in_array("T Bar", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="tBar">T Bar</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="NMT" id="nmt"
                                                            <?= in_array("NMT", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="nmt">NMT</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="MET" id="met"
                                                            <?= in_array("MET", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="met">MET</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="PRT" id="prt"
                                                            <?= in_array("PRT", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="prt">PRT</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="Stretching" id="stretching"
                                                            <?= in_array("Stretching", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="stretching">Stretching</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="Exercise" id="exercise"
                                                            <?= in_array("Exercise", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="exercise">Exercise</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="Nutrisi" id="nutrisi"
                                                            <?= in_array("Nutrisi", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="nutrisi">Nutrisi</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="US" id="us"
                                                            <?= in_array("US", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="us">US</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="TENS" id="tens"
                                                            <?= in_array("TENS", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="tens">TENS</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="management[]" value="Lain-lain" id="lainlain"
                                                            <?= in_array("Lain-lain", $managementTerpilih) ? "checked" : ""; ?>>
                                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hasilPemeriksaan">Hasil Pemeriksaan <span class="required">*</span></label>
                                                <textarea class="form-control" id="hasilPemeriksaan" name="hasilPemeriksaan" placeholder="Hasil pemeriksaan oleh terapis" rows="3" cols="" id="floatingTextarea" required><?= $datahasil["hasilPemeriksaan"]; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="diagnosis">Diagnosis <span class="required">*</span></label>
                                                <textarea class="form-control" id="diagnosis" name="diagnosis" placeholder="Diagnosis dari terapis" rows="3" cols="" id="floatingTextarea" required><?= $datahasil["diagnosis"]; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="catatanTindakan">Catatan dan Rencana Tindakan <span class="required">*</span></label>
                                                <textarea class="form-control" id="catatanTindakan" name="catatanTindakan" placeholder="Catatan dan rekomendasi rencana tindakan dari terapis" rows="3" cols="" id="floatingTextarea" required><?= $datahasil["catatanTindakan"]; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="editbtn" value="true" class="btn btn-primary btn-sm" style="border-radius: 25px;">SIMPAN</button>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">TUTUP</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                                <?php
                                $idHasilLayanan = $datahasil["idHasilLayanan"]; // Ambil idHasilLayanan dari URL atau request

                                // Query untuk mendapatkan sifatSakit pasien tertentu
                                $sqlSifatSakit = "SELECT sifatSakit FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                $view = new cView();
                                $arraySifatSakit = $view->vViewData($sqlSifatSakit);
                                // Pastikan data ditemukan
                                $sifatSakitTerpilih = [];
                                if (!empty($arraySifatSakit)) {
                                    $dataSifatSakit = $arraySifatSakit[0]; // Ambil baris pertama
                                    $sifatSakitTerpilih = explode(",", $dataSifatSakit["sifatSakit"]); // Ubah ke array
                                } 

                                // Query untuk mendapatkan positive pasien tertentu
                                $sqlPositive = "SELECT positive FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                $view = new cView();
                                $arrayPositive = $view->vViewData($sqlPositive);
                                // Pastikan data ditemukan
                                $positiveTerpilih = [];
                                if (!empty($arrayPositive)) {
                                    $dataPositive = $arrayPositive[0]; // Ambil baris pertama
                                    $positiveTerpilih = explode(",", $dataPositive["positive"]); // Ubah ke array
                                } 

                                // Query untuk mendapatkan management pasien tertentu
                                $sqlManagement = "SELECT management FROM hasil_layanan WHERE idHasilLayanan = '$idHasilLayanan'";
                                $view = new cView();
                                $arrayManagement = $view->vViewData($sqlManagement);
                                // Pastikan data ditemukan
                                $managementTerpilih = [];
                                if (!empty($arrayManagement)) {
                                    $dataManagement = $arrayManagement[0]; // Ambil baris pertama
                                    $managementTerpilih = explode(",", $dataManagement["management"]); // Ubah ke array
                                } 

                                ?>
                            </td>
                            <td>
                            <?php
                                // delete
                                $datadelete = array(
                                    array("idHasilLayanan", $datahasil["idHasilLayanan"], "hasil_layanan")
                                );
                                _CreateWindowModalDelete($datahasil["idHasilLayanan"], "del", "del-form", "del-button", "lg", 200, "HAPUS#JADWAL KINESIOTERAPI " . $datahasil["idHasilLayanan"] . "#" . $datahasil["namaLengkap"] . " - " . $datahasil["tanggalKegiatan"], "", $datadelete, "", "$idJadwal");
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