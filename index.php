<?php
// Periksa jika form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nama_customer = $_POST['nama_customer'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

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

    // Query untuk menyimpan data customer ke tabel customer
    $sql_customer = "INSERT INTO customer (nama_customer, email, no_hp, alamat)
                    VALUES ('$nama_customer', '$email', '$no_hp', '$alamat')";

    if ($koneksi->query($sql_customer) === TRUE) {
        echo "Data customer berhasil disimpan.<br><br>";

        // Ambil ID customer yang baru saja disimpan
        $id_customer = $koneksi->insert_id;

        // Insert ke tabel transaksi
        $tanggal_transaksi = date('Y-m-d H:i:s'); // Tanggal transaksi saat ini
        $sql_transaksi = "INSERT INTO transaksi (id_customer, tanggal_transaksi, metode_pembayaran, total_bayar, diskon)
                         VALUES ($id_customer, '$tanggal_transaksi', '$metode_pembayaran', 0, 0)";

        if ($koneksi->query($sql_transaksi) === TRUE) {
            echo "Transaksi berhasil disimpan.<br><br>";

            // Ambil ID transaksi yang baru saja disimpan
            $id_transaksi = $koneksi->insert_id;

            // Proses detail pembelian roti
            foreach ($_POST['jumlah_roti'] as $id_roti => $jumlah_beli) {
                if ($jumlah_beli > 0) {
                    // Query untuk mengambil harga roti dan stok berdasarkan ID roti
                    $sql_roti_info = "SELECT harga_roti, stok FROM roti WHERE id_roti = '$id_roti'";
                    $result_roti_info = $koneksi->query($sql_roti_info);

                    if ($result_roti_info === FALSE) {
                        echo "Error: " . $sql_roti_info . "<br>" . $koneksi->error . "<br><br>";
                    } else {
                        // Pastikan query mengembalikan hasil sebelum menggunakan num_rows
                        if ($result_roti_info->num_rows > 0) {
                            $row_roti = $result_roti_info->fetch_assoc();
                            $harga_roti = $row_roti['harga_roti'];
                            $stok_awal = $row_roti['stok'];

                            // Hitung stok baru
                            $stok_baru = $stok_awal - $jumlah_beli;

                            // Update stok roti di database
                            $sql_update_stok = "UPDATE roti SET stok = $stok_baru WHERE id_roti = '$id_roti'";
                            if ($koneksi->query($sql_update_stok) !== TRUE) {
                                echo "Error updating stok roti: " . $koneksi->error . "<br><br>";
                            }

                            // Insert detail pembelian roti ke tabel detail_penjualan_roti
                            $subtotal = $harga_roti * $jumlah_beli;
                            $sql_detail_penjualan = "INSERT INTO detail_penjualan_roti (id_transaksi, id_roti, id_customer, jumlah_beli, subtotal)
                                                    VALUES ($id_transaksi, '$id_roti', $id_customer, $jumlah_beli, $subtotal)";

                            if ($koneksi->query($sql_detail_penjualan) !== TRUE) {
                                echo "Error inserting detail penjualan roti: " . $koneksi->error . "<br><br>";
                            }
                        } else {
                            echo "Data roti dengan ID $id_roti tidak ditemukan.<br><br>";
                        }
                    }
                }
            }

            // Update total bayar dan diskon ke dalam tabel transaksi
            $sql_update_transaksi = "UPDATE transaksi SET total_bayar = (SELECT SUM(subtotal) FROM detail_penjualan_roti WHERE id_transaksi = $id_transaksi) WHERE id_transaksi = $id_transaksi";

            if ($koneksi->query($sql_update_transaksi) !== TRUE) {
                echo "Error updating total bayar transaksi: " . $koneksi->error . "<br><br>";
            }
        } else {
            echo "Error: " . $sql_transaksi . "<br>" . $koneksi->error . "<br><br>";
        }
    } else {
        echo "Error: " . $sql_customer . "<br>" . $koneksi->error . "<br><br>";
    }

    // Tutup koneksi ke database
    $koneksi->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Penjualan Roti</title>
    <style>
           
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

form input[type="text"],
form input[type="number"],
form select {
    width: calc(100% - 20px);
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

form input[type="submit"],
form input[type="button"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

form input[type="submit"]:hover,
form input[type="button"]:hover {
    background-color: #45a049;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #f5f5f5;
}
    </style>
</head>
<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'header.php') : ?>
            <li><a href="header.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
    </header>
    <h2>Form Penjualan Roti</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="nama_customer">Nama Customer:</label>
        <input type="text" id="nama_customer" name="nama_customer" required><br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="no_hp">No HP:</label>
        <input type="text" id="no_hp" name="no_hp" required><br><br>

        <label for="alamat">Alamat Customer:</label>
        <input type="text" id="alamat" name="alamat" required><br><br>
        
        <!-- Tabel untuk menampilkan detail pembelian roti -->
        <h2>Detail Pembelian Roti</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Nama Roti</th>
                    <th>Harga Roti</th>
                    <th>Stok</th>
                    <th>Jumlah Beli</th>
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
                
                // Query untuk mengambil data roti dari tabel roti
                $sql = "SELECT id_roti, nama_roti, harga_roti, stok FROM roti";
                $result = $koneksi->query($sql);
                
                if ($result->num_rows > 0) {
                    // Output data dari setiap baris hasil query
                    while($row = $result->fetch_assoc()) {
                        $id_roti = $row['id_roti'];
                        $nama_roti = htmlspecialchars($row['nama_roti']);
                        $harga_roti = $row['harga_roti'];
                        $stok = $row['stok'];
                        
                        echo '<tr>';
                        echo '<td>' . $nama_roti . '</td>';
                        echo '<td>Rp ' . number_format($harga_roti, 0, ',', '.') . '</td>';
                        echo '<td>' . $stok . '</td>';
                        echo '<td><input type="number" name="jumlah_roti[' . $id_roti . ']" min="0"></td>';
                        echo '</tr>';
                    }
                } else {
                    echo "Tidak ada data roti yang ditemukan";
                }
                
                // Tutup koneksi ke database
                $koneksi->close();
                ?>
            </tbody>
        </table><br>
        
        <!-- Input untuk metode pembayaran -->
        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select name="metode_pembayaran" id="metode_pembayaran">
            <option value="Transfer">Transfer</option>
            <option value="Tunai">Tunai</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="Simpan Data">
        <a href="pembayaran.php"><input type="button" value="Pembayaran"></a>
    </form>
</body>
</html>
