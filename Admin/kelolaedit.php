<?php
session_start();

require '../koneksi/kon.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server Anda
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Koneksi ke database
    $conn = new PDO("sqlsrv:Server=BEBI\\DBMS22;Database=PBL", "", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ambil data dari form
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $nim = $_POST['nim'];
        $kelas = $_POST['kelas'];
        $pelanggaran = $_POST['pelanggaran'];
        $tingkat = $_POST['tingkat'];
        $bukti = null;

        // Proses upload file (jika ada)
        if (!empty($_FILES['bukti']['name'])) {
            $targetDir = "uploads/"; // Folder untuk menyimpan file
            $bukti = $targetDir . basename($_FILES['bukti']['name']);
            move_uploaded_file($_FILES['bukti']['tmp_name'], $bukti);
        }

  // Insert data ke database
$sqlInsert = "INSERT INTO tb_kelolatatib (nim, tahun_ajaran, nama_mahasiswa, kelas, pelanggaran, tingkat, bukti) 
VALUES (:nim, :tahun_ajaran, :nama_mahasiswa, :kelas, :pelanggaran, :tingkat, :bukti)";
$stmt = $conn->prepare($sqlInsert);
$stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
$stmt->bindParam(':nim', $nim);
$stmt->bindParam(':kelas', $kelas);
$stmt->bindParam(':pelanggaran', $pelanggaran);
$stmt->bindParam(':tingkat', $tingkat);
$stmt->bindParam(':bukti', $bukti);

if ($stmt->execute()) {
// Redirect ke halaman kelola.php setelah berhasil menyimpan
echo "<script>alert('Data berhasil ditambahkan!');</script>";
header("Location: kelola.php");
exit();
} else {
echo "<script>alert('Gagal menambahkan data!');</script>";
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

            // Create a new card element
            const card = document.createElement("div");
            card.className = "card mb-3";
            card.innerHTML = `
        <div class="card-body">
          <p class="card-text">Nama Mahasiswa: New Name</p>
          <p class="card-text">NIM: New NIM</p>
          <p class="card-text">Kelas: New Class</p>
          <p class="card-text">Pelanggaran: New Violation</p>
          <p class="card-text">Tingkat Pelanggaran: New Level</p>
          <p class="card-text">Tahun Ajaran: New Academic Year</p>
          <div>
            <label for="fileUpload" class="form-label">Upload Bukti Pelanggaran:</label>
            <input type="file" class="form-control mb-3" id="fileUpload">
            <a href="#" class="btn btn-primary btn-sm me-2" title="Edit"><i class="bi bi-pencil-square"></i> Edit</a>
            <a href="#" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i> Hapus</a>
          </div>
        </div>
      `;

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
                <h2>Kelola Tata Tertib</h2>
                <p>Tambahkan, edit, atau hapus aturan tata tertib di bawah ini:</p>

                <!-- Button to Add Card -->
                <a href="kelola.php" class="btn btn-success mb-3">
                    Tambah Pelanggaran
                </a>


                <!-- Card Container -->
                <div id="cardContainer">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Inputan untuk Nama Mahasiswa -->
                            <div class="mb-3">
                                <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="namaMahasiswa"
                                    placeholder="Masukkan Nama Mahasiswa">
                            </div>

                            <!-- Inputan untuk NIM -->
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM">
                            </div>

                            <!-- Inputan untuk Kelas -->
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" placeholder="Masukkan Kelas">
                            </div>

                            <!-- Inputan untuk Pelanggaran -->
                            <div class="mb-3">
                                <label for="pelanggaran" class="form-label">Pelanggaran</label>
                                <input type="text" class="form-control" id="pelanggaran"
                                    placeholder="Masukkan Pelanggaran">
                            </div>

                            <!-- Inputan untuk Tingkat Pelanggaran -->
                            <div class="mb-3">
                                <label for="tingkatPelanggaran" class="form-label">Tingkat Pelanggaran</label>
                                <input type="text" class="form-control" id="tingkatPelanggaran"
                                    placeholder="Masukkan Tingkat Pelanggaran">
                            </div>
                            <!-- Upload Bukti Pelanggaran -->
                            <div class="mb-3">
                                <label for="fileUpload" class="form-label">Upload Bukti Pelanggaran</label>
                                <input type="file" class="form-control" id="fileUpload">
                            </div>

                            <!-- Button Edit dan Hapus -->
                            <div>
                                <a href="#" class="btn btn-primary btn-sm me-2" title="Edit"><i
                                        class="bi bi-pencil-square"></i> Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i>
                                    Hapus</a>
                            </div>
                        </div>
                    </div>

                    <script
                        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>