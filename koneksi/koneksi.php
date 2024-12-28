<?php
// Konfigurasi database
$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server dari gambar
$database = "PBL"; // Ganti dengan nama database Anda
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);

    // Mengatur mode error PDO ke Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Debug jika koneksi berhasil
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Menampilkan pesan error jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}
?>
