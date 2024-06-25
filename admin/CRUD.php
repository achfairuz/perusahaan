<?php
include "../koneksi.php";
$status = isset($_GET["stts"]) ? $_GET["stts"] : '';

if ($status == 'insert' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_cabang = $_POST['nama_cabang'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO cabang (nama_cabang, alamat) VALUES ('$nama_cabang', '$alamat')";

    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        alert('Data Berhasil di Masukkan!');
        document.location.href = 'index.php?page=cabang';
        </script>
        ";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'update') {
    $id_cabang = $_GET['id_cabang'];
    $nama_cabang = $_POST['nama_cabang'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE cabang SET nama_cabang='$nama_cabang', alamat='$alamat' WHERE id_cabang='$id_cabang'";
    if ($koneksi->query($sql) === TRUE) {
        echo "
            <script>
            alert('Data Berhasil di Update!');
            document.location.href = 'index.php?page=cabang';
            </script>
            ";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'delete') {
    $id_cabang = $_GET['id_cabang'];

    $sql = "DELETE FROM cabang WHERE id_cabang='$id_cabang'";
    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        document.location.href = 'index.php?page=cabang';
        </script>
        ";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'addAdminCabang' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['pass'];
    $id_cabang = $_POST['cabang'];

    // Insert data into database
    $sql = "INSERT INTO user (username, nama, alamat, no_telp, jabatan, pass, role, id_cabang)
            VALUES ('$username', '$nama_admin', '$alamat', '$no_telp', '$jabatan', '$pass', 'admin cabang', '$id_cabang')";

    if ($koneksi->query($sql) === TRUE) {

        echo "<script>alert('Admin cabang berhasil ditambahkan'); document.location.href = 'index.php?page=admin_cabang'; </script>";
    } else {

        echo "<script>alert('Error: " . $koneksi->error . "');</script>";
    }
} elseif ($status == 'updateAdminCabang') {
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['pass'];
    $id_cabang = $_POST['cabang'];
    $old_username = $_POST['old_username']; // Menggunakan username lama untuk WHERE clause

    // Update data in the database
    $sql = "UPDATE user SET username='$username', id_cabang='$id_cabang', nama='$nama_admin', alamat='$alamat', no_telp='$no_telp', jabatan='$jabatan', pass='$pass' WHERE username='$old_username'";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Admin cabang berhasil diperbarui'); document.location.href = 'index.php?page=admin_cabang'; </script>";
    } else {
        echo "<script>alert('Error: " . $koneksi->error . "');</script>";
    }
} elseif ($status == 'deleteAdminCabang') {
    $username = $_GET['username'];

    $sql = "DELETE FROM user WHERE username = '$username'";
    $result = $koneksi->query($sql);

    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        document.location.href = 'index.php?page=admin_cabang';
        </script>
        ";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'setuju') {
    $id_cuti = $_GET['id_cuti'];

    $sql = "UPDATE cuti SET status_cuti = 'Disetujui' WHERE id_cuti = '$id_cuti'";
    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        document.location.href = 'index.php?page=daftarCuti';
        </script>
        ";
        exit();
    } else {
        echo "
        <script>
       alert('Gagal " . $koneksi->error . "');
        </script>
        ";
        exit();
    }
} elseif ($status == 'tidaksetuju') {
    $id_cuti = $_GET['id_cuti'];

    $sql = "UPDATE cuti SET status_cuti = 'Ditolak' WHERE id_cuti = '$id_cuti'";
    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        document.location.href = 'index.php?page=daftarCuti';
        </script>
        ";
        exit();
    } else {
        echo "
        <script>
       alert('Gagal " . $koneksi->error . "');
        </script>
        ";
        exit();
    }
}
?>

?>