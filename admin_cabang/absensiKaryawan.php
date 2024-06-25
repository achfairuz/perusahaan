<?php
include "../koneksi.php";
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

// Mencari id_cabang dari admin_cabang yang login
$sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username' AND role = 'admin cabang'";
$result = $koneksi->query($sql_cabang);

if ($result && $result->num_rows > 0) {
    $a = $result->fetch_assoc();
    $id_cabang = $a['id_cabang'];
} else {
    echo "Data tidak ditemukan.";
    exit();
}

$no = 1;
$sql = "SELECT absensi.id_absensi, user.nama, absensi.tanggal, absensi.keterangan, DATE_FORMAT(absensi.tanggal, '%d-%m-%Y') AS formatted_date
        FROM absensi 
        JOIN user ON user.username = absensi.username 
        WHERE user.role = 'karyawan'
        AND user.id_cabang = '$id_cabang'
        ORDER BY absensi.tanggal ASC";
$result = $koneksi->query($sql);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mt-3">
    <h2 class="h2">Absensi Karyawan</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="?page=formAbsensi" class="btn btn-sm btn-outline-secondary btn-add-category">
            <span data-feather="plus"></span>
            Tambah Absensi
        </a>
        <a href="#" class="btn btn-sm btn-danger ms-2" id="deleteButton">
            <span data-feather="trash"></span>
            Hapus Terpilih
        </a>
    </div>
</div>

<!--Table -->
<form method="POST" action="CRUD.php?stts=multideleteabsen" id="deleteForm">
    <div class="table-responsive mt-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mt-3">
            <h3>Absensi</h3>
            <div class="input d-flex flex-row mb-3 justify-content-end">
                <input type="date" class="p-1 rounded input datepicker" name="tanggal" id="searchInput" placeholder="Pilih tanggal" aria-label="Pilih tanggal" aria-describedby="searchButton">
                <button class="btn btn-primary ms-2" type="button" id="updateButton">Update</button>
            </div>
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" class="d-flex align-items-center"><input type="checkbox" id="selectAll"></th>
                    <th scope="col">No</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col" style="display: none;">ID Absensi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($a = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td class="align-middle"><input type="checkbox" class="delete-checkbox" name="delete_ids[]" value="<?php echo $a['id_absensi']; ?>"></td>
                        <td class="align-middle"><?php echo $no++; ?></td>
                        <td class="align-middle"><?php echo $a['nama']; ?></td>
                        <td class="align-middle"><?php echo $a['formatted_date']; ?></td>
                        <td class="align-middle"><?php echo $a['keterangan']; ?></td>
                        <td class="align-middle" style="display: none;"><?php echo $a['id_absensi']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="delete" value="true">
</form>

<script>
    document.getElementById('updateButton').addEventListener('click', function() {
        var tanggal = document.getElementById('searchInput').value;
        if (tanggal) {
            var url = '?page=updateAbsensi&tanggal=' + tanggal;
            window.location.href = url;
        } else {
            alert('Silakan pilih tanggal terlebih dahulu.');
        }
    });

    document.getElementById('deleteButton').addEventListener('click', function(event) {
        event.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
            document.getElementById('deleteForm').submit();
        }
    });

    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.delete-checkbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>