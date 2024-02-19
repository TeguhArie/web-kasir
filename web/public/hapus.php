<?php
if(isset($_POST['kembali'])) {

    require '../../src/config/dbConfig.php';

    $sql = "DELETE FROM detail_transaksi";

    if ($conn->query($sql) === TRUE) {
        echo "<script> ;
    document.location.href = 'index.php';
    </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>