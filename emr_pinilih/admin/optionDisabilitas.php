<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr';

// Koneksi ke MySQL dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

// SUB DISABILITAS
  $id_jenisDisabilitas = $_POST['jenisDisabilitas'];

  // Buat query untuk menampilkan data subDisabilitas dengan jenisDisabilitas tertentu (sesuai yang dipilih user pada form)
  $sqlDisabilitas = $pdo->prepare("SELECT * FROM sub_disabilitas WHERE idJenisDisabilitas='" .$id_jenisDisabilitas. "'ORDER BY idSubDisabilitas");
  $sqlDisabilitas->execute(); // Eksekusi querynya

  $html = "<option value=''>- pilihan -</option>";
  while($data = $sqlDisabilitas->fetch()){ // Ambil semua data dari hasil eksekusi $sql
    $html .= "<option value='".$data['idSubDisabilitas']."'>".$data['namaDisabilitas']."</option>";
  }

  $callback = array('data_disabilitas'=>$html); // Masukan variabel html ke dalam array $callback dengan index array : data_disabilitas
  echo json_encode($callback);
?>