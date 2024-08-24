<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once ("./Database.php");
$database = new Database();
$db = $database->getConnection();
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . "/ppdb_fin";

$query = "SELECT *
          FROM data_siswa a
          INNER JOIN data_orang_tua b ON a.id = b.id_siswa
          INNER JOIN data_wali c ON a.id = c.id_siswa
          INNER JOIN data_berkas d ON a.id = d.id_siswa
          INNER JOIN status_pendaftaran e ON a.id = e.id_siswa";
$stmt = $db->prepare($query);
$stmt->execute();
$data_peserta_ppdb = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$col = 'A';
foreach ($data_peserta_ppdb[0] as $key => $value) {
    $sheet->setCellValue($col . '1', $key);
    $col++;
}

$row = 2;
foreach ($data_peserta_ppdb as $peserta) {
    $col = 'A';
    foreach ($peserta as $key => $value) {
        if (in_array($key, ['foto_kk_ktp_akta_kelahiran', 'foto_pkh_kis_kks', 'foto_rapor'])) {
            $value = $domain . '/uploads/data-berkas/' . $peserta['nisn'] . "/"  . $value;
        }
        $sheet->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'laporan_peserta_ppdb.xlsx';
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
