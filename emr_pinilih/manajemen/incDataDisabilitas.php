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

    <script src="../manajemen/js/jquery.min.js" type="text/javascript"></script>
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