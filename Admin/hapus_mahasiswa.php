<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index2.php");
    exit();
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server Anda
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

// Mengambil ID dosen dari URL
$id_dosen = $_GET['id_mahasiswa'];

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk menghapus dosen berdasarkan ID
    $sql = "DELETE FROM tb_mahasiswa WHERE id_mahasiswa = :id_mahasiswa";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_mahasiswa', $id_dosen, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect kembali ke halaman tabel dosen setelah data terhapus
    header("Location: tabelmahasiswa.php");
    exit();
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
