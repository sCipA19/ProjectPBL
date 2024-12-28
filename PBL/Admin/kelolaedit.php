<?php
session_start();
require '../koneksi/kon.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

try {
    // Pastikan parameter koneksi sesuai
    $conn = new PDO("sqlsrv:Server=BEBI\\DBMS22;Database=PBL", "", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek apakah form sudah disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form dengan validasi tambahan
        $nim = isset($_POST['nim']) ? trim($_POST['nim']) : null;
        $nama_mahasiswa = isset($_POST['nama_mahasiswa']) ? trim($_POST['nama_mahasiswa']) : null;
        $kelas = isset($_POST['kelas']) ? trim($_POST['kelas']) : null;
        $pelanggaran = isset($_POST['pelanggaran']) ? trim($_POST['pelanggaran']) : null;
        $tingkat = isset($_POST['tingkat']) ? trim($_POST['tingkat']) : null;
        $kompensasi = isset($_POST['kompensasi']) ? trim($_POST['kompensasi']) : null;
        $tenggat = isset($_POST['tenggat']) ? trim($_POST['tenggat']) : null;


        // Validasi data input
        if (!empty($nim) && !empty($nama_mahasiswa) && !empty($kelas) && !empty($pelanggaran) && !empty($tingkat) && !empty($kompensasi) && !empty($tenggat)) {
            // Insert data baru
            $stmt = $conn->prepare("INSERT INTO tb_kelolatatib (nim, nama_mahasiswa, kelas, pelanggaran, tingkat,kompensasi,tenggat) VALUES (:nim, :nama_mahasiswa, :kelas, :pelanggaran, :tingkat, :kompensasi, :tenggat)");

            // Bind parameter
            $stmt->bindParam(':nim', $nim);
            $stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
            $stmt->bindParam(':kelas', $kelas);
            $stmt->bindParam(':pelanggaran', $pelanggaran);
            $stmt->bindParam(':tingkat', $tingkat);
            $stmt->bindParam(':kompensasi', $kompensasi);
            $stmt->bindParam(':tenggat', $tenggat);

            if ($stmt->execute()) {
                // Setelah berhasil, arahkan ke kelola.php
                header("Location: kelola.php");
                exit();
            } else {
                echo "Gagal menyimpan pelanggaran.";
            }
        } else {
            echo "Semua kolom harus diisi.";
        }
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>








<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anukrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_beranda.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        // JavaScript function to add a card
        function addCard() {
            const cardContainer = document.getElementById("cardContainer");



            cardContainer.appendChild(card);
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar vh-100">
                <div class="text-center mt-4">
                    <h3 class="text-uppercase fw-bold">Anukrama</h3>
                    <img src="./img/pic.jpeg" alt="Suprapto" class="rounded-circle mt-3" width="80">
                    <h5 class="mt-2">Suprapto</h5>
                </div>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a href="beranda.php" class="nav-link">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pelanggaran.php" class="nav-link">
                            <i class="bi bi-list-task me-2"></i>Daftar Pelanggaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="kelola.php" class="nav-link">
                            <i class="bi bi-gear me-2"></i>Kelola Tata Tertib
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" onclick="toggleDropdown()">
                            <i class="bi bi-bell me-2"></i>Notifikasi
                        </a>
                        <div class="dropdown-container" id="dropdownMenu">
                            <ul class="notification-list">
                                <li><a href="notifikasidosen.php">Notifikasi dari Dosen</a></li>
                                <li><a href="notifikasimahasiswa.php">Notifikasi Mahasiswa</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4" id="main-content">
                <h2>Kelola Tata Tertib</h2>
                <p>Tambahkan, edit, atau hapus aturan tata tertib di bawah ini:</p>

                <!-- Form untuk tambah pelanggaran -->
                <form method="POST" action="" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-success mb-3">Tambah Pelanggaran</button>
                    <!-- Card Container -->
                    <div class="form-background">
                        <!-- Input NIM -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM"
                                    required>
                            </div>
                            <!-- Input Nama Mahasiswa -->
                            <div class="col-md-6">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa"
                                    placeholder="Masukkan Nama Mahasiswa" required>
                            </div>
                        </div>


                        <!-- Input Kelas -->
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option selected disabled value="">Pilih kelas</option>
                                <option value="SIB 1A">SIB 1A</option>
                                <option value="SIB 1B">SIB 1B</option>
                                <option value="SIB 1C">SIB 1C</option>
                                <option value="SIB 1D">SIB 1D</option>
                                <option value="SIB 1E">SIB 1E</option>
                                <option value="SIB 1F">SIB 1F</option>
                                <option value="SIB 1G">SIB 1G</option>
                                <option value="SIB 2A">SIB 2A</option>
                                <option value="SIB 2B">SIB 2B</option>
                                <option value="SIB 2C">SIB 2C</option>
                                <option value="SIB 2D">SIB 2D</option>
                                <option value="SIB 2E">SIB 2E</option>
                                <option value="SIB 2F">SIB 2F</option>
                                <option value="SIB 2G">SIB 2G</option>
                                <option value="SIB 3A">SIB 3A</option>
                                <option value="SIB 3B">SIB 3B</option>
                                <option value="SIB 3C">SIB 3C</option>
                                <option value="SIB 3D">SIB 3D</option>
                                <option value="SIB 3E">SIB 3E</option>
                                <option value="SIB 3F">SIB 3F</option>
                                <option value="SIB 3G">SIB 3G</option>
                                <option value="SIB 4A">SIB 4A</option>
                                <option value="SIB 4B">SIB 4B</option>
                                <option value="SIB 4C">SIB 4C</option>
                                <option value="SIB 4D">SIB 4D</option>
                                <option value="SIB 4E">SIB 4E</option>
                                <option value="SIB 4F">SIB 4F</option>
                                <option value="SIB 4G">SIB 4G</option>
                            </select>
                        </div>

                        <!-- Input Pelanggaran -->
                        <div class="mb-3">
                            <label for="pelanggaran" class="form-label">Pelanggaran</label>
                            <select class="form-select" id="pelanggaran" name="pelanggaran" required>
                                <option value="" selected disabled>Pilih Pelanggaran</option>
                                <option
                                    value="Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain">
                                    Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada
                                    mahasiswa, dosen, karyawan, atau orang lain</option>
                                <option
                                    value="Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana tertentu">
                                    Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai
                                    t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini,
                                    backless, celana pendek, celana tiga per empat, legging, model celana tertentu
                                </option>
                                <option
                                    value="Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah baju di bagian leher">
                                    Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati
                                    batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah
                                    baju di bagian leher</option>
                                <option
                                    value="Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned">
                                    Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned</option>
                                <option value="Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel">Makan, atau
                                    minum di dalam ruang kuliah/laboratorium/bengkel</option>
                                <option
                                    value="Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi">
                                    Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi
                                </option>
                                <option value="Tidak menjaga kebersihan di seluruh area Polinema">Tidak menjaga
                                    kebersihan di seluruh area Polinema</option>
                                <option
                                    value="Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung">
                                    Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang
                                    berlangsung</option>
                                <option value="Merokok di luar area kawasan merokok">Merokok di luar area kawasan
                                    merokok</option>
                                <option value="Bermain kartu, game online di area kampus">Bermain kartu, game online di
                                    area kampus</option>
                                <option
                                    value="Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema">
                                    Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan
                                    Polinema</option>
                                <option
                                    value="Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan">
                                    Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan
                                </option>
                                <option value="Merusak sarana dan prasarana yang ada di area Polinema">Merusak sarana
                                    dan prasarana yang ada di area Polinema</option>
                                <option
                                    value="Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)">
                                    Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir
                                    tidak pada tempatnya, konvoi selebrasi wisuda, dll)</option>
                                <option
                                    value="Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang">
                                    Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik
                                    Negeri Malang</option>
                                <option value="Mengakses materi pornografi di kelas atau area kampus">Mengakses materi
                                    pornografi di kelas atau area kampus</option>
                                <option
                                    value="Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal">
                                    Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal
                                </option>
                                <option
                                    value="Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif">
                                    Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif</option>
                                <option value="Melakukan kegiatan politik praktis di dalam kampus">Melakukan kegiatan
                                    politik praktis di dalam kampus</option>
                                <option value="Melakukan tindakan kekerasan atau perkelahian di dalam kampus">Melakukan
                                    tindakan kekerasan atau perkelahian di dalam kampus</option>
                                <option value="Melakukan penyalahgunaan identitas untuk perbuatan negatif">Melakukan
                                    penyalahgunaan identitas untuk perbuatan negatif</option>
                                <option
                                    value="Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan">
                                    Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau
                                    karyawan</option>
                                <option value="Mencuri dalam bentuk apapun">Mencuri dalam bentuk apapun</option>
                                <option value="Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan">
                                    Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan</option>
                                <option value="Melakukan pemerasan dan/atau penipuan">Melakukan pemerasan dan/atau
                                    penipuan</option>
                                <option
                                    value="Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus">
                                    Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di
                                    luar kampus</option>
                                <option
                                    value="Berjudi, mengkonsumsi minum-minuman keras, dan/atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema">
                                    Berjudi, mengkonsumsi minum-minuman keras, dan/atau bermabuk-mabukan di lingkungan
                                    dan di luar lingkungan Kampus Polinema</option>
                                <option
                                    value="Mengikuti organisasi dan/atau menyebarkan faham-faham yang dilarang oleh Pemerintah">
                                    Mengikuti organisasi dan/atau menyebarkan faham-faham yang dilarang oleh Pemerintah
                                </option>
                                <option value="Melakukan pemalsuan data/dokumen/tanda tangan">Melakukan pemalsuan
                                    data/dokumen/tanda tangan</option>
                                <option value="Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah">
                                    Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah</option>
                                <option
                                    value="Tidak menjaga nama baik Polinema di masyarakat dan/atau mencemarkan nama baik Polinema melalui media apapun">
                                    Tidak menjaga nama baik Polinema di masyarakat dan/atau mencemarkan nama baik
                                    Polinema melalui media apapun</option>
                                <option
                                    value="Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa, dan Polinema">
                                    Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat
                                    Negara, Bangsa, dan Polinema</option>
                                <option value="Menggunakan barang-barang psikotropika dan/atau zat-zat adiktif lainnya">
                                    Menggunakan barang-barang psikotropika dan/atau zat-zat adiktif lainnya</option>
                                <option
                                    value="Mengedarkan serta menjual barang-barang psikotropika dan/atau zat-zat adiktif lainnya">
                                    Mengedarkan serta menjual barang-barang psikotropika dan/atau zat-zat adiktif
                                    lainnya</option>
                                <option
                                    value="Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan">
                                    Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan</option>
                            </select>
                        </div>



                        <!-- Input Tingkat Pelanggaran -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat Pelanggaran</label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="" selected disabled>Pilih Tingkat Pelanggaran</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                        </div>
                        <!-- Input Kompensasi -->
                        <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kompensasi" class="form-label">Kompensasi</label>
                            <input type="text" class="form-control" id="kompensasi" name="kompensasi"
                                placeholder="Masukkan Kompensasi" required>
                        </div>
                            <!-- Tenggat Waktu -->
                            <div class="col-md-6">
                                <label for="tenggat" class="form-label">Tenggat Waktu</label>
                                <input type="date" class="form-control" id="tenggat" name="tenggat" required>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdownMenu");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        window.onclick = function (event) {
            if (!event.target.matches('.nav-link')) {
                const dropdown = document.getElementById("dropdownMenu");
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        };
    </script>
    </div>
    </div>
</body>

</html>