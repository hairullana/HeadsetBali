<?php

include "db.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Penjualan</title>
    <?php require "headtags.php" ?>
</head>
<body>
    <!-- sidebar -->
    <div class="row">
        <?php require "sidebar.php" ?>
        <div class="row-md-10 text-center mx-auto mt-5">
            <h3>Menghapus Data Penjualan ...</h3>
        </div>
    </div>
</body>
</html>


<?php 

if (!isset($_GET["id"])){
    echo "
        <script>
            Swal.fire('Halaman Error','Halaman Tidak Menerima Inputan ID','error').then(function(){
                window.location = 'riwayat-penjualan.php';
            });
        </script>
    ";
}else{
    // ambil id stok
    $idStok = $_GET["id"];

    // ubah status jadi 1 (masih ada)
    mysqli_query($db,"UPDATE stok SET status = 1 WHERE idStok = $idStok");
    
    echo "
        <script>
            Swal.fire('Penghapusan Sukses','Data Penjualan Sudah Di Hapus','success').then(function(){
                window.location = 'riwayat-penjualan.php';
            });
        </script>
    ";
}


?>