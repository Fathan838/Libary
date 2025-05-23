<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);
    $success = "Pesan Anda telah dikirim!";
}
?>
<style>
  body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    color: white;
    min-height: 100vh;
    background: url('assets/bg perpus.jpg') no-repeat center center/cover;
    background-attachment: fixed;
  }

  /* Navbar fixed on top, with proper z-index */
  .navbar {
    background-color: transparent;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 50;
  }
</style>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact - SMKN 65 Jakarta</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
</head>
<body class="bg-fixed bg-center bg-cover" style="background-image: url('assets/bg perpus.jpg')">

<!-- Navbar -->
<header class="relative z-10 px-6 py-4 flex justify-between items-center bg-transparent text-white">
  <div class="flex items-center space-x-4">
    <img src="assets/logo_SMK_65 (2).png" alt="Logo" class="h-12" />
    <div>
      <h1 class="text-blue-400 text-xl font-bold">PERPUSTAKAAN</h1>
      <p class="text-sm">SMKN 65 JAKARTA</p>
    </div>
  </div>

  <!-- Hamburger Button -->
  <button id="nav-toggle" class="md:hidden focus:outline-none" aria-label="Toggle Menu">
    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Navigation Menu -->
  <nav id="nav-menu" class="hidden md:flex space-x-6 font-semibold text-white">
    <a href="dashboard.php" class="hover:text-green-400">Beranda</a>
    <a href="koleksi.php" class="hover:text-green-400">Koleksi</a>
    <a href="contact.php" class="hover:text-green-400">Contact</a>
  </nav>
</header>

<main class="max-w-4xl mx-auto px-4 sm:px-8 py-24 sm:py-12">
  <h2 class="text-3xl font-bold mb-6 text-center text-green-700">Hubungi Kami</h2>

  <?php if (!empty($success)) : ?>
    <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-sm text-center max-w-md mx-auto">
      <?= $success ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="bg-white shadow rounded-lg p-6 space-y-5 max-w-xl mx-auto">
    <div>
      <label class="block text-sm font-semibold mb-1 text-black" for="nama">Nama</label>
      <input id="nama" type="text" name="nama" required
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1 text-black" for="email">Email</label>
      <input id="email" type="email" name="email" required
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1 text-black" for="pesan">Pesan</label>
      <textarea id="pesan" name="pesan" rows="5" required
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400 text-black"></textarea>
    </div>
    <button type="submit"
      class="bg-green-600 w-full py-2 rounded text-white font-semibold hover:bg-green-700 transition">
      Kirim Pesan
    </button>
  </form>

  <section class="mt-10 bg-gray-200 p-6 rounded max-w-xl mx-auto text-gray-700 text-center sm:text-left text-sm sm:text-base">
    <h3 class="text-lg font-semibold mb-3">Alamat Sekolah</h3>
    <p>SMKN 65 Jakarta</p>
    <p>Jl. Panjang No. 65, Jakarta Barat, DKI Jakarta 11520</p>
    <p>Telepon: (021) 12345678</p>
    <p>Email: info@smkn65jkt.sch.id</p>
  </section>
</main>

<footer class="bg-gray-900 text-white py-8 mt-16">
  <div class="max-w-6xl mx-auto px-4 sm:px-8">
    <div class="flex flex-col md:flex-row justify-between gap-8 md:gap-0">
      <div class="md:w-1/3">
        <h2 class="text-lg font-bold text-blue-400 mb-2">SMKN 65 Jakarta</h2>
        <p class="text-sm leading-relaxed text-gray-300">
          Sekolah Menengah Kejuruan Negeri 65 Jakarta adalah institusi pendidikan yang berkomitmen mencetak
          lulusan berkualitas dan siap kerja di dunia industri maupun wirausaha.
        </p>
      </div>
      <div class="md:w-1/3">
        <h3 class="font-semibold mb-2">Alamat</h3>
        <p class="text-sm text-gray-300">
          Jl. Ipn Rt. 09 Rw 06, Kota Jakarta Timur.<br />
          DKI Jakarta 11520
        </p>
      </div>
      <div class="md:w-1/3">
        <h3 class="font-semibold mb-2">Kontak</h3>
        <p class="text-sm text-gray-300">
          Telepon: (021)11301420<br />
          Email: smkn65jkt@gmail.com
        </p>
      </div>
    </div>
    <div class="mt-6 border-t border-gray-700 pt-4 text-center text-xs text-gray-400">
      &copy; <?= date("Y") ?> SMKN 65 Jakarta. All rights reserved.
    </div>
  </div>
</footer>


<script>
  const navToggle = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');

  navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('hidden');
  });
</script>

</body>
</html>
