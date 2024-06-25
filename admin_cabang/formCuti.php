<div class="title d-flex justify-content-between align-items-center mt-4 px-4 ">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <div class="container">
        <h2 class="text-mainColor fw-bold text-center">Ajukan Cuti</h2>
    </div>

</div>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <form action="CRUD.php?stts=ajukanCuti" method="POST" enctype="multipart/form-data">
                <div class=" mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Cuti:</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai Cuti:</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Surat Cuti:</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Cuti:</label>
                    <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
            </form>
        </div>
    </div>
</div>

<script>
function back() {
    window.history.back();
}
</script>