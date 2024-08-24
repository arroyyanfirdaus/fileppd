<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

require_once ("../service/Database.php");
$database = new Database();
$db = $database->getConnection();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$rowPerPage = isset($_GET['rowsPerPage']) ? (int) $_GET['rowsPerPage'] : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $rowPerPage;

$query = "SELECT a.*, b.status, c.nama as nama_jurusan FROM data_siswa a
INNER JOIN status_pendaftaran b ON a.id = b.id_siswa
INNER JOIN data_prodi c ON c.id = a.jurusan
WHERE a.nama_siswa LIKE :search 
ORDER BY a.id DESC LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($query);
$searchParam = "%" . $search . "%";
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindParam(':limit', $rowPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$data_peserta_ppdb = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_query = "SELECT COUNT(*) FROM data_siswa WHERE nama_siswa LIKE :search";
$total_stmt = $db->prepare($total_query);
$total_stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $rowPerPage);

$status_counts = array_count_values(array_column($data_peserta_ppdb, 'status'));

$query = "SELECT COUNT(*) as total FROM data_admin";
$stmt = $db->prepare($query);
$stmt->execute();
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
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
            <!-- <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User Admin</span></a>
            </li>
            <hr class="sidebar-divider"> -->
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

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="../service/generateExcel.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Admin</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $totalUsers ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Menunggu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $status_counts["Menunggu"] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Ditolak</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $status_counts["Ditolak"] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Diterima</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $status_counts["Diterima"] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <h1>Data Peserta PPDB</h1>

                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search"
                                    aria-label="Search" name="search"
                                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                        <div class="col-12">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Asal Sekolah</th>
                                                    <th>Jurusan</th>
                                                    <th>Alamat</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data_peserta_ppdb as $index => $peserta): ?>
                                                    <tr>
                                                        <td><?= ($offset + $index + 1) ?></td>
                                                        <td><?= $peserta['nama_siswa'] ?></td>
                                                        <td><?= $peserta['asal_sekolah'] ?></td>
                                                        <td><?= $peserta['nama_jurusan'] ?></td>
                                                        <td><?= $peserta['alamat'] ?></td>
                                                        <td><?= $peserta['tgl_lahir'] ?></td>
                                                        <td><?= $peserta['jenis_kelamin'] ?></td>
                                                        <td><?= $peserta['status'] ?></td>
                                                        <td>
                                                            <a class="btn btn-info"
                                                                href="./detail_siswa.php?id=<?= $peserta['id'] ?>">Detail</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
                                            <form method="GET">
                                                <input type="hidden" name="search"
                                                    value="<?= htmlspecialchars($search) ?>">
                                                <input type="hidden" name="page" value="<?= $page ?>">
                                                <select class="form-control" id="rowsPerPage" name="rowsPerPage"
                                                    onchange="this.form.submit()">
                                                    <option value="5" <?php if ($rowPerPage == 5)
                                                        echo 'selected'; ?>>5
                                                    </option>
                                                    <option value="10" <?php if ($rowPerPage == 10)
                                                        echo 'selected'; ?>>10
                                                    </option>
                                                    <option value="20" <?php if ($rowPerPage == 20)
                                                        echo 'selected'; ?>>20
                                                    </option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <script src="../assets/dist/jquery/jquery.min.js"></script>
    <script src="../assets/dist/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/dist/jquery.easing/jquery.easing.min.js"></script>
</body>

</html>

</html>