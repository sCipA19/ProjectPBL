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
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Query untuk mengambil data dari tabel tb_laporan_pelanggaran_dosen
$sqlLaporan = "SELECT id_laporan, nim, nama_mahasiswa, kelas_mahasiswa, nama_pelanggaran, deskripsi_pelanggaran, status_id
               FROM tb_laporan_pelanggaran_dosen";  // Mengambil status langsung dari kolom status
$stmtLaporan = $conn->prepare($sqlLaporan);
$stmtLaporan->execute();
$dataLaporan = $stmtLaporan->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TATIB - ANUKRAMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4>ANUKRAMA</h4>
                <div class="profile">
                    <img src="image/Dosen2.jpg" alt="Profile Picture">
                    <h5 class="mt-2">Purnomo Sujarwo S.Pd A.Sg</h5>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i> Dashboard TATIB
                    </a>
                    <a href="laporkan_mahasiswa.php" class="nav-link">
                        <i class="fas fa-clipboard-list"></i> Laporkan Pelanggaran
                    </a>
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>

            
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <h1 class="fw-bold">Selamat Datang</h1>
                <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai laporkan pelanggaran, dan notifikasi.</p>
                
             <!-- Tabel Pelanggaran -->
<div class="table-container mt-4" style="max-height: 550px; overflow-y: auto; ">
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Kelas</th>
                <th>Nama Pelanggaran</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($dataLaporan)) {
                foreach ($dataLaporan as $index => $row) {
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kelas_mahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pelanggaran']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deskripsi_pelanggaran']) . "</td>";
                    echo "<td>";
                    // Cek nilai status_id dan tampilkan status yang sesuai
                    if ($row['status_id'] == 1) {
                        echo "<span class='badge badge-danger'>Proses</span>";
                    } elseif ($row['status_id'] == 2) {
                        echo "<span class='badge badge-success'>Selesai</span>";
                    } else {
                        echo "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                    }
                    echo "</td>";
                    echo "<td class='text-center'>";
                    echo "<a href='edit_laporan.php?id=" . htmlspecialchars($row['id_laporan']) . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>";
                    echo " ";
                    echo "<a href='delete_laporan.php?id=" . htmlspecialchars($row['id_laporan']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus laporan ini?\")'><i class='fas fa-trash'></i> Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data pelanggaran</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
