<?php

include "connectDB.php";

$idModal = $_GET["id"];

$query = "SELECT * FROM stok WHERE idModal = $idModal";
$result = mysqli_query($connectDB,$query);
if (mysqli_num_rows($result) > 0 ) {
    $dataStok = mysqli_query($connectDB, "SELECT idBarang, count(idBarang) as totalBarang FROM stok WHERE idModal = $idModal GROUP BY idModal");
    
    // ubah stok
    foreach ($dataStok as $data) {
        $idBarang = $data['idBarang'];
        $dataBarang = mysqli_query($connectDB, "SELECT * FROM data_barang WHERE idBarang = $idBarang");
        $dataBarang = mysqli_fetch_assoc($dataBarang);
        $totalStok = $dataBarang["totalStok"] - $data["totalBarang"];
        mysqli_query($connectDB,"UPDATE data_barang SET totalStok = $totalStok");
    }
}

// hapus modal
mysqli_query($connectDB,"DELETE FROM modal WHERE idModal = $idModal");
// hapus stok
mysqli_query($connectDB,"DELETE FROM stok WHERE idModal = $idModal");

echo "
    <script>
        alert('Data Modal Tidak Ditemukan');
        window.location.href = 'data-modal.php';
    </script>
";


?>