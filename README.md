# 🏥 Sistem Rekam Medis Elektronik (EMR) - Yayasan Pinilih Sedayu

Sistem ini dikembangkan untuk mendukung program layanan terapi kesehatan bagi penyandang disabilitas di Rumah Kebugaran Difabel (RKD) Yayasan Pinilih Sedayu. Sistem ini dirancang untuk mencatat, mengelola, dan memantau data rekam medis serta aktivitas program layanan yang berlangsung secara rutin.

## 🧩 Fitur Utama
### Autentikasi
- Login pengguna, reset password, dan sistem OTP melalui email.
### 1. **Beranda**
- Informasi ringkas dan daftar kegiatan terbaru.
### 2. **Master Data**
- Manajemen data pasien, tenaga medis/paramedis/non medis, pengguna, dan jenis disabilitas
### 3. **Program Layanan**
- **Fisioterapi**
  - Pencatatan jadwal dan hasil fisioterapi (CRUD)
- **Kinesioterapi**
  - Pencatatan jadwal dan hasil kinesioterapi (CRUD)
### 4. **Rekam Medis**
- Pencatatan daftar pasien
- Pencatatan detail rekam medis / riwayat pasien
- Fitur filter dan ekspor ke PDF/Excel.
### 5. **Laporan**
- Laporan operasional berdasarkan data pasien dan program layanan di RKD Pinilih.

## 👥 Peran Pengguna
- **Admin/Operator:** Mengelola seluruh fitur dalam sistem
- **Manajemen:** Mengakses seluruh fitur dalam sistem (read-only)
- **Terapis:** Mengelola program layanan dan rekam medis pasien

## 🛠️ Sistem
- **Bahasa Pemrograman:** PHP, HTML, CSS, JavaScript
- **Database:** MySQL
- **Tools:** XAMPP
- **Library Tambahan**: 
  - [TCPDF](https://tcpdf.org/) untuk ekspor PDF
  - phpoffice dan phpspreadsheet untuk ekspor excel
  - [PHPMailer] OTP system