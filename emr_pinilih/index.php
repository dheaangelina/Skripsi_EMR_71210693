<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMR</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #dff2fd; }
        .login-container { background-color: white; border-radius: 15px; padding: 40px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); max-width: 900px; }
        .login-image { max-width: 100%; height: auto; }
        .login-form { width: 90%; }
        .form-control { border-radius: 10px; }
        .btn-login { border-radius: 10px; font-weight: bold; padding: 10px; background-color: #08abea; color: white; }
        .btn-login:hover { background-color: #dff2fd; border-color: #08abea; border-width: 2px; color: #08abea; }
        .password-container { position: relative; display: flex; align-items: center; }
        .toggle-password { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; }
    </style>
</head>

<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

include_once("_function_i/cConnect.php");
include_once("_function_i/cView.php");

$conn = new cConnect();
$conn->goConnect();

if (empty($_POST["btnpost"])) {
    $gu = 0;
    $gp = 0;
    $alert = "";
} else {
    $gp = 1;
    if (empty($_POST["unme"])) {
        $gu = 0;
        $gp = 0;
    } else {
        if (empty($_POST["pswd"])) {
            $gu = 1;
            $gp = 0;
        } else {
            // cleansing input post
            $un = strip_tags($_POST["unme"]);
            $up = md5(strip_tags($_POST["pswd"]));

            // username & role
            $sql = "SELECT a.* FROM user a ";
            $sql .= "WHERE a.username = '" . $un . "' AND a.password = '" . $up . "' ";

            $view = new cView();
            $array = $view->vViewData($sql);

            $gu = 0;
            $gp = 1;
            foreach ($array as $value) {
                $gu = 1;
                $gp = 1;
                $alert = "";
                $_SESSION["idUser"] = $value["idUser"];
                $_SESSION["nama"] = $value["nama"];
                $_SESSION["role"] = $value["role"];
                $_SESSION["baseurl"] = $value["urlbase"];
                $_SESSION["jabatan"] = $value["jbtn"];
                $_SESSION["aktif"] = $value["status_aktif"];
                $_SESSION["keyaccess"] = $value["keyaccess"]; 
            }
        }
    }
}

if ($gu == 0 and $gp == 1) {
    $alert = 'Username atau Password Salah !';
} elseif ($gu == 1 and $gp == 0) {
    $alert = 'Username atau Password Salah !';
} elseif ($gu == 0 and $gp == 0) {
    $alert = '';
} elseif ($gu == 1 and $gp == 1) {
    header('Location: ' . $_SESSION["baseurl"]);
}
?>

<body>
    <div class="container-fluid mt-3">
        <br>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="login-container d-flex flex-row px-4">
                        <div class="row align-items-center justify-content-center" style="height: 75vh;">
                            <div class="col-md-7 text-left d-flex flex-column justify-content-center">
                                <h1 class="fw-bold">Selamat Datang!</h1>
                                <p class="text-muted">Kelola data pasien pakai Sistem Rekam Medis Elektronik Rumah Kebugaran Difabel Yayasan Pinilih Sedayu</p>
                                <img src="_img/login.png" alt="login" class="img-fluid" style="max-width: 95%; height: auto;">
                            </div>
                            <div class="col-md-5 d-flex flex-column align-items-center">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <img src="_img/ukdw.png" alt="UKDW" width="70" height="90">
                                    <img src="_img/logo.png" alt="Logo" width="90" height="90">
                                </div>
                                <br>
                                <form action="" method="post" class="login-form">
                                    <label for="username" class="fw-bold">Username</label>
                                    <input type="text" id="username" class="form-control mb-3" placeholder="username" aria-label="Username" name="unme">
                                    <label for="password" class="fw-bold">Password</label>
                                    <div class="password-container position-relative">
                                        <input type="password" id="password" class="form-control" placeholder="password" aria-label="password" name="pswd">
                                        <span class="toggle-password" onclick="togglePassword()"><ion-icon id="eyeIcon" name="eye-outline"></ion-icon></span>
                                    </div>
                                    <a href="#" class="small text-primary d-block text-end mb-3" data-bs-toggle="modal" data-bs-target="#modalEmail">Lupa password?</a>
                                    <br>
                                    <input class="btn btn-login w-100" name="btnpost" type="submit" value=" LOGIN ">
                                    <br>
                                    <?php if (!empty($alert)) : ?>
                                        <b><p class="text-danger text-center small"><?= $alert; ?></p></b>
                                    <?php endif; ?>
                                </form>
                                <!-- Pop-up 1: Input Email -->
                                <div class="modal fade" id="modalEmail" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">RESET PASSWORD</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="sendOTP.php" method="post" id="formOTP">
                                                <div class="modal-body">
                                                    <p>Masukkan email Anda yang terdaftar. Kami akan mengirimkan kode verifikasi untuk mengatur ulang kata sandi Anda.</p>
                                                    <label for="alamatEmail">EMAIL</label>
                                                    <input type="email" id="alamatEmail" name="alamatEmail" class="form-control" placeholder="Masukkan Email" autocomplete="email">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="kirimEmail" name="verifikasi1">Verifikasi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pop-up 2: Input Kode Verifikasi -->
                                <div class="modal fade" id="modalKode" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">VERIFIKASI EMAIL</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="verifyOTP.php" method="post" id="formVerifyOTP">
                                                <div class="modal-body">
                                                    <p id="kirimEmailVerifikasi"></p>
                                                    <label for="otp">Kode Verifikasi Email</label>
                                                    <input type="text" id="otp" name="otp" class="form-control" placeholder="Masukkan Kode Verifikasi" autocomplete="one-time-code">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="kirimKode" name="verifikasi2">Verifikasi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pop-up 3: Ubah Password -->
                                <div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">UBAH PASSWORD</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="resetPassword.php" method="post" id="formResetPassword">
                                                <div class="modal-body">
                                                    <label for="passwordBaru">Password Baru</label>
                                                    <input type="password" id="passwordBaru" name="passwordBaru" class="form-control mb-2" placeholder="Password Baru" autocomplete="current-password">
                                                    <label for="konfirmasiPassword">Konfirmasi Password Baru</label>
                                                    <input type="password" id="konfirmasiPassword" name="konfirmasiPassword" class="form-control" placeholder="Konfirmasi Password" autocomplete="new-password">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="ubahPassword" name="ubahPassword">Ubah Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- ion icon -->
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
    
    <!-- tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Aktifkan semua elemen dengan tooltip di dalam dokumen
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.setAttribute("name", "eye-off-outline");
            } else {
                passwordField.type = "password";
                eyeIcon.setAttribute("name", "eye-outline");
            }
        }

        $(document).on('submit', '#formOTP', function(e) {
            e.preventDefault();
            let email = $('#alamatEmail').val();
            
            $.post('sendOTP.php', {alamatEmail: email}, function(response) {
                if (response === "success") {
                    $('#modalEmail').modal('hide');
                    $('#modalKode').modal('show');
                } else if (response === "not_found") {
                    alert("Email tidak ditemukan");
                } else {
                    alert("Email tidak ditemukan");
                }
            });
        });

        $(document).on('submit', '#formVerifyOTP', function(e) {
            e.preventDefault();
            let email = $('#alamatEmail').val();
            let otp = $('#otp').val();
            
            $.post('verifyOTP.php', {alamatEmail: email, otp: otp}, function(response) {
                if (response === "valid") {
                    $('#modalKode').modal('hide');
                    $('#modalPassword').modal('show');
                } else {
                    alert("Kode OTP salah atau sudah kedaluwarsa");
                }
            });
        });

        $(document).on('submit', '#formResetPassword', function(e) {
            e.preventDefault();
            let email = $('#alamatEmail').val();
            let passwordBaru = $('#passwordBaru').val();
            let konfirmasiPassword = $('#konfirmasiPassword').val();

            if (passwordBaru !== konfirmasiPassword) {
                alert("Konfirmasi password tidak cocok!");
                return;
            }

            $.post('resetPassword.php', {alamatEmail: email, passwordBaru: passwordBaru}, function(response) {
                if (response === "success") {
                    alert("Password berhasil diubah!");
                    $('#modalPassword').modal('hide');
                } else {
                    alert("Gagal mengubah password!");
                }
            });
        });

    </script>
</body>

</html>