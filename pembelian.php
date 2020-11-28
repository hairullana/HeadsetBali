<?php

require 'connectDB.php';

if (isset($_POST["tambahDataModal"])) {
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $totalModal = htmlspecialchars($_POST["totalModal"]);
    $ongkir = htmlspecialchars($_POST["ongkir"]);
    $totalBarang = htmlspecialchars($_POST["totalBarang"]);

    mysqli_query($connectDB,"INSERT INTO modal VALUES('','$tanggal',$totalModal,$ongkir,$totalBarang,0,0)");
    if (mysqli_affected_rows($connectDB) > 0){
        echo "
            <script>
                alert('data berhasil ditambahkan');
            </script>
        ";
    }else {
        echo mysqli_error($connectDB);
    }
}



if (isset($_POST["tambahStokBarang"])) {
    $totalJenisBarang = htmlspecialchars($_POST["totalJenisBarang"]);
    $dataModal = mysqli_query($connectDB, "SELECT MAX(idModal) as idModal FROM modal");
    $dataModal = mysqli_fetch_assoc($dataModal);
    $idModal = $dataModal["idModal"];
    for ($i=0;$i<$totalJenisBarang;$i++){
        $idBarang[$i] = htmlspecialchars($_POST["idBarang$i"]);
        $modalBarang[$i] = htmlspecialchars($_POST["modalBarang$i"]);
        $totalBarang[$i] = htmlspecialchars($_POST["totalBarang$i"]);
    }
    
    for ($i=0 ; $i<$totalJenisBarang ; $i++){
        for ($j=0 ; $j<$totalBarang[$i] ; $j++) {
            mysqli_query($connectDB, "INSERT INTO stok VALUES ('','$idModal','$idBarang[$i]','$modalBarang[$i]',0,0)");
        }
    }


    if (mysqli_affected_rows($connectDB) > 0){
        echo "
            <script>
                alert('data berhasil ditambahkan');
            </script>
        ";
    }else {
        echo mysqli_error($connectDB);
    }


}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
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
            <li><a href="dataBarang.php">Data Barang</a></li>
        </ul>
    </div>

    <hr>

    <div id="body">

        <?php if (!isset($_POST["tambahDataModal"]) && !isset($_POST["submitTotalJenisBarang"])) : ?>

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
                <form action="" method="POST">
                    <input type="number" name="totalJenisBarang">
                    <button type="submit" name="submitTotalJenisBarang">Lanjut Bosss</button>
                </form>

                <?php
                    if (isset($_POST["submitTotalJenisBarang"])) :
                        echo "
                            <script>
                                alert('data berhasil ditambahkan');
                            </script>
                        ";
                        $totalJenisBarang = htmlspecialchars($_POST["totalJenisBarang"]);
                ?>

                    <form action="" method="POST">
                        <input type="hidden" name="totalJenisBarang" value="<?= $totalJenisBarang ?>">
                        <?php for ($i=0 ; $i<$totalJenisBarang ; $i++) : ?>
                            <label for="idBarang<?= $i ?>">Nama Barang</label><br>
                            <select name="idBarang<?= $i ?>" id="">
                                <?php
                                    $dataBarang = mysqli_query($connectDB,"SELECT * FROM data_barang");
                                    foreach ($dataBarang as $data) :
                                ?>
                                        <option value="<?php $data["idBarang"] ?>"><?= $data["namaBarang"] ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <label for="modalBarang<?= $i ?>">Harga Modal Barang</label>
                            <input type="text" name="modalBarang<?= $i ?>">
                            <label for="totalBarang<?= $i ?>">Total Barang</label>
                            <input type="number" name="totalBarang<?= $i ?>">
                            <button type="submit" name="tambahStokBarang">Tambah Data</button>
                        <?php endfor; ?>
                    </form>

                <?php endif; ?>
            

        <?php endif; ?>

    </div>

</body>
</html>