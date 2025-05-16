<?php
// session_start();
require_once("../_tcpdf/tcpdf.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cConnect.php");

$conn = new cConnect();
$conn->goConnect();

$tanggalCetak = date("d-m-Y H:i", strtotime("+6 hours"));

class MYPDF extends TCPDF {
    public function Header() {
        global $tanggalCetak;

        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Laporan Data Pasien (' . $tanggalCetak . ')', 0, 1, 'C');
        $this->Ln(5);
    }
}

$pdf = new MYPDF();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$view = new cView();
$where = [];

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

$sql = "SELECT p.*, jd.jenisDisabilitas, subJD.namaDisabilitas 
        FROM pasien p 
        LEFT JOIN sub_disabilitas subJD ON subJD.idSubDisabilitas = p.idSubDisabilitas 
        LEFT JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = subJD.idJenisDisabilitas";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " GROUP BY p.idPasien";

$data = $view->vViewData($sql);

$html = '<table border="1" cellpadding="5">
            <thead>
                <tr bgcolor="#d3d3d3">
                    <th width="5%">No</th>
                    <th width="12%">Nama Pasien</th>
                    <th width="12%">Jenis Kelamin</th>
                    <th width="13%">Usia</th>
                    <th width="10%">Golongan Darah</th>
                    <th width="14%">Alamat</th>
                    <th width="12%">Jenis Disabilitas</th>
                    <th width="12%">Sub Jenis Disabilitas</th>
                    <th width="12%">Alat Bantu</th>
                </tr>
            </thead>
            <tbody>';

$no = 1;
foreach ($data as $row) {
    $html .= '<tr>
                <td width="5%" align="center">' . $no++ . '</td>
                <td width="12%">' . htmlspecialchars($row['namaLengkap']) . '</td>
                <td width="12%" align="center">' . htmlspecialchars($row['jenisKelamin']) . '</td>
                <td width="13%" align="center">' . htmlspecialchars($row['kelompokUsia']) . '</td>
                <td width="10%" align="center">' . htmlspecialchars($row['golonganDarah']) . '</td>
                <td width="14%" align="center">' . htmlspecialchars($row['alamatDomisili']) . '</td>
                <td width="12%">' . htmlspecialchars($row['jenisDisabilitas']) . '</td>
                <td width="12%">' . htmlspecialchars($row['namaDisabilitas']) . '</td>
                <td width="12%">' . htmlspecialchars($row['alatBantu']) . '</td>
            </tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Laporan_Pasien.pdf', 'I');
?>
