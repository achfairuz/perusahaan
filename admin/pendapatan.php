<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

// Check if a branch is selected
if (isset($_POST['cabangSelect'])) {
    $selectedCabang = $_POST['cabangSelect'];
} else {
    $selectedCabang = ''; // Default to show all branches
}

// Fetch branches
$sqlCabang = "SELECT * FROM cabang";
$resultCabang = $koneksi->query($sqlCabang);
?>


<body>
    <div class="container mt-5">
        <h1 class="text-primary">Pendapatan Cabang</h1>

        <form method="post">
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="cabangSelect" class="form-label">Pilih Cabang:</label>
                        <select class="form-select" name="cabangSelect" id="cabangSelect" onchange="this.form.submit()">
                            <option value="">Semua Cabang</option>
                            <?php while ($cabangData = $resultCabang->fetch_assoc()) { ?>
                            <option value="<?php echo $cabangData['id_cabang']; ?>"
                                <?php echo ($selectedCabang == $cabangData['id_cabang']) ? 'selected' : ''; ?>>
                                <?php echo $cabangData['nama_cabang']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display pendapatan based on selected branch
                if ($selectedCabang !== '') {
                    $queryPendapatan = "SELECT pendapatan.*, cabang.*, DATE_FORMAT(pendapatan.bulandantahun,'%M-%Y') as formatTanggal 
                                    FROM pendapatan 
                                    JOIN cabang ON cabang.id_cabang = pendapatan.id_cabang 
                                    WHERE cabang.id_cabang = '$selectedCabang'";
                } else {
                    $queryPendapatan = "SELECT pendapatan.*, cabang.*, DATE_FORMAT(pendapatan.bulandantahun,'%M-%Y') as formatTanggal 
                                    FROM pendapatan 
                                    JOIN cabang ON cabang.id_cabang = pendapatan.id_cabang";
                }

                $resultPendapatan = $koneksi->query($queryPendapatan);
                if ($resultPendapatan->num_rows > 0) {
                    while ($pendapatanData = $resultPendapatan->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $pendapatanData['formatTanggal'] . "</td>";
                        echo "<td>" . $pendapatanData['nama_cabang'] . "</td>";
                        echo "<td>Rp. " . number_format($pendapatanData['totalpendapatan'], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>Data Kosong</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>