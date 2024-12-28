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

    // Debugging: Pastikan ID diterima
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_tatib = (int) $_GET['id']; // Mengonversi ke integer untuk validasi
        $sql = "SELECT * FROM tb_kelolatatib WHERE id_tatib = :id_tatib";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_tatib', $id_tatib, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            die("Data pelanggaran tidak ditemukan.");
        }
    } else {
        die("ID pelanggaran tidak valid.");
    }

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

// Memproses file yang diunggah dan mengarahkan kembali ke dashboard
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Memproses file yang diunggah
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['file_upload'];
        $fileName = basename($file["name"]);
        $targetDir = "uploads/"; // Direktori penyimpanan file sementara
        $targetFile = $targetDir . $fileName;
        $uploadOk = 1;

        // Cek apakah file sudah pernah di-upload di database untuk ID_tatib yang berbeda
        $checkFileSQL = "SELECT COUNT(*) FROM tb_kelolatatib WHERE nama_file = :nama_file AND id_tatib != :id_tatib";
        $checkFileStmt = $conn->prepare($checkFileSQL);
        $checkFileStmt->bindParam(':nama_file', $fileName, PDO::PARAM_STR);
        $checkFileStmt->bindParam(':id_tatib', $id_tatib, PDO::PARAM_INT); // Menggunakan ID_tatib saat ini
        $checkFileStmt->execute();
        $fileCount = $checkFileStmt->fetchColumn();

        if ($fileCount > 0) {
            echo "File dengan nama yang sama sudah pernah di-upload di entri lain. Silakan pilih file lain atau upload lagi file yang sama untuk entri ini.<br>";
        }

        // Debugging: Menampilkan informasi file yang di-upload
        echo "Nama file: " . $file["name"] . "<br>";
        echo "Ukuran file: " . $file["size"] . " bytes<br>";
        echo "Tipe file: " . $file["type"] . "<br>";

        // Cek ukuran file (maksimum 5MB)
        if ($file["size"] > 5000000) {
            echo "Ukuran file terlalu besar.<br>";
            $uploadOk = 0;
        }

        // Jika semuanya OK, maka upload file
        if ($uploadOk == 0) {
            echo "File tidak dapat di-upload.<br>";
        } else {
            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                echo "File berhasil dipindahkan ke direktori.<br>";

                // Membaca file yang di-upload untuk disimpan ke database
                $fileData = file_get_contents($file["tmp_name"]); // Membaca konten file

                // Update kolom pengumpulan di dalam database dengan file yang di-upload
               // Update kolom pengumpulan dan status
$updateSQL = "UPDATE tb_kelolatatib 
SET pengumpulan = :pengumpulan, 
    nama_file = :nama_file, 
    tipe_file = :tipe_file,
    status_id = 2  -- Mengubah status menjadi 'Diproses' setelah file diupload
WHERE id_tatib = :id_tatib AND pengumpulan IS NULL";  // Menambahkan kondisi agar hanya update jika NULL

  
                $updateStmt = $conn->prepare($updateSQL);
                $updateStmt->bindParam(':pengumpulan', $fileData, PDO::PARAM_LOB); // Menyimpan file biner
                $updateStmt->bindParam(':nama_file', $fileName, PDO::PARAM_STR);  // Nama file
                $updateStmt->bindParam(':tipe_file', $file["type"], PDO::PARAM_STR); // Tipe file (MIME type)
                $updateStmt->bindParam(':id_tatib', $id_tatib, PDO::PARAM_INT);

                // Eksekusi query update
                if ($updateStmt->execute()) {
                    echo "File berhasil disimpan dalam database dan status diperbarui ke 'Proses'.<br>";
                } else {
                    echo "Gagal menyimpan file dalam database. Error: " . implode(", ", $updateStmt->errorInfo()) . "<br>";
                }

                // Menyimpan nama file ke dalam session
                $_SESSION['uploaded_file_name'] = $file["name"]; // Menyimpan nama file yang diupload ke session
            } else {
                echo "Terjadi kesalahan saat meng-upload file.<br>";
            }
        }
    } else {
        echo "Tidak ada file yang di-upload atau terjadi kesalahan.<br>";
    }

    // Setelah file diproses, arahkan pengguna kembali ke dashboard
    header("Location: index.php"); // Mengarahkan ke dashboard
    exit();
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggaran - Sistem Informasi Tata Tertib JTI</title>
    <link rel="stylesheet" href="mhs.css"> <!-- Memasukkan file CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Perbaikan CSS agar input file bisa diklik */
        input[type="file"] {
            position: relative;
            z-index: 10;
            cursor: pointer;
        }

        .sidebar,
        .main-content {
            margin: 0;
            padding: 0;
        }
    </style>
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
                <li>
                    <a href="index.php"> <!-- Ubah URL di sini -->
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
        <h4 class="text-center">Detail Pelanggaran</h4>
        <div class="table-container">
            <table class="table table-bordered table-hover detail-table">
                <thead>
                    <tr>
                        <th class="center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-detail">
                            <div class="detail-container">
                                <div class="detail-item">
                                    <div class="label">Pelanggaran</div><span class="colon">:</span>
                                    <span><?= htmlspecialchars($data['pelanggaran']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Kelas</div><span class="colon">:</span>
                                    <span><?= htmlspecialchars($data['kelas']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Tingkat Pelanggaran</div><span class="colon">:</span>
                                    <span><?= htmlspecialchars($data['tingkat']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Kompensasi</div><span class="colon">:</span>
                                    <span><?= htmlspecialchars($data['kompensasi']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Tenggat Waktu</div><span class="colon">:</span>
                                    <span><?= htmlspecialchars($data['tenggat']) ?></span>
                                </div>

                                <!-- Form untuk pengumpulan file -->
                                <form method="post" enctype="multipart/form-data" onsubmit="return validateFileUpload()">
    <div class="detail-item mt-4">
        <div class="label">Pengumpulan File</div><span class="colon">:</span>
        <div class="file-upload-container" style="display: flex; align-items: center;">
            <!-- Menampilkan input file -->
            <input type="file" name="file_upload" id="file_upload" class="form-control" style="flex-grow: 1;">

            <i class="bi bi-x-circle file-cancel-icon" id="file_cancel_icon" 
                style="display: none; cursor: pointer; margin-left: 10px;"></i>
        </div>
    </div>

                                    <script>
                                        // Menangani perubahan file
                                        document.getElementById('file_upload').addEventListener('change', function () {
                                            var cancelIcon = document.getElementById('file_cancel_icon');
                                            console.log("File selected: ", this.files); // Tambahkan log untuk melihat apakah file terdeteksi
                                            if (this.files.length > 0) {
                                                cancelIcon.style.display = 'inline-block'; // Tampilkan ikon silang
                                            } else {
                                                cancelIcon.style.display = 'none'; // Sembunyikan ikon silang jika tidak ada file
                                            }
                                        });

                                        // Menangani pembatalan pemilihan file
                                        document.getElementById('file_cancel_icon').addEventListener('click', function () {
                                            var fileInput = document.getElementById('file_upload');
                                            fileInput.value = ''; // Menghapus nilai input file
                                            this.style.display = 'none'; // Sembunyikan ikon silang
                                        });

                                        // Fungsi untuk validasi file upload
                                        function validateFileUpload() {
                                            var fileInput = document.getElementById('file_upload');
                                            if (fileInput.files.length === 0) {
                                                alert("Harap pilih file terlebih dahulu sebelum meng-upload.");
                                                return false; // Mencegah pengiriman form jika file tidak dipilih
                                            }
                                            return true; // Melanjutkan pengiriman form jika file dipilih
                                        }
                                    </script>

<div class="text-left mt-4 d-flex ms-4">
    <a href="index.php" class="btn btn-secondary me-2">Kembali ke Dashboard</a>
    <button type="submit" class="btn btn-success">Upload File</button>
</div>




                                </form>
                                <!-- Menampilkan pesan dari database -->
<?php if (!empty($data['pesan'])): ?>
    <div class="alert alert-warning mt-3">
        <strong>Pesan:</strong> <?= htmlspecialchars($data['pesan']); ?>
    </div>
<?php endif; ?>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script src="main.js"></script>
</body>

</html>