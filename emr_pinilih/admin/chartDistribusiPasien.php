<?php
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");

$conn = new cConnect();
$conn->goConnect();

header("Content-Type: application/json");

// Ambil tahun dari GET atau gunakan tahun saat ini jika tidak ada input
$tahun = isset($_GET["tahun"]) && !empty($_GET["tahun"]) ? intval($_GET["tahun"]) : date("Y");

// Query untuk mendapatkan jumlah pasien per bulan
// LEFT JOIN supaya semua bulan tetap muncul meskipun tidak ada data jumlah pasiennya
$sql = "WITH Bulan AS (
    SELECT 1 AS bulan UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
    UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 
    UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
)
SELECT 
    b.bulan,
    COALESCE(SUM(CASE WHEN j.idProgram = 1 AND h.idPasien IS NOT NULL THEN 1 ELSE 0 END), 0) AS fisioterapi,
    COALESCE(SUM(CASE WHEN j.idProgram = 2 AND h.idPasien IS NOT NULL THEN 1 ELSE 0 END), 0) AS kinesioterapi
FROM Bulan b
LEFT JOIN jadwal_program j 
    ON MONTH(j.tanggalKegiatan) = b.bulan 
    AND YEAR(j.tanggalKegiatan) = $tahun
LEFT JOIN hasil_layanan h 
    ON j.idJadwal = h.idJadwal
GROUP BY b.bulan
ORDER BY b.bulan";

$view = new cView();
$data = $view->vViewData($sql);

$result = [
    "labels" => [],
    "datasets" => [
        "fisioterapi" => [],
        "kinesioterapi" => []
    ]
];

// Mempermudah akses data berdasarkan bulan dan memastikan bulan 1-12 tetap muncul meskipun datanya kosong
$bulanArray = range(1, 12);
$dataMap = [];
foreach ($data as $row) {
    $dataMap[$row["bulan"]] = $row;
}

foreach ($bulanArray as $bulan) {
    $result["labels"][] = $bulan;
    $result["datasets"]["fisioterapi"][] = $dataMap[$bulan]["fisioterapi"] ?? 0;
    $result["datasets"]["kinesioterapi"][] = $dataMap[$bulan]["kinesioterapi"] ?? 0;
}

echo json_encode($result);
?>
