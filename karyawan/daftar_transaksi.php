<div class="container">
    <h1 class="mt-5 mb-3">Daftar Transaksi</h1>

    <?php
    session_start();
    include "../koneksi.php";
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM orders WHERE username = '$username'";
    $result = $koneksi->query($sql);
    while ($a = $result->fetch_assoc()) {
    ?>
    <div class="list-group-item list-group-item-action bg-light border p-3 rounded mb-2">
        <div class="d-flex w-100 justify-content-between">
            <h1 style="display: none;"><?php echo $a['id_order'] ?></h1>
            <h5 class="mb-1"><?php echo $a['username'] ?></h5>
            <small><?php echo $a['tanggal_pesanan'] ?></small>
        </div>
        <p class="mb-1">Jumlah: Rp. <?php echo number_format($a['total_harga'], 0, ',', '.') ?></p>
        <p class="mb-1">Status: <?php echo $a['status_order']; ?></p>


        <div class="d-flex justify-content-end">
            <a href="?page=detail_pesanan&id_order=<?php echo $a['id_order']; ?>"
                class="btn btn-info btn-sm me-2 text-white">Detail
                Pesanan</a>
            <?php if ($a['status_order'] == 'Proses') { ?>
            <a href="?page=pembayaran&order_id=<?php echo $a['id_order']; ?>"
                class="btn btn-warning text-white btn-sm">Pembayaran</a>
            <?php } elseif ($a['status_order'] == 'Sukses') {

                ?>
            <a href="struk.php?id_order=<?php echo  $a['id_order'];  ?>" target="_blank"
                class="btn btn-primary btn-sm">Cetak
                Struk</a>
            <?php

                } ?>
        </div>
    </div>
    <?php
    }
    ?>
    <!-- Tambahkan item transaksi sesuai kebutuhan -->
</div>