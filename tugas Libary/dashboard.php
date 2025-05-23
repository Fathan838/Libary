<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit();
}

$products = query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perpustakaan SMKN 65</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="text-white min-h-screen bg-cover bg-center" style="background-image: url('assets/65.jpg');">
  <!-- Navbar -->
  <header class="w-full px-6 py-4 bg-transparent flex flex-wrap justify-between items-center text-white">
  <div class="flex items-center space-x-4">
    <img src="assets/logo_SMK_65 (2).png" alt="Logo" class="h-12" />
    <div>
      <h1 class="text-blue-400 text-xl font-bold">PERPUSTAKAAN</h1>
      <p class="text-sm">SMKN 65 JAKARTA</p>
    </div>
  </div>

  <!-- Hamburger button (hanya muncul di mobile) -->
  <button id="nav-toggle" class="block md:hidden focus:outline-none" aria-label="Toggle Menu" aria-expanded="false">
    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Menu navigasi -->
  <nav id="nav-menu" class="hidden md:flex space-x-4 font-semibold text-sm mt-2 md:mt-0">
    <a href="dashboard.php" class="hover:text-blue-300 block md:inline">Beranda</a>
    <a href="koleksi.php" class="hover:text-blue-300 block md:inline">Koleksi</a>
    <a href="contact.php" class="hover:text-blue-300 block md:inline">Contact</a>
  </nav>
</header>

  <!-- Hero / Content -->
  <section class="flex flex-col items-center text-center px-4 py-24 md:py-32">
    <h1 class="text-3xl sm:text-5xl font-bold mb-4">ONLINE PUBLIC ACCESS CATALOG<br>PERPUSTAKAAN SMKN 65</h1>
    <p class="text-white text-base sm:text-lg max-w-2xl">
      Perpustakaan SMKN 65 memiliki <span class="bg-green-500 px-2 py-1 rounded font-bold">100</span> Koleksi. Untuk memulai pencarian, masukkan satu atau beberapa kata kunci dari judul, penulis atau subjek yang diinginkan.
    </p>

    <!-- Search Box -->
    <form class="flex flex-col sm:flex-row bg-white rounded-full overflow-hidden mt-6 w-full max-w-xl shadow-lg">
      <input type="text" placeholder="Enter keywords" class="p-4 text-gray-800 flex-1 text-sm outline-none" />
      <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 text-sm">SEARCH</button>
    </form>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-10 mt-10">
    <div class="max-w-6xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        <div>
          <h2 class="text-lg font-bold text-blue-400">SMKN 65 Jakarta</h2>
          <p class="mt-2 text-sm text-gray-300">
            Sekolah Menengah Kejuruan Negeri 65 Jakarta adalah institusi pendidikan yang berkomitmen mencetak lulusan berkualitas dan siap kerja di dunia industri maupun wirausaha.
          </p>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Alamat</h3>
          <p class="text-sm text-gray-300">
            Jl. Ipn Rt. 09 Rw 06, Kota Jakarta Timur<br />
            DKI Jakarta 11520
          </p>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Kontak</h3>
          <p class="text-sm text-gray-300">
            Telepon: (021) 11301420<br />
            Email: smkn65jkt@gmail.com
          </p>
        </div>
      </div>
      <div class="mt-8 border-t border-gray-700 pt-4 text-center text-xs text-gray-400">
        &copy; <?= date("Y") ?> SMKN 65 Jakarta. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- Wishlist script (optional if needed) -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".wishlist-icon").forEach(icon => {
        icon.addEventListener("click", function () {
          this.classList.toggle("active");
        });
      });
    });

    const toggleButton = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');

  toggleButton.addEventListener('click', () => {
    navMenu.classList.toggle('hidden');
    // Update aria-expanded untuk aksesibilitas
    const expanded = toggleButton.getAttribute('aria-expanded') === 'true';
    toggleButton.setAttribute('aria-expanded', String(!expanded));
  });
  </script>
</body>
</html>
