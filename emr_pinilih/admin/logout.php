<?php
session_start();
session_destroy(); // Hapus semua sesi
header("Location: http://localhost/emr_pinilih/");
exit();
?>
