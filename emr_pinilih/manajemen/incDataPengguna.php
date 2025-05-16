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