<?php
date_default_timezone_set('Asia/Jakarta'); // Sesuaikan dengan zona waktu server

// Konfigurasi database
$host = "localhost"; // Ganti sesuai host database Anda
$dbname = "emr_pinilih"; // Nama database
$username = "root"; // Ganti sesuai username database Anda
$password = ""; // Ganti sesuai password database Anda

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set mode error agar mudah debug jika terjadi kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
