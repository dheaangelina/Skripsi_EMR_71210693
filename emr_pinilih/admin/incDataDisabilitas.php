<?php
if (!empty($_POST["savebtn"])) {
    $linkurl = 24;

    // Data untuk sub disabilitas
    $datafield_dis = array("idJenisDisabilitas", "namaDisabilitas");

    if (!empty($_POST["idJenisDisabilitas"]) && $_POST["idJenisDisabilitas"] !== "baru") {
        // Jika sudah ada, langsung masukkan ke sub disabilitas
        $idJenisDisabilitas = $_POST["idJenisDisabilitas"];
    } else {
        // Jika disabilitas baru, insert ke tabel jenis disabilitas dulu
        $datafield_jd = array("jenisDisabilitas");
        $datavalue_jd = array("'" . $_POST["jenisDisabilitasBaru"] . "'");

        $insert1 = new cInsert();
        $idJenisDisabilitas = $insert1->vInsertData($datafield_jd, "jenis_disabilitas", $datavalue_jd, $linkurl);
    }

    // Insert ke peserta_edukasi jika $idPeserta valid
    if ($idJenisDisabilitas) {
        $datavalue_dis = array($idJenisDisabilitas, "'" . $_POST["namaDisabilitas"] . "'");
        $insert2 = new cInsert();
        $insert2->vInsertData($datafield_dis, "sub_disabilitas", $datavalue_dis, $linkurl);
    }
}
?>

<?php
// update
if (!empty($_POST["editbtn"])) {
    $linkurl = 24;

    $idJenisDisabilitas = $_POST["idJenisDisabilitas"] ? $_POST['idJenisDisabilitas'] : NULL;

    $datafield_dis = array("idJenisDisabilitas", "namaDisabilitas");

    $datavalue_dis = array($idJenisDisabilitas !== NULL ? $idJenisDisabilitas : "NULL", "'" . $_POST["namaDisabilitas"] . "'");

    $datakey = ' idSubDisabilitas =' . $_POST["idSubDisabilitas"] . '';

    $update = new cUpdate();
    // $update->vUpdateDataTrial($datafield_dis, "sub_disabilitas", $datavalue_dis, $datakey, $linkurl);
    $update->vUpdateData($datafield_dis, "sub_disabilitas", $datavalue_dis, $datakey, $linkurl);
}
?>

