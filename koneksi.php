<?php
// koneksi.php
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "penjualan_roti"; // Ganti dengan nama database Anda

// Membuat koneksi
$koneksi = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>


