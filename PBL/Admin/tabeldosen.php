<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server Anda
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data biodata mahasiswa
    $sql_dosen = "SELECT COUNT(*) FROM tb_dosen"; // Menghitung jumlah dosen
    $stmt_dosen = $conn->prepare($sql_dosen);
    $stmt_dosen->execute();
    $jumlah_dosen = $stmt_dosen->fetchColumn(); // Mengambil jumlah dosen

    $sql_mahasiswa = "SELECT COUNT(*) FROM tb_mahasiswa"; // Menghitung jumlah mahasiswa
    $stmt_mahasiswa = $conn->prepare($sql_mahasiswa);
    $stmt_mahasiswa->execute();
    $jumlah_mahasiswa = $stmt_mahasiswa->fetchColumn(); // Mengambil jumlah mahasiswa

    // Query untuk mengambil data biodata dosen
    $sql = "SELECT * FROM tb_dosen"; // Ganti dengan nama tabel yang sesuai
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengambil semua data mahasiswa
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
                <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai mengelola tata tertib, pelanggaran, dan notifikasi</p>

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

                <!-- Tabel Dosen -->
                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7" style="text-align: left; padding-left: 20px;">
                                    <a href="tambah_dosen.php" class="text-white" title="Tambah Dosen" style="font-size: 20px; text-decoration: none;">
                                        <i class="bi bi-person-plus" style="color: white; margin-right: 8px;"></i> Tambah Dosen
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan Fungsional</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Looping untuk menampilkan data dosen
                            $no = 1;
                            foreach ($mahasiswa as $data) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$data['nip']}</td>
                                        <td>{$data['nama_dosen']}</td>
                                        <td>{$data['jabatan_fungsional']}</td>
                                        <td>{$data['status']}</td>
                                        <td>
                                          <a href='edit_dosen.php?id_dosen={$data['id_dosen']}' class='text-primary me-2' title='Edit'><i class='bi bi-pencil-square'></i></a>
                                         <a href='hapus_dosen.php?id_dosen={$data['id_dosen']}' class='text-danger' title='Hapus'><i class='bi bi-trash'></i></a>

                                        </td>
                                    </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
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
