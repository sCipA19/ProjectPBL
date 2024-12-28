<?php
session_start();
require '../koneksi/kon.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

try {
    // Koneksi database
    $conn = new PDO("sqlsrv:Server=BEBI\\DBMS22;Database=PBL", "", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Data pelanggaran (mapping ID pelanggaran dengan deskripsi)
    $pelanggaran = [
        1 => 'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain',
        2 => 'Berbusana tidak sopan dan tidak rapi, seperti berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana tertentu',
        3 => 'Mengganggu ketertiban umum dengan berteriak atau berbicara keras di ruang kelas, koridor, atau area kampus lainnya',
        4 => 'Tidak mengikuti peraturan jadwal kuliah atau perkuliahan tanpa izin yang sah',
        5 => 'Menyontek atau melakukan tindakan kecurangan saat ujian atau penilaian lainnya',
        6 => 'Membawa makanan atau minuman ke dalam ruang kelas atau ruang laboratorium tanpa izin',
        7 => 'Mendekati atau berinteraksi secara tidak pantas dengan mahasiswa lain, dosen, atau karyawan',
        8 => 'Mencemari atau merusak fasilitas kampus, termasuk kebersihan dan keamanan',
        9 => 'Menggunakan perangkat elektronik (seperti ponsel, laptop, atau tablet) selama kuliah tanpa izin',
        10 => 'Melakukan pelanggaran terhadap aturan perpustakaan atau penggunaan fasilitas kampus lainnya',
        11 => 'Melakukan perbuatan diskriminatif atau pelecehan berdasarkan ras, agama, gender, atau orientasi seksual',
        12 => 'Berpartisipasi dalam tindakan kekerasan fisik atau verbal terhadap mahasiswa, dosen, atau karyawan',
        13 => 'Berkendara secara ugal-ugalan atau melanggar aturan lalu lintas kampus',
        14 => 'Tidak mematuhi aturan mengenai penggunaan fasilitas olahraga kampus',
        15 => 'Menggunakan obat-obatan terlarang atau melakukan penyalahgunaan zat di lingkungan kampus',
        16 => 'Mengabaikan atau menentang instruksi atau perintah yang diberikan oleh dosen atau petugas kampus',
        17 => 'Melanggar peraturan/ketentuan yang berlaku di Polinema baik di Jurusan/Program Studi',
        18 => 'Tidak menjaga kebersihan di seluruh area Polinema',
        19 => 'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung',
        20 => 'Merokok di luar area kawasan merokok',
        21 => 'Bermain kartu, game online di area kampus',
        22 => 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema',
        23 => 'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan',
        24 => 'Merusak sarana dan prasarana yang ada di area Polinema',
        25 => 'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda, dll)',
        26 => 'Melakukan pengotoran/pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang',
        27 => 'Mengakses materi pornografi di kelas atau area kampus',
        28 => 'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal',
        29 => 'Melakukan perkelahian, serta membentuk geng/kelompok yang bertujuan negatif',
        30 => 'Melakukan kegiatan politik praktis di dalam kampus',
        31 => 'Melakukan tindakan kekerasan atau perkelahian di dalam kampus',
        32 => 'Melakukan penyalahgunaan identitas untuk perbuatan negatif',
        33 => 'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan',
        34 => 'Mencuri dalam bentuk apapun',
        35 => 'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan',
        36 => 'Melakukan pemerasan dan/atau penipuan',
        37 => 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus',
        38 => 'Berjudi, mengkonsumsi minum-minuman keras, dan/atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema',
        39 => 'Mengikuti organisasi dan/atau menyebarkan faham-faham yang dilarang oleh Pemerintah',
        40 => 'Melakukan pemalsuan data/dokumen/tanda tangan',
        41 => 'Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah',
        42 => 'Tidak menjaga nama baik Polinema di masyarakat dan/atau mencemarkan nama baik Polinema melalui media apapun',
        43 => 'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa, dan Polinema',
        44 => 'Menggunakan barang-barang psikotropika dan/atau zat-zat adiktif lainnya',
        45 => 'Mengedarkan serta menjual barang-barang psikotropika dan/atau zat-zat adiktif lainnya',
        46 => 'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan',
    ];

    // Cek apakah form sudah disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form dengan validasi tambahan
        $nim = isset($_POST['nimMahasiswa']) ? trim($_POST['nimMahasiswa']) : null;
        $nama_mahasiswa = isset($_POST['namaMahasiswa']) ? trim($_POST['namaMahasiswa']) : null;
        $kelas_mahasiswa = isset($_POST['kelasMahasiswa']) ? trim($_POST['kelasMahasiswa']) : null;
        $id_pelanggaran = isset($_POST['namaPelanggaran']) ? trim($_POST['namaPelanggaran']) : null;
        $deskripsi_pelanggaran = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : null;

        // Validasi data input
        if (!empty($nim) && !empty($nama_mahasiswa) && !empty($kelas_mahasiswa) && !empty($id_pelanggaran) && !empty($deskripsi_pelanggaran)) {
            // Dapatkan nama pelanggaran berdasarkan ID
            $nama_pelanggaran = $pelanggaran[$id_pelanggaran] ?? null;  // Jika ID pelanggaran tidak valid, return null

            // Pastikan nama pelanggaran ada
            if ($nama_pelanggaran) {
                // Insert data ke database
                $stmt = $conn->prepare("INSERT INTO tb_laporan_pelanggaran_dosen (nim, nama_mahasiswa, kelas_mahasiswa, nama_pelanggaran, deskripsi_pelanggaran) 
                                        VALUES (:nim, :nama_mahasiswa, :kelas_mahasiswa, :nama_pelanggaran, :deskripsi_pelanggaran)");
                $stmt->bindParam(':nim', $nim);
                $stmt->bindParam(':nama_mahasiswa', $nama_mahasiswa);
                $stmt->bindParam(':kelas_mahasiswa', $kelas_mahasiswa);
                $stmt->bindParam(':nama_pelanggaran', $nama_pelanggaran);
                $stmt->bindParam(':deskripsi_pelanggaran', $deskripsi_pelanggaran);
                $stmt->execute();
                
                // Redirect ke halaman dashboard
                header("Location: dashbroad.php");  // Ganti dengan halaman tujuan yang sesuai
                exit();
            } else {
                echo "Pelanggaran tidak ditemukan.";
            }
        } else {
            echo "Semua kolom harus diisi.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
