<?php
require 'config.php';

if (!isset($_GET['judul'])) {
    echo "Judul buku tidak ditemukan.";
    exit;
}

$judul = $_GET['judul'];
$query = "SELECT * FROM produk WHERE nama = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $judul);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data buku tidak ditemukan.";
    exit;
}

$buku = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #80deea);
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 80px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0,0,0,0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #00796b;
        }

        .btn-pinjam {
            background-color: #00796b;
            color: white;
            transition: 0.3s ease;
        }

        .btn-pinjam:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="form-title">Form Peminjaman Buku</h2>
    <form action="proses_pinjam.php" method="POST">
        <input type="hidden" name="produk_id" value="<?php echo $buku['id']; ?>">

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $buku['nama']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="peminjam" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="peminjam" name="peminjam" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-pinjam">Pinjam</button>
        </div>
    </form>
</div>

</body>
</html>
