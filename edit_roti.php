<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Roti</title>
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

        h1 {
            margin-bottom: 15px;
            color: #333;
            text-align: center;
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
    </style>
</head>
<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'stok_roti.php') : ?>
            <li><a href="stok_roti.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
        <h1>Edit Data Roti</h1>
    </header>

    <div class="container">
        <section>
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

            // Periksa apakah form edit telah dikirimkan
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
                $id_roti = $_POST['id_roti'];
                $nama_roti = $_POST['nama_roti'];
                $harga_roti = $_POST['harga_roti'];
                $stok = $_POST['stok'];

                // Query untuk melakukan update data roti
                $sql_update = "UPDATE roti SET nama_roti='$nama_roti', harga_roti=$harga_roti, stok=$stok WHERE id_roti='$id_roti'";

                if (mysqli_query($conn, $sql_update)) {
                    echo "Data roti berhasil diperbarui";
                    // Redirect ke halaman Data Roti setelah 1 detik
                    header("Refresh: 1; url=stok_roti.php"); // Menggunakan Refresh header untuk redirect
                } else {
                    echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                }
            }

            // Periksa apakah ada parameter ID roti dari URL
            if (isset($_GET['id'])) {
                $id_roti = $_GET['id'];

                // Query untuk mengambil data roti berdasarkan ID
                $sql_select = "SELECT * FROM roti WHERE id_roti='$id_roti'";
                $result = mysqli_query($conn, $sql_select);

                // Periksa apakah query berhasil dieksekusi
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        // Data roti ditemukan, tampilkan form untuk mengedit
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_roti; ?>" method="post">
                            <input type="hidden" name="id_roti" value="<?php echo htmlspecialchars($row['id_roti']); ?>">
                            <label for="nama_roti">Nama Roti:</label><br>
                            <input type="text" id="nama_roti" name="nama_roti" value="<?php echo htmlspecialchars($row['nama_roti']); ?>" required><br><br>
                            <label for="harga_roti">Harga Roti:</label><br>
                            <input type="number" id="harga_roti" name="harga_roti" value="<?php echo $row['harga_roti']; ?>" min="0" step="500" required><br><br>
                            <label for="stok">Stok:</label><br>
                            <input type="number" id="stok" name="stok" value="<?php echo $row['stok']; ?>" min="0" required><br><br>
                            <input type="submit" name="edit" value="Simpan Perubahan">
                        </form>
                        <?php
                    } else {
                        echo "Data roti tidak ditemukan.";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn); // Tampilkan pesan error jika query gagal dieksekusi
                }
            } else {
                echo "ID roti tidak ditemukan.";
            }

            // Langkah 4: Menutup koneksi ke database
            mysqli_close($conn);
            ?>
        </section>
    </div>

</body>
</html>
