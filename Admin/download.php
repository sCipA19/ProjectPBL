<?php
$serverName = "BEBI\\DBMS22";
$database = "PBL";
$username = "";
$password = "";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id_tatib'])) {
        $id_tatib = intval($_GET['id_tatib']);

        $sql = "SELECT pengumpulan, nama_file, tipe_file FROM tb_kelolatatib WHERE id_tatib = :id_tatib";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_tatib', $id_tatib);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            header("Content-Type: " . $row['tipe_file']);
            header("Content-Disposition: attachment; filename=" . $row['nama_file']);
            echo $row['pengumpulan'];
            exit;
        } else {
            echo "File tidak ditemukan.";
        }
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
