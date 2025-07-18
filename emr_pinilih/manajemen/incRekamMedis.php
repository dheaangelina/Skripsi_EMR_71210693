<?php
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cInsert.php");
include_once("../_function_i/cUpdate.php");
include_once("../_function_i/cDelete.php");
include_once("../_function_i/inc_f_object.php");
?>

<style>
    .button-container {
        display: flex;
        gap: 10px; /* Jarak antara tombol */
    }
</style>

<div class="row mx-2">
    <div class="col-md-11">
        <?php
        _myHeader("MENU REKAM MEDIS", "Data Rekam Medis");
        ?>
    </div>

<?php
// Proses Filtering Data
$sql = "SELECT p.*, sd.*, jd.*, k.namaKelurahan 
        FROM pasien p
        JOIN sub_disabilitas sd ON sd.idSubDisabilitas = p.idSubDisabilitas
        JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas
        LEFT JOIN kelurahan k ON k.idKelurahan = p.idKelurahanDomisili";
$where = [];

// Filter Kelompok Usia
if (!empty($_POST["kelompokUsia"])) {
    $selectedUsia = $_POST["kelompokUsia"];
    if (is_array($selectedUsia)) {
        $selectedUsia = array_map('trim', $selectedUsia);
        $usia_in = implode("','", $selectedUsia);
        $where[] = "p.kelompokUsia IN ('" . $usia_in . "')";
    } else {
        $where[] = "p.kelompokUsia = '" . trim($_POST["kelompokUsia"]) . "'";
    }
}


// Filter Jenis Kelamin
if (!empty($_POST["jenisKelamin"])) {
    $selectedJK = $_POST["jenisKelamin"];
    if (is_array($selectedJK)) {
        $selectedJK = array_map('trim', $selectedJK);
        $jk_in = implode("','", $selectedJK);
        $where[] = "p.jenisKelamin IN ('" . $jk_in . "')";
    } else {
        $where[] = "p.jenisKelamin = '" . trim($_POST["jenisKelamin"]) . "'";
    }
}

// Filter Golongan Darah
if (!empty($_POST["golonganDarah"])) {
    $selectedGoldar = $_POST["golonganDarah"];
    if (is_array($selectedGoldar)) {
        $selectedGoldar = array_map('trim', $selectedGoldar);
        $goldar_in = implode("','", $selectedGoldar);
        $where[] = "p.golonganDarah IN ('" . $goldar_in . "')";
    } else {
        $where[] = "p.golonganDarah = '" . trim($_POST["golonganDarah"]) . "'";
    }
}

// Filter Jenis Disabilitas
if (!empty($_POST["jenisDisabilitas"])) {
    $selectedDisabilitas = $_POST["jenisDisabilitas"];
    if (is_array($selectedDisabilitas)) {
        $selectedDisabilitas = array_map('trim', $selectedDisabilitas);
        $disabilitas_in = implode("','", $selectedDisabilitas);
        $where[] = "jd.jenisDisabilitas IN ('" . $disabilitas_in . "')";
    } else {
        $where[] = "jd.jenisDisabilitas = '" . trim($_POST["jenisDisabilitas"]) . "'";
    }
}
// Filter Kelurahan (khusus Sedayu, ID 40579–40582)
if (!empty($_POST["idKelurahan"])) {
    $where[] = "p.idKelurahanDomisili = '" . intval($_POST["idKelurahan"]) . "'";
}

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY p.idPasien;";

$view = new cView();
$arrayhasil = $view->vViewData($sql);
?>

<?php
// Query ENUM 'kelompokUsia'
$usia = "SHOW COLUMNS FROM pasien LIKE 'kelompokUsia'";
$arrayUsia = $view->vViewData($usia);
$enumKelompokUsia = [];
if (!empty($arrayUsia)) {
    $row = $arrayUsia[0];
    if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
        $enumKelompokUsia = explode(",", str_replace("'", "", $matches[1]));
    }
}

// Query ENUM 'jenisKelamin'
$jk = "SHOW COLUMNS FROM pasien LIKE 'jenisKelamin'";
$arrayJK = $view->vViewData($jk);
$enumJK = [];
if (!empty($arrayJK)) {
    $row = $arrayJK[0];
    if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
        $enumJK = explode(",", str_replace("'", "", $matches[1]));
    }
}

// Query ENUM 'golonganDarah'
$goldar = "SHOW COLUMNS FROM pasien LIKE 'golonganDarah'";
$arrayGoldar = $view->vViewData($goldar);
$enumGoldar = [];
if (!empty($arrayGoldar)) {
    $row = $arrayGoldar[0];
    if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
        $enumGoldar = explode(",", str_replace("'", "", $matches[1]));
    }
}

// Daftar jenis disabilitas
$disabilitasQuery = "SELECT DISTINCT jenisDisabilitas FROM jenis_disabilitas";
$enumDisabilitas = $view->vViewData($disabilitasQuery);

// Daftar kelurahan dengan id tertentu
$kelurahanQuery = "SELECT idKelurahan, namaKelurahan FROM kelurahan WHERE idKelurahan BETWEEN 40579 AND 40582";
$kelurahanList = $view->vViewData($kelurahanQuery);
?>

