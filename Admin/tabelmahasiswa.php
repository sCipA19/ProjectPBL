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

    // Query untuk mengambil data mahasiswa
    $sql_mahasiswa = "SELECT * FROM tb_mahasiswa"; // Ganti dengan nama tabel mahasiswa Anda
    $stmt_mahasiswa = $conn->prepare($sql_mahasiswa);
    $stmt_mahasiswa->execute();
    $mahasiswa = $stmt_mahasiswa->fetchAll(PDO::FETCH_ASSOC);

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

    <style>
        /* Mengatur lebar kolom No dan Aksi agar lebih kecil */
        .table th,
        .table td {
            white-space: nowrap;
            /* Menghindari teks yang terlalu panjang dalam satu baris */
        }

        /* Mengatur lebar kolom No */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 50px;
            /* Lebar kolom No */
        }

        /* Mengatur lebar kolom NIM */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 100px;
            /* Lebar kolom NIM */
        }

        /* Mengatur lebar kolom Nama */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 200px;
            /* Lebar kolom Nama */
        }

        /* Mengatur lebar kolom Kelas */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 100px;
            /* Lebar kolom Kelas */
        }

        /* Mengatur lebar kolom Aksi */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 50px;
            /* Lebar kolom Aksi */
        }
    </style>

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

                <!-- Tabel Mahasiswa -->
                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5" style="text-align: left; padding-left: 20px;">
                                    <a href="tambah_mahasiswa.php" class="text-white" title="Tambah Mahasiswa"
                                        style="font-size: 20px; text-decoration: none;">
                                        <i class="bi bi-person-plus" style="color: white; margin-right: 8px;"></i>
                                        Tambah Mahasiswa
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Looping untuk menampilkan data mahasiswa
                            $no = 1;
                            foreach ($mahasiswa as $data) {
                                echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['nim']}</td>
                    <td>{$data['nama']}</td>
                    <td>{$data['kelas']}</td>
                  <td>
     <a href='edit_mahasiswa.php?id={$data['id_mahasiswa']}' class='text-primary me-2' title='Edit'><i class='bi bi-pencil-square'></i></a>
     <a href='hapus_mahasiswa.php?id_mahasiswa={$data['id_mahasiswa']}' class='text-danger' title='Hapus'><i class='bi bi-trash'></i></a>

</td>

                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
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
</body>

</html>