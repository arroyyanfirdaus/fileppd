<?php

include_once './Database.php';
include_once './kirimEmail.php';
session_start();

function getData($array, $key, $default = '')
{
    return isset($array[$key]) ? htmlspecialchars(strip_tags($array[$key])) : $default;
}

function uploadFile($file, $uploadDir, $key)
{
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $originalFileName = basename($file['name']);
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $timestamp = time();
    $newFileName = $timestamp . '_' . $key . '_' . $originalFileName;
    $targetFilePath = $uploadDir . $newFileName;

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        return '';
    }

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $newFileName;
    } else {
        return '';
    }
}

function updateData($db, $query, $params)
{
    $stmt = $db->prepare($query);
    foreach ($params as $key => &$value) {
        $stmt->bindParam($key, $value);
    }
    return $stmt->execute();
}

$id = getData($_POST, 'id');
$nisn = getData($_POST, 'nisn');
$uploadDir = '../uploads/data-berkas/' . $nisn . "/";
$database = new Database();
$db = $database->getConnection();

$queryGetBerkas = "SELECT * FROM data_berkas WHERE id_siswa = :id_siswa";
$stmt = $db->prepare($queryGetBerkas);
$stmt->bindParam(':id_siswa', $id);
$stmt->execute();
$existingBerkas = $stmt->fetch(PDO::FETCH_ASSOC);

$uploadedFiles = [
    'foto_kk_ktp_akta_kelahiran' => '',
    'foto_pkh_kis_kks' => '',
    'foto_rapor' => ''
];

foreach ($uploadedFiles as $key => &$value) {
    if (!empty($_FILES[$key]['name'])) {
        $existingFilePath = isset($existingBerkas[$key]) ? $uploadDir . $existingBerkas[$key] : '';
        if (!empty($existingFilePath) && file_exists($existingFilePath)) {
            unlink($existingFilePath);
        }

        $value = uploadFile($_FILES[$key], $uploadDir, $key);
    } else {
        $value = isset($existingBerkas[$key]) ? $existingBerkas[$key] : '';
    }
}


$formData = [
    'id' => $id,
    'nisn' => $nisn,
    'nama_siswa' => getData($_POST, 'nama_siswa'),
    'nik' => getData($_POST, 'nik'),
    'jenis_kelamin' => getData($_POST, 'jenis_kelamin'),
    'tempat_lahir' => getData($_POST, 'tempat_lahir'),
    'tgl_lahir' => getData($_POST, 'tanggal_lahir'),
    'agama' => getData($_POST, 'nama_agama'),
    'golongan_darah' => getData($_POST, 'golongan_darah'),
    'alamat' => getData($_POST, 'alamat_siswa'),
    'email_siswa' => getData($_POST, 'email_siswa'),
    'rumah_milik' => getData($_POST, 'rumah_milik'),
    'no_telp_rumah' => getData($_POST, 'no_telp_rumah'),
    'no_telp_siswa' => getData($_POST, 'no_telp_siswa'),
    'asal_sekolah' => getData($_POST, 'asal_sekolah'),
    'alamat_asal_sekolah' => getData($_POST, 'alamat_asal_sekolah'),
    'jurusan' => getData($_POST, 'nama_jurusan'),
    'nama_ayah' => getData($_POST, 'nama_ayah'),
    'pekerjaan_ayah' => getData($_POST, 'pekerjaan_ayah'),
    'nama_ibu' => getData($_POST, 'nama_ibu'),
    'pekerjaan_ibu' => getData($_POST, 'pekerjaan_ibu'),
    'no_telepon_ortu' => getData($_POST, 'no_telp_ortu'),
    'nama_wali' => getData($_POST, 'nama_wali'),
    'pekerjaan_wali' => getData($_POST, 'pekerjaan_wali'),
    'alamat_wali' => getData($_POST, 'alamat_wali'),
    'no_telepon_wali' => getData($_POST, 'no_telepon_wali'),
    'prestasi' => getData($_POST, 'prestasi'),
    'hobi' => getData($_POST, 'hobi'),
    'catatan_panitia' => getData($_POST, 'catatan_panitia'),
    'status' => getData($_POST, 'status'),
    'foto_kk_ktp_akta_kelahiran' => $uploadedFiles['foto_kk_ktp_akta_kelahiran'],
    'foto_pkh_kis_kks' => $uploadedFiles['foto_pkh_kis_kks'],
    'foto_rapor' => $uploadedFiles['foto_rapor']
];

