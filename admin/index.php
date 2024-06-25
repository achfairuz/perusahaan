<?php
include "../koneksi.php";
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ob_start();
if (isset($_GET['page'])) {
    $page = htmlentities($_GET['page']);
}


// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Admin </title>
    <link rel="icon" type="image/png" href="../aset/logo.png">

    <!-- FONT MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <style>
    body {
        padding-top: 56px;
        /* Atur sesuai dengan tinggi navbar Anda */
    }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" aria-label="Fourth navbar example"
            style="z-index: 1;">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#"><img src="../aset/logo.png" alt="logo"
                        class="img img-fluid me-2" style="max-width: 40px; max-height: 40px;">Bismillah Sejahtera</a>
                <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse"
                style="background-color: #2A2F34;">
                <div class="position-fixed">
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link text-color <?php if ($page == 'dashboard' || $page == '') echo 'active'; ?>"
                                aria-current="page" href="?page=dashboard">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color <?php if ($page == 'cabang') echo 'active'; ?>"
                                href="?page=cabang">
                                <span data-feather="briefcase"></span>
                                Cabang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color <?php if ($page == 'pendapatan') echo 'active'; ?>"
                                href="?page=pendapatan">
                                <span data-feather="dollar-sign"></span>
                                Pendapatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color <?php if ($page == 'admin_cabang' || $page == 'formAddAdmin' || $page == 'formUpdateAdmin') echo 'active'; ?>"
                                href="?page=admin_cabang">
                                <span data-feather="users"></span>
                                Admin cabang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-color <?php if ($page == 'daftarCuti') echo 'active'; ?>"
                                href="?page=daftarCuti">
                                <span data-feather="book"></span>
                                Daftar Cuti
                            </a>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link border-0 bg-transparent text-color" id="logout">
                                <span data-feather="log-out"></span>
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                $file = "$page.php";
                $cek = strlen('$page');
                if ($cek > 30 || !file_exists($file) || empty($page)) {
                    include("dashboard.php");
                } else {
                    include($file);
                }
                ?>
            </main>
        </div>
    </div>

    <div id="popupLogout" class="popup popupLogout">
        <div class="popup-content pop-up rounded">
            <div class="title text-center">
                <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
                <h4 class="text-danger fw-bold text-center">Are you sure you want to Logout?</h4>
            </div>
            <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
                <button class="btn btn-danger mt-3" id="confirm">Logout</button>
                <button class="btn btn-secondary mt-3" id="cancelLogout">Cancel</button>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('logout').addEventListener('click', function(event) {
        document.getElementById('popupLogout').style.display = 'block';
    });

    document.getElementById('cancelLogout').addEventListener('click', function() {
        document.getElementById('popupLogout').style.display = 'none';
    });

    document.getElementById('confirm').addEventListener('click', function() {
        window.location.href = '../logout.php';
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>

    <script src="script.js"></script>
</body>

</html>