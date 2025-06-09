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
        </div>
        <p></p>

        <div class="row">
            <div class="col-md-12">
                <?php
                $sqlterapis = "SELECT t.* FROM terapis t ORDER BY idTerapis DESC";
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
                                        
                                        // File dokumenSertifikasi
                                        $dokumenPath = "../admin/" . $dataterapis["dokumenSertifikasi"];
                                        $pathForCheck = __DIR__ . "/../admin/" . $dataterapis["dokumenSertifikasi"]; // untuk file_exists()

                                        if (!empty($dataterapis["dokumenSertifikasi"]) && file_exists($pathForCheck)) {
                                            $dokumenSertifikasi = '<a href="' . htmlspecialchars($dokumenPath) . '" target="_blank">Lihat Dokumen</a>';
                                        } else {
                                            $dokumenSertifikasi = '<span>Tidak ada dokumen</span>';
                                        }

                                        // File dokumenLainnya
                                        // __DIR__ = folder saat ini (manajemen/)
                                        $dokumenPath2 = "../admin/" . $dataterapis["dokumenLainnya"];
                                        $pathForCheck2 = __DIR__ . "/../admin/" . $dataterapis["dokumenLainnya"];

                                        if (!empty($dataterapis["dokumenLainnya"]) && file_exists($pathForCheck2)) {
                                            $dokumenLainnya = '<a href="' . htmlspecialchars($dokumenPath2) . '" target="_blank">Lihat Dokumen</a>';
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