<?php
// session_start();
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cUpdate.php");
include_once("../_function_i/inc_f_object.php");

$request = $_SERVER['REQUEST_URI'];
$request = trim($request, '/');
$segments = explode('/', $request);

// Ambil idPasien dari session jika tersedia
if (isset($_POST['idPasien'])) {
    $_SESSION['idPasien'] = $_POST['idPasien']; // Simpan ke session
}

// Ambil dari session
$idPasien = $_SESSION['idPasien'] ?? null;

// Jika idPasien tidak ditemukan, kembalikan ke halaman sebelumnya
if (!$idPasien) {
    die("ID Pasien tidak ditemukan.");
}

$conn = new cConnect();
$conn->goConnect();

$view = new cView();

// Ambil ID User dari sesi atau database
$idUser = $_SESSION['idUser'] ?? null;
if (!$idUser) {
    $sqlUser = "SELECT idUser FROM user LIMIT 1"; 
    $dataUser = $view->vViewData($sqlUser);
    $idUser = $dataUser[0]["idUser"] ?? null;
}

// Query data
$sqlPasien = "SELECT p.*, sd.*, jd.* FROM pasien p
            JOIN sub_disabilitas sd ON sd.idSubDisabilitas = p.idSubDisabilitas
            JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas
            WHERE p.idPasien = $idPasien";

$datahasil = $view->vViewData($sqlPasien);

if (empty($datahasil)) {
    die("Data tidak ditemukan.");
}

$datahasil = $datahasil[0]; // Ambil hasil pertama
?>

<style>
    .button-container {
        display: flex;
        gap: 10px; /* Jarak antara tombol */
    }
</style>

<div class="row mx-2">
    <div class="col-md-1" style="width: min-content; align-content: center;">
        <a href="../admin/41"><ion-icon name="chevron-back-outline" size="large" style="color: black;"></ion-icon></a>
    </div>
    <div class="col-md-11">
        <?php _myHeader("DETAIL REKAM MEDIS PASIEN " . strtoupper($datahasil['namaLengkap']), "Detail Hasil Rekam Medis"); ?>
    </div>
</div>

<!-- Form Pencarian -->
<div class="row mx-2 mt-5">
    <div class="col-md-12">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Mulai</span>
                        <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai">
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Sampai</span>
                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 5%; height: fit-content;" name="searchbtn" value="true"><b>CARI</b></button>
            </div>
        </form>
    </div>
</div>

