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
                alert('Data Barang Berhasil di Ubah');
                document.location = 'data-barang.php';
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
    <?php include "headtags.php" ?>
    <title>Edit Data Barang</title>
</head>
<body>

    <div class="row">
        <?php include "sidebar.php" ?>
        <div class="col-md-10">
            <h1 class="mt-4 display-4 text-center">Edit Data Barang</h1>
            <hr>
            <div class="card col-md-6 offset-md-3">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="namaBarang">Nama Barang :</label>
                            <input type="text" id="namaBarang" name="namaBarang" class="form-control" value="<?= $data['namaBarang'] ?>">
                        </div>
                        <button type="submit" name="editNamaBarang" class="btn btn-primary">Edit Nama Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>