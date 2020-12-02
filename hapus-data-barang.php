<?php 
require "connectDB.php";

$idBarang = $_GET["id"];
$data = mysqli_query($connectDB, "SELECT * FROM data_barang WHERE idBarang = $idBarang");
$data = mysqli_fetch_assoc($data);


mysqli_query($connectDB,"DELETE FROM data_barang WHERE idBarang = '$idBarang'");
if (mysqli_affected_rows($connectDB) > 0) {
    echo "
        <script>
            alert('Data Barang Berhasil DIHAPUS');
            document.location = 'dataBarang.php';
        </script>
    ";
}else {
    echo mysqli_error($connectDB);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Barang</title>
</head>
<body>
    
</body>
</html>