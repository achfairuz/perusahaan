<style>
.card-header {
    background-color: #007bff;
    color: white;
}

.table th {
    background-color: #f8f9fa;
}
</style>


<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM user where username = '$username'";
$a = $koneksi->query($sql)->fetch_assoc();


$id_order = $_GET['id_order']; //mengambil data id_order
$sqlOrder = "SELECT * FROM orders WHERE id_order = '$id_order'";
$resultOrder = $koneksi->query($sqlOrder);
$order = $resultOrder->fetch_assoc();

$sqlpembayaran = "SELECT * FROM pembayaran WHERE id_order = '$id_order'";
$pembayaran = $koneksi->query($sqlpembayaran)->fetch_assoc();
?>




<div class="container my-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Detail Pesanan</h2>
            <?php if ($order['status_order'] == 'Sukses') { ?>
            <a href="struk.php?id_order=<?php echo $id_order ?>" target="_blank" class="btn btn-mainColor">Cetak
                Struk</a>
            <?php } ?>
        </div>

        <div class="card-body   ">
            <h4 class="card-title">Informasi Pelanggan</h4>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> <?php echo $a['nama'] ?></p>
                    <p><strong>No Telepon:</strong> <?php echo $a['no_telp'] ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Pesanan:</strong> <?php echo $order['tanggal_pesanan'] ?></p>
                    <?php if ($order['status_order'] == 'Sukses') {

                    ?>
                    <p><strong>Status:</strong> <span class="badge bg-success">Sukses</span></p>
                    <p><strong>Metode Pembayaran:</strong> <?php echo $pembayaran['metode_pembayaran'] ?></p>
                    <?php
                    } elseif ($order['status_order'] == 'Proses') {

                    ?>
                    <p><strong>Status:</strong> <span class="badge bg-warning">Proses</span></p>
                    <?php
                    } else {
                        echo "order status tidak di temukan";
                    } ?>

                </div>
            </div>
            <h4 class="card-title">Detail Produk</h4>


            <div class="table-responsive mb-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sqlItem = "SELECT order_items.*, produk.nama_produk, produk.harga FROM order_items JOIN produk ON produk.id_produk = order_items.id_produk WHERE order_items.id_order = '$id_order' ";
                        $resultItem = $koneksi->query($sqlItem);
                        while ($a = $resultItem->fetch_assoc()) {
                            $subHarga = $a['jumlah'] * $a['harga'];
                        ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $a['nama_produk'] ?></td>
                            <td><?php echo $a['jumlah'] ?></td>
                            <td><?php echo number_format($a['harga'], 0, ',', '.') ?></td>
                            <td><?php echo number_format($subHarga, 0, ',', '.') ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>



            <div class="mb-3 text-end">
                <div class="row my-3">
                    <div class="col-md-10 text-end">
                        <h5>Total Harga:</h5>
                    </div>
                    <div class="col text-end">
                        <h5><strong>Rp. <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></strong></h5>
                    </div>
                </div>

                <?php if ($order['status_order'] == 'Sukses') { ?>
                <div class="row mb-2">
                    <div class="col-md-10 text-end">
                        <h5>Uang Diterima:</h5>
                    </div>
                    <div class="col text-end">
                        <h5><strong>Rp. <?php echo number_format($pembayaran['uang_terima'], 0, ',', '.'); ?></strong>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 text-end">
                        <h5>Kembalian:</h5>
                    </div>
                    <div class="col text-end">
                        <h5><strong>Rp. <?php echo number_format($pembayaran['uang_kembali'], 0, ',', '.'); ?></strong>
                        </h5>
                    </div>
                </div>
                <?php } ?>
            </div>



        </div>
    </div>
</div>