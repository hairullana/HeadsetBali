<?php

include "db.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Modal</title>
    <?php require "headtags.php" ?>
</head>
<body>
    <!-- sidebar -->
    <div class="row">
        <?php require "sidebar.php" ?>
        <div class="row-md-10 text-center mx-auto mt-5">
            <h3>Menghapus Data Modal ...</h3>
        </div>
    </div>
</body>
</html>


<?php 

if (!isset($_GET["id"])){
    echo "
        <script>
            Swal.fire('Halaman Error','Halaman Tidak Menerima Inputan ID','error').then(function(){
                window.location = 'data-modal.php';
            });
        </script>
    ";
}else{
    // ambil idModal
    $idModal = $_GET["id"];
    
    // hapus modal
    mysqli_query($db,"DELETE FROM modal WHERE idModal = $idModal");
    // reset idModal
    mysqli_query($db,"ALTER TABLE modal DROP idModal");
    mysqli_query($db,"ALTER TABLE modal ADD idModal INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
    // hapus stok
    mysqli_query($db,"DELETE FROM stok WHERE idModal = $idModal");
    // reset idStok
    mysqli_query($db,"ALTER TABLE stok DROP idStok");
    mysqli_query($db,"ALTER TABLE stok ADD idStok INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
    
    echo "
        <script>
            Swal.fire('Penghapusan Sukses','Data Modal Sudah Di Hapus','success').then(function(){
                window.location = 'data-modal.php';
            });
        </script>
    ";
}


?>