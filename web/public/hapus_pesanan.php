<?php

require '../../src/config/dbConfig.php';

$id = $_GET['id'];

// Ambil informasi produk yang dihapus dari database
$query_produk = "SELECT * FROM keranjang WHERE id_keranjang = '$id'";
$result_produk = mysqli_query($conn, $query_produk);
$row_produk = mysqli_fetch_assoc($result_produk);

if ($row_produk) {
    // Mengembalikan stok barang
    $nama_produk = $row_produk['nama'];
    $qty_produk = $row_produk['qty'];

    $query_update_stok = "UPDATE produk SET stok = stok + $qty_produk WHERE nama = '$nama_produk'";
    mysqli_query($conn, $query_update_stok);
}

// Hapus produk dari keranjang
$hapus = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id'");

if (mysqli_affected_rows($conn)) {
    echo "<script> ;
    document.location.href = 'index.php';
    </script>";
} else {
    echo "<script> alert('data gagal dihapus');
    document.location.href = 'carts.php';
    </script>";
}
