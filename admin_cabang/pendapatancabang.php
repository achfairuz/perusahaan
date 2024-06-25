<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

// Mengambil id_cabang dan nama_cabang dari username login
$sql = "SELECT user.id_cabang, cabang.nama_cabang 
        FROM user 
        JOIN cabang ON cabang.id_cabang = user.id_cabang 
        WHERE user.username = '$username'";
$result = $koneksi->query($sql)->fetch_assoc();
$id_cabang = $result['id_cabang'];
$nama_cabang = $result['nama_cabang'];
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mt-3">
    <h1 class="h2 text-mainColor">Pendapatan <?php echo $nama_cabang ?></h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mengambil data pendapatan dan memformat tanggal
            $sqlPendapatan = "SELECT DATE_FORMAT(bulandantahun, '%M-%Y') AS bulan_dan_tahun, totalpendapatan 
                              FROM pendapatan 
                              WHERE id_cabang = '$id_cabang' 
                              ORDER BY bulandantahun ASC";
            $resultpendapatan = $koneksi->query($sqlPendapatan);

            while ($a = $resultpendapatan->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $a['bulan_dan_tahun'] ?> </td>
                    <td>Rp. <?php echo number_format($a['totalpendapatan'], 0, ',', '.') ?> </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>