<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr';

// Koneksi ke MySQL dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

header('Content-Type: application/json'); // Pastikan respons dalam format JSON

// KOTA KABUPATEN
// Ambil data ID provinsi yang dikirim via ajax post
$idProv = $_POST['idProv'];

// Buat query untuk menampilkan data sesuai yang dipilih user pada form
$sql = $pdo->prepare("SELECT * FROM kotakabupaten WHERE idProvinsi='" .$idProv. "'ORDER BY idKotaKabupaten");
$sql->execute(); // Eksekusi querynya

$html = "<option value=''>- pilihan -</option>";
while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
  $html .= "<option value='".$data['idKotaKabupaten']."'>".$data['namaKotaKabupaten']."</option>"; // Tambahkan tag option ke variabel $html
}

$callback = array('data_kotaKab'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_subDisabilitas
echo json_encode($callback); // konversi variabel $callback menjadi JSON
?>