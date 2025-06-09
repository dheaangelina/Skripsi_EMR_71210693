<?php
date_default_timezone_set('Asia/Jakarta');

require_once("../_tcpdf/tcpdf.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cConnect.php");

$idPasien = $_SESSION['idPasien'] ?? $_POST['idPasien'] ?? 0;
if (empty($idPasien)) {
    die("ID Pasien tidak valid.");
}

$conn = new cConnect();
$conn->goConnect();
$view = new cView();

$sqlPasien = "SELECT p.*, sd.*, jd.* FROM pasien p
              JOIN sub_disabilitas sd ON sd.idSubDisabilitas = p.idSubDisabilitas
              JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas
              WHERE p.idPasien = '$idPasien'";
$dataPasien = $view->vViewData($sqlPasien);
if (empty($dataPasien)) {
    die("Data pasien tidak ditemukan.");
}

$namaPasien = $dataPasien[0]['namaLengkap'];
$tanggalCetak = date("d-m-Y H:i");

$kolomPerProgram = [
    1 => ["areaTubuh" => "Area Tubuh"],
    2 => [
        "tingkatNyeri" => "Tingkat Nyeri",
        "waktuMunculKeluhan" => "Waktu Muncul Keluhan",
        "sifatSakit" => "Sifat Sakit",
        "obat" => "Obat",
        "posturTubuh" => "Postur Tubuh",
        "ROM" => "ROM",
        "positive" => "Positive",
        "management" => "Management"
    ]
];

$sqlhasil = "SELECT hasil.*, jp.*, pr.*, t.*, p.* 
             FROM hasil_layanan hasil 
             JOIN jadwal_program jp ON jp.idJadwal = hasil.idJadwal 
             JOIN pasien p ON hasil.idPasien = p.idPasien
             JOIN program pr ON pr.idProgram = jp.idProgram
             JOIN terapis t ON t.idTerapis = hasil.idTerapis
             WHERE hasil.idPasien = '$idPasien'";

$where = [];
if (!empty($_POST['tanggalMulai']) && !empty($_POST['tanggalSelesai'])) {
    $where[] = "jp.tanggalKegiatan BETWEEN '" . $_POST['tanggalMulai'] . "' AND '" . $_POST['tanggalSelesai'] . "'";
} elseif (!empty($_POST['tanggalMulai'])) {
    $where[] = "jp.tanggalKegiatan >= '" . $_POST['tanggalMulai'] . "'";
} elseif (!empty($_POST['tanggalSelesai'])) {
    $where[] = "jp.tanggalKegiatan <= '" . $_POST['tanggalSelesai'] . "'";
}
if (!empty($where)) {
    $sqlhasil .= " AND " . implode(" AND ", $where);
}
$sqlhasil .= " ORDER BY jp.tanggalKegiatan DESC";

$arrayhasil = $view->vViewData($sqlhasil);
if (empty($arrayhasil)) {
    die("Tidak ada data hasil layanan yang ditemukan.");
}

function printTableHeader($pdf, $w, $header) {
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetFillColor(230, 230, 230);
    for ($i = 0; $i < count($header); $i++) {
        $pdf->MultiCell($w[$i], 8, $header[$i], 1, 'C', 1, 0);
    }
    $pdf->Ln();
}

// Buat PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rumah Kebugaran Difabel Yayasan Pinilih Sejahtera');
$pdf->SetTitle('Rekam Medis - ' . $namaPasien);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->MultiCell(0, 10, 'Rumah Kebugaran Difabel Yayasan Pinilih Sejahtera', 0, 'C', 0, 1);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->MultiCell(0, 10, 'REKAM MEDIS ' . strtoupper($namaPasien), 0, 'C', 0, 1);
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, 'Tanggal Cetak: ' . $tanggalCetak, 0, 'C', 0, 1);
$pdf->Ln(8);

// Header tabel
$header = ['No', 'Tanggal', 'Program Layanan', 'Terapis', 'Keluhan', 'Hasil Pemeriksaan', 'Diagnosis', 'Rencana Tindakan'];
$w = [8, 20, 22, 20, 25, 30, 25, 30];

printTableHeader($pdf, $w, $header);
$pdf->SetFont('helvetica', '', 9);

$no = 1;
foreach ($arrayhasil as $row) {
    $cellData = [
        $no++,
        $row['tanggalKegiatan'],
        $row['namaProgram'],
        $row['namaTerapis'],
        $row['keluhan'],
        $row['hasilPemeriksaan'],
        $row['diagnosis'],
        $row['catatanTindakan']
    ];

    // Hitung tinggi maksimum baris
    $maxHeight = 0;
    $cellHeights = [];
    foreach ($cellData as $idx => $text) {
        $lines = $pdf->getNumLines($text, $w[$idx]);
        $height = $lines * 5;
        $cellHeights[] = $height;
        if ($height > $maxHeight) {
            $maxHeight = $height;
        }
    }

    // Cek apakah cukup ruang di halaman
    if ($pdf->GetY() + $maxHeight > ($pdf->getPageHeight() - $pdf->getBreakMargin())) {
        $pdf->AddPage();
        printTableHeader($pdf, $w, $header);
        $pdf->SetFont('helvetica', '', 9);
    }

    $startX = $pdf->GetX();
    $startY = $pdf->GetY();

    foreach ($cellData as $idx => $text) {
        $pdf->MultiCell($w[$idx], $maxHeight, $text, 1, 'L', 0, 0, $startX, $startY, true, 0, false, true, $maxHeight, 'M');
        $startX += $w[$idx];
    }
    $pdf->Ln($maxHeight);

    // Cetak detail hasil jika ada
    if (isset($kolomPerProgram[$row['idProgram']])) {
        $pdf->SetFont('helvetica', '', 8);
        $detailItems = [];
        foreach ($kolomPerProgram[$row['idProgram']] as $dbColumn => $label) {
            $value = $row[$dbColumn] ?? '-';
            $detailItems[] = "$label : $value";
        }
        $detailText = "Detail Hasil:\n" . implode("\n", $detailItems);

        $detailHeight = $pdf->getStringHeight(180, $detailText, false, true, '', 1.5);
        if ($pdf->GetY() + $detailHeight > ($pdf->getPageHeight() - $pdf->getBreakMargin())) {
            $pdf->AddPage();
            printTableHeader($pdf, $w, $header);
            $pdf->SetFont('helvetica', '', 9);
        }

        $pdf->MultiCell(0, 0, $detailText, 'LRB', 'L', 0, 1);
        $pdf->SetFont('helvetica', '', 9);
    }
}

$pdf->Output('Rekam_Medis_' . preg_replace('/[^a-z0-9]/i', '_', $namaPasien) . '.pdf', 'I');
?>
