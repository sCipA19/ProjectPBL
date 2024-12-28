<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../Login/index2.php"); // Jika belum login, arahkan ke halaman login
    exit();
}

// Koneksi ke database
$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server
$database = "PBL"; // Ganti dengan nama database
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Cek apakah ada id laporan yang dikirimkan
if (isset($_GET['id'])) {
    $id_laporan = $_GET['id'];

    // Ambil data laporan berdasarkan id
    $sql = "SELECT * FROM tb_laporan_pelanggaran_dosen WHERE id_laporan = :id_laporan";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_laporan', $id_laporan);
    $stmt->execute();
    $laporan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$laporan) {
        die("Data laporan tidak ditemukan.");
    }
}

// Proses update data setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil inputan dari form
    $nim = $_POST['nimMahasiswa'];
    $nama_mahasiswa = $_POST['namaMahasiswa'];
    $kelas_mahasiswa = $_POST['kelasMahasiswa'];
    $nama_pelanggaran = $_POST['namaPelanggaran'];
    $deskripsi_pelanggaran = $_POST['deskripsi'];

    // Update data ke database
    $update_sql = "UPDATE tb_laporan_pelanggaran_dosen 
                   SET nim = :nim, 
                       nama_mahasiswa = :nama_mahasiswa, 
                       kelas_mahasiswa = :kelas_mahasiswa, 
                       nama_pelanggaran = :nama_pelanggaran, 
                       deskripsi_pelanggaran = :deskripsi_pelanggaran 
                   WHERE id_laporan = :id_laporan";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':nim', $nim);
    $update_stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
    $update_stmt->bindParam(':kelas_mahasiswa', $kelas_mahasiswa);
    $update_stmt->bindParam(':nama_pelanggaran', $nama_pelanggaran);
    $update_stmt->bindParam(':deskripsi_pelanggaran', $deskripsi_pelanggaran);
    $update_stmt->bindParam(':id_laporan', $id_laporan);
    $update_stmt->execute();

    // Redirect ke halaman dashboard setelah data berhasil diupdate
    header("Location: dashbroad.php");
    exit();
}

