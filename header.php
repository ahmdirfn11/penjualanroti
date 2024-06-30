<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roti Enak</title>
    <style>
        /* Reset CSS untuk memastikan konsistensi tampilan */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body dan font default */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            line-height: 1.6;
        }

        /* Navbar styling */
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            padding-left: 20px;
            text-decoration: none;
            color: #fff;
        }

        .navbar-nav {
            padding-left: 20px;
        }

        .navbar-nav .nav-link {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
        }

        .navbar-nav .nav-link:hover {
            background-color: #555;
            border-radius: 4px;
        }

        /* Main content styling */
        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Company Info styling */
        .company-info {
            margin-bottom: 20px;
        }

        .company-info h2 {
            margin-bottom: 10px;
        }

        .company-info p {
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .company-info ul {
            margin-bottom: 10px;
        }

        /* Signature styling */
        .signature {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ROTI SPECIAL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="data_customer.php">Data customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="stok_roti.php">Stok Roti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="laporan_penjualan.php">Laporan Penjualan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="company-info">
            <h2>Tentang Perusahaan Kami</h2>
            <p>
                Perusahaan Roti Enak adalah produsen roti terkemuka yang berkomitmen untuk menyediakan produk roti berkualitas tinggi kepada pelanggan kami. Kami telah beroperasi selama lebih dari 20 tahun dan dikenal karena inovasi, kualitas, dan pelayanan yang prima.
            </p>
            <p>
                Visi kami adalah menjadi pemimpin pasar dalam industri roti dengan terus mengembangkan produk-produk baru yang memenuhi kebutuhan dan selera pelanggan kami. Kami juga memprioritaskan keberlanjutan dan kualitas bahan baku dalam setiap proses produksi kami.
            </p>
            <p>
                Kami bangga dengan reputasi kami dalam menciptakan roti yang tidak hanya lezat tetapi juga sehat. Semua produk kami diproses dengan standar keamanan dan kebersihan yang ketat untuk memastikan kualitas terbaik.
            </p>
            <h2>Misi Kami</h2>
            <ul>
                <li>Menyediakan berbagai jenis roti berkualitas tinggi untuk memenuhi kebutuhan konsumen.</li>
                <li>Menjaga komitmen terhadap inovasi dan pengembangan produk baru.</li>
                <li>Memberikan pelayanan pelanggan yang ramah dan responsif.</li>
                <li>Mendorong keberlanjutan dalam praktik bisnis kami.</li>
                <li>Menjadi mitra yang baik bagi masyarakat dan lingkungan sekitar.</li>
            </ul>
            <p>
                Kami selalu berusaha untuk memberikan pengalaman berbelanja yang luar biasa kepada pelanggan kami. Jika Anda memiliki pertanyaan lebih lanjut atau ingin mengetahui lebih banyak tentang produk kami, jangan ragu untuk menghubungi kami melalui kontak yang tersedia.
            </p>
        </div>
        <div class="signature">
            <p>&copy; Ahmad irfan fauzi 211011401533</p>
            <p>&copy; 2024 Roti Enak. All Rights Reserved.</p>
        </div>
    </main>
</body>
</html>
