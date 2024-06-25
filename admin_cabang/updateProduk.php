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

<div class="container mt-5 mb-5">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <h2 class="mb-4 text-center fw-bold text-mainColor">Update Produk</h2>
    <form role="form" id="updateForm" method="POST" enctype="multipart/form-data">
        <!-- Form fields -->
        <input type="hidden" name="existing_image" id="existing_image">
        <input type="hidden" name="id_produk" id="id_produk">
        <div class="mb-3">
            <label for="productCategory" class="form-label">Kategori Produk</label>
            <select class="form-select" name="kategori" id="productCategory" required>
                <option selected disabled value="">Pilih Kategori</option>
                <?php
                include "../koneksi.php";
                $sql = "SELECT * FROM kategoriproduk";
                $result = $koneksi->query($sql);
                while ($a = $result->fetch_array()) {
                    echo '<option value="' . $a['id_kategori'] . '">' . $a['nama_kategori'] . '</option>';
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
            <input class="form-control" type="file" name="gambar" id="productImage">
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
            <button class="btn btn-mainColor mt-3" id="addProduk" type="submit">Update Produk</button>
        </div>
    </form>
</div>

<script>
    function back() {
        window.history.back();
    }

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);

        const idProduk = urlParams.get('id_produk');
        const kategori = urlParams.get('kategori');
        const nama_produk = urlParams.get('nama_produk');
        const gambar = urlParams.get('gambar');
        const deskripsi = urlParams.get('deskripsi');
        const price = urlParams.get('harga');
        const stok = urlParams.get('stok');

        const updateForm = document.getElementById("updateForm");

        if (idProduk && kategori && nama_produk && deskripsi && price && stok) {
            updateForm.querySelector('input[name="id_produk"]').value = idProduk;
            updateForm.querySelector('select[name="kategori"]').value = kategori;
            updateForm.querySelector('input[name="nama_produk"]').value = nama_produk;
            updateForm.querySelector('textarea[name="deskripsi"]').value = deskripsi;
            updateForm.querySelector('input[name="price"]').value = price;
            updateForm.querySelector('input[name="stok"]').value = stok;

            if (gambar) {
                document.getElementById('existing_image').value = gambar;
            }

            // Update the form action to include the id_produk
            updateForm.action = `CRUD.php?stts=updateProduk&id_produk=${idProduk}`;
        }
    }
</script>