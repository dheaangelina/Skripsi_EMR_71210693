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
// Perbarui query dengan alias untuk jenisKelamin agar tidak terjadi duplikasi
$sql = "SELECT p.*, sd.*, jd.* FROM pasien p
        JOIN sub_disabilitas sd ON sd.idSubDisabilitas = p.idSubDisabilitas
        JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas";

$where = [];

// Filter Kelompok Usia
// Cek apakah variabel POST "kelompokUsia" tidak kosong
if (!empty($_POST["kelompokUsia"])) {
    // Simpan nilai dari input "kelompokUsia" ke dalam variabel $selectedUsia
    $selectedUsia = $_POST["kelompokUsia"];
    // Periksa apakah nilai $selectedUsia berupa array (artinya pengguna memilih lebih dari satu opsi)
    if (is_array($selectedUsia)) {
        // Menghapus spasi ekstra dari setiap elemen dalam array $selectedUsia
        $selectedUsia = array_map('trim', $selectedUsia);
        // Menggabungkan elemen array menjadi sebuah string dengan format: 'nilai1','nilai2',...
        $usia_in = implode("','", $selectedUsia);
        // Menambahkan kondisi ke array $where menggunakan operator IN untuk mencocokkan beberapa nilai
        $where[] = "p.kelompokUsia IN ('" . $usia_in . "')";
    } else {
        // Jika $selectedUsia bukan array (hanya satu nilai yang dipilih)
        // Menambahkan kondisi ke array $where dengan mencocokkan nilai secara langsung setelah menghapus spasi ekstra
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

// Jika ada filter yang dipilih, gabungkan dengan operator AND dan tambahkan ke query SQL
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY p.idPasien;";

// Eksekusi Query
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

// Ambil daftar jenis disabilitas
$disabilitasQuery = "SELECT DISTINCT jenisDisabilitas FROM jenis_disabilitas";
$enumDisabilitas = $view->vViewData($disabilitasQuery);
?>

<!-- Form Pencarian -->
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
            </div>
            <br>
            <button type="submit" class="btn btn-primary" style="width: 15%;" name="searchbtn" value="true"><b>CARI</b></button>
        </form>
    </div>
</div>

<!-- Tabel Hasil -->
<div class="row mx-2">
    <div class="col-md-12">
        <br><br>
        <div class="table-responsive">
            <div class="hasil-filtering" id="hasilFilter">
                <table id='example' class='table table-condensed'>
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center" width="12%">Usia</th>
                            <th class="text-center" width="3%">Golongan Darah</th>
                            <th class="text-center" width="15%">Alamat</th>
                            <th class="text-center" width="5%">Jenis Disabilitas</th>
                            <th class="text-center">Sub Jenis Disabilitas</th>
                            <th class="text-center">Alat Bantu</th>
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
            
            <br><br><br>
        </div>
    </div>
</div> 