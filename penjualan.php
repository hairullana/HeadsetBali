<?php

require 'db.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "headtags.php"; ?>
    <title>Penjualan Barang</title>
</head>
<body>

    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10 mt-4">
            <h1 class="display-4 text-center">Penjualan Barang</h1>
            <hr>
            <div class="col-md-8 offset-md-2 card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Penjualan</label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="idBarang">Nama Barang</label>
                            <select name="idBarang" class="form-control">
                                <option value="0" selected disabled>Pilih Nama Barang</option>
                                <?php
                                    $dataBarang = mysqli_query($db,"SELECT * FROM data_barang");
                                    foreach ($dataBarang as $data) :
                                ?>
                                        <option value="<?= $data['idBarang'] ?>"><?= $data["namaBarang"] ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hargaJual">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp. </div>
                                </div>
                                <input type="text" name="hargaJual" class="form-control" placeholder="Harga Jual">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submitPenjualan">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

<?php

if (isset($_POST["submitPenjualan"])) {
    $idBarang = htmlspecialchars($_POST["idBarang"]);
    $hargaJual = htmlspecialchars($_POST["hargaJual"]);
    $tanggal = $_POST["tanggal"];

    // ambil barang paling lama
    $dataStok = mysqli_query($db, "SELECT * FROM stok WHERE idBarang = $idBarang && status = 0 ORDER BY idStok ASC");
    if (mysqli_num_rows($dataStok) < 1){
        echo "
            <script>
                Swal.fire('Penambahan Data Gagal','Stok Barang Kosong Bos Hairul Lana Gans','warning').then(function(){
                    window.location = 'penjualan.php';
                });
            </script>
        ";
    }else{
        $dataStok = mysqli_fetch_assoc($dataStok);
        $idStok = $dataStok["idStok"];
        $idModal = $dataStok["idModal"];
        $idBarang = $dataStok["idBarang"];
    
        // pasang harga jual di tabel stok
        mysqli_query($db, "UPDATE stok SET hargaJual = $hargaJual, status = 1, tanggalTerjual = DATE_FORMAT(tanggalTerjual, '$tanggal') WHERE idStok = $idStok");
    
        // ganti status dan totalPenjualan di tabel modal
        $dataModal = mysqli_query($db,"SELECT * FROM modal WHERE idModal = $idModal");
        $dataModal = mysqli_fetch_assoc($dataModal);
        $totalPenjualan = $dataModal["totalPenjualan"] + $hargaJual;
    
        // jika semua terjual, ubah status modal
        if (mysqli_num_rows(mysqli_query($db,"SELECT * FROM stok WHERE idModal = $idModal AND status = 1")) == $dataModal["totalBarang"]){
            mysqli_query($db,"UPDATE modal SET status = 1 WHERE idModal = $idModal");
        }
    
        // ubah totalPenjualan modal
        mysqli_query($db,"UPDATE modal SET totalPenjualan = $totalPenjualan WHERE idModal = $idModal");
        
        if (mysqli_affected_rows($db) > 0) {
            echo "
                <script>
                    Swal.fire('Penambahan Data Sukses','Data Penjualan Modal Sudah Ditambah','success').then(function(){
                        window.location = 'penjualan.php';
                    });
                </script>
            ";
        }
    }

}

?>