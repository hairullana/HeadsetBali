<?php

require "connectDB.php";

$dataModal = mysqli_query($connectDB, "SELECT * FROM modal")



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach ($dataModal as $modal) : ?>
        <?php
            $idModal = $modal["idModal"];
            $dataBarang = mysqli_query($connectDB,"SELECT namaBarang, COUNT(namaBarang) as jumlahBarang FROM data_barang INNER JOIN stok ON data_barang.idBarang = stok.idBarang where stok.idModal = $idModal GROUP BY namaBarang");
        ?>
        <p>Tanggal : <?= $modal["tanggalPembelian"] ?></p>
        <ul>
            <?php foreach ($dataBarang as $barang) : ?>
                <li><?= $barang["namaBarang"] ?> (<?= $barang["jumlahBarang"] ?>)</li>
            <?php endforeach; ?>
        </ul>
        <p>Status = <?php if ($modal["status"] == 0) { echo "Masih Ada";}else {echo "Sudah Habis";} ?></p>
        <p>Total Modal = <?= $modal["totalModal"] + $modal["ongkir"] ?></p>
        <p>Penjualan Kotor = <?= $modal["totalPenjualan"] ?></p>
        <p>Keuntungan Bersih = <?php if ($modal["status"] == 0){ echo "Belum Diketahui"; }else{ echo $modal["totalPenjualan"]-($modal["totalModal"]+$modal["ongkir"]);} ?></p>
        <br>
        <hr>
    <?php endforeach; ?>
</body>
</html>