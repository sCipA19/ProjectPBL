<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TATIB - ANUKRAMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"> <!-- Link ke file CSS eksternal -->
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
                    <a class="nav-link" href="dashbroad.php">
                        <i class="fas fa-home"></i> Dashboard TATIB
                    </a>
                    <a class="nav-link active" href="#"> <!-- Background biru pindah ke sini -->
                        <i class="fas fa-clipboard-list"></i> Laporkan Pelanggaran
                    </a>
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>

            <div class="col-md-9 content">
                <h1 class="fw-bold">Selamat datang</h1>
                <p>Kelola laporan pelanggaran dan akses tata tertib</p>

                <div class="row mt-4">
                    <div class="col-md-5 welcome-card p-4">
                        <h4>Akses Tata Tertib</h4>
                        <p>Lihat semua peraturan yang berlaku</p>
                        <!-- Button untuk membuka tata tertib -->
                        <button data-bs-toggle="modal" data-bs-target="#tataTertibModal">Lihat Tata Tertib</button>
                    </div>
                    <div class="col-md-5 offset-md-1 welcome-card p-4">
                        <h4>Laporkan Pelanggaran</h4>
                        <p>Kirim laporan pelanggaran mahasiswa kepada admin</p>
                        <!-- Button untuk membuka pelanggaran -->
                        <button data-bs-toggle="modal" data-bs-target="#laporModal">Lapor Pelanggaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile -->
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
                            <img src="image/Dosen2.jpg" alt="Foto Profil" class="rounded-circle mb-3"
                                style="width: 100px; height: 100px; object-fit: cover;">
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
                        <a href="edit_laporan.php?id=<?php echo $laporan['id_laporan']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#laporModal">Edit</a>

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
                                <input type="text" class="form-control" id="editAlamat"
                                    value="Jl. Surabaya Blok A12 No 14">
                            </div>
                            <div class="mb-3">
                                <label for="editHp" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="editHp" value="08234-98767-2367">
                            </div>
                            <div class="mb-3">
                                <label for="editJabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="editJabatan" value="Dosen Pembina Akademik">
                            </div>
                            <button type="button" class="btn btn-success w-100" id="saveProfileBtn">Simpan
                                Perubahan</button>
                            <button type="button" class="btn btn-secondary w-100 mt-2" id="cancelEditBtn">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tata Tertib -->
    <div class="modal fade" id="tataTertibModal" tabindex="-1" aria-labelledby="tataTertibModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tataTertibModalLabel">Pedoman Tata Tertib</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Google Drive Embed -->
                    <iframe src="https://drive.google.com/file/d/1Gdr4X_example/preview" width="100%" height="400"
                        allow="autoplay"></iframe>
                </div>
                <div class="modal-footer">
                <a href="https://drive.google.com/uc?export=download&id=1vx92t2VGu2ptvBJEFtp94Y1Zq9P2N5n4
" class="btn btn-primary">
    <i class="fas fa-download"></i> Download Tata Tertib
