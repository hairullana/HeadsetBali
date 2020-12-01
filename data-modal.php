<?php

require "connectDB.php";

$dataModal = mysqli_query($connectDB, "SELECT * FROM modal ORDER BY idModal DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.php"; ?>
    <title>Data Modal</title>
</head>
<body>

    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10">
            <h1 class="text-center display-4 mt-4">Data Modal</h1>
            <hr>
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <table class="table text-center" border=1>
                        <tr class="bg-dark text-white">
                            <th>Tanggal</th>
                            <th>List Barang</th>
                            <th>Status</th>
                            <th>Total Modal</th>
                            <th>Total Penjualan</th>
                            <th>Keuntungan Bersih</th>
                            <th>Aksi</th>
                        </tr>
                        
                        <?php foreach ($dataModal as $modal) : ?>
                            <?php
                                $idModal = $modal["idModal"];
                                $dataBarang = mysqli_query($connectDB,"SELECT namaBarang, COUNT(namaBarang) as jumlahBarang FROM data_barang INNER JOIN stok ON data_barang.idBarang = stok.idBarang where stok.idModal = $idModal GROUP BY namaBarang");
                            ?>
                            <tr>
                                <td><?= $modal["tanggalPembelian"] ?></td>
                                <td class="text-left">
                                    <ul>
                                        <?php foreach ($dataBarang as $barang) : ?>
                                            <li><?= $barang["namaBarang"] ?> (<?= $barang["jumlahBarang"] ?>)</li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td><?php if ($modal["status"] == 0) { echo "Masih Ada";}else {echo "Sudah Habis";} ?></td>
                                <td>Rp. <?= $modal["totalModal"] + $modal["ongkir"] ?></td>
                                <td>Rp. <?= $modal["totalPenjualan"] ?></td>
                                <td>Rp. <?php if ($modal["status"] == 0){ echo "Belum Diketahui"; }else{ echo $modal["totalPenjualan"]-($modal["totalModal"]+$modal["ongkir"]);} ?></td>
                                <td><a href="hapus-data-modal.php?id=<?= $modal['idModal'] ?>" class="btn btn-primary">Hapus Modal</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>