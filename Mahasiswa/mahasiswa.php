<?php
$user = [
    'name' => 'My Babby Findia',
    'nim' => '2341760007',
    'angkatan' => 2023,
    'email' => 'Mybabyfind@gmail.com',
    'kota_lahir' => 'Malang',
    'jenis_kelamin' => 'Perempuan',
];

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Tata Tertib JTI</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <aside class="sidebar">
        <div class="profile-section">
            <img src="images/profile.jpg" alt="Profile Picture" class="profile-picture" id="profile-trigger">
            <p class="profile-name"><?= htmlspecialchars($user['name']) ?></p>
        </div>
        <nav class="menu">
            <ul>
                <li class="<?= $page == 'dashboard' ? 'active' : '' ?>"><a href="?page=dashboard"><i class="fas fa-home"></i>Dashboard TATIB</a></li>
                <li class="<?= $page == 'pelanggaran' ? 'active' : '' ?>"><a href="?page=pelanggaran"><i class="fas fa-list"></i>Daftar Pelanggaran</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <?php if ($page == 'dashboard'): ?>
            <h1>Hi <?= htmlspecialchars($user['name']) ?></h1>
            <p>Selamat Datang di Dashboard Mahasiswa</p>

            <button class="btn-main" onclick="location.href='?page=pelanggaran'">Daftar Pelanggaran</button>

            <div class="info-container">
                <div class="info-card info-red">
                    <h2>Total Pelanggaran Mahasiswa</h2>
                    <p>120 Pelanggaran</p>
                </div>
                <div class="info-card info-orange">
                    <h2>Pelanggaran Diproses</h2>
                    <p>120 Pelanggaran</p>
                </div>
                <div class="info-card info-green">
                    <h2>Pelanggaran Selesai</h2>
                    <p>120 Pelanggaran</p>
                </div>
            </div>
        <?php elseif ($page == 'pelanggaran'): ?>
            <h1>Daftar Pelanggaran</h1>
            <p>Daftar pelanggaran yang terdaftar di sistem:</p>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Kelas</th>
                    <th>Pelanggaran</th>
                    <th>Tingkat</th>
                    <th>Status</th>
                </tr>
            </table>
        <?php endif; ?>
    </main>

    <div class="popup" id="profile-popup">
        <div class="popup-content">
            <h2>Identitas Mahasiswa</h2>
            <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>NIM:</strong> <?= htmlspecialchars($user['nim']) ?></p>
            <p><strong>Angkatan:</strong> <?= htmlspecialchars($user['angkatan']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Kota Lahir:</strong> <?= htmlspecialchars($user['kota_lahir']) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($user['jenis_kelamin']) ?></p>
            <button class="close" id="close-popup">Tutup</button>
        </div>
    </div>
    <img src="images/message-icon.png" alt="Message Icon" class="message-icon" id="message-icon">

    <script>
        document.getElementById("profile-trigger").addEventListener("click", function() {
            document.getElementById("profile-popup").style.display = "flex";
        });

        document.getElementById("close-popup").addEventListener("click", function() {
            document.getElementById("profile-popup").style.display = "none";
        });

        document.getElementById("message-icon").addEventListener("click", function() {
            alert("Pemberitahuan baru!");
        });
    </script>
</body>
</html>

    <script>
        document.getElementById("profile-trigger").addEventListener("click", function() {
            document.getElementById("profile-popup").style.display = "flex";
        });

        document.getElementById("close-popup").addEventListener("click", function() {
            document.getElementById("profile-popup").style.display = "none";
        });
    </script>
</body>
</html>