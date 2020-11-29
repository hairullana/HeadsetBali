<?php

require 'connectDB.php';

if (isset($_POST["submitPenjualan"])) {
    $idBarang = htmlspecialchars($_POST["idBarang"]);
    $hargaJual = htmlspecialchars($_POST["hargaJual"]);
    $tanggal = $_POST["tanggal"];

    $dataStok = mysqli_query($connectDB, "SELECT * FROM stok WHERE idBarang = $idBarang && status = 0 ORDER BY idStok ASC");
    $dataStok = mysqli_fetch_assoc($dataStok);
    $idStok = $dataStok["idStok"];
    $idModal = $dataStok["idModal"];
    $idBarang = $dataStok["idBarang"];

    // pasang harga jual di tabel stok
    mysqli_query($connectDB, "UPDATE stok SET hargaJual = $hargaJual, status = 1, tanggalTerjual = DATE_FORMAT(tanggalTerjual, '$tanggal') WHERE idStok = $idStok");

    // ganti totalStok dan totalLaku di tabel data_barang
    $dataBarang = mysqli_query($connectDB,"SELECT * FROM data_barang WHERE idBarang = $idBarang");
    $dataBarang = mysqli_fetch_assoc($dataBarang);
    $totalStok = $dataBarang["totalStok"]-1;
    $totalLaku = $dataBarang["totalLaku"]+1;
    mysqli_query($connectDB, "UPDATE data_barang SET totalStok = $totalStok, totalLaku = $totalLaku WHERE idBarang = $idBarang");

    // ganti status dan totalPenjualan di tabel modal
    $dataModal = mysqli_query($connectDB,"SELECT * FROM modal WHERE idModal = $idModal");
    $dataModal = mysqli_fetch_assoc($dataModal);
    $status = $dataModal["status"];
    $totalPenjualan = $dataModal["totalPenjualan"] + $hargaJual;
    if (mysqli_num_rows(mysqli_query($connectDB,"SELECT * FROM stok WHERE idModal = $idModal && status = 1")) == $dataModal["totalBarang"]){
        mysqli_query($connectDB,"UPDATE modal SET status = 1 WHERE idModal = $idModal");
    }
    mysqli_query($connectDB,"UPDATE modal SET totalPenjualan = $totalPenjualan WHERE idModal = $idModal");
    
    if (mysqli_affected_rows($connectDB) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan');
            </script>
        ";
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="POST">
        <label for="tanggal">Tanggal Penjualan</label><br>
        <input type="date" name="tanggal"><br>
        <label for="idBarang">Nama Barang</label><br>
        <select name="idBarang" id="">
            <?php
                $dataBarang = mysqli_query($connectDB,"SELECT * FROM data_barang");
                foreach ($dataBarang as $data) :
            ?>
                    <option value="<?= $data['idBarang'] ?>"><?= $data["namaBarang"] ?></option>
            <?php
                endforeach;
            ?>
        </select><br>
        <label for="hargaJual">Harga Jual</label><br>
        <input type="text" name="hargaJual"><br>
        <button type="submit" name="submitPenjualan">Submit Data Penjualan</button>
    </form>

</body>
</html>