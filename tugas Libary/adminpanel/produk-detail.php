<?php
    require "session.php";
    require "../config.php";

    $id = $_GET['p'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id != '$data[kategori_id]'");

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Produk Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        form div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <?php require "navbar.php";?>

    <div class="container mt-5 mb-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama'] ?>" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php while($dataKategori = mysqli_fetch_array($queryKategori)) { ?>
                            <option value="<?php echo $dataKategori['id']; ?>"><?php echo $dataKategori['nama']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="currentFoto">Foto Produk Sekarang</label><br>
                    <img src="../assets/<?php echo $data['foto'] ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="foto">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"><?php echo $data['detail'] ?></textarea>
                </div>
                <div>
    <label for="pengarang">Pengarang</label>
    <input type="text" id="pengarang" name="pengarang" value="<?php echo isset($data['pengarang']) ? htmlspecialchars($data['pengarang']) : ''; ?>" class="form-control" autocomplete="off" required>
</div>
<div>
    <label for="tahun_terbit">Tahun Terbit</label>
    <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?php echo isset($data['tahun_terbit']) ? htmlspecialchars($data['tahun_terbit']) : ''; ?>" class="form-control" min="1900" max="<?php echo date('Y'); ?>" required>
</div>


                <div>
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stok'] ?>"><?php echo $data['ketersediaan_stok'] ?></option>
                        <?php if($data['ketersediaan_stok'] == 'tersedia') { ?>
                            <option value="habis">Habis</option>
                        <?php } else { ?>
                            <option value="tersedia">Tersedia</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
            </form>

            <?php
                if (isset($_POST['simpan'])) {
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $pengarang = htmlspecialchars($_POST['pengarang']);
                    $tahun_terbit = htmlspecialchars($_POST['tahun_terbit']);
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                    $updateQuery = mysqli_query($conn, "UPDATE produk SET 
                        kategori_id = '$kategori', 
                        nama = '$nama', 
                        detail = '$detail', 
                        pengarang = '$pengarang',
                        tahun_terbit = '$tahun_terbit',
                        ketersediaan_stok = '$ketersediaan_stok' 
                        WHERE id = '$id'
                    ");

                    if ($updateQuery) {
                        // Proses jika ada foto diupload
                        if (!empty($_FILES["foto"]["name"])) {
                            $target_dir = "../assets/";
                            $nama_file = basename($_FILES["foto"]["name"]);
                            $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                            $image_size = $_FILES["foto"]["size"];
                            $random_name = generateRandomString(20);
                            $new_name = $random_name . "." . $imageFileType;
                            $target_file = $target_dir . $new_name;

                            if ($image_size > 500000) {
                                echo '<div class="alert alert-warning mt-3">Foto tidak boleh lebih dari 500kb</div>';
                            } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
                                echo '<div class="alert alert-warning mt-3">File wajib bertipe jpg, png, atau gif</div>';
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
                                mysqli_query($conn, "UPDATE produk SET foto='$new_name' WHERE id='$id'");
                            }
                        }

                        echo '<div class="alert alert-primary mt-3">Produk berhasil diupdate</div>';
                        echo '<meta http-equiv="refresh" content="2; url=produk.php" />';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Gagal update produk: ' . mysqli_error($conn) . '</div>';
                    }
                }

                if (isset($_POST['hapus'])) {
                    $hapusQuery = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

                    if ($hapusQuery) {
                        echo '<div class="alert alert-primary mt-3">Produk berhasil dihapus</div>';
                        echo '<meta http-equiv="refresh" content="2; url=produk.php" />';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Gagal menghapus produk</div>';
                    }
                }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
