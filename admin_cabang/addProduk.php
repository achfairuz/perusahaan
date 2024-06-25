  <style>
      body {
          background-color: #f8f9fa;
      }

      .container {
          background-color: #fff;
          padding: 2rem;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .form-label {
          font-weight: bold;
      }

      .form-control:focus {
          border-color: #80bdff;
          box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
      }

      .btn-primary {
          background-color: #007bff;
          border-color: #007bff;
      }

      .btn-primary:hover {
          background-color: #0056b3;
          border-color: #004085;
      }
  </style>


  <body>
      <div class="container mt-5 mb-5">
          <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
          <h2 class="mb-4 text-center fw-bold text-mainColor">Tambah Produk</h2>
          <form role="form" action="CRUD.php?stts=addProduk" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                  <label for="productCategory" class="form-label">Kategori Produk</label>
                  <select class="form-select" name="kategori" id="productCategory" required>
                      <option selected disabled value="">Pilih Kategori</option>
                      <?php
                        include "../koneksi.php";
                        $sql = "SELECT * FROM kategoriproduk";
                        $result = $koneksi->query($sql);
                        if ($result->num_rows > 0) {
                            while ($a = $result->fetch_array()) {
                                echo '<option value="' . $a['id_kategori'] . '">' . $a['nama_kategori'] . '</option>';
                            }
                        } else {
                            echo "KATEGORI TIDAK DITEMUKAN";
                        }
                        ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label for="productName" class="form-label">Nama Produk</label>
                  <input type="text" class="form-control" name="nama_produk" id="productName" placeholder="Masukkan nama produk" required>
              </div>
              <div class="mb-4">
                  <label for="productImage" class="form-label">Upload Gambar Produk</label>
                  <input class="form-control" type="file" name="gambar" id="productImage" required>
              </div>
              <div class="mb-3">
                  <label for="productDescription" class="form-label">Deskripsi Produk</label>
                  <textarea class="form-control" id="productDescription" name="deskripsi" rows="3" placeholder="Masukkan deskripsi produk" required></textarea>
              </div>
              <div class="mb-3">
                  <label for="productPrice" class="form-label">Harga Produk</label>
                  <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="number" class="form-control" name="price" id="productPrice" placeholder="Masukkan harga produk" required>
                  </div>
              </div>
              <div class="mb-3">
                  <label for="stok" class="form-label">Stok</label>
                  <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukkan Jumlah Stok" required>
              </div>

              <div class="d-grid gap-2">
                  <button class="btn btn-mainColor mt-3" id="addProduk" type="submit">Tambahkan Produk</button>
              </div>
          </form>
      </div>

      <script>
          function back() {
              window.history.back();
          }
      </script>