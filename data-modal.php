<?php

require "db.php";

$dataModal = mysqli_query($db, "SELECT * FROM modal ORDER BY idModal DESC");
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
                <div class="col mt-3">
                    <table class="table text-center">
                        <tr class="bg-primary text-white">
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
                                $dataBarang = mysqli_query($db,"SELECT namaBarang, COUNT(namaBarang) as jumlahBarang FROM data_barang INNER JOIN stok ON data_barang.idBarang = stok.idBarang where stok.idModal = $idModal GROUP BY namaBarang");
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
                                <td><?php if ($modal["status"] == 1) { echo "Ada";}else {echo "Habis";} ?></td>
                                <td>Rp. <?= number_format($modal["totalModal"] + $modal["ongkir"]) ?></td>
                                <td>Rp. <?= number_format($modal["totalPenjualan"]) ?></td>
                                <td><?php if ($modal["status"] == 1){ echo "Belum Diketahui"; }else{ echo "Rp. " . number_format($modal["totalPenjualan"]-($modal["totalModal"]+$modal["ongkir"]));} ?></td>
                                <td><a href="hapus-data-modal.php?id=<?= $modal['idModal'] ?>" class="btn btn-primary rounded-pill" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Pelamar ?')"><i class="fa fa-trash-alt"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>