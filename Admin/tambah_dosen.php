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
    $nip = $_POST['nip'];
    $nama_dosen = $_POST['nama_dosen'];
    $jabatan_fungsional = $_POST['jabatan_fungsional'];
    $status = $_POST['status'];

    // Query untuk menyimpan data dosen
    $sql = "INSERT INTO tb_dosen (nip, nama_dosen, jabatan_fungsional, status) 
            VALUES (:nip, :nama_dosen, :jabatan_fungsional, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nip', $nip);
    $stmt->bindParam(':nama_dosen', $nama_dosen);
    $stmt->bindParam(':jabatan_fungsional', $jabatan_fungsional);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        // Redirect langsung ke halaman tabeldosen.php tanpa notifikasi
        header("Location: tabeldosen.php");
        exit();
    } else {
        // Jika terjadi kesalahan, kembali ke halaman form
        header("Location: tambah_dosen.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_beranda.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Menambahkan background pada halaman */
        body {
            background-color: #f4f6f9;
            /* Warna latar belakang seluruh halaman */
        }

        /* Styling form dengan background */
        .form-container {
            background-color: #ffffff;
            /* Warna latar belakang putih */
            padding: 40px;
            border-radius: 10px;
            /* Membuat sudut form melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Efek bayangan */
            margin: 0 auto;
            /* Menempatkan form di tengah halaman */
        }

        /* Gaya tombol */
        .btn-primary {
            background-color: #007bff;
            /* Warna tombol */
            border-color: #007bff;
            /* Border tombol */
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        /* Gaya untuk judul halaman */
        h2 {
            color: #333333;
        }

       /* Menjaga form agar selebar dengan kolom kartu */
.form-container {
    width: 100%; /* Menambahkan lebar 100% agar sesuai dengan lebar konten lainnya */
    margin: 0 auto;
}

/* Menyamakan gaya antara input dan select */
.form-container .form-control, 
.form-container .form-select {
    width: 100%; /* Lebar penuh */
    box-sizing: border-box; /* Memastikan padding tidak menambah lebar */
    padding: 6px 12px; /* Padding seragam */
    font-size: 14px; /* Ukuran font seragam */
    border: 1px solid #ced4da; /* Border */
    border-radius: 5px; /* Sudut melengkung */
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

                <div class="container mt-5">
    <div class="form-container">
        <h2>Tambah Dosen</h2>
        <form action="tambah_dosen.php" method="POST">
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" required>
            </div>
            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Dosen</label>
                <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_fungsional" class="form-label">Jabatan Fungsional</label>
                <input type="text" class="form-control" id="jabatan_fungsional" name="jabatan_fungsional" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="tabeldosen.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>




            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
