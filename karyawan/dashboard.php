<?php
session_start();
include "../koneksi.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT user.*, cabang.* FROM user
        JOIN cabang ON cabang.id_cabang = user.id_cabang
        WHERE user.username = '$username' AND user.role = 'karyawan'";

$result = $koneksi->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}
?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-4 ">
            <div class="card mb-4">
                <div class="card-body text-center">

                    <h5 class="my-3 fw-bold text-mainColor"><?php echo ($row['username']); ?></h5>
                    <p class="text-muted mb-1"><?php echo ($row['jabatan']); ?></p>
                    <p class="text-muted mb-4"><?php echo ($row['alamat']); ?></p>

                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-center d-flex flex-column ">
                    <img src="../aset/logo.png" class="img img-fluid mb-3" alt="logo_perusahaan">
                    <h3 class="fw-bold text-mainColor"><?php echo ($row['nama_cabang']); ?></h>

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo ($row['nama']); ?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Phone</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo ($row['no_telp']); ?></p>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo ($row['alamat']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active-btn" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">About</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active-btn" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="profileTabContent">
                        <div class="tab-pane fade show active-btn" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <p class="mt-3 text-secondary">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Praesent
                                eget
                                pharetra purus, nec suscipit eros.</p>
                        </div>

                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <p class="mt-3 text-secondary">Contact form or information can be placed here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>