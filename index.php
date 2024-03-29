<?php
require "db.php";


if (isset($_POST["detil"])){
    echo "
        <script>
            window.location.href = '#detil';
        </script>
    ";
}

if (isset($_POST["cek"])){
    $tahun = $_POST["tahun"];
    echo "
        <script>
            window.location.href = 'index.php?tahun=$tahun';
        </script>
    ";
}

if(isset($_GET["tahun"])){
    $tahun = $_GET["tahun"];
}else {
    $tahun = date('Y');
}

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
                <h1 class="display-4 mt-4 text-center">Headset Bali</h1>
                <hr>
                <div class="row text-white mt-4">
                    <div class="col-md-4 offset-md-4 text-center">
                        <form action="" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Tahun</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="tahun">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                </select>
                                <button type="submit" class="button btn-primary" name="cek"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-5 offset-md-1 card bg-primary" style="width: 25rem;">
                        <div class="card-body">
                            <h3 class="card-title"><strong>Pendapatan Tahun <?= $tahun; ?></strong></h3>
                            <?php
                                $dataTahun = mysqli_query($db, "SELECT * from stok where tanggalTerjual > '$tahun-01-01' && tanggalTerjual < '$tahun-12-31'");
                                $modalTahun = 0;
                                $penjualanTahun = 0;
                                foreach($dataTahun as $data) {
                                    $modalTahun += $data["hargaModal"];
                                    $penjualanTahun += $data["hargaJual"];
                                }
                                $keuntunganBersih = $penjualanTahun - $modalTahun;
                                ?>
                            <ul>
                                <li>Total Penjualan = Rp. <?= number_format($penjualanTahun) ?></li>
                                <li>Keuntungan Bersih = Rp. <?= number_format($keuntunganBersih) ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5 card bg-primary mx-3" style="width: 25rem;">
                        <div class="card-body">
                            <h3 class="card-title"><strong>Pendapatan Bulan <?= date('M'); ?></strong></h3>
                            <?php
                                $bulan = date('m');
                                $dataBulan = mysqli_query($db, "SELECT * from stok where tanggalTerjual >= '$tahun-$bulan-01' && tanggalTerjual <= '$tahun-$bulan-31'");
                                $modalBulan = 0;
                                $penjualanBulan = 0;
                                foreach($dataBulan as $data) {
                                    $modalBulan += $data["hargaModal"];
                                    $penjualanBulan += $data["hargaJual"];
                                }
                                $keuntunganBersih = $penjualanBulan - $modalBulan;
                            ?>
                            <ul>
                                <li>Total Penjualan = Rp. <?= number_format($penjualanBulan) ?></li>
                                <li>Keuntungan Bersih = Rp. <?= number_format($keuntunganBersih) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <?php
                            for ($i=1;$i<=12;$i++){
                                if(strlen($i<2)){
                                    $bulan = "0" . $i;
                                }else {
                                    $bulan = $i;
                                }
                                $bulan = mysqli_query($db, "SELECT * from stok where tanggalTerjual >= '$tahun-$bulan-01' && tanggalTerjual <= '$tahun-$bulan-31'");
                                $modal[$i] = 0;
                                $penjualan[$i] = 0;
                                foreach($bulan as $data) {
                                    $modal[$i] += $data["hargaModal"];
                                    $penjualan[$i] += $data["hargaJual"];
                                }
                                $keuntunganBersihBulan[$i] = $penjualan[$i] - $modal[$i];
                            }
                        ?>
                        <table class="table m-5 text-center">
                            <tr class="bg-primary text-white">
                                <th>BULAN</th>
                                <th>PENJUALAN</th>
                                <th>KEUNTUNGAN</th>
                                <th>DETAIL</th>
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
                                    <td><?= "Rp. " . number_format($penjualan[$i]) ?></td>
                                    <td><?= "Rp. " . number_format($keuntunganBersihBulan[$i]) ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="bulan" value="<?= $i ?>">
                                            <button type="submit" class="btn btn-primary rounded-pill" name="detil"><i class="fa fa-info-circle"></i> Detail</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endfor;?>
                            <tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row">
                <?php
                    if (isset($_POST["detil"])) :
                        $bulan = $_POST["bulan"];
                        echo  "<h2 id='detil' class='text-center col-12 mb-5'>Data Penjualan Bulan " . $bulan . "</h2>";
                        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        for ($i=1;$i<=$jumlahHari;$i++) :
                            if (strlen($i) == 1) {
                                $hari = "0" . $i;
                            }else {
                                $hari = $i;
                            }
                            $dataPenjualan = mysqli_query($db, "SELECT sum(hargaModal) as hargaModal, sum(hargaJual) as hargaJual FROM  stok WHERE tanggalTerjual = '$tahun-$bulan-$hari'");
                            $dataPenjualan = mysqli_fetch_assoc($dataPenjualan);
                ?>

                            
                            <div class="col-md-2 mt-2">
                                <div class="card">
                                    <div class="card-header text-center bg-dark text-white">
                                        <h5><?= $i ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <i class="fa fa-arrow-circle-up"></i> Rp. <?= number_format($dataPenjualan["hargaJual"]) ?><br>
                                        <i class="fa fa-arrow-circle-right"></i> Rp. <?= number_format($dataPenjualan["hargaJual"] - $dataPenjualan["hargaModal"]) ?>
                                    </div>
                                </div>
                            </div>
                
                        <?php endfor; ?>
                <?php endif; ?>
                </div>
            </div>
    </div>

    

    <script src="assets/jquery/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>