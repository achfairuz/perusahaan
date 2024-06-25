<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-mainColor fw-bold">Admin Cabang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="?page=formAddAdmin"><button type="button" id="tambah"
                class="btn btn-sm text-color btn-outline-secondary">
                <span data-feather="plus"></span> Tambah Admin
            </button></a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm text-center">
        <thead class="border-color">
            <tr>
                <th scope="col" class="px-3">NO</th>
                <th scope="col" class="px-3">Username</th>
                <th scope="col" class="px-3">Nama</th>
                <th scope="col" class="px-3">Alamat</th>
                <th scope="col" class="px-3">No Telepon</th>
                <th scope="col" class="px-3">Jabatan</th>
                <th scope="col" class="px-3">Pass</th>
                <th scope="col" class="px-3">Cabang</th>
                <th scope="col" class="px-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../koneksi.php";
            $no = 1;
            $sql = "SELECT user.*, cabang.nama_cabang FROM user, cabang WHERE user.id_cabang = cabang.id_cabang AND user.role = 'admin cabang' ORDER BY user.username ASC";
            $result = $koneksi->query($sql);

            while ($a = $result->fetch_array()) {
            ?>
            <tr>
                <td class="p-3"><?php echo $no++; ?></td>
                <td class="p-3"><?php echo $a['username']; ?></td>
                <td class="p-3"><?php echo $a['nama']; ?></td>
                <td class="p-3"><?php echo $a['alamat']; ?></td>
                <td class="p-3"><?php echo $a['no_telp']; ?></td>
                <td class="p-3"><?php echo $a['jabatan']; ?></td>
                <td class="p-3"><?php echo $a['pass']; ?></td>
                <td class="p-3"><?php echo $a['nama_cabang']; ?></td>
                <td class="p-3">
                    <a
                        href="?page=formUpdateAdmin&id_cabang=<?php echo $a['id_cabang']; ?>&username=<?php echo $a['username']; ?>&nama_admin=<?php echo $a['nama']; ?>&alamat=<?php echo $a['alamat']; ?>&no_telp=<?php echo $a['no_telp']; ?>&jabatan=<?php echo $a['jabatan']; ?>&pass=<?php echo $a['pass']; ?>">
                        <button class="btn btn-update text-primary">Update</button>
                    </a>
                    <button class="btn btn-delete text-danger" data-id="<?php echo $a['username']; ?>">Delete</button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<!-- POP up delete -->
<div id="popupDelete" class="popup popupdelete">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Apakah Anda Ingin Menghapusnya ?
            </h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-danger mt-3" id="confirmDelete">Delete</button>
            <button class="btn btn-secondary mt-3" id="cancel">Cancel</button>

        </div>
    </div>
</div>


<script>
// Delete
let deleteHref = '';

document.querySelectorAll(".btn-delete").forEach(button => {
    button.addEventListener("click", function() {
        deleteHref = 'CRUD.php?stts=deleteAdminCabang&username=' + this.getAttribute(
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