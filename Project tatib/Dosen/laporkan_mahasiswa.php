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
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin: auto;
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
                    <img src="image/Dosen2.jpg" alt="Foto Profil" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <h5 class="mt-2">Purnomo Sujarwo S.Pd A.Sg</h5>
                </div>
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="#">
                        <i class="fas fa-home"></i> Dashboard TATIB
                    </a>
                    <a class="nav-link active" href="#"> <!-- Background biru pindah ke sini -->
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
                        <!-- Button untuk membuka modal tata tertib -->
                        <button data-bs-toggle="modal" data-bs-target="#tataTertibModal">Lihat Tata Tertib</button>
                    </div>
                    <div class="col-md-5 offset-md-1 welcome-card p-4">
                        <h4>Laporkan Pelanggaran</h4>
                        <p>Kirim laporan pelanggaran mahasiswa kepada admin</p>
                        <!-- Button untuk membuka modal pelanggaran -->
                        <button data-bs-toggle="modal" data-bs-target="#laporModal">Lapor Pelanggaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Profile -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="profileView">
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
                        <button class="btn btn-primary w-100" id="editProfileBtn">Edit Profile</button>
                    </div>
                    <div id="profileEdit" style="display: none;">
                        <form>
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editNama" value="Purnomo Sujarwo S.Pd S.Ag">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" value="purnomo123jsr@gmail.com">
                            </div>
                            <div class="mb-3">
                                <label for="editAlamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="editAlamat" value="Jl. Surabaya Blok A12 No 14">
                            </div>
                            <div class="mb-3">
                                <label for="editHp" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="editHp" value="08234-98767-2367">
                            </div>
                            <div class="mb-3">
                                <label for="editJabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="editJabatan" value="Dosen Pembina Akademik">
                            </div>
                            <button type="button" class="btn btn-success w-100" id="saveProfileBtn">Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary w-100 mt-2" id="cancelEditBtn">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tata Tertib -->
    <div class="modal fade" id="tataTertibModal" tabindex="-1" aria-labelledby="tataTertibModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tataTertibModalLabel">Pedoman Tata Tertib</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Google Drive Embed -->
                    <iframe src="https://drive.google.com/file/d/1Gdr4X_example/preview" width="100%" height="400" allow="autoplay"></iframe>
                </div>
                <div class="modal-footer">
                    <a href="https://drive.google.com/uc?id=1Gdr4X_example&export=download" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download Tata Tertib
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lapor Pelanggaran -->
    <div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporModalLabel">Lapor Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="namaMahasiswa" placeholder="Masukkan nama mahasiswa">
                        </div>
                        <div class="mb-3">
                            <label for="kelasMahasiswa" class="form-label">Kelas Mahasiswa</label>
                            <select class="form-select" id="kelasMahasiswa">
                                <option selected>Pilih kelas</option>
                                <option value="1">Kelas A</option>
                                <option value="2">Kelas B</option>
                                <option value="3">Kelas C</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaPelanggaran" class="form-label">Nama Pelanggaran</label>
                            <select class="form-select" id="namaPelanggaran">
                                <option selected>Pilih pelanggaran</option>
                                <option value="1">Terlambat</option>
                                <option value="2">Tidak memakai seragam</option>
                                <option value="3">Bolos kelas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="4" placeholder="Masukkan deskripsi pelanggaran"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Kirim Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editProfileBtn').addEventListener('click', function() {
            document.getElementById('profileView').style.display = 'none';
            document.getElementById('profileEdit').style.display = 'block';
        });

        document.getElementById('cancelEditBtn').addEventListener('click', function() {
            document.getElementById('profileView').style.display = 'block';
            document.getElementById('profileEdit').style.display = 'none';
        });

        document.getElementById('saveProfileBtn').addEventListener('click', function() {
            alert('Profile saved!');
            document.getElementById('profileView').style.display = 'block';
            document.getElementById('profileEdit').style.display = 'none';
        });
    </script>
</body>
</html>
