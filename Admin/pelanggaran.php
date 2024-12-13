<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$serverName = "BEBI\DBMS22"; // Ganti dengan nama server Anda
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data biodata mahasiswa
    $sql = "SELECT * FROM tb_pelanggaran"; // Ganti dengan nama tabel yang sesuai
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $mahasiswa = $stmt->fetchAll(); // Mengambil semua data mahasiswa
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
                        <a href="#" class="nav-link">
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
                <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai mengelola tata tertib, pelanggaran, dan
                    notifikasi</p>
                    

                <!-- Tabel Mahasiswa -->
                <h4>Mahasiswa</h4>
                <table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Kelas</th>
            <th>Pelanggaran</th>
            <th>Tingkat</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1; // Variabel untuk nomor urut
        foreach ($mahasiswa as $row) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
            echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pelanggaran']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tingkat']) . "</td>";
            echo "<td><span class='badge bg-success'>Selesai</span></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
