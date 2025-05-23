<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $produk_id = $_POST['produk_id'];
    $judul = $_POST['judul'];
    $peminjam = $_POST['peminjam'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    // Validasi stok produk
    $cek = $conn->prepare("SELECT product_stok FROM produk WHERE id = ?");
    $cek->bind_param("i", $produk_id);
    $cek->execute();
    $result = $cek->get_result();
    $data = $result->fetch_assoc();

    if ($data['product_stok'] <= 0) {
        echo "Stok habis. Tidak dapat dipinjam.";
        exit;
    }

    // Kurangi stok
    $update = $conn->prepare("UPDATE produk SET product_stok = product_stok - 1 WHERE id = ?");
    $update->bind_param("i", $produk_id);
    $update->execute();

    // Simpan data peminjaman (Pastikan kamu sudah punya tabel peminjaman)
    $insert = $conn->prepare("INSERT INTO peminjaman (produk_id, judul, peminjam, tanggal_pinjam, tanggal_kembali) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("issss", $produk_id, $judul, $peminjam, $tanggal_pinjam, $tanggal_kembali);
    if($insert->execute()){

    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <meta http-equiv="refresh" content="2;url=koleksi.php" />
        </head>
        <body>
            <div class="alert alert-success text-center mt-5" role="alert">
                Peminjaman berhasil! Anda akan diarahkan ke dashboard...
            </div>
        </body>
        </html>';
    } else {
        echo '<div class="alert alert-danger">Gagal meminjam buku.</div>';
    }
} else {
    echo 'Metode tidak diizinkan.';
}
?>
