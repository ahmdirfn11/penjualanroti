<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            margin-bottom: 20px;
        }
        header h2 {
            margin: 0;
        }
        header li {
            display: inline;
            margin-right: 10px;
        }
        header a {
            color: #fff;
            text-decoration: none;
        }
        header a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'header.php') : ?>
            <li><a href="header.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
    </header>
    <h2>Laporan Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
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

            // Query untuk mengambil data transaksi dari tabel transaksi dan customer
            $sql_transaksi = "SELECT t.id_transaksi, c.nama_customer, c.email, c.no_hp, c.alamat, t.tanggal_transaksi, t.metode_pembayaran, t.total_bayar, t.diskon 
                            FROM transaksi t
                            INNER JOIN customer c ON t.id_customer = c.id_customer
                            ORDER BY t.tanggal_transaksi DESC";

            $result_transaksi = $koneksi->query($sql_transaksi);

            // Periksa hasil query
            if ($result_transaksi === false) {
                echo "Error: " . $koneksi->error;
            } elseif ($result_transaksi->num_rows > 0) {
                while ($row = $result_transaksi->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id_transaksi'] . '</td>';
                    echo '<td>' . $row['nama_customer'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['no_hp'] . '</td>';
                    echo '<td>' . $row['alamat'] . '</td>';
                    echo '<td>' . $row['tanggal_transaksi'] . '</td>';
                    echo '<td>' . $row['metode_pembayaran'] . '</td>';
                    echo '<td>Rp ' . number_format($row['total_bayar'], 0, ',', '.') . '</td>';
                    echo '<td>' . $row['diskon'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="9">Tidak ada data transaksi yang ditemukan</td></tr>';
            }

            // Tutup koneksi ke database
            $koneksi->close();
            ?>
        </tbody>
    </table>
</body>
</html>
