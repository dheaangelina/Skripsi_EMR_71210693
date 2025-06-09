<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr';

$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
?>

<?php
// insert
if (!empty($_POST["savebtn"])) {
    $linkurl = 21;

    $idSubDisabilitas = $_POST["subDisabilitas"];
    $idKelurahanDomisili = !empty($_POST['kelurahan']) ? $_POST['kelurahan'] : NULL;
    $kodePosDomisili = !empty($_POST["kodePosDomisili"]) ? $_POST["kodePosDomisili"] : NULL;
    $RTDomisili = !empty($_POST["RTDomisili"]) ? $_POST["RTDomisili"] : NULL;
    $RWDomisili = !empty($_POST["RWDomisili"]) ? $_POST["RWDomisili"] : NULL;
    $alasanTidakAktif = isset($_POST["alasanTidakAktif"]) ? $_POST["alasanTidakAktif"] : ""; 

    if (!empty($_POST["riwayatPenyakitPribadi"])) {
        $riwayatPenyakitPribadi = implode(", ", $_POST["riwayatPenyakitPribadi"]);
    } else {
        $riwayatPenyakitPribadi = "";
    }
    if (!empty($_POST["riwayatPenyakitKeluarga"])) {
        $riwayatPenyakitKeluarga = implode(", ", $_POST["riwayatPenyakitKeluarga"]); 
    } else {
        $riwayatPenyakitKeluarga = ""; 
    }

    $datafield_pasien = array("namaLengkap", "namaPanggilan", "nik", "tempatLahir", "tanggalLahir", "kelompokUsia", "jenisKelamin", "golonganDarah", "noTeleponPasien", "alamatLengkap", "alamatDomisili", "tanggalAktif", "statusPasien", "alasanTidakAktif", "idSubDisabilitas", "alatBantu", "kebutuhanKhusus", "riwayatPenyakitPribadi", "riwayatPenyakitKeluarga", "alergi", "trauma", "namaOrangTua", "noTelpOrangTua", "namaPendamping", "noTelpPendamping", "namaJalan", "idKelurahanDomisili", "kodePosDomisili", "RTDomisili", "RWDomisili", "agama", "suku", "bahasaDikuasai", "pendidikan", "pekerjaan", "statusPernikahan", "keterangan");

    // value
    $datavalue_pasien = array('"' . $_POST["namaLengkap"] . '"', '"' . $_POST["namaPanggilan"] . '"', '"' . $_POST["nik"] . '"', '"' . $_POST["tempatLahir"] . '"', '"'. $_POST["tanggalLahir"] .'"', '"' . $_POST["kelompokUsia"] . '"', '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["golonganDarah"] . '"', '"' . $_POST["noTeleponPasien"] . '"', '"' . $_POST["alamatLengkap"] . '"', '"' . $_POST["alamatDomisili"] . '"', '"'. $_POST["tanggalAktif"] .'"', '"'. $_POST["statusPasien"] .'"', '"' . $alasanTidakAktif . '"', $idSubDisabilitas, '"' . $_POST["alatBantu"] . '"', '"' . $_POST["kebutuhanKhusus"] . '"', '"' . $riwayatPenyakitPribadi . '"', '"' . $riwayatPenyakitKeluarga . '"', '"' . $_POST["alergi"] . '"', '"' . $_POST["trauma"] . '"', '"' . $_POST["namaOrtu"] . '"', '"' . $_POST["noTelpOrtu"] . '"', '"' . $_POST["namaPendamping"] . '"', '"' . $_POST["noTelpPendamping"] . '"', '"' . $_POST["namaJalan"] . '"', $idKelurahanDomisili !== NULL ? $idKelurahanDomisili : "NULL", $kodePosDomisili !== NULL ? $kodePosDomisili : "NULL", $RTDomisili !== NULL ? $RTDomisili : "NULL", $RWDomisili !== NULL ? $RWDomisili : "NULL", '"' . $_POST["agama"] . '"', '"' . $_POST["suku"] . '"', '"' . $_POST["bahasaDikuasai"] . '"', '"' . $_POST["pendidikan"] . '"', '"' . $_POST["pekerjaan"] . '"', '"' . $_POST["statusPernikahan"] . '"', '"' . $_POST["keterangan"] . '"');

    $insert = new cInsert();
    // $insert->vInsertDataTrial($datafield_pasien, "pasien", $datavalue_pasien, $linkurl);
    $insert->vInsertData($datafield_pasien, "pasien", $datavalue_pasien, $linkurl);
}
?>

<?php
// update
if (!empty($_POST["editbtn"])) {
    $linkurl = 21;

    $idPasien = $_POST["idPasien"];
    $idSubDisabilitas = !empty($_POST["subDisabilitas"]) ? (is_array($_POST["subDisabilitas"]) ? implode(",", $_POST["subDisabilitas"]) : $_POST["subDisabilitas"]) : "NULL";

    $idKelurahanDomisili = !empty($_POST["kelurahan"][$idPasien]) ? $_POST["kelurahan"][$idPasien] : NULL;
    $kodePosDomisili = !empty($_POST["kodePosDomisili"]) ? $_POST["kodePosDomisili"] : NULL;
    $RTDomisili = !empty($_POST["RTDomisili"]) ? $_POST["RTDomisili"] : NULL;
    $RWDomisili = !empty($_POST["RWDomisili"]) ? $_POST["RWDomisili"] : NULL;
    
    if (!empty($_POST["riwayatPenyakitPribadi"])) {
        $riwayatPenyakitPribadi = implode(", ", $_POST["riwayatPenyakitPribadi"]); 
    } else {
        $riwayatPenyakitPribadi = "";
    }
    if (!empty($_POST["riwayatPenyakitKeluarga"])) {
        $riwayatPenyakitKeluarga = implode(", ", $_POST["riwayatPenyakitKeluarga"]);
    } else {
        $riwayatPenyakitKeluarga = ""; 
    }

    $statusPasien = isset($_POST["statusPasien"]) ? $_POST["statusPasien"] : "0"; 
    $alasanTidakAktif = isset($_POST["alasanTidakAktif"]) ? $_POST["alasanTidakAktif"] : ""; 

    $datafield_pasien = array("namaLengkap", "namaPanggilan", "nik", "tempatLahir", "tanggalLahir", "kelompokUsia", "jenisKelamin", "golonganDarah", "noTeleponPasien", "alamatLengkap", "alamatDomisili", "tanggalAktif", "statusPasien", "alasanTidakAktif", "idSubDisabilitas", "alatBantu", "kebutuhanKhusus", "riwayatPenyakitPribadi", "riwayatPenyakitKeluarga", "alergi", "trauma", "namaOrangTua", "noTelpOrangTua", "namaPendamping", "noTelpPendamping", "namaJalan", "idKelurahanDomisili", "kodePosDomisili", "RTDomisili", "RWDomisili", "agama", "suku", "bahasaDikuasai", "pendidikan", "pekerjaan", "statusPernikahan", "keterangan");
    $datavalue_pasien = array('"' . $_POST["namaLengkap"] . '"', '"' . $_POST["namaPanggilan"] . '"', '"' . $_POST["nik"] . '"', '"' . $_POST["tempatLahir"] . '"', '"'. $_POST["tanggalLahir"] .'"', '"' . $_POST["kelompokUsia"] . '"', '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["golonganDarah"] . '"', '"' . $_POST["noTeleponPasien"] . '"', '"' . $_POST["alamatLengkap"] . '"', '"' . $_POST["alamatDomisili"] . '"', '"'. $_POST["tanggalAktif"] .'"', '"' . $statusPasien . '"', '"' . $alasanTidakAktif . '"', $idSubDisabilitas, '"' . $_POST["alatBantu"] . '"', '"' . $_POST["kebutuhanKhusus"] . '"', '"' . $riwayatPenyakitPribadi . '"', '"' . $riwayatPenyakitKeluarga . '"', '"' . $_POST["alergi"] . '"', '"' . $_POST["trauma"] . '"', '"' . $_POST["namaOrtu"] . '"', '"' . $_POST["noTelpOrtu"] . '"', '"' . $_POST["namaPendamping"] . '"', '"' . $_POST["noTelpPendamping"] . '"', '"' . $_POST["namaJalan"] . '"', $idKelurahanDomisili !== NULL ? $idKelurahanDomisili : "NULL", $kodePosDomisili !== NULL ? $kodePosDomisili : "NULL", $RTDomisili !== NULL ? $RTDomisili : "NULL", $RWDomisili !== NULL ? $RWDomisili : "NULL", 
    "'" . $_POST["agama"] . "'", '"' . $_POST["suku"] . '"', '"' . $_POST["bahasaDikuasai"] . '"', '"' . $_POST["pendidikan"] . '"', '"' . $_POST["pekerjaan"] . '"', '"' . $_POST["statusPernikahan"] . '"', '"' . $_POST["keterangan"] . '"');

    $datakey = ' idPasien =' . $_POST["idPasien"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_pasien, "pasien", $datavalue_pasien, $datakey, $linkurl);
    $update->vUpdateData($datafield_pasien, "pasien", $datavalue_pasien, $datakey, $linkurl);
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
    // Query ENUM 'kelompokUsia'
    $usia = "SHOW COLUMNS FROM pasien LIKE 'kelompokUsia'";
    $view = new cView();
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
    $view = new cView();
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
    $view = new cView();
    $arrayGoldar = $view->vViewData($goldar);
    $enumGoldar = [];
    if (!empty($arrayGoldar)) {
        $row = $arrayGoldar[0];
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
        $row = $arrayAgama[0];
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
        $row = $arrayPendidikan[0];
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
        $row = $arrayPekerjaan[0];
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
        $row = $arrayStatusNikah[0];
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
    
    <script src="../admin/js/jquery.min.js" type="text/javascript"></script>
    <script src="../admin/js/config.js?v=<?php echo time(); ?>" type="text/javascript"></script>

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
                                        <p>Tambah Data Pasien</p>
                                    </blockquote>
                                </h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="" method="post" action="21" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="namaLengkap">Nama Lengkap Pasien <span class="required">*</span></label>
                                            <input class="form-control" type="text" name="namaLengkap" id="namaLengkap" value="" placeholder="Nama lengkap pasien" maxlength="255" size="" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="namaPanggilan">Nama Panggilan <span class="required">*</span></label>
                                            <input class="form-control" type="text" name="namaPanggilan" id="namaPanggilan" value="" placeholder="Nama panggilan pasien" maxlength="255" size="" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik">NIK <span class="required">*</span></label>
                                        <input class="form-control" type="number" name="nik" id="nik" value="" placeholder="NIK Pasien" maxlength="255" size="" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="tempatLahir">Tempat Lahir <span class="required">*</span></label>
                                            <input class="form-control" type="text" name="tempatLahir" id="tempatLahir" value="" placeholder="Tempat lahir pasien" maxlength="255" size="" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="tanggalLahir">Tanggal Lahir <span class="required">*</span></label>
                                            <input class="form-control" type="date" name="tanggalLahir" id="tanggalLahir" value="" placeholder="Tanggal lahir pasien" maxlength="" size="" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelompokUsia">Kelompok Usia <span class="required">*</span></label>
									    <select name="kelompokUsia" class="form-control" required>
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumKelompokUsia as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
										</select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="jenisKelamin">Jenis Kelamin <span class="required">*</span></label>
                                            <select name="jenisKelamin" class="form-control" required>
                                                <option value="">- pilihan -</option>
                                                <?php
                                                    foreach ($enumJK as $option) {
                                                        $trimmedValue = trim($option);
                                                        echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="golonganDarah">Golongan Darah <span class="required">*</span></label>
                                            <select name="golonganDarah" class="form-control" required>
                                                <option value="">- pilihan -</option>
                                                <?php
                                                    foreach ($enumGoldar as $option) {
                                                        $trimmedValue = trim($option);
                                                        echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="noTeleponPasien">Nomor Telepon Pasien <span class="required">*</span></label>
                                        <input class="form-control" type="number" name="noTeleponPasien" id="noTeleponPasien" value="" placeholder="Nomor telepon pasien" maxlength="16" size="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamatLengkap">Alamat Lengkap (sesuai KTP) <span class="required">*</span></label>
                                        <textarea class="form-control" id="alamatLengkap" name="alamatLengkap" placeholder="Alamat lengkap sesuai KTP" rows="3" cols="" id="floatingTextarea" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamatDomisili">Alamat Lengkap Domisili <span class="required">*</span></label>
                                        <textarea class="form-control" id="alamatDomisili" name="alamatDomisili" placeholder="Alamat lengkap domisili" rows="3" cols="" id="floatingTextarea"required ></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggalAktif">Tanggal Mulai Aktif <span class="required">*</span></label>
                                        <input class="form-control" type="date" name="tanggalAktif" id="tanggalAktif" value="" placeholder="Tanggal pasien mulai aktif" maxlength="" size="" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="statusPasien">Status Pasien <span class="required">*</span></label>
                                            <select name="statusPasien" class="form-control" id="statusPasien" required>
                                                <option value="">- pilihan -</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="alasanTidakAktif">Alasan Tidak Aktif</label>
                                            <input class="form-control" type="text" name="alasanTidakAktif" id="alasanTidakAktif" value="" placeholder="Alasan pasien tidak aktif" maxlength="255" disabled>
                                        </div>
                                        <script>
                                            document.getElementById("statusPasien").addEventListener("change", function () {
                                                var alasanInput = document.getElementById("alasanTidakAktif");
                                                if (this.value === "Tidak Aktif") {
                                                    alasanInput.removeAttribute("disabled"); // Aktifkan input jika "Tidak Aktif"
                                                } else {
                                                    alasanInput.setAttribute("disabled", "true"); // Nonaktifkan input jika "Aktif"
                                                    alasanInput.value = ""; // Kosongkan input ketika dinonaktifkan
                                                }
                                            });
                                        </script>

                                        <div class="col-6 mb-3">
                                            <label for="jenisDisabilitas">Jenis Disabilitas <span class="required">*</span></label>
                                            <select name="jenisDisabilitas" id="jenisDisabilitas" class="form-control" required>
                                                <option value="">- pilihan -</option>
                                                
                                                <?php                                
                                                // Buat query untuk menampilkan semua data siswa
                                                $sql = $pdo->prepare("SELECT * FROM jenis_disabilitas ORDER BY idJenisDisabilitas");
                                                $sql->execute(); // Eksekusi querynya
                                                
                                                while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
                                                    echo "<option value='".$data['idJenisDisabilitas']."'>".$data['jenisDisabilitas']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="subDisabilitas">Sub Jenis Disabilitas <span class="required">*</span></label>
                                            <select name="subDisabilitas" id="subDisabilitas" class="form-control" required>
                                                <option value="">- pilihan -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="alatBantu">Alat Bantu</label>
                                            <textarea class="form-control" id="alatBantu" name="alatBantu" placeholder="Alat bantu yang dibutuhkan pasien" rows="3" cols="" id="floatingTextarea"></textarea>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="kebutuhanKhusus">Kebutuhan Khusus</label>
                                            <textarea class="form-control" id="kebutuhanKhusus" name="kebutuhanKhusus" placeholder="Kebutuhan khusus yang mendukung kenyamanan pasien" rows="3" cols="" id="floatingTextarea"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="riwayatPenyakitPribadi">Riwayat Penyakit Pribadi</label><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Diabetes Mellitus" id="diabetes">
                                                    <label class="form-check-label" for="diabetes">Diabetes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Hipertensi" id="hipertensi">
                                                    <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Jantung" id="jantung">
                                                    <label class="form-check-label" for="jantung">Jantung</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Kanker" id="kanker">
                                                    <label class="form-check-label" for="kanker">Kanker</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Rhematik" id="rhematik">
                                                    <label class="form-check-label" for="rhematik">Rhematik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Asma" id="asma">
                                                    <label class="form-check-label" for="asma">Asma</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Asam Lambung" id="asamLambung">
                                                    <label class="form-check-label" for="asamLambung">Asam Lambung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Lain-lain" id="lainlain">
                                                    <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="riwayatPenyakitKeluarga">Riwayat Penyakit Keluarga</label><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Diabetes Mellitus" id="diabetes">
                                                    <label class="form-check-label" for="diabetes">Diabetes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Hipertensi" id="hipertensi">
                                                    <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Jantung" id="jantung">
                                                    <label class="form-check-label" for="jantung">Jantung</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Kanker" id="kanker">
                                                    <label class="form-check-label" for="kanker">Kanker</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Rhematik" id="rhematik">
                                                    <label class="form-check-label" for="rhematik">Rhematik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Asma" id="asma">
                                                    <label class="form-check-label" for="asma">Asma</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Asam Lambung" id="asamLambung">
                                                    <label class="form-check-label" for="asamLambung">Asam Lambung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Lain-lain" id="lainlain">
                                                    <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="alergi">Alergi</label>
                                            <input class="form-control" type="text" name="alergi" id="alergi" value="" placeholder="Alergi pasien" maxlength="255" size="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="trauma">Trauma/Cedera</label>
                                            <input class="form-control" type="text" name="trauma" id="trauma" value="" placeholder="Trauma/Cedera pasien" maxlength="255" size="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="namaOrtu">Nama Orang Tua</label>
                                            <input class="form-control" type="text" name="namaOrtu" id="namaOrtu" value="" placeholder="Nama Orang Tua" maxlength="255" size="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="noTelpOrtu">Nomor Telepon Orang Tua</label>
                                            <input class="form-control" type="number" name="noTelpOrtu" id="noTelpOrtu" value="" placeholder="Nomor Telepon Orang Tua" maxlength="16" size="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="namaPendamping">Nama Pendamping</label>
                                            <input class="form-control" type="text" name="namaPendamping" id="namaPendamping" value="" placeholder="Nama Pendamping" maxlength="255" size="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="noTelpPendamping">Nomor Telepon Pendamping</label>
                                            <input class="form-control" type="number" name="noTelpPendamping" id="noTelpPendamping" value="" placeholder="Nomor Telepon Pendamping" maxlength="16" size="">
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-body border border-2">
                                            <p><strong>Alamat Domisili Pasien</strong></p> 
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label for="namaJalan">Nama Jalan</label>
                                                    <input class="form-control" type="text" name="namaJalan" id="namaJalan" value="" placeholder="Nama jalan" maxlength="255" size="">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="provinsi">Provinsi</label>
                                                    <select name="provinsi" id="provinsi" class="form-control">
                                                        <option value="">- pilihan -</option>
                                                        
                                                        <?php                                
                                                        $sql = $pdo->prepare("SELECT * FROM provinsi ORDER BY idProvinsi");
                                                        $sql->execute();
                                                        
                                                        while($data = $sql->fetch()){
                                                            echo "<option value='".$data['idProvinsi']."'>".$data['namaProvinsi']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="kotaKab">Kota / Kabupaten</label>
                                                    <select name="kotaKab" id="kotaKab" class="form-control">
                                                        <option value="">- pilihan -</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="kecamatan">Kecamatan</label>
                                                    <select name="kecamatan" id="kecamatan" class="form-control">
                                                        <option value="">- pilihan -</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="kelurahan">Kelurahan</label>
                                                    <select name="kelurahan" id="kelurahan" class="form-control">
                                                        <option value="">- pilihan -</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="kodePosDomisili">Kode Pos Domisili</label>
                                                    <input type="number" name="kodePosDomisili" value="" id="kodePosDomisili" class="form-control" placeholder="Kode Pos Domisili" maxlength="5" size="">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="RTDomisili">RT Domisili</label>
                                                    <input type="number" name="RTDomisili" value="" id="RTDomisili" class="form-control" placeholder="RT Domisili" maxlength="3" size="">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="RWDomisili">RW Domisili</label>
                                                    <input type="number" name="RWDomisili" value="" id="RWDomisili" class="form-control" placeholder="RW Domisili" maxlength="3" size="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6 my-3">
                                            <label for="agama">Agama</label>
                                            <select name="agama" class="form-control">
                                                <option value="">- pilihan -</option>
                                                <?php
                                                    foreach ($enumAgama as $option) {
                                                        $trimmedValue = trim($option);
                                                        echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 my-3">
                                            <label for="suku">Suku</label>
                                            <input class="form-control" type="text" name="suku" id="suku" value="" placeholder="Suku" maxlength="255" size="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bahasaDikuasai">Bahasa Dikuasai</label>
                                        <input class="form-control" type="text" name="bahasaDikuasai" id="bahasaDikuasai" value="" placeholder="Bahasa yang dikuasai pasien" maxlength="255" size="">
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="pendidikan">Pendidikan Terakhir</label>
                                            <select name="pendidikan" class="form-control">
                                                <option value="">- pilihan -</option>
                                                <?php
                                                    foreach ($enumPendidikan as $option) {
                                                        $trimmedValue = trim($option);
                                                        echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <select name="pekerjaan" class="form-control">
                                                <option value="">- pilihan -</option>
                                                <?php
                                                    foreach ($enumPekerjaan as $option) {
                                                        $trimmedValue = trim($option);
                                                        echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="statusPernikahan">Status Pernikahan</label>
									    <select name="statusPernikahan" class="form-control">
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumNikah as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
										</select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan / Catatan untuk pasien" rows="3" cols="" id="floatingTextarea"></textarea>
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

            <div class="row">
                <div class="col-md-12">
                <?php
                $sqlpasien = "SELECT p.*, sd.*, jd.*, prov.*, kk.*, kec.*, kel.* 
                                FROM pasien p
                                LEFT JOIN sub_disabilitas sd ON p.idSubDisabilitas = sd.idSubDisabilitas
                                LEFT JOIN jenis_disabilitas jd ON sd.idJenisDisabilitas = jd.idJenisDisabilitas
                                LEFT JOIN kelurahan kel ON p.idKelurahanDomisili = kel.idKelurahan
                                LEFT JOIN kecamatan kec ON kel.idKecamatan = kec.idKecamatan
                                LEFT JOIN kotakabupaten kk ON kec.idKotaKabupaten = kk.idKotaKabupaten
                                LEFT JOIN provinsi prov ON kk.idProvinsi = prov.idProvinsi
                                ORDER BY idPasien DESC;
                                ";
                $view = new cView();
                $arraypasien = $view->vViewData($sqlpasien);
                ?>
                <div id="" class='table-responsive'>
                    <table id="example" class="table table-condensed">
                        <thead>
                            <tr class=''>
                                <th width='5%'>No.</th>
                                <th width='17%'>Nama Pasien</th>
                                <th width='18%'>Usia</th>
                                <th width='15%'>Jenis Kelamin</th>
                                <th width='15%'>Kelurahan Domisili</th>
                                <th width=''>Disabilitas</th>
                                <th width='5%'>VIEW</th>
                                <th width='5%'>EDIT</th>
                                <th width='5%'>HAPUS</th>
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
                                    <td><?= $datapasien["namaLengkap"]; ?></td>
                                    <td><?= $datapasien["kelompokUsia"]; ?></td>
                                    <td><?= $datapasien["jenisKelamin"]; ?></td>
                                    <td><?= $datapasien["namaKelurahan"]; ?></td>
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
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formedit<?= $datapasien["idPasien"]; ?>" style="border-radius: 8px;">
                                            <i class="fa-regular fa-pen-to-square" style="color: #000000;"></i>
                                        </button>

                                        <!-- Modal UPDATE -->
                                        <div class="modal fade" id="formedit<?= $datapasien["idPasien"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content text-left">
                                                    <div class="modal-header">
                                                        <figure class="text-left">
                                                            <blockquote class="blockquote">EDIT PASIEN</blockquote>
                                                            <figcaption class="blockquote-footer"><?= $datapasien["idPasien"]; ?></figcaption>                                     
                                                            <figcaption class="blockquote-footer"><?= $datapasien["namaLengkap"]; ?></figcaption>                                     
                                                        </figure>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <FORM method="post" enctype="multipart/form-data" action="21">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <input class="form-control" type="text" name="idPasien" id="idPasien" value="<?= $datapasien["idPasien"]; ?>" hidden>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="namaLengkap">Nama Lengkap Pasien <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="namaLengkap" id="namaLengkap" value="<?= $datapasien["namaLengkap"]; ?>" placeholder="Nama lengkap pasien" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="namaPanggilan">Nama Panggilan <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="namaPanggilan" id="namaPanggilan" value="<?= $datapasien["namaPanggilan"]; ?>" placeholder="Nama panggilan pasien" maxlength="255" size="" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nik">NIK <span class="required">*</span></label>
                                                                <input class="form-control" type="number" name="nik" id="nik" value="<?= $datapasien["nik"]; ?>" placeholder="NIK Pasien" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="tempatLahir">Tempat Lahir <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="tempatLahir" id="tempatLahir" value="<?= $datapasien["tempatLahir"]; ?>" placeholder="Tempat lahir pasien" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="tanggalLahir">Tanggal Lahir <span class="required">*</span></label>
                                                                    <input class="form-control" type="date" name="tanggalLahir" id="tanggalLahir" value="<?= isset($datapasien["tanggalLahir"]) ? htmlspecialchars($datapasien["tanggalLahir"], ENT_QUOTES, 'UTF-8') : ''; ?>" placeholder="Tanggal lahir pasien" maxlength="" size="" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kelompokUsia">Kelompok Usia <span class="required">*</span></label>
                                                                <select name="kelompokUsia" class="form-control" required>
                                                                    <option value="<?= $datapasien["kelompokUsia"]; ?>"><?= $datapasien["kelompokUsia"]; ?></option>
                                                                    <?php
                                                                        foreach ($enumKelompokUsia as $option) {
                                                                            $trimmedValue = trim($option);
                                                                            echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="jenisKelamin">Jenis Kelamin <span class="required">*</span></label>
                                                                    <select name="jenisKelamin" class="form-control" required>
                                                                        <option value="<?= $datapasien["jenisKelamin"]; ?>"><?= $datapasien["jenisKelamin"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumJK as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="golonganDarah">Golongan Darah <span class="required">*</span></label>
                                                                    <select name="golonganDarah" class="form-control" required>
                                                                        <option value="<?= $datapasien["golonganDarah"]; ?>"><?= $datapasien["golonganDarah"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumGoldar as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="noTeleponPasien">Nomor Telepon Pasien <span class="required">*</span></label>
                                                                <input class="form-control" type="number" name="noTeleponPasien" id="noTeleponPasien" value="<?= $datapasien["noTeleponPasien"]; ?>" placeholder="Nomor Telepon Pasien" maxlength="16" size="" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamatLengkap">Alamat Lengkap (sesuai KTP) <span class="required">*</span></label>
                                                                <textarea class="form-control" id="alamatLengkap" name="alamatLengkap" placeholder="Alamat sesuai KTP" rows="3" cols="" id="floatingTextarea" required><?= $datapasien["alamatLengkap"]; ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamatDomisili">Alamat Lengkap Domisili <span class="required">*</span></label>
                                                                <textarea class="form-control" id="alamatDomisili" name="alamatDomisili" placeholder="Alamat Domisili" rows="3" cols="" id="floatingTextarea" required><?= $datapasien["alamatDomisili"]; ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggalAktif">Tanggal Mulai Aktif <span class="required">*</span></label>
                                                                <input class="form-control" type="date" name="tanggalAktif" id="tanggalAktif" value="<?= isset($datapasien["tanggalAktif"]) ? htmlspecialchars($datapasien["tanggalAktif"], ENT_QUOTES, 'UTF-8') : ''; ?>" placeholder="Tanggal pasien mulai aktif" maxlength="" size="" required>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="statusPasien<?= $datapasien['idPasien']; ?>">Status Pasien <span class="required">*</span></label>
                                                                    <select name="statusPasien" class="form-control statusPasien" id="statusPasien<?= $datapasien['idPasien']; ?>" required>
                                                                        <option value="<?= $datapasien["statusPasien"]; ?>"><?= $datapasien["statusPasien"]; ?></option>
                                                                        <option value="Aktif" <?= ($datapasien["statusPasien"] == 1) ? "selected" : ""; ?>>Aktif</option>
                                                                        <option value="Tidak Aktif" <?= ($datapasien["statusPasien"] == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="alasanTidakAktif<?= $datapasien['idPasien']; ?>">Alasan Tidak Aktif</label>
                                                                    <input class="form-control alasanTidakAktif" type="text" name="alasanTidakAktif" id="alasanTidakAktif<?= $datapasien['idPasien']; ?>" value="<?= $datapasien["alasanTidakAktif"]; ?>" placeholder="Alasan pasien tidak aktif" maxlength="255" <?= ($datapasien["statusPasien"] == 1) ? "disabled" : ""; ?>>
                                                                </div>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $(".statusPasien").each(function () {
                                                                            let alasanField = $("#alasanTidakAktif" + $(this).attr("id").replace("statusPasien", ""));
                                                                            alasanField.prop("disabled", $(this).val().toString() !== "Tidak Aktif");
                                                                            $(this).on("change", function () {
                                                                                alasanField.prop("disabled", $(this).val().toString() !== "Tidak Aktif").val($(this).val().toString() === "0" ? alasanField.val() : "");
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="jenisDisabilitas<?= $datapasien['idPasien']; ?>">Jenis Disabilitas <span class="required">*</span></label>
                                                                    <select name="jenisDisabilitas[<?= $datapasien['idPasien']; ?>]" 
                                                                    class="form-control jd" 
                                                                    data-id="<?= $datapasien['idPasien']; ?>" required>
                                                                        <option value="<?= $datapasien["idJenisDisabilitas"]; ?>">
                                                                            <?= $datapasien["jenisDisabilitas"] ?>
                                                                        </option>                                                                    
                                                                        <?php                                
                                                                        // Buat query untuk menampilkan semua data siswa
                                                                        $sql = $pdo->prepare("SELECT * FROM jenis_disabilitas ORDER BY idJenisDisabilitas");
                                                                        $sql->execute(); // Eksekusi querynya
                                                                        
                                                                        while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
                                                                            echo "<option value='".$data['idJenisDisabilitas']."'>".$data['jenisDisabilitas']."</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="subDisabilitas<?= $datapasien['idPasien']; ?>">Sub Jenis Disabilitas <span class="required">*</span></label>
                                                                    <select name="subDisabilitas[<?= $datapasien['idPasien']; ?>]" 
                                                                    class="form-control sd"
                                                                    data-id="<?= $datapasien['idPasien']; ?>" required>
                                                                        <option value="<?= $datapasien["idSubDisabilitas"]; ?>"><?= $datapasien["namaDisabilitas"]?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="alatBantu">Alat Bantu</label>
                                                                    <textarea class="form-control" id="alatBantu" name="alatBantu" placeholder="Alat Bantu yang dibutuhkan pasien" rows="3" cols="" id="floatingTextarea"><?= $datapasien["alatBantu"]; ?></textarea>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="kebutuhanKhusus">Kebutuhan Khusus</label>
                                                                    <textarea class="form-control" id="kebutuhanKhusus" name="kebutuhanKhusus" placeholder="Kebutuhan khusus yang mendukung kenyamanan pasien" rows="3" cols="" id="floatingTextarea"><?= $datapasien["kebutuhanKhusus"]; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $idPasien = $datapasien["idPasien"]; // Ambil idPasien dari URL atau request

                                                            // Query untuk mendapatkan riwayat penyakit pasien tertentu
                                                            $sqlRiwayatPenyakitPribadi = "SELECT riwayatPenyakitPribadi FROM pasien WHERE idPasien = '$idPasien'";
                                                            $view = new cView();
                                                            $arrayRiwayatPenyakitPribadi = $view->vViewData($sqlRiwayatPenyakitPribadi);
                                                            // Pastikan data ditemukan
                                                            $riwayatPenyakitPribadiTerpilih = [];
                                                            if (!empty($arrayRiwayatPenyakitPribadi)) {
                                                                $dataRiwayatPenyakitPribadi = $arrayRiwayatPenyakitPribadi[0]; // Ambil baris pertama
                                                                $riwayatPenyakitPribadiTerpilih = explode(",", $dataRiwayatPenyakitPribadi["riwayatPenyakitPribadi"]); // Ubah ke array
                                                            } 
                                                            ?>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="riwayatPenyakitPribadi">Riwayat Penyakit Pribadi</label><br>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Diabetes Mellitus" id="diabetes"
                                                                                <?= in_array("Diabetes Mellitus", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="diabetes">Diabetes</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Hipertensi" id="hipertensi"
                                                                                <?= in_array("Hipertensi", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Jantung" id="jantung"
                                                                                <?= in_array("Jantung", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="jantung">Jantung</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Kanker" id="kanker"
                                                                                <?= in_array("Kanker", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="kanker">Kanker</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Rhematik" id="rhematik"
                                                                                <?= in_array("Rhematik", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="rhematik">Rhematik</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Asma" id="asma"
                                                                                <?= in_array("Asma", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="asma">Asma</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Asam Lambung" id="asamLambung"
                                                                                <?= in_array("Asam Lambung", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="asamLambung">Asam Lambung</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitPribadi[]" value="Lain-lain" id="lainlain"
                                                                                <?= in_array("Lain-lain", $riwayatPenyakitPribadiTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $idPasien = $datapasien["idPasien"]; // Ambil idPasien dari URL atau request
                                                            // Query untuk mendapatkan riwayat penyakit pasien tertentu
                                                            $sqlRiwayatPenyakitKeluarga = "SELECT riwayatPenyakitKeluarga FROM pasien WHERE idPasien = '$idPasien'";
                                                            $view = new cView();
                                                            $arrayRiwayatPenyakitKeluarga = $view->vViewData($sqlRiwayatPenyakitKeluarga);
                                                            // Pastikan data ditemukan
                                                            $riwayatPenyakitKeluargaTerpilih = [];
                                                            if (!empty($arrayRiwayatPenyakitKeluarga)) {
                                                                $dataRiwayatPenyakitKeluarga = $arrayRiwayatPenyakitKeluarga[0]; // Ambil baris pertama
                                                                $riwayatPenyakitKeluargaTerpilih = explode(",", $dataRiwayatPenyakitKeluarga["riwayatPenyakitKeluarga"]); // Ubah ke array
                                                            } 
                                                            ?>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="riwayatPenyakitKeluarga">Riwayat Penyakit Keluarga</label><br>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Diabetes Mellitus" id="diabetes"
                                                                                <?= in_array("Diabetes Mellitus", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="diabetes">Diabetes</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Hipertensi" id="hipertensi"
                                                                                <?= in_array("Hipertensi", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="hipertensi">Hipertensi</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Jantung" id="jantung"
                                                                                <?= in_array("Jantung", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="jantung">Jantung</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Kanker" id="kanker"
                                                                                <?= in_array("Kanker", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="kanker">Kanker</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Rhematik" id="rhematik"
                                                                                <?= in_array("Rhematik", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="rhematik">Rhematik</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Asma" id="asma"
                                                                                <?= in_array("Asma", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="asma">Asma</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Asam Lambung" id="asamLambung"
                                                                                <?= in_array("Asam Lambung", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="asamLambung">Asam Lambung</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="riwayatPenyakitKeluarga[]" value="Lain-lain" id="lainlain"
                                                                                <?= in_array("Lain-lain", $riwayatPenyakitKeluargaTerpilih) ? "checked" : ""; ?>>
                                                                            <label class="form-check-label" for="lainlain">Lain-lain</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="alergi">Alergi</label>
                                                                    <input class="form-control" type="text" name="alergi" id="alergi" value="<?= $datapasien["alergi"]; ?>" placeholder="Alergi pasien" maxlength="255" size="">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="trauma">Trauma/Cedera</label>
                                                                    <input class="form-control" type="text" name="trauma" id="trauma" value="<?= $datapasien["trauma"]; ?>" placeholder="Trauma/Cedera pasien" maxlength="255" size="">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="namaOrtu">Nama Orang Tua</label>
                                                                    <input class="form-control" type="text" name="namaOrtu" id="namaOrtu" value="<?= $datapasien["namaOrangTua"]; ?>" placeholder="Nama Orang Tua" maxlength="255" size="">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="noTelpOrtu">Nomor Telepon Orang Tua</label>
                                                                    <input class="form-control" type="number" name="noTelpOrtu" id="noTelpOrtu" value="<?= $datapasien["noTelpOrangTua"]; ?>" placeholder="Nomor Telepon Orang Tua" maxlength="16" size="">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="namaPendamping">Nama Pendamping</label>
                                                                    <input class="form-control" type="text" name="namaPendamping" id="namaPendamping" value="<?= $datapasien["namaPendamping"]; ?>" placeholder="Nama Pendamping" maxlength="255" size="">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="noTelpPendamping">Nomor Telepon Pendamping</label>
                                                                    <input class="form-control" type="number" name="noTelpPendamping" id="noTelpPendamping" value="<?= $datapasien["noTelpPendamping"]; ?>" placeholder="Nomor Telepon Pendamping" maxlength="16" size="">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="card">
                                                                <div class="card-body border border-2">
                                                                    <p><strong>Alamat Domisili Pasien</strong></p> 
                                                                    <div class="row">
                                                                        <div class="col-6 mb-3">
                                                                            <label for="namaJalan">Nama Jalan</label>
                                                                            <input class="form-control" type="text" name="namaJalan" id="namaJalan" value="<?= $datapasien["namaJalan"]; ?>" placeholder="Nama Jalan" maxlength="255" size="">
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="provinsi[<?= $datapasien['idPasien']; ?>]">Provinsi</label>
                                                                            <select name="provinsi[<?= $datapasien['idPasien']; ?>]"
                                                                             class="form-control prov"
                                                                             data-id="<?= $datapasien['idPasien']; ?>">
                                                                                <option value="<?= $datapasien["idProvinsi"]; ?>"><?= $datapasien["namaProvinsi"]; ?></option>
                                                                                
                                                                                <?php                                
                                                                                $sql = $pdo->prepare("SELECT * FROM provinsi ORDER BY idProvinsi");
                                                                                $sql->execute();
                                                                                
                                                                                while($data = $sql->fetch()){
                                                                                    echo "<option value='".$data['idProvinsi']."'>".$data['namaProvinsi']. "</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="kotaKab[<?= $datapasien['idPasien']; ?>]">Kota / Kabupaten</label>
                                                                            <select name="kotaKab[<?= $datapasien['idPasien']; ?>]" 
                                                                            class="form-control kotaKab"
                                                                            data-id="<?= $datapasien['idPasien']; ?>">
                                                                                <option value="<?= $datapasien["idKotaKabupaten"]; ?>"><?= $datapasien["namaKotaKabupaten"]; ?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="kecamatan[<?= $datapasien['idPasien']; ?>]">Kecamatan</label>
                                                                            <select name="kecamatan[<?= $datapasien['idPasien']; ?>]" 
                                                                            class="form-control kec"
                                                                            data-id="<?= $datapasien['idPasien']; ?>">
                                                                                <option value="<?= $datapasien["idKecamatan"]; ?>"><?= $datapasien["namaKecamatan"]; ?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="kelurahan[<?= $datapasien['idPasien']; ?>]">Kelurahan</label>
                                                                            <select name="kelurahan[<?= $datapasien['idPasien']; ?>]" 
                                                                            class="form-control kel"
                                                                            data-id="<?= $datapasien['idPasien']; ?>">
                                                                                <option value="<?= $datapasien["idKelurahan"]; ?>"><?= $datapasien["namaKelurahan"]; ?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="kodePosDomisili">Kode Pos Domisili</label>
                                                                            <input type="number" name="kodePosDomisili" value="<?= $datapasien["kodePosDomisili"]; ?>" id="kodePosDomisili" class="form-control" placeholder="Kode Pos Domisili" maxlength="" size="">
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="RTDomisili">RT Domisili</label>
                                                                            <input type="number" name="RTDomisili" value="<?= $datapasien["RTDomisili"]; ?>" id="RTDomisili" class="form-control" placeholder="RT Domisili" maxlength="" size="">
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label for="RWDomisili">RW Domisili</label>
                                                                            <input type="number" name="RWDomisili" value="<?= $datapasien["RWDomisili"]; ?>" id="RWDomisili" class="form-control" placeholder="RW Domisili" maxlength="" size="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-6 my-3">
                                                                    <label for="agama">Agama</label>
                                                                    <select name="agama" class="form-control">
                                                                        <option value="<?= $datapasien["agama"]; ?>"><?= $datapasien["agama"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumAgama as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 my-3">
                                                                    <label for="suku">Suku</label>
                                                                    <input class="form-control" type="text" name="suku" id="suku" value="<?= $datapasien["suku"]; ?>" placeholder="Suku Pasien" maxlength="255" size="">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bahasaDikuasai">Bahasa Dikuasai</label>
                                                                <input class="form-control" type="text" name="bahasaDikuasai" id="bahasaDikuasai" value="<?= $datapasien["bahasaDikuasai"]; ?>" placeholder="Bahasa yang Dikuasai Pasien" maxlength="255" size="">
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="pendidikan">Pendidikan Terakhir</label>
                                                                    <select name="pendidikan" class="form-control">
                                                                        <option value="<?= $datapasien["pendidikan"]; ?>"><?= $datapasien["pendidikan"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumPendidikan as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="pekerjaan">Pekerjaan</label>
                                                                    <select name="pekerjaan" class="form-control">
                                                                        <option value="<?= $datapasien["pekerjaan"]; ?>"><?= $datapasien["pekerjaan"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumPekerjaan as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="statusPernikahan">Status Pernikahan</label>
                                                                <select name="statusPernikahan" class="form-control">
                                                                    <option value="<?= $datapasien["statusPernikahan"]; ?>"><?= $datapasien["statusPernikahan"]; ?></option>
                                                                    <?php
                                                                        foreach ($enumNikah as $option) {
                                                                            $trimmedValue = trim($option);
                                                                            echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan / Catatan untuk pasien" rows="3" cols="" id="floatingTextarea"><?= $datapasien["keterangan"]; ?></textarea>
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
                                            array("idPasien", $datapasien["idPasien"], "pasien")
                                        );
                                        _CreateWindowModalDelete($datapasien["idPasien"], "del", "del-form", "del-button", "lg", 200, "HAPUS#DATA PASIEN" . $datapasien["idPasien"] . "#" . $datapasien["namaLengkap"] . " - " . $datapasien["namaDisabilitas"], "", $datadelete, "", "21");
                                        ?>
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