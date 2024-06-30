<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Roti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        header li {
            display: inline;
            margin-right: 10px;
        }

        .container {
            width: 80%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        section {
            margin-bottom: 30px;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type=text],
        input[type=number] {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type=submit] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type=submit]:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #fff;
        }

        table a {
            text-decoration: none;
            color: #333;
            margin-right: 10px;
        }

        table a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'header.php') : ?>
            <li><a href="header.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
    </header>

    <div class="container">
        <section>
            <h2>Form Tambah Data Roti</h2>
            <form action="data_roti.php" method="post">
                <label for="nama_roti">Nama Roti:</label><br>
                <input type="text" id="nama_roti" name="nama_roti" required><br><br>
                <label for="harga_roti">Harga Roti:</label><br>
                <input type="number" id="harga_roti" name="harga_roti" min="0" step="1000" required><br><br>
                <label for="stok">Stok:</label><br>
                <input type="number" id="stok" name="stok" min="0" required><br><br>
                <input type="submit" name="tambah" value="Tambah Data">
            </form>
        </section>

        <section>
            <h2>Daftar Roti</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Roti</th>
                        <th>Harga Roti</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Langkah 1: Membuat koneksi ke database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "penjualan_roti"; // Ganti dengan nama database Anda

                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Periksa koneksi
                    if (!$conn) {
                        die("Koneksi gagal: " . mysqli_connect_error());
                    }

                    // Aksi tambah data roti
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
                        $nama_roti = $_POST['nama_roti'];
                        $harga_roti = $_POST['harga_roti'];
                        $stok = $_POST['stok'];

                        $sql = "INSERT INTO roti (nama_roti, harga_roti, stok) VALUES ('$nama_roti', $harga_roti, $stok)";

                        if (mysqli_query($conn, $sql)) {
                            echo "Data roti berhasil ditambahkan";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

                    // Aksi hapus data roti
                    if (isset($_GET['hapus'])) {
                        $id_roti = $_GET['hapus'];

                        $sql = "DELETE FROM roti WHERE id=$id_roti";

                        if (mysqli_query($conn, $sql)) {
                            echo "Data roti berhasil dihapus";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

                    // Langkah 3: Mengambil data roti dari database untuk ditampilkan di tabel
                    $sql_select = "SELECT id_roti, nama_roti, harga_roti, stok FROM roti";
                    $result = mysqli_query($conn, $sql_select);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_roti'] . "</td>"; // Menampilkan ID Roti
                            echo "<td>" . $row['nama_roti'] . "</td>";
                            echo "<td>" . $row['harga_roti'] . "</td>";
                            echo "<td>" . $row['stok'] . "</td>";
                            echo "<td>
                                    <a href='edit_roti.php?id=" . $row['id_roti'] . "'>Edit</a> |
                                    <a href='data_roti.php?hapus=" . $row['id_roti'] . "'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data roti.</td></tr>";
                    }

                    // Langkah 4: Menutup koneksi ke database
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
