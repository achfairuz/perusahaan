<?php
session_start();
include "../koneksi.php";
$status = isset($_GET["stts"]) ? $_GET["stts"] : '';


// Penambahan karyawan
if ($status == 'addKaryawan' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['pass'];

    $usernameSession = $_SESSION['username'];
    $sqlcabang = "SELECT id_cabang FROM user where username = '$usernameSession' ";
    $id = $koneksi->query($sqlcabang)->fetch_assoc();
    $id_cabang = $id['id_cabang'];

    // Periksa apakah username sudah ada
    $cek_username = "SELECT * FROM user WHERE username = '$username'";
    $result_cek = $koneksi->query($cek_username);

    if ($result_cek->num_rows > 0) {
        // Jika username sudah ada, berikan pesan kesalahan
        echo "<script>alert('Username sudah digunakan, silakan gunakan username lain.'); window.history.back();</script>";
        exit();
    } else {
        // Jika username belum ada, tambahkan karyawan baru
        $sql = "INSERT INTO user(username,nama,alamat,no_telp,jabatan,pass,role,id_cabang) VALUES ('$username','$nama_karyawan','$alamat','$no_telp','$jabatan','$pass','karyawan','$id_cabang')";
        $result = $koneksi->query($sql);

        if ($result === true) {
            echo "<script>alert('Data Berhasil di Masukkan!'); document.location.href = 'index.php?page=showKaryawan';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
} elseif ($status == 'updateKaryawan') {
    $username = $_POST['username'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['pass'];


    $sql = "UPDATE user SET  nama='$nama_karyawan', alamat='$alamat', no_telp='$no_telp', jabatan='$jabatan', pass='$pass' WHERE username='$username'";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Karyawan berhasil diperbarui'); document.location.href = 'index.php?page=showKaryawan'; </script>";
    } else {
        echo "<script>alert('Error: " . $koneksi->error . "');</script>";
    }
} elseif ($status == 'deleteAdminCabang') {
    $username = $_GET['username'];

    $sql = "DELETE FROM user WHERE username = '$username'";
    $result = $koneksi->query($sql);

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>document.location.href = 'index.php?page=showKaryawan';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'addCategory') {

    $nama_kategori = $_POST['nama_kategori'];

    $sql = "INSERT INTO kategoriproduk(nama_kategori) VALUES ('$nama_kategori')";

    $result =  $koneksi->query($sql);

    if ($result === true) {
        echo "<script>alert('kategori berhasil ditambahkan'); document.location.href = 'index.php?page=product'; </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'updateKategori') {
    $id_kategori = $_GET['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "UPDATE kategoriproduk SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
    $result =  $koneksi->query($sql);

    if ($result === true) {
        echo "<script>alert('kategori berhasil diperbarui'); document.location.href = 'index.php?page=product'; </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'deletekategori') {
    $id_kategori = $_GET['id_kategori'];

    $sql = "DELETE FROM kategoriproduk WHERE id_kategori = $id_kategori";

    if ($koneksi->query($sql) === true) {
        echo "<script>document.location.href = 'index.php?page=product';</script>";
        exit();
    } else {
        # code...
    }
} elseif ($status == 'addProduk' && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_SESSION['username'];
    // Dapatkan id_cabang dari admin yang sedang login
    $sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username' AND role = 'admin cabang'";
    $result_cabang = $koneksi->query($sql_cabang);

    if ($result_cabang && $result_cabang->num_rows > 0) {
        $row_cabang = $result_cabang->fetch_assoc();
        $id_cabang = $row_cabang['id_cabang'];
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }

    // Pastikan pengguna sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php");
        exit();
    }

    $username = $_SESSION['username'];

    // mendapatkan id cabang dari admin tng login
    $sql_cabang = "SELECT id_cabang FROM user WHERE username = '$username' AND role = 'admin cabang'";
    $result_cabang = $koneksi->query($sql_cabang);

    if ($result_cabang && $result_cabang->num_rows > 0) {
        $row_cabang = $result_cabang->fetch_assoc();
        $id_cabang = $row_cabang['id_cabang'];
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }

    $kategori = $_POST['kategori'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];

    // tempat penyimpanan sementara untuk upload gambar
    $file_name = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $file_type = $_FILES['gambar']['type'];
    $file_error = $_FILES['gambar']['error'];

    $file_name = preg_replace('/\s+/', '_', $file_name); // nama file gambar
    $lokasi_file = "../uploads/produk/" . $file_name;

    if (move_uploaded_file($file_tmp, $lokasi_file)) {
        $sql = "INSERT INTO produk (id_kategori, nama_produk, gambar, harga, deskripsi, stok, id_cabang) VALUES ('$kategori', '$nama_produk', '$lokasi_file', '$price', '$deskripsi', '$stok','$id_cabang')";

        if ($koneksi->query($sql) === TRUE) {
            echo "<script>alert('Data Berhasil di Masukkan!'); document.location.href = 'index.php?page=product';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        echo "<script>alert('Gagal Upload File!'); document.location.href = 'index.php?page=product';</script>";
    }
} elseif (isset($_GET['stts']) && $_GET['stts'] == 'updateProduk') {
    $id_produk = $_GET['id_produk'];
    $kategori = $_POST['kategori'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $existing_image = $_POST['existing_image'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $lokasi_file = "../uploads/produk/";
        $target_file = $lokasi_file . basename($gambar);

        // Memastikan direktori unggahan ada dan dapat ditulisi
        if (!is_dir($lokasi_file) || !is_writable($lokasi_file)) {
            die("Lokasi Tidak di ketahui");
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = $target_file;
        } else {
            die("Gagal mengunggah file.");
        }
    } else {
        // Menyimpan gambar yang ada jika tidak ada gambar baru diunggah
        $gambar = $existing_image;
    }

    $sql = "UPDATE produk SET id_kategori='$kategori', nama_produk = '$nama_produk', deskripsi='$deskripsi', harga='$price', gambar='$gambar', stok= '$stok' WHERE id_produk='$id_produk'";
    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Data Berhasil di Ubah!'); document.location.href = 'index.php?page=product';</script>";
        exit();
    } else {
        echo "Error updating record: " . $koneksi->error;
    }
} elseif ($status == 'deleteProduk') {
    $id_produk = $_GET['id_produk'];

    $sqlDelete = "DELETE FROM produk WHERE id_produk = '$id_produk'";
    if ($result = $koneksi->query($sqlDelete) === true) {
        echo "<script>document.location.href = 'index.php?page=product';</script>";
        exit();
    } else {
        echo "Error Delete : " . $koneksi->error;
    }
} elseif ($status == 'ajukanCuti') {
    $username = $_SESSION['username'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $alasan = $_POST['alasan'];
    $status_cuti = 'Diajukan'; // Misalnya, set status cuti menjadi "Diajukan" saat pertama kali diajukan

    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];

    if ($tipe_file == 'application/pdf' || $tipe_file == 'application/msword') {
        $ukuranMaksFile = 2 * 1024 * 1024;
        if ($ukuran_file <= $ukuranMaksFile) {

            $lokasi_upload = "../uploads/surat cuti/";
            $target = $lokasi_upload . $file;
            // memindahkan file ke target
            if (move_uploaded_file($file_tmp, $target)) {
                $sql = "INSERT INTO cuti (username, tanggal_mulai, tanggal_selesai, file, alasan, status_cuti) 
                    VALUES ('$username', '$tanggal_mulai', '$tanggal_selesai', '$file', '$alasan', '$status_cuti')";

                if ($koneksi->query($sql) === true) {
                    echo "<script>
                alert('Cuti berhasil diajukan.'); 
                window.location.href = 'index.php?page=cuti';
                </script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $koneksi->error;
                }
            } else {
                echo "<script>
                alert('Folder Tidak Ditemukan'); 
                window.location.href = 'index.php?page=formCuti';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('Ukuran File Melebihi Batas (2MB)'); 
                window.location.href = 'index.php?page=formCuti';
                </script>";
            exit();
        }
    } else {
        echo "<script>
                 alert('Tipe file tidak diizinkan. Harap unggah file dalam format PDF atau Word.'); 
                window.location.href = 'index.php?page=formCuti';
                </script>";
        exit();
    }
} elseif ($status == 'update_cuti') {

    $id_cuti = $_POST['id_cuti'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $alasan = $_POST['alasan'];

    // Cek apakah file diunggah
    if ($_FILES['file']['error'] == 0) {

        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $ukuran_file = $_FILES['file']['size'];
        $tipe_file = $_FILES['file']['type'];

        $jenis_file =   array('application/pdf', 'application/msword');

        if (in_array($tipe_file, $jenis_file)) {
            $ukuranMaksFile = 2 * 1024 * 1024;
            if ($ukuran_file <= $ukuranMaksFile) {

                $lokasi_upload = "../uploads/surat cuti/";
                $target = $lokasi_upload . $file;
                // memindahkan file ke target
                if (move_uploaded_file($file_tmp, $target)) {
                    // Update data cuti ke database dengan data file yang baru
                    $sql = "UPDATE cuti SET tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', file='$file_name', alasan='$alasan' WHERE id_cuti='$id_cuti'";

                    if ($koneksi->query($sql) === true) {
                        echo "<script>
                alert('Cuti berhasil diajukan.'); 
                window.location.href = 'index.php?page=cuti';
                </script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $koneksi->error;
                    }
                } else {
                    echo "<script>
                alert('Folder Tidak Ditemukan'); 
                window.location.href = 'index.php?page=cuti';
                </script>";
                    exit();
                }
            } else {
                echo "<script>
                alert('Ukuran File Melebihi Batas (2MB)'); 
                window.location.href = 'index.php?page=cuti';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                 alert('Tipe file tidak diizinkan. Harap unggah file dalam format PDF atau Word.'); 
                window.location.href = 'index.php?page=cuti';
                </script>";
            exit();
        }
    } else {
        // Jika tidak ada file yang diunggah, gunakan file yang ada sebelumnya
        $file = $_POST['file'];
    }

    // Update data cuti ke database dengan data file yang lama
    $sql = "UPDATE cuti SET tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', alasan='$alasan' WHERE id_cuti='$id_cuti'";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Cuti berhasil diperbarui.'); window.location.href = 'index.php?page=cuti';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'batal_cuti') {
    $id_cuti = $_GET['id_cuti'];

    $sql = "DELETE FROM cuti WHERE id_cuti = '$id_cuti'";
    if ($koneksi->query($sql) === true) {
        echo "<script> window.location.href = 'index.php?page=cuti';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} elseif ($status == 'absensiKaryawan') {  //Multi Insert Untuk Absensi
    $tanggal = $_POST['tanggal'];
    $jumlahKaryawan = $_POST['jumlahKaryawan'];
    for ($i = 1; $i <= $jumlahKaryawan; $i++) {
        $username = $_POST['username' . $i];
        $keterangan = $_POST['keterangan_' . $username];
        $sql = "INSERT INTO absensi (username, tanggal, keterangan) VALUES ('$username','$tanggal','$keterangan')";
        $result = $koneksi->query($sql);
    }
    if ($result === true) {
        echo "<script>alert('Semua Data Absensi Berhasil Disimpan!!!'); window.location.href = 'index.php?page=absensiKaryawan';</script>";
    } else {
        echo 'Error' . $koneksi->error;
    }
} elseif ($status == 'updateAbsensi') {
    $id_absensi = $_POST['id_absensi'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    foreach ($id_absensi as $index => $id) {
        $sql = "UPDATE absensi SET keterangan ='$keterangan[$index]' WHERE id_absensi = '$id' AND tanggal ='$tanggal'";
        $result = $koneksi->query($sql);
    }
    if ($result === true) {
        echo "<script>alert('Semua Data Absensi  Berhasil DiUpdate!!!'); window.location.href = 'index.php?page=absensiKaryawan';</script>";
    } else {
        echo "<script>alert('Data Tidak Ditemukan')</script>";
    }
} elseif ($status == 'multideleteabsen') {
    $id_absensi = $_POST['delete_ids'];
    foreach ($id_absensi as $index => $id) {
        $sql = "DELETE FROM absensi WHERE id_absensi = '$id_absensi[$index]'";
        $result = $koneksi->query($sql);
    }
    if ($result === true) {
        echo "<script>alert('Semua Data Berhasil Dihapus!!!'); window.location.href = 'index.php?page=absensiKaryawan';</script>";
    } else {
        echo "<script>alert('Data Tidak Ditemukan')</script>";
    }
} elseif ($status == 'tambahStok') {
    $id_produk = $_POST['id_produk'];
    $stok = $_POST['jumlah_stok'];
    $stoksaatini = $_POST['stok_saat_ini'];

    $updatestok = $stoksaatini + $stok;
    $sql = "UPDATE produk SET stok = '$updatestok' where id_produk = '$id_produk' ";
    if ($koneksi->query($sql) === true) {
        echo "<script>alert('Berhasil Menambahkan Stok !!!'); window.location.href = 'index.php?page=product';</script>";
    } else {
        echo "<script>alert('Gagal)</script>";
    }
}
