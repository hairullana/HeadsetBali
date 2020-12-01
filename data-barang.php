<?php

require "connectDB.php";

if (isset($_POST["tambahDataBarang"])) {
    $namaBarang = htmlspecialchars($_POST["namaBarang"]);

    mysqli_query($connectDB, "INSERT INTO data_barang VALUES ('','$namaBarang','0','0')");
    if (mysqli_affected_rows($connectDB) > 0) {
        echo "
            <script>
                alert('Data Barang Berhasil Di Ubah');
            </script>
        ";
    }else {
        echo mysqli_error($connectDB);
    }
}

$dataBarang = mysqli_query($connectDB,"SELECT * FROM data_barang");
$totalDataBarang = mysqli_num_rows($dataBarang);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.php"; ?>
    <title>Data Barang</title>
</head>
<body>

    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10">
            <h1 class="display-4 mt-4 text-center">Data Barang</h1>
            <hr>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="namaBarang" placeholder="Nama Barang">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" name="tambahDataBarang" class="btn btn-primary">Tambah Data Barang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <br>


            <?php if (mysqli_num_rows($dataBarang) > 0 ) : ?>
                
                <table class="table text-center">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Total Stok</th>
                        <th>Total Laku</th>
                        <th>Total Keuntungan</th>
                        <th>X̄ Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($dataBarang as $barang) : ?>
                    <tr>
                        <?php
                            $idBarang = $barang["idBarang"];
                            $laba = mysqli_query($connectDB,"SELECT count(idBarang) as totalBarang, SUM(hargaJual) as totalPenjualan, SUM(hargaModal) as totalModal FROM stok WHERE idBarang = $idBarang && status = 1");
                            $laba = mysqli_fetch_assoc($laba);
                            $totalKeuntungan = $laba["totalPenjualan"] - $laba["totalModal"];
                            if ($totalKeuntungan < 1) {
                                $mean = 0;
                            }else {
                                $mean = $totalKeuntungan / $laba["totalBarang"];
                            }

                        ?>
                        <td><?= $barang["namaBarang"]; ?></td>
                        <td><?= $barang["totalStok"]; ?></td>
                        <td><?= $barang["totalLaku"]; ?></td>
                        <td><?= $totalKeuntungan; ?></td>
                        <td><?= $mean = number_format($mean); ?></td>
                        <td><a class="btn btn-danger rounded-pill" href="editDataBarang.php?id=<?= $data['idBarang'] ?>">Edit</a> <a class="btn btn-danger rounded-pill " href="hapusDataBarang.php?id=<?= $data['idBarang'] ?>">Hapus</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <h1>Belum Ada Data</h1>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>