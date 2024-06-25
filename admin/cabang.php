<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-mainColor fw-bold">Cabang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" id="tambahCabang" class="btn btn-sm text-color btn-outline-secondary ">
            <span data-feather="plus"></span>
            Tambah Cabang
        </button>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm  text-center">
        <thead class="border-color">
            <tr>
                <th style="display: none;"></th>
                <th scope="col">NO</th>
                <th scope="col">Nama Cabang</th>
                <th scope="col">Alamat</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../koneksi.php";
            $no = 1;
            $sql = "SELECT * FROM cabang";
            $result = $koneksi->query($sql);

            while ($a = $result->fetch_array()) {
                $cbg = $a['id_cabang']
                ?>
            <tr>
                <td style="display: none;" id="id_cabang"><?php echo $cbg?></td>
                <td><?php echo $no++; ?></td>
                <td><?php echo $a['nama_cabang']; ?></td>
                <td><?php echo $a['alamat']; ?></td>
                <td> <button class="btn  btn-update text-primary" data-id="<?php echo $cbg; ?>"
                        data-name="<?php echo $a['nama_cabang']; ?>" data-alamat="<?php echo $a['alamat']; ?>">
                        Update
                    </button>

                    <button class="btn  btn-delete text-danger" data-id="<?php echo $cbg; ?>">Delete</button>

                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- POP UP ADDcabang -->
<div id="popupCabang" class="popup">
    <div class="popup-content rounded p-4">
        <div class="title d-flex justify-content-between align-items-center ">
            <h2 class="text-mainColor fw-bold">Tambah Cabang</h2>
            <span class="close">&times;</span>
        </div>

        <form role="form" action="CRUD.php?stts=insert" method="POST">
            <div class="mb-2 row">
                <label for="nama_cabang" class="col-sm-2 col-form-label">Nama Cabang:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_cabang" id="nama_cabang" required>
                </div>
            </div>
            <div class="mb-2 row">
                <label for="alamat" class="col-sm-2 col-form-label">Lokasi :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat" id="alamat" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" id="AddCabang" type="submit">Tambahkan Cabang</button>
            </div>
        </form>
    </div>
</div>


<!-- POP UP UPDATE -->
<div id="popupUpdate" class="popup">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">Update Cabang</h2>
            <span class="close">&times;</span>
        </div>

        <form role="form" action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2 row">
                <label for="update_nama_cabang" class="col-sm-2 col-form-label">Nama Cabang:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_cabang" id="update_nama_cabang" required>
                </div>
            </div>
            <div class="mb-2 row">
                <label for="update_alamat" class="col-sm-2 col-form-label">Lokasi :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat" id="update_alamat" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" id="UpdateCabang" type="submit">Update Cabang</button>
            </div>
        </form>
    </div>
</div>



<!-- POP up delete -->
<div id="popupDelete" class="popup popupdelete">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Apakah Anda Ingin Menghapus Cabang ini?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-danger mt-3" id="confirmDelete">Delete</button>
            <button class="btn btn-secondary mt-3" id="cancel">Cancel</button>

        </div>
    </div>
</div>





<script>
// Add
document.getElementById("tambahCabang").addEventListener("click", function() {
    document.getElementById("popupCabang").style.display = "block";
});

// Close button
document.querySelectorAll(".close").forEach(closeButton => {
    closeButton.addEventListener("click", function() {
        this.closest(".popup").style.display = "none";
    });
});



// Update
document.querySelectorAll(".btn-update").forEach(button => {
    button.addEventListener("click", function() {

        const name = this.getAttribute('data-name');
        const alamat = this.getAttribute('data-alamat');

        const updatePopup = document.getElementById("popupUpdate");
        updatePopup.style.display = "block";

        updatePopup.querySelector('input[name="nama_cabang"]').value = name;
        updatePopup.querySelector('input[name="alamat"]').value = alamat;

        updatePopup.querySelector('form').action = `CRUD.php?stts=update&id_cabang=` + this
            .getAttribute('data-id');
    });
});




// Delete
let deleteHref = '';

document.querySelectorAll(".btn-delete").forEach(button => {
    button.addEventListener("click", function() {
        deleteHref = 'CRUD.php?stts=delete&id_cabang=' + this.getAttribute(
            'data-id'); // memasukkan atribute id
        document.getElementById("popupDelete").style.display = "block";
    });
});

document.getElementById("confirmDelete").addEventListener("click", function() {
    window.location.href = deleteHref;
});

// Cancel button
document.getElementById("cancel").addEventListener("click", function() {
    this.closest(".popupdelete").style.display = "none";
});
</script>