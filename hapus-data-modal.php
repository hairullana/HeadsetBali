<?php

include "connectDB.php";

// ambil idModal
$idModal = $_GET["id"];

// cek apakah DATA MODAL sudah di inputkan barang
$query = "SELECT * FROM stok WHERE idModal = $idModal";
$result = mysqli_query($connectDB,$query);
if (mysqli_num_rows($result) > 0 ) {

    $dataStok = mysqli_query($connectDB, "SELECT idBarang, count(idBarang) as totalBarang FROM stok WHERE idModal = $idModal GROUP BY idBarang");
    
    // ubah stok
    foreach ($dataStok as $data) {
        $idBarang = $data['idBarang'];
        $dataBarang = mysqli_query($connectDB, "SELECT * FROM data_barang WHERE idBarang = $idBarang");
        $dataBarang = mysqli_fetch_assoc($dataBarang);
        $totalStok = $dataBarang["totalStok"] - $data["totalBarang"];
        mysqli_query($connectDB,"UPDATE data_barang SET totalStok = $totalStok WHERE idBarang = $idBarang");
    }
}

// hapus modal
mysqli_query($connectDB,"DELETE FROM modal WHERE idModal = $idModal");
// reset idModal
mysqli_query($connectDB,"ALTER TABLE modal DROP idModal");
mysqli_query($connectDB,"ALTER TABLE modal ADD idModal INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
// hapus stok
mysqli_query($connectDB,"DELETE FROM stok WHERE idModal = $idModal");
// reset idStok
mysqli_query($connectDB,"ALTER TABLE stok DROP idStok");
mysqli_query($connectDB,"ALTER TABLE stok ADD idStok INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");

echo "
    <script>
        alert('Modal Berhasil di Hapus Cuy !');
        window.location.href = 'data-modal.php';
    </script>
";


?>