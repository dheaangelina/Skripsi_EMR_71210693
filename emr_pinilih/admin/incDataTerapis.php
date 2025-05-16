<?php
// insert
if (!empty($_POST["savebtn"])) {
    $linkurl = 22;

    // Mapping ENUM ke Label Tampilan
    $enumJTMapping = [
        "Tenaga Medis" => "Tenaga Medis - Dokter, Psikiater",
        "Tenaga Paramedis" => "Tenaga Paramedis - Perawat",
        "Tenaga Non Medis" => "Tenaga Non Medis - Psikolog, Terapis, Volunteer, dll"
    ];

    $jenisTerapis = array_search($_POST["jenisTerapis"], $enumJTMapping);
    if ($jenisTerapis === false) {
        $jenisTerapis = $_POST["jenisTerapis"]; // Gunakan langsung jika tidak ditemukan
    }

    //Upload File
    $targetDir = "uploads/sertifikasi/"; // Folder penyimpanan file
    $fileName = basename($_FILES["dokumenSertifikasi"]["name"]);
    $filePath = $targetDir . time() . "_" . $fileName; // Buat nama unik

    if (!empty($_FILES["dokumenSertifikasi"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["dokumenSertifikasi"]["tmp_name"], $filePath)) {
            $dokumenSertifikasi = "'" . $filePath . "'";
        } else {
            $dokumenSertifikasi = "NULL"; // Jika gagal upload
        }
    } else {
        $dokumenSertifikasi = "NULL"; // Tidak ada file yang diupload
    }

    // Upload File dokumenLainnya
    $targetDir = "uploads/sertifikasi/";
    $fileNameLainnya = basename($_FILES["dokumenLainnya"]["name"]);
    $filePathLainnya = $targetDir . time() . "_" . $fileNameLainnya;
    
    if (!empty($_FILES["dokumenLainnya"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["dokumenLainnya"]["tmp_name"], $filePathLainnya)) {
            $dokumenLainnya = "'" . $filePathLainnya . "'";
        } else {
            $dokumenLainnya = "NULL"; // Jika gagal upload
        }
    } else {
        $dokumenLainnya = "NULL"; // Tidak ada file yang diupload
    }

    $alasanTidakAktif = isset($_POST["alasanTidakAktif"]) ? $_POST["alasanTidakAktif"] : ""; 

    // field
    $datafield_terapis = array("namaTerapis", "jenisKelamin", "alamat", "noTelepon", "jenisTerapis", "spesialisasi", "instansi", "pendidikanTerakhir", "pendidikanNonFormal", "noIzinPraktek", "dokumenSertifikasi", "tanggalAktif", "statusTerapis", "alasanTidakAktif", "statusPekerja", "dokumenLainnya", "keterangan");

    // value
    $datavalue_terapis = array( '"' . $_POST["namaTerapis"] . '"',  '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["alamat"] . '"',  '"' . $_POST["noTelepon"] . '"',  '"' . $jenisTerapis . '"',  '"' . $_POST["spesialisasi"] . '"', '"' . $_POST["instansi"] . '"', '"' . $_POST["pendidikanTerakhir"] . '"', '"' . $_POST["pendidikanNonFormal"] . '"', '"' . $_POST["noIzinPraktek"] . '"', $dokumenSertifikasi, '"' . $_POST["tanggalAktif"] . '"', '"' . $_POST["statusTerapis"] . '"', '"' . $alasanTidakAktif . '"', '"' . $_POST["statusPekerja"] . '"', $dokumenLainnya, '"' . $_POST["keterangan"] . '"');


    $insert = new cInsert();
    // $insert->vInsertDataTrial($datafield_terapis, "terapis", $datavalue_terapis, $linkurl);
    $insert->vInsertData($datafield_terapis, "terapis", $datavalue_terapis, $linkurl);
}
?>

<?php
// update
if (!empty($_POST["editbtn"])) {
    $linkurl = 22;

    $sql = "SELECT dokumenSertifikasi, dokumenLainnya FROM terapis WHERE idTerapis = '" . $_POST["idTerapis"] . "'";
    $view = new cView();
    $arrayTerapis = $view->vViewData($sql);

    $dokumenSertifikasiLama = $arrayTerapis[0]["dokumenSertifikasi"];
    $dokumenLainnyaLama = $arrayTerapis[0]["dokumenLainnya"];

    // Mapping ENUM ke Label Tampilan
    $enumJTMapping = [
        "Tenaga Medis" => "Tenaga Medis - Dokter, Psikiater",
        "Tenaga Paramedis" => "Tenaga Paramedis - Perawat",
        "Tenaga Non Medis" => "Tenaga Non Medis - Psikolog, Terapis, Volunteer, dll"
    ];

    // Ambil ENUM asli dari label panjang yang dipilih
    $jenisTerapis = array_search($_POST["jenisTerapis"], $enumJTMapping);
    if ($jenisTerapis === false) {
        $jenisTerapis = $_POST["jenisTerapis"]; // Gunakan langsung jika tidak ditemukan
    }

    //Upload File
    $targetDir = "uploads/sertifikasi/"; // Folder penyimpanan file
    $fileName = basename($_FILES["dokumenSertifikasi"]["name"]);
    $filePath = $targetDir . time() . "_" . $fileName; // Buat nama unik

    if (!empty($_FILES["dokumenSertifikasi"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["dokumenSertifikasi"]["tmp_name"], $filePath)) {
            $dokumenSertifikasi = "'" . $filePath . "'";
        } else {
            $dokumenSertifikasi = "'" . $dokumenSertifikasiLama . "'";
        }
    } else {
        $dokumenSertifikasi = "'" . $dokumenSertifikasiLama . "'";
    }

    // Upload File dokumenLainnya
    $targetDir = "uploads/dokumenLain/";
    $fileNameLainnya = basename($_FILES["dokumenLainnya"]["name"]);
    $filePathLainnya = $targetDir . time() . "_" . $fileNameLainnya;
    
    if (!empty($_FILES["dokumenLainnya"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["dokumenLainnya"]["tmp_name"], $filePathLainnya)) {
            $dokumenLainnya = "'" . $filePathLainnya . "'";
        } else {
            $dokumenLainnya = "'" . $dokumenLainnyaLama . "'";
        }
    } else {
        $dokumenLainnya = "'" . $dokumenLainnyaLama . "'";
    }

    $alasanTidakAktif = isset($_POST["alasanTidakAktif"]) ? $_POST["alasanTidakAktif"] : ""; 
    
    $datafield_terapis = array("namaTerapis", "jenisKelamin", "alamat", "noTelepon", "jenisTerapis", "spesialisasi", "instansi", "pendidikanTerakhir", "pendidikanNonFormal", "noIzinPraktek", "dokumenSertifikasi", "tanggalAktif", "statusTerapis", "alasanTidakAktif", "statusPekerja", "dokumenLainnya", "keterangan");
    $datavalue_terapis = array( '"' . $_POST["namaTerapis"] . '"',  '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["alamat"] . '"',  '"' . $_POST["noTelepon"] . '"',  '"' . $jenisTerapis . '"',  '"' . $_POST["spesialisasi"] . '"', '"' . $_POST["instansi"] . '"', '"' . $_POST["pendidikanTerakhir"] . '"', '"' . $_POST["pendidikanNonFormal"] . '"', '"' . $_POST["noIzinPraktek"] . '"', $dokumenSertifikasi, '"' . $_POST["tanggalAktif"] . '"', '"' . $_POST["statusTerapis"] . '"', '"' . $alasanTidakAktif . '"', '"' . $_POST["statusPekerja"] . '"', $dokumenLainnya, '"' . $_POST["keterangan"] . '"');

    $datakey = ' idTerapis =' . $_POST["idTerapis"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_terapis, "terapis", $datavalue_terapis, $datakey, $linkurl);
    $update->vUpdateData($datafield_terapis, "terapis", $datavalue_terapis, $datakey, $linkurl);
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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-11">
            <figure>
                <blockquote class="blockquote">
                    <p>DATA TENAGA MEDIS / PARAMEDIS / NON MEDIS</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Entri Data Tenaga Medis / Paramedis / Non Medis
                </figcaption>
            </figure>
        </div>

        <div class="col-md-1">
            <?php
            // Query ENUM 'jenisKelamin'
            $jk = "SHOW COLUMNS FROM terapis LIKE 'jenisKelamin'";
            $view = new cView();
            $arrayJK = $view->vViewData($jk);
            $enumJK = [];
            if (!empty($arrayJK)) {
                $row = $arrayJK[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumJK = explode(",", str_replace("'", "", $matches[1]));
                }
            }

            // Query ENUM 'jenisTerapis'
            $jt = "SHOW COLUMNS FROM terapis LIKE 'jenisTerapis'";
            $view = new cView();
            $arrayJT = $view->vViewData($jt);
            $enumJT = [];
            if (!empty($arrayJT)) {
                $row = $arrayJT[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumJT = explode(",", str_replace("'", "", $matches[1]));
                }
            }

            // Mapping ENUM ke Label Tampilan
            $enumJTMapping = [
                "Tenaga Medis" => "Tenaga Medis - Dokter, Psikiater",
                "Tenaga Paramedis" => "Tenaga Paramedis - Perawat",
                "Tenaga Non Medis" => "Tenaga Non Medis - Psikolog, Terapis, Volunteer, dll"
            ];

            // Buat array untuk dropdown
            $enumJTForm = [];
            foreach ($enumJTMapping as $key => $label) {
                $enumJTForm[$key] = $label; // Dropdown menampilkan label panjang
            }

            // Query ENUM 'pendidikanTerakhir'
            $pt = "SHOW COLUMNS FROM terapis LIKE 'pendidikanTerakhir'";
            $view = new cView();
            $arrayPT = $view->vViewData($pt);
            $enumPT = [];
            if (!empty($arrayPT)) {
                $row = $arrayPT[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumPT = explode(",", str_replace("'", "", $matches[1]));
                }
            }

            // Query ENUM 'statusAktif'
            $status = "SHOW COLUMNS FROM terapis LIKE 'statusTerapis'";
            $view = new cView();
            $arrayStatus = $view->vViewData($status);
            $enumStatus = [];
            if (!empty($arrayStatus)) {
                $row = $arrayStatus[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumStatus = explode(",", str_replace("'", "", $matches[1]));
                }
            }
            // Query ENUM 'statusTetap'
            $statusPekerja = "SHOW COLUMNS FROM terapis LIKE 'statusPekerja'";
            $view = new cView();
            $arraystatusPekerja = $view->vViewData($statusPekerja);
            $enumstatusPekerja = [];
            if (!empty($arraystatusPekerja)) {
                $row = $arraystatusPekerja[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumstatusPekerja = explode(",", str_replace("'", "", $matches[1]));
                }
            }
            ?>

            <button type="button" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" 
                    data-bs-toggle="modal" data-bs-target="#exampleModal" 
                    style="border-radius: 10px; width: 50%; height: 60%; display: flex;">
                <i class="fa-solid fa-plus fa-lg" style="color: #ffffff;"></i>
            </button>

            <!-- Modal INSERT -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="exampleModalLabel">
                                <blockquote class="blockquote">
                                    <p>Tambah Data Tenaga Medis / Paramedis / Non Medis</p>
                                </blockquote>
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="" method="post" action="22" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="namaTerapis">Nama Lengkap <span class="required">*</span></label>
                                    <input class="form-control" type="text" name="namaTerapis" id="namaTerapis" value="" placeholder="Nama lengkap" maxlength="255" size="" required>
                                </div>
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label for="alamat">Alamat <span class="required">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" rows="3" cols="" id="floatingTextarea" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="noTelepon">Nomor Telepon <span class="required">*</span></label>
                                    <input class="form-control" type="number" name="noTelepon" id="noTelepon" value="" placeholder="Nomor telepon" maxlength="16" size="" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="jenisTerapis">Jenis Terapis <span class="required">*</span></label>
                                        <select name="jenisTerapis" class="form-control" required>
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumJTForm as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="spesialisasi">Spesialisasi <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="spesialisasi" id="spesialisasi" value="" placeholder="Spesialisasi" maxlength="255" size="" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="instansi">Asal Instansi <span class="required">*</span></label>
                                    <input class="form-control" type="text" name="instansi" id="instansi" value="" placeholder="Asal instansi" maxlength="255" size="" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="pendidikanTerakhir">Pendidikan Terakhir <span class="required">*</span></label>
                                        <select name="pendidikanTerakhir" class="form-control" required>
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumPT as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="pendidikanNonFormal">Pendidikan Non Formal </label>
                                        <input class="form-control" type="text" name="pendidikanNonFormal" id="pendidikanNonFormal" value="" placeholder="Pendidikan non formal" maxlength="255" size="" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="tanggalAktif">Tanggal Mulai Aktif <span class="required">*</span></label>
                                        <input class="form-control" type="date" name="tanggalAktif" id="tanggalAktif" value="" placeholder="Tanggal terapis mulai aktif" maxlength="" size="" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="statusPekerja">Status Pekerja</label>
                                        <select name="statusPekerja" class="form-control" >
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumstatusPekerja as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="statusTerapis">Status Terapis <span class="required">*</span></label>
                                        <select name="statusTerapis" class="form-control" id="statusTerapis" required>
                                            <option value="">- pilihan -</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="alasanTidakAktif">Alasan Tidak Aktif</label>
                                        <input class="form-control" type="text" name="alasanTidakAktif" id="alasanTidakAktif" value="" placeholder="Alasan terapis tidak aktif" maxlength="255" disabled>
                                        </div>
                                    <script>
                                        document.getElementById("statusTerapis").addEventListener("change", function () {
                                            var alasanInput = document.getElementById("alasanTidakAktif");
                                            if (this.value === "Tidak Aktif") {
                                                alasanInput.removeAttribute("disabled"); // Aktifkan input jika "Tidak Aktif"
                                            } else {
                                                alasanInput.setAttribute("disabled", "true"); // Nonaktifkan input jika "Aktif"
                                                alasanInput.value = ""; // Kosongkan input ketika dinonaktifkan
                                            }
                                        });
                                    </script>
			                    </div>
                                <div class="mb-3">
                                    <label for="noIzinPraktek">Nomor Izin Praktek</label>
                                    <input class="form-control" type="text" name="noIzinPraktek" id="noIzinPraktek" value="" placeholder="Nomor Izin Praktek" maxlength="255" size="" >
                                </div>
                                
                                <div class="mb-3">
                                    <label for="dokumenSertifikasi">Dokumen Sertifikasi</label>
                                    <input type="file" class="form-control" id="dokumenSertifikasi" name="dokumenSertifikasi" >
                                </div>
                            
                                <div class="mb-3">
                                    <label for="dokumenLainnya">Dokumen Lainnya</label>
                                    <input type="file" class="form-control" id="dokumenLainnya" name="dokumenLainnya">
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="3" cols="" id="floatingTextarea" ></textarea>
                                </div>     
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 25px;" name="savebtn" value="true">SIMPAN</button>
                                <button type="reset" class="btn btn-warning btn-sm" style="border-radius: 25px;" name="" value="true">ULANG</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">TUTUP</button>
                            </div>
                        </form>                                  
                    </div>
                </div>
            </div>
        </div>
        <p></p>

        <div class="row">
            <div class="col-md-12">
                <?php
                $sqlterapis = "SELECT t.* FROM terapis t ORDER BY idTerapis DESC";
                // echo $sqlterapis;
                $view = new cView();
                $arrayterapis = $view->vViewData($sqlterapis);
                ?>
                <div id="" class='table-responsive'>
                    <table id='example' class='table table-condensed'>
                        <thead>
                            <tr class=''>
                                <th width='5%'>No.</th>
                                <th width=''>Nama Lengkap</th>
                                <th width=''>Spesialisasi</th>
                                <th width=''>Instansi</th>
                                <th width=''>No Telepon</th>
                                <th width='5%'>VIEW</th>
                                <th width='5%'>EDIT</th>
                                <th width='5%'>HAPUS</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $cnourut = 0;
                            foreach ($arrayterapis as $dataterapis) { 
                                $cnourut = $cnourut + 1;
                                ?>
                                <tr class=''>
                                    <td><?= $cnourut; ?></td>
                                    <td><?= $dataterapis["namaTerapis"]; ?></td>
                                    <td><?= $dataterapis["spesialisasi"]; ?></td>
                                    <td><?= $dataterapis["instansi"]; ?></td>
                                    <td><?= $dataterapis["noTelepon"]; ?></td>
                                    <td>
                                    <?php
                                        //jenisTerapis
                                        $labelJenisTerapis = isset($enumJTMapping[$dataterapis["jenisTerapis"]]) ? $enumJTMapping[$dataterapis["jenisTerapis"]] : $dataterapis["jenisTerapis"];
                                        
                                        // Path file DOKUMENTASI SERTIFIKASI
                                        $dokumenPath = "uploads/sertifikasi/" . basename($dataterapis["dokumenSertifikasi"]);

                                        if (!empty($dataterapis["dokumenSertifikasi"]) && file_exists($dokumenPath)) {
                                            $dokumenSertifikasi = '<a href="../admin/' . htmlspecialchars($dokumenPath) . '" target="_new">Lihat Dokumen</a>';
                                        } else {
                                            $dokumenSertifikasi = '<span>Tidak ada dokumen</span>';
                                        }

                                        // Path file DOKUMENTASI SERTIFIKASI
                                        $dokumenPath2 = "uploads/sertifikasi/" . basename($dataterapis["dokumenLainnya"]);

                                        if (!empty($dataterapis["dokumenLainnya"]) && file_exists($dokumenPath2)) {
                                            $dokumenLainnya = '<a href="../admin/' . htmlspecialchars($dokumenPath2) . '" target="_new">Lihat Dokumen</a>';
                                        } else {
                                            $dokumenLainnya = '<span>Tidak ada dokumen</span>';
                                        }

                                        $datadetail = array(
                                            array("NAMA LENGKAP", "namaTerapis", $dataterapis["namaTerapis"], 1, ""),
                                            array("JENIS KELAMIN", "jenisKelamin", $dataterapis["jenisKelamin"], 1, ""),
                                            array("ALAMAT", "alamat", $dataterapis["alamat"], 1, ""),
                                            array("NOMOR TELEPON", "noTelepon", $dataterapis["noTelepon"], 1, ""),
                                            array("JENIS TERAPIS", "jenisTerapis", $labelJenisTerapis, 1, ""),
                                            array("SPESIALISASI", "spesialisasi", $dataterapis["spesialisasi"], 1, ""),
                                            array("ASAL INSTANSI", "instansi", $dataterapis["instansi"], 1, ""),
                                            array("PENDIDIKAN TERAKHIR", "pendidikanTerakhir", $dataterapis["pendidikanTerakhir"], 1, ""),
                                            array("PENDIDIKAN NON FORMAL", "pendidikanNonFormal", $dataterapis["pendidikanNonFormal"], 1, ""),
                                            array("TANGGAL MULAI AKTIF", "tanggalAktif", $dataterapis["tanggalAktif"], 1, ""),
                                            array("STATUS PEKERJA", "statusPekerja", $dataterapis["statusPekerja"], 1, ""),
                                            array("STATUS TERAPIS", "statusTerapis", $dataterapis["statusTerapis"], 1, ""),
                                            array("ALASAN TIDAK AKTIF", "alasanTidakAktif", $dataterapis["alasanTidakAktif"], 1, ""),
                                            array("NOMOR IZIN PRAKTEK", "noIzinPraktek", $dataterapis["noIzinPraktek"], 1, ""),
                                            array("DOKUMEN SERTIFIKASI", "dokumenSertifikasi", $dokumenSertifikasi, 1, ""),
                                            array("DOKUMEN LAINNYA", "dokumenLainnya", $dokumenLainnya, 1, ""),
                                            array("KETERANGAN", "keterangan", $dataterapis["keterangan"], 1, ""),
                                        );
                                        _CreateWindowModalDetil($dataterapis["idTerapis"], "view", "viewterapis-form", "viewterapis-button", "", 600, "DETAIL TERAPIS " . $dataterapis["idTerapis"], "", $datadetail, "", "22", "");
                                    ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formedit<?= $dataterapis["idTerapis"]; ?>" style="border-radius: 8px;">
                                            <i class="fa-regular fa-pen-to-square" style="color: #000000;"></i>
                                        </button>

                                        <div class="modal fade" id="formedit<?= $dataterapis["idTerapis"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content text-left">
                                                    <div class="modal-header">
                                                        <figure class="text-left">
                                                            <blockquote class="blockquote">EDIT DATA TENAGA MEDIS / PARAMEDIS / NON MEDIS</blockquote>
                                                            <figcaption class="blockquote-footer"><?= $dataterapis["idTerapis"]; ?></figcaption>                                     
                                                            <figcaption class="blockquote-footer"><?= $dataterapis["namaTerapis"]; ?></figcaption>                                     
                                                        </figure>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <FORM method="post" enctype="multipart/form-data" action="22">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <input class="form-control" type="text" name="idTerapis" id="idTerapis" value="<?= $dataterapis["idTerapis"]; ?>" hidden>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="namaTerapis">Nama Lengkap <span class="required">*</span></label>
                                                                <input class="form-control" type="text" name="namaTerapis" id="namaTerapis" value="<?= $dataterapis["namaTerapis"]; ?>" placeholder="Nama lengkap" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenisKelamin">Jenis Kelamin <span class="required">*</span></label>
                                                                <select name="jenisKelamin" class="form-control" required>
                                                                    <option value="<?= $dataterapis["jenisKelamin"]; ?>"><?= $dataterapis["jenisKelamin"]; ?></option>
                                                                    <?php
                                                                        foreach ($enumJK as $option) {
                                                                            $trimmedValue = trim($option);
                                                                            echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamat">Alamat <span class="required">*</span></label>
                                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" rows="3" cols="" id="floatingTextarea" required><?= $dataterapis["alamat"]; ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="noTelepon">Nomor Telepon <span class="required">*</span></label>
                                                                <input class="form-control" type="text" name="noTelepon" id="noTelepon" value="<?= $dataterapis["noTelepon"]; ?>" placeholder="Nomor Telepon yang Aktif" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenisTerapis">Jenis Terapis <span class="required">*</span></label>
                                                                <select name="jenisTerapis" class="form-control" required>
                                                                    <option value="<?= $dataterapis["jenisTerapis"]; ?>"><?= $dataterapis["jenisTerapis"]; ?></option>
                                                                    <?php
                                                                        foreach ($enumJTForm as $option) {
                                                                            $trimmedValue = trim($option);
                                                                            echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="spesialisasi">Spesialisasi <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="spesialisasi" id="spesialisasi" value="<?= $dataterapis["spesialisasi"]; ?>" placeholder="Spesialisasi" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="instansi">Asal Instansi <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="instansi" id="instansi" value="<?= $dataterapis["instansi"]; ?>" placeholder="Asal Instansi" maxlength="255" size="" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="pendidikanTerakhir">Pendidikan Terakhir <span class="required">*</span></label>
                                                                    <select name="pendidikanTerakhir" class="form-control" required>
                                                                        <option value="<?= $dataterapis["pendidikanTerakhir"]; ?>"><?= $dataterapis["pendidikanTerakhir"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumPT as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="pendidikanNonFormal">Pendidikan Non Formal </label>
                                                                    <input class="form-control" type="text" name="pendidikanNonFormal" id="pendidikanNonFormal" value="<?= $dataterapis["pendidikanNonFormal"]; ?>" placeholder="Pendidikan Non Formal" maxlength="255" size="" >
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                    <label for="tanggalAktif">Tanggal Aktif <span class="required">*</span> </label>
                                                                    <input class="form-control" type="date" name="tanggalAktif" id="tanggalAktif" value="<?= $dataterapis["tanggalAktif"]; ?>" placeholder="Tanggal Mulai Aktif" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="statusTerapis<?= $dataterapis['idTerapis']; ?>">Status Terapis <span class="required">*</span></label>
                                                                    <select name="statusTerapis" class="form-control statusTerapis" id="statusTerapis<?= $dataterapis['idTerapis']; ?>" required>
                                                                        <option value="<?= $dataterapis["statusTerapis"]; ?>"><?= $dataterapis["statusTerapis"]; ?></option>
                                                                        <option value="Aktif" <?= ($dataterapis["statusTerapis"] == 1) ? "selected" : ""; ?>>Aktif</option>
                                                                        <option value="Tidak Aktif" <?= ($dataterapis["statusTerapis"] == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="alasanTidakAktif<?= $dataterapis['idTerapis']; ?>">Alasan Tidak Aktif</label>
                                                                        <input class="form-control alasanTidakAktif" type="text" name="alasanTidakAktif" id="alasanTidakAktif<?= $dataterapis['idTerapis']; ?>" value="<?= $dataterapis["alasanTidakAktif"]; ?>" placeholder="Alasan pasien tidak aktif" maxlength="255" <?= ($dataterapis["statusTerapis"] == 1) ? "disabled" : ""; ?>>
                                                                    </div>
                                                                	<script>
                                                                        $(document).ready(function () {
                                                                        	$(".statusTerapis").each(function () {
                                                                                let alasanField = $("#alasanTidakAktif" + $(this).attr("id").replace("statusTerapis", ""));
                                                                                    alasanField.prop("disabled", $(this).val().toString() !== "Tidak Aktif");
                                                                                $(this).on("change", function () {
                                                                                        alasanField.prop("disabled", $(this).val().toString() !== "Tidak Aktif").val($(this).val().toString() === "0" ? alasanField.val() : "");
                                                                                });
                                                                        	});
                                                                        });
                                                                    </script>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="statusPekerja">Status Pekerja </label>
                                                                <select name="statusPekerja" class="form-control" >
                                                                    <option value="<?= $dataterapis["statusPekerja"]; ?>"><?= $dataterapis["statusPekerja"]; ?></option>
                                                                    <?php
                                                                        foreach ($enumstatusPekerja as $option) {
                                                                            $trimmedValue = trim($option);
                                                                            echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="noIzinPraktek">Nomor Izin Praktek </label>
                                                                <input class="form-control" type="text" name="noIzinPraktek" id="noIzinPraktek" value="<?= $dataterapis["noIzinPraktek"]; ?>" placeholder="Nomor Izin Praktek" maxlength="255" size="" >
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="dokumenSertifikasi">Dokumen Sertifikasi</label>
                                                                <input class="form-control" type="file" name="dokumenSertifikasi" id="dokumenSertifikasi">
                                                            </div>                
                                                            <div class="mb-3">
                                                                <label for="dokumenLainnya">Dokumen Lainnya</label>
                                                                <input class="form-control" type="file" name="dokumenLainnya" id="dokumenLainnya">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="keterangan" rows="3" cols="" id="floatingTextarea" ><?= $dataterapis["keterangan"]; ?></textarea>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="submit" name="editbtn" value="true" class="btn btn-primary btn-sm" style="border-radius: 25px;">SIMPAN</button>
                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">TUTUP</button>
                                                            </div>
                                                        </div>
                                                    </FORM>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            // delete
                                            $datadelete = array(
                                                array("idTerapis", $dataterapis["idTerapis"], "terapis")
                                            );
                                            _CreateWindowModalDelete($dataterapis["idTerapis"], "del", "del-form", "del-button", "lg", 200, "HAPUS#TERAPIS " . $dataterapis["idTerapis"] . " - " . $dataterapis["namaTerapis"], "", $datadelete, "", "22");

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

<p></p>
<div class="row">
    <div class="col-md-12">
        <p><br><br><br><br><br></p>
    </div>
</div>