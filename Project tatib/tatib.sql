-- SQL Server Script

USE tata_tertib;
GO

-- Table structure for table `login`
CREATE TABLE login (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    username NVARCHAR(30) NOT NULL,
    password NVARCHAR(30) NOT NULL
);
GO

-- Dumping data for table `login`
INSERT INTO login (username, password) VALUES
('admin', 'admin123'),
('mahasiswa', 'mhs456'),
('dosen', 'dosen789');
GO

-- Table structure for table `pedoman`
CREATE TABLE pedoman (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    pelanggaran NVARCHAR(MAX) NOT NULL,
    tingkat NVARCHAR(5) NOT NULL
);
GO

-- Dumping data for table `pedoman`
INSERT INTO pedoman (pelanggaran, tingkat) VALUES
('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain ', 'V'),
('Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana ', 'IV'),
('Mahasiswa laki-laki berambut tidak rapi, gondrong yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping atau menyentuh kerah baju di bagian leher ', 'IV'),
('Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned. ', 'IV'),
('Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel. ', 'IV'),
('Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi ', 'III'),
('Tidak menjaga kebersihan di seluruh area Polinema', 'III'),
('Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung. ', 'III'),
('Merokok di luar area kawasan merokok ', 'III'),
('Bermain kartu, game online di area kampus ', 'III'),
('Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema ', 'III'),
('Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan. ', 'III'),
('Merusak sarana dan prasarana yang ada di area Polinema ', 'II'),
('Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll) ', 'II'),
('Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang ', 'II'),
('Mengakses materi pornografi di kelas atau area kampus ', 'II'),
('Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal ', 'II'),
('Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', 'II'),
('Melakukan kegiatan politik praktis di dalam kampus ', 'II'),
('Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', 'II'),
('Melakukan penyalahgunaan identitas untuk perbuatan negatif ', 'II'),
('Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan. ', 'II'),
('Mencuri dalam bentuk apapun', 'I/ II'),
('Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan. ', 'I/ II'),
('Melakukan pemerasan dan/atau penipuan ', 'I/ II'),
('Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus ', 'I/ II'),
('Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema ', 'I/ II'),
('Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 'I/ II'),
('Melakukan pemalsuan data / dokumen / tanda tangan. ', 'I/ II'),
('Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah', 'I/ II'),
('Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun', 'I'),
('Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema. ', 'I'),
('Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya ', 'I'),
('Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya ', 'I'),
('Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan ', 'I');
GO
