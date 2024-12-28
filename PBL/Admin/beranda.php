<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../Login/index2.php"); // Jika belum login, arahkan ke halaman login
    exit();
}


// Koneksi ke database
$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server
$database = "PBL"; // Ganti dengan nama database
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk menghitung laporan yang belum dibaca
    $sql_notifikasi = "SELECT COUNT(*) as new_notifications FROM tb_laporan_pelanggaran_dosen WHERE is_read = 0"; // Misalnya, 0 = belum dibaca
    $stmt_notifikasi = $conn->prepare($sql_notifikasi);
    $stmt_notifikasi->execute();
    $result_notifikasi = $stmt_notifikasi->fetch(PDO::FETCH_ASSOC);
    $jumlah_notifikasi = $result_notifikasi['new_notifications'];
     // Query untuk menghitung jumlah mahasiswa
     $sql_jumlah_mahasiswa = "SELECT COUNT(*) AS jumlah_mahasiswa FROM tb_mahasiswa";
     $stmt_jumlah_mahasiswa = $conn->prepare($sql_jumlah_mahasiswa);
     $stmt_jumlah_mahasiswa->execute();
     $jumlah_mahasiswa = $stmt_jumlah_mahasiswa->fetch(PDO::FETCH_ASSOC)['jumlah_mahasiswa'];
 
     // Query untuk menghitung jumlah dosen
     $sql_jumlah_dosen = "SELECT COUNT(*) AS jumlah_dosen FROM tb_dosen"; // Ganti dengan nama tabel dosen Anda
     $stmt_jumlah_dosen = $conn->prepare($sql_jumlah_dosen);
     $stmt_jumlah_dosen->execute();
     $jumlah_dosen = $stmt_jumlah_dosen->fetch(PDO::FETCH_ASSOC)['jumlah_dosen'];

} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Query untuk mengambil jumlah dosen
$sqlDosen = "SELECT COUNT(*) FROM tb_dosen"; // Ganti dengan tabel dosen
$stmtDosen = $conn->prepare($sqlDosen);
$stmtDosen->execute();
$dosenCount = $stmtDosen->fetchColumn();

// Query untuk mengambil jumlah mahasiswa
$sqlMahasiswa = "SELECT COUNT(*) FROM tb_mahasiswa"; // Ganti dengan tabel mahasiswa
$stmtMahasiswa = $conn->prepare($sqlMahasiswa);
$stmtMahasiswa->execute();
$mahasiswaCount = $stmtMahasiswa->fetchColumn();
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
                        <a href="#" class="nav-link">
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
                <h2>Selamat Datang</h2>
                <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai mengelola tata tertib, pelanggaran, dan
                    notifikasi</p>

               <div class="row">
                    <div class="col-md-6">
                        <a href="tabeldosen.php" class="text-decoration-none">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4>Dosen</h4>
                                    <p><?php echo $jumlah_dosen; ?></p> <!-- Menampilkan jumlah dosen -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="tabelmahasiswa.php" class="text-decoration-none">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4>Mahasiswa</h4>
                                    <p><?php echo $jumlah_mahasiswa; ?></p> <!-- Menampilkan jumlah mahasiswa -->
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
function toggleDropdown() {
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.nav-link')) {
        const dropdown = document.getElementById("dropdownMenu");
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    }
};

</script>
</body>

</html>
