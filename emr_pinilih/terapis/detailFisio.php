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

<?php
// insert
if (!empty($_POST["savebtn"])) {
    $idUser = $_SESSION["idUser"];
    $linkurl = $idJadwal;

    // field
    $datafield_hasil = array("idJadwal", "idUser", "idPasien", "idTerapis", "keluhan", "hasilPemeriksaan", "areaTubuh", "diagnosis", "catatanTindakan");

    // value
    $datavalue_hasil = array($idJadwal, $idUser, $_POST["idPasien"], $_POST["idTerapis"], "'" . $_POST["keluhan"] . "'", "'" . $_POST["hasilPemeriksaan"] . "'", "'" . $_POST["areaTubuh"] . "'", "'" . $_POST["diagnosis"] . "'", "'" . $_POST["catatanTindakan"] . "'");

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

    $datafield_hasil = array("idJadwal", "idUser", "idPasien", "idTerapis", "keluhan", "hasilPemeriksaan", "areaTubuh", "diagnosis", "catatanTindakan");

    $datavalue_hasil = array($_POST["idJadwal"], $_POST["idUser"], $_POST["idPasien"], $_POST["idTerapis"], "'" . $_POST["keluhan"] . "'", "'" . $_POST["hasilPemeriksaan"] . "'", "'" . $_POST["areaTubuh"] . "'", "'" . $_POST["diagnosis"] . "'", "'" . $_POST["catatanTindakan"] . "'");

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
                                <p>Tambah Hasil Fisioterapi</p>
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
                            <div class="mb-3">
                                <label for="hasilPemeriksaan">Hasil Pemeriksaan <span class="required">*</span></label>
                                <textarea class="form-control" id="hasilPemeriksaan" name="hasilPemeriksaan" placeholder="Hasil pemeriksaan oleh terapis" rows="3" cols="" id="floatingTextarea" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="areaTubuh">Area Tubuh <span class="required">*</span></label>
                                <input class="form-control" type="text" name="areaTubuh" id="areaTubuh" value="" placeholder="Area tubuh yang diterapi" maxlength="255" size="" required>
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
                                                <blockquote class="blockquote">EDIT HASIL FISIOTERAPI</blockquote>
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
                                            <div class="mb-3">
                                                <label for="hasilPemeriksaan">Hasil Pemeriksaan <span class="required">*</span></label>
                                                <textarea class="form-control" id="hasilPemeriksaan" name="hasilPemeriksaan" placeholder="Hasil pemeriksaan oleh terapis" rows="3" cols="" id="floatingTextarea" required><?= $datahasil["hasilPemeriksaan"]; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="areaTubuh">Area Tubuh <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="areaTubuh" id="areaTubuh" value="<?= $datahasil["areaTubuh"]; ?>" placeholder="Area tubuh yang diterapi" maxlength="255" size="" required>
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
                            </td>
                            <td>
                            <?php
                                // delete
                                $datadelete = array(
                                    array("idHasilLayanan", $datahasil["idHasilLayanan"], "hasil_layanan")
                                );
                                _CreateWindowModalDelete($datahasil["idHasilLayanan"], "del", "del-form", "del-button", "lg", 200, "HAPUS#JADWAL FISIOTERAPI " . $datahasil["idHasilLayanan"] . "#" . $datahasil["namaLengkap"] . " - " . $datahasil["tanggalKegiatan"], "", $datadelete, "", "$linkurl");
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