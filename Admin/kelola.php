<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    $conn = new PDO("sqlsrv:Server=BEBI\\DBMS22;Database=PBL", "", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";

    // Query untuk mengambil data biodata mahasiswa
    $sql = "SELECT id_tatib, nim, nama_mahasiswa, kelas, pelanggaran, tingkat FROM tb_kelolatatib";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $mahasiswa = $stmt->fetchAll();
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
        // JavaScript function to add a row to the table
        function addRow() {
            var table = document.getElementById("violationTable");
            var row = table.insertRow(-1); // Insert row at the end of the table
            // Create new cells
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);

            // Set default values for new row cells
            cell1.innerHTML = table.rows.length; // Row number
            cell2.innerHTML = "New NIM"; // Placeholder for NIM
            cell3.innerHTML = "New Academic Year"; // Placeholder for Academic Year
            cell4.innerHTML = "New Name"; // Placeholder for Name
            cell5.innerHTML = "New Class"; // Placeholder for Class
            cell6.innerHTML = "New Violation"; // Placeholder for Violation
            cell7.innerHTML = "New Level"; // Placeholder for Level
            cell8.innerHTML = `<a href="#" class="text-primary me-2" title="Edit"><i class="bi bi-pencil-square"></i></a>
                         <a href="#" class="text-danger" title="Hapus"><i class="bi bi-trash"></i></a>`; // Placeholder for Actions
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
                        <a href="#" class="nav-link">
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
                <h2>Kelola Tata Tertib</h2>
                <p>Tambahkan, edit, atau hapus aturan tata tertib di bawah ini:</p>

                <!-- Button to Add Row -->
                <a href="kelolaedit.php" class="btn btn-success mb-3">
                    Tambah Pelanggaran
                </a>

                <!-- Violation Table -->
                <div class="table-responsive mt-4" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered" id="violationTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Kelas</th>
                <th>Pelanggaran</th>
                <th>Tingkat </th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mahasiswa as $index => $data): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($data['nim']) ?></td>
                    <td><?= htmlspecialchars($data['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($data['kelas']) ?></td>
                    <td><?= htmlspecialchars($data['pelanggaran']) ?></td>
                    <td><?= htmlspecialchars($data['tingkat']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $data['id_tatib'] ?>" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
                        <a href="delete.php?id=<?= $data['id_tatib'] ?>" class="text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
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