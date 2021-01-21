<?php

require "db.php";
// ambil data barang yang laku
$penjualan = mysqli_query($db, "SELECT stok.tanggalTerjual as tanggalTerjual, stok.hargaJual as hargaJual, data_barang.namaBarang as namaBarang FROM stok INNER JOIN data_barang ON data_barang.idBarang = stok.idBarang where stok.status = 0 ORDER BY stok.idStok DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan</title>
    <?php require "headtags.php" ?>
</head>
<body>
    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10">
            <h1 class="display-4 text-center">Penjualan Barang</h1>
            <hr>
            <div class="col-md-10 offset-md-1">
                <table class="table">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($penjualan as $data) : ?>
                        <tr>
                            <td><?= $data["namaBarang"] ?></td>
                            <td><?= $data["tanggalTerjual"] ?></td>
                            <td><?= $data["hargaJual"] ?></td>
                            <td><a class="btn btn-primary rounded-pill" href="edit-data-barang.php?id=<?= $barang['idBarang'] ?>"><i class="fa fa-edit"></i></a> <a class="btn btn-primary rounded-pill " href="hapus-data-barang.php?id=<?= $barang['idBarang'] ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Barang ?')"><i class="fa fa-trash-alt"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>