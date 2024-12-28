<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TATIB - ANUKRAMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #e6f7f9, #577eae);
            height: 100vh;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar h4 {
            text-align: center;
            color: #2d5a89;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .sidebar img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            margin: auto;
            display: block;
            cursor: pointer; /* Menambahkan pointer untuk menandakan elemen dapat diklik */
        }
        .nav-link {
            color: #333;
            font-size: 16px;
        }
        .nav-link.active {
            background-color: #2d5a89;
            color: white;
            border-radius: 5px;
        }
        .nav-link i {
            margin-right: 10px;
        }
        .content {
            padding: 30px;
        }
        .welcome-card {
            background-color: #2d5a89;
            color: white;
            border-radius: 8px;
        }
        .welcome-card button {
            background-color: white;
            color: #2d5a89;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
        }
        .welcome-card button:hover {
            background-color: #dde1e6;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h4>ANUKRAMA</h4>
                <div class="text-center mb-4">
                    <img src="image/Dosen2.jpg" alt="Foto Profil" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <h5 class="mt-2">Suprapto</h5>
                </div>
                <nav class="nav flex-column px-3">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-home"></i> Dashboard TATIB
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-clipboard-list"></i> Laporkan Pelanggaran
                    </a>
                    <a class="nav-link text-danger" href="#">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 content">
                <h1 class="fw-bold">Selamat datang</h1>
                <p>Kelola laporan pelanggaran dan akses tata tertib</p>

                <div class="row mt-4">
                    <div class="col-md-5 welcome-card p-4">
                        <h4>Akses Tata Tertib</h4>
                        <p>Lihat semua peraturan yang berlaku</p>
                        <button onclick="window.location.href='#'">Lihat Tata Tertib</button>
                    </div>
                    <div class="col-md-5 offset-md-1 welcome-card p-4">
                        <h4>Laporkan Pelanggaran</h4>
                        <p>Kirim laporan pelanggaran mahasiswa kepada admin</p>
                        <button onclick="window.location.href='#'">Lapor Pelanggaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Profile -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="image/Dosen2.jpg" alt="Foto Profil" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h5>PURNOMO SUJARWO S.Pd S.Ag</h5>
                        <p class="text-muted">PEMOGRAMAN WEB</p>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>: Purnomo Sujarwo S.Pd S.Ag</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>: 231786382908638</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: purnomo123jsr@gmail.com</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: Jl. Surabaya Blok A12 No 14</td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td>: 08234-98767-2367</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>: Dosen Pembina Akademik</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary w-100">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
