<?php
// insert
if (!empty($_POST["savebtn"])) {
    $linkurl = 23;

    // Mapping role ke urlbase
    $roleMapping = [
        "1" => "admin",
        "2" => "manajemen",
        "3" => "terapis"
    ];
    
    // Ambil role dari form
    $role = $_POST["role"];
    
    // Tentukan urlbase berdasarkan role
    $urlbase = isset($roleMapping[$role]) ? $roleMapping[$role] : "default";

    // Status aktif default = 1
    $status_aktif = 1;

    $datafield_user = array("nama", "jenisKelamin", "alamat", "jbtn", "urlbase", "status_aktif", "tglMulaiAktif", "noTelp", "role", "email", "username", "password", "statusPekerja", "keterangan");

    // value
    $datavalue_user = array( '"' . $_POST["nama"] . '"',  '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["alamat"] . '"','"' . $_POST["jbtn"] . '"', '"' . $urlbase . '"', '"' . $status_aktif . '"',  '"' . $_POST["tglMulaiAktif"] . '"',  '"' . $_POST["noTelp"] . '"',  '"' . $_POST["role"] . '"', '"' . $_POST["email"] . '"', '"' . $_POST["username"] . '"', '"' . md5($_POST["password"]) . '"', '"' . $_POST["statusPekerja"] . '"', '"' . $_POST["keterangan"] . '"');


    $insert = new cInsert();
    // $insert->vInsertDataTrial($datafield_user, "user", $datavalue_user, $linkurl);
    $insert->vInsertData($datafield_user, "user", $datavalue_user, $linkurl);
}
?>


<?php
// update
if (!empty($_POST["editbtn"])) {
    // Ambil data sebelumnya dari database
    $sql = "SELECT password, role, urlbase FROM user WHERE idUser = '" . $_POST["idUser"] . "'";
    $view = new cView();
    $arrayUser = $view->vViewData($sql);

    if (!empty($arrayUser)) {
        $data = $arrayUser[0]; 
        $passwd = $data["password"];
        $oldRole = $data["role"];
        $oldUrlbase = $data["urlbase"];
    }

    // Cek apakah password diubah atau tidak
    if ($_POST["password"] == $passwd) {
        $passwd = $_POST["password"];
    } else {
        $passwd = md5($_POST["password"]);
    }

    // Mapping role ke urlbase
    $roleMapping = [
        "1" => "admin",
        "2" => "manajemen",
        "3" => "terapis"
    ];
    
    // Gunakan role baru jika ada, jika tidak ada pakai yang lama
    $role = isset($_POST["role"]) && $_POST["role"] !== "" ? $_POST["role"] : $oldRole;
    
    // Tentukan urlbase berdasarkan role, tetapi tetap gunakan nilai lama jika role tidak berubah
    $urlbase = isset($roleMapping[$role]) ? $roleMapping[$role] : $oldUrlbase;
    
    $linkurl = 23;

    // Status aktif default = 1
    $status_aktif = 1;

    $datafield_user = array("nama", "jenisKelamin", "alamat", "jbtn", "urlbase", "status_aktif", "tglMulaiAktif", "noTelp", "role", "email", "username", "password", "statusPekerja", "keterangan");

    // value
    $datavalue_user = array( '"' . $_POST["nama"] . '"',  '"' . $_POST["jenisKelamin"] . '"', '"' . $_POST["alamat"] . '"', '"' . $_POST["jbtn"] . '"', '"' . $urlbase . '"', '"' . $status_aktif . '"',  '"' . $_POST["tglMulaiAktif"] . '"',  '"' . $_POST["noTelp"] . '"', '"' . $role . '"', '"' . $_POST["email"] . '"', '"' . $_POST["username"] . '"', '"' . $passwd . '"', '"' . $_POST["statusPekerja"] . '"', '"' . $_POST["keterangan"] . '"');

    $datakey = ' idUser =' . $_POST["idUser"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_user, "user", $datavalue_user, $datakey, $linkurl);
    $update->vUpdateData($datafield_user, "user", $datavalue_user, $datakey, $linkurl);
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
                    <p>DATA PENGGUNA</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Entri Data Pengguna
                </figcaption>
            </figure>
        </div>

        <div class="col-md-1">
            <?php
            // Query ENUM 'jenisKelamin'
            $jk = "SHOW COLUMNS FROM user LIKE 'jenisKelamin'";
            $view = new cView();
            $arrayJK = $view->vViewData($jk);
            $enumJK = [];
            if (!empty($arrayJK)) {
                $row = $arrayJK[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumJK = explode(",", str_replace("'", "", $matches[1]));
                }
            }

            // Query ENUM 'statusPengguna'
            $sp = "SHOW COLUMNS FROM user LIKE 'role'";
            $view = new cView();
            $arraySP = $view->vViewData($sp);
            $enumSP = [];
            if (!empty($arraySP)) {
                $row = $arraySP[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumSP = explode(",", str_replace("'", "", $matches[1]));
                }
            }
                
            // Mapping ENUM ke Label Tampilan
            $enumSPMapping = [
                "1" => "1 - Admin/Operator",
                "2" => "2 - Manajemen RKD",
                "3" => "3 - Terapis"
            ];
            // Buat array dalam format yang sesuai untuk $afield
            $enumSPForm = [];
            foreach ($enumSP as $value) {
                $trimmedValue = trim($value);
                if (isset($enumSPMapping[$trimmedValue])) {
                    $enumSPForm[$trimmedValue] = $enumSPMapping[$trimmedValue];
                }
            }

            // Query ENUM 'status_pekerja'
            $statusPekerja= "SHOW COLUMNS FROM user LIKE 'statusPekerja'";
            $view = new cView();
            $arraystatusPekerja = $view->vViewData($statusPekerja);
            $enumStatusPekerja = [];
            if (!empty($arraystatusPekerja)) {
                $row = $arraystatusPekerja[0]; // Ambil hasil pertama
                if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
                    $enumStatusPekerja = explode(",", str_replace("'", "", $matches[1]));
                }
            }
            ?>

            <button type="button" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" 
                    data-bs-toggle="modal" data-bs-target="#exampleModal" 
                    style="border-radius: 10px; width: 50%; height: 60%; display: flex;">
                <i class="fa-solid fa-plus fa-lg" style="color: #ffffff;"></i>
            </button>

            <!-- MODAL INSERT -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="exampleModalLabel">
                                <blockquote class="blockquote">
                                    <p>Tambah Data Pengguna</p>
                                </blockquote>
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="" method="post" action="23" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama">Nama Pengguna <span class="required">*</span></label>
                                    <input class="form-control" type="text" name="nama" id="nama" value="" placeholder="Nama pengguna" maxlength="255" size="" required>
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
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat pengguna" rows="3" cols="" id="floatingTextarea" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="noTelp">Nomor Telepon <span class="required">*</span></label>
                                    <input class="form-control" type="number" name="noTelp" id="noTelepon" value="" placeholder="Nomor telepon pengguna" maxlength="16" size="" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="role">Status Pengguna <span class="required">*</span></label>
                                        <select name="role" class="form-control" required>
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumSPForm as $key => $label) {
                                                    echo '<option value="' . $key . '">' . $label . '</option>';
                                                }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="jbtn">Jabatan <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="jbtn" id="jbtn" value="" placeholder="Jabatan" maxlength="255" size="" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="tglMulaiAktif">Tanggal Mulai Aktif <span class="required">*</span></label>
                                        <input class="form-control" type="date" name="tglMulaiAktif" id="tglMulaiAktif" value="" placeholder="Tanggal Mulai Aktif Pengguna" maxlength="" size="" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="statusPekerja">Status Pekerja <span class="required">*</span></label>
                                        <select name="statusPekerja" class="form-control" required>
                                            <option value="">- pilihan -</option>
                                            <?php
                                                foreach ($enumStatusPekerja as $option) {
                                                    $trimmedValue = trim($option);
                                                    echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                }
                                            ?>
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input class="form-control" type="text" name="email" id="email" value="" placeholder="Email pengguna" maxlength="255" size="" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="username">Username <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="username" id="username" value="" placeholder="Username" maxlength="255" size="" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="password">Password <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="password" id="password" value="" placeholder="Password" maxlength="255" size="" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="3" cols="" id="floatingTextarea"></textarea>
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
    </div>
    <p></p>

    <div class="row">
        <div class="col-md-12">
            <?php
            $sqlpengguna = "SELECT u.* FROM user u ORDER BY idUser DESC";
            $view = new cView();
            $arraypengguna = $view->vViewData($sqlpengguna);
            ?>
                <div id="" class='table-responsive'>
                    <table id='example' class='table table-condensed'>
                        <thead>
                            <tr class=''>
                                <th width='5%'>No.</th>
                                <th>Nama Pengguna</th>
                                <th>Jabatan</th>
                                <th>No Telepon</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th width='5%'>VIEW</th>
                                <th width='5%'>EDIT</th>
                                <th width='5%'>HAPUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($arraypengguna as $datapengguna) { ?>
                                <tr class=''>
                                    <td><?= $no++; ?></td>
                                    <td><?= $datapengguna["nama"]; ?></td>
                                    <td><?= $datapengguna["jbtn"]; ?></td>
                                    <td><?= $datapengguna["noTelp"]; ?></td>
                                    <td><?= $datapengguna["username"]; ?></td>
                                    <td><?= $datapengguna["email"]; ?></td>
                                    <td>
                                        <?php
                                        $roleLabel = isset($enumSPMapping[$datapengguna["role"]]) ? $enumSPMapping[$datapengguna["role"]] : $datapengguna["role"];

                                        $datadetail = array(
                                            array("NAMA LENGKAP", "nama", $datapengguna["nama"], 1, ""),
                                            array("JENIS KELAMIN", "jenisKelamin", $datapengguna["jenisKelamin"], 1, ""),
                                            array("JABATAN", "jbtn", $datapengguna["jbtn"], 1, ""),
                                            array("ALAMAT", "alamat", $datapengguna["alamat"], 1, ""),
                                            array("TANGGAL MULAI AKTIF", "tglMulaiAktf", $datapengguna["tglMulaiAktif"], 1, ""),
                                            array("NO TELEPON", "noTelp", $datapengguna["noTelp"], 1, ""),
                                            array("STATUS PENGGUNA", "role", $roleLabel, 1, ""),
                                            array("STATUS PEKERJA", "statusPekerja", $datapengguna["statusPekerja"], 1, ""),
                                            array("USERNAME", "username", $datapengguna["username"], 1, ""),
                                            array("EMAIL", "email", $datapengguna["email"], 1, ""),
                                            array("KETERANGAN", "keterangan", $datapengguna["keterangan"], 1, ""),
                                        );
                                        _CreateWindowModalDetil($datapengguna["idUser"], "view", "viewuser-form", "viewuser-button", "", 600, "DETAIL PENGGUNA " . $datapengguna["idUser"], "", $datadetail, "", "24", "");
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formedit<?= $datapengguna["idUser"]; ?>" style="border-radius: 8px;">
                                            <i class="fa-regular fa-pen-to-square" style="color: #000000;"></i>
                                        </button>

                                        <div class="modal fade" id="formedit<?= $datapengguna["idUser"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content text-left">
                                                    <div class="modal-header">
                                                        <figure class="text-left">
                                                            <blockquote class="blockquote">EDIT DATA PENGGUNA</blockquote>
                                                            <figcaption class="blockquote-footer"><?= $datapengguna["idUser"]; ?></figcaption>                                     
                                                            <figcaption class="blockquote-footer"><?= $datapengguna["nama"]?> - <?= $datapengguna["jbtn"]?></figcaption>                                     
                                                        </figure>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <FORM method="post" enctype="multipart/form-data" action="23">
                                                    <div class="modal-body">
                                                            <div class="mb-3">
                                                                <input class="form-control" type="text" name="idUser" id="idUser" value="<?= $datapengguna["idUser"]; ?>" hidden>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama">Nama Pengguna <span class="required">*</span></label>
                                                                <input class="form-control" type="text" name="nama" id="nama" value="<?= $datapengguna["nama"]; ?>" placeholder="Nama Lengkap Pengguna" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenisKelamin">Jenis Kelamin <span class="required">*</span></label>
                                                                <select name="jenisKelamin" class="form-control" required>
                                                                    <option value="<?= $datapengguna["jenisKelamin"]; ?>"><?= $datapengguna["jenisKelamin"]; ?></option>
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
                                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat pengguna" rows="3" cols="" id="floatingTextarea" required><?= $datapengguna["alamat"]; ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="noTelp">Nomor Telepon <span class="required">*</span></label>
                                                                <input class="form-control" type="number" name="noTelp" id="noTelp" value="<?= $datapengguna["noTelp"]; ?>" placeholder="Nomor Telepon Pengguna" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="role">Status Pengguna <span class="required">*</span></label>
                                                                    <select name="role" class="form-control" required>
                                                                        <option value="<?= $datapengguna["role"]; ?>"><?= $datapengguna["role"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumSPForm as $key => $label) {
                                                                                echo '<option value="' . $key . '">' . $label . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="jbtn">Jabatan <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="jbtn" id="jbtn" value="<?= $datapengguna["jbtn"]; ?>" placeholder="Jabatan (Admin/Manajemen/Terapis)" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                        <label for="tglMulaiAktif">Tanggal Mulai Aktif <span class="required">*</span> </label>
                                                                        <input class="form-control" type="date" name="tglMulaiAktif" id="tglMulaiAktif" value="<?= $datapengguna["tglMulaiAktif"]; ?>" placeholder="Tanggal Mulai Aktif" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="statusPekerja">Status Pekerja <span class="required">*</span></label>
                                                                    <select name="statusPekerja" class="form-control" required>
                                                                        <option value="<?= $datapengguna["statusPekerja"]; ?>"><?= $datapengguna["statusPekerja"]; ?></option>
                                                                        <?php
                                                                            foreach ($enumStatusPekerja as $option) {
                                                                                $trimmedValue = trim($option);
                                                                                echo '<option value="' . $trimmedValue . '">' . $trimmedValue . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email">Email <span class="required">*</span></label>
                                                                <input class="form-control" type="text" name="email" id="email" value="<?= $datapengguna["email"]; ?>" placeholder="Email" maxlength="255" size="" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label for="username">Username <span class="required">*</span></label>
                                                                    <input class="form-control" type="text" name="username" id="username" value="<?= $datapengguna["username"]; ?>" placeholder="username" maxlength="255" size="" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label for="password">Password <span class="required">*</span></label>
                                                                    <input class="form-control" type="password" name="password" id="password" value="<?= $datapengguna["password"]; ?>" placeholder="password" maxlength="255" size="" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan">Keterangan </label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="keterangan Pengguna" rows="3" cols="" id="floatingTextarea" ><?= $datapengguna["keterangan"]; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="editbtn" value="true" class="btn btn-primary btn-sm" style="border-radius: 25px;">SIMPAN</button>
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">TUTUP</button>
                                                        </div>
                                                    </FORM>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <?php
                                        // delete
                                        $datadelete = array(
                                            array("idUser", $datapengguna["idUser"], "user")
                                        );
                                        _CreateWindowModalDelete($datapengguna["idUser"], "del", "del-form", "del-button", "lg", 200, "HAPUS#PENGGUNA " . $datapengguna["idUser"] . " - " . $datapengguna["nama"], "", $datadelete, "", "23");
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