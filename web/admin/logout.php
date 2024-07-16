<?php
include '../../src/config/dbConfig.php';
// Mulai session
session_start();

// Hapus semua data session

session_destroy();
// Redirect ke halaman login atau halaman lain yang diinginkan setelah logout
header("Location: login.php");
exit;
?>  