<?php
// Data pengguna (dapat diambil dari database atau API)
$user = [
    'name' => 'My Babby Findia',
    'nim' => '2341760007',
    'angkatan' => 2023,
    'email' => 'Mybabyfind@gmail.com',
    'kota_lahir' => 'Malang',
    'jenis_kelamin' => 'Perempuan',
];

// Handle navigasi halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Tata Tertib JTI</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 20%;
            background-color: #DEE5D4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .profile-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-picture {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .profile-name {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.1em;
            font-weight: bold;
        }
        .menu ul {
            list-style: none;
            padding: 0;
        }
        .menu li {
            display: flex;
            align-items: center;
            padding: 10px 0;
            cursor: pointer;
            color: #000;
        }
        .menu li.active {
            font-weight: bold;
            color: #007bff;
        }
        .menu i {
            margin-right: 10px;
        }
        /* Main content */
        .main-content {
            width: 80%;
            padding: 20px;
            background: linear-gradient(to bottom, #DFF2EB, #4A628A);
            overflow-y: auto;
            position: relative;
        }
        /* Table */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4A628A;
            color: white;
        }
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .popup h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .popup p {
            margin: 10px 0;
        }

        .popup .close {
            margin-top: 15px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup .close:hover {
            background-color: #0056b3;
        }
    </style>
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
        <!-- Dynamic Content -->
        <?php if ($page == 'dashboard'): ?>
            <h1>Dashboard TATIB</h1>
            <p>Selamat datang di Sistem Informasi Tata Tertib JTI.</p>
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
                <tr>
                    <td>1</td>
                    <td>28 November 2024</td>
                    <td>SIB-2B</td>
                    <td>Tidak memakai seragam</td>
                    <td>I</td>
                    <td>Proses</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>01 Desember 2024</td>
                    <td>SIB-2B</td>
                    <td>Merokok di area kampus</td>
                    <td>III</td>
                    <td>Proses</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>06 Desember 2024</td>
                    <td>SIB-2B</td>
                    <td>Mabuk di dalam kelas</td>
                    <td>IV</td>
                    <td>Proses</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>25 Agustus 2023</td>
                    <td>SIB-1A</td>
                    <td>Tidak memakai seragam</td>
                    <td>I</td>
                    <td>Selesai</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>05 Desember 2023</td>
                    <td>SIB-1A</td>
                    <td>Merokok di area kampus</td>
                    <td>II</td>
                    <td>Selesai</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>16 Desember 2024</td>
                    <td>SIB-1A</td>
                    <td>Mabuk di dalam kelas</td>
                    <td>I</td>
                    <td>Selesai</td>
                </tr>
            </table>
        <?php endif; ?>
    </main>

    <!-- Profile Popup -->
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
