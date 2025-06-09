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
            border-color:rgb(43, 80, 135) !important;
            color:rgb(33, 87, 168) !important; 
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

<div class="row mx-2 justify-content-center">
    <div class="col-5">
        <!-- JENIS DISABILITAS -->
        <div class="card text-center border border-2" style="height: 380px;">
            <div class="card-body" >
                <button onclick="exportToExcel('chartJD', 'Jenis Disabilitas')" class="btn btn-success mb-2 btn-sm ">
                    <i class="fa-solid fa-print"></i> CETAK EXCEL
                </button>
                <h5>Jenis Disabilitas Pasien</h5>
                <canvas id="chartJD"></canvas>
            </div>
        </div>
    </div>
    
    
    <div class="col-5">
        <!-- SUB DISABILITAS -->
        <div class="card text-center border border-2" style="height: 380px;">
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

            // Load chart utama saat halaman dimuat
            loadChartJD();
            loadEmptyChartSubJD(); // Menampilkan chart kosong

            // Fungsi untuk memuat chart utama (Jenis Disabilitas)
            function loadChartJD() {
                $.ajax({
                    url: 'chartDisabilitas.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var ctx = document.getElementById('chartJD').getContext('2d');

                        // Simpan ID jenis disabilitas dari respons
                        var idJenisList = response.ids;

                        if (chartJD) {
                            chartJD.destroy();
                        }
                        chartJD = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    label: 'Jenis Disabilitas',
                                    data: response.datas,
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
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
                                        var idJenisDisabilitas = idJenisList[index]; // Gunakan ID yang benar
                                        loadChartSubJD(idJenisDisabilitas);
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

            // Fungsi untuk memuat chart sub jenis disabilitas
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
    function exportToExcel(chartId, sheetName, filterText = "") {
        var chart = Chart.getChart(chartId); // Ambil grafik berdasarkan ID
        if (!chart) {
            alert("Grafik tidak ditemukan!");
            return;
        }

        var labels = chart.data.labels; // Ambil label sumbu X
        var datas = chart.data.datasets[0].data; // Ambil data jumlah pasien

        // Tambahkan judul dan header dengan pemformatan lebih rapi
        var dataExcel = [
            [sheetName.toUpperCase()], // Judul laporan (huruf besar)
            [],                        // Baris kosong
            ["Kategori", "Jumlah Pasien"] // Header tabel
        ];

        // Jika ada filter, tambahkan info jenis disabilitas
        if (filterText) {
            dataExcel.splice(1, 0, ["Jenis Disabilitas:", filterText]);
        }

        // Masukkan data ke dalam Excel
        for (var i = 0; i < labels.length; i++) {
            dataExcel.push([labels[i], datas[i]]);
        }

        // Buat sheet Excel
        var ws = XLSX.utils.aoa_to_sheet(dataExcel);

        // Auto-width untuk kolom agar tidak kepotong
        var wsCols = [
            { wch: 30 }, // Lebar kolom pertama (Kategori)
            { wch: 15 }  // Lebar kolom kedua (Jumlah Pasien)
        ];
        ws['!cols'] = wsCols;

        //  Tambahkan bold pada header dan judul
        var titleCell = ws["A1"];
        if (titleCell) titleCell.s = { font: { bold: true, sz: 14 } }; // Judul besar

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
</div>

<div><br><br></div>
   

<!-- pie chart -->
<div class="row mx-2 justify-content-center">
    
        <div class="col-5">
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
                    $namaKelompok = trim($value["kelompokUsia"]);
                    $jumlah = (int) $value["jumlah"];

                    $labels[] = $namaKelompok;
                    $datas[] = $jumlah;
                    $total += $jumlah;
                }

                $labels = json_encode($labels, JSON_UNESCAPED_UNICODE);
                $datas = json_encode($datas);
                $total = max($total, 1); // Mencegah pembagian dengan nol
            ?>

            <script>
            document.addEventListener("DOMContentLoaded", function () {
                var ctx = document.getElementById("chartUsia").getContext("2d");
                var labels = <?= $labels; ?>;
                var dataValues = <?= $datas; ?>;
                var total = <?= $total; ?>;

                console.log("Labels:", labels);
                console.log("Data Values:", dataValues);
                console.log("Total Pasien:", total);

                var colors = [
                    "rgba(176, 214, 254, 0.8)",  
                    "rgba(132, 192, 251, 0.8)", 
                    "rgba(102, 153, 255, 0.8)", 
                    "rgba(51, 102, 204, 0.8)", 
                    "rgba(0, 51, 153, 0.8)" 
                ];

                // Cek apakah chart sudah ada, jika ada maka hapus dulu sebelum membuat yang baru
                if (window.chartUsia instanceof Chart) {
                    window.chartUsia.destroy();
                }

                window.chartUsia = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            data: dataValues,
                            backgroundColor: colors,
                            borderColor: "#fff",
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: "bottom"
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        var jumlah = dataValues[tooltipItem.dataIndex] || 0;
                                        var persentase = ((jumlah / total) * 100).toFixed(1);
                                        return jumlah + " pasien (" + persentase + "%)";
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: { weight: 'bold', size: 18 },
                                anchor: 'center', // Pusat label di dalam pie
                                align: 'center',
                                formatter: function(value, context) {
                                    // var label = context.chart.data.labels[context.dataIndex];
                                    var persentase = ((value / total) * 100).toFixed(1);
                                    return persentase + "%"; // 👈 Menampilkan label + jumlah + persen
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });
            </script>
       
       <div class="col-5">
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
                    $datas[] = $value["jumlah"];
                    $total += $value["jumlah"];
                }

                $labels = json_encode($labels);
                $datas = json_encode($datas);
                $total = max($total, 1); // Mencegah pembagian dengan nol
            ?>

            <script>
                var ctx = document.getElementById('chartGoldar').getContext('2d');
                var labels = <?= $labels; ?>;
                var dataValues = <?= $datas; ?>;
                var total = <?= $total; ?>;

                var colors = [
                    'rgba(153, 0, 0, 0.8)',  // A - Merah gelap
                    'rgba(204, 51, 51, 0.8)', // B - Merah medium
                    'rgba(255, 102, 102, 0.8)', // AB - Merah lebih muda
                    'rgba(255, 153, 153, 0.8)'  // O - Merah paling terang
                ];

                var chartGoldar = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: dataValues,
                            backgroundColor: colors,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }, // 👈 Hapus legend default
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var jumlah = dataValues[tooltipItem.dataIndex];
                                        var persentase = ((jumlah / total) * 100).toFixed(1);
                                        return jumlah + " pasien (" + persentase + "%)";
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: { weight: 'bold', size: 18 },
                                anchor: 'center', // Pusat label di dalam pie
                                align: 'center',
                                formatter: function(value, context) {
                                    // var label = context.chart.data.labels[context.dataIndex];
                                    var persentase = ((value / total) * 100).toFixed(1);
                                    return persentase + "%"; // 👈 Menampilkan label + jumlah + persen
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // 👈 Aktifkan Data Labels hanya untuk chart ini
                });
            </script>
        </div>

        <script>
            function exportUsiaToExcel() {
            var labels = window.chartUsia.data.labels;
            var dataValues = window.chartUsia.data.datasets[0].data;

            // Format Data dengan Judul
            var data = [
                ["LAPORAN KELOMPOK USIA PASIEN"],  // Judul
                [""], // Baris kosong sebagai pemisah
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

            function exportGoldarToExcel() {
                var labels = window.chartGoldar.data.labels;
                var dataValues = window.chartGoldar.data.datasets[0].data;

                // Format Data dengan Judul
                var data = [
                    ["LAPORAN GOLONGAN DARAH PASIEN"],  // Judul
                    [""], // Baris kosong sebagai pemisah
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
</div>


<!-- Distribusi Pasien -->
<div><br><br></div>
<div class="row mx-2 justify-content-center">
    <div class="col-11">
        <!-- DISTRIBUSI PASIEN -->
        <div class="card text-center border border-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <button id="btnExportDistrubsiPasien" class="btn btn-success btn-sm">
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
            let chartData = {}; // Simpan data untuk ekspor
            let selectedYear = ""; // Simpan tahun yang dipilih
            function loadChart(tahun = '') {
                selectedYear = tahun; // Simpan tahun untuk ekspor
                fetch(`chartDistribusiPasien.php?tahun=${tahun}`)
                    .then(response => response.json())
                    .then(data => {
                        chartData = data;
                        if (chartDistribusi) {
                            chartDistribusi.destroy();
                        }
                        chartDistribusi = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [
                                    { label: 'Fisioterapi', data: data.datasets.fisioterapi, borderColor: 'rgba(255, 99, 132, 1)', fill: false },
                                    { label: 'Kinesioterapi', data: data.datasets.kinesioterapi, borderColor: 'rgba(54, 162, 235, 1)', fill: false },
                                    { label: 'Screening', data: data.datasets.screening, borderColor: 'rgba(255, 206, 86, 1)', fill: false },
                                    { label: 'Konsultasi', data: data.datasets.konsultasi, borderColor: 'rgba(75, 192, 192, 1)', fill: false },
                                    { label: 'Edukasi', data: data.datasets.edukasi, borderColor: 'rgba(153, 102, 255, 1)', fill: false }
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
                    .then(data => {
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

            // EKSPOR KE EXCEL DENGAN JUDUL & FILTER
            document.getElementById('btnExportDistrubsiPasien').addEventListener('click', function() {
                if (!chartData.labels) {
                    alert("Data belum tersedia untuk diekspor!");
                    return;
                }
                let worksheetData = [];

                // Tambahkan JUDUL di Excel
                worksheetData.push(["Distribusi Pasien"]);
                worksheetData.push(["Tahun:", selectedYear || "Semua Tahun"]);
                worksheetData.push([]); // Baris kosong untuk pemisah

                // Header Data
                worksheetData.push(["Bulan", "Fisioterapi", "Kinesioterapi", "Screening", "Konsultasi", "Edukasi"]);

                // Tambahkan Data Grafik
                chartData.labels.forEach((bulan, index) => {
                    worksheetData.push([
                        bulan,
                        chartData.datasets.fisioterapi[index] || 0,
                        chartData.datasets.kinesioterapi[index] || 0,
                        chartData.datasets.screening[index] || 0,
                        chartData.datasets.konsultasi[index] || 0,
                        chartData.datasets.edukasi[index] || 0
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
<br><br>

<!-- total program layanan -->
<div class="row mx-2 justify-content-center">
    <div class="col-11">
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

                function loadChart(bulan = '', tahun = '') {
                    $.ajax({
                        url: 'chartTotalProgram.php',
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
                                            anchor: 'end',          // Posisi di ujung
                                            align: 'start',         // Teks di atas bar
                                            formatter: function(value, context) {
                                                return  value; // Label di angka
                                            },
                                            font: {
                                                size: 16,           // Perbesar font
                                                weight: 'bold'
                                            },
                                            color: '#000'           // Warna teks hitam
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Program Layanan'
                                            },
                                            ticks: {
                                                stepSize: 1
                                            }
                                        },
                                        y: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Jumlah Program'
                                            },
                                            ticks: {
                                                stepSize: 1,
                                                precision: 0
                                            }
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels] // ✅ Penting: aktifkan plugin
                            });


                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                }

                // Load chart pertama kali tanpa filter
                loadChart();

                // Event saat tombol filter diklik
                $("#btnFilter").click(function () {
                    var bulan = $("#filterMonth").val();
                    var tahun = $("#filterYear").val();
                    loadChart(bulan, tahun);
                });
                 });
                 $("#btnExportTotalProgram").click(function () {
                    var bulan = $("#filterMonth").val();
                    var tahun = $("#filterYear").val();

                    // Konversi bulan angka ke teks
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
                                ["Total Program Layanan"],   // Judul laporan
                                [filterInfo],                // Informasi filter
                                [],                          // Baris kosong
                                ["No", "Nama Program", "Total"] // Header tabel
                            ];
                        
                            // Tambahkan data program layanan
                            labels.forEach((label, index) => {
                                excelData.push([index + 1, label, datas[index]]);
                            });
                        
                            // Buat worksheet
                            var ws = XLSX.utils.aoa_to_sheet(excelData);
                        
                            // Merge cell untuk judul dan informasi filter
                            ws["!merges"] = [
                                { s: { r: 0, c: 0 }, e: { r: 0, c: 2 } }, // Judul di baris pertama
                                { s: { r: 1, c: 0 }, e: { r: 1, c: 2 } }  // Info filter di baris kedua
                            ];
                        
                            // Atur lebar kolom agar lebih rapi
                            ws["!cols"] = [
                                { wch: 5 },   // Kolom "No"
                                { wch: 30 },  // Kolom "Nama Program"
                                { wch: 10 }   // Kolom "Total"
                            ];
                        
                            // **Terapkan alignment rata kiri ke semua sel**
                            Object.keys(ws).forEach(cell => {
                                if (cell[0] !== '!') { // Hindari properti metadata (!cols, !merges, dll.)
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
