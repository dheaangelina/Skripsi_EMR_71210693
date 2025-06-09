<?php
date_default_timezone_set('Asia/Jakarta');

require '../vendor/autoload.php'; // Path ke PhpSpreadsheet (jika menggunakan composer)

// Gunakan namespace PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");

$conn = new cConnect();
$conn->goConnect();
$view = new cView();

$idPasien = $_POST['idPasien'] ?? null;
$tanggalMulai = $_POST['tanggalMulai'] ?? null;
$tanggalSelesai = $_POST['tanggalSelesai'] ?? null;

if (!$idPasien) {
    die("ID Pasien tidak ditemukan.");
}

$sqlhasil = "SELECT hasil.*, jp.*, pr.*, p.*, t.*
            FROM hasil_layanan hasil 
            JOIN jadwal_program jp ON jp.idJadwal = hasil.idJadwal 
            JOIN program pr ON pr.idProgram = jp.idProgram
            JOIN pasien p ON p.idPasien = hasil.idPasien
            JOIN terapis t ON t.idTerapis = hasil.idTerapis
            WHERE hasil.idPasien = '$idPasien'";

if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
    $sqlhasil .= " AND jp.tanggalKegiatan BETWEEN '$tanggalMulai' AND '$tanggalSelesai'";
} elseif (!empty($tanggalMulai)) {
    $sqlhasil .= " AND jp.tanggalKegiatan >= '$tanggalMulai'";
} elseif (!empty($tanggalSelesai)) {
    $sqlhasil .= " AND jp.tanggalKegiatan <= '$tanggalSelesai'";
}

$sqlhasil .= " ORDER BY jp.tanggalKegiatan DESC";
$datahasil = $view->vViewData($sqlhasil);

if (empty($datahasil)) {
    die("Data tidak ditemukan.");
}

// Definisi kolom hasil layanan per program
$kolomPerProgram = [
    1 => ["areaTubuh"],
    2 => ["tingkatNyeri", "waktuMunculKeluhan", "sifatSakit", "obat", "posturTubuh", "ROM", "positive", "management"]
];

// Mapping nama kolom ke teks deskriptif
$namaKolom = [
    "areaTubuh" => "Area Terapi Tubuh",
    "tingkatNyeri" => "Tingkat Nyeri",
    "waktuMunculKeluhan" => "Waktu Muncul Keluhan",
    "sifatSakit" => "Sifat Sakit",
    "obat" => "Obat",
    "posturTubuh" => "Postur Tubuh",
    "ROM" => "Range of Motion (ROM)",
    "positive" => "Positive",
    "management" => "Management"
];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Ambil nama pasien dari database berdasarkan idPasien
$sqlPasien = "SELECT namaLengkap FROM pasien WHERE idPasien = '$idPasien'";
$dataPasien = $view->vViewData($sqlPasien);
$namaPasien = $dataPasien[0]['namaLengkap'] ?? 'Tidak Diketahui';

// Ambil tanggal saat ini
$tanggalCetak = date("d-m-Y H:i");

// Judul laporan
$judul = "Detail Rekam Medis Pasien: $namaPasien";
$tanggalJudul = "Dicetak pada: $tanggalCetak";

// Menggabungkan sel untuk judul
$colIndex = 1;
$sheet->mergeCells('A1:' . getExcelColumn($colIndex - 1) . '1');
$sheet->mergeCells('A2:' . getExcelColumn($colIndex - 1) . '2');

// Menulis judul dan tanggal
$sheet->setCellValue('A1', $judul);
$sheet->setCellValue('A2', $tanggalJudul);

// Format judul agar terlihat rapi
$sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(2)->setRowHeight(20);

// Menyusun daftar semua kolom yang akan digunakan
$allKolom = array_merge(...array_values($kolomPerProgram));
// Menulis header ke Excel
$sheet->fromArray(["No", "Tanggal", "Program Layanan", "Terapis", "Keluhan", "Hasil Pemeriksaan", "Diagnosis", "Rencana Tindakan"], null, 'A4');
$colIndex = 9;
foreach ($allKolom as $kolom) {
    $sheet->setCellValue(getExcelColumn($colIndex++) . '4', $namaKolom[$kolom]);
}

// Menulis data ke Excel
$row = 5;
$no = 1;
foreach ($datahasil as $data) {
    $sheet->fromArray([
        $no++, $data["tanggalKegiatan"], $data["namaProgram"], $data["namaTerapis"],
        $data["keluhan"], $data["hasilPemeriksaan"], $data["diagnosis"], $data["catatanTindakan"]
    ], null, 'A' . $row);

    $colIndex = 9;
    foreach ($allKolom as $kolom) {
        $nilai = isset($data[$kolom]) && !empty($data[$kolom]) ? $data[$kolom] : "-";
        $sheet->setCellValue(getExcelColumn($colIndex++) . $row, $nilai);
    }
    $row++;
}

// Fungsi untuk konversi angka ke huruf kolom Excel
function getExcelColumn($index) {
    return Coordinate::stringFromColumnIndex($index);
}

// Menyesuaikan ukuran kolom agar lebih rapi
$sheet->getColumnDimension('A')->setWidth(3);   // No
$sheet->getColumnDimension('B')->setWidth(10);  // Tanggal
$sheet->getColumnDimension('C')->setWidth(15);  // Program Layanan
$sheet->getColumnDimension('D')->setWidth(15);  // Terapis
$sheet->getColumnDimension('E')->setWidth(20);  // Keluhan
$sheet->getColumnDimension('F')->setWidth(20);  // Hasil Pemeriksaan
$sheet->getColumnDimension('G')->setWidth(20);  // Diagnosis
$sheet->getColumnDimension('H')->setWidth(20);  // Rencana Tindakan

// Auto-size untuk kolom hasil layanan per program
for ($i = 9; $i < $colIndex; $i++) {
    $colLetter = getExcelColumn($i);
    $sheet->getColumnDimension($colLetter)->setWidth(20);
    $sheet->getStyle($colLetter . '1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
}

// Atur teks hasil layanan agar rata tengah (mulai dari baris 5)
for ($i = 5; $i < $row; $i++) { 
    $sheet->getStyle("A$i:" . getExcelColumn($colIndex - 1) . "$i")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
}

// Membuat header lebih jelas
$sheet->getStyle('A4:AF4')->getFont()->setBold(true);
$sheet->getStyle('A4:AF4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A4:AF4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

// Wrap text untuk kolom yang mungkin memiliki teks panjang
for ($i = 4; $i < $row; $i++) { 
    $sheet->getStyle("A$i:" . getExcelColumn($colIndex - 1) . "$i")->getAlignment()->setWrapText(true);
}

$filename = 'Detail_Rekam_Medis_Pasien.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
