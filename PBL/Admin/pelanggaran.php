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

    // Query untuk mengambil data dari tb_kelolatatib
    $sql = "SELECT * FROM tb_kelolatatib";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tatib = $stmt->fetchAll(); // Mengambil semua data dari tabel
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
    <h2>Data Tata Tertib</h2>
    <p>Berikut adalah data tata tertib yang dikelola:</p>

    <!-- Tabel Tata Tertib -->
    <h4>Tata Tertib</h4>
    <div class="table-wrapper" style="max-height: 550px; overflow-y: auto;">
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
                foreach ($tatib as $row) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['pelanggaran']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tingkat']) . "</td>";

                    // Menentukan status berdasarkan status_id
                    if ($row['status_id'] == 3) {
                        $status = "<span class='badge bg-success'>Selesai</span>";
                    } elseif ($row['tingkat'] === 'Rendah') {
                        $status = "<span class='badge bg-success'>Selesai</span>";
                    } elseif ($row['tingkat'] === 'Sedang') {
                        $status = "<span class='badge bg-warning'>Proses</span>";
                    } else {
                        $status = "<span class='badge bg-danger'>Belum Selesai</span>";
                    }

                    echo "<td>" . $status . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    </div>

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
