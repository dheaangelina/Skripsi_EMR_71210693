<?php
// insert
if (!empty($_POST["savebtn"])) {
    $linkurl = 31;

    $_POST["idProgram"] = 1;
    $idUser = $_SESSION["idUser"];
    // field
    $datafield_jadwal = array("idProgram", "idUser", "tanggalKegiatan", "waktuMulai", "waktuSelesai", "lokasi", "instansi", "catatan");

    // value
    $datavalue_jadwal = array($_POST["idProgram"], $idUser, "'" . $_POST["tanggalKegiatan"] . "'", "'" . $_POST["waktuMulai"] . "'", "'" . $_POST["waktuSelesai"] . "'", "'" . $_POST["lokasi"] . "'", "'" . $_POST["instansi"] . "'", "'" . $_POST["catatan"] . "'");

    $insert = new cInsert();
    // $insert->vInsertDataTrial($datafield_jadwal, "jadwal_program", $datavalue_jadwal, $linkurl);
    $insert->vInsertData($datafield_jadwal, "jadwal_program", $datavalue_jadwal, $linkurl);
}
?>

<?php
// update
if (!empty($_POST["editbtn"])) {
    $linkurl = 31;

    $_POST["idProgram"] = 1;
    $idUser = $_SESSION["idUser"];
    $datafield_jadwal = array("idProgram", "idUser", "tanggalKegiatan", "waktuMulai", "waktuSelesai", "lokasi", "instansi", "catatan");

    $datavalue_jadwal = array($_POST["idProgram"], $idUser, "'" . $_POST["tanggalKegiatan"] . "'", "'" . $_POST["waktuMulai"] . "'", "'" . $_POST["waktuSelesai"] . "'", "'" . $_POST["lokasi"] . "'", "'" . $_POST["instansi"] . "'", "'" . $_POST["catatan"] . "'");

    $datakey = ' idJadwal =' . $_POST["idJadwal"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_jadwal, "jadwal_program", $datavalue_jadwal, $datakey, $linkurl);
    $update->vUpdateData($datafield_jadwal, "jadwal_program", $datavalue_jadwal, $datakey, $linkurl);
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

<div class="row">
    <div class="col-md-11">
        <?php
        _myHeader("FISIOTERAPI", "Jadwal Program Fisioterapi");
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
                                <p>Tambah Jadwal Fisioterapi</p>
                            </blockquote>
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="" method="post" action="31" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggalKegiatan">Tanggal Kegiatan <span class="required">*</span></label>
                                <input class="form-control" type="date" name="tanggalKegiatan" id="tanggalKegiatan" value="" placeholder="Tanggal Kegiatan" maxlength="255" size="" required>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="waktuMulai">Waktu Mulai <span class="required">*</span></label>
                                    <input class="form-control" type="time" name="waktuMulai" id="waktuMulai" value="" placeholder="Waktu Mulai (hh:mm:ss)" maxlength="255" size="" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="waktuSelesai">Waktu Selesai <span class="required">*</span></label>
                                    <input class="form-control" type="time" name="waktuSelesai" id="waktuSelesai" value="" placeholder="Waktu Selesai (hh:mm:ss)" maxlength="255" size="" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi">Lokasi Kegiatan <span class="required">*</span></label>
                                <input class="form-control" type="text" name="lokasi" id="lokasi" value="" placeholder="Lokasi Kegiatan" maxlength="255" size="" required>
                            </div>
                            <div class="mb-3">
                                <label for="instansi">Instansi <span class="required">*</span></label>
                                <input class="form-control" type="text" name="instansi" id="instansi" value="" placeholder="Instansi Penanggung Jawab" maxlength="255" size="" required>
                            </div>
                            <div class="mb-3">
                                <label for="catatan">Catatan Kegiatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan Kegiatan" rows="3" cols="" id="floatingTextarea"></textarea>
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

<p></p>
<div class="row">
    <div class="col-md-12">
        <?php
        $sqljadwal = "SELECT jp.*, prog.*, u.* FROM jadwal_program jp 
                    JOIN program prog ON jp.idProgram = prog.idProgram 
                    JOIN user u ON jp.idUser = u.idUser
                    WHERE jp.idProgram = 1
                    ORDER BY jp.tanggalKegiatan DESC";
        $view = new cView();
        $arrayjadwal = $view->vViewData($sqljadwal);
        ?>
        <div id="" class='table-responsive'>
            <table id='example' class='table table-condensed'>
                <thead>
                    <tr>
                        <th width='5%' class="text-right">No.</th>
                        <th width=''>Tanggal</th>
                        <th width=''>Waktu Mulai</th>
                        <th width=''>Waktu Selesai</th>
                        <th width=''>Instansi</th>
                        <th width='5%'>VIEW</th>
                        <th width='5%'>EDIT</th>
                        <th width='5%'>HAPUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnourut = 0;
                    foreach ($arrayjadwal as $datajadwal) {
                        $cnourut = $cnourut + 1;
                    ?>
                        <tr class=''>
                            <td class="text-right"><?= $cnourut; ?></td>
                            <td><?= $datajadwal["tanggalKegiatan"]; ?></td>
                            <td><?= $datajadwal["waktuMulai"]; ?></td>
                            <td><?= $datajadwal["waktuSelesai"]; ?></td>
                            <td><?= $datajadwal["instansi"]; ?></td>
                            <td>
                                <a href="311/<?php echo $datajadwal["idJadwal"]; ?>" class="btn btn-info" style="border-radius: 8px;">
                                    <i class="fa-regular fa-eye" style="color: #000000;"></i>
                                </a>
                            </td>
                            <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formedit<?= $datajadwal["idJadwal"]; ?>" style="border-radius: 8px;">
                                <i class="fa-regular fa-pen-to-square" style="color: #000000;"></i>
                            </button>
                            <!-- Modal UPDATE -->
                            <div class="modal fade" id="formedit<?= $datajadwal["idJadwal"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content text-left">
                                        <div class="modal-header">
                                            <figure class="text-left">
                                                <blockquote class="blockquote">EDIT JADWAL FISIOTERAPI</blockquote>
                                                <figcaption class="blockquote-footer"><?= $datajadwal["idJadwal"]; ?></figcaption>                                     
                                                <figcaption class="blockquote-footer"><?= $datajadwal["tanggalKegiatan"]; ?> (<?= $datajadwal["lokasi"]; ?>)</figcaption>                                     
                                            </figure>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <FORM method="post" enctype="multipart/form-data" action="31">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <input class="form-control" type="text" name="idJadwal" id="idJadwal" value="<?= $datajadwal["idJadwal"]; ?>" maxlength="255" size="" hidden>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggalKegiatan">Tanggal Kegiatan <span class="required">*</span></label>
                                                <input class="form-control" type="date" name="tanggalKegiatan" id="tanggalKegiatan" value="<?= $datajadwal["tanggalKegiatan"]; ?>" placeholder="Tanggal Kegiatan" maxlength="255" size="" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label for="waktuMulai">Waktu Mulai <span class="required">*</span></label>
                                                    <input class="form-control" type="time" name="waktuMulai" id="waktuMulai" value="<?= $datajadwal["waktuMulai"]; ?>" placeholder="Waktu Mulai (hh:mm:ss)" maxlength="255" size="" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="waktuSelesai">Waktu Selesai <span class="required">*</span></label>
                                                    <input class="form-control" type="time" name="waktuSelesai" id="waktuSelesai" value="<?= $datajadwal["waktuSelesai"]; ?>" placeholder="Waktu Selesai (hh:mm:ss)" maxlength="255" size="" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="lokasi">Lokasi Kegiatan <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="lokasi" id="lokasi" value="<?= $datajadwal["lokasi"]; ?>" placeholder="Lokasi Kegiatan" maxlength="255" size="" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="instansi">Instansi <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="instansi" id="instansi" value="<?= $datajadwal["instansi"]; ?>" placeholder="Instansi Penanggung Jawab" maxlength="255" size="" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="catatan">Catatan Kegiatan</label>
                                                <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan Kegiatan" rows="3" cols="" id="floatingTextarea"><?= $datajadwal["catatan"]; ?></textarea>
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
                                    array("idJadwal", $datajadwal["idJadwal"], "jadwal_program")
                                );
                                _CreateWindowModalDelete($datajadwal["idJadwal"], "del", "del-form", "del-button", "lg", 200, "HAPUS#JADWAL FISIOTERAPI " . $datajadwal["idJadwal"] . "#" . $datajadwal["tanggalKegiatan"] . " - " . $datajadwal["namaProgram"], "", $datadelete, "", "31");
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