<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page - Sistem Informasi Keuangan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Custom CSS -->
    <style>
        .hero-section {
            background-image: url('https://via.placeholder.com/1200x600');
            /* Ganti dengan gambar hero */
            background-size: cover;
            background-position: center;
            height: 60vh;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .feature-section {
            padding: 50px 0;
        }

        .feature-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-box:hover {
            transform: scale(1.05);
        }

        .cta-btn {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div>
            <h1>Selamat Datang di Sistem Informasi Keuangan</h1>
            <p>Solusi terbaik untuk mengelola keuangan Anda dengan mudah dan efisien</p>
            <a href="#fitur" class="btn btn-primary btn-lg">Lihat Fitur</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="feature-section bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Pengelolaan Keuangan</h3>
                        <p>Kelola semua transaksi dan catatan keuangan Anda dengan mudah di satu tempat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Analisis Keuangan</h3>
                        <p>Dapatkan analisis yang mendalam tentang kondisi keuangan Anda dengan laporan yang mudah dipahami.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Keamanan Data</h3>
                        <p>Data Anda selalu aman dengan enkripsi tingkat tinggi dan sistem yang andal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-primary text-white text-center py-5">
        <h2>Mulai Sekarang</h2>
        <p>Daftarkan diri Anda untuk mengakses semua fitur yang kami tawarkan!</p>
        <a href="#" class="btn cta-btn btn-lg">Daftar Sekarang</a>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Sistem Informasi Keuangan. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>