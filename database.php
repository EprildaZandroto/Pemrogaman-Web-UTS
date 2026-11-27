<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "`KEEPly app`";

$conn = mysqli_connect($host, $user, $pass, "KEEPly app");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>