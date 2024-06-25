<div class="title d-flex justify-content-between align-items-center mt-4 px-4">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <div class="container">
        <h2 class="text-mainColor fw-bold text-center">Update Admin Cabang</h2>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form role="form" action="CRUD.php?stts=updateAdminCabang" method="POST" id="updateForm">
                <div class="mb-2 row">
                    <label for="cabang" class="col-sm-4 col-form-label">Cabang :</label>
                    <div class="col-sm-8">
                        <select name="cabang" id="cabang" class="form-select" required>
                            <?php
                            $sql = "SELECT * FROM cabang ORDER BY id_cabang DESC";
                            $result = $koneksi->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_cabang'] . "'>" . $row['nama_cabang'] . "</option>";
                                }
                            } else {
                                echo "<option disabled>No branches available</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="username" class="col-sm-4 col-form-label">Username :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" id="username" required>

                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="nama_admin" class="col-sm-4 col-form-label">Nama Admin:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_admin" id="nama_admin" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="alamat" class="col-sm-4 col-form-label">Alamat :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="no_telp" class="col-sm-4 col-form-label">Nomor Telepon :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_telp" id="no_telp" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="jabatan" class="col-sm-4 col-form-label">Jabatan :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="pass" class="col-sm-4 col-form-label">Password :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="pass" id="pass" required>
                    </div>
                </div>

                <input type="hidden" name="old_username">


                <div class="d-grid gap-2">
                    <button class="btn btn-mainColor mt-3" id="AddCabang" type="submit">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function back() {
    window.history.back();
}
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const idCabang = urlParams.get('id_cabang');
    const username = urlParams.get('username');
    const namaAdmin = urlParams.get('nama_admin');
    const alamat = urlParams.get('alamat');
    const noTelp = urlParams.get('no_telp');
    const jabatan = urlParams.get('jabatan');
    const pass = urlParams.get('pass');
    const oldUsername = urlParams.get('username');

    const updateForm = document.getElementById("updateForm");

    if (idCabang && username && namaAdmin && alamat && noTelp && jabatan && pass) {
        updateForm.querySelector('select[name="cabang"]').value = idCabang;
        updateForm.querySelector('input[name="username"]').value = username;
        updateForm.querySelector('input[name="nama_admin"]').value = namaAdmin;
        updateForm.querySelector('input[name="alamat"]').value = alamat;
        updateForm.querySelector('input[name="no_telp"]').value = noTelp;
        updateForm.querySelector('input[name="jabatan"]').value = jabatan;
        updateForm.querySelector('input[name="pass"]').value = pass;
        updateForm.querySelector('input[name="old_username"]').value = oldUsername;


    }
}
</script>