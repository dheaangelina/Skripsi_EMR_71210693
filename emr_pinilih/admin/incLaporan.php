<?php
include_once("../_function_i/cConnect.php");
include_once("../_function_i/cView.php");
include_once("../_function_i/cInsert.php");
include_once("../_function_i/cUpdate.php");
include_once("../_function_i/cDelete.php");
include_once("../_function_i/inc_f_object.php");

$conn = new cConnect();
$conn->goConnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan RKD</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <style>
        .custom-dark-blue {
            border-color:rgb(37, 99, 191) !important;
            color:rgb(6, 38, 85) !important; 
        }
    </style>
</head>

<div class="row mx-2">
    <div class="col-md-12 mb-3">
        <?php
        _myHeader("LAPORAN", "Laporan RKD Pinilih");
        ?>
    </div>
</div>


<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="card text-center border border-4 custom-dark-blue">
            <div class="card-body">
                <?php  
                    $jmlPasien = "SELECT COUNT(*) as totalPasien FROM pasien";
                    $view = new cView();
                    $view->vViewData($jmlPasien);
                    $arrayjmlPasien = $view->vViewData($jmlPasien);
                    foreach ($arrayjmlPasien as $dataPasien) {
                        $totalPasien = $dataPasien["totalPasien"];
                    }
                ?>
                <h2><?= $totalPasien ?></h2>
                <h3>Pasien</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border border-4 custom-dark-blue">
            <div class="card-body">
                <?php  
                    $jmlTerapis = "SELECT COUNT(*) as totalTerapis FROM terapis";
                    $view = new cView();
                    $view->vViewData($jmlTerapis);
                    $arrayjmlTerapis = $view->vViewData($jmlTerapis);
                    foreach ($arrayjmlTerapis as $dataTerapis) {
                        $totalTerapis = $dataTerapis["totalTerapis"];
                    }
                ?>
                <h2><?= $totalTerapis ?></h2>
                <h3>Terapis</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center border border-4 custom-dark-blue">
            <div class="card-body">
                <?php  
                    $jmlPengguna = "SELECT COUNT(*) as totalPengguna FROM user";
                    $view = new cView();
                    $view->vViewData($jmlPengguna);
                    $arrayjmlPengguna = $view->vViewData($jmlPengguna);
                    foreach ($arrayjmlPengguna as $dataPengguna) {
                        $totalPengguna = $dataPengguna["totalPengguna"];
                    }
                ?>
                <h2><?= $totalPengguna ?></h2>
                <h3>Pengguna</h3>
            </div>
        </div>
    </div>
</div>
<br><br>