<div class="row mx-2">
    <div class="col-md-12">
        <?php

        // Ambil tanggal dari form jika ada
        $tanggalMulai = $_POST['tanggalMulai'] ?? null;
        $tanggalSelesai = $_POST['tanggalSelesai'] ?? null;

        // Query daftar program layanan yang telah diikuti pasien
        $sqlhasil = "SELECT hasil.*, jp.*, pr.*, p.*, t.*
                    FROM hasil_layanan hasil 
                    JOIN jadwal_program jp ON jp.idJadwal = hasil.idJadwal 
                    JOIN program pr ON pr.idProgram = jp.idProgram
                    JOIN pasien p ON p.idPasien = hasil.idPasien
                    JOIN terapis t ON t.idTerapis = hasil.idTerapis
                    WHERE hasil.idPasien = '$idPasien'";
        
        // Tambahkan filter tanggal jika diisi
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $sqlhasil .= " AND jp.tanggalKegiatan BETWEEN '$tanggalMulai' AND '$tanggalSelesai'";
        } elseif (!empty($tanggalMulai)) {
            $sqlhasil .= " AND jp.tanggalKegiatan >= '$tanggalMulai'";
        } elseif (!empty($tanggalSelesai)) {
            $sqlhasil .= " AND jp.tanggalKegiatan <= '$tanggalSelesai'";
        }

        $sqlhasil .= "ORDER BY jp.tanggalKegiatan DESC";

        // Eksekusi query
        $arrayhasil = $view->vViewData($sqlhasil);
        ?>
        <div id="" class='table-responsive'>
            <table id='example' class='table table-condensed'>
                <thead>
                    <tr>
                        <th width='5%' class="text-right">No.</th>
                        <th width='10%'>Tanggal</th>
                        <th width=''>Program Layanan</th>
                        <th width=''>Terapis</th>
                        <th width='20%'>Keluhan</th>
                        <th width='10%'>Diagnosis</th>
                        <th width='20%'>Rencana Tindakan</th>
                        <th width='5%'>DETAIL</th>
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
                            <td><?= $datahasil["tanggalKegiatan"]; ?></td>
                            <td><?= $datahasil["namaProgram"]; ?></td>
                            <td><?= $datahasil["namaTerapis"]; ?></td>
                            <td><?= $datahasil["keluhan"]; ?></td>
                            <td><?= $datahasil["diagnosis"]; ?></td>
                            <td><?= $datahasil["catatanTindakan"]; ?></td>
                            <td>
                            <?php
                                // Ambil idHasilLayanan dari data hasil layanan yang sedang di-loop
                                $idHasilLayanan = $datahasil["idHasilLayanan"];
                                $linkurl = "detailRekamMedis.php?idHasilLayanan=" . $idHasilLayanan;

                                // Query untuk mengambil idProgram berdasarkan idHasilLayanan
                                $sqlProgram = "SELECT jp.idProgram 
                                            FROM hasil_layanan hl
                                            JOIN jadwal_program jp ON hl.idJadwal = jp.idJadwal
                                            WHERE hl.idHasilLayanan = '$idHasilLayanan'";
                                $view = new cView();
                                $dataProgram = $view->vViewData($sqlProgram);

                                if (!empty($dataProgram)) {
                                    $idProgram = $dataProgram[0]["idProgram"];
                                } else {
                                    $idProgram = null; // Jika tidak ada data
                                }

                                // Menentukan tampilan detail berdasarkan idProgram
                                switch ($idProgram) {
                                    case '1': // Detail Fisioterapi
                                        $datadetail = array(
                                            array("NAMA TERAPIS", "namaTerapis", $datahasil["namaTerapis"], 1),
                                            array("KELUHAN", "keluhan", $datahasil["keluhan"], 1),
                                            array("HASIL PEMERIKSAAN", "hasilPemeriksaan", $datahasil["hasilPemeriksaan"], 1),
                                            array("AREA TUBUH YANG DITERAPI", "areaTubuh", $datahasil["areaTubuh"], 1),
                                            array("DIAGNOSIS", "diagnosis", $datahasil["diagnosis"], 1),
                                            array("CATATAN RENCANA TINDAKAN", "catatanTindakan", $datahasil["catatanTindakan"], 1),
                                        );
                                        _CreateWindowModalDetil($datahasil["idHasilLayanan"], "view", "viewsasaran-form", "viewsasaran-button", "", 600, "DETAIL#HASIL FISIOTERAPI", "", $datadetail, "", $linkurl, "");
                                        break;

                                    case '2': // Detail Kinesioterapi
                                        $datadetail = array(
                                            array("NAMA TERAPIS", "namaTerapis", $datahasil["namaTerapis"], 1),
                                            array("KELUHAN", "keluhan", $datahasil["keluhan"], 1),
                                            array("TINGKAT NYERI", "tingkatNyeri", $datahasil["tingkatNyeri"], 1),
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
                                        _CreateWindowModalDetil($datahasil["idHasilLayanan"], "view", "viewsasaran-form", "viewsasaran-button", "", 600, "DETAIL#HASIL KINESIOTERAPI", "", $datadetail, "", $linkurl, "");
                                        break;

                                    default:
                                        echo "<p>Detail layanan tidak ditemukan.</p>";
                                        break;
                                }
                            ?>
                            </td>    
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="button-container">
                <form method="post" action="export_pdfdetail.php" target="_new">
                    <input type="hidden" name="tanggalMulai" value="<?= $_POST["tanggalMulai"] ?? ''; ?>">
                    <input type="hidden" name="tanggalSelesai" value="<?= $_POST["tanggalSelesai"] ?? ''; ?>">
                    <input type="hidden" name="idPasien" value="<?= $idPasien; ?>">
                    <button type="submit" name="export_pdfdetail" class="btn btn-danger">CETAK PDF</button>
                </form>
                <form method="post" action="export_exceldetail.php">
                    <input type="hidden" name="tanggalMulai" value="<?= $_POST["tanggalMulai"] ?? ''; ?>">
                    <input type="hidden" name="tanggalSelesai" value="<?= $_POST["tanggalSelesai"] ?? ''; ?>">
                    <input type="hidden" name="idPasien" value="<?= $idPasien; ?>">
                    <button type="submit" name="export_exceldetail" class="btn btn-success">CETAK EXCEL</button>
                </form>
            </div>
            
            <?php
                if(isset($_POST['export_pdfdetail'])){
                    header("location export_pdfdetail.php");
                }
            ?>
            <br><br><br>
        </div>
    </div>
</div>


