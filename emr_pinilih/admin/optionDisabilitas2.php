<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'emr';


// Koneksi ke database dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

header('Content-Type: application/json'); // Pastikan respons dalam format JSON

$idJenis = $_POST['idJenis'];

// Query dengan prepared statement
$sqlDisabilitas = $pdo->prepare("SELECT * FROM sub_disabilitas WHERE idJenisDisabilitas='" .$idJenis. "'ORDER BY idSubDisabilitas");
$sqlDisabilitas->execute();
    
$html = "<option value=''>- pilihan -</option>";
while ($data = $sqlDisabilitas->fetch()) {
    $html .= "<option value='" . $data['idSubDisabilitas'] . "'>" . $data['namaDisabilitas'] . "</option>";
}


$callback = array('data_disabilitas'=>$html);
echo json_encode($callback);
?>