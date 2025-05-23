<?php
require "config.php";

$produkId = isset($_GET['p']) ? intval($_GET['p']) : 0;

$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $produkId);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    die("<p>Produk tidak ditemukan.</p>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Validasi form
    if (!$name || !$email || $quantity <= 0) {
        echo "<script>alert('Harap isi semua data dengan benar.');</script>";
    } elseif ($quantity > $produk['product_stok']) {
        echo "<script>alert('Stok tidak mencukupi.');</script>";
    } else {
        $total_price = $quantity * $produk['harga'];

        $stmt = $conn->prepare("INSERT INTO pesanan (nama, email, total_price, product_id, quantity) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdii", $name, $email, $total_price, $produkId, $quantity);

        if ($stmt->execute()) {
            $stmt = $conn->prepare("UPDATE produk SET product_stok = product_stok - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $produkId);
            $stmt->execute();

            $alertMessage = '<div class="alert alert-primary mt-3" role="alert">Produk Berhasil Diupdate</div>';

            header("refresh:3;url=dashboard.php");


        } else {
            $alertMessage = '<div class="alert alert-danger mt-3" role="alert">Terjadi kesalahan saat menyimpan pesanan.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .checkout-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .checkout-btn {
            width: 100%;
            background: black;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <p><strong>Produk:</strong> <?= htmlspecialchars($produk["nama"]) ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($produk["harga"], 0, ',', '.') ?></p>
        

        <form method="post">
            <input type="text" name="full_name" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="number" name="quantity" placeholder="Jumlah" required id="quantity">



            <p><strong>Total Harga:</strong> Rp <span id="totalPrice"><?= number_format($produk["harga"], 0, ',', '.') ?></span></p>

            <button type="submit" class="checkout-btn">Pesan Sekarang</button>
        </form>
        
    </div>

    <script>
        document.getElementById("quantity").addEventListener("input", function() {
            let quantity = this.value || 1;
            let price = <?= $produk["harga"] ?>;
            document.getElementById("totalPrice").textContent = (price * quantity).toLocaleString("id-ID");
        });
    </script>
</body>

</html>