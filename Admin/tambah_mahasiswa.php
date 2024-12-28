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

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    // Query untuk menyimpan data mahasiswa
    $sql = "INSERT INTO tb_mahasiswa (nim, nama, kelas) 
            VALUES (:nim, :nama, :kelas)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nim', $nim);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':kelas', $kelas);

    if ($stmt->execute()) {
        // Redirect langsung ke halaman tabelmahasiswa.php tanpa notifikasi
        header("Location: tabelmahasiswa.php");
        exit();
    } else {
        // Jika terjadi kesalahan, kembali ke halaman form
        header("Location: tambah_mahasiswa.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_beranda.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        h2 {
            color: #333333;
        }

        .form-container {
            width: 100%;
            margin: 0 auto;
        }

        .form-container .form-control, 
        .form-container .form-select {
            width: 100%;
            box-sizing: border-box;
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 5px;
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

                <div class="container mt-5">
                    <div class="form-container">
                        <h2>Tambah Mahasiswa</h2>
                        <form action="tambah_mahasiswa.php" method="POST">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
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
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="tabelmahasiswa.php" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
