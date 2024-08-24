<?php
include_once './Database.php';
session_start();

$database = new Database();
$db = $database->getConnection();

$id = htmlspecialchars(strip_tags($_GET["id"]));

$query = "DELETE FROM data_siswa WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $_SESSION["message"] = "Pendaftaran Berhasil Dihapus";
} else {
    $_SESSION["message"] = "Pendaftaran Gagal Dihapus";
}

header("Location: ../admin");
exit;
?>
