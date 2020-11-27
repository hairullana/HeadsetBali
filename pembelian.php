<?php

require 'connectDB.php';

if (isset($_POST["tambahDataModal"])) {
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $totalModal = htmlspecialchars($_POST["totalModal"]);
    $ongkir = htmlspecialchars($_POST["ongkir"]);
    $totalBarang = htmlspecialchars($_POST["totalBarang"]);

    mysqli_query($connect,"INSERT INTO modal VAULES('','$tanggal',$totalModal,$ongkir,$totalBarang,0,0");

    $totalInputBarang = $totalBarang;
}

if (isset($_POST["tambahStokBarang"])) {
    $idModal = mysqli_query($connect, "SELECT id_modal FROM modal ORDER BY id_modal DESC");

    mysqli_query($connect, "INSERT INTO stok VALUES ('', $idModal");

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Barang</title>
</head>
<body>
    
    <div id="header">
        <ul>
            <li><a href="index.php">Overview</a></li>
            <li><a href="penjualan.php">Penjulana</a></li>
            <li><a href="pembelian.php">Pembelian</a></li>
            <li><a href="data-modal.php">Data Modal</a></li>
            <li><a href="stok-barang.php">Stok Barang</a></li>
            <li><a href="data-barang.php">Data Barang</a></li>
        </ul>
    </div>

    <hr>

    <div id="body">

        <?php if (!isset($_POST["tambahDataModal"])) : ?>

            <form action="" method="POST">
                <label for="tanggal">Tanggal</label><br>
                <input type="date" name="tanggal"><br>
                <label for="totalModal">Total Modal (Tanpa Ongkir)</label><br>
                <input type="text" name="totalModal"><br>
                <label for="ongkir">Ongkos Kirim</label><br>
                <input type="text" name="ongkir"><br>
                <label for="totalBarang">Total Barang</label><br>
                <input type="number" name="totalBarang"><br>
                <button type="submit" name="tambahDataModal">Tambah Data</button>
            </form>

        <?php else : ?>

            <?= "Sisa Barang : " . $totalInputBarang ?>
            <?php if ($totalInputBarang != 0) : ?>
                <form action="" method="POST">
                    <label for="namaBarang">Nama Barang</label><br>
                    <input type="text" name="namaBarang">
                    <label for="hargaModalBarang">Harga Modal Barang</label>
                    <input type="text" name="hargaModalBarang">
                    <label for="totalBarang">Total Barang</label>
                    <input type="number" name="totalBarang">
                    <button type="submit" name="tambahStokBarang">Tambah Data</button>
                </form>
            <?php endif; ?>
            

        <?php endif; ?>

    </div>

</body>
</html>