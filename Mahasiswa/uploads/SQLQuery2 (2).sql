
USE PBL;
-- tabel mahasiswa --
CREATE TABLE tb_kelas (
id_kls int primary key,
 nama_kls varchar(10) 
);

insert into tb_kelas(id_kls, nama_kls)  values
(11, 'SIB 1A'),
(12, 'SIB 1F'),
(13, 'SIB 2A'),
(14, 'SIB 2E'),
(15, 'SIB 3A'),
(16, 'SIB 3C'),
(17, 'TI 1G'),
(18, 'TI 2H');
 


-- tabel login

CREATE TABLE tb_login (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    username NVARCHAR(30) NOT NULL,
    password NVARCHAR(30) NOT NULL,
	role varchar(15)
);
GO

INSERT INTO tb_login (username, password, role) VALUES
--('admin', 'admin123', 'admin'),
--('mahasiswa', 'mhs456','mahasiswa'),
--('dosen', 'dosen789','dosen'),
('dosennn', 'dosen78989','dosen');
GO
select * from tb_login;
delete from tb_login where no in(4,5,6,7,8);
select * from tb_login;
CREATE TABLE notifikasi (
    id INT PRIMARY KEY IDENTITY(1,1),
    nim VARCHAR(15),
    pesan VARCHAR(255),
    waktu DATETIME,
    status VARCHAR(20) DEFAULT 'unread'
);

CREATE TABLE notifikasi (
    id INT PRIMARY KEY IDENTITY(1,1),
    nim VARCHAR(15),
    pesan VARCHAR(255),
    waktu DATETIME,
    status VARCHAR(20) DEFAULT 'unread'
);
INSERT INTO notifikasi (nim, pesan, waktu, status)
VALUES 
    ('2341760007', 'Anda memiliki pelanggaran baru.', '2024-12-12 10:00:00', 'unread'),
    ('2341760008', 'Pengumpulan dokumen telah diterima.', '2024-12-10 14:30:00', 'read'),
    ('2341760009', 'Harap segera lengkapi berkas Anda.', '2024-12-13 09:00:00', 'unread');
