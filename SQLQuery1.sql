USE PBL;

SELECT table_name
FROM INFORMATION_SCHEMA.TABLES
WHERE table_type = 'BASE TABLE';

-- Membuat ulang tabel
-- Tabel login
CREATE TABLE tb_login (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    username NVARCHAR(30) NOT NULL,
    password NVARCHAR(30) NOT NULL,
    role VARCHAR(15)
);

INSERT INTO tb_login (username, password, role) VALUES
('admin@polinema.ac.id', 'admin123', 'admin'),
('2345', 'mhs456','mahasiswa'),
('0987', 'dosen789','dosen');

-- Tabel Dosen
CREATE TABLE tb_dosen (
    id_dosen INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    nip NVARCHAR(20) NOT NULL,
    nama_dosen NVARCHAR(100) NOT NULL,
    jabatan_fungsional NVARCHAR(50) NOT NULL,
    status NVARCHAR(20) NOT NULL
);

-- Tabel Mahasiswa
CREATE TABLE tb_mahasiswa (
    id_mahasiswa INT PRIMARY KEY IDENTITY(1,1),
    nim VARCHAR(15) NOT NULL,
    nama NVARCHAR(100) NOT NULL,
    kelas NVARCHAR(20)
);

-- Tabel Status Laporan
CREATE TABLE tb_status_laporan (
    status_id INT IDENTITY(1,1) PRIMARY KEY,
    status_name NVARCHAR(50) NOT NULL
);

INSERT INTO tb_status_laporan (status_name) VALUES
('Belum Selesai'),
('Proses'),
('Selesai');

-- Tabel Kelola Tata Tertib
CREATE TABLE tb_kelolatatib (
    id_tatib INT IDENTITY(1,1) PRIMARY KEY,
    nim NVARCHAR(20) NOT NULL,
    nama_mahasiswa NVARCHAR(100) NOT NULL,
    kelas NVARCHAR(20),
    pelanggaran NVARCHAR(255),
    tingkat NVARCHAR(10),
    kompensasi NVARCHAR(250),
    tenggat DATE NOT NULL,
    pengumpulan VARBINARY(MAX),
    nama_file NVARCHAR(255),
    tipe_file NVARCHAR(50),
    status_id INT,
    pesan NVARCHAR(50),
    FOREIGN KEY (status_id) REFERENCES tb_status_laporan(status_id)
);

-- Tabel Laporan Pelanggaran Dosen
CREATE TABLE tb_laporan_pelanggaran_dosen (
    id_laporan INT IDENTITY(1,1) PRIMARY KEY,
    nim NVARCHAR(20) NOT NULL,
    nama_mahasiswa NVARCHAR(100) NOT NULL,
    kelas_mahasiswa NVARCHAR(50) NOT NULL,
    nama_pelanggaran NVARCHAR(255) NOT NULL,
    deskripsi_pelanggaran NVARCHAR(255),
    status_id INT NOT NULL DEFAULT 1,
    is_read BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (status_id) REFERENCES tb_status_laporan(status_id)
);

select * from tb_kelolatatib;
select * from tb_laporan_pelanggaran_dosen;
select * from tb_mahasiswa;
select * from tb_status_laporan;
select * from tb_login;




















 










