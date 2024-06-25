<?php
include "koneksi.php";
$status = $_GET["stts"];

if ($status == 'login') {
    $username =  $_POST['username'];
    $pass =  $_POST['pass'];

    $sql = "SELECT * FROM user WHERE username = '$username' AND pass = '$pass'";
    $cek = $koneksi->query($sql);

    if ($cek->num_rows > 0) {
        $user = $cek->fetch_assoc();
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Ambil id_cabang dari user yang sesuai
        $_SESSION['id_cabang'] = $user['id_cabang'];

        if ($user['role'] == 'admin') {
            header("Location: admin/index.php");
            exit();
        } elseif ($user['role'] == 'admin cabang') {
            header("Location:admin_cabang/index.php");
            exit();
        } elseif ($user['role'] == 'karyawan') {
            header("Location:karyawan/index.php");
            exit();
        } else {
            echo "<script>
                alert('role tidak ditemukan, Silahkan Login Kembali!!!');
                window.location.href='login.php';
              </script>";
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan, Silahkan Login Kembali!!!');
                window.location.href='login.php';
              </script>";
    }
}
