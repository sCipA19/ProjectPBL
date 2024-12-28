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

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_laporan = $_GET['id'];

    // Query untuk menghapus laporan berdasarkan id_laporan
    $sqlDelete = "DELETE FROM tb_laporan_pelanggaran_dosen WHERE id_laporan = :id_laporan";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id_laporan', $id_laporan, PDO::PARAM_INT);

    // Eksekusi query dan redirect ke halaman dashboard
    if ($stmtDelete->execute()) {
        header("Location: dashbroad.php");
        exit();
    } else {
        echo "Gagal menghapus laporan.";
    }
} else {
    echo "ID laporan tidak ditemukan.";
}
?>
