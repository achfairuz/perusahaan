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

    $tanggal = $_GET['tanggal'];
    ?>

    <div class="title d-flex justify-content-between align-items-center my-4 px-4">
        <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
        <div class="container">
            <h2 class="text-mainColor fw-bold text-center">Update Absen Karyawan</h2>
        </div>
    </div>

    <form role="form" action="CRUD.php?stts=updateAbsensi" method="POST">
        <div class="row mb-3">
            <div class="col-auto">
                <label for="tanggal" class="visually-hidden">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" disabled>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Absensi</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nmr = 1;
                        $sql = "SELECT a.id_absensi, u.username, u.nama, COALESCE(a.keterangan, 'Hadir') as keterangan 
                                FROM user u 
                                LEFT JOIN absensi a ON u.username = a.username AND a.tanggal = '$tanggal' 
                                WHERE u.id_cabang = '$id_cabang' AND u.role = 'karyawan'";
                        $hasil = $koneksi->query($sql);
                        $an = mysqli_num_rows($hasil); // menghitung jumlah karyawan

                        while ($row = $hasil->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $row['id_absensi'] ?>
                                    <input name="id_absensi[]" value="<?php echo $row['id_absensi'] ?>" style="display: none;">
                                </td>
                                <!-- Menampilkan ID Absensi -->
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['nama'] ?></td>
                                <td>
                                    <select class="form-select" name="keterangan[]" id="keterangan_<?php echo $row['username'] ?>">
                                        <option value="Hadir" <?php if ($row['keterangan'] == 'Hadir') echo 'selected'; ?>>
                                            Hadir</option>
                                        <option value="Alpha" <?php if ($row['keterangan'] == 'Alpha') echo 'selected'; ?>>
                                            Alpha</option>
                                        <option value="Izin" <?php if ($row['keterangan'] == 'Izin') echo 'selected'; ?>>
                                            Izin</option>
                                        <option value="Sakit" <?php if ($row['keterangan'] == 'Sakit') echo 'selected'; ?>>
                                            Sakit</option>
                                    </select>
                                </td>

                                <!-- mengambil username untuk memasukkan absensi ke database-->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <input type="hidden" name="jumlah_karyawan" value="<?php echo $an; ?>"> <!-- Jumlah karyawan -->
                <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>"> <!-- Tanggal absensi -->
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