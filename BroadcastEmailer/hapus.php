<?php

session_start();

// cek telah login/belum
if ( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

include 'functions.php';

$id = $_GET["id"];

if( hapus($id) > 0 ){
    echo " 
        <script> 
            alert('Data berhasil dihapus');
            document.location.href = 'index.php';
        </script> 
    ";
}else {
    echo " 
        <script> 
            alert('Gagal');
            document.location.href = 'index.php';
        </script> 
    ";
}

?>