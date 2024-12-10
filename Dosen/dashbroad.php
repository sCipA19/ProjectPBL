<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anukrama Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-users-cog"></i> ANUKRAMA</h2>
            <div class="profile-pic">
                <img src="image/Dosen.jpg" alt="Profile Picture">
            </div>
            <p class="profile-name">PURNOMO SUJARWO S.Pd S.Ag</p>
        </div>
        <ul>
            <li><a href="#" class="menu-item"><i class="fas fa-tachometer-alt"></i><span class="menu-text">Dashboard TATIB</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-flag-checkered"></i><span class="menu-text">Laporkan Pelanggaran</span></a></li>
        </ul>
        <ul class="logout">
            <li><a href="#" class="menu-item"><i class="fas fa-sign-out-alt"></i><span class="menu-text">Logout</span></a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Selamat Datang</h1>
        <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai laporkan pelanggaran, dan notifikasi.</p>
        <table>
            <tr>
                <th>No.</th>
                <th>Nama Mahasiswa</th>
                <th>Kelas</th>
                <th>Pelanggaran</th>
                <th>Tingkat</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Rizky Roza Rahim</td>
                <td>SIB - 2B</td>
                <td>Tidak memakai seragam</td>
                <td>I</td>
                <td><span class="status-proses">Proses</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Syifa Revalina</td>
                <td>SIB - 2B</td>
                <td>Merokok di area kampus</td>
                <td>III</td>
                <td><span class="status-proses">Proses</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td>My Babby Findia</td>
                <td>SIB - 2B</td>
                <td>Mabuk di dalam kelas</td>
                <td>IV</td>
                <td><span class="status-selesai">Selesai</span></td>
            </tr>
        </table>
    </div>