<?php
require_once ("../service/Database.php");
$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : null;

$query = "SELECT * FROM data_siswa a
          INNER JOIN data_orang_tua b ON a.id = b.id_siswa
          INNER JOIN data_wali c ON a.id = c.id_siswa
          INNER JOIN data_berkas d ON a.id = d.id_siswa
          INNER JOIN status_pendaftaran e ON a.id = e.id_siswa
          WHERE a.id = :id";

$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$data_peserta_ppdb = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM data_prodi";

$stmt = $db->prepare($query);
$stmt->execute();

$data_prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/dist/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../assets/dist/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SMK NEGERI 1 HURUNA</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="./index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../index.php" />
                                <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                Home
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="card mt-5" style="overflow-y: auto; height: 78vh;">
                    <div class="card-body">
                        <h1>Biodata Calon Siswa</h1>
                        <hr>
                        <form action="../service/edit_pendaftaran.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Nama Calon Siswa</label>
                                        <input type="text" name="nama_siswa" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['nama_siswa'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>NISN</label>
                                        <input type="number" name="nisn" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['nisn'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="number" name="nik" class="form-control" autocomplete="off" required
                                            value="<?= $data_peserta_ppdb['nik'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="Laki-laki" <?php if ($data_peserta_ppdb["jenis_kelamin"] == "Laki-laki")
                                                echo 'selected'; ?>>Laki Laki</option>
                                            <option value="Perempuan" <?php if ($data_peserta_ppdb["jenis_kelamin"] == "Perempuan")
                                                echo 'selected'; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['tgl_lahir'] ?>" onchange="validateUmur(this)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['tempat_lahir'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select name="nama_agama" class="form-control">
                                            <option value="Islam" <?php if ($data_peserta_ppdb["agama"] == "Islam")
                                                echo 'selected'; ?>>Islam</option>
                                            <option value="Kristen" <?php if ($data_peserta_ppdb["agama"] == "Kristen")
                                                echo 'selected'; ?>>Kristen</option>
                                            <option value="Hindu" <?php if ($data_peserta_ppdb["agama"] == "Hindu")
                                                echo 'selected'; ?>>Hindu</option>
                                            <option value="Katolik" <?php if ($data_peserta_ppdb["agama"] == "Katolik")
                                                echo 'selected'; ?>>Katolik</option>
                                            <option value="Buddha" <?php if ($data_peserta_ppdb["agama"] == "Buddha")
                                                echo 'selected'; ?>>Buddha</option>
                                            <option value="Lainnya" <?php if ($data_peserta_ppdb["agama"] == "Lainnya")
                                                echo 'selected'; ?>>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Gol. Darah</label>
                                        <select name="golongan_darah" class="form-control">
                                            <option value="A" <?php if ($data_peserta_ppdb["golongan_darah"] == "A")
                                                echo 'selected'; ?>>A</option>
                                            <option value="B" <?php if ($data_peserta_ppdb["golongan_darah"] == "B")
                                                echo 'selected'; ?>>B</option>
                                            <option value="O" <?php if ($data_peserta_ppdb["golongan_darah"] == "O")
                                                echo 'selected'; ?>>O</option>
                                            <option value="AB" <?php if ($data_peserta_ppdb["golongan_darah"] == "AB")
                                                echo 'selected'; ?>>AB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email_siswa" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['email_siswa'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat Rumah</label>
                                        <textarea name="alamat_siswa" rows="5" class="form-control"
                                            required><?= $data_peserta_ppdb['alamat'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Rumah Milik</label>
                                        <select name="rumah_milik" class="form-control">
                                            <option value="Orang Tua">Orang Tua</option>
                                            <option value="Asrama / Pondok Pesantren">Asrama / Pondok Pesantren</option>
                                            <option value="Kost">Kost</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Telepon Rumah</label>
                                        <input type="number" name="no_telp_rumah" class="form-control"
                                            autocomplete="off" value="<?= $data_peserta_ppdb['no_telp_rumah'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>No Hp Calon Siswa</label>
                                        <input type="number" name="no_telp_siswa" class="form-control"
                                            autocomplete="off" value="<?= $data_peserta_ppdb['no_telp_siswa'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Asal SMP/MTs</label>
                                        <input type="text" name="asal_sekolah" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['asal_sekolah'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat Asal Sekolah</label>
                                        <textarea name="alamat_asal_sekolah" rows="5" class="form-control"
                                            required><?= $data_peserta_ppdb['alamat_asal_sekolah'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kompetensi Keahlian</label>
                                        <select name="nama_jurusan" class="form-control">
                                            
                                        <?php foreach ($data_prodi as $index => $prodi): ?>
                                            <option value="<?= $prodi['id'] ?>" <?= ($data_peserta_ppdb["jurusan"] == $prodi['id']) ? 'selected' : '' ?>><?= $prodi['nama'] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hobi / Kegemaran</label>
                                        <input type="text" id="hobi" name="hobi" class="form-control" autocomplete="off"
                                            value="<?= $data_peserta_ppdb['hobi'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Prestasi Yang Pernah Dicapai</label>
                                        <textarea name="prestasi" rows="5" class="form-control"
                                            required><?= $data_peserta_ppdb['prestasi'] ?></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="foto_kk_ktp_akta_kelahiran">Scan KK,KTP & Akta Kelahiran</label>
                                            <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        id="foto_kk_ktp_akta_kelahiran" name="foto_kk_ktp_akta_kelahiran">
                                                    <label class="custom-file-label" for="foto_kk_ktp_akta_kelahiran">Pilih
                                                        file...</label>
                                                    </div>
                                                    <div id="file-name-kartu-keluarga" style="margin-top: 5px;"></div>
                                                    <?php if (!empty($data_peserta_ppdb['foto_kk_ktp_akta_kelahiran'])): ?>
                                                            <div class="input-group-append">
                                                                <a href="../uploads/data-berkas/<?php echo $data_peserta_ppdb['nisn'] . "/" . $data_peserta_ppdb['foto_kk_ktp_akta_kelahiran']; ?>"
                                                                    class="btn btn-outline-secondary" target="_blank">
                                                                    Download
                                                                </a>
                                                            </div>
                                                    <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label>Scan Asli PKH / KIS / KKS</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto_pkh_kis_kks"
                                                    name="foto_pkh_kis_kks" >
                                                <label class="custom-file-label" for="foto_pkh_kis_kks">Pilih file...</label>
                                            </div>
                                            <div id="file-name-pkh-kis-kks" style="margin-top: 5px;"></div>
                                            <?php if (!empty($data_peserta_ppdb['foto_pkh_kis_kks'])): ?>
                                                    <div class="input-group-append">
                                                        <a href="../uploads/data-berkas/<?php echo $data_peserta_ppdb['nisn'] . "/" . $data_peserta_ppdb['foto_pkh_kis_kks']; ?>"
                                                            class="btn btn-outline-secondary" target="_blank">
                                                            Download
                                                        </a>
                                                    </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Scan Asli Rapot Semester 1~5</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto_rapor"
                                                    name="foto_rapor" >
                                                <label class="custom-file-label" for="foto_rapor">Pilih file...</label>
                                            </div>
                                            <div id="file-name-rapor" style="margin-top: 5px;"></div>
                                            <?php if (!empty($data_peserta_ppdb['foto_rapor'])): ?>
                                                    <div class="input-group-append">
                                                        <a href="../uploads/data-berkas/<?php echo $data_peserta_ppdb['nisn'] . "/" . $data_peserta_ppdb['foto_rapor']; ?>"
                                                            class="btn btn-outline-secondary" target="_blank">
                                                            Download
                                                        </a>
                                                    </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h1 class="mt-5">Biodata Orang Tua</h1>
                                    <hr>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Nama Ayah</label>
                                        <input type="text" name="nama_ayah" class="form-control" autocomplete="off"
                                            required value="<?= $data_peserta_ppdb['nama_ayah'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan Ayah</label>
                                        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                            class="form-control" autocomplete="off" required
                                            value="<?= $data_peserta_ppdb['pekerjaan_ayah'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Ibu</label>
                                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-control"
                                            autocomplete="off" required value="<?= $data_peserta_ppdb['nama_ibu'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan Ibu</label>
                                        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control"
                                            autocomplete="off" required
                                            value="<?= $data_peserta_ppdb['pekerjaan_ibu'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Telepon Orang Tua</label>
                                        <input type="number" id="no_telp_ortu" name="no_telp_ortu" class="form-control"
                                            autocomplete="off" value="<?= $data_peserta_ppdb['no_telepon_ortu'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h1 class="mt-5">Biodata Wali</h1>
                                    <hr>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Nama Wali</label>
                                        <input type="text" name="nama_wali" class="form-control" autocomplete="off"
                                            value="<?= $data_peserta_ppdb['nama_wali'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan Wali</label>
                                        <input type="text" id="pekerjaan_wali" name="pekerjaan_wali"
                                            class="form-control" autocomplete="off"
                                            value="<?= $data_peserta_ppdb['pekerjaan_wali'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Telepon Wali</label>
                                        <input type="number" id="no_telepon_wali" name="no_telepon_wali" class="form-control"
                                            autocomplete="off" value="<?= $data_peserta_ppdb['no_telepon_wali'] ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat Rumah Wali</label>
                                        <textarea name="alamat_wali" rows="5"
                                            class="form-control"><?= $data_peserta_ppdb['alamat_wali'] ?></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h1 class="mt-5">Catatan</h1>
                                    <hr>
                                </div>

                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Catatan Panitia</label>
                                        <textarea name="catatan_panitia" rows="5"
                                            class="form-control"><?= $data_peserta_ppdb['catatan_panitia'] ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="Diterima" <?php if ($data_peserta_ppdb["status"] == "Diterima")
                                                echo 'selected'; ?>>Diterima</option>
                                            <option value="Menunggu" <?php if ($data_peserta_ppdb["status"] == "Menunggu")
                                                echo 'selected'; ?>>Menunggu</option>
                                            <option value="Ditolak" <?php if ($data_peserta_ppdb["status"] == "Ditolak")
                                                echo 'selected'; ?>>Ditolak</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-danger w-100"
                                        href="../service/hapus_pendaftaran.php?id=<?= $_GET['id'] ?>">Hapus</a>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-secondary w-100" href="./">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>2024</span>
                    </div>
                </div>
            </footer>

            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <form id="logout-form" action="../service/logout.php" method="POST">
                                <input type="hidden" name="_token" value="CcBWaHLXLAI4BHyfGfL5lzDnGEoqba4PrUCvet6P">
                                <button class="btn btn-primary" type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/dist/jquery/jquery.min.js"></script>
    <script src="../assets/dist/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/dist/jquery.easing/jquery.easing.min.js"></script>

    <script>
        function showFileName(inputFileId, fileNameDivId) {
            var input = document.getElementById(inputFileId);
            var fileNameDiv = document.getElementById(fileNameDivId);
            var fileName = input.files[0].name;
            fileNameDiv.textContent = fileName;
        }

        function validateUmur(element) {
            const birthdateInput = element;
            const birthdate = new Date(birthdateInput.value);

            if (!birthdate.getTime()) {
                return;
            }

            const today = new Date();
            const age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();
            const dayDiff = today.getDate() - birthdate.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            if (age > 21) {
                alert("Umur tidak boleh lebih dari 21")
            }
        }

        document.getElementById('foto_kk_ktp_akta_kelahiran').addEventListener('change', function() {
            showFileName('foto_kk_ktp_akta_kelahiran', 'file-name-kartu-keluarga');
        });

        document.getElementById('foto_pkh_kis_kks').addEventListener('change', function() {
            showFileName('foto_pkh_kis_kks', 'file-name-pkh-kis-kks');
        });

        document.getElementById('foto_rapor').addEventListener('change', function() {
            showFileName('foto_rapor', 'file-name-rapor');
        });
    </script>
</body>

</html>

</html>