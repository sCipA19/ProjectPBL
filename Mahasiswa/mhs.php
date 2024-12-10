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

// Data notifikasi
$notifications = [
    ['name' => 'Bambang Siswanto', 'message' => 'Pelanggaran Mahasiswa...', 'time' => '17:00', 'status' => 'sent'],
    ['name' => 'Ani Rahmawati', 'message' => 'Harap segera hadir...', 'time' => 'Yesterday', 'status' => 'sent'],
    ['name' => 'Dimas Nugroho', 'message' => 'Tidak ada laporan hari ini.', 'time' => '10/20/25', 'status' => 'failed'],
    ['name' => 'Citra Ayu', 'message' => 'Tugas telah selesai.', 'time' => '12:51', 'status' => 'sent'],
    ['name' => 'Rizky Hidayat', 'message' => 'Ada perubahan jadwal.', 'time' => 'Monday', 'status' => 'sent'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['uploadFile'])) {
        $fileTmpName = $_FILES['uploadFile']['tmp_name'];
        $fileName = $_FILES['uploadFile']['name'];
        $fileType = $_FILES['uploadFile']['type'];
        echo 'Nama File yang Diupload: ' . $fileName;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Tata Tertib JTI</title>
    <link rel="stylesheet" href="mhs.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="profile-section">
        <img src="images/profile.jpg" alt="Profile Picture" class="profile-picture" id="profile-trigger">
        <p class="profile-name"><?= htmlspecialchars($user['name']) ?></p>
    </div>
    <nav class="menu">
        <ul>
            <li class="<?= $page == 'dashboard' ? 'active' : '' ?>"><a href="?page=dashboard">Dashboard TATIB</a></li>
            <li class="<?= $page == 'pelanggaran' ? 'active' : '' ?>"><a href="?page=pelanggaran">Daftar Pelanggaran</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">
    <?php if ($page == 'dashboard'): ?>
        <h1>Hi <?= htmlspecialchars($user['name']) ?></h1>
        <p>Selamat Datang di Dashboard Mahasiswa</p>
        <button class="btn-main" onclick="location.href='?page=pelanggaran'">Daftar Pelanggaran</button>
        <div class="info-container">
            <div class="info-card info-red">
                <h2>Total Pelanggaran</h2>
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

<!-- Popup Identitas Mahasiswa -->
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

<!-- Popup Message -->
<img src="images/message-icon.png" alt="Message Icon" class="message-icon" id="message-icon">
<div class="popup" id="message-popup">
    <div class="popup-content">
        <div class="chat-list-container" id="chatList">
            <div class="chat-list-header">Notifikasi</div>
            <div class="chat-list-body">
                <?php foreach ($notifications as $index => $notif): ?>
                <div class="chat-list-item" data-index="<?= $index ?>" data-name="<?= htmlspecialchars($notif['name']) ?>" data-message="<?= htmlspecialchars($notif['message']) ?>" data-time="<?= htmlspecialchars($notif['time']) ?>" onclick="showNotificationDetails(this)">
                    <div class="chat-item-info">
                        <span class="chat-item-name"><?= htmlspecialchars($notif['name']) ?></span>
                        <span class="chat-item-time"><?= htmlspecialchars($notif['time']) ?></span>
                    </div>
                    <div class="chat-item-message">
                        <span><?= htmlspecialchars($notif['message']) ?></span>
                        <span class="chat-item-status <?= htmlspecialchars($notif['status']) ?>"><?= ucfirst($notif['status']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="close" id="message-popup-close">Tutup</button>
    </div>
</div>

<!-- Notification Details Modal -->
<div class="notification" id="notificationDetails">
    <button class="back-button" onclick="goBack()">Kembali</button>
    <p class="header">To : -</p>
    <p class="header date">-</p>
    <div class="notification-details">
        <div class="row"><span class="label">NIM</span><span class="value">: 2341760007</span></div>
        <div class="row"><span class="label">Nama</span><span class="value">: -</span></div>
        <div class="row"><span class="label">Pelanggaran</span><span class="value">: -</span></div>
        <div class="row"><span class="label">Tingkat Pelanggaran</span><span class="value">: -</span></div>
        <div class="row"><span class="label">Kompensasi</span><span class="value">: -</span></div>
        <div class="row"><span class="label">Tenggat Waktu</span><span class="value">: -</span></div>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <span class="label">Form Pengumpulan</span><span class="colon">:</span>
                <span class="value">
                    <input type="file" id="uploadFile" name="uploadFile" class="file-input" accept="application/pdf" onchange="displayFileName();">
                    <div id="fileName"></div>
                </span>
            </div>
        </form>
    </div>
</div>

<script>
    // Menampilkan popup ketika ikon pesan diklik
    document.getElementById("message-icon").addEventListener("click", function () {
        document.getElementById("message-popup").style.display = "flex";
    });

    // Menutup popup ketika tombol "Tutup" diklik
    document.getElementById("message-popup-close").addEventListener("click", function () {
        document.getElementById("message-popup").style.display = "none";
    });

    function showNotificationDetails(element) {
        var name = element.getAttribute('data-name');
        var message = element.getAttribute('data-message');
        var time = element.getAttribute('data-time');

        document.getElementById('chatList').style.display = 'none';
        document.getElementById('notificationDetails').style.display = 'block';

        document.querySelector('.notification .header').textContent = `To : ${name}`;
        document.querySelector('.notification .header.date').textContent = time;
        document.querySelector('.notification .row .value').textContent = message;
    }

    function goBack() {
        document.getElementById('chatList').style.display = 'block';
        document.getElementById('notificationDetails').style.display = 'none';
    }
</script>

</body>
</html>