<div class="row mx-1 justify-content-center">
    <div class="col-6">
        <!-- JENIS DISABILITAS -->
        <div class="card text-center border border-2" style="height: 430px;">
            <div class="card-body" >
                <button onclick="exportToExcel('chartJD', 'Jenis Disabilitas')" class="btn btn-success mb-2 btn-sm ">
                    <i class="fa-solid fa-print"></i> CETAK EXCEL
                </button>
                <h5>Jenis Disabilitas Pasien</h5>
                <br>
                <canvas id="chartJD"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-6">
        <!-- SUB DISABILITAS -->
        <div class="card text-center border border-2" style="height: 430px;">
            <div class="card-body ">
                <button onclick="exportToExcel('chartSubJD', 'Sub Jenis Disabilitas')" class="btn btn-success mb-2 btn-sm">
                    <i class="fa-solid fa-print"></i> CETAK EXCEL
                </button>
                <h5>Sub Jenis Disabilitas Pasien</h5>
                <small><p id="subJDText">Klik bar pada Jenis Disabilitas untuk melihat Sub Jenis Disabilitas</p></small>
                <canvas id="chartSubJD"></canvas>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var chartJD, chartSubJD;
        loadChartJD(); //Chart Jenis Disabilitas
        loadEmptyChartSubJD(); // Chart Sub Jenis Disabilitas kosong

        // Chart Jenis Disabilitas
        function loadChartJD() {
            $.ajax({
                url: 'chartDisabilitas.php', // Ambil data dari chartDisabilitas.php pakai AJAX
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('chartJD').getContext('2d');

                    // Simpan ID jenis disabilitas untuk ketika diklik
                    var idJenisList = response.ids;
                    if (chartJD) {
                        chartJD.destroy();
                    }
                    chartJD = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels, //nama JD
                            datasets: [{ // jumlah pasien per JD
                                label: 'Jenis Disabilitas',
                                data: response.datas, 
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true, // ukuran layar
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'start',
                                    formatter: (value) => value,
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    color: '#000'
                                },
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: { display: true, text: 'Jenis Disabilitas' },
                                },
                                y: {
                                    display: true,
                                    title: { display: true, text: 'Jumlah Pasien' },
                                    ticks: { stepSize: 1 }
                                }
                            },
                            onClick: function(event, elements) {
                                if (elements.length > 0) {
                                    var index = elements[0].index; 
                                    var idJenisDisabilitas = idJenisList[index]; // ambil idJD pada bar pertama yang diklik
                                    loadChartSubJD(idJenisDisabilitas); // klik bar pada JD untuk menampilkan sub JD
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }

        // Fungsi untuk membuat chart sub disabilitas kosong
        function loadEmptyChartSubJD() {
            var ctx = document.getElementById('chartSubJD').getContext('2d');
            chartSubJD = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sub Jenis Disabilitas',
                        data: [],
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {        
                        x: {
                            display: true,
                            title: {display: true, text: 'Sub Jenis Disabilitas'},
                        },
                        y: {
                            display: true,
                            title: {display: true, text: 'Jumlah Pasien'},
                        }
                    }
                }
            });
        }

        // Fungsi untuk memuat chart sub jenis disabilitas dengan mengirim idJenisDisabilitas ke chartSubDisabilitas.php
        function loadChartSubJD(idJenisDisabilitas) {
            $.ajax({
                url: 'chartSubDisabilitas.php',
                type: 'GET',
                data: { idJenisDisabilitas: idJenisDisabilitas },
                dataType: 'json',
                success: function(response) {
                    if (chartSubJD) {
                        chartSubJD.destroy();
                    }
                    var ctx = document.getElementById('chartSubJD').getContext('2d');
                    chartSubJD = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Sub Jenis Disabilitas',
                                data: response.datas,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'start',
                                    formatter: (value) => value,
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    color: '#000'
                                },
                                legend: {
                                    display: false
                                }
                            },
                            scales: {        
                                x: {
                                    display: true,
                                    title: {display: true, text: 'Sub Jenis Disabilitas'},
                                },
                                y: {
                                    display: true,
                                    title: {display: true, text: 'Jumlah Pasien'},
                                    ticks: { stepSize: 1 }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    });
    </script>

    <script>
    function exportToExcel(chartId, sheetName) {
        var chart = Chart.getChart(chartId);
        if (!chart) {
            alert("Grafik tidak ditemukan!");
            return;
        }

        var labels = chart.data.labels; // sumbu X
        var datas = chart.data.datasets[0].data; // sumbu Y

        var dataExcel = [
            [sheetName.toUpperCase()], // Judul
            [],                        // Baris kosong
            ["Kategori", "Jumlah Pasien"] // Header tabel
        ];

        // Masukkan data ke dalam Excel
        for (var i = 0; i < labels.length; i++) {
            dataExcel.push([labels[i], datas[i]]);
        }

        // Buat worksheet Excel
        var ws = XLSX.utils.aoa_to_sheet(dataExcel);

        var wsCols = [
            { wch: 30 }, // Lebar kolom Kategori
            { wch: 15 }  // Lebar kolom Jumlah Pasien
        ];
        ws['!cols'] = wsCols;

        // header dan judul
        var titleCell = ws["A1"];
        if (titleCell) titleCell.s = { font: { bold: true, sz: 14 } };

        var headerCell1 = ws["A3"], headerCell2 = ws["B3"];
        if (headerCell1) headerCell1.s = { font: { bold: true } };
        if (headerCell2) headerCell2.s = { font: { bold: true } };

        // Buat workbook dan simpan file Excel
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);
        XLSX.writeFile(wb, sheetName + ".xlsx");
    }
    </script>
    </div>
</div><br>

<!-- pie chart -->
<div class="row mx-2 justify-content-center">
    <div class="col-4">
        <!-- KELOMPOK USIA -->
        <div class="card text-center border border-2">
            <div class="card-body">
                <button onclick="exportUsiaToExcel()" class="btn btn-success btn-sm mb-2">
                    <i class="fa-solid fa-print" style="color: #ffffff;"></i> CETAK EXCEL
                </button>
                <h5 class="text-center">Kelompok Usia Pasien</h5>
                <canvas id="chartUsia"></canvas>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT * FROM vKelompokUsia";
    $view = new cView();
    $arrayhasil = $view->vViewData($sql);

    $labels = [];
    $datas = [];
    $total = 0;

    foreach ($arrayhasil as $value) {
    $labels[] = trim($value["kelompokUsia"]); // kelompok usia
    $datas[] = (int) $value["jumlah"]; //jumlah pasien
    $total += (int) $value["jumlah"]; // total keseluruhan
    }

    // Urutin dari besar ke kecil
    array_multisort($datas, SORT_DESC, $labels);

    //konversi php ke json
    $labels = json_encode($labels, JSON_UNESCAPED_UNICODE);
    $datas = json_encode($datas);
    $total = max($total, 1);
    ?>

    <script>
    function getDynamicColors(values, total, baseColor) {
        const targetColors = { //warna dasar utk usia, kelurahan, dan goldar
            'rgba(2, 32, 92, 0.8)': { r: 135, g: 206, b: 250 }, 
            'rgba(0, 103, 48, 0.8)': { r: 144, g: 238, b: 144 },
            'rgba(153, 0, 0, 0.8)': { r: 255, g: 182, b: 193 }  
        };

        // ambil RGB
        var match = baseColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        var baseR = parseInt(match[1]);
        var baseG = parseInt(match[2]);
        var baseB = parseInt(match[3]);

        var target = targetColors[baseColor] || { r: 255, g: 255, b: 255 }; // fallback putih kalau baseColor gak ada

        return values.map(function(value, index) {
            if (index === 0) { // data pertama pake warna dasar
                return baseColor; 
            }

            //buat gradasinya 
            var ratio = index / (values.length - 1);
            var r = Math.round(baseR + (target.r - baseR) * ratio);
            var g = Math.round(baseG + (target.g - baseG) * ratio);
            var b = Math.round(baseB + (target.b - baseB) * ratio);

            return 'rgb(' + r + ',' + g + ',' + b + ')';
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        var ctxUsia = document.getElementById("chartUsia").getContext("2d");
        var labelsUsia = <?= $labels; ?>;
        var dataValuesUsia = <?= $datas; ?>;
        var totalUsia = <?= $total; ?>;

        var warnaUsia = getDynamicColors(dataValuesUsia, totalUsia, 'rgba(2, 32, 92, 0.8)');

        if (window.chartUsia instanceof Chart) {
            window.chartUsia.destroy();
        }

        window.chartUsia = new Chart(ctxUsia, {
            type: "pie",
            data: {
                labels: labelsUsia,
                datasets: [{
                    data: dataValuesUsia,
                    backgroundColor: warnaUsia,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { font: { size: 10 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                var jumlah = dataValuesUsia[tooltipItem.dataIndex] || 0;
                                var persentase = ((jumlah / totalUsia) * 100).toFixed(1);
                                return jumlah + " pasien (" + persentase + "%)";
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 15 },
                        anchor: 'center',
                        align: 'center',
                        formatter: function(value) {
                            var persentase = ((value / totalUsia) * 100).toFixed(1);
                            return persentase + "%";
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
    </script>

    <div class="col-4">
        <!-- WILAYAH -->
        <div class="card text-center border border-2">
            <div class="card-body">
                <button onclick="exportKelurahanToExcel()" class="btn btn-success btn-sm mb-2">
                    <i class="fa-solid fa-print" style="color: #ffffff;"></i> CETAK EXCEL
                </button>
                <h5 class="text-center">Kelurahan Domisili Pasien</h5>
                <canvas id="chartKelurahan"></canvas>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT k.namaKelurahan, COUNT(p.idPasien) AS jumlah
            FROM pasien p
            JOIN kelurahan k ON p.idKelurahanDomisili = k.idKelurahan
            WHERE p.idKelurahanDomisili IN (40579, 40580, 40581, 40582)
            GROUP BY p.idKelurahanDomisili";
    $view = new cView();
    $arrayhasil = $view->vViewData($sql);

    $labels = [];
    $datas = [];
    $total = 0;

    foreach ($arrayhasil as $value) {
    $labels[] = trim($value["namaKelurahan"]);
    $datas[] = (int) $value["jumlah"];
    $total += (int) $value["jumlah"];
    }

    // Urutin dari besar ke kecil
    array_multisort($datas, SORT_DESC, $labels);

    $labels = json_encode($labels, JSON_UNESCAPED_UNICODE);
    $datas = json_encode($datas);
    $total = max($total, 1);
    ?>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctxKelurahan = document.getElementById("chartKelurahan").getContext("2d");
        var labelsKelurahan = <?= $labels; ?>;
        var dataValuesKelurahan = <?= $datas; ?>;
        var totalKelurahan = <?= $total; ?>;

        var warnaKelurahan = getDynamicColors(dataValuesKelurahan, totalKelurahan, 'rgba(0, 103, 48, 0.8)');

        if (window.chartKelurahan instanceof Chart) {
            window.chartKelurahan.destroy();
        }

        window.chartKelurahan = new Chart(ctxKelurahan, {
            type: "pie",
            data: {
                labels: labelsKelurahan,
                datasets: [{
                    data: dataValuesKelurahan,
                    backgroundColor: warnaKelurahan,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "bottom" },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                var jumlah = dataValuesKelurahan[tooltipItem.dataIndex] || 0;
                                var persentase = ((jumlah / totalKelurahan) * 100).toFixed(1);
                                return jumlah + " pasien (" + persentase + "%)";
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 15 },
                        anchor: 'center',
                        align: 'center',
                        formatter: function(value) {
                            var persentase = ((value / totalKelurahan) * 100).toFixed(1);
                            return persentase + "%";
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
    </script>

    <div class="col-4">
        <!-- GOLONGAN DARAH -->
        <div class="card text-center border border-2">
            <div class="card-body">
                <button onclick="exportGoldarToExcel()" class="btn btn-success btn-sm mb-2">
                    <i class="fa-solid fa-print" style="color: #ffffff;"></i> CETAK EXCEL
                </button>
                <h5 class="text-center">Golongan Darah Pasien</h5>
                <canvas id="chartGoldar"></canvas>
            </div>
        </div>

        <?php
        $sql = "SELECT * FROM vGolonganDarah";
        $view = new cView();
        $arrayhasil = $view->vViewData($sql);

        $labels = [];
        $datas = [];
        $total = 0;

        foreach ($arrayhasil as $value) {
            $labels[] = $value["golonganDarah"];
            $datas[] = (int) $value["jumlah"];
            $total += (int) $value["jumlah"];
        }

        // Urutin dari besar ke kecil
        array_multisort($datas, SORT_DESC, $labels);

        $labels = json_encode($labels);
        $datas = json_encode($datas);
        $total = max($total, 1);
        ?>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctxGoldar = document.getElementById('chartGoldar').getContext('2d');
            var labelsGoldar = <?= $labels; ?>;
            var dataValuesGoldar = <?= $datas; ?>;
            var totalGoldar = <?= $total; ?>;

            var warnaGoldar = getDynamicColors(dataValuesGoldar, totalGoldar, 'rgba(153, 0, 0, 0.8)');

            if (window.chartGoldar instanceof Chart) {
                window.chartGoldar.destroy();
            }

            window.chartGoldar = new Chart(ctxGoldar, {
                type: 'pie',
                data: {
                    labels: labelsGoldar,
                    datasets: [{
                        data: dataValuesGoldar,
                        backgroundColor: warnaGoldar,
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var jumlah = dataValuesGoldar[tooltipItem.dataIndex];
                                    var persentase = ((jumlah / totalGoldar) * 100).toFixed(1);
                                    return jumlah + " pasien (" + persentase + "%)";
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: { weight: 'bold', size: 15 },
                            anchor: 'center',
                            align: 'center',
                            formatter: function(value) {
                                var persentase = ((value / totalGoldar) * 100).toFixed(1);
                                return persentase + "%";
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
        </script>
    </div>
</div>

        <script>
            function exportUsiaToExcel() {
                var labels = window.chartUsia.data.labels;
                var dataValues = window.chartUsia.data.datasets[0].data;

                // Format Data dengan Judul
                var data = [
                    ["LAPORAN PASIEN BERDASARKAN KELOMPOK USIA "],  // Judul
                    [""],
                    ["Kelompok Usia", "Jumlah Pasien"]  // Header
                ];

                for (var i = 0; i < labels.length; i++) {
                    data.push([labels[i], dataValues[i]]);
                }

                // Buat Worksheet
                var ws = XLSX.utils.aoa_to_sheet(data);

                // Styling untuk judul
                ws["A1"].s = { font: { bold: true, sz: 14 }, alignment: { horizontal: "center" } };

                // Styling untuk header
                ws["A3"].s = { font: { bold: true } };
                ws["B3"].s = { font: { bold: true } };

                // Auto-width kolom
                ws["!cols"] = [
                    { wch: 20 },  // Kolom "Kelompok Usia"
                    { wch: 15 }   // Kolom "Jumlah Pasien"
                ];

                // Buat Workbook dan Simpan File
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Kelompok Usia");
                XLSX.writeFile(wb, "Kelompok_Usia.xlsx");
            }

            function exportKelurahanToExcel() {
                var labels = window.chartKelurahan.data.labels;
                var dataValues = window.chartKelurahan.data.datasets[0].data;

                // Format Data dengan Judul
                var data = [
                    ["LAPORAN PASIEN BERDASARKAN KELURAHAN DOMISILI"],  // Judul
                    [""], 
                    ["Kelurahan Domisili", "Jumlah Pasien"]  // Header
                ];

                for (var i = 0; i < labels.length; i++) {
                    data.push([labels[i], dataValues[i]]);
                }

                // Buat Worksheet
                var ws = XLSX.utils.aoa_to_sheet(data);

                // Styling untuk judul
                ws["A1"].s = { font: { bold: true, sz: 14 }, alignment: { horizontal: "center" } };

                // Styling untuk header
                ws["A3"].s = { font: { bold: true } };
                ws["B3"].s = { font: { bold: true } };

                // Auto-width kolom
                ws["!cols"] = [
                    { wch: 20 }, 
                    { wch: 15 }
                ];

                // Buat Workbook dan Simpan File
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Kelurahan Domisili");
                XLSX.writeFile(wb, "Kelurahan_Domisili.xlsx");
            }

            function exportGoldarToExcel() {
                var labels = window.chartGoldar.data.labels;
                var dataValues = window.chartGoldar.data.datasets[0].data;

                // Format Data dengan Judul
                var data = [
                    ["LAPORAN PASIEN BERDASARKAN GOLONGAN DARAH"],  // Judul
                    [""],
                    ["Golongan Darah", "Jumlah Pasien"]  // Header
                ];

                for (var i = 0; i < labels.length; i++) {
                    data.push([labels[i], dataValues[i]]);
                }

                // Buat Worksheet
                var ws = XLSX.utils.aoa_to_sheet(data);

                // Styling untuk judul
                ws["A1"].s = { font: { bold: true, sz: 14 }, alignment: { horizontal: "center" } };

                // Styling untuk header
                ws["A3"].s = { font: { bold: true } };
                ws["B3"].s = { font: { bold: true } };

                // Auto-width kolom
                ws["!cols"] = [
                    { wch: 20 },  // Kolom "Golongan Darah"
                    { wch: 15 }   // Kolom "Jumlah Pasien"
                ];

                // Buat Workbook dan Simpan File
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Golongan Darah");
                XLSX.writeFile(wb, "Golongan_Darah.xlsx");
            }
        </script>
    </div>
</div><br>

<!-- Distribusi Pasien -->
<div class="row mx-2 justify-content-center">
    <div class="col-12">
        <!-- DISTRIBUSI PASIEN -->
        <div class="card text-center border border-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <button id="btnExportDistribusiPasien" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-print" style="color: #ffffff;"></i> CETAK EXCEL
                    </button>
                    <h5 class="flex-grow-1 text-center">Distribusi Pasien</h5>
                    <select id="filterTahun" class="form-select form-select-sm w-auto">
                        <option value="">Semua Tahun</option>
                    </select>
                </div>
                <div style="width: 100%; height: 300px;">
                    <canvas id="chartDistribusiPasien"></canvas>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            let ctx = document.getElementById('chartDistribusiPasien').getContext('2d');
            let chartDistribusi;
            let chartData = {};
            let selectedYear = "";
            function loadChart(tahun = '') {
                selectedYear = tahun;
                fetch(`chartDistribusiPasien.php?tahun=${tahun}`) // ambil data JSON dgn parameter tahun
                    .then(response => response.json())
                    .then(data => {
                        chartData = data; // simpan data untuk cetak Excel
                        if (chartDistribusi) {
                            chartDistribusi.destroy();
                        }
                        chartDistribusi = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels, // data bulan 1,2,3, ... (sumbu X)
                                datasets: [
                                    { label: 'Fisioterapi', data: data.datasets.fisioterapi, borderColor: 'rgba(255, 99, 132, 1)', fill: false },
                                    { label: 'Kinesioterapi', data: data.datasets.kinesioterapi, borderColor: 'rgba(54, 162, 235, 1)', fill: false }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: { display: true, text: 'Bulan' }
                                    },
                                    y: {
                                        title: { display: true, text: 'Jumlah Pasien' }
                                    }
                                }
                            }
                        });
                    });
            }

            function loadTahun() {
                fetch(`getTahunDistribusi.php`)
                    .then(response => response.json())
                    .then(data => { // isi filter dropdown secara dinamis
                        let select = document.getElementById('filterTahun');
                        select.innerHTML = '<option value="">Semua Tahun</option>';
                        data.forEach(tahun => {
                            let option = document.createElement('option');
                            option.value = tahun;
                            option.textContent = tahun;
                            select.appendChild(option);
                        });
                    });
            }

            document.getElementById('filterTahun').addEventListener('change', function() {
                loadChart(this.value);
            });

            // CETAK EXCEL
            document.getElementById('btnExportDistribusiPasien').addEventListener('click', function() {
                if (!chartData.labels) {
                    alert("Data belum tersedia untuk diekspor!");
                    return;
                }
                let worksheetData = [];

                // Tambahkan JUDUL di Excel
                worksheetData.push(["Distribusi Pasien"]);
                worksheetData.push(["Tahun:", selectedYear || "Semua Tahun"]);
                worksheetData.push([]); 

                // Header Data
                worksheetData.push(["Bulan", "Fisioterapi", "Kinesioterapi"]);

                // Tambahkan Data Grafik
                chartData.labels.forEach((bulan, index) => {
                    worksheetData.push([
                        bulan,
                        chartData.datasets.fisioterapi[index] || 0,
                        chartData.datasets.kinesioterapi[index] || 0
                    ]);
                });

                let ws = XLSX.utils.aoa_to_sheet(worksheetData);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Distribusi Pasien");

                XLSX.writeFile(wb, `Distribusi_Pasien_${selectedYear || "Semua_Tahun"}.xlsx`);
            });

            loadTahun();
            loadChart();
        });
        </script>
    </div>
</div>
<br>

<!-- total program layanan -->
<div class="row mx-2 justify-content-center">
    <div class="col-12">
        <!-- TOTAL PROGRAM -->
        <div class="card text-center border border-2">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <button id="btnExportTotalProgram" class="btn btn-success btn-sm text-start">
                        <i class="fa-solid fa-print" style="color: #ffffff;"></i> CETAK EXCEL
                    </button>
                </div>
                <div class="col-8">
                    <h5 class="text-center">Total Program Layanan</h5>
                </div>
            </div>

            <!-- Filter -->
            <div class="d-flex justify-content-center mb-3">
                <select id="filterMonth" class="form-select form-select-sm w-auto mx-2">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>

                <select id="filterYear" class="form-select form-select-sm w-auto mx-2">
                    <option value="">Pilih Tahun</option>
                    <?php 
                    $currentYear = date("Y");
                    for ($year = $currentYear; $year >= 2020; $year--) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
                <button id="btnFilter" class="btn btn-primary btn-sm mx-2">Filter</button>
            </div>
                
            <!-- Chart -->
            <div style="width: 100%; height: 300px;">
                <canvas id="chartTotalProgram"></canvas>
            </div>
        </div>


            <script>
            $(document).ready(function () {
                var ctx = document.getElementById('chartTotalProgram').getContext('2d');
                var myChart;

                // fungsi grafik sesuai filter bulan dan tahun
                function loadChart(bulan = '', tahun = '') { 
                    $.ajax({
                        url: 'chartTotalProgram.php', //Kirim req ke chartTotalProgram.php dengan parameter bulan dan tahun
                        type: 'GET',
                        data: { bulan: bulan, tahun: tahun },
                        dataType: 'json',
                        success: function (response) {
                            var labels = response.labels;
                            var datas = response.datas;

                            if (myChart) { myChart.destroy(); }

                            myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Total Program',
                                        data: datas,
                                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'start',
                                            formatter: function(value, context) {
                                                return  value;
                                            },
                                            font: { size: 16, weight: 'bold'},
                                            color: '#000'
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: true,
                                            title: { display: true, text: 'Program Layanan' },
                                        },
                                        y: {
                                            display: true,
                                            title: { display: true, text: 'Jumlah Program'},
                                            ticks: { stepSize: 1 }
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels] 
                            });


                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                }

                // Load chart tanpa filter
                loadChart();

                // Tombol filter diklik
                $("#btnFilter").click(function () {
                    var bulan = $("#filterMonth").val();
                    var tahun = $("#filterYear").val();
                    // Load chart dengan bulan dan tahun
                    loadChart(bulan, tahun);
                });
            });

            $("#btnExportTotalProgram").click(function () {
                var bulan = $("#filterMonth").val();
                var tahun = $("#filterYear").val();

                // ubah bulan angka ke teks untuk string filter pada judul laporan
                var bulanText = $("#filterMonth option:selected").text();
                var tahunText = tahun ? tahun : "Semua Tahun";
                var filterInfo = bulan ? `Bulan: ${bulanText}, Tahun: ${tahunText}` : `Tahun: ${tahunText}`;

                $.ajax({
                    url: 'chartTotalProgram.php',
                    type: 'GET',
                    data: { bulan: bulan, tahun: tahun },
                    dataType: 'json',
                    success: function (response) {
                        var labels = response.labels;
                        var datas = response.datas;
                        
                        // Buat data Excel dalam format array
                        var excelData = [
                            ["Total Program Layanan"],   // Judul
                            [filterInfo],                // Informasi filter
                            [],                          
                            ["Nama Program", "Total"] // Header
                        ];
                    
                        // Tambahkan data program layanan
                        labels.forEach((label, index) => {
                            excelData.push([label, datas[index]]);
                        });
                        
                        // Buat worksheet
                        var ws = XLSX.utils.aoa_to_sheet(excelData);
                    
                        // Merge cell untuk judul dan informasi filter
                        ws["!merges"] = [
                            { s: { r: 0, c: 0 }, e: { r: 0, c: 2 } }, // Judul
                            { s: { r: 1, c: 0 }, e: { r: 1, c: 2 } }  // Info filter
                        ];
                        
                        // Atur lebar kolom
                        ws["!cols"] = [
                            { wch: 30 },  // Nama Program
                            { wch: 10 }   // Total
                        ];
                        
                        // Rata kiri pada semua sel
                        Object.keys(ws).forEach(cell => {
                            if (cell[0] !== '!') { 
                                ws[cell].s = { alignment: { horizontal: "left" } };
                            }
                        });
                        
                        // Buat workbook & simpan file
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "Total Program");
                        XLSX.writeFile(wb, "Laporan_Total_Program.xlsx");
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });
        </script>
        </div>
    </div>
</div>
<br><br><br>
<p></p>
</body>
</html>
