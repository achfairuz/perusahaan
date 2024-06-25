<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "perusahaandagang";
$koneksi = mysqli_connect($host, $username, $password, $database);
if($koneksi){
    echo "";
}else{
    echo "Server Not Connected";
}
?>