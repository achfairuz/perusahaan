<div class="container mt-5">
    <?php
    session_start();
    include "../koneksi.php";

    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php");
        exit();
    }

    $username = $_SESSION['username'];

    // mencari id_cabang dari admin_cabang yang login
    $sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username' AND role = 'admin cabang'";
    $result = $koneksi->query($sql_cabang);


    if ($result && $result->num_rows > 0) {
        $a = $result->fetch_assoc();
        $id_cabang = $a['id_cabang'];
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
    ?>


    <div class="title d-flex justify-content-between align-items-center my-4 px-4  ">
        <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
        <div class="container">
            <h2 class="text-mainColor fw-bold text-center">Absen Karyawan</h2>
        </div>

    </div>


    <form role="form" action="CRUD.php?stts=absensiKaryawan" method="POST">
        <div class="row mb-3">
            <div class="col-auto">
                <label for="tanggal" class="visually-hidden">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nmr = 1;
                    $sql = "SELECT * FROM user WHERE id_cabang = '$id_cabang' AND role = 'karyawan'";
                    $hasil = $koneksi->query($sql);
                    $an = mysqli_num_rows($hasil); // menghitung jumlah karyawan

                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['nama'] ?></td>
                        <td>
                            <select class="form-select" name="keterangan_<?php echo $row['username'] ?>"
                                id="keterangan_<?php echo $row['username'] ?>">
                                <option value="Hadir">Hadir</option>
                                <option value="Alpha">Alpha</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </td>
                        <input type="hidden" name="username<?php echo $nmr++; ?>"
                            value="<?php echo $row['username']; ?>">
                        <!-- mengambil username untuk memasukkan absensi ke database-->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <input type="hidden" name="jumlahKaryawan" value="<?php echo $an; ?>"> <!-- Jumlah karyawan -->
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<script>
function back() {
    window.history.back();
}
</script>