<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pembayaran</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid black;
}

th {
    background-color: #f2f2f2;
    padding: 10px;
    text-align: left;
}

td {
    padding: 8px;
    text-align: left;
}

    </style>
</head>
<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'index.php') : ?>
            <li><a href="index.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
    </header>
    <h2>Detail Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Nama Customer</th>
                <th>Tanggal Transaksi</th>
                <th>Metode Pembayaran</th>
                <th>Total Bayar</th>
                <th>Diskon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Koneksi ke database
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'penjualan_roti';

            $koneksi = new mysqli($host, $username, $password, $database);

            // Periksa koneksi
            if ($koneksi->connect_error) {
                die("Koneksi gagal: " . $koneksi->connect_error);
            }

            // Query untuk mengambil data transaksi dari tabel transaksi
            $sql_transaksi = "SELECT t.id_transaksi, c.nama_customer, t.tanggal_transaksi, t.metode_pembayaran, t.total_bayar, t.diskon 
                              FROM transaksi t
                              INNER JOIN customer c ON t.id_customer = c.id_customer
                              ORDER BY t.tanggal_transaksi DESC";

            $result_transaksi = $koneksi->query($sql_transaksi);

            if ($result_transaksi === FALSE) {
                echo "Error: " . $sql_transaksi . "<br>" . $koneksi->error . "<br><br>";
            }

            if ($result_transaksi->num_rows > 0) {
                // Output data dari setiap baris hasil query
                while ($row = $result_transaksi->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id_transaksi'] . '</td>';
                    echo '<td>' . $row['nama_customer'] . '</td>';
                    echo '<td>' . $row['tanggal_transaksi'] . '</td>';
                    echo '<td>' . $row['metode_pembayaran'] . '</td>';
                    echo '<td>Rp ' . number_format($row['total_bayar'], 0, ',', '.') . '</td>';
                    echo '<td>Rp ' . number_format($row['diskon'], 0, ',', '.') . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">Tidak ada data transaksi yang ditemukan</td></tr>';
            }

            // Tutup koneksi ke database
            $koneksi->close();
            ?>
        </tbody>
    </table>
</body>
</html>
