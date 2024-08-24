<?php
require_once ("./service/Database.php");
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM data_prodi";

$stmt = $db->prepare($query);
$stmt->execute();

$data_prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once ("./layout/head/head_daftar.php"); ?>

<body>
    <?php require_once ("./layout/header/header_daftar.php"); ?>

    <main id="main">
        <div class="container" style="margin-top: 150px;">

            <h2 class="text-center mt-5 mb-3">Alur PPDB Online</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card h-100 d-flex">
                        <div class="card-body text-center">
                            <h4>Daftar</h4>
                            <p>Calon peserta didik baru akses laman situs PPDB online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 d-flex">
                        <div class="card-body text-center">
                            <h4>Membaca Syarat Pendaftaran</h4>
                            <p>Calon siswa mempersiapkan beberapa dokumen penting yang dibutuhkan untuk
                                Persyaratan pendaftaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 d-flex">
                        <div class="card-body text-center">
                            <h4>Masuk ke Menu Daftar</h4>
                            <p>Melakukan pendaftaran dan upload dokumen yang telah diberitahu sebelumnya</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 d-flex">
                        <div class="card-body text-center">
                            <h4>Hasil</h4>
                            <p>Calon siswa akan menerima hasil pendaftaran melalui email yang telah didaftarkan dan
                                melalui menu
                                <strong>"Hasil Pendaftaran"</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <h1>Biodata Calon Siswa</h1>
                    <hr>
                    <form action="./service/simpan_pendaftaran.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Calon Siswa</label>
                                    <input type="text" name="nama_siswa" class="form-control" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>NISN</label>
                                    <input type="number" name="nisn" class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik" class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="Laki-laki">Laki Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" autocomplete="off"
                                        required onchange="validateUmur(this)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="nama_agama" class="form-control">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Gol. Darah</label>
                                    <select name="golongan_darah" class="form-control">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="O">O</option>
                                        <option value="AB">AB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email_siswa" class="form-control" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Rumah</label>
                                    <textarea name="alamat_siswa" rows="5" class="form-control" required></textarea>
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
                                    <input type="number" name="no_telp_rumah" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>No Hp Calon Siswa</label>
                                    <input type="number" name="no_telp_siswa" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Asal SMP/MTs</label>
                                    <input type="text" name="asal_sekolah" class="form-control" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Asal Sekolah</label>
                                    <textarea name="alamat_asal_sekolah" rows="5" class="form-control"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kompetensi Keahlian</label>
                                    <select name="nama_jurusan" class="form-control">
                                        <?php foreach ($data_prodi as $index => $prodi): ?>
                                            <option value="<?= $prodi['id'] ?>"><?= $prodi['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hobi / Kegemaran</label>
                                    <input type="text" id="hobi" name="hobi" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Prestasi Yang Pernah Dicapai</label>
                                    <textarea name="prestasi" rows="5" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>Fotokopi KK,KTP & Akta Kelahiran</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_kk_ktp_akta_kelahiran"
                                                name="foto_kk_ktp_akta_kelahiran" required>
                                            <label class="custom-file-label" for="foto_kk_ktp_akta_kelahiran">Pilih
                                                file...</label>
                                        </div>
                                        <div id="file-name-kartu-keluarga" style="margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>Fotokopi PKH / KIS / KKS</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_pkh_kis_kks"
                                                name="foto_pkh_kis_kks" required>
                                            <label class="custom-file-label" for="foto_pkh_kis_kks">Pilih
                                                file...</label>
                                        </div>
                                        <div id="file-name-pkh-kis-kks" style="margin-top: 5px;"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Scan Asli Rapot Semester 1~5</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_rapor"
                                                name="foto_rapor" required>
                                            <label class="custom-file-label" for="foto_rapor">Pilih file...</label>
                                        </div>
                                        <div id="file-name-rapor" style="margin-top: 5px;"></div>
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
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" id="nama_ibu" name="nama_ibu" class="form-control"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Telepon Orang Tua</label>
                                    <input type="number" id="no_telp_ortu" name="no_telp_ortu" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <h1 class="mt-5">Biodata Wali</h1>
                                <hr>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Wali</label>
                                    <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Telepon Wali</label>
                                    <input type="number" id="no_telepon_wali" name="no_telepon_wali"
                                        class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Rumah Wali</label>
                                    <textarea name="alamat_wali" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary w-100" type="submit">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php require_once ("./layout/footer/footer_daftar.php"); ?>

    <script>
        const menuItems = document.querySelectorAll('.nav-menu li');

        menuItems.forEach(function (item) {
            if (item.id !== "nav_menu_daftar") {
                item.classList.remove('active');
            } else {
                item.classList.add("active");
            }
        });

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
                alert("Umur tidak boleh lebih dari 21 Tahun")
            }
        }


        function showFileName(inputFileId, fileNameDivId) {
            var input = document.getElementById(inputFileId);
            var fileNameDiv = document.getElementById(fileNameDivId);
            var fileName = input.files[0].name;
            fileNameDiv.textContent = fileName;
        }

        document.getElementById('foto_kk_ktp_akta_kelahiran').addEventListener('change', function () {
            showFileName('foto_kk_ktp_akta_kelahiran', 'file-name-kartu-keluarga');
        });

        document.getElementById('foto_pkh_kis_kks').addEventListener('change', function () {
            showFileName('foto_pkh_kis_kks', 'file-name-pkh-kis-kks');
        });

        document.getElementById('foto_rapor').addEventListener('change', function () {
            showFileName('foto_rapor', 'file-name-rapor');
        });
    </script>
</body>

</html>