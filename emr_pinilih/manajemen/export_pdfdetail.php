<?php
// Sertakan file TCPDF
require_once("../_tcpdf/tcpdf.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cConnect.php");

// Mulai output buffering untuk mencegah output sebelum TCPDF dijalankan
ob_start();

// Ambil idPasien dari sesi atau form
$idPasien = $_SESSION['idPasien'] ?? $_POST['idPasien'] ?? 0;

// Pastikan idPasien tersedia
if ($idPasien == 0) {
    die("ID Pasien tidak ditemukan.");
}

// Koneksi ke database
$conn = new cConnect();
$conn->goConnect();
$view = new cView();

// Query untuk mengambil data pasien
$sqlPasien = "SELECT p.*, sd.*, jd.*
              FROM pasien p
              JOIN sub_disabilitas sd ON sd.idSubDisabilitas = p.idSubDisabilitas
              JOIN jenis_disabilitas jd ON jd.idJenisDisabilitas = sd.idJenisDisabilitas
              WHERE p.idPasien = '$idPasien'";

$dataPasien = $view->vViewData($sqlPasien);

// Periksa apakah data pasien ditemukan
if (!$dataPasien) {
    die("Data pasien tidak ditemukan.");
}

// Ambil nama pasien dari hasil query
$namaPasien = $dataPasien[0]['namaLengkap'] ?? 'Tidak Diketahui';

// Definisi kolom hasil layanan per program
$kolomPerProgram = [
    1 => ["areaTubuh"],
    2 => ["tingkatNyeri", "waktuMunculKeluhan", "sifatSakit", "obat", "posturTubuh", "ROM", "positive", "management"],
    3 => ["tanggalRujukan", "alasanRujukan", "tinggiBadan", "beratBadan", "tekananDarah", "gulaDarah", "kolesterol", "trigliserida", "benjolanPayudara", "inspeksiVisualAsamAsetat", "kadarAlkoholPernafasan", "tesAmfetaminUrin", "arusPernafasanEkspirasi", "faktorResikoPerilaku"],
    4 => ["saranRujukan"]
];

// Mapping nama kolom ke teks deskriptif
$labelKolom = [
    // Fisioterapi
    "areaTubuh" => "Area tubuh yang diterapi",

    // Kinesioterapi
    "tingkatNyeri" => "Tingkat nyeri",
    "waktuMunculKeluhan" => "Waktu munculnya keluhan",
    "sifatSakit" => "Sifat sakit",
    "obat" => "Obat yang digunakan",
    "posturTubuh" => "Postur tubuh",
    "ROM" => "Range of Motion (ROM)",
    "positive" => "Tes positif",
    "management" => "Manajemen terapi",

    // Screening
    "tanggalRujukan" => "Tanggal rujukan",
    "alasanRujukan" => "Alasan rujukan",
    "tinggiBadan" => "Tinggi badan (cm)",
    "beratBadan" => "Berat badan (kg)",
    "tekananDarah" => "Tekanan darah (mmHg)",
    "gulaDarah" => "Gula darah (mg/dL)",
    "kolesterol" => "Kolesterol (mg/dL)",
    "trigliserida" => "Trigliserida (mg/dL)",
    "benjolanPayudara" => "Benjolan pada payudara",
    "inspeksiVisualAsamAsetat" => "Inspeksi visual asam asetat (IVA)",
    "kadarAlkoholPernafasan" => "Kadar alkohol dalam pernafasan",
    "tesAmfetaminUrin" => "Tes amfetamin dalam urin",
    "arusPernafasanEkspirasi" => "Arus pernafasan ekspirasi puncak",
    "faktorResikoPerilaku" => "Faktor resiko perilaku",

    // Konsultasi
    "saranRujukan" => "Saran rujukan"
];

// Query daftar program layanan yang telah diikuti pasien
$sqlhasil = "SELECT hasil.*, jp.*, pr.*, t.*, p.*
             FROM hasil_layanan hasil 
             JOIN jadwal_program jp ON jp.idJadwal = hasil.idJadwal 
             JOIN pasien p ON hasil.idPasien = p.idPasien
             JOIN program pr ON pr.idProgram = jp.idProgram
             JOIN terapis t ON t.idTerapis = hasil.idTerapis
             WHERE hasil.idPasien = '$idPasien'";

