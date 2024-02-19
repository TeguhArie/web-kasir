<?php
include  '../../src/config/dbConfig.php';  //menghubungkan ke

// Mendapatkan nilai dari form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Mencegah SQL Injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Mengecek keberadaan username dan password di database
    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // Login berhasil
        session_start();
        $_SESSION['login_admin'] = $username;
        header("location: dashboard.php");
        exit();
    } else {
        // Login gagal
        echo "Username atau password salah.";
    }
}
?>