<!-- FILTERING -->
<div class="row">
    <div class="col-md-12">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-4">
                    <label for="kelompokUsia">KELOMPOK USIA</label>
                    <select name="kelompokUsia" class="form-control">
                        <option value="">- pilihan -</option>
                        <?php foreach ($enumKelompokUsia as $option) {
                            echo '<option value="' . trim($option) . '">' . trim($option) . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="jenisKelamin">JENIS KELAMIN</label>
                    <select name="jenisKelamin" class="form-control">
                        <option value="">- pilihan -</option>
                        <?php foreach ($enumJK as $option) {
                            echo '<option value="' . trim($option) . '">' . trim($option) . '</option>';
                        } ?>
                    </select>
                </div>
                <div><br></div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="golonganDarah">GOLONGAN DARAH</label>
                    <select name="golonganDarah" class="form-control">
                        <option value="">- pilihan -</option>
                        <?php foreach ($enumGoldar as $option) {
                            echo '<option value="' . trim($option) . '">' . trim($option) . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="jenisDisabilitas">JENIS DISABILITAS</label>
                    <select name="jenisDisabilitas" class="form-control">
                        <option value="">- pilihan -</option>
                        <?php foreach ($enumDisabilitas as $row) {
                            echo '<option value="' . trim($row["jenisDisabilitas"]) . '">' . trim($row["jenisDisabilitas"]) . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="idKelurahan">KELURAHAN (Sedayu)</label>
                    <select name="idKelurahan" class="form-control">
                        <option value="">- pilihan -</option>
                        <?php foreach ($kelurahanList as $row) {
                            echo '<option value="' . $row["idKelurahan"] . '">' . $row["namaKelurahan"] . '</option>';
                        } ?>
                    </select>
                </div>
                <br>
                <p></p>
            <br>
            <button type="submit" class="btn btn-primary" style="width: 15%; margin-left: 10px;" name="searchbtn" value="true"><b>CARI</b></button>
        </form>
    </div>
</div>

<!-- Tabel Hasil -->
<div class="row">
    <div class="col-md-12">
        <br><br>
        <div class="table-responsive">
            <div class="hasil-filtering" id="hasilFilter">
                <table id='example' class='table table-condensed'>
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th class="text-center" width="">Nama Pasien</th>
                            <th class="text-center" width="">Jenis Kelamin</th>
                            <th class="text-center" width="">Usia</th>
                            <th class="text-center" width="">Golongan Darah</th>
                            <th class="text-center" width="5%">Alamat</th>
                            <th class="text-center" width="">Kelurahan</th>
                            <th class="text-center" width="">Jenis Disabilitas</th>
                            <th class="text-center" width="">Sub Jenis Disabilitas</th>
                            <th class="text-center" width="">Alat Bantu</th>
                            <th width="5%">DETAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnourut = 0;
                        foreach ($arrayhasil as $data) {
                            $cnourut++;
                        ?>
                            <tr>
                                <td class="text-right"><?= $cnourut; ?></td>
                                <td><?= $data["namaLengkap"]; ?></td> 
                                <td><?= $data["jenisKelamin"]; ?></td>
                                <td><?= $data["kelompokUsia"]; ?></td>
                                <td><?= $data["golonganDarah"]; ?></td>
                                <td><?= $data["alamatDomisili"]; ?></td>
                                <td><?= $data["namaKelurahan"]; ?></td>
                                <td><?= $data["jenisDisabilitas"]; ?></td>
                                <td><?= $data["namaDisabilitas"]; ?></td>
                                <td><?= $data["alatBantu"]; ?></td>
                                <td>
                                    <form method="post" action="411">
                                        <input type="hidden" name="idPasien" value="<?= $data["idPasien"]; ?>">
                                        <button type="submit" class="btn btn-info" style="border-radius: 8px;">
                                            <i class="fa-regular fa-eye" style="color: #000000;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
                
            <div class="button-container">
                <form method="post" action="export_pdf.php" target="_new">
                    <input type="hidden" name="kelompokUsia" value="<?= $_POST["kelompokUsia"] ?? ''; ?>">
                    <input type="hidden" name="jenisKelamin" value="<?= $_POST["jenisKelamin"] ?? ''; ?>">
                    <input type="hidden" name="golonganDarah" value="<?= $_POST["golonganDarah"] ?? ''; ?>">
                    <input type="hidden" name="jenisDisabilitas" value="<?= $_POST["jenisDisabilitas"] ?? ''; ?>">
                    <input type="hidden" name="idKelurahan" value="<?= $_POST["idKelurahan"] ?? ''; ?>">
                    <button type="submit" name="export_pdf" class="btn btn-danger">CETAK PDF</button>
                </form>
                <form method="post" action="export_excel.php">
                    <input type="hidden" name="kelompokUsia" value="<?= $_POST["kelompokUsia"] ?? ''; ?>">
                    <input type="hidden" name="jenisKelamin" value="<?= $_POST["jenisKelamin"] ?? ''; ?>">
                    <input type="hidden" name="golonganDarah" value="<?= $_POST["golonganDarah"] ?? ''; ?>">
                    <input type="hidden" name="jenisDisabilitas" value="<?= $_POST["jenisDisabilitas"] ?? ''; ?>">
                    <input type="hidden" name="idKelurahan" value="<?= $_POST["idKelurahan"] ?? ''; ?>">
                    <button type="submit" name="export_excel" class="btn btn-success">CETAK EXCEL</button>
                </form>
            </div>
            <br><br><br>
        </div>
    </div>
</div> 