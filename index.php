<?php
require "connectDB.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "headtags.php"; ?>
    <title>Headset Bali</title>
</head>
<body>
    <div class="row">
        
        <?php require "sidebar.php"; ?>

        <div class="col-md-10">
            <div class="container">
                <h1 class="display-4 mt-4 text-center">Headset Bali</h1>
                <hr>
                <div class="row text-white mt-4">
                    <div class="col-md-5 offset-md-1 card bg-primary" style="width: 25rem;">
                        <div class="card-body">
                            <h3 class="card-title"><strong>Pendapatan Tahun <?= date('Y'); ?></strong></h3>
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
                        </div>
                    </div>
                    <div class="col-md-5 card bg-primary mx-3" style="width: 25rem;">
                        <div class="card-body">
                            <h3 class="card-title"><strong>Pendapatan Bulan <?= date('M'); ?></strong></h3>
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
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-2">
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
                        <table class="table m-5 text-center" border=1>
                            <tr class="bg-primary text-white">
                                <th>BULAN</th>
                                <th>MODAL</th>
                                <th>PENJUALAN</th>
                                <th>KEUNTUNGAN</th>
                            </tr>    
                            <?php for($i=1;$i<=12;$i++) : ?>
                                <?php
                                    $namaBulan = array (1 =>   'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember'
                                    );
                                ?>
                                <tr>
                                    <th><?= $namaBulan[$i] ?></th>
                                    <td><?= $modal[$i] ?></td>
                                    <td><?= $penjualan[$i] ?></td>
                                    <td><?= $keuntunganBersihBulan[$i]; ?></td>
                                </tr>
                            <?php endfor;?>
                            <tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</body>
</html>