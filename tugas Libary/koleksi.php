<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Ambil input filter dari URL
$keyword = $_GET['keyword'] ?? '';
$kategori_id = $_GET['kategori'] ?? '';
$pengarang = $_GET['pengarang'] ?? '';
$tahun = $_GET['tahun'] ?? '';

// Ambil semua kategori untuk dropdown
$kategoriResult = $conn->query("SELECT id, nama FROM kategori ORDER BY nama ASC");
$kategoriList = [];
while ($row = $kategoriResult->fetch_assoc()) {
    $kategoriList[] = $row;
}

// Mulai query produk dengan join ke kategori
$sql = "SELECT p.*, k.nama AS kategori_nama FROM produk p 
        LEFT JOIN kategori k ON p.kategori_id = k.id WHERE 1=1";

$params = [];
$paramTypes = "";

// Filter keyword (nama buku)
if ($keyword !== '') {
    $sql .= " AND p.nama LIKE ?";
    $params[] = "%$keyword%";
    $paramTypes .= "s";
}

// Filter kategori
if ($kategori_id !== '') {
    $sql .= " AND p.kategori_id = ?";
    $params[] = $kategori_id;
    $paramTypes .= "i";
}

// Filter pengarang
if ($pengarang !== '') {
    $sql .= " AND p.pengarang LIKE ?";
    $params[] = "%$pengarang%";
    $paramTypes .= "s";
}

// Filter tahun terbit
if ($tahun !== '') {
    $sql .= " AND p.tahun_terbit = ?";
    $params[] = $tahun;
    $paramTypes .= "s";
}

// Prepare statement
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($paramTypes, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hasil Pencarian</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Untuk membatasi baris judul buku */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex flex-col">

<!-- Header -->
<div class="relative bg-cover bg-center h-48 sm:h-64" style="background-image: url('assets/bg.jpg');">
  <div class="absolute inset-0 bg-black bg-opacity-60"></div>
  <div class="relative z-10 px-4 sm:px-6 py-4 flex justify-between items-center text-white">
    <div class="flex items-center space-x-3 sm:space-x-4">
      <img src="assets/logo_SMK_65 (2).png" alt="Logo" class="h-10 sm:h-12" />
      <div>
        <h1 class="text-blue-400 text-lg sm:text-xl font-bold">PERPUSTAKAAN</h1>
        <p class="text-xs sm:text-sm">SMKN 65 JAKARTA</p>
      </div>
    </div>
    <button id="nav-toggle" class="block md:hidden text-white focus:outline-none" aria-label="Toggle Menu" aria-expanded="false">
  <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 6h16M4 12h16M4 18h16"></path>
  </svg>
</button>

<nav id="nav-menu" class="hidden md:flex space-x-3 sm:space-x-6 font-semibold text-sm sm:text-base">
  <a href="dashboard.php" class="hover:text-green-400 transition">Beranda</a>
  <a href="koleksi.php" class="hover:text-green-400 transition">Koleksi</a>
  <a href="contact.php" class="hover:text-green-400 transition">Contact</a>
</nav>

  </div>
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-4">
    <h2 class="text-2xl sm:text-4xl font-extrabold">HASIL PENCARIAN</h2>
    <p class="mt-1 sm:mt-2 text-xs sm:text-sm">Koleksi / Hasil Pencarian</p>
  </div>
</div>

<!-- Title -->
<strong class="text-xl sm:text-2xl flex justify-center mt-8 mb-6">Koleksi Kami</strong>

<!-- Filter Form -->
<form method="GET" class="max-w-4xl mx-auto flex flex-wrap justify-center gap-3 px-4 mb-10">
  <input
    type="text"
    name="keyword"
    placeholder="Cari buku..."
    value="<?= htmlspecialchars($keyword) ?>"
    class="border rounded px-3 py-2 text-sm text-gray-700 w-full sm:w-auto flex-grow sm:flex-grow-0"
  />

  <select name="kategori" class="border rounded px-3 py-2 text-sm text-gray-700 w-full sm:w-auto">
    <option value="">Kategori</option>
    <?php foreach ($kategoriList as $kat): ?>
      <option value="<?= $kat['id'] ?>" <?= $kategori_id == $kat['id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($kat['nama']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <input
    type="text"
    name="pengarang"
    placeholder="Pengarang"
    value="<?= htmlspecialchars($pengarang) ?>"
    class="border rounded px-3 py-2 text-sm text-gray-700 w-full sm:w-auto"
  />

  <input
    type="text"
    name="tahun"
    placeholder="Tahun Terbit"
    value="<?= htmlspecialchars($tahun) ?>"
    class="border rounded px-3 py-2 text-sm text-gray-700 w-full sm:w-auto"
  />

  <button
    type="submit"
    class="bg-green-500 text-white px-5 py-2 rounded hover:bg-green-600 text-sm font-semibold w-full sm:w-auto"
  >
    Cari
  </button>
</form>

<!-- Grid Produk -->
<div class="max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-16">
  <?php if (empty($products)) : ?>
    <p class="col-span-full text-center text-gray-600 text-sm">Tidak ada buku ditemukan.</p>
  <?php else : ?>
    <?php foreach ($products as $product) : ?>
      <div class="w-full max-w-[150px] mx-auto text-sm text-center">
        <div class="relative w-full" style="padding-top: 130%;">
          <img
            src="assets/<?= htmlspecialchars($product["foto"]) ?>"
            alt="<?= htmlspecialchars($product["nama"]) ?>"
            class="absolute top-0 left-0 w-full h-full object-cover rounded shadow"
          />
        </div>
        <h3 class="mt-2 font-bold text-sm leading-tight line-clamp-2"><?= htmlspecialchars($product["nama"]) ?></h3>
        <p class="text-xs text-gray-600 leading-snug">
          Stok: <?= ($product["product_stok"] > 0) ? $product["product_stok"] : "Habis" ?>
        </p>
        <?php if ($product["product_stok"] > 0) : ?>
          <a
            href="form_peminjaman.php?judul=<?= urlencode($product["nama"]) ?>"
            class="inline-block mt-2 bg-green-500 text-white text-xs px-3 py-1 rounded hover:bg-green-600"
          >Pinjam Sekarang</a>
        <?php else : ?>
          <button
            class="mt-2 bg-gray-400 text-white text-xs px-3 py-1 rounded cursor-not-allowed"
            disabled
          >
            Buku Tidak Tersedia
          </button>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<script>
  const toggleButton = document.getElementById('nav-toggle');
const navMenu = document.getElementById('nav-menu');

toggleButton.addEventListener('click', () => {
  navMenu.classList.toggle('hidden');
  // Update aria-expanded
  const expanded = toggleButton.getAttribute('aria-expanded') === 'true';
  toggleButton.setAttribute('aria-expanded', String(!expanded));
});

</script>

</body>
</html>
