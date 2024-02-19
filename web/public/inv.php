<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>

<body>
    <?php
    // Menghubungkan ke database
    require '../../src/config/dbConfig.php';

    // Mendapatkan nomor struk dengan angka terbesar
    $query_max_struk = "SELECT MAX(CAST(no_struck AS UNSIGNED)) AS max_struk FROM transaksi";
    $result_max_struk = mysqli_query($conn, $query_max_struk);
    $data_max_struk = mysqli_fetch_assoc($result_max_struk);
    $max_struk = $data_max_struk['max_struk'];

    // Mendapatkan data transaksi berdasarkan nomor struk terbesar
    $query_transaksi = "SELECT * FROM transaksi WHERE no_struck = '$max_struk'";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $data_transaksi = mysqli_fetch_assoc($result_transaksi);

    ?>
    <div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto mt-8">
        <h1 class="font-bold text-2xl my-4 text-center text-blue-600">A|T Mart</h1>
        <hr class="mb-2">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Invoice</h1>
            <div class="text-gray-700">
                <div>Date: <?php echo date("d/m/Y", strtotime($data_transaksi['tanggal_transaksi'])); ?></div>
                <div>Invoice #: <?php echo $data_transaksi['no_struck']; ?></div>
            </div>
        </div>
        <div class="mb-8">
            <h2 class="text-lg font-bold mb-4">Kasir:</h2>
            <div class="text-gray-700 mb-2"><?php echo $data_transaksi['kasir']; ?></div>
            <!-- Menampilkan data lainnya seperti alamat dan email jika diperlukan -->
        </div>
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="text-left font-bold text-gray-700">Produk</th>
                    <th class="text-right font-bold text-gray-700">Harga</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $ambil = mysqli_query($conn, "SELECT * FROM detail_transaksi");

                foreach ($ambil as $data) :
                ?>

                    <tr>
                        <td class="text-left text-gray-700"><?= $data["nama_produk"] ?></td>
                        <td class="text-right text-gray-700"><?= number_format($data["harga_produk"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-left font-bold text-gray-700">Total</td>
                    <td class="text-right font-bold text-gray-700">Rp. <?php echo number_format($data_transaksi['harga_total'], 2); ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="text-gray-700 mb-2">Terimakasih sudah berbelanja ditoko kami!</div>
        <div class="text-gray-700 text-sm">Semoga puas dengan pelayanan kami</div>
    </div>
    <div>
        <div class="w-full flex justify-evenly h-20 items-center">
            <form action="hapus.php" method="post">
            <button type="submit" name="kembali" class="bg-gray-400 text-white h-10 w-24 rounded-lg hover:bg-gray-500">Selesai</button>
            </form>
            <button onclick="window.print()" class="bg-blue-500 text-white h-10 w-24 rounded-lg hover:bg-blue-600">Print</button>
            

        </div>
    </div>
</body>

</html>
<?php
// Menutup koneksi database
mysqli_close($conn);
?>