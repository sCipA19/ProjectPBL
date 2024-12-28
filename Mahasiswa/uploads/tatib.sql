-- SQL Server Script

USE PBL;
GO


CREATE TABLE login (
    no INT NOT NULL PRIMARY KEY IDENTITY(1,1),
    username NVARCHAR(30) NOT NULL,
    password NVARCHAR(30) NOT NULL,
	role varchar(15)
);
GO


INSERT INTO login (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('mahasiswa', 'mhs456','mahasiswa'),
('dosen', 'dosen789','dosen'),
('dosenn', 'dosen7899','dosenn');
GO


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
    id_mhs INT FOREIGN KEY REFERENCES mahasiswa(id_mhs),
    id_dosen INT FOREIGN KEY REFERENCES dosen(id_dosen),
    nim NVARCHAR(15) NOT NULL,
    nama_mhs NVARCHAR(50) NOT NULL,
    kelas NVARCHAR(10) NOT NULL,
    pelanggaran NVARCHAR(255) NOT NULL,
    tingkat NVARCHAR(5) NOT NULL,
    kejadian NVARCHAR(50) NOT NULL,
    dosen_yang_lapor NVARCHAR(50) NOT NULL,
	tanggal_laporan datetime

);

INSERT INTO laporan (id_mhs, id_dosen, nim, nama_mhs, kelas, pelanggaran, tingkat, kejadian, dosen_yang_lapor) VALUES
(101, 2, '2245760250', 'Bagas Putra Sofyan', 'SIB 3C', 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus','I', 'di lihat langsung', 'H. Jainal, S.Kom., M.Kom.'),
(102, 2, '2445760090', 'Daffa Athallah Erlangga', 'SIB 1F', 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema','III', 'terlihat cctv', 'H. Jainal, S.Kom., M.Kom.');

CREATE TABLE kelas (
id_kls int primary key,
 nama_kls varchar(10) 
);
drop table kelas;
insert into kelas(id_kls, nama_kls)  values
(11, 'SIB 1A'),
(12, 'SIB 1F'),
(13, 'SIB 2A'),
(14, 'SIB 2E'),
(15, 'SIB 3A'),
(16, 'SIB 3C'),
(17, 'TI 1G'),
(18, 'TI 2H');
 
CREATE TABLE mahasiswa (
    id_mhs INT NOT NULL primary key,
    nama_mhs NVARCHAR(50) NOT NULL,
    nim NVARCHAR(15) NOT NULL,
    id_kls int NOT NULL foreign key references kelas (id_kls));
GO

INSERT INTO mahasiswa (id_mhs, nama_mhs, nim,id_kls) VALUES
(101, 'Bagas Putra Sofyan', '2245760250', 16),
(102, 'Daffa Athallah Erlangga', '2445760090', 12),
(103, 'My Baby Findia Revalina', '2234567809',17),
(104, 'Haikal Nurmantiyo','2456347818',11),
(105, 'Bagas Hasan','2243534897',15),
(106, 'Jumantyo Nurhahaha', '2341780170', 18),
(107, 'Asep Junaidi', '2357498730', 14),
(108, 'Rizky Findia Yahya', '2243465678', 13)
;
GO

CREATE TABLE dosen (
    id_dosen INT not NULL primary key,
    nama_dosen NVARCHAR(100) NOT NULL,
    nip NVARCHAR(15) NOT NULL,
	id_login int foreign key references login(no)
);


INSERT INTO dosen (id_dosen, nama_dosen, nip, id_login) VALUES
(1, 'Dr.Fufufafa', '1234567', 3),
(2, 'H. Jainal, S.Kom., M.Kom.', '1234568', 4);
GO



select * from login;
select * from pedoman;
select * from dosen;
select * from mahasiswa;
select * from laporan;
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
    laporan.id_mhs,
	laporan.id_dosen,
    laporan.nim,
    laporan.nama_mhs,
    kelas.nama_kls AS nama_kelas,
    laporan.pelanggaran,
    laporan.tingkat,
    laporan.kejadian,
    laporan.dosen_yang_lapor
FROM 
    laporan
JOIN 
    kelas
ON 
    laporan.kelas = kelas.nama_kls;


	
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

	delete from laporan where id_laporan = 2

	truncate table laporan;