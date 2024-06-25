<div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-2" style="border-bottom: 1px solid black;">
    <h2 class="fw-bold text-mainColor">Daftar Cuti</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="?page=formCuti">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-ajukan-ajuanCuti">
                <span data-feather="plus"></span>
                Ajukan Cuti
            </button>
        </a>
    </div>
</div>

<!-- SHOW CUTI -->
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr class="text-center">
                <th scope="col">NO</th>
                <th scope="col" class="px-3">Nama</th>
                <th scope="col" class="px-3">Cabang</th>
                <th scope="col" class="px-3">Tanggal Mulai</th>
                <th scope="col" class="px-3">Tanggal Selesai</th>
                <th scope="col" class="px-3">Berkas</th>
                <th scope="col" class="px-3">Alasan</th>
                <th scope="col" class="px-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = "SELECT cuti.*, user.*, cabang.*, DATE_FORMAT(cuti.tanggal_mulai, '%d %M %Y') AS format_tanggal_mulai, DATE_FORMAT(cuti.tanggal_selesai, '%d %M %Y') AS format_tanggal_selesai FROM cuti JOIN user ON user.username = cuti.username JOIN cabang ON cabang.id_cabang = user.id_cabang ORDER BY cuti.tanggal_mulai ASC";

            $result = $koneksi->query($sql);

            // Memeriksa apakah ada data cuti
            if ($result->num_rows > 0) {
                while ($a = $result->fetch_assoc()) {
                    $id_cuti = $a['id_cuti'];
            ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td class="p-3"><?php echo $a['nama']; ?></td>
                        <td class="p-3"><?php echo $a['nama_cabang']; ?></td>
                        <td class="p-3"><?php echo $a['format_tanggal_mulai']; ?></td>
                        <td class="p-3"><?php echo $a['format_tanggal_selesai']; ?></td>
                        <td class="p-3"><a href="../uploads/surat cuti/<?php echo ($a['file']); ?>"><?php echo $a['file']; ?></a></td>
                        <td class="p-3"><?php echo $a['alasan']; ?></td>
                        <td class="p-3">
                            <?php if ($a['status_cuti'] == 'Diajukan') { ?>
                                <button href="?page=update_cuti&id_cuti=<?php echo $id_cuti; ?>" data-id="<?php echo $id_cuti; ?>" class=" btn btn-sm btn-danger btn-tidak-setuju-cuti my-2">Tolak</button>
                                <button class="btn btn-sm btn-success btn-setuju-cuti  my-2" data-id="<?php echo $id_cuti; ?>">Setuju</button>
                            <?php } else {
                                echo "Tidak ada aksi";
                            } ?>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada ajuan cuti.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- POPUP Setuju -->
<div id="popupsetuju" class="popup popupsetuju">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <h4 class="text-success fw-bold text-center">Apakah Anda Menyetujuinya?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-secondary mt-3 mx-2" id="cancel">Cancel</button>
            <button class="btn btn-success mt-3 mx-2" id="setuju">Setuju</button>
        </div>
    </div>
</div>

<div id="popuptidaksetuju" class="popup popuptidaksetuju">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Apakah Anda Menolaknya?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-secondary mt-3 mx-2" id="cancel">Cancel</button>
            <button class="btn btn-danger mt-3 mx-2" id="tidak_setuju">Tolak</button>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-setuju-cuti').forEach(button => {
        button.addEventListener('click', function() {
            setuju = 'CRUD.php?stts=setuju&id_cuti=' + this.getAttribute('data-id');
            document.getElementById('popupsetuju').style.display = 'block';
        });
    });

    document.querySelectorAll('.btn-tidak-setuju-cuti').forEach(button => {
        button.addEventListener('click', function() {
            tidaksetuju = 'CRUD.php?stts=tidaksetuju&id_cuti=' + this.getAttribute('data-id');
            document.getElementById('popuptidaksetuju').style.display = 'block';
        });
    });

    document.getElementById('setuju').addEventListener('click', function() {
        window.location.href = setuju;
    })

    document.getElementById('tidak_setuju').addEventListener('click', function() {
        window.location.href = tidaksetuju;
    })

    // Cancel button
    document.querySelectorAll('.btn-secondary').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.popup').forEach(popup => {
                popup.style.display = 'none';
            });
        });
    });
</script>