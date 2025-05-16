<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testing</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
                $_SESSION["nama"] = $value["nama"];
                $_SESSION["role"] = $value["role"];
                $_SESSION["baseurl"] = $value["urlbase"];
                $_SESSION["jabatan"] = $value["jbtn"];
                $_SESSION["aktif"] = $value["status_aktif"];
            }

            // tahun aktif
            $sqltahun = "SELECT a.* FROM fiskal a WHERE a.stsaktif = 1";
            $view = new cView();
            $aarraytahun = $view->vViewData($sqltahun);
            foreach ($aarraytahun as $datatahun) {
                $_SESSION["tahun_aktif"] = $datatahun["tahun"];
                $_SESSION["tanggal_mulai"] = $datatahun["tanggal_mulai"];
                $_SESSION["tanggal_akhir"] = $datatahun["tanggal_akhir"];
            }
        }
    }
}
if ($gu == 0 and $gp == 1) {
    $alert = 'Username & Password Salah !';
} elseif ($gu == 0 and $gp == 0) {
    $alert = "";
} elseif ($gu == 1 and $gp == 1) {
    header('Location: ' . $_SESSION["baseurl"]);
}
?>

<body>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Enable both scrolling & backdrop</button>

                <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdrop with scrolling</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <p>Try scrolling the rest of the page to see this option in action.</p>
                        <a href="http://">TESTING 1</a><br>
                        <a href="http://">TESTING 2</a><br>
                        <a href="http://">TESTING 3</a><br>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-1">
            </div>
            <div class="col-4">
                <div class="card border-dark">

                    <div class="card-header text-center">
                        <h6 class="card-title">SI.ANGGER<br>
                            Sistem Informasi Anggaran Gereja</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <p>
                            <h5><ion-icon name="wallet-outline"></ion-icon>&nbsp;LOGIN</h5>
                            </p>
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="username" aria-label="Username" name="unme">
                            <p></p>
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="password" aria-label="password" name="pswd">
                            <p></p>
                            <input class="btn btn-primary btn-sm" name="btnpost" type="submit" value=" SUBMIT " style="border-radius: 25px;">
                            <p></p>
                            <p class="text-danger text-center small">
                                <?= $alert; ?>
                            </p>
                        </form>
                    </div>
                    <div class="card-footer text-center small">
                        GKJ Dayu &copy;2024
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1">
        </div>
        <div class="col-3">
        </div>
    </div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Bootstrap 5 JS Proper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>


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
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>