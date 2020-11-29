<?php
require "connectDB.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <title>Headset Bali</title>
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
        <h1>Keuntungan Tahun Ini</h1>
        <?php
            $tahun = date('Y');
            $dataTahun = mysqli_query($connectDB, "SELECT * from stok where tanggalTerjual > '$tahun-01-01' && tanggalTerjual < '$tahun-12-31'");
            $modalTahun = 0;
            $penjualanTahun = 0;
            foreach($dataTahun as $data) {
                $modalTahun += $data["hargaModal"];
                $penjualanTahun += $data["hargaJual"];
            }
            $keuntunganBersih = $penjualanTahun - $modalTahun;
        ?>
        <ul>
            <li>Total Penjualan = Rp. <?= $penjualanTahun ?></li>
            <li>Keuntungan Bersih = Rp. <?= $keuntunganBersih ?></li>
        </ul>
        <h1>Keuntungan Bulan Ini</h1>
        <?php
            $bulan = date('m');
            $dataBulan = mysqli_query($connectDB, "SELECT * from stok where tanggalTerjual > '$tahun-$bulan-01' && tanggalTerjual < '$tahun-$bulan-31'");
            $modalBulan = 0;
            $penjualanBulan = 0;
            foreach($dataBulan as $data) {
                $modalBulan += $data["hargaModal"];
                $penjualanBulan += $data["hargaJual"];
            }
            $keuntunganBersih = $penjualanBulan - $modalBulan;
        ?>
        <ul>
            <li>Total Penjualan = Rp. <?= $penjualanBulan ?></li>
            <li>Keuntungan Bersih = Rp. <?= $keuntunganBersih ?></li>
        </ul>
        <h1>Keuntungan Bulan Ini</h1>
        <?php
            for ($i=1;$i<=12;$i++){
                if(strlen($i<2)){
                    $bulan = "0" . $i;
                }else {
                    $bulan = $i;
                }
                $bulan = mysqli_query($connectDB, "SELECT * from stok where tanggalTerjual > '$tahun-$bulan-01' && tanggalTerjual < '$tahun-$bulan-31'");
                $modal[$i] = 0;
                $penjualan[$i] = 0;
                foreach($bulan as $data) {
                    $modal[$i] += $data["hargaModal"];
                    $penjualan[$i] += $data["hargaJual"];
                }
                $keuntunganBersihBulan[$i] = $penjualan[$i] - $modal[$i];
            }
        ?>
        <table border=1>
            <tr>
                <th>BULAN</th>
                <th>Januari</th>
                <th>Februari</th>
                <th>Maret</th>
                <th>April</th>
                <th>Mei</th>
                <th>Juni</th>
                <th>Juli</th>
                <th>Agustus</th>
                <th>September</th>
                <th>Oktober</th>
                <th>November</th>
                <th>Desember</th>
            </tr>
                <th>LABA KOTOR</th>
                <?php for($i=1;$i<=12;$i++) : ?>
                <td><?= $penjualan[$i]; ?></td>
                <?php endfor;?>
            <tr>
            </tr>
                <th>LABA BERSIH</th>
                <?php for($i=1;$i<=12;$i++) : ?>
                <td><?= $keuntunganBersihBulan[$i]; ?></td>
                <?php endfor;?>
            <tr>

            </tr>
        </table>
    </div>

</body>
</html>