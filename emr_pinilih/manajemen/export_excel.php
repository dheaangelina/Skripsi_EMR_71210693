<?php
include_once("../_function_i/cView.php");
include_once("../_function_i/cConnect.php");

$conn = new cConnect();
$conn->goConnect();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Data_Pasien.xls");
header("Pragma: no-cache");
header("Expires: 0");

$view = new cView();
$where = [];

// Filter berdasarkan input
if (!empty($_POST['kelompokUsia'])) {
    $where[] = "p.kelompokUsia = '" . $_POST['kelompokUsia'] . "'";
}
if (!empty($_POST['jenisKelamin'])) {
    $where[] = "p.jenisKelamin = '" . $_POST['jenisKelamin'] . "'";
}
if (!empty($_POST['golonganDarah'])) {
    $where[] = "p.golonganDarah = '" . $_POST['golonganDarah'] . "'";
}
if (!empty($_POST['jenisDisabilitas'])) {
    $where[] = "jd.jenisDisabilitas = '" . $_POST['jenisDisabilitas'] . "'";
}

// Query data pasien
$sql = "SELECT p.*, jd.jenisDisabilitas, subJD.namaDisabilitas 
        FROM pasien p 
        LEFT JOIN sub_disabilitas subJD ON subJD.idSubDisabilitas = p.idSubDisabilitas 
        LEFT JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = subJD.idJenisDisabilitas";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " GROUP BY p.idPasien";

$dataPasien = $view->vViewData($sql);

// Mendapatkan tanggal cetak
$tanggalCetak = date("d-m-Y H:i", strtotime("+6 hours"));

// Menampilkan judul laporan
echo "<table border='1'>";
echo "<tr><th colspan='9' style='text-align:center; font-weight:bold;'>LAPORAN DATA PASIEN</th></tr>";
echo "<tr><th colspan='9' style='text-align:center;'>Tanggal Cetak: $tanggalCetak</th></tr>";
echo "<tr><td colspan='9'></td></tr>";

// Header tabel
echo "<tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
        <th>Kelompok Usia</th>
        <th>Golongan Darah</th>
        <th>Alamat</th>
        <th>Jenis Disabilitas</th>
        <th>Sub Jenis Disabilitas</th>
        <th>Alat Bantu</th>
      </tr>";

$no = 1;
foreach ($dataPasien as $row) {
    echo "<tr>
            <td>" . $no++ . "</td>
            <td>" . $row['namaLengkap'] . "</td>
            <td>" . $row['jenisKelamin'] . "</td>
            <td>" . $row['kelompokUsia'] . "</td>
            <td>" . $row['golonganDarah'] . "</td>
            <td>" . $row['alamatLengkap'] . "</td>
            <td>" . $row['jenisDisabilitas'] . "</td>
            <td>" . $row['namaDisabilitas'] . "</td>
            <td>" . $row['alatBantu'] . "</td>
          </tr>";
}

echo "</table>";
exit;
?>
