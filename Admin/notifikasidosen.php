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

    // Query untuk mengambil data pelanggaran dari dosen dan status
    $sql = "SELECT nim, nama_mahasiswa, kelas_mahasiswa, nama_pelanggaran, deskripsi_pelanggaran, status_id
            FROM tb_laporan_pelanggaran_dosen"; // Ganti dengan nama tabel Anda
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $laporan = $stmt->fetchAll(); // Mengambil semua data laporan
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi dari Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style_beranda.css">
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
    <h2>Laporan Pelanggaran Dosen</h2>

    <div class="table-wrapper" style="max-height: 550px; overflow-y: auto;">
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Kelas</th>
                    <th>Nama Pelanggaran</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; // Variabel untuk nomor urut
                foreach ($laporan as $row) {
                    // Cek apakah status sudah 'Accepted' (status_id = 2)
                    $buttonClass = $row['status_id'] == 2 ? 'btn-secondary' : 'btn-success';
                    $buttonText = $row['status_id'] == 2 ? 'Accepted' : 'Accept';
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kelas_mahasiswa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pelanggaran']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deskripsi_pelanggaran']) . "</td>";
                    echo "<td><button id='accept-btn-" . $no . "' class='btn $buttonClass btn-sm' onclick='changeButtonColor(" . $no . ", \"" . htmlspecialchars($row['nim']) . "\")'>$buttonText</button></td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <a href="beranda.php" class="btn btn-secondary mt-3">Kembali</a>
</div>

        </div>
    </div>

    <script>
function changeButtonColor(rowNumber, nim) {
    const button = document.getElementById('accept-btn-' + rowNumber);

    // Cek apakah tombol sudah dalam status 'Accepted'
    if (button.textContent === 'Accepted') {
        return; // Jika sudah 'Accepted', hentikan eksekusi
    }

    // Kirim permintaan AJAX untuk memperbarui status
    fetch('updatestatus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ nim: nim })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Ubah warna tombol menjadi abu-abu dan nonaktifkan
            button.style.backgroundColor = '#acc3cc'; // Warna abu-abu (Bootstrap secondary)
            button.style.borderColor = '#acc3cc';
            button.textContent = 'Accepted'; // Ubah teks tombol
            button.disabled = true; // Nonaktifkan tombol
        } else {
            console.error('Gagal memperbarui status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


</script>

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