<?php
// delete
if (!empty($_POST["btnhapus"])) {
    $delete = new cDelete();
    foreach ($_POST["hiddendeletevalue"] as $data) {
        $idSubDisabilitas = $data["value"]; // ID Sub Disabilitas yang akan dihapus

        // Ambil idJenisDisabilitas dari sub_disabilitas sebelum dihapus
        $queryGetJenis = "SELECT idJenisDisabilitas FROM sub_disabilitas WHERE idSubDisabilitas = '$idSubDisabilitas'";
        $resultGetJenis = mysqli_query($GLOBALS["conn"], $queryGetJenis);
        $row = mysqli_fetch_assoc($resultGetJenis);
        $idJenisDisabilitas = $row["idJenisDisabilitas"];

        // Hapus sub_disabilitas terlebih dahulu
        $delete->_dDeleteData($data["field"], $data["value"], $data["table"]);

        // Cek apakah idJenisDisabilitas masih digunakan di tabel sub_disabilitas
        $queryCheck = "SELECT COUNT(*) as jumlah FROM sub_disabilitas WHERE idJenisDisabilitas = '$idJenisDisabilitas'";
        $resultCheck = mysqli_query($GLOBALS["conn"], $queryCheck);
        $rowCheck = mysqli_fetch_assoc($resultCheck);

        if ($rowCheck["jumlah"] == 0) {
            // Jika tidak ada lagi sub_disabilitas yang menggunakan idJenisDisabilitas, hapus dari jenis_disabilitas
            $delete->_dDeleteData("idJenisDisabilitas", $idJenisDisabilitas, "jenis_disabilitas");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Disabilitas</title>
    <!-- Load jQuery DULU -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load DataTables SETELAH jQuery -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="../admin/js/jquery.min.js" type="text/javascript"></script>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-11">
            <figure>
                <blockquote class="blockquote">
                    <p>DATA DISABILITAS</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Entri Data Disabilitas
                </figcaption>
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
                                    <p>Tambah Data Disabilitas</p>
                                </blockquote>
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="24" enctype="multipart/form-data">
                            <div class="modal-body">
                                <!-- Pilih Jenis Disabilitas -->
                                <div id="selectDisabilitasContainer">
                                    <div class="mb-3">
                                        <label for="pilihJD">Pilih Jenis Disabilitas</label>
                                        <select id="pilihJD" name="idJenisDisabilitas" class="form-control" required>
                                            <option value="">- Pilih Jenis Disabilitas -</option>
                                            <?php 
                                            // Ambil data jenis disabilitas dari database
                                            $queryJD = "SELECT * FROM jenis_disabilitas";
                                            $resultJD = mysqli_query($GLOBALS["conn"], $queryJD);
                                            while ($row = mysqli_fetch_assoc($resultJD)) : ?>
                                                <option value="<?= $row['idJenisDisabilitas'] ?>"><?= $row['jenisDisabilitas'] ?></option>
                                            <?php endwhile; ?>
                                            <option value="baru" style="color: blue;"> + Tambah Jenis Disabilitas Baru</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namaDisabilitas">Sub Jenis Disabilitas <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="namaDisabilitas" id="namaDisabilitas" placeholder="Nama Disabilitas" maxlength="255">
                                    </div>
                                </div>

                                <!-- Form Jenis Disabilitas Baru -->
                                <div id="formDisabilitasBaru" style="display: none;">
                                    <div class="mb-3">
                                        <label for="jenisDisabilitasBaru">Jenis Disabilitas <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="jenisDisabilitasBaru" id="jenisDisabilitasBaru" placeholder="Jenis Disabilitas" maxlength="255" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namaDisabilitasBaru">Sub Jenis Disabilitas <span class="required">*</span></label>
                                        <input class="form-control" type="text" name="namaDisabilitas" id="namaDisabilitasBaru" placeholder="Nama Disabilitas" maxlength="255" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 25px;" name="savebtn" value="true">Simpan</button>
                                <button type="reset" class="btn btn-warning btn-sm" style="border-radius: 25px;">Ulang</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 25px;">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("pilihJD").addEventListener("change", function () {
                if (this.value === "baru") {
                    // Sembunyikan hanya dropdown, tetapi biarkan input sub jenis tetap terlihat
                    document.getElementById("selectDisabilitasContainer").style.display = "none";
                    document.getElementById("formDisabilitasBaru").style.display = "block";

                    // Aktifkan input dalam form jenis disabilitas baru
                    document.querySelectorAll("#formDisabilitasBaru input").forEach(el => {
                        el.removeAttribute("disabled");
                    });

                    // Pastikan nama input sub jenis tetap sesuai agar terkirim dalam form
                    document.getElementById("namaDisabilitasBaru").setAttribute("name", "namaDisabilitas");
                } else {
                    // Jika memilih jenis yang ada, tampilkan kembali dropdown
                    document.getElementById("selectDisabilitasContainer").style.display = "block";
                    document.getElementById("formDisabilitasBaru").style.display = "none";

                    // Matikan kembali input jenis disabilitas baru
                    document.querySelectorAll("#formDisabilitasBaru input").forEach(el => {
                        el.setAttribute("disabled", "true");
                    });

                    document.getElementById("namaDisabilitasBaru").removeAttribute("name");
                }
            });
        });
        </script>

        <div class="row">
            <div class="col-md-12">
                <?php
                $sqldisabilitas = "SELECT sd.idSubDisabilitas, jd.idJenisDisabilitas, jd.jenisDisabilitas, sd.namaDisabilitas 
                                    FROM sub_disabilitas sd
                                    JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas
                                    ORDER BY idSubDisabilitas DESC";
                $view = new cView();
                $arraydisabilitas = $view->vViewData($sqldisabilitas);
                ?>
                <div id="" class='table-responsive'>
                    <table id='example' class='table table-condensed'>
                        <thead>
                            <tr class=''>
                                <th width='15%' class="text-right">No.</th>
                                <th width=''>Jenis Disabilitas</th>
                                <th width=''>Subjenis Disabilitas</th>
                                <th width='5%'>VIEW</th>
                                <th width='5%'>EDIT</th>
                                <th width='5%'>HAPUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cnourut = 0; 
                            foreach ($arraydisabilitas as $datadisabilitas) { 
                                $cnourut = $cnourut + 1;
                            ?>
                                <tr class=''>
                                    <td class="text-right"><?= $cnourut; ?></td>
                                    <td><?= $datadisabilitas["jenisDisabilitas"]; ?></td>
                                    <td><?= $datadisabilitas["namaDisabilitas"]; ?></td>
                                    <td>
                                        <?php
                                        $datadetail = array(
                                            array("ID", "idSubDisabilitas", $datadisabilitas["idSubDisabilitas"], 1, ""),
                                            array("JENIS DISABILITAS", "", $datadisabilitas["jenisDisabilitas"], 1, ""),
                                            array("NAMA DISABILITAS", "", $datadisabilitas["namaDisabilitas"], 1, ""),
                                        );
                                        _CreateWindowModalDetil($datadisabilitas["idSubDisabilitas"], "view", "viewsasaran-form", "viewsasaran-button", "", 600, "DETIL#DISABILITAS", "", $datadetail, "", "24", "");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // update
                                        $dataupdate = array(
                                            // array("CAPTION", "field", data, type, "query"),
                                            array("ID SUB DISABILITAS", "idSubDisabilitas", $datadisabilitas["idSubDisabilitas"], 2, ""),
                                            array("Jenis Disabilitas", "idJenisDisabilitas", $datadisabilitas["idJenisDisabilitas"], 52, "SELECT idJenisDisabilitas field1, CONCAT(jenisDisabilitas, '-', idJenisDisabilitas) field2 FROM jenis_disabilitas ORDER BY idJenisDisabilitas"),
                                            array("Nama Disabilitas", "namaDisabilitas", $datadisabilitas["namaDisabilitas"], 12, ""),
                                        );

                                        // $number, $type, $name, $button, $width, $height, $title, $acaption, $afield, $value, $linkurl
                                        _CreateWindowModalUpdate("edit" . $datadisabilitas["idSubDisabilitas"], "edit", "edit-form", "edit-button", "", "", 'EDIT DISABILITAS#' . $datadisabilitas["idSubDisabilitas"] . '#' . $datadisabilitas["namaDisabilitas"], "", $dataupdate, "", "24");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // delete
                                        $datadelete = array(
                                            array("idSubDisabilitas", $datadisabilitas["idSubDisabilitas"], "sub_disabilitas")
                                        );
                                        _CreateWindowModalDelete($datadisabilitas["idSubDisabilitas"], "del", "del-form", "del-button", "lg", 200, "HAPUS#DISABILITAS " . $datadisabilitas["idSubDisabilitas"] . "#" . $datadisabilitas["jenisDisabilitas"]. " - " .$datadisabilitas["namaDisabilitas"], "", $datadelete, "", "24");
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