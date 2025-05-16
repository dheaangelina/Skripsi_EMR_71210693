<?php
// if (empty($_SESSION["keyaccess"]) or $_SESSION["keyaccess"] != "123456") {
//     header("Location: ");
//     die;
// }
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cInsert.php");
include_once("../_function_i/cUpdate.php");
include_once("../_function_i/cDelete.php");
include_once("../_function_i/inc_f_object.php");

$conn = new cConnect();
$conn->goConnect();

session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION["idUser"])) {
    // Redirect ke halaman login jika belum login
    header("Location: http://localhost/emr_pinilih/");
    exit();
}

?>

<style>
    #offcanvasNavbar{
        width: 25%;
    }

    ion-icon {
    --ionicon-stroke-width: 30px;
    }

    .required {
        color: red;
    }

    thead {
        background-color:#e3f2fd;
        color: black;
    }
</style>

<?php
// Ambil URL path dari permintaan
$request = $_SERVER['REQUEST_URI'];
$request = trim($request, '/');
$segments = explode('/', $request);

if (empty($segments[2])) {
    $segments[2] = 1;
} else {
    $segments[2] = $segments[2];
}
$link = $segments[2];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin EMR</title>

    <!-- Bootstrap 5.2.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/2b55107a0a.js" crossorigin="anonymous"></script>

    <!-- chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php
    $baseurl = "http://localhost/emr_pinilih/admin";
    ?>
    <nav class="navbar fixed-top" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">EMR RKD Pinilih</a>
            <ul class="nav-pills mt-2">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user fa-lg" style="color: #000000;"></i>    
                    <span class="ms-2"><?= $_SESSION["nama"]; ?></span>
                </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><strong><?= $_SESSION["nama"]; ?></strong></a></li>
                        <li><a class="dropdown-item" href="#"><?= $_SESSION["jabatan"]; ?></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= $baseurl; ?>/61"><ion-icon name="settings-outline"></ion-icon> Atur Profil</a></li>
                        <li><a class="dropdown-item text-danger" href="../logout.php"><ion-icon name="log-out-outline"></ion-icon> Log Out</a></li>
                    </ul>
            </ul>
            <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-body mx-3 mt-3">
                    <ul class="navbar-nav me-auto mb-2">
                        <li class="nav-item mb-2">
                            <a class="nav-link active" aria-current="page" href="<?= $baseurl; ?>/1">
                                <i class="fa-solid fa-house fa-lg" style="color:black;"></i> &nbsp; BERANDA
                            </a>
                        </li>
                        <li class="nav-item dropdown mb-2">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-database fa-lg" style="color:black;"></i> &nbsp; MASTER DATA
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/21">
                                    <i class="fa-solid fa-hospital-user" style="color:black;"></i> &nbsp; Data Pasien
                                </a></li>
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/22">
                                    <i class="fa-solid fa-user-doctor" style="color:black;"></i> &nbsp; Data Tenaga Medis / <br> &nbsp; &nbsp; &nbsp; Paramedis / Non Medis
                                </a></li>
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/23">
                                    <i class="fa-solid fa-user-tie" style="color:black;"></i> &nbsp; Data Pengguna
                                </a></li>
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/24">
                                    <i class="fa-solid fa-wheelchair" style="color:black;"></i> &nbsp; Data Disabilitas
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown mb-2">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-hand-holding-medical fa-lg" style="color:black;"></i> &nbsp; PROGRAM LAYANAN
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/31">
                                    <i class="fa-solid fa-person-cane" style="color:black;"></i> &nbsp; Fisioterapi
                                </a></li>
                                <li><a class="dropdown-item mb-2" href="<?= $baseurl; ?>/32">
                                    <i class="fa-solid fa-people-robbery" style="color:black;"></i> &nbsp; Kinesioterapi
                                </a></li>
                            </ul>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link active" aria-current="page" href="<?= $baseurl; ?>/41">
                                <i class="fa-solid fa-laptop-medical fa-lg" style="color:black;"></i> &nbsp; REKAM MEDIS
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link active" aria-current="page" href="<?= $baseurl; ?>/51">
                                <i class="fa-solid fa-chart-line fa-lg" style="color:black;"></i> &nbsp; LAPORAN
                            </a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </nav>

    <br><br><br>

    <div class="container-fluid mt-5">
        <?php

        switch ($link) {
            case 1:
                include("incHome.php");
                break;
            case 21:
                include("incDataPasien.php");
                break;
            case 22:
                include("incDataTerapis.php");
                break;
            case 23:
                include("incDataPengguna.php");
                break;
            case 24:
                include("incDataDisabilitas.php");
                break;
            case 31:
                include("incFisioterapi.php");
                break;
            case 311:
                include("detailFisio.php");
                break;
            case 32:
                include("incKinesioterapi.php");
                break;
            case 321:
                include("detailKinesio.php");
                break;            
            case 41:
                include("incRekamMedis.php");
                break;
            case 411:
                include("detailRekamMedis.php");
                break;
            case 51:
                include("incLaporan.php");
                break;
            case 61:
                include("incAturProfil.php");
                break;
        }
        ?>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5.2.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- ion icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

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

    <!-- Inisialisasi DataTable -->
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable("#example")) {
                $('#example').DataTable().destroy(); // Hapus instance sebelumnya
            }
            
            $('#example').DataTable({
                "order": [[0, "asc"]],
                "paging": true,
                "searching": true,
                "info": true
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const numberInputs = document.querySelectorAll('input[type="number"]');
        
            numberInputs.forEach(function (input) {
                // Buat elemen pesan error jika belum ada
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                    const errorMessage = document.createElement('small');
                    errorMessage.classList.add('error-msg');
                    errorMessage.style.color = 'red';
                    errorMessage.style.display = 'none';
                    errorMessage.textContent = 'Harus isi angka!';
                    input.parentNode.appendChild(errorMessage);
                }
            
                const errorMsg = input.nextElementSibling;
            
                // Cegah input huruf dari keyboard
                input.addEventListener('keydown', function (e) {
                    const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];
                    const isNumber = /^[0-9]$/.test(e.key);
                
                    if (!isNumber && !allowedKeys.includes(e.key)) {
                        e.preventDefault();
                        errorMsg.style.display = 'block';
                        input.classList.add('is-invalid');
                    }
                });
            
                // Validasi saat nilai berubah (termasuk copy-paste)
                input.addEventListener('input', function () {
                    const onlyNumbers = /^\d*$/;
                    if (onlyNumbers.test(input.value)) {
                        errorMsg.style.display = 'none';
                        input.classList.remove('is-invalid');
                    } else {
                        errorMsg.style.display = 'block';
                        input.classList.add('is-invalid');
                    }
                });
            });
        });
    </script>

   
    <!-- validasi number  -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const numberInputs = document.querySelectorAll('input[type="number"]');
        
            numberInputs.forEach(function (input) {
                // Buat elemen pesan error jika belum ada
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                    const errorMessage = document.createElement('small');
                    errorMessage.classList.add('error-msg');
                    errorMessage.style.color = 'red';
                    errorMessage.style.display = 'none';
                    errorMessage.textContent = 'Harus isi angka!';
                    input.parentNode.appendChild(errorMessage);
                }
            
                const errorMsg = input.nextElementSibling;
            
                // Cegah input huruf dari keyboard
                input.addEventListener('keydown', function (e) {
                    const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];
                    const isNumber = /^[0-9]$/.test(e.key);
                
                    if (!isNumber && !allowedKeys.includes(e.key)) {
                        e.preventDefault();
                        errorMsg.style.display = 'block';
                        input.classList.add('is-invalid');
                    }
                });
            
                // Validasi saat nilai berubah (termasuk copy-paste)
                input.addEventListener('input', function () {
                    const onlyNumbers = /^\d*$/;
                    if (onlyNumbers.test(input.value)) {
                        errorMsg.style.display = 'none';
                        input.classList.remove('is-invalid');
                    } else {
                        errorMsg.style.display = 'block';
                        input.classList.add('is-invalid');
                    }
                });
            });
        });
    </script>

    <!-- validasi time  -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const timeInputs = document.querySelectorAll('input[type="time"]');
        
        timeInputs.forEach(function (input) {
            // Buat elemen pesan error jika belum ada
            if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                const errorMessage = document.createElement('small');
                errorMessage.classList.add('error-msg');
                errorMessage.style.color = 'red';
                errorMessage.style.display = 'none';
                errorMessage.textContent = 'Harus isi waktu yang valid (hh:mm)!';
                input.parentNode.appendChild(errorMessage);
            }

            const errorMsg = input.nextElementSibling;

            // Fungsi untuk memformat waktu menjadi hh:mm:ss
            function formatTimeToHHMMSS(timeValue) {
                const parts = timeValue.split(':'); // dari hh:mm
                if (parts.length !== 2) return '';
                return parts[0] + ':' + parts[1] + ':00'; // hh:mm:ss
            }

            function isValidTime(timeValue) {
                // Cek apakah formatnya sesuai dengan hh:mm (waktu 24 jam)
                const timePattern = /^\d{2}:\d{2}$/;
                return timePattern.test(timeValue);
            }

            // Cegah input huruf atau karakter yang tidak valid
            input.addEventListener('keydown', function (e) {
                const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', ':'];
                const isNumber = /^[0-9]$/.test(e.key);

                if (!isNumber && !allowedKeys.includes(e.key)) {
                    e.preventDefault();
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                }
            });

            // Validasi saat nilai berubah (termasuk copy-paste)
            input.addEventListener('input', function () {
                if (input.value && isValidTime(input.value)) {
                    const formattedTime = formatTimeToHHMMSS(input.value);
                    input.setAttribute('data-formatted', formattedTime); // Simpan format hh:mm:ss di atribut data
                    errorMsg.style.display = 'none';
                    input.classList.remove('is-invalid');
                } else {
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                }
            });

            // Validasi saat blur (keluar dari input)
            input.addEventListener('blur', function () {
                if (!input.value || !isValidTime(input.value)) {
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                } else {
                    const formattedTime = formatTimeToHHMMSS(input.value);
                    input.setAttribute('data-formatted', formattedTime);
                    errorMsg.style.display = 'none';
                    input.classList.remove('is-invalid');
                }
            });
        });
    });
    </script>
        
    <!-- validasi date  -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateInputs = document.querySelectorAll('input[type="date"]');

        dateInputs.forEach(function (input) {
            // Buat elemen pesan error jika belum ada
            if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                const errorMessage = document.createElement('small');
                errorMessage.classList.add('error-msg');
                errorMessage.style.color = 'red';
                errorMessage.style.display = 'none';
                errorMessage.textContent = 'Harus isi tanggal yang valid (hh/bb/tttt)!';
                input.parentNode.appendChild(errorMessage);
            }

            const errorMsg = input.nextElementSibling;

            function formatDateToMMDDYYYY(dateValue) {
                const parts = dateValue.split('-');
                if (parts.length !== 3) return '';
                return parts[1] + '/' + parts[2] + '/' + parts[0]; // mm/dd/yyyy
            }

            function isValidDate(dateValue) {
                const datePattern = /^\d{4}-\d{2}-\d{2}$/;
                if (!datePattern.test(dateValue)) return false;

                const parts = dateValue.split('-');
                const year = parts[0];

                return year.length === 4; // Pastikan tahun 4 digit
            }

            // Cegah ketik huruf
            input.addEventListener('keydown', function (e) {
                const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', '-', '/'];
                const isNumber = /^[0-9]$/.test(e.key);

                if (!isNumber && !allowedKeys.includes(e.key)) {
                    e.preventDefault();
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                }
            });

            // Validasi saat nilai berubah
            input.addEventListener('input', function () {
                if (input.value && isValidDate(input.value)) {
                    const formattedDate = formatDateToMMDDYYYY(input.value);
                    input.setAttribute('data-formatted', formattedDate);
                    errorMsg.style.display = 'none';
                    input.classList.remove('is-invalid');
                } else {
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                }
            });

            // Validasi saat blur (keluar dari input)
            input.addEventListener('blur', function () {
                if (!input.value || !isValidDate(input.value)) {
                    errorMsg.style.display = 'block';
                    input.classList.add('is-invalid');
                } else {
                    const formattedDate = formatDateToMMDDYYYY(input.value);
                    input.setAttribute('data-formatted', formattedDate);
                    errorMsg.style.display = 'none';
                    input.classList.remove('is-invalid');
                }
            });
        });
    });
    </script>

</body>

</html>