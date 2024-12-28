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

    // Query untuk mengambil data dari tabel tb_kelolatatib
    $sql = "SELECT id_tatib, nim, nama_mahasiswa, kelas, pelanggaran, tingkat, kompensasi, tenggat, pengumpulan, nama_file, status_id 
        FROM tb_kelolatatib";

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
    <title>Notifikasi Mahasiswa</title>
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
                                <li><a href="notifikasimahasiswa.php">Notifikasi dari Mahasiswa</a></li>
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
                <h2>Laporan Pelanggaran Mahasiswa</h2>
                <div class="table-wrapper">
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Nama Mahasiswa</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center small-col">Pelanggaran</th>
                                <th class="text-center small-col-tingkat">Tingkat</th>
                                <th class="text-center breakable-col">Kompensasi</th>
                                <th class="text-center">Tenggat</th>
                                <th class="text-center small-col">Pengumpulan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; 
                            foreach ($laporan as $row) {
                                $isFileAvailable = !empty($row['nama_file']);
                                $disableAttr = $isFileAvailable ? '' : 'disabled';
                                $btnSuccessClass = $isFileAvailable ? 'btn-success' : 'btn-secondary';
                                $btnDangerClass = $isFileAvailable ? 'btn-danger' : 'btn-secondary';

                                echo "<tr>";
                                echo "<td>" . $no . "</td>";
                                echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_mahasiswa']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                                echo "<td class='small-col'>" . htmlspecialchars($row['pelanggaran']) . "</td>"; 
                                echo "<td class='small-col-tingkat'>" . htmlspecialchars($row['tingkat']) . "</td>"; 
                                echo "<td class='breakable-col'>" . htmlspecialchars($row['kompensasi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tenggat']) . "</td>";

                                if ($isFileAvailable) {
                                    echo "<td class='small-col text-center'><a href='download.php?id_tatib=" . $row['id_tatib'] . "' target='_blank'>" . htmlspecialchars($row['nama_file']) . "</a></td>"; 
                                } else {
                                    echo "<td class='small-col text-center'>Tidak Ada</td>";
                                }

                                echo "<td class='text-center'>";
                                echo "<div class='d-inline'>";
                                if ($row['status_id'] == 3) {
                                    echo "<button class='border-0 bg-transparent' disabled><i class='bi bi-check-circle-fill text-secondary'></i></button>";
                                    echo " ";
                                    echo "<button class='border-0 bg-transparent' disabled><i class='bi bi-x-circle-fill text-secondary'></i></button>";
                                } else {
                                    if ($isFileAvailable) {
                                        echo "<button id='accept-btn-" . $row['id_tatib'] . "' class='border-0 bg-transparent' onclick='handleAccept(\"" . htmlspecialchars($row['nim']) . "\", " . $row['id_tatib'] . ")'><i class='bi bi-check-circle-fill text-success'></i></button>";
                                        echo " ";
                                        echo "<button id='reject-btn-" . $row['id_tatib'] . "' class='border-0 bg-transparent' onclick='handleReject(\"" . htmlspecialchars($row['nim']) . "\", " . $row['id_tatib'] . ")'><i class='bi bi-x-circle-fill text-danger'></i></button>";
                                    } else {
                                        echo "<button class='border-0 bg-transparent' disabled><i class='bi bi-check-circle-fill text-secondary'></i></button>";
                                        echo " ";
                                        echo "<button class='border-0 bg-transparent' disabled><i class='bi bi-x-circle-fill text-secondary'></i></button>";
                                    }
                                }
                                echo "</div>";
                                echo "</td>";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function markRowAsClicked(row) {
            const buttons = row.querySelectorAll('button');
            buttons.forEach(button => {
                button.classList.add('disabled');
                button.setAttribute('disabled', true);
            });
        }

        function handleAccept(nim, idTatib) {
            fetch('updatestatusmahasiswa.php', {
                method: 'POST',
                body: JSON.stringify({
                    nim: nim,
                    id_tatib: idTatib,
                    action: 'accept'
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.status === 'success') {
                      const row = document.querySelector(`#accept-btn-${idTatib}`).closest('tr');
                      markRowAsClicked(row);
                  } else {
                      console.error('Terjadi kesalahan.');
                  }
              });
        }

        function handleReject(nim, idTatib) {
            const reason = prompt('Masukkan alasan penolakan:');
            if (reason) {
                fetch('updatestatusmahasiswa.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        nim: nim,
                        id_tatib: idTatib,
                        action: 'reject',
                        reason: reason
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.status === 'success') {
                          const row = document.querySelector(`#reject-btn-${idTatib}`).closest('tr');
                          markRowAsClicked(row);
                          alert('Penolakan berhasil disimpan.');
                      } else {
                          console.error('Terjadi kesalahan: ', data.message);
                      }
                  }).catch(error => {
                      console.error('Error:', error);
                  });
            }
        }
    </script>
</body>
</html>
