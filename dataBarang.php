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
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <title>Data Barang</title>
</head>
<body>
    
    <div id="header">
        <ul>
            <li><a href="index.php">Overview</a></li>
            <li><a href="penjualan.php">Penjulana</a></li>
            <li><a href="pembelian.php">Pembelian</a></li>
            <li><a href="data-modal.php">Data Modal</a></li>
            <li><a href="stok-barang.php">Stok Barang</a></li>
            <li><a href="jenis-barang.php">Jenis Barang</a></li>
        </ul>
    </div>

    <div id="body">
        <form action="" method="POST">
            <label for="namaBarang">Nama Barang</label><br>
            <input type="text" name="namaBarang">
            <button type="submit" name="tambahDataBarang">Tambah Data</button>
        </form>

        <br>


        <?php if (mysqli_num_rows($dataBarang) > 0 ) : ?>
            <table border=1>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Total Stok</th>
                    <th>Total Terjual</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($dataBarang as $data) : ?>
                    <tr>
                        <td><?= $data["idBarang"] ?></td>
                        <td><?= $data["namaBarang"] ?></td>
                        <td><?= $data["totalStok"] ?></td>
                        <td><?= $data["totalLaku"] ?></td>
                        <td><a class="btn btn-danger rounded-pill" href="editDataBarang.php?id=<?= $data['idBarang'] ?>">Edit</a> <a class="btn btn-danger rounded-pill " href="hapusDataBarang.php?id=<?= $data['idBarang'] ?>">Hapus</a></td>
                    </tr>
                <?php endforeach; ?>
                
            </table>
        <?php else : ?>
            <h1>Belum Ada Data</h1>
        <?php endif; ?>

    </div>



</body>
</html>