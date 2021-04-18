<?php
session_start();
require 'functions.php';

$userId = $_SESSION['idUser'];
$result = query("SELECT * FROM data WHERE id_user= '$userId' ORDER BY id DESC");
$emailTerpilih = mysqli_num_rows($result);

// cek telah login/belum
if ( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

if ( isset($_POST['edit']) ) {
    header("location: data.php");
}


if( isset($_POST['send']) ) {
    sendEmail($_POST);
}

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <title>Mailer Broadcaster</title>
  </head>
  <body>

    <div class="card-header">
        <div  class="text-center" > <h1>Aplikasi Broadcast Emailer</h1> </div>
        <div  class="position-absolute top-0 end-0 fw-bold mt-2 me-3"> <a href="logout.php">Logout</a> </div>
            <!-- <button class="position-absolute top-0 end-0" type="submit" name="logout"> <img src="img/logout.png" alt="logout" width="30" height="30"> </button> -->
            
    </div>
    <!-- <div class="position-absolute top-5"> <a href="logout.php" >Logout</a> </div> -->

    <br><br>
    <div class="col-lg-5 container" >
        <form action="" method="post">

            <div class="form-group ">
                <label class="fw-bold">Tujuan : </label>
                <div class="fst-italic"> Terdapat <?=$emailTerpilih?> email dipilih </div>
                <button type="submit" class="btn btn-primary" name="edit">Edit</button>
            </div>
            <div class="form-group mt-3">
                <label class="fw-bold">Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="subject">
            </div>
            <div class="form-group mt-3">
                <label class="fw-bold">Pesan</label>
                <textarea name="pesan" class="form-control" rows="5" placeholder="Pesan"></textarea>
            </div>
            <div class="form-group mt-3">
                <input type="file" name="file">  </input>
            </div>
            <div class="form-group mt-3">
                <button name="send" class="btn btn-primary" type="submit" >Send</button>
            </div>

        </form>
    </div>
  </body>
</html>
