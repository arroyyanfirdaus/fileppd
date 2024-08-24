<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../admin/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMK Negeri 1 Huruna- Login</title>
    <link href="../assets/img/favicon.png" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="../assets/dist/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url('../assets/img/background.jpg');
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(4px);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin: 0;
        }

        .card-body {
            background-color: #c1cff7;
        }
    </style>
</head>

<body class="bg-image">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0 d-flex justify-content-center">
                        <div class="text-center mt-4 w-75">
                            <img src="../assets/img/foto.png" alt="Foto" width="200" height="200">
                            <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                            </>
                            <form class="user" method="POST" action="../service/login.php">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" value=""
                                        required autocomplete="email" autofocus placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password"
                                        required autocomplete="current-password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <hr>
                            </form>
                            </>
                        </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/dist/jquery/jquery.min.js"></script>
    <script src="../assets/dist/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/dist/jquery.easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>