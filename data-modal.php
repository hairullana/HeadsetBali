<?php

require "db.php";

//konfirgurasi pagination
$jumlahDataPerHalaman = 10;
$jumlahData = mysqli_num_rows(mysqli_query($db, "SELECT * FROM modal"));
//ceil() = pembulatan ke atas
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
//menentukan halaman aktif
//$halamanAktif = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
if ( isset($_GET["page"])){
    $halamanAktif = $_GET["page"];
}else{
    $halamanAktif = 1;
}
//data awal
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

$dataModal = mysqli_query($db, "SELECT * FROM modal ORDER BY idModal DESC LIMIT $awalData, $jumlahDataPerHalaman");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.php"; ?>
    <title>Data Modal</title>
</head>
<body>

    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-10">
            <h1 class="text-center display-4 mt-4">Data Modal</h1>
            <hr>
            
            <div class="row">
                <div class="col mt-3">

                    <!-- pagination -->
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center">
                            <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
                                <?php if( $i == $halamanAktif ) : ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                    </li>   
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <!-- end pagination -->

                    <table class="table text-center">
                        <tr class="bg-primary text-white">
                            <th>Tanggal</th>
                            <th>List Barang</th>
                            <th>Status</th>
                            <th>Total Modal</th>
                            <th>Total Penjualan</th>
                            <th>Keuntungan Bersih</th>
                            <th>Aksi</th>
                        </tr>
                        
                        <?php foreach ($dataModal as $modal) : ?>
                            <?php
                                $idModal = $modal["idModal"];
                                $dataBarang = mysqli_query($db,"SELECT namaBarang, COUNT(namaBarang) as jumlahBarang FROM data_barang INNER JOIN stok ON data_barang.idBarang = stok.idBarang where stok.idModal = $idModal GROUP BY namaBarang");
                            ?>
                            <tr>
                                <td><?= $modal["tanggalPembelian"] ?></td>
                                <td class="text-left">
                                    <ul>
                                        <?php foreach ($dataBarang as $barang) : ?>
                                            <li><?= $barang["namaBarang"] ?> (<?= $barang["jumlahBarang"] ?>)</li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td><?php if ($modal["status"] == 1) { echo "Ada";}else {echo "Habis";} ?></td>
                                <td>Rp. <?= number_format($modal["totalModal"] + $modal["ongkir"]) ?></td>
                                <td>Rp. <?= number_format($modal["totalPenjualan"]) ?></td>
                                <td><?php if ($modal["status"] == 1){ echo "Belum Diketahui"; }else{ echo "Rp. " . number_format($modal["totalPenjualan"]-($modal["totalModal"]+$modal["ongkir"]));} ?></td>
                                <td><a href="hapus-data-modal.php?id=<?= $modal['idModal'] ?>" class="btn btn-primary rounded-pill" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Pelamar ?')"><i class="fa fa-trash-alt"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>