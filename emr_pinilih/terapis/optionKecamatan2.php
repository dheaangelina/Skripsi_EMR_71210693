<?php
header('Content-Type: application/json'); // Tambahkan header JSON

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr_pinilih';

$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

header('Content-Type: application/json'); // Pastikan respons dalam format JSON
$idKotaKab = $_POST['idKotaKab'];

$sql = $pdo->prepare("SELECT * FROM kecamatan WHERE idKotaKabupaten = '" .$idKotaKab. "' ORDER BY idKecamatan");
$sql->execute();

// Buat data untuk dropdown kecamatan
$html = "<option value=''>- pilihan -</option>";
while ($data = $sql->fetch()) {
    $html .= "<option value='".$data['idKecamatan']."'>".$data['namaKecamatan']. "</option>";
}

// Pastikan tidak ada output lain sebelum JSON
echo json_encode(['data_kecamatan' => $html]);
?>