try {
    $db->beginTransaction();

    $querySiswa = "UPDATE data_siswa SET
        nisn = :nisn,
        nama_siswa = :nama_siswa,
        nik = :nik,
        jenis_kelamin = :jenis_kelamin,
        tempat_lahir = :tempat_lahir,
        tgl_lahir = :tgl_lahir,
        agama = :agama,
        golongan_darah = :golongan_darah,
        alamat = :alamat,
        email_siswa = :email_siswa,
        rumah_milik = :rumah_milik,
        no_telp_rumah = :no_telp_rumah,
        no_telp_siswa = :no_telp_siswa,
        asal_sekolah = :asal_sekolah,
        alamat_asal_sekolah = :alamat_asal_sekolah,
        jurusan = :jurusan,
        prestasi = :prestasi,
        hobi = :hobi
    WHERE id = :id";

    $paramsSiswa = [
        ':id' => $formData['id'],
        ':nisn' => $formData['nisn'],
        ':nama_siswa' => $formData['nama_siswa'],
        ':nik' => $formData['nik'],
        ':jenis_kelamin' => $formData['jenis_kelamin'],
        ':tempat_lahir' => $formData['tempat_lahir'],
        ':tgl_lahir' => $formData['tgl_lahir'],
        ':agama' => $formData['agama'],
        ':golongan_darah' => $formData['golongan_darah'],
        ':alamat' => $formData['alamat'],
        ':email_siswa' => $formData['email_siswa'],
        ':rumah_milik' => $formData['rumah_milik'],
        ':no_telp_rumah' => $formData['no_telp_rumah'],
        ':no_telp_siswa' => $formData['no_telp_siswa'],
        ':asal_sekolah' => $formData['asal_sekolah'],
        ':alamat_asal_sekolah' => $formData['alamat_asal_sekolah'],
        ':jurusan' => $formData['jurusan'],
        ':prestasi' => $formData['prestasi'],
        ':hobi' => $formData['hobi']
    ];

    if (updateData($db, $querySiswa, $paramsSiswa)) {
        $idSiswa = $formData['id'];

        $queryOrangTua = "UPDATE data_orang_tua SET
            nama_ayah = :nama_ayah,
            pekerjaan_ayah = :pekerjaan_ayah,
            nama_ibu = :nama_ibu,
            pekerjaan_ibu = :pekerjaan_ibu,
            no_telepon_ortu = :no_telepon_ortu
        WHERE id_siswa = :id_siswa";

        $paramsOrangTua = [
            ':id_siswa' => $idSiswa,
            ':nama_ayah' => $formData['nama_ayah'],
            ':pekerjaan_ayah' => $formData['pekerjaan_ayah'],
            ':nama_ibu' => $formData['nama_ibu'],
            ':pekerjaan_ibu' => $formData['pekerjaan_ibu'],
            ':no_telepon_ortu' => $formData['no_telepon_ortu']
        ];

        $queryWali = "UPDATE data_wali SET
            nama_wali = :nama_wali,
            pekerjaan_wali = :pekerjaan_wali,
            alamat_wali = :alamat_wali,
            no_telepon_wali = :no_telepon_wali
        WHERE id_siswa = :id_siswa";

        $paramsWali = [
            ':id_siswa' => $idSiswa,
            ':nama_wali' => $formData['nama_wali'],
            ':pekerjaan_wali' => $formData['pekerjaan_wali'],
            ':alamat_wali' => $formData['alamat_wali'],
            ':no_telepon_wali' => $formData['no_telepon_wali']
        ];

        $queryBerkas = "UPDATE data_berkas SET
            foto_kk_ktp_akta_kelahiran = :foto_kk_ktp_akta_kelahiran,
            foto_pkh_kis_kks = :foto_pkh_kis_kks,
            foto_rapor = :foto_rapor
        WHERE id_siswa = :id_siswa";

        $paramsBerkas = [
            ':id_siswa' => $idSiswa,
            ':foto_kk_ktp_akta_kelahiran' => $formData['foto_kk_ktp_akta_kelahiran'],
            ':foto_pkh_kis_kks' => $formData['foto_pkh_kis_kks'],
            ':foto_rapor' => $formData['foto_rapor']
        ];

        $queryPendaftaran = "UPDATE status_pendaftaran SET
            status = :status,
            catatan_panitia = :catatan_panitia
        WHERE id_siswa = :id_siswa";

        $paramsPendaftaran = [
            ':id_siswa' => $idSiswa,
            ':status' => $formData['status'],
            ':catatan_panitia' => $formData['catatan_panitia']
        ];

        if (
            updateData($db, $queryOrangTua, $paramsOrangTua) &&
            updateData($db, $queryWali, $paramsWali) &&
            updateData($db, $queryBerkas, $paramsBerkas) &&
            updateData($db, $queryPendaftaran, $paramsPendaftaran)
        ) {
            $db->commit();
            $_SESSION["message"] = "Pendaftaran Berhasil Dirubah";

            $query = "SELECT * FROM data_prodi WHERE id=". $formData['jurusan'];
            $stmt = $db->prepare($query);
            $stmt->execute();
            $prodi = $stmt->fetch(PDO::FETCH_ASSOC);
            $nama_prodi = $prodi["nama"];

            // $recipient = $formData["email_siswa"];
            $recipient = 'calonsiswahuruna@gmail.com';
            $subject = 'Pendaftaran PPDB - ' . $formData['nama_siswa'];
            $body = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Data Pendaftaran PPDB</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 10px;
                            text-align: left;
                            border-bottom: 1px solid #ddd;
                        }
                        th {
                            background-color: #f2f2f2;
                            max-width: 20px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    </style>
                </head>
                <body>
                    <h1>Data Pendaftaran PPDB</h1>

                    <table>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>' . $formData['nama_siswa'] . '</td>
                        </tr>
                        <tr>
                            <th>Status Pendaftaran</th>
                            <td>' . $formData['status'] . '</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>' . $formData['nisn'] . '</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>' . $formData['nik'] . '</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>' . $nama_prodi . '</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>' . $formData['jenis_kelamin'] . '</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>' . $formData['tempat_lahir'] . '</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>' . $formData['tgl_lahir'] . '</td>
                        </tr>
                        <tr>
                            <th>Catatan Panitia</th>
                            <td>' . $formData['catatan_panitia'] . '</td>
                        </tr>
                    </table>
                </body>
                </html>
            ';

            sendEmail($recipient, $body, $subject);
        } else {
            $db->rollBack();
            $_SESSION["message"] = "Pendaftaran Gagal Dirubah";
        }
    } else {
        $db->rollBack();
        $_SESSION["message"] = "Pendaftaran Gagal Dirubah";
    }
} catch (Exception $e) {
    $db->rollBack();
    $_SESSION["message"] = "Pendaftaran Gagal: " . $e->getMessage();
}

header("Location: ../admin/index.php");
exit;
?>
