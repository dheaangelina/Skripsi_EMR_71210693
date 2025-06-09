<?php
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");

$conn = new cConnect();
$conn->goConnect();

header("Content-Type: application/json");

//filter bulan dan tahun
$bulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : 0;
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 0;

$sql = "SELECT namaProgram, COUNT(*) AS jumlah FROM jadwal_program jp
        JOIN program ON program.idProgram = jp.idProgram";

if ($bulan > 0) {
    $sql .= " AND MONTH(jp.tanggalKegiatan) = $bulan";
}

if ($tahun > 0) {
    $sql .= " AND YEAR(jp.tanggalKegiatan) = $tahun";
}

$sql .= " GROUP BY namaProgram ORDER BY jp.idProgram";

$view = new cView();
$arrayhasil = $view->vViewData($sql);

$labels = [];
$datas = [];

foreach ($arrayhasil as $value) {
    $labels[] = $value["namaProgram"];
    $datas[] = (int)$value["jumlah"];
}

echo json_encode([
    "labels" => $labels,
    "datas" => $datas
]);
?>
