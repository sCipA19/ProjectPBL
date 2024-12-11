<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TATIB - ANUKRAMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #e6f7f9, #b8d7f1);
        }
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h4 {
            color: #2d5a89;
            font-weight: bold;
            text-align: center;
        }
        .sidebar .profile img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: block;
            margin: 10px auto;
        }
        .sidebar .profile h5 {
            text-align: center;
            font-weight: bold;
        }
        .sidebar .nav-link {
            font-size: 16px;
            color: #333;
            margin: 5px 0;
        }
        .sidebar .nav-link.active {
            background-color: #2d5a89;
            color: white;
            border-radius: 5px;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4>ANUKRAMA</h4>
                <div class="profile">
                    <img src="image/Dosen2.jpg" alt="Profile Picture">
                    <h5>PURNOMO SUJARWO S.Pd S.Ag</h5>
                </div>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i> Dashboard TATIB
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-clipboard-list"></i> Laporkan Pelanggaran
                    </a>
                    <a href="#" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <h1 class="fw-bold">Selamat Datang</h1>
                <p>di sistem Anukrama. Pilih menu di sidebar untuk mulai laporkan pelanggaran, dan notifikasi.</p>
                
                <!-- Tabel Pelanggaran -->
                <div class="table-container mt-4">
                    <table class="table table-bordered">
                        <thead class="table-primary">
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
                            $data = [
                                ['nim' => '2341760007', 'nama' => 'Rizky Roza Rahim', 'kelas' => 'SIB -2B', 'pelanggaran' => 'Tidak memakai seragam', 'tingkat' => 'I', 'status' => 'Proses'],
                                ['nim' => '2341760007', 'nama' => 'Syifa Revalina', 'kelas' => 'SIB -2B', 'pelanggaran' => 'Merokok di area kampus', 'tingkat' => 'III', 'status' => 'Proses'],
                                ['nim' => '2341760007', 'nama' => 'My Babby Findia', 'kelas' => 'SIB -2B', 'pelanggaran' => 'Mabuk di dalam kelas', 'tingkat' => 'IV', 'status' => 'Selesai'],
                            ];
                            foreach ($data as $index => $row) {
                                echo "<tr>";
                                echo "<td>" . ($index + 1) . "</td>";
                                echo "<td>" . $row['nim'] . "</td>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $row['kelas'] . "</td>";
                                echo "<td>" . $row['pelanggaran'] . "</td>";
                                echo "<td>" . $row['tingkat'] . "</td>";
                                echo "<td>";
                                echo $row['status'] === 'Proses' 
                                    ? "<span class='badge badge-danger'>Proses</span>" 
                                    : "<span class='badge badge-success'>Selesai</span>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
