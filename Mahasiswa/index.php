<?php
// Memastikan sesi hanya dimulai sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

    // Menangani status yang dipilih pada URL
    $statusFilter = $_GET['status'] ?? 'all'; // Default: tampilkan semua

    if ($statusFilter == 'diproses') {
        $pelanggaran = $conn->query("SELECT * FROM tb_kelolatatib WHERE status_id = 2")->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($statusFilter == 'selesai') {
        $pelanggaran = $conn->query("SELECT * FROM tb_kelolatatib WHERE status_id = 3")->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $pelanggaran = $conn->query("SELECT * FROM tb_kelolatatib")->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Query untuk menghitung jumlah pelanggaran berdasarkan status
    $totalPelanggaran = $conn->query("SELECT COUNT(*) AS total FROM tb_kelolatatib")->fetch(PDO::FETCH_ASSOC);
$diprosesPelanggaran = $conn->query("SELECT COUNT(*) AS total FROM tb_kelolatatib WHERE status_id = 2")->fetch(PDO::FETCH_ASSOC);
$selesaiPelanggaran = $conn->query("SELECT COUNT(*) AS total FROM tb_kelolatatib WHERE status_id = 3")->fetch(PDO::FETCH_ASSOC);


    // Mengambil jumlah pelanggaran untuk setiap kategori
    $totalCount = $totalPelanggaran['total'];
    $diprosesCount = $diprosesPelanggaran['total'];
    $selesaiCount = $selesaiPelanggaran['total'];
    
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Dummy data untuk sesi pengguna (Ganti dengan data aktual dari database)
$user = [
    'name' => 'My Babby Findia',
    'nim' => '2341760007',
    'angkatan' => 2023,
    'email' => 'Mybabyfind@gmail.com',
    'kota_lahir' => 'Malang',
    'jenis_kelamin' => 'Perempuan',
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Tata Tertib JTI</title>
    <link rel="stylesheet" href="mhs.css"> <!-- Memasukkan file CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="profile-section">
            <p class="anukrama-label">ANUKRAMA</p>
            <img src="images/profile.jpg" alt="Profile Picture" class="profile-picture" id="profile-trigger">
            <p class="profile-name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <nav class="menu">
            <ul>
                <li class="active">
                    <a href="?page=dashboard">
                        <i class="bi bi-house-door"></i> Dashboard TATIB
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <h1>Hi <?= htmlspecialchars($user['name']) ?></h1>
        <p>Selamat Datang di Dashboard Mahasiswa</p>
        <div class="info-container">
    <div class="info-card info-red" onclick="window.location.href='?status=all'">
        <h5>Total Pelanggaran</h5>
        <p><?= $totalCount ?> Pelanggaran</p>
    </div>
    <div class="info-card info-orange" onclick="window.location.href='?status=diproses'">
        <h5>Pelanggaran Diproses</h5>
        <p><?= $diprosesCount ?> Pelanggaran</p>
    </div>
    <div class="info-card info-green" onclick="window.location.href='?status=selesai'">
        <h5>Pelanggaran Selesai</h5>
        <p><?= $selesaiCount ?> Pelanggaran</p>
    </div>
</div>

<div class="table-container">
    <table class="table table-hover">
        <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 2;">
            <tr>
                <th>No.</th>
                <th>Pelanggaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($pelanggaran as $data): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['pelanggaran'] ?? '') ?></td>
                    <td class="text-center">
                        <?php
                        if ($data['pengumpulan'] === NULL) {
                            echo "<span class='badge bg-danger'>Belum Selesai</span>";
                        } elseif ($data['status_id'] == 3) { 
                            echo "<span class='badge bg-success'>Selesai</span>";
                        } else {
                            echo "<span class='badge bg-warning'>Diproses</span>";
                        }
                        ?>
                    </td>
                    <td class="text-center align-middle">
                        <a href="detail.php?id=<?= $data['id_tatib'] ?>" class="btn-three-dots">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    </main>

    <script src="main.js"></script>
</body>
</html>