// Filter berdasarkan tanggal jika diisi
$where = [];
if (!empty($_POST['tanggalMulai']) && !empty($_POST['tanggalSelesai'])) {
    $where[] = "jp.tanggalKegiatan BETWEEN '" . $_POST['tanggalMulai'] . "' AND '" . $_POST['tanggalSelesai'] . "'";
} elseif (!empty($_POST['tanggalMulai'])) {
    $where[] = "jp.tanggalKegiatan >= '" . $_POST['tanggalMulai'] . "'";
} elseif (!empty($_POST['tanggalSelesai'])) {
    $where[] = "jp.tanggalKegiatan <= '" . $_POST['tanggalSelesai'] . "'";
}

// Tambahkan kondisi ke query jika ada filter
if (count($where) > 0) {
    $sqlhasil .= " AND " . implode(" AND ", $where);
}

$sqlhasil .= " ORDER BY jp.tanggalKegiatan DESC";

// Ambil data hasil layanan
$arrayhasil = $view->vViewData($sqlhasil);

$tanggalCetak = date("d-m-Y H:i", strtotime("+6 hours"));

// Buat class PDF dengan Header berisi nama pasien
class MYPDFDetail extends TCPDF {
    private $namaPasien;
    private $tanggalCetak;

    public function __construct($namaPasien, $tanggalCetak) {
        parent::__construct();
        $this->namaPasien = $namaPasien;
        $this->tanggalCetak = $tanggalCetak;
    }

    public function Header() {
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Rekam Medis Pasien - ' . $this->namaPasien, 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'Tanggal Cetak: ' . $this->tanggalCetak, 0, 1, 'C');
        $this->Ln(3);
    }
}

// Buat PDF baru
$pdf = new MYPDFDetail($namaPasien, $tanggalCetak);
$pdf->SetMargins(10, 20, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Header tabel hasil layanan
$html = '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr bgcolor="#d3d3d3">
                    <th width="5%" style="text-align:center;">No</th>
                    <th width="12%">Tanggal Kegiatan</th>
                    <th width="13%">Program Layanan</th>
                    <th width="13%">Terapis</th>
                    <th width="13%">Keluhan</th>
                    <th width="15%">Hasil Pemeriksaan</th>
                    <th width="15%">Diagnosis</th>
                    <th width="17%">Catatan Tindakan</th>
                </tr>
            </thead>
            <tbody>';

$no = 1;
foreach ($arrayhasil as $datahasil) {
    $idProgram = $datahasil["idProgram"];
    $kolomHasil = $kolomPerProgram[$idProgram] ?? [];

    $html .= '<tr>
                <td width="5%" align="center" rowspan="2">' . $no++ . '</td>
                <td width="12%" rowspan="2">' . $datahasil["tanggalKegiatan"] . '</td>
                <td width="13%">' . $datahasil["namaProgram"] . '</td>
                <td width="13%">' . $datahasil["namaTerapis"] . '</td>
                <td width="13%">' . $datahasil["keluhan"] . '</td>
                <td width="15%">' . $datahasil["hasilPemeriksaan"] . '</td>
                <td width="15%">' . $datahasil["diagnosis"] . '</td>
                <td width="17%">' . $datahasil["catatanTindakan"] . '</td>
            </tr>';

    // Baris tambahan untuk detail hasil layanan
    if (!empty($kolomHasil)) {
        $html .= '<tr>
                    <td colspan="6">
                        <b>Detail Hasil Layanan:</b><br>';

        // Gabungkan semua data menjadi satu string dengan format list
        $detailText = [];
        foreach ($kolomHasil as $kolom) {
            $label = isset($labelKolom[$kolom]) ? $labelKolom[$kolom] : ucfirst(str_replace('_', ' ', $kolom));
            $nilai = isset($datahasil[$kolom]) ? $datahasil[$kolom] : '-';
            $detailText[] = "  $label : $nilai";
        }

        // Gabungkan array menjadi string dengan pemisah "<br>" agar tetap dalam satu kolom
        $html .= implode('<br>', $detailText);

        $html .= '  </td>
                  </tr>';
    }
}

$html .= '</tbody></table>';

// Tulis konten ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Hentikan output buffering sebelum mengirim file PDF
ob_end_clean();

// Outputkan PDF
$namaFile = "Rekam_Medis_" . strtoupper(str_replace(' ', '_', $namaPasien)) . ".pdf";
$pdf->Output($namaFile, 'I');

?>
