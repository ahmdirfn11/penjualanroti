<?php
// Koneksi ke database (ganti dengan informasi koneksi sesuai kebutuhan)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'penjualan_roti';

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil nilai dari formulir
$nama_customer = $_POST['nama_customer'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat_customer = $_POST['alamat_customer'];

// Query untuk menyimpan data customer ke tabel customer
$sql_customer = "INSERT INTO customer (nama_customer, email, no_hp, alamat_customer)
                VALUES ('$nama_customer', '$email', '$no_hp', '$alamat_customer')";

if ($koneksi->query($sql_customer) === TRUE) {
    echo "Data customer berhasil disimpan.";
} else {
    echo "Error: " . $sql_customer . "<br>" . $koneksi->error;
}

// Proses untuk menyimpan data penjualan roti (jumlah beli roti) bisa ditambahkan di sini

// Tutup koneksi ke database
$koneksi->close();
?>
