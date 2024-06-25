<div class="title d-flex justify-content-between align-items-center mt-4 px-4">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer;"></span>
    <div class="container position-relative z-index-1 p-2">
        <h2 class="text-mainColor fw-bold text-center">Pembayaran</h2>
    </div>
</div>

<div class="bg-light position-relative z-index-0 border rounded mt-3">
    <div class="container p-2 mt-4 mb-5">
        <div class="row justify-content-center p-2">
            <div class="col-md-8 p-2">
                <form action="CRUD.php?stts=pembayaran" method="post">
                    <?php
                    session_start();
                    $username = $_SESSION['username'];
                    $id_order = $_GET['order_id'];
                    $sql = "SELECT * FROM orders WHERE id_order = '$id_order'";
                    $result = $koneksi->query($sql);
                    while ($a = $result->fetch_assoc()) {
                        $total_harga = $a['total_harga'];
                    ?>
                    <input type="hidden" name="id_order" value="<?php echo $id_order ?>">

                    <div class="mb-3">
                        <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                        <input type="text" class="form-control" name="total_pembayaran" id="total_pembayaran"
                            value="<?php echo $total_harga; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" id="metode_pembayaran"
                            onchange="checkPaymentMethod()">
                            <option value="cash">Tunai</option>
                            <option value="Qris">Qris</option>
                            <option value="transfer bank BCA">Transfer Bank BCA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="uang_terima" class="form-label">Uang Diterima</label>
                        <input type="number" name="uang_terima" class="form-control" id="uang_terima">
                    </div>
                    <input type="hidden" name="uang_kembalian" id="uang_kembalian">

                    <?php
                    }
                    ?>

                    <div class="mb-3 text-end">
                        <div class="row">
                            <div class="col">
                                <h5>Total Harga:</h5>
                            </div>
                            <div class="col text-end">
                                <h5>Rp. <?php echo $total_harga; ?></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5>Uang Diterima:</h5>
                            </div>
                            <div class="col text-end">
                                <h5 id="uang_terima_display">Rp. </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5>Kembalian:</h5>
                            </div>
                            <div class="col text-end">
                                <h5 id="uang_kembali_display"></h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function checkPaymentMethod() {
    var selectedMethod = document.getElementById("metode_pembayaran").value;
    var uangTerimaInput = document.getElementById("uang_terima");
    var totalHarga = parseFloat(document.getElementById("total_pembayaran").value);

    if (selectedMethod === "Qris" || selectedMethod === "transfer bank BCA") {
        uangTerimaInput.value = totalHarga;
        uangTerimaInput.disabled = true;
        document.getElementById("uang_terima_display").innerText = 'Rp. ' + totalHarga;
        document.getElementById("uang_kembali_display").innerText = 'Rp. 0';
        document.getElementById("uang_kembalian").value = 0;
    } else {
        uangTerimaInput.value = "";
        uangTerimaInput.disabled = false;
        document.getElementById("uang_terima_display").innerText = 'Rp. ';
        document.getElementById("uang_kembali_display").innerText = 'Rp. ';
        document.getElementById("uang_kembalian").value = '';
    }
}

document.getElementById("uang_terima").addEventListener("input", function() {
    var totalHarga = parseFloat(document.getElementById("total_pembayaran").value);
    var uangTerima = parseFloat(this.value);
    var uangKembali = uangTerima - totalHarga;

    document.getElementById("uang_terima_display").innerText = uangTerima ? 'Rp. ' + uangTerima : 'Rp. ';
    document.getElementById("uang_kembali_display").innerText = uangKembali >= 0 ? 'Rp. ' + uangKembali :
        'Rp. ';
    document.getElementById("uang_kembalian").value = uangKembali >= 0 ? uangKembali : 0;
});

function back() {
    window.location.href = '?page=daftar_transaksi';
}
</script>