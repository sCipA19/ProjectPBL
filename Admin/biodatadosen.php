<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$serverName = "BEBI\DBMS22"; // Ganti dengan nama server
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data biodata dosen
    $sql = "SELECT * FROM tb_dosen"; // Ganti dengan nama tabel biodata dosen Anda
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dosen = $stmt->fetchAll(); // Menyimpan hasil query dalam bentuk array
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
    <link rel="stylesheet" href="style_bio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
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
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-bell me-2"></i>Notifikasi Mahasiswa
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 p-4" id="main-content">
        <h2>Selamat Datang</h2>
        <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai mengelola tata tertib, pelanggaran, dan notifikasi</p>

        
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h4>Dosen</h4>
                        <p>18</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <a href="biodatamahasiswa.php" class="text-decoration-none">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4>Mahasiswa</h4>
                            <p>18</p>
                        </div>
                    </div>
                </a>
            </div>


            <!-- Biodata Dosen -->
            <div class="card p-4">
                <h4 class="text-center">BIODATA DOSEN</h4>
                <div class="row">
                    <div class="col-12">
                        <p>Nama: <span>Bambang Yudi</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>NIP: <span>2341760007</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>Email: <span>bambang123@gmail.com</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>Alamat: <span>Jl. Surabaya Blok A12 No 14</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>No. HP: <span>08234-98767-2367</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>Prodi/Kelas: <span>SIB - 3A</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                    <div class="col-12">
                        <p>Status: <span>Aktif</span> <a href="#" class="text-primary"><i
                                    class="bi bi-pencil-square"></i></a></p>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-secondary">Reset</button>
                    <a href="beranda.php">
                        <button class="btn btn-primary">Save</button>
                    </a>

                </div>
            </div>
        </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>