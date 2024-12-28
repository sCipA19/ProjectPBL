<?php
// Update status menjadi dibaca
if (isset($_POST['nim'])) {
    $nim = $_POST['nim'];

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update status laporan menjadi dibaca
        $sql_update = "UPDATE tb_laporan_pelanggaran_dosen SET is_read = 1 WHERE nim = :nim";
        $stmt = $conn->prepare($sql_update);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();

        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
