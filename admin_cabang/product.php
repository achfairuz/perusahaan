<?php
session_start();
include "../koneksi.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

// Dapatkan id_cabang dari admin yang sedang login
$sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username' AND role = 'admin cabang'";
$result_cabang = $koneksi->query($sql_cabang);

if ($result_cabang && $result_cabang->num_rows > 0) {
    $row_cabang = $result_cabang->fetch_assoc();
    $id_cabang = $row_cabang['id_cabang'];
} else {
    echo "Data tidak ditemukan.";
    exit();
}
?>

<!-- KATEGORI PRODUK -->
<div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-2" style="border-bottom: 1px solid black;">
    <h2 class="fw-bold text-mainColor">Kategori Product</h2>

    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-secondary btn-add-category">
            <span data-feather="plus"></span>
            Tambah Kategori
        </button>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm text-center">
        <thead>
            <tr>
                <th scope="col">NO</th>
                <th scope="col">Kategori</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = "SELECT * FROM kategoriproduk";
            $result = $koneksi->query($sql);
            while ($a = $result->fetch_assoc()) {
                $id_kategori = $a['id_kategori'];
                $nama_kategori = $a['nama_kategori'];
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nama_kategori; ?></td>
                    <td>
                        <button class="btn px-2 py-2 btn-update-kategori" data-id="<?php echo $id_kategori; ?>" data-name="<?php echo $nama_kategori; ?>">
                            Update
                        </button>

                        <button class="btn px-2 py-2 btn-delete-kategori text-danger" data-id="<?php echo $id_kategori; ?>">Delete</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Kategori-->
<div id="popupADDCatgeory" class="popup" style="display: none;">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">ADd Kategori</h2>
            <h1 id="close-btn">&times;</h1>
        </div>

        <form role="form" action="CRUD.php?stts=addCategory" method="POST">
            <input type="hidden" name="id_kategori" id="id_kategori_input">
            <div class="mb-2 row">
                <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" type="submit">Add Kategori</button>
            </div>
        </form>

    </div>
</div>


<!-- POP UP UPDATE Kategori -->
<div id="popupUpdateKategori" class="popup" style="display: none;">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">Update Kategori</h2>
            <h1 id="close-btn">&times;</h1>
        </div>

        <form role="form" id="updateKategoriForm" method="POST">
            <input type="hidden" name="id_kategori" id="update_id_kategori">
            <div class="mb-2 row">
                <label for="update_nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_kategori" id="update_nama_kategori" required>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" type="submit">Update Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- POP up delete Kategori-->
<div id="popupDeleteKategori" class="popup popupdelete">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Apakah Anda Ingin Menghapusnya?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-danger mt-3" id="confirmDelete">Delete</button>
            <button class="btn btn-secondary mt-3" id="cancelDelete">Cancel</button>

        </div>
    </div>
</div>


<!-- PRODUK -->
<div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2">
    <h2 class="mb-0 fw-bold text-mainColor mb-2">Product</h2>

    <div class="input-group mx-md-3 mb-2">
        <input id="searchInput" class="form-control me-2 " type="text" placeholder="Search" aria-label="Search">
        <button id="searchButton" class="btn btn-mainColor btn-outline-secondary" type="button" style="z-index: 0;">
            <span data-feather="search"></span>
        </button>
    </div>


    <div class="ms-auto">
        <div class="btn-toolbar mb-2 mb-md-0 d-flex justify-content-end">

            <a href="?page=addProduk"><button type="button" class="btn btn-mainColor btn-outline-secondary me-2 mb-1">
                    <span data-feather="plus"></span>
                    Add
                </button></a>
        </div>
    </div>
</div>


<!-- Table menu -->
<div class="table-responsive text-center ">
    <table class="table table-striped table-sm table-menu">
        <thead>
            <tr>
                <th style="display: none;"></th>
                <th scope="col" class="px-3">NO</th>
                <th scope="col" class="px-3">Kategori</th>
                <th scope="col" class="px-3">Nama</th>
                <th scope="col" class="px-3">Gambar</th>
                <th scope="col" class="px-3">Stok</th>
                <th scope="col" class="px-3">Harga</th>
                <th scope="col" class="px-3">Deskripsi</th>

                <th scope="col" class="px-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            include "../koneksi.php";

            if (!isset($_SESSION['username'])) {
                header("Location: ../login.php");
                exit();
            }

            $username = $_SESSION['username'];
            $no = 1;
            $sql = "SELECT produk.*, cabang.* , kategoriproduk.* 
            FROM produk 
            JOIN cabang ON cabang.id_cabang = produk.id_cabang 
            JOIN kategoriproduk ON kategoriproduk.id_kategori = produk.id_kategori 
            WHERE produk.id_cabang = '$id_cabang' ORDER BY produk.nama_produk ASC";
            $result = $koneksi->query($sql);

            while ($a = $result->fetch_array()) {
                $id_produk = $a['id_produk'];
                $gambar = $a['id_produk'];

            ?>
                <tr>
                    <td style="display: none;" id="id_produk"><?php echo $id_produk ?></td>
                    <td class="p-3"> <?php echo $no++; ?></td>
                    <td class="p-3"><?php echo $a['nama_kategori']; ?></td>
                    <td class="p-3"><?php echo $a['nama_produk']; ?></td>
                    <td class="p-3"><img src="<?php echo $a['gambar'];  ?>" class="img img-fluid" style="width: 100%; max-width: 150px; height: auto;" alt="Produk"></td>
                    <td class="p-3"><?php echo $a['stok']; ?></td>
                    <td class="p-3">Rp. <?php echo number_format($a['harga'], 0, ',', '.'); ?></td>
                    <td class="p-3"><?php echo $a['deskripsi']; ?></td>

                    <td class="p-3">
                        <!-- Tombol Update -->
                        <a style="text-decoration: none;" href="?page=updateProduk&id_produk=<?php echo ($id_produk); ?>&kategori=<?php echo ($a['id_kategori']); ?>&nama_produk=<?php echo ($a['nama_produk']); ?>&gambar=<?php echo ($a['gambar']); ?>&stok=<?php echo ($a['stok']); ?>&harga=<?php echo ($a['harga']); ?>&deskripsi=<?php echo ($a['deskripsi']); ?>">
                            <button class="btn btn-update text-primary"></button>
                            Update
                        </a>

                        <!-- Tombol Tambah Stok -->
                        <button class="btn px-2 py-2 btn-tambah-stok text-success" data-id="<?php echo $id_produk; ?>" data-stok="<?php echo $a['stok']; ?>">Tambah Stok</button>

                        <!-- Tombol Delete -->
                        <button class="btn px-2 py-2 btn-delete-produk text-danger" data-id="<?php echo $id_produk; ?>">Delete</button>
                    </td>


                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<!-- POPUP TAMBAH STOK -->
<div id="popupTambahStok" class="popup" style="display: none;">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">Tambah Stok</h2>
            <h1 id="close-btn-stok">&times;</h1>
        </div>

        <form role="form" id="tambahStokForm" method="POST" action="CRUD.php?stts=tambahStok">


            <input type="hidden" name="id_produk" id="tambah_stok_id_produk">
            <div class="mb-2 row">
                <label for="tambah_stok_jumlah" class="col-sm-3 col-form-label">Jumlah Stok</label>
                <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="stok_saat_ini" id="stok_saat_ini">
                    <input type="number" class="form-control" name="jumlah_stok" id="tambah_stok_jumlah" required>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" type="submit">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>



<!-- POPUP DELETE Produk -->
<div id="popupDeleteProduk" class="popup popupdelete">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Apakah Anda Ingin Menghapus Produk Ini?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-danger mt-3" id="confirmDeleteProduk">Delete</button>
            <button class="btn btn-secondary mt-3" id="cancelDelete">Cancel</button>

        </div>
    </div>
</div>


<script>
    // Close Buttons 
    document.querySelectorAll('#close-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.popup').style.display = 'none';
        });
    });
    // add Kategori
    document.querySelectorAll('.btn-add-category').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('popupADDCatgeory').style.display = 'block';
        })
    })

    // Update kategori
    document.querySelectorAll(".btn-update-kategori").forEach(button => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const name = this.getAttribute("data-name");

            const updatePopup = document.getElementById("popupUpdateKategori");
            updatePopup.style.display = "block";


            document.getElementById('update_id_kategori').value = id;
            document.getElementById('update_nama_kategori').value = name;


            document.getElementById('updateKategoriForm').action =
                `CRUD.php?stts=updateKategori&id_kategori=${id}`;
        });
    });

    //delete kategori
    let url = "";
    document.querySelectorAll(".btn-delete-kategori").forEach(button => {
        button.addEventListener("click", function() {
            deleteUrl = 'CRUD.php?stts=deletekategori&id_kategori=' + this.getAttribute('data-id');
            document.getElementById('popupDeleteKategori').style.display = 'block';
        });
    });

    document.getElementById("confirmDelete").addEventListener("click", function() {
        window.location.href = deleteUrl;
    });


    document.querySelectorAll('#cancelDelete').forEach(button => {
        button.addEventListener("click", function() {
            this.closest(".popup").style.display = "none";
        });

    });




    // DELETE PRODUCT
    let link = "";
    document.querySelectorAll('.btn-delete-produk').forEach(button => {
        button.addEventListener('click', function() {
            deleteProduk = 'CRUD.php?stts=deleteProduk&id_produk=' + this.getAttribute('data-id');
            document.getElementById('popupDeleteProduk').style.display = 'block';
        });
    });

    document.getElementById('confirmDeleteProduk').addEventListener('click', function() {
        window.location.href = deleteProduk;
    });


    // Tampilkan popup tambah stok
    document.querySelectorAll('.btn-tambah-stok').forEach(button => {
        button.addEventListener('click', function() {
            const id_produk = this.getAttribute('data-id');
            const stok = this.getAttribute('data-stok');
            document.getElementById('popupTambahStok').style.display = 'block';
            document.getElementById('tambah_stok_id_produk').value = id_produk;
            document.getElementById('stok_saat_ini').value = stok;

        });
    });

    // Tutup popup tambah stok
    document.querySelectorAll('#close-btn-stok').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.popup').style.display = 'none';
        });
    });
</script>