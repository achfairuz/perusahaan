<?php

include "koneksi.php";


session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// mengambil id_cuti pada URL
if (isset($_GET['id_cuti'])) {
    $id_cuti = $_GET['id_cuti'];


    $sql = "SELECT * FROM cuti WHERE id_cuti = $id_cuti";
    $result = $koneksi->query($sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tanggal_mulai = $row['tanggal_mulai'];
        $tanggal_selesai = $row['tanggal_selesai'];
        $file = $row['file'];
        $alasan = $row['alasan'];
    } else {

        echo "Data cuti tidak ditemukan.";
    }
}
?>

<div class="title d-flex justify-content-between align-items-center mt-4 px-4 ">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <div class="container">
        <h2 class="text-mainColor fw-bold text-center">Update Cuti</h2>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <form action="CRUD.php?stts=update_cuti" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_cuti" id="id_cuti" value="<?php echo $id_cuti; ?>">
                <div class=" mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Cuti:</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $tanggal_mulai; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai Cuti:</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $tanggal_selesai; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Surat Cuti:</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Cuti:</label>
                    <textarea class="form-control" id="alasan" name="alasan" rows="4" required><?php echo $alasan; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Cuti</button>
            </form>
        </div>
    </div>
</div>

<script>
    function back() {
        window.history.back();
    }
</script>