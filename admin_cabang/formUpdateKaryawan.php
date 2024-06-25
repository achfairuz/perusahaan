<div class="title d-flex justify-content-between align-items-center mt-4 px-4">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <div class="container">
        <h2 class="text-mainColor fw-bold text-center">Update Karyawan</h2>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php
            include "../koneksi.php";
            $username = $_GET['username'];
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $result = $koneksi->query($sql);
            $a = $result->fetch_assoc();
            ?>
            <form role="form" action="CRUD.php?stts=updateKaryawan" method="POST" id="updateForm">
                <div class="mb-2 row">
                    <label for="username" class="col-sm-4 col-form-label">Username :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?php echo $a['username'] ?>" id="username" disabled>
                        <input type="hidden" class="form-control" name="username" value="<?php echo $a['username'] ?>" id="username_hidden">
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="nama_karyawan" class="col-sm-4 col-form-label">Nama Karyawan:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" value="<?php echo $a['nama'] ?>" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="alamat" class="col-sm-4 col-form-label">Alamat :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $a['alamat'] ?>" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="no_telp" class="col-sm-4 col-form-label">Nomor Telepon :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?php echo $a['no_telp'] ?>" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="jabatan" class="col-sm-4 col-form-label">Jabatan :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?php echo $a['jabatan'] ?>" required>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="pass" class="col-sm-4 col-form-label">Password :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="pass" id="pass" value="<?php echo $a['pass'] ?>" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-mainColor mt-3" type="submit">Update Karyawan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function back() {
        window.history.back();
    }
</script>