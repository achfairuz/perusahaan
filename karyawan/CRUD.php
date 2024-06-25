<?php
session_start();
include '../koneksi.php';

$status = isset($_GET["stts"]) ? $_GET["stts"] : '';

if ($status == 'checkout') {
    session_start();

 
    $username = $_SESSION['username'];
    $grand_total = $_POST['grand_total'];
    $id_produks = $_POST['produk_id'];
    $jumlahs = $_POST['jumlah'];

    $sqlOrder = "INSERT INTO orders(username, total_harga) VALUES ('$username', '$grand_total')";
    if ($koneksi->query($sqlOrder) === TRUE) {

        $order_id = $koneksi->insert_id;

       
        foreach ($id_produks as $index => $id_produk) {
            $jumlah = $jumlahs[$index];
            $sqlItems = "INSERT INTO order_items (id_order, id_produk, jumlah) VALUES ('$order_id', '$id_produk', '$jumlah')";
            $result = $koneksi->query($sqlItems);
        }

       
        unset($_SESSION['keranjang']);
        unset($_SESSION['jumlah']);

        echo "<script>alert('Produk Berhasil Di Checkout'); window.location.href = 'index.php?page=pembayaran&order_id=$order_id'; </script>";
    } else {
        echo "Error: " . $sqlOrder . "<br>" . $koneksi->error;
    }

    $koneksi->close();
    exit();
} elseif ($status == 'pembayaran') {
    $username = $_SESSION['username'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $uang_terima = isset($_POST['uang_terima']) ? $_POST['uang_terima'] : 0;  // Menambahkan pengecekan untuk 'uang_terima'
    $uang_kembali = $_POST['uang_kembalian'];
    $id_order = $_POST['id_order'];
    $total_pembayaran = $_POST['total_pembayaran'];

    $sql = "INSERT INTO pembayaran(username,id_order, total_pembayaran, uang_terima, uang_kembali, metode_pembayaran) VALUES ('$username','$id_order', '$total_pembayaran', '$uang_terima', '$uang_kembali', '$metode_pembayaran')";
    $result = $koneksi->query($sql);

    if ($result === true) {
        $sql = "UPDATE orders SET status_order = 'Sukses' WHERE id_order = '$id_order'";

        $result = $koneksi->query($sql);
        echo "<script>alert('Produk Berhasil di Bayar'); window.location.href = 'index.php?page=daftar_transaksi'; </script>";
        exit();
    } else {
        echo "<script>alert('Produk Gagal di Bayar');</script> "  . $koneksi->error;
    }
}
