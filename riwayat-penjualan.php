<?php

require "db.php";


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
        <div class="col-md-10 my-4">
            <h1 class="display-4 text-center">Penjualan Barang</h1>
            <hr>
            <div class="col-md-10 offset-md-1">
                <table class="table" id="data">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Tanggal</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $penjualan = mysqli_query($db, "SELECT stok.idStok as idStok, stok.tanggalTerjual as tanggalTerjual, stok.hargaJual as hargaJual, data_barang.namaBarang as namaBarang FROM stok INNER JOIN data_barang ON data_barang.idBarang = stok.idBarang where stok.status = 0");
                        ?>
                        <?php foreach ($penjualan as $data) : ?>
                            <tr>
                                <td><?= $data["namaBarang"] ?></td>
                                <td><?= $data["tanggalTerjual"] ?></td>
                                <td><?= $data["hargaJual"] ?></td>
                                <td><a class="btn btn-primary rounded-pill" href="hapus-penjualan.php?id=<?= $data['idStok'] ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Riwayat Penjualan ?')"><i class="fa fa-trash-alt"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#data').DataTable();
        } );
	</script>
</body>
</html>