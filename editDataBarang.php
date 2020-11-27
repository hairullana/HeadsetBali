<?php

require "connectDB.php";

$idBarang = $_GET["id"];
$data = mysqli_query($connectDB, "SELECT * FROM data_barang WHERE idBarang = $idBarang");
$data = mysqli_fetch_assoc($data);


if(isset($_POST["editNamaBarang"])) {
    $namaBarang = htmlspecialchars($_POST["namaBarang"]);

    mysqli_query($connectDB,"UPDATE data_barang SET namaBarang = '$namaBarang' WHERE idBarang = '$idBarang'");
    if (mysqli_affected_rows($connectDB) > 0) {
        echo "
            <script>
                alert('Data Barang Berhasil Ditambahkan');
                document.location = 'dataBarang.php';
            </script>
        ";
    }else {
        echo mysqli_error($connectDB);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="namaBarang" value="<?= $data['namaBarang'] ?>">
        <button type="submit" name="editNamaBarang">Edit Nama Barang</button>
    </form>
</body>
</html>