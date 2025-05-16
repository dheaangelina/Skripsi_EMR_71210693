<?php
header('Content-Type: application/json'); // Tambahkan header JSON

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr_pinilih';

$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

$idKec = $_POST['idKec'];

$sql = $pdo->prepare("SELECT * FROM kelurahan WHERE idKecamatan = '" .$idKec. "' ORDER BY idKelurahan");
$sql->execute();

// Buat data untuk dropdown kecamatan
$html = "<option value=''>- pilihan -</option>";
while ($data = $sql->fetch()) {
    $html .= "<option value='". $data['idKelurahan'] ."'>". $data['namaKelurahan'] ."</option>";
}

// Pastikan tidak ada output lain sebelum JSON
echo json_encode(['data_kelurahan' => $html]);
?>
