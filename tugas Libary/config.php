<?php
// Konfigurasi database
$host     = "localhost";     // Biasanya 'localhost'
$user     = "root";          // Sesuaikan dengan user MySQL Anda
$password = "";              // Password MySQL Anda
$database = "libary";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi untuk menjalankan query dan mengembalikan hasil dalam bentuk array
function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
?>
