<?php

require '../../src/config/dbConfig.php';

$id = $_GET['id'];

$hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id'");

if(mysqli_affected_rows($conn)){
    echo "<script> ;
    document.location.href = 'produk.php';
    </script>";
} else{
    echo "<script> alert('data gagal dihapus');
    document.location.href = 'produk.php';
    </script>";
}