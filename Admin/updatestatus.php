<?php
// updatestatus.php
session_start();

if (!isset($_SESSION['username'])) {
    die("Unauthorized access");
}

$serverName = "BEBI\\DBMS22"; // Ganti dengan nama server Anda
$database = "PBL";
$username = ""; // Kosongkan karena menggunakan Windows Authentication
$password = ""; // Kosongkan karena menggunakan Windows Authentication

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nim = $_POST['nim'] ?? null;
    
        if (!$nim) {
            echo json_encode(["status" => "error", "message" => "NIM tidak diterima"]);
            exit();
        }

        // Update status ke 'Selesai' (status_id = 2) jika belum diproses
        $sql = "UPDATE tb_laporan_pelanggaran_dosen SET status_id = 2 WHERE nim = :nim AND status_id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Tidak ada data yang diperbarui."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}


?>
