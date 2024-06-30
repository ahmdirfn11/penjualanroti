<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customer</title>
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
    input[type=email],
    textarea {
        width: 100%;
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

    .message {
        margin-top: 10px;
        padding: 10px;
        background-color: #dff0d8;
        border: 1px solid #3c763d;
        color: #3c763d;
        border-radius: 4px;
    }

    .error {
        background-color: #f2dede;
        border: 1px solid #ebccd1;
        color: #a94442;
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
            <h2>Form Tambah Data Customer</h2>
            <form action="data_customer.php" method="post">
                <label for="nama">Nama:</label><br>
                <input type="text" id="nama" name="nama" required><br><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <label for="no_hp">Nomor HP:</label><br>
                <input type="text" id="no_hp" name="no_hp" required><br><br>
                <label for="alamat">Alamat:</label><br>
                <textarea id="alamat" name="alamat" rows="4" required></textarea><br><br>
                <input type="submit" name="tambah" value="Tambah Data">
            </form>
        </section>

        <section>
            <h2>Daftar Customer</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Langkah 1: Membuat koneksi ke database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "penjualan_roti";

                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Periksa koneksi
                    if (!$conn) {
                        die("Koneksi gagal: " . mysqli_connect_error());
                    }

                    // Aksi tambah data customer
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
                        $nama = $_POST['nama'];
                        $email = $_POST['email'];
                        $no_hp = $_POST['no_hp'];
                        $alamat = $_POST['alamat'];

                        $sql = "INSERT INTO customer (nama_customer, email, no_hp, alamat) VALUES ('$nama', '$email', '$no_hp', '$alamat')";

                        if (mysqli_query($conn, $sql)) {
                            echo "Data customer berhasil ditambahkan";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

                    // Aksi hapus data customer
                    if (isset($_GET['hapus'])) {
                        $id_customer = $_GET['hapus'];

                        $sql = "DELETE FROM customer WHERE id_customer=$id_customer";

                        if (mysqli_query($conn, $sql)) {
                            echo "Data customer berhasil dihapus";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

                    // Langkah 3: Mengambil data customer dari database untuk ditampilkan di tabel
                    $sql_select = "SELECT id_customer, nama_customer, email, no_hp, alamat FROM customer";
                    $result = mysqli_query($conn, $sql_select);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_customer'] . "</td>";
                            echo "<td>" . $row['nama_customer'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['no_hp'] . "</td>";
                            echo "<td>" . $row['alamat'] . "</td>";
                            echo "<td>
                                    <a href='edit_data_cs.php?id=" . $row['id_customer'] . "'>Edit</a> |
                                    <a href='data_customer.php?hapus=" . $row['id_customer'] . "'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data customer.</td></tr>";
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
