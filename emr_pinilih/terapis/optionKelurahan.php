<?php
header('Content-Type: application/json'); // Tambahkan header JSON

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr_pinilih';

$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

$id_kecamatan = $_POST['kecamatan'];

$sql = $pdo->prepare("SELECT * FROM kelurahan WHERE idKecamatan = '" .$id_kecamatan. "' ORDER BY idKelurahan");
$sql->execute();

// Buat data untuk dropdown kecamatan
$html = "<option value=''>- pilihan -</option>";
while ($data = $sql->fetch()) {
    $html .= "<option value='".$data['idKelurahan']."'>".$data['namaKelurahan']. "</option>";
}

// Pastikan tidak ada output lain sebelum JSON
echo json_encode(['data_kelurahan' => $html]);
?>
