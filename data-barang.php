<?php

require "db.php";

$dataBarang = mysqli_query($db,"SELECT *, SUM(stok.hargaModal) as totalHargaModal, COUNT(stok.idBarang) as totalBarang FROM data_barang INNER JOIN stok ON data_barang.idBarang = stok.idBarang GROUP BY data_barang.idBarang ORDER BY SUM(stok.status) DESC");

// status
// 0 = laku
// 1 = belum laku

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
                                    <button type="submit" name="tambahDataBarang" class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin Ingin Menambah Data Barang ?')">Tambah Data Barang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <br>


            <?php if (mysqli_num_rows($dataBarang) > 0 ) : ?>
                <div class="col-md-10 offset-md-1 my-3">
                    <table class="table text-center" id="data">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Nama Barang</th>
                                <th>Total Stok</th>
                                <th>Total Laku</th>
                                <th>X̄ Pembelian</th>
                                <th>X̄ Penjualan</th>
                                <th>X̄ Keuntungan</th>
                                <th>Total Keuntungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataBarang as $barang) : ?>
                            <tr>
                                <?php
                                    $idBarang = $barang["idBarang"];
                                    $laba = mysqli_query($db,"SELECT count(idBarang) as totalBarang, SUM(hargaJual) as totalPenjualan, SUM(hargaModal) as totalModal FROM stok WHERE idBarang = $idBarang AND status = 0");
                                    $laba = mysqli_fetch_assoc($laba);
                                    $totalKeuntungan = $laba["totalPenjualan"] - $laba["totalModal"];
                                    
                                    // cari rata2 pembelian
                                    $meanPembelian = $barang["totalHargaModal"] / $barang["totalBarang"];
                                    
                                    // cari rata2 penjualan
                                    if ($totalKeuntungan < 1) {
                                        $meanPenjualan = 0;
                                    }else {
                                        $meanPenjualan = $laba["totalPenjualan"] / $laba["totalBarang"];
                                    }
                                    
                                    // cari rata2 keuntungan
                                    if ($totalKeuntungan < 1) {
                                        $meanKeuntungan = 0;
                                    }else {
                                        $meanKeuntungan = $totalKeuntungan / $laba["totalBarang"];
                                    }
                                    
                                    
                                ?>
                                <td class="text-left"><?= $barang["namaBarang"] ?></td>
                                <td><?= mysqli_num_rows(mysqli_query($db, "SELECT * from stok where idBarang = $idBarang AND status = 1")); ?></td>
                                <td><?= mysqli_num_rows(mysqli_query($db, "SELECT * from stok where idBarang = $idBarang AND status = 0")); ?></td>
                                <td><?= "Rp. " . number_format($meanPembelian); ?></td>
                                <td><?= "Rp. " . number_format($meanPenjualan); ?></td>
                                <td><?= "Rp. " . number_format($meanKeuntungan); ?></td>
                                <td><?= "Rp. " . number_format($totalKeuntungan) ?></td>
                                <td><a class="btn btn-primary rounded-pill" href="edit-data-barang.php?id=<?= $barang['idBarang'] ?>"><i class="fa fa-edit"></i></a> <a class="btn btn-primary rounded-pill " href="hapus-data-barang.php?id=<?= $barang['idBarang'] ?>" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Barang ?')"><i class="fa fa-trash-alt"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <h1>Belum Ada Data</h1>
            <?php endif; ?>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#data').DataTable();
        } );
	</script>

</body>
</html>

<?php

if (isset($_POST["tambahDataBarang"])) {
    $namaBarang = htmlspecialchars($_POST["namaBarang"]);

    mysqli_query($db, "INSERT INTO data_barang VALUES('','$namaBarang')");
    if (mysqli_affected_rows($db) > 0) {
        echo "
            <script>
                Swal.fire('Penambahan Data Sukses','Data Barang Sudah Ditambah','success').then(function(){
                    window.location = 'data-barang.php';
                });
            </script>
        ";
    }else {
        echo mysqli_error($db);
    }
}



?>