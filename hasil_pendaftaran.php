<?php
session_start();
require_once ("./service/Database.php");
$database = new Database();
$db = $database->getConnection();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$rowPerPage = isset($_GET['rowPerPage']) ? (int) $_GET['rowPerPage'] : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $rowPerPage;

$query = "SELECT a.nama_siswa, a.asal_sekolah, a.jurusan, a.nisn, b.status, c.nama as nama_jurusan 
          FROM data_siswa a 
          INNER JOIN status_pendaftaran b ON a.id = b.id_siswa 
          INNER JOIN data_prodi c ON c.id = a.jurusan
          WHERE a.nama_siswa LIKE :search 
          ORDER BY a.id DESC 
          LIMIT :limit OFFSET :offset";$stmt = $db->prepare($query);
$searchParam = "%" . $search . "%";
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindParam(':limit', $rowPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$data_pendaftaran = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM data_siswa";
$stmt = $db->prepare($query);
$stmt->execute();
$data_search = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_query = "SELECT COUNT(*) FROM data_siswa WHERE nama_siswa LIKE :search";
$total_stmt = $db->prepare($total_query);
$total_stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $rowPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once ("./layout/head/head_daftar.php"); ?>

<body>
    <?php require_once ("./layout/header/header_daftar.php"); ?>

    <main id="main">
        <div class="container" style="margin-top: 150px;">
            <form method="GET" action="">
                <div class="form-group d-flex flex-column w-25">
                    <select class="form-control" id="selectSearch" name="search">
                        <option value="" disabled selected>Cari...</option>
                        <?php if (count($data_search) > 0): ?>
                            <?php foreach ($data_search as $index => $data): ?>
                                <option value="<?= htmlspecialchars($data['nama_siswa']) ?>">
                                    <?= htmlspecialchars($data['nama_siswa']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="Kosong">
                                Kosong</option>
                        <?php endif; ?>
                    </select>
                    <div>
                        <button class="btn btn-primary mt-2 w-25" type="submit">Cari</button>
                        <a class="btn btn-danger mt-2 w-25" href="./hasil_pendaftaran.php" type="button">Reset</a>
                    </div>
                </div>

            </form>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Asal Sekolah</th>
                                    <th>Jurusan</th>
                                    <th>NISN</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="body_hasil_pendaftaran">
                                <?php if (count($data_pendaftaran) > 0): ?>
                                    <?php foreach ($data_pendaftaran as $index => $data): ?>
                                        <tr>
                                            <td><?= ($offset + $index + 1) ?></td>
                                            <td><?= htmlspecialchars($data['nama_siswa']) ?></td>
                                            <td><?= htmlspecialchars($data['asal_sekolah']) ?></td>
                                            <td><?= $data['nama_jurusan'] ?></td>
                                            <td><?= htmlspecialchars($data['nisn']) ?></td>
                                            <?php
                                            $status = htmlspecialchars($data['status']);
                                            $btn_class = '';

                                            if ($status == 'Menunggu') {
                                                $btn_class = 'btn-warning';
                                            } elseif ($status == 'Ditolak') {
                                                $btn_class = 'btn-danger';
                                            } elseif ($status == 'Diterima') {
                                                $btn_class = 'btn-success';
                                            }
                                            ?>
                                            <td>
                                                <button type="button" class="btn <?= $btn_class ?> w-100"><?= $status ?></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">Data tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="pagination-container">
                            <ul class="pagination justify-content-center" id="pagination">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $i ?>&rowPerPage=<?= $rowPerPage ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>

                        <div class="form-group">
                            <form method="GET" action="">
                                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                <input type="hidden" name="page" value="<?= $page ?>">
                                <select id="rowPerPage" name="rowPerPage" class="form-control"
                                    onchange="this.form.submit()">
                                    <option value="5" <?= ($rowPerPage == 5) ? 'selected' : '' ?>>5</option>
                                    <option value="10" <?= ($rowPerPage == 10) ? 'selected' : '' ?>>10</option>
                                    <option value="20" <?= ($rowPerPage == 20) ? 'selected' : '' ?>>20</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php if (isset($_SESSION["message"])) { ?>
        <script>
            Swal.fire({
                title: '<?php echo $_SESSION["message"]; ?>',
                icon: 'info',
                confirmButtonText: 'OK',
            });
        </script>
        <?php $_SESSION["message"] = null; ?>
    <?php } ?>

    <?php require_once ("./layout/footer/footer_daftar.php"); ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#selectSearch').select2({
                placeholder: 'Cari...',
                allowClear: true
            });
        });
    </script>
</body>

</html>