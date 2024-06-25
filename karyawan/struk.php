<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM user where username = '$username'";
$user = $koneksi->query($sql)->fetch_assoc();

$id_order = $_GET['id_order'];
$sqlOrder = "SELECT * FROM orders WHERE id_order = '$id_order'";
$order = $koneksi->query($sqlOrder)->fetch_assoc();

$sqlPembayaran = "SELECT * FROM pembayaran WHERE id_order = '$id_order'";
$pembayaran = $koneksi->query($sqlPembayaran)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="card receipt">
            <div class="card-header">
                <h2 class="text-center">Struk Pembayaran</h2>
                <p class="text-center">ID Pesanan: <?php echo $id_order; ?></p>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama:</strong> <?php echo $user['nama']; ?>
                    </div>
                    <div class="col-md-6">
                        <strong>No Telepon:</strong> <?php echo $user['no_telp']; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Pesanan:</strong> <?php echo $order['tanggal_pesanan']; ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <?php echo ($order['status_order'] == 'Sukses') ? '<span class="badge bg-success">Sukses</span>' : '<span class="badge bg-warning">Proses</span>'; ?>
                    </div>
                </div>

                <?php if ($order['status_order'] == 'Sukses') { ?>
                    <div class="row mb-3">
                        <div class="col">
                            <strong>Metode Pembayaran:</strong> <?php echo $pembayaran['metode_pembayaran']; ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sqlItem = "SELECT order_items.*, produk.nama_produk, produk.harga FROM order_items JOIN produk ON produk.id_produk = order_items.id_produk WHERE order_items.id_order = '$id_order'";
                            $resultItem = $koneksi->query($sqlItem);
                            while ($item = $resultItem->fetch_assoc()) {
                                $subHarga = $item['jumlah'] * $item['harga'];
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $item['nama_produk']; ?></td>
                                    <td><?php echo $item['jumlah']; ?></td>
                                    <td><?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo number_format($subHarga, 0, ',', '.'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total Harga:</strong> Rp.
                        <?php echo number_format($order['total_harga'], 0, ',', '.'); ?>
                    </div>
                </div>

                <?php if ($order['status_order'] == 'Sukses') { ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Uang Diterima:</strong> Rp.
                            <?php echo number_format($pembayaran['uang_terima'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Kembalian:</strong> Rp.
                            <?php echo number_format($pembayaran['uang_kembali'], 0, ',', '.'); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</body>


<script>
    window.print();
</script>

</html>