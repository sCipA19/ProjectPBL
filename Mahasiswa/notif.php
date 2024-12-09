<?php
// Data notifikasi
$notifications = [
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => '17.00 Sent', 'class' => 'sent'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => 'Yesterday Sent', 'class' => 'sent'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => '10/20/25 Failed', 'class' => 'failed'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => 'Yesterday Failed', 'class' => 'failed'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => '12.51 Sent', 'class' => 'sent'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => 'Monday Sent', 'class' => 'sent'],
    ['name' => 'Bambang Siswanto', 'date' => 'Pelanggaran Mahasiswa pada tanggal 10/23/43', 'status' => 'Wednesday Sent', 'class' => 'sent'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="header">Notifikasi</div>
    <div class="notif-list">
        <?php foreach ($notifications as $notif): ?>
        <div class="notif">
            <div class="notif-content">
                <div class="name"><?= htmlspecialchars($notif['name']) ?></div>
                <div class="date"><?= htmlspecialchars($notif['date']) ?></div>
            </div>
            <div class="status <?= htmlspecialchars($notif['class']) ?>">
                <?= htmlspecialchars($notif['status']) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
