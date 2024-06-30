<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Customer</title>
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

        h1 {
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
        <?php if (basename($_SERVER['PHP_SELF']) != 'data_customer.php') : ?>
            <li><a href="data_customer.php">Kembali ke halaman utama</a></li>
        <?php endif; ?>
        <h1>Edit Data Customer</h1>
    </header>

    <div class="container">
        <section>
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

            // Periksa apakah ada parameter ID customer dari URL
            if (isset($_GET['id'])) {
                $id_customer = $_GET['id'];

                // Query untuk mengambil data customer berdasarkan ID
                $sql_select = "SELECT * FROM customer WHERE id_customer=$id_customer";
                $result = mysqli_query($conn, $sql_select);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // Data customer ditemukan, tampilkan form untuk mengedit
                    ?>
                    <form action="edit_data_cs.php?id=<?php echo $id_customer; ?>" method="post">
                        <input type="hidden" name="id_customer" value="<?php echo $row['id_customer']; ?>">
                        <label for="nama">Nama:</label><br>
                        <input type="text" id="nama" name="nama" value="<?php echo $row['nama_customer']; ?>" required><br><br>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
                        <label for="no_hp">Nomor HP:</label><br>
                        <input type="text" id="no_hp" name="no_hp" value="<?php echo $row['no_hp']; ?>"><br><br>
                        <label for="alamat">Alamat:</label><br>
                        <textarea id="alamat" name="alamat" rows="4" required><?php echo $row['alamat']; ?></textarea><br><br>
                        <input type="submit" name="edit" value="Simpan Perubahan">
                    </form>
                    <?php

                    // Proses simpan perubahan jika form disubmit
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
                        $id_customer = $_POST['id_customer'];
                        $nama = $_POST['nama'];
                        $email = $_POST['email'];
                        $no_hp = $_POST['no_hp'];
                        $alamat = $_POST['alamat'];

                        // Query untuk update data customer
                        $sql_update = "UPDATE customer SET nama_customer='$nama', email='$email', no_hp='$no_hp', alamat='$alamat' WHERE id_customer=$id_customer";

                        if (mysqli_query($conn, $sql_update)) {
                            echo "Data customer berhasil diupdate.";
                        } else {
                            echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
                        }
                    }
                } else {
                    echo "Data customer tidak ditemukan.";
                }
            } else {
                echo "ID customer tidak ditemukan.";
            }

            // Langkah 4: Menutup koneksi ke database
            mysqli_close($conn);
            ?>
        </section>
    </div>

</body>
</html>
