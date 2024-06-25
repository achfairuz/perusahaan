  <?php
    session_start();
    require_once '../koneksi.php';

    $grand_total = 0; // Inisialisasi variabel grand_total

    if (isset($_GET['delete'])) {
        unset($_SESSION['keranjang'][$_GET['delete']]);
        unset($_SESSION['jumlah'][$_GET['delete']]);
    }

    if (isset($_GET['min'])) {
        $_SESSION['jumlah'][$_GET['index']]--;
    }

    if (isset($_GET['plus'])) {
        $_SESSION['jumlah'][$_GET['index']]++;
    }

    foreach ($_SESSION['keranjang'] as $index => $id) {
        $query = "SELECT * FROM produk WHERE id_produk = $id";
        $produk = $koneksi->query($query)->fetch_assoc();

        // Perhitungan total harga


    }
    ?>
  <div class="container my-5">
      <h1 class="mb-4 text-mainColor">Keranjang Belanja</h1>
      <div class="card">
          <div class="card-body">
              <form action="CRUD.php?stts=checkout" method="POST">
                  <div class="table-responsive">
                      <table class="table text-center">
                          <tbody>
                              <?php
                                foreach ($_SESSION['keranjang'] as $index => $id) {
                                    $query = "SELECT * FROM produk WHERE id_produk = $id";
                                    $a = $koneksi->query($query)->fetch_assoc();
                                    $harga = $a['harga'] * $_SESSION['jumlah'][$index];

                                    $grand_total += $harga;
                                ?>
                                  <tr>
                                      <td><input type="hidden" name="produk_id[]" value="<?php echo $a['id_produk'] ?>">
                                      </td>
                                      <td><img src="<?php echo $a['gambar'] ?> " class="img img-fluid" style="max-width: 80px; max-height: 80px;" alt="gambar_menu-<?php echo $a['gambar'] ?>"></td>
                                      <td><?php echo $a['nama_produk'] ?></td>
                                      <td><?php echo number_format($a['harga'], 0, ',', '.'); ?></td>
                                      <td>
                                          <div class="d-flex flex-row justify-content-center ">
                                              <a href="?page=keranjang&min=1&index=<?php echo $index ?>" class="btn btn-primary <?php if ($_SESSION['jumlah'][$index] <= 1) echo 'disabled'; ?>">-</a>
                                              <input type="number" class="text-center mx-2" value="<?php echo $_SESSION['jumlah'][$index] ?>" name="jumlah[]" min="1" readonly>
                                              <a href="?page=keranjang&plus=1&index=<?php echo $index ?>" class="btn btn-primary ">+</a>
                                          </div>
                                      </td>

                                      <td id="total">Rp. <?php echo number_format($harga, 0, ',', '.') ?></td>
                                      <td>
                                          <a href="?page=keranjang&delete=<?php echo $index ?>" class="btn btn-danger btn-sm">Hapus</a>
                                      </td>
                                  </tr>
                              <?php
                                }
                                ?>
                          </tbody>
                      </table>
                  </div>
                  <div class="d-flex justify-content-end mt-3">
                      <h4>Total: <span id="grandTotal">Rp. <?php echo number_format($grand_total, 0, ',', '.') ?></span>
                      </h4>
                      <input type="hidden" name="grand_total" value="<?php echo $grand_total ?>">
                  </div>
                  <div class="d-flex justify-content-end mt-2">
                      <button type="submit" class="btn btn-mainColor">Lanjutkan ke Pembayaran</button>
                  </div>
              </form>
          </div>
      </div>
  </div>