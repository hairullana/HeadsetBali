<?php require "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Barang</title>
    <?php require "headtags.php" ?>
</head>
<body>
    <!-- sidebar -->
    <div class="row">
        <?php require "sidebar.php" ?>
        <div class="row-md-10 text-center mx-auto mt-5">
            <h3>Menghapus Data Barang ...</h3>
        </div>
    </div>
</body>
</html>

<?php

if (!isset($_GET["id"])){
    echo "
        <script>
            Swal.fire('Halaman Error','Halaman Tidak Menerima Inputan ID','error').then(function(){
                window.location = 'data-barang.php';
            });
        </script>
    ";
}else{
    $idBarang = $_GET["id"];
    $data = mysqli_query($db, "SELECT * FROM data_barang WHERE idBarang = $idBarang");
    $data = mysqli_fetch_assoc($data);
    mysqli_query($db,"DELETE FROM data_barang WHERE idBarang = '$idBarang'");
    if (mysqli_affected_rows($db) > 0) {
        echo "
            <script>
                Swal.fire('Penghapusan Sukses','Data Barang Sudah Di Hapus','success').then(function(){
                    window.location = 'data-barang.php';
                });
            </script>
        ";
    }else {
        echo mysqli_error($db);
    }
}

?>