</a>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lapor Pelanggaran Modal -->
    <div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporModalLabel">Lapor Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="laporanForm" method="POST" action="laporkan_pelanggaran.php">
                    <div class="mb-3">
                            <label for="nimMahasiswa" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nimMahasiswa" name="nimMahasiswa"
                                placeholder="Masukkan NIM mahasiswa">
                        <div class="mb-3">
                            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa"
                                placeholder="Masukkan nama mahasiswa">
                        </div>
                        <div class="mb-3">
                            <label for="kelasMahasiswa" class="form-label">Kelas Mahasiswa</label>
                            <select class="form-select" id="kelasMahasiswa" name="kelasMahasiswa">
                            <option selected disabled value="">Pilih kelas</option>
                                <option value="SIB 1A">SIB 1A</option>
                                <option value="SIB 1B">SIB 1B</option>
                                <option value="SIB 1C">SIB 1C</option>
                                <option value="SIB 1D">SIB 1D</option>
                                <option value="SIB 1E">SIB 1E</option>
                                <option value="SIB 1F">SIB 1F</option>
                                <option value="SIB 1G">SIB 1G</option>
                                <option value="SIB 2A">SIB 2A</option>
                                <option value="SIB 2B">SIB 2B</option>
                                <option value="SIB 2C">SIB 2C</option>
                                <option value="SIB 2D">SIB 2D</option>
                                <option value="SIB 2E">SIB 2E</option>
                                <option value="SIB 2F">SIB 2F</option>
                                <option value="SIB 2G">SIB 2G</option>
                                <option value="SIB 3A">SIB 3A</option>
                                <option value="SIB 3B">SIB 3B</option>
                                <option value="SIB 3C">SIB 3C</option>
                                <option value="SIB 3D">SIB 3D</option>
                                <option value="SIB 3E">SIB 3E</option>
                                <option value="SIB 3F">SIB 3F</option>
                                <option value="SIB 3G">SIB 3G</option>
                                <option value="SIB 4A">SIB 4A</option>
                                <option value="SIB 4B">SIB 4B</option>
                                <option value="SIB 4C">SIB 4C</option>
                                <option value="SIB 4D">SIB 4D</option>
                                <option value="SIB 4E">SIB 4E</option>
                                <option value="SIB 4F">SIB 4F</option>
                                <option value="SIB 4G">SIB 4G</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaPelanggaran" class="form-label">Nama Pelanggaran</label>
                            <select class="form-select" id="namaPelanggaran" name="namaPelanggaran">
                            <option selected disabled value="">Pilih Pelanggaran</option>

                                <option value="1">Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis
                                    kepada mahasiswa, dosen, karyawan, atau orang lain</option>
                                <option value="2">Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat,
                                    transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can
                                    see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana
                                    tertentu</option>
                                <option value="3">Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang
                                    rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping, atau
                                    menyentuh kerah baju di bagian leher</option>
                                <option value="4">Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau
                                    skinned</option>
                                <option value="5">Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel</option>
                                <option value="6">Melanggar peraturan/ketentuan yang berlaku di Polinema baik di
                                    Jurusan/Program Studi</option>
                                <option value="7">Tidak menjaga kebersihan di seluruh area Polinema</option>
                                <option value="8">Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau
                                    praktikum yang sedang berlangsung</option>
                                <option value="9">Merokok di luar area kawasan merokok</option>
                                <option value="10">Bermain kartu, game online di area kampus</option>
                                <option value="11">Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di
                                    lingkungan Polinema</option>
                                <option value="12">Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen,
                                    dan/atau karyawan</option>
                                <option value="13">Merusak sarana dan prasarana yang ada di area Polinema</option>
                                <option value="14">Tidak menjaga ketertiban dan keamanan di seluruh area Polinema
                                    (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)</option>
                                <option value="15">Melakukan pengotoran/pengrusakan barang milik orang lain termasuk
                                    milik Politeknik Negeri Malang</option>
                                <option value="16">Mengakses materi pornografi di kelas atau area kampus</option>
                                <option value="17">Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk
                                    hal kriminal</option>
                                <option value="18">Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan
                                    negatif</option>
                                <option value="19">Melakukan kegiatan politik praktis di dalam kampus</option>
                                <option value="20">Melakukan tindakan kekerasan atau perkelahian di dalam kampus
                                </option>
                                <option value="21">Melakukan penyalahgunaan identitas untuk perbuatan negatif</option>
                                <option value="22">Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen,
                                    dan/atau karyawan</option>
                                <option value="23">Mencuri dalam bentuk apapun</option>
                                <option value="24">Melakukan kecurangan dalam bidang akademik, administratif, dan
                                    keuangan</option>
                                <option value="25">Melakukan pemerasan dan/atau penipuan</option>
                                <option value="26">Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di
                                    dalam dan di luar kampus</option>
                                <option value="27">Berjudi, mengkonsumsi minum-minuman keras, dan/atau bermabuk-mabukan
                                    di lingkungan dan di luar lingkungan Kampus Polinema</option>
                                <option value="28">Mengikuti organisasi dan/atau menyebarkan faham-faham yang dilarang
                                    oleh Pemerintah</option>
                                <option value="29">Melakukan pemalsuan data/dokumen/tanda tangan</option>
                                <option value="30">Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah
                                </option>
                                <option value="31">Tidak menjaga nama baik Polinema di masyarakat dan/atau mencemarkan
                                    nama baik Polinema melalui media apapun</option>
                                <option value="32">Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan
                                    atau martabat Negara, Bangsa, dan Polinema</option>
                                <option value="33">Menggunakan barang-barang psikotropika dan/atau zat-zat adiktif
                                    lainnya</option>
                                <option value="34">Mengedarkan serta menjual barang-barang psikotropika dan/atau zat-zat
                                    adiktif lainnya</option>
                                <option value="35">Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh
                                    Pengadilan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                                placeholder="Masukkan deskripsi pelanggaran"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" form="laporanForm">Kirim Laporan</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editProfileBtn').addEventListener('click', function () {
            document.getElementById('profileView').style.display = 'none';
            document.getElementById('profileEdit').style.display = 'block';
        });

        document.getElementById('cancelEditBtn').addEventListener('click', function () {
            document.getElementById('profileView').style.display = 'block';
            document.getElementById('profileEdit').style.display = 'none';
        });

        document.getElementById('saveProfileBtn').addEventListener('click', function () {
            alert('Profile saved!');
            document.getElementById('profileView').style.display = 'block';
            document.getElementById('profileEdit').style.display = 'none';
        });


    </script>
</body>

</html>