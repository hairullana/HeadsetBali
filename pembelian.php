<?php

require 'db.php';
session_start();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.php"; ?>
    <title>Pembelian Barang</title>
</head>
<body>
    
    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10">
            <h1 class="text-center display-4 mt-4">Pembelian Barang</h1>
            <hr>
            <?php if (!isset($_POST["tambahDataModal"]) && !isset($_POST["submitTotalJenisBarang"])) : ?>

                <div class="card col-md-8 offset-md-2">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pembelian</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="totalModal">Total Pembelian (Tanpa Ongkir)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp. </div>
                                    </div>
                                    <input type="text" name="totalModal" class="form-control" placeholder="Total Pembelian">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="totalModal">Total Ongkir</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp. </div>
                                    </div>
                                    <input type="text" name="ongkir" class="form-control" placeholder="Total Ongkir">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="totalBarang">Total Barang</label>
                                <input type="number" name="totalBarang" class="form-control" placeholder="Total Barang">
                            </div>
                            <div class="form-group">
                                <button onclick="return confirm('Apakah Anda Yakin Ingin Menambah Data Pembelian ?')" type="submit" name="tambahDataModal" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else : ?>
                    

                    <?php
                        if (isset($_POST["submitTotalJenisBarang"])) :
                            $totalJenisBarang = htmlspecialchars($_POST["totalJenisBarang"]);
                            $totalBarang = $_SESSION["totalBarang"];
                            if ($totalJenisBarang > $totalBarang){
                                $dataModal = mysqli_query($db, "SELECT MAX(idModal) as idModal FROM modal");
                                $dataModal = mysqli_fetch_assoc($dataModal);
                                $idModal = $dataModal["idModal"];
                                mysqli_query($db,"DELETE FROM modal WHERE idModal = $idModal");
                                echo "
                                    <script>
                                        Swal.fire('Penambahan Data Gagal','Jumlah Jenis Barang Lebih Banyak Dari Jumlah Barang','error').then(function(){
                                            window.location = 'pembelian.php';
                                        });
                                    </script>
                                ";
                            }else{
                                echo "
                                    <script>
                                        Swal.fire('Penambahan Data Sukses','Data Pembelian Modal Sudah Ditambah','success');
                                    </script>
                                ";
                            }
                    ?>

                        <div class="card col-md-8 offset-md-2">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="totalJenisBarang" value="<?= $totalJenisBarang ?>">
                                    <?php for ($i=0 ; $i<$totalJenisBarang ; $i++) : ?>
                                        <div class="form-group">
                                            <label for="idBarang<?= $i ?>">Jenis Barang <?= $i+1 ?></label>
                                            <select name="idBarang<?= $i ?>" class="form-control">
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
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp. </div>
                                                    </div>
                                                    <input type="text" name="modalBarang<?= $i ?>" class="form-control" placeholder="Harga Modal Barang">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group">
                                                    <input type="number" name="totalBarang<?= $i ?>" placeholder="Total Barang" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                        <div class="form-group">
                                            <button onclick="return confirm('Apakah Data Yang Anda Inputkan Sudah Benar ?')" type="submit" name="tambahStokBarang" class="btn btn-primary">Simpan Data</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="card col-md-8 offset-md-2">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="totalJenisBarang">Jumlah Jenis Barang</label>
                                        <input type="number" name="totalJenisBarang" plcaceholder="Jumlah Jenis Barang" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button onclick="return confirm('Lanjut ?')" type="submit" name="submitTotalJenisBarang" class="btn btn-primary">Lanjut Bosku</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php

if (isset($_POST["tambahDataModal"])) {
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $totalModal = htmlspecialchars($_POST["totalModal"]);
    $ongkir = htmlspecialchars($_POST["ongkir"]);
    $totalBarang = htmlspecialchars($_POST["totalBarang"]);
    $_SESSION["totalBarang"] = $totalBarang;
    

    mysqli_query($db,"INSERT INTO modal VALUES('','$tanggal',$totalModal,$ongkir,$totalBarang,0,0)");
    if (mysqli_affected_rows($db) > 0){
        echo "
            <script>
                Swal.fire('Penambahan Data Sukses','Data Pembelian Modal Sudah Ditambah','success');
            </script>
        ";
    }else {
        echo mysqli_error($db);
    }
}



if (isset($_POST["tambahStokBarang"])) {
    $totalJenisBarang = htmlspecialchars($_POST["totalJenisBarang"]);
    
    $dataModal = mysqli_query($db, "SELECT MAX(idModal) as idModal FROM modal");
    $dataModal = mysqli_fetch_assoc($dataModal);
    $idModal = $dataModal["idModal"];
    $TOTAL = 0;
    for ($i=0;$i<$totalJenisBarang;$i++){
        $idBarang[$i] = htmlspecialchars($_POST["idBarang$i"]);
        $modalBarang[$i] = htmlspecialchars($_POST["modalBarang$i"]);
        $totalBarang[$i] = htmlspecialchars($_POST["totalBarang$i"]);
        $TOTAL += $totalBarang[$i];
    }
    // die;
    
    $totalBarangAwal = $_SESSION["totalBarang"];

    if ($totalBarangAwal != $TOTAL){
        mysqli_query($db,"DELETE FROM modal WHERE idModal = $idModal");
        echo "
            <script>
                Swal.fire('Penambahan Data Gagal','Jumlah Barang Tidak Sesuai, Seharusnya Total Barang = $totalBarangAwal','error');
            </script>
        ";

    }else{
        for ($i=0 ; $i<$totalJenisBarang ; $i++){
            for ($j=0 ; $j<$totalBarang[$i] ; $j++) {
                mysqli_query($db, "INSERT INTO stok VALUES ('','$idModal','$idBarang[$i]','$modalBarang[$i]',0,0,'')");
            }
        }
    
    
        if (mysqli_affected_rows($db) > 0){
            echo "
                <script>
                    Swal.fire('Penambahan Data Sukses','Data Stok Barang Sudah Ditambah','success');
                </script>
            ";
        }else {
            echo mysqli_error($db);
        }
    }



}

?>