SELECT * FROM notifikasi;
drop table pelanggaran;
CREATE TABLE pelanggaran (
 
drop table pelanggaran;
SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'pelanggaran';
CREATE TABLE pelanggaran (
    id INT PRIMARY KEY IDENTITY(1,1),
    nim NVARCHAR(15) NOT NULL,
    nama NVARCHAR(100) NOT NULL,
    pelanggaran NVARCHAR(255),
    tingkat_pelanggaran NVARCHAR(50),
    kompensasi NVARCHAR(255),
    tenggat_waktu DATE,
    created_at DATETIME DEFAULT GETDATE()
);
INSERT INTO pelanggaran (nim, nama, pelanggaran, tingkat_pelanggaran, kompensasi, tenggat_waktu)
VALUES
('2341760007', 'My Babby Findia', 'Tidak memakai atribut lengkap', 'Ringan', 'Membuat esai 500 kata', '2024-12-20'),
('2341760008', 'Budi Santoso', 'Terlambat masuk kelas', 'Sedang', 'Membersihkan ruang kelas', '2024-12-15'),
('2341760009', 'Siti Aminah', 'Melanggar aturan parkir', 'Berat', 'Mengikuti pelatihan disiplin', '2024-12-25');

-- Tabel Admin --

CREATE TABLE tb_dosen (
    id_dosen INT not null primary key identity (1,1), -- Auto increment ID
    nip NVARCHAR(20) NOT NULL,             -- Kolom NIP
    nama_dosen NVARCHAR(100) NOT NULL,     -- Kolom Nama
    jabatan_fungsional NVARCHAR(50) NOT NULL, -- Kolom Jabatan Fungsional
    status NVARCHAR(20) NOT NULL,           -- Kolom Status (Aktif/Nonaktif)
	id_login int foreign key references tb_login(no)
);

INSERT INTO tb_dosen (nip,  nama_dosen,jabatan_fungsional, status, id_login) VALUES
( '1234567', 'Dr.Fufufafa', 'rektor', 'aktif', 3),
('2345678', 'Prof. Budi Santoso', 'dekan', 'aktif', 4),
('3456789', 'Dr. Siti Nurhaliza', 'ketua prodi', 'non-aktif', 9);

drop table tb_dosen;

select * from tb_dosen;
select * from tb_login;



CREATE TABLE tb_mahasiswa (
    id_mahasiswa INT PRIMARY KEY IDENTITY(1,1), -- ID unik untuk mahasiswa
    no INT NOT NULL,                            -- Nomor urut (dihitung manual)
    nim VARCHAR(15) NOT NULL,                   -- Nomor Induk Mahasiswa
    nama NVARCHAR(100) NOT NULL,                -- Nama Mahasiswa
    kelas NVARCHAR(20),                         -- Kelas mahasiswa
    aksi NVARCHAR(50),                          -- Placeholder untuk aksi
    id_kls INT,                                 -- ID kelas untuk relasi
    FOREIGN KEY (id_kls) REFERENCES tb_kelas(id_kls)
);


select * from tb_mahasiswa;


CREATE TABLE tb_pelanggaran (
    id_pelanggaran INT PRIMARY KEY,  -- ID pelanggaran sebagai primary key
    id_mahasiswa INT,                     -- ID mahasiswa sebagai foreign key
    id_dosen INT,                   -- ID dosen sebagai foreign key
    id_kls INT,                     -- ID kelas sebagai foreign key
    no INT,                          -- Nomor
    nim VARCHAR(20),                 -- NIM mahasiswa
    nama_mahasiswa VARCHAR(100),     -- Nama mahasiswa
    kelas VARCHAR(20),               -- Kelas mahasiswa
    pelanggaran TEXT,                -- Deskripsi pelanggaran
    tingkat VARCHAR(50),             -- Tingkat pelanggaran
    status VARCHAR(50),              -- Status pelanggaran
    FOREIGN KEY (id_mahasiswa) REFERENCES tb_mahasiswa(id_mahasiswa),  -- Menghubungkan dengan tabel mahasiswa
    FOREIGN KEY (id_dosen) REFERENCES tb_dosen(id_dosen),  -- Menghubungkan dengan tabel dosen
    FOREIGN KEY (id_kls) REFERENCES tb_kelas(id_kls)       -- Menghubungkan dengan tabel kelas
);

select* from tb_pelanggaran;

CREATE TABLE tb_kelolatatib (
    id_tatib INT IDENTITY(1,1) PRIMARY KEY,  -- Auto increment
    id_mahasiswa INT NOT NULL,
    id_kls INT NOT NULL,
    id_dosen INT NOT NULL,
    nim VARCHAR(20) NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    kelas VARCHAR(20),
    pelanggaran VARCHAR(255),
    tingkat VARCHAR(10),
    bukti VARCHAR(255), -- Path file bukti pelanggaran
    FOREIGN KEY (id_mahasiswa) REFERENCES tb_mahasiswa(id_mahasiswa),
    FOREIGN KEY (id_kls) REFERENCES tb_kelas(id_kls),
    FOREIGN KEY (id_dosen) REFERENCES tb_dosen(id_dosen)
);


select * from tb_kelolatatib;
drop table tb_kelolatatib;

CREATE TABLE tb_kelolaedit (
    id_kelolaedit INT IDENTITY(1,1) PRIMARY KEY,  -- Primary key dengan auto increment
    id_mahasiswa INT NOT NULL,  -- Foreign key ke tb_mahasiswa
    id_kls INT NOT NULL,        -- Foreign key ke tb_kelas
    id_pelanggaran INT NOT NULL, -- Foreign key ke tb_pelanggaran
    nama_mahasiswa VARCHAR(100),
    nim VARCHAR(20),
    kelas VARCHAR(20),
    pelanggaran VARCHAR(255),
    tingkat_pelanggaran VARCHAR(10),
    nama_file VARCHAR(255) NOT NULL,  -- Kolom nama file
    lokasi_file VARCHAR(255) NOT NULL,  -- Kolom lokasi file
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Default timestamp saat upload
    FOREIGN KEY (id_mahasiswa) REFERENCES tb_mahasiswa(id_mahasiswa),  -- Foreign key ke tb_mahasiswa
    FOREIGN KEY (id_kls) REFERENCES tb_kelas(id_kls),  -- Foreign key ke tb_kelas
    FOREIGN KEY (id_pelanggaran) REFERENCES tb_pelanggaran(id_pelanggaran)  -- Foreign key ke tb_pelanggaran
);

select * from tb_mahasiswa;
select * from tb_kelolaedit;
SELECT * FROM tb_kelolatatib;


SELECT id_tatib, nim, tahun_ajaran, nama_mahasiswa, kelas, pelanggaran, tingkat 
FROM tb_kelolatatib;

-- Mengubah username untuk admin
UPDATE tb_login
SET username = 'admin@polinema.ac.id'
WHERE username = 'admin';

-- Mengubah username untuk dosen menjadi 0987
UPDATE tb_login
SET username = '0987'
WHERE username = 'dosen';
select *from tb_login;
select *from tb_mahasiswa;

select *from tb_dosen;















SELECT m.id_mhs, m.nama_mhs, m.nim, k.nama_kls
FROM tb_mahasiswa m
JOIN tb_kelas k ON m.id_kls = k.id_kls;

ALTER TABLE tb_mahasiswa
ADD nama_kls NVARCHAR(50);

SELECT m.id_mhs, m.nama_mhs, m.nim, k.nama_kls
FROM tb_mahasiswa m
JOIN tb_kelas k ON m.id_kls = k.id_kls;

UPDATE m
SET m.nama_kls = k.nama_kls
FROM tb_mahasiswa m
JOIN tb_kelas k ON m.id_kls = k.id_kls;

select * from tb_mahasiswa;
ALTER TABLE tb_mahasiswa
DROP COLUMN id_kls;










select *from tb_mahasiswa;
INSERT INTO tb_mahasiswa (no, nim, nama, kelas, aksi, id_kls)
VALUES
(1, '2024101001', 'Ali Akbar', 'SIB 1A', 'Aktif', 1),
(2, '2024101002', 'Budi Santoso', 'SIB 1A', 'Aktif', 1),
(3, '2024101003', 'Citra Wulandari', 'SIB 1B', 'Aktif', 2),
(4, '2024101004', 'Dina Kurnia', 'SIB 1B', 'Aktif', 2),
(5, '2024101005', 'Eko Prasetyo', 'SIB 1C', 'Aktif', 3),
(6, '2024101006', 'Fira Dwi', 'SIB 1C', 'Aktif', 3),
(7, '2024101007', 'Gina Amelia', 'SIB 1D', 'Aktif', 4),
(8, '2024101008', 'Hadi Firmansyah', 'SIB 1D', 'Aktif', 4),
(9, '2024101009', 'Indah Rahayu', 'SIB 1E', 'Aktif', 5),
(10, '2024101010', 'Joko Susilo', 'SIB 1E', 'Aktif', 5);



select *from tb_kelas;

INSERT INTO tb_kelas (id_kls, nama_kls)
VALUES
(1, 'SIB 1A'),
(2, 'SIB 1B'),
(3, 'SIB 1C'),
(4, 'SIB 1D'),
(5, 'SIB 1E'),
(6, 'SIB 1F'),
(7, 'SIB 1G'),
(8, 'SIB 2A'),
(9, 'SIB 2B'),
(10, 'SIB 2C'),
(11, 'SIB 2D'),
(12, 'SIB 2E'),
(13, 'SIB 2F'),
(14, 'SIB 2G'),
(15, 'SIB 3A'),
(16, 'SIB 3B'),
(17, 'SIB 3C'),
(18, 'SIB 3D'),
(19, 'SIB 3E'),
(20, 'SIB 3F'),
(21, 'SIB 3G'),
(22, 'SIB 4A'),
(23, 'SIB 4B'),
(24, 'SIB 4C'),
(25, 'SIB 4D'),
(26, 'SIB 4E'),
(27, 'SIB 4F'),
(28, 'SIB 4G');

-- Tabel Dosen --



CREATE TABLE sanksi (
    id_sanksi INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    tingkat VARCHAR(5),
    sanksi VARCHAR(255)
);

insert into sanksi (tingkat, sanksi) values 
('V','Teguran lisan disertai dengan surat pernyataan tidak mengulangi perbuatan 
tersebut, dibubuhi materai'),
('IV','Teguran tertulis disertai dengan pemanggilan orang tua/wali dan membuat 
surat pernyataan tidak mengulangi perbuatan tersebut'),
('III','Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibutuhi 
materai ditandatangani mahasiswa, orang tua/wali, dan DPA & Melakukan tugas khusus, misalnya bertanggungjawab untuk memperbaiki 
atau membersihkan kembali, dan tugas-tugas lainnya. '),
('II','Dikenakan penggantian kerugian atau penggantian benda/ barang 
semacamnya dan/atau, Melakukan tugas layanan sosial dalam jangka waktu tertentu dan/atau, Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran. '),
('I','. Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester 
dan/atau, Diberhentikan sebagai mahasiswa. ');


CREATE TABLE pedoman (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    pelanggaran NVARCHAR(MAX) NOT NULL,
    tingkat NVARCHAR(5) NOT NULL
);
GO

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


CREATE TABLE laporan (
    id_laporan INT identity(1,1) NOT NULL PRIMARY KEY ,
    id_mhs INT FOREIGN KEY REFERENCES tb_mahasiswa(id_mahasiswa),
    id_dosen INT FOREIGN KEY REFERENCES tb_dosen(id_dosen),
    nim NVARCHAR(15) NOT NULL,
    nama_mhs NVARCHAR(50) NOT NULL,
    kelas NVARCHAR(10) NOT NULL,
    pelanggaran NVARCHAR(255) NOT NULL,
    -- tingkat NVARCHAR(5) NOT NULL,
    kejadian NVARCHAR(50) NOT NULL,
    dosen_yang_lapor NVARCHAR(50) NOT NULL,
	tanggal_laporan datetime
);

INSERT INTO laporan (id_mhs, id_dosen, nim, nama_mhs, kelas, pelanggaran,  kejadian, dosen_yang_lapor) VALUES
(101, 2, '2245760250', 'Bagas Putra Sofyan', 16 , 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 'di lihat langsung', 'H. Jainal, S.Kom., M.Kom.'),
(102, 2, '2445760090', 'Daffa Athallah Erlangga', 12 , 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', 'terlihat cctv', 'H. Jainal, S.Kom., M.Kom.');


 
CREATE TABLE dosen (
    id_dosen INT not NULL primary key,
    nama_dosen NVARCHAR(100) NOT NULL,
    nip NVARCHAR(15) NOT NULL,
	id int foreign key references tb_login(no)
);



GO

delete from login where no in(9);




select * from pedoman;
select * from tb_dosen;
select * from mahasiswa;
select * from laporan;
select * from kelas;
drop table login;
drop table pedoman;
 drop table dosen;
drop table mahasiswa;
drop table laporan;

ALTER TABLE login
ADD role NVARCHAR(20) NOT NULL DEFAULT 'mahasiswa';
GO

UPDATE login
SET role = 'admin'
WHERE username = 'admin';

UPDATE login
SET role = 'dosen'
WHERE username = 'dosen';

UPDATE login
SET role = 'mahasiswa'
WHERE username = 'mahasiswa';

UPDATE login
SET role = 'dosenn'
WHERE username = 'dosenn';

	
CREATE VIEW laporan_view AS
	SELECT 
    l.nim, 
	l.id_dosen,
    l.nama_mhs, 
    k.nama_kls AS nama_kelas, 
    l.pelanggaran, 
    l.tanggal_laporan
FROM laporan l
JOIN kelas k
ON l.kelas = k.id_kls;


	select *from laporan_view;

	drop view laporan_view;

CREATE TABLE tb_laporan_pelanggaran_dosen (
    id_laporan INT IDENTITY(1,1) PRIMARY KEY,   -- Auto-increment ID for the report
    id_mahasiswa INT NOT NULL,                   -- ID of the student (foreign key)
    id_dosen INT NOT NULL,                       -- ID of the lecturer (foreign key)
    nama_mahasiswa NVARCHAR(100) NOT NULL,       -- Name of the student
    kelas_mahasiswa NVARCHAR(50) NOT NULL,       -- Class of the student
    nama_pelanggaran NVARCHAR(255) NOT NULL,     -- Name of the violation (as an option)
    deskripsi_pelanggaran NVARCHAR(255),         -- Description of the violation
    FOREIGN KEY (id_mahasiswa) REFERENCES tb_mahasiswa(id_mahasiswa),  -- Foreign key for student
    FOREIGN KEY (id_dosen) REFERENCES tb_dosen(id_dosen)               -- Foreign key for lecturer
);


INSERT INTO tb_laporan_pelanggaran_dosen (id_mahasiswa, id_dosen, nama_mahasiswa, kelas_mahasiswa, nama_pelanggaran, deskripsi_pelanggaran)
VALUES (1, 1, 'My Babby Findia', 'SIB 2A', 'Tidak Mengikuti Mata Kuliah', 'Mahasiswa tidak hadir dalam mata kuliah selama seminggu berturut-turut'),
(2, 4, 'Syifa Revalina', 'SIB 2B', 'Plagiarisme dalam Tugas', 'Mahasiswa melakukan plagiarisme dalam penulisan tugas akhir tanpa memberikan sumber yang jelas');



select *from tb_laporan_pelanggaran_dosen;













 










