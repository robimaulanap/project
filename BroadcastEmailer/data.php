<?php

require 'functions.php';
session_start();

if ( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

$userId = $_SESSION['idUser'];
$dataEmail = query("SELECT * FROM data WHERE id_user= '$userId' ORDER BY id DESC");

if ( isset($_POST['home']) ) {
    header("location: index.php");
}


if ( isset( $_POST["add"]) ) {
    array_push($_POST, $userId);
    if (tambah($_POST) > 0 ) {
        echo " 
            <script>
                alert('data berhasil ditambahkan');
                document.location.href = 'data.php';
            </script>
        ";
    }else {
        echo " 
            <script>
                alert('gagal');
                document.location.href = 'data.php';
            </script>
        ";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>

    <div class="col-lg-5 container mt-2">

    <form action="" method="post">
    <button type="submit" name="home" class="mb-2">Back</button>
    <table class="table table-bordered" >
        <tr class="table-light">
            <th>Act.</th>
            <th>No.</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        <tr>
            <td> <button type="submit" name="add" >Add</button> </td>
            <td><input type="text" name="nama" placeholder="add Name..."></td>
            <td><input type="text" name="email" placeholder="add Email..."></td>
        </tr>
        <?php $i = 1; ?>
        <?php foreach( $dataEmail as $row ) : ?>
            <tr>
                <td>
                    <a href="hapus.php? id=<?= $row["id"]; ?>" onclick=" return confirm('Yakin'); "> Dell </a>
                </td>
                <td><?= $i ?></td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["email"] ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </form>

    </div>
    
</body>
</html>