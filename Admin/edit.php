<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Menghubungkan ke database
    $conn = new PDO("sqlsrv:Server=BEBI\\DBMS22;Database=PBL", "", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengecek apakah ada parameter 'id' yang dikirimkan
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query untuk mengambil data berdasarkan id_tatib
        $sql = "SELECT id_tatib, nim, nama_mahasiswa, kelas, pelanggaran, tingkat, kompensasi, tenggat FROM tb_kelolatatib WHERE id_tatib = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika data tidak ditemukan, redirect ke halaman utama
        if (!$data) {
            header("Location: kelola.php");
            exit();
        }
    }

    // Proses update data setelah form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ambil data dari form
        $nim = $_POST['nim'];
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $kelas = $_POST['kelas'];
        $pelanggaran = $_POST['pelanggaran'];
        $tingkat = $_POST['tingkat'];
        $kompensasi = $_POST['kompensasi'];
        $tenggat = $_POST['tenggat'];

        // Query untuk memperbarui data
        $updateSql = "UPDATE tb_kelolatatib SET nim = :nim, nama_mahasiswa = :nama_mahasiswa, kelas = :kelas, pelanggaran = :pelanggaran, tingkat = :tingkat,  kompensasi = :kompensasi ,tenggat = :tenggat WHERE id_tatib = :id";
        $stmt = $conn->prepare($updateSql);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
        $stmt->bindParam(':kelas', $kelas);
        $stmt->bindParam(':pelanggaran', $pelanggaran);
        $stmt->bindParam(':tingkat', $tingkat);
        $stmt->bindParam(':kompensasi', $kompensasi);
        $stmt->bindParam(':tenggat', $tenggat);


        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Redirect ke halaman utama setelah berhasil update
            header("Location: kelola.php");
            exit();
        } else {
            echo "Gagal memperbarui data.";
        }
    }

} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tata Tertib</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_beranda.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        // JavaScript function to add a card
        function addCard() {
            const cardContainer = document.getElementById("cardContainer");



            cardContainer.appendChild(card);
        }
    </script>
</head>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar vh-100">
            <div class="text-center mt-4">
                <h3 class="text-uppercase fw-bold">Anukrama</h3>
                <img src="./img/pic.jpeg" alt="Suprapto" class="rounded-circle mt-3" width="80">
                <h5 class="mt-2">Suprapto</h5>
            </div>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="beranda.php" class="nav-link">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pelanggaran.php" class="nav-link">
                        <i class="bi bi-list-task me-2"></i>Daftar Pelanggaran
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola.php" class="nav-link">
                        <i class="bi bi-gear me-2"></i>Kelola Tata Tertib
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" onclick="toggleDropdown()">
                        <i class="bi bi-bell me-2"></i>Notifikasi
                    </a>
                    <div class="dropdown-container" id="dropdownMenu">
                        <ul class="notification-list">
                            <li><a href="notifikasidosen.php">Notifikasi dari Dosen</a></li>
                            <li><a href="notifikasimahasiswa.php">Notifikasi dari Mahasiswa</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 p-4" id="main-content">
            <h2>Kelola Tata Tertib</h2>
            <p>Tambahkan, edit, atau hapus aturan tata tertib di bawah ini:</p>

            <form method="POST">
                <!-- Card Container -->
                <div class="form-background">
                    <!-- Input NIM -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="<?= htmlspecialchars($data['nim']) ?>" required>
                        </div>

                        <!-- Input Nama Mahasiswa -->
                        <div class="col-md-6">
                            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa"
                                value="<?= htmlspecialchars($data['nama_mahasiswa']) ?>" required>
                        </div>

                        <!-- Input Kelas -->
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option selected disabled value="">Pilih kelas</option>
                                <option value="SIB 1A" <?= $data['kelas'] == 'SIB 1A' ? 'selected' : '' ?>>SIB 1A</option>
                                <option value="SIB 1B" <?= $data['kelas'] == 'SIB 1B' ? 'selected' : '' ?>>SIB 1B</option>
                                <option value="SIB 1C" <?= $data['kelas'] == 'SIB 1C' ? 'selected' : '' ?>>SIB 1C</option>
                                <option value="SIB 1D" <?= $data['kelas'] == 'SIB 1D' ? 'selected' : '' ?>>SIB 1D</option>
                                <option value="SIB 1E" <?= $data['kelas'] == 'SIB 1E' ? 'selected' : '' ?>>SIB 1E</option>
                                <option value="SIB 1F" <?= $data['kelas'] == 'SIB 1F' ? 'selected' : '' ?>>SIB 1F</option>
                                <option value="SIB 1G" <?= $data['kelas'] == 'SIB 1G' ? 'selected' : '' ?>>SIB 1G</option>
                                <option value="SIB 2A" <?= $data['kelas'] == 'SIB 2A' ? 'selected' : '' ?>>SIB 2A</option>
                                <option value="SIB 2B" <?= $data['kelas'] == 'SIB 2B' ? 'selected' : '' ?>>SIB 2B</option>
                                <option value="SIB 2C" <?= $data['kelas'] == 'SIB 2C' ? 'selected' : '' ?>>SIB 2C</option>
                                <option value="SIB 2D" <?= $data['kelas'] == 'SIB 2D' ? 'selected' : '' ?>>SIB 2D</option>
                                <option value="SIB 2E" <?= $data['kelas'] == 'SIB 2E' ? 'selected' : '' ?>>SIB 2E</option>
                                <option value="SIB 2F" <?= $data['kelas'] == 'SIB 2F' ? 'selected' : '' ?>>SIB 2F</option>
                                <option value="SIB 2G" <?= $data['kelas'] == 'SIB 2G' ? 'selected' : '' ?>>SIB 2G</option>
                                <option value="SIB 3A" <?= $data['kelas'] == 'SIB 3A' ? 'selected' : '' ?>>SIB 3A</option>
                                <option value="SIB 3B" <?= $data['kelas'] == 'SIB 3B' ? 'selected' : '' ?>>SIB 3B</option>
                                <option value="SIB 3C" <?= $data['kelas'] == 'SIB 3C' ? 'selected' : '' ?>>SIB 3C</option>
                                <option value="SIB 3D" <?= $data['kelas'] == 'SIB 3D' ? 'selected' : '' ?>>SIB 3D</option>
                                <option value="SIB 3E" <?= $data['kelas'] == 'SIB 3E' ? 'selected' : '' ?>>SIB 3E</option>
                                <option value="SIB 3F" <?= $data['kelas'] == 'SIB 3F' ? 'selected' : '' ?>>SIB 3F</option>
                                <option value="SIB 3G" <?= $data['kelas'] == 'SIB 3G' ? 'selected' : '' ?>>SIB 3G</option>
                                <option value="SIB 4A" <?= $data['kelas'] == 'SIB 4A' ? 'selected' : '' ?>>SIB 4A</option>
                                <option value="SIB 4B" <?= $data['kelas'] == 'SIB 4B' ? 'selected' : '' ?>>SIB 4B</option>
                                <option value="SIB 4C" <?= $data['kelas'] == 'SIB 4C' ? 'selected' : '' ?>>SIB 4C</option>
                                <option value="SIB 4D" <?= $data['kelas'] == 'SIB 4D' ? 'selected' : '' ?>>SIB 4D</option>
                                <option value="SIB 4E" <?= $data['kelas'] == 'SIB 4E' ? 'selected' : '' ?>>SIB 4E</option>
                                <option value="SIB 4F" <?= $data['kelas'] == 'SIB 4F' ? 'selected' : '' ?>>SIB 4F</option>
                                <option value="SIB 4G" <?= $data['kelas'] == 'SIB 4G' ? 'selected' : '' ?>>SIB 4G</option>
                            </select>
                        </div>


                        <!-- Input Pelanggaran -->
                        <div class="mb-3">
                            <label for="pelanggaran" class="form-label">Pelanggaran</label>
                            <select class="form-select" id="pelanggaran" name="pelanggaran" required>
                                <option value="" selected disabled>Pilih Pelanggaran</option>
                                <option
                                    value="Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain"
                                    <?= $data['pelanggaran'] == 'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain' ? 'selected' : '' ?>>
                                    Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada
                                    mahasiswa, dosen, karyawan, atau orang lain
                                </option>
                                <option
                                    value="Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana tertentu"
                                    <?= $data['pelanggaran'] == 'Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana tertentu' ? 'selected' : '' ?>>
                                    Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai
                                    t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini,
                                    backless, celana pendek, celana tiga per empat, legging, model celana tertentu
                                </option>
                                <option
                                    value="Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah baju di bagian leher"
                                    <?= $data['pelanggaran'] == 'Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah baju di bagian leher' ? 'selected' : '' ?>>
                                    Mahasiswa laki-laki berambut tidak rapi, gondrong, yaitu panjang rambutnya melewati
                                    batas alis mata di bagian depan, telinga di bagian samping, atau menyentuh kerah
                                    baju di bagian leher
                                </option>
                                <option
                                    value="Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned"
                                    <?= $data['pelanggaran'] == 'Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned' ? 'selected' : '' ?>>
                                    Mahasiswa berambut dengan model punk, dicat selain hitam, dan/atau skinned
                                </option>
                                <option value="Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel"
                                    <?= $data['pelanggaran'] == 'Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel' ? 'selected' : '' ?>>
                                    Makan, atau minum di dalam ruang kuliah/laboratorium/bengkel
                                </option>
                                <option
                                    value="Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi"
                                    <?= $data['pelanggaran'] == 'Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi' ? 'selected' : '' ?>>
                                    Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi
                                </option>
                                <option value="Tidak menjaga kebersihan di seluruh area Polinema"
                                    <?= $data['pelanggaran'] == 'Tidak menjaga kebersihan di seluruh area Polinema' ? 'selected' : '' ?>>
                                    Tidak menjaga kebersihan di seluruh area Polinema
                                </option>
                                <option
                                    value="Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung"
                                    <?= $data['pelanggaran'] == 'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung' ? 'selected' : '' ?>>
                                    Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang
                                    berlangsung
                                </option>
                                <option value="Merokok di luar area kawasan merokok" <?= $data['pelanggaran'] == 'Merokok di luar area kawasan merokok' ? 'selected' : '' ?>>
                                    Merokok di luar area kawasan merokok
                                </option>
                                <option value="Bermain kartu, game online di area kampus"
                                    <?= $data['pelanggaran'] == 'Bermain kartu, game online di area kampus' ? 'selected' : '' ?>>
                                    Bermain kartu, game online di area kampus
                                </option>
                                <option
                                    value="Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema"
                                    <?= $data['pelanggaran'] == 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema' ? 'selected' : '' ?>>
                                    Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan
                                    Polinema
                                </option>
                                <option
                                    value="Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan"
                                    <?= $data['pelanggaran'] == 'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan' ? 'selected' : '' ?>>
                                    Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan
                                </option>
                                <option value="Merusak sarana dan prasarana yang ada di area Polinema"
                                    <?= $data['pelanggaran'] == 'Merusak sarana dan prasarana yang ada di area Polinema' ? 'selected' : '' ?>>
                                    Merusak sarana dan prasarana yang ada di area Polinema
                                </option>
                                <option
                                    value="Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)"
                                    <?= $data['pelanggaran'] == 'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)' ? 'selected' : '' ?>>
                                    Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir
                                    tidak pada tempatnya, konvoi selebrasi wisuda, dll)
                                </option>
                                <option
                                    value="Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang"
                                    <?= $data['pelanggaran'] == 'Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang' ? 'selected' : '' ?>>
                                    Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik
                                    Negeri Malang
                                </option>
                                <option value="Mengakses materi pornografi di kelas atau area kampus"
                                    <?= $data['pelanggaran'] == 'Mengakses materi pornografi di kelas atau area kampus' ? 'selected' : '' ?>>
                                    Mengakses materi pornografi di kelas atau area kampus
                                </option>
                                <option
                                    value="Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal"
                                    <?= $data['pelanggaran'] == 'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal' ? 'selected' : '' ?>>
                                    Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal
                                </option>
                                <option
                                    value="Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif"
                                    <?= $data['pelanggaran'] == 'Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif' ? 'selected' : '' ?>>
                                    Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif
                                </option>
                                <option value="Melakukan kegiatan politik praktis di dalam kampus"
                                    <?= $data['pelanggaran'] == 'Melakukan kegiatan politik praktis di dalam kampus' ? 'selected' : '' ?>>
                                    Melakukan kegiatan politik praktis di dalam kampus
                                </option>
                                <option value="Melakukan tindakan kekerasan atau perkelahian di dalam kampus"
                                    <?= $data['pelanggaran'] == 'Melakukan tindakan kekerasan atau perkelahian di dalam kampus' ? 'selected' : '' ?>>
                                    Melakukan tindakan kekerasan atau perkelahian di dalam kampus
                                </option>
                                <option value="Melakukan penyalahgunaan identitas untuk perbuatan negatif"
                                    <?= $data['pelanggaran'] == 'Melakukan penyalahgunaan identitas untuk perbuatan negatif' ? 'selected' : '' ?>>
                                    Melakukan penyalahgunaan identitas untuk perbuatan negatif
                                </option>
                                <option
                                    value="Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan"
                                    <?= $data['pelanggaran'] == 'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan' ? 'selected' : '' ?>>
                                    Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau
                                    karyawan
                                </option>
                                <option value="Mencuri dalam bentuk apapun" <?= $data['pelanggaran'] == 'Mencuri dalam bentuk apapun' ? 'selected' : '' ?>>
                                    Mencuri dalam bentuk apapun
                                </option>
                                <option value="Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan"
                                    <?= $data['pelanggaran'] == 'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan' ? 'selected' : '' ?>>
                                    Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan
                                </option>
                                <option value="Melakukan pemerasan dan/atau penipuan"
                                    <?= $data['pelanggaran'] == 'Melakukan pemerasan dan/atau penipuan' ? 'selected' : '' ?>>
                                    Melakukan pemerasan dan/atau penipuan
                                </option>
                                <option
                                    value="Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus"
                                    <?= $data['pelanggaran'] == 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus' ? 'selected' : '' ?>>
                                    Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di
                                    luar kampus
                                </option>
                            </select>
                        </div>




                        <!-- Input Tingkat -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat</label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="" selected disabled>Pilih Tingkat</option>
                                <option value="I" <?= $data['tingkat'] == 'I' ? 'selected' : '' ?>>I</option>
                                <option value="II" <?= $data['tingkat'] == 'II' ? 'selected' : '' ?>>II</option>
                                <option value="III" <?= $data['tingkat'] == 'III' ? 'selected' : '' ?>>III</option>
                                <option value="IV" <?= $data['tingkat'] == 'IV' ? 'selected' : '' ?>>IV</option>
                                <option value="V" <?= $data['tingkat'] == 'V' ? 'selected' : '' ?>>V</option>
                            </select>
                        </div>

                        <!-- Input Nama Mahasiswa -->
                        <div class="col-md-6">
                            <label for="kompensasi" class="form-label">Kompensasi</label>
                            <input type="text" class="form-control" id="kompensasi" name="kompensasi"
                                value="<?= htmlspecialchars($data['kompensasi']) ?>" required>
                        </div>

                        <!-- Tenggat Waktu -->
                        <div class="col-md-6">
                            <label for="tenggat" class="form-label">Tenggat Waktu</label>
                            <input type="date" class="form-control" id="tenggat" name="tenggat" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 ms-3">Simpan Perubahan</button>

            </form>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById("dropdownMenu");
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            }

            window.onclick = function (event) {
                if (!event.target.matches('.nav-link')) {
                    const dropdown = document.getElementById("dropdownMenu");
                    if (dropdown.style.display === "block") {
                        dropdown.style.display = "none";
                    }
                }
            };
        </script>
        </body>

</html>