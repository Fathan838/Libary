<?php
    require "session.php";
    require "../config.php";

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($conn, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<style>
    .kotak{
        border: solid;
    }

    .summary-kategori{
        background: #07b4a2;
        border-radius:15px;
    }

    .summary-produk{
        background: #08b946;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }
</style>


<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
        <i class="fa-solid fa-house-chimney me-2"></i>Home
        </li>
    </ol>
    </nav>
        <h2>Hallo <?php echo $_SESSION['email']; ?></h2>

        <div class="container mt-5">
            <div class='row'>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-produk p-3">
                            <div class="row">
                                <div class="col-6">
                                <i class="fa-solid fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahProduk; ?> Produk</p>
                                <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>