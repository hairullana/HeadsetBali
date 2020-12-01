<?php

include "connectDB.php";

$dataBarang = mysqli_query($connectDB,"SELECT * FROM data_barang WHERE totalLaku > 0");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.php"; ?>
    <title>Document</title>
</head>
<body>
    <div class="row">
        <?php include "sidebar.php" ?>
        <div class="col-md-10">
            <h1 class="display-4 text-center">Stok Barang</h1>
            <hr>
            <table class="table text-center">
                <tr>
                    <th>Nama Barang</th>
                    <th>Total Stok</th>
                    <th>Total Laku</th>
                    <th>Total Keuntungan</th>
                    <th>X̄ Harga Jual</th>
                </tr>
                <?php foreach ($dataBarang as $barang) : ?>
                <tr>
                    <?php
                        $idBarang = $barang["idBarang"];
                        $laba = mysqli_query($connectDB,"SELECT count(idBarang) as totalBarang, SUM(hargaJual) as totalPenjualan, SUM(hargaModal) as totalModal FROM stok WHERE idBarang = $idBarang && status = 1");
                        $laba = mysqli_fetch_assoc($laba);
                        $totalKeuntungan = $laba["totalPenjualan"] - $laba["totalModal"];
                        $mean = $totalKeuntungan / $laba["totalBarang"];

                    ?>
                    <td><?= $barang["namaBarang"]; ?></td>
                    <td><?= $barang["totalStok"]; ?></td>
                    <td><?= $barang["totalLaku"]; ?></td>
                    <td><?= $totalKeuntungan; ?></td>
                    <td><?= $mean = number_format($mean); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>