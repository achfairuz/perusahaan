<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

$isTambahJumlah = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $produk = $_POST['id_produk'];
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
        $_SESSION['jumlah'] = [];
    }
    foreach ($_SESSION['keranjang'] as $key => $id) {
        if ($id == $produk) {
            $_SESSION['jumlah'][$key]++;
            $isTambahJumlah = true;
        }
    }
    if (!$isTambahJumlah) {
        array_push($_SESSION['keranjang'], $produk);
        array_push($_SESSION['jumlah'], 1);
    }
}

$username = $_SESSION['username'];

$sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username'";
$result_cabang = $koneksi->query($sql_cabang);

if ($result_cabang && $result_cabang->num_rows > 0) {
    $a = $result_cabang->fetch_assoc();
    $id_cabang = $a['id_cabang'];
} else {
    echo "Data tidak ditemukan.";
    exit();
}

$sql_categories = "SELECT * FROM kategoriproduk";
$result_categories = $koneksi->query($sql_categories);
?>




<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mb-4">
        <h1 class="h2 text-mainColor">Produk</h1>
        <div class="input-group mx-md-3 mb-2">
            <input id="searchInput" class="form-control me-2" type="text" placeholder="Search" aria-label="Search" style="border: 1px solid rgba(36, 112, 220, 1);">
        </div>
    </div>

    <?php
    while ($row_category = $result_categories->fetch_assoc()) {
        $id_kategori = $row_category['id_kategori'];
        $nama_kategori = $row_category['nama_kategori'];

        $sql_menu = "SELECT * FROM produk WHERE id_kategori = '$id_kategori' AND id_cabang = '$id_cabang'";
        $result_menu = $koneksi->query($sql_menu);

        if ($result_menu->num_rows > 0) {
            # code...

            echo '<div class="row category-row mb-4">';
            echo '<div class="col-12 fw-bold"><h3 class="category-title">' . $nama_kategori . '</h3></div>';

            while ($a = $result_menu->fetch_assoc()) {
    ?>
                <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-4 p-2 product-item">
                    <form id="<?php echo $a['id_produk']; ?>" method="POST">
                        <input type="hidden" name="id_produk" value="<?php echo $a['id_produk']; ?>">
                        <div class="content text-start">
                            <img src="<?php echo $a['gambar']; ?>" class="img img-fluid" alt="gambar_menu_<?php echo $a['id_produk']; ?>">
                            <h2 class="fw-bold mb-1 mt-2"><?php echo $a['nama_produk']; ?></h2>
                            <p class="mt-1 mb-2"><?php echo $a['deskripsi']; ?></p>
                            <div class="harga">
                                <p class="mt-1 mb-2 text-end fw-bold text-mainColor">Rp.
                                    <?php echo number_format($a['harga'], 0, ',', '.'); ?></p>
                                <button class="btn btn-mainColor col-12">Buy</button>
                            </div>
                        </div>
                    </form>
                </div>
    <?php
            }

            echo '</div>';
        }
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var categoryRows = document.querySelectorAll('.category-row');

        categoryRows.forEach(function(row) {
            var productItems = row.querySelectorAll('.product-item');
            var categoryTitle = row.querySelector('.category-title');
            var anyVisible = false;

            productItems.forEach(function(item) {
                var productName = item.querySelector('h2').textContent.toLowerCase();
                var productDescription = item.querySelector('p').textContent.toLowerCase();

                if (productName.includes(filter) || productDescription.includes(filter)) {
                    item.style.display = '';
                    anyVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (anyVisible) {
                categoryTitle.style.display = '';
            } else {
                categoryTitle.style.display = 'none';
            }
        });
    });
</script>