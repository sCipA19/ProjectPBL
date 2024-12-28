<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Login/index2.php");
    exit();
}

$serverName = "BEBI\\DBMS22";  // Nama server SQL Server
$database = "PBL";  // Nama database
$username = "";  // Kosongkan untuk Windows Authentication
$password = "";  // Kosongkan untuk Windows Authentication

try {
    // Membuat koneksi menggunakan PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data yang dikirimkan dari frontend
    $data = json_decode(file_get_contents('php://input'), true);
    $nim = $data['nim'];  // NIM mahasiswa
    $idTatib = $data['id_tatib'];  // ID Tata Tertib
    $action = $data['action'];  // Tindakan yang diterima ('accept' atau 'reject')

    // Proses untuk menerima laporan (status_id = 3) dan set pesan ke NULL
    if ($action === 'accept') {
        // Query untuk memperbarui status_id menjadi 3 dan menghapus pesan
        $sql = "UPDATE tb_kelolatatib 
                SET status_id = 3, pesan = NULL 
                WHERE id_tatib = :id_tatib";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_tatib', $idTatib, PDO::PARAM_INT);
        $stmt->execute();  // Menjalankan query

        echo json_encode(['status' => 'success']);
    } 
    // Proses untuk menolak laporan (status_id = 2)
    elseif ($action === 'reject') {
        $reason = $data['reason'];  // Alasan penolakan

        // Query untuk memperbarui status_id menjadi 2 dan menyimpan alasan penolakan
        $sql = "UPDATE tb_kelolatatib 
                SET status_id = 2, pengumpulan = NULL, nama_file = NULL, pesan = :pesan 
                WHERE id_tatib = :id_tatib";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pesan', $reason, PDO::PARAM_STR);
        $stmt->bindParam(':id_tatib', $idTatib, PDO::PARAM_INT);
        $stmt->execute();  // Menjalankan query

        echo json_encode(['status' => 'success']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    die();  // Menghentikan eksekusi jika terjadi error
}
?>
