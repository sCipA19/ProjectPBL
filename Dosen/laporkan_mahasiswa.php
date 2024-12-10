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
            width: 110px; /* Atur ukuran lebar */
            height: 110px; /* Atur ukuran tinggi */
            object-fit: cover; /* Memastikan gambar tetap proporsional */
            border-radius: 50%; /* Membuat bentuk lingkaran */
            margin: auto; /* Pusatkan gambar */
            display: block;
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
                    <img src="image/Dosen2.jpg" alt="Foto Profil">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
