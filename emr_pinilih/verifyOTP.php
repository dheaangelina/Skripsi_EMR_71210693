<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['alamatEmail'];
    $otp = $_POST['otp'];

    // Cek OTP di database
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM user WHERE email = ? AND otp = ?");
    $stmt->execute([$email, $otp]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $current_time = new DateTime(); // Waktu sekarang
        $otp_expiry = new DateTime($row['otp_expiry']); // Waktu kadaluarsa OTP

        if ($current_time <= $otp_expiry) {
            echo "valid";
        } else {
            echo "invalid";
        }
    } else {
        echo "invalid";
    }
}
?>