?>

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

            
            <!-- Modal Edit Laporan -->
            <div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="laporModalLabel">Lapor Pelanggaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form id="laporanForm" method="POST" action="">


                                <div class="mb-3">
                                    <label for="nimMahasiswa" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nimMahasiswa" name="nimMahasiswa" placeholder="Masukkan NIM mahasiswa" value="<?php echo htmlspecialchars($laporan['nim']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa" placeholder="Masukkan nama mahasiswa" value="<?php echo htmlspecialchars($laporan['nama_mahasiswa']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelasMahasiswa" class="form-label">Kelas Mahasiswa</label>
                                    <select class="form-select" id="kelasMahasiswa" name="kelasMahasiswa" required>
                                        <option disabled value="">Pilih kelas</option>
                                        <option value="SIB 1A" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1A' ? 'selected' : ''; ?>>SIB 1A</option>
                                        <option value="SIB 1B" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1B' ? 'selected' : ''; ?>>SIB 1B</option>
                                        <option value="SIB 1C" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1C' ? 'selected' : ''; ?>>SIB 1C</option>
                                        <option value="SIB 1D" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1D' ? 'selected' : ''; ?>>SIB 1D</option>
                                        <option value="SIB 1E" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1E' ? 'selected' : ''; ?>>SIB 1E</option>
                                        <option value="SIB 1F" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1F' ? 'selected' : ''; ?>>SIB 1F</option>
                                        <option value="SIB 1G" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 1G' ? 'selected' : ''; ?>>SIB 1G</option>
                                        <option value="SIB 2A" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2A' ? 'selected' : ''; ?>>SIB 2A</option>
                                        <option value="SIB 2B" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2B' ? 'selected' : ''; ?>>SIB 2B</option>
                                        <option value="SIB 2C" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2C' ? 'selected' : ''; ?>>SIB 2C</option>
                                        <option value="SIB 2D" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2D' ? 'selected' : ''; ?>>SIB 2D</option>
                                        <option value="SIB 2E" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2E' ? 'selected' : ''; ?>>SIB 2E</option>
                                        <option value="SIB 2F" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2F' ? 'selected' : ''; ?>>SIB 2F</option>
                                        <option value="SIB 2G" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 2G' ? 'selected' : ''; ?>>SIB 2G</option>
                                        <option value="SIB 3A" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 3A' ? 'selected' : ''; ?>>SIB 3A</option>
                                        <option value="SIB 3B" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 3B' ? 'selected' : ''; ?>>SIB 3B</option>
                                        <option value="SIB 3C" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 3C' ? 'selected' : ''; ?>>SIB 3C</option>
                                        <option value="SIB 3D" <?php echo $laporan['kelas_mahasiswa'] == 'SIB 3D' ? 'selected' : ''; ?>>SIB 3D</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="namaPelanggaran" class="form-label">Nama Pelanggaran</label>
                                    <select class="form-select" id="namaPelanggaran" name="namaPelanggaran" required>
                                        <option disabled value="">Pilih Pelanggaran</option>
                                        <option value="1" <?php echo $laporan['nama_pelanggaran'] == '1' ? 'selected' : ''; ?>>Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain</option>
<option value="2" <?php echo $laporan['nama_pelanggaran'] == '2' ? 'selected' : ''; ?>>Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana tertentu</option>
<option value="3" <?php echo $laporan['nama_pelanggaran'] == '3' ? 'selected' : ''; ?>>Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah baju di bagian leher</option>
<option value="4" <?php echo $laporan['nama_pelanggaran'] == '4' ? 'selected' : ''; ?>>Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned</option>
<option value="5" <?php echo $laporan['nama_pelanggaran'] == '5' ? 'selected' : ''; ?>>Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel</option>
<option value="6" <?php echo $laporan['nama_pelanggaran'] == '6' ? 'selected' : ''; ?>>Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi</option>
<option value="7" <?php echo $laporan['nama_pelanggaran'] == '7' ? 'selected' : ''; ?>>Tidak menjaga kebersihan di seluruh area Polinema</option>
<option value="8" <?php echo $laporan['nama_pelanggaran'] == '8' ? 'selected' : ''; ?>>Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung</option>
<option value="9" <?php echo $laporan['nama_pelanggaran'] == '9' ? 'selected' : ''; ?>>Merokok di luar area kawasan merokok</option>
<option value="10" <?php echo $laporan['nama_pelanggaran'] == '10' ? 'selected' : ''; ?>>Bermain kartu, game online di area kampus</option>
<option value="11" <?php echo $laporan['nama_pelanggaran'] == '11' ? 'selected' : ''; ?>>Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema</option>
<option value="12" <?php echo $laporan['nama_pelanggaran'] == '12' ? 'selected' : ''; ?>>Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan</option>
<option value="13" <?php echo $laporan['nama_pelanggaran'] == '13' ? 'selected' : ''; ?>>Merusak sarana dan prasarana yang ada di area Polinema</option>
<option value="14" <?php echo $laporan['nama_pelanggaran'] == '14' ? 'selected' : ''; ?>>Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)</option>
<option value="15" <?php echo $laporan['nama_pelanggaran'] == '15' ? 'selected' : ''; ?>>Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang</option>
<option value="16" <?php echo $laporan['nama_pelanggaran'] == '16' ? 'selected' : ''; ?>>Mengakses materi pornografi di kelas atau area kampus</option>
<option value="17" <?php echo $laporan['nama_pelanggaran'] == '17' ? 'selected' : ''; ?>>Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal</option>
<option value="18" <?php echo $laporan['nama_pelanggaran'] == '18' ? 'selected' : ''; ?>>Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif</option>
<option value="19" <?php echo $laporan['nama_pelanggaran'] == '19' ? 'selected' : ''; ?>>Melakukan kegiatan politik praktis di dalam kampus</option>
<option value="20" <?php echo $laporan['nama_pelanggaran'] == '20' ? 'selected' : ''; ?>>Melakukan tindakan kekerasan atau perkelahian di dalam kampus</option>
<option value="21" <?php echo $laporan['nama_pelanggaran'] == '21' ? 'selected' : ''; ?>>Melakukan penyalahgunaan identitas untuk perbuatan negatif</option>
<option value="22" <?php echo $laporan['nama_pelanggaran'] == '22' ? 'selected' : ''; ?>>Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan</option>
<option value="23" <?php echo $laporan['nama_pelanggaran'] == '23' ? 'selected' : ''; ?>>Mencuri dalam bentuk apapun</option>
<option value="24" <?php echo $laporan['nama_pelanggaran'] == '24' ? 'selected' : ''; ?>>Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan</option>
<option value="25" <?php echo $laporan['nama_pelanggaran'] == '25' ? 'selected' : ''; ?>>Melakukan pemerasan dan/atau penipuan</option>
<option value="26" <?php echo $laporan['nama_pelanggaran'] == '26' ? 'selected' : ''; ?>>Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus</option>
<option value="27" <?php echo $laporan['nama_pelanggaran'] == '27' ? 'selected' : ''; ?>>Berjudi, mengkonsumsi minum-minuman keras, dan/atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema</option>
<option value="28" <?php echo $laporan['nama_pelanggaran'] == '28' ? 'selected' : ''; ?>>Mengikuti organisasi dan/atau menyebarkan faham-faham yang dilarang oleh Pemerintah</option>
<option value="29" <?php echo $laporan['nama_pelanggaran'] == '29' ? 'selected' : ''; ?>>Melakukan pemalsuan data/dokumen/tanda tangan</option>
<option value="30" <?php echo $laporan['nama_pelanggaran'] == '30' ? 'selected' : ''; ?>>Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah</option>
<option value="31" <?php echo $laporan['nama_pelanggaran'] == '31' ? 'selected' : ''; ?>>Tidak menjaga nama baik Polinema di masyarakat dan/atau mencemarkan nama baik Polinema melalui media apapun</option>
<option value="32" <?php echo $laporan['nama_pelanggaran'] == '32' ? 'selected' : ''; ?>>Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa, dan Polinema</option>
<option value="33" <?php echo $laporan['nama_pelanggaran'] == '33' ? 'selected' : ''; ?>>Menggunakan barang-barang psikotropika dan/atau zat-zat adiktif lainnya</option>
<option value="34" <?php echo $laporan['nama_pelanggaran'] == '34' ? 'selected' : ''; ?>>Mengedarkan serta menjual barang-barang psikotropika dan/atau zat-zat adiktif lainnya</option>
<option value="35" <?php echo $laporan['nama_pelanggaran'] == '35' ? 'selected' : ''; ?>>Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan</option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pelanggaran" required><?php echo htmlspecialchars($laporan['deskripsi_pelanggaran']); ?></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" form="laporanForm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script untuk membuka modal secara otomatis -->
<script type="text/javascript">
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        var idLaporan = urlParams.get('id');
        
        // Cek apakah ada parameter id di URL
        if (idLaporan) {
            var myModal = new bootstrap.Modal(document.getElementById('laporModal'));
            myModal.show();
        }
    };
</script>

</body>

</html>
