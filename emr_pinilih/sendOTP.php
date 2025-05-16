<?php
require 'config.php'; // File koneksi database
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['alamatEmail'];

    // Cek apakah email ada dalam database user
    $query = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate OTP (6 digit angka)
        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Simpan OTP ke database user
        $stmt = $conn->prepare("UPDATE user SET otp = ?, otp_expiry = ? WHERE email = ?");
        $stmt->execute([$otp, $expires_at, $email]);

        // Kirim email menggunakan PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ubah sesuai server SMTP Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'rkdpinilih@gmail.com'; // Ganti dengan email pengirim
        $mail->Password = 'rfyh hvqs ueno swhv'; // Ganti dengan password email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('rkdpinilih@gmail.com', 'Support - Rekam Medis RKD Pinilih');
        $mail->addAddress($email);
        $mail->Subject = 'Kode OTP Reset Password';
        $mail->Body = "Kode OTP Anda: $otp\nKode ini berlaku selama 10 menit.";

        if ($mail->send()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "Email tidak ditemukan";
    }
}
?>
