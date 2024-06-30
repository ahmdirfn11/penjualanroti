<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.signup-container {
    max-width: 400px;
    margin: 50px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.signup-container h1 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.form-group button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.form-group button[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>

</head>
<body>
    <div class="signup-container">
        <h1>Signup Admin</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="nama_customer">Nama Lengkap</label>
                <input type="text" id="nama_customer" name="nama_customer" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" id="no_hp" name="no_hp" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
require 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama_customer = $_POST['nama_customer'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($nama_customer) || empty($email) || empty($no_hp) || empty($alamat) || empty($password)) {
        echo "Semua field harus diisi.";
    } else {
        // Prepare statement untuk memasukkan data
        $sql = "INSERT INTO customer (nama_customer, email, no_hp, alamat, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);

        // Periksa apakah statement berhasil dibuat
        if ($stmt) {
            // Bind parameter ke statement
            mysqli_stmt_bind_param($stmt, "sssss", $nama_customer, $email, $no_hp, $alamat, $password);

            // Eksekusi statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Data berhasil dimasukkan.";
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    }
    // Tutup koneksi
    mysqli_close($koneksi);
}
?>
