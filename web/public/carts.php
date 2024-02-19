<?php
require '../../src/config/dbConfig.php';

if (isset($_POST['pesan'])) {
    // Ambil nilai dari form
    $foto = $_POST['foto'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $qty = $_POST['qty'];
    $total = $harga * $qty;

    // Periksa apakah qty valid
    if ($qty <= 0) {
        echo "<script> alert('Pembelian tidak boleh kurang dari 1');
        document.location.href = 'index.php';
        </script>";

        return false;
    }

    // Periksa stok barang di database
    $query = "SELECT stok FROM produk WHERE nama = '$nama'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Periksa apakah stok mencukupi
    if ($row && $row['stok'] >= $qty) {
        // Kurangi stok barang di database
        $new_stock = $row['stok'] - $qty;
        $update_query = "UPDATE produk SET stok = $new_stock WHERE nama = '$nama'";
        mysqli_query($conn, $update_query);

        // Tambahkan barang ke keranjang
        $tambah = mysqli_query($conn, "INSERT INTO keranjang (foto, nama, harga, qty, total) VALUES ('$foto', '$nama', '$harga', '$qty', '$total')");

        if (mysqli_affected_rows($conn)) {
            echo "<script>
            document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script> alert('Produk gagal dimasukkan ke keranjang');
            document.location.href = 'index.php';
            </script>";
        }
    } else {
        echo "<script> alert('Stok tidak mencukupi');
        document.location.href = 'index.php';
        </script>";
    }
}
?>

<?php
if (isset($_POST['cek'])) {
    // Ambil nilai dari form
    $kasir = $_POST['kasir'];
    $harga_total = $_POST['harga_total'];
    $metode = $_POST['metode'];

    // Tambahkan barang ke keranjang
    $tambah_transaksi = mysqli_query($conn, "INSERT INTO transaksi (kasir, harga_total, metode) VALUES ('$kasir', '$harga_total', '$metode')");

    // Periksa apakah transaksi berhasil disimpan
    if (mysqli_affected_rows($conn)) {
        // Ambil detail produk dari tabel keranjang
        $query_produk = "SELECT * FROM keranjang";
        $result_produk = mysqli_query($conn, $query_produk);

        // Periksa apakah ada produk dalam keranjang
        if (mysqli_num_rows($result_produk) > 0) {
            // Simpan detail setiap produk ke dalam tabel transaksi
            while ($row_produk = mysqli_fetch_assoc($result_produk)) {
                $nama_produk = $row_produk['nama'];
                $harga_produk = $row_produk['harga'];
                $qty_produk = $row_produk['qty'];

                $tambah_detail_transaksi = mysqli_query($conn, "INSERT INTO detail_transaksi (nama_produk, harga_produk, qty) VALUES ('$nama_produk', '$harga_produk', '$qty_produk')");

                if (!$tambah_detail_transaksi) {
                    echo "<script> alert('Gagal menyimpan detail produk'); </script>";
                    echo "<script> document.location.href = 'index.php'; </script>";
                    exit;
                }
            }
        }

        // Hapus data dari tabel keranjang setelah transaksi berhasil disimpan
        $hapus_keranjang = mysqli_query($conn, "DELETE FROM keranjang");

        if ($hapus_keranjang) {
            echo "<script> document.location.href = 'inv.php'; </script>";
        } else {
            echo "<script> alert('Gagal menghapus data keranjang'); </script>";
            echo "<script> document.location.href = 'index.php'; </script>";
        }
    } else {
        echo "<script> alert('Gagal menyimpan transaksi'); </script>";
        echo "<script> document.location.href = 'index.php'; </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <link rel="stylesheet" href="../../src/css/manip.css">
</head>

<body>
    <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button" class="close relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                            <span class="absolute -inset-0.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                                            <?php
                                            $no = 1;
                                            $ambil2 = mysqli_query($conn, "SELECT * FROM keranjang");

                                            foreach ($ambil2 as $data) : @$harga_total += $data['total'];

                                            ?>
                                                <li class="flex py-6">
                                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                        <img src="../../src/uploads/<?= $data['foto'] ?>">
                                                    </div>

                                                    <div class="ml-4 flex flex-1 flex-col">
                                                        <div>
                                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                                <h3>
                                                                    <?= $data['nama'] ?>
                                                                </h3>
                                                                <p class="ml-4">Rp. <?= number_format($data['harga'])  ?></p>
                                                            </div>
                                                            <!-- <p class="mt-1 text-sm text-gray-500">Salmon</p> -->
                                                        </div>
                                                        <div class="flex flex-1 items-end justify-between text-sm">
                                                            <p class="text-gray-500">Qty <?= $data['qty'] ?></p>

                                                            <div class="flex">
                                                                <a href="hapus_pesanan.php?id=<?= $data['id_keranjang'] ?>" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                            <!-- More products... -->
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                <form action="" method="post">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p>Rp. <?= number_format(@$harga_total)  ?></p>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">Tekan checkout untuk melanjutkan pembayaran.</p>
                                    <div class="font-bold mb-6 flex justify-center items-start text-center text-md text-gray-500">
                                        <div class="w-full h-full flex justify-between">
                                            <div class="mt-2 w-1/2">
                                                <label for="kasir">kasir:</label>
                                                <input type="text" name="kasir" id="kasir">
                                                <input type="hidden" name="harga_total" value="<?= @$harga_total ?>">
                                            </div>
                                            <div class="mt-2 w-1/2">
                                                <select name="metode" id="">
                                                    <option value="Tunai">Tunai</option>
                                                    <option value="Dana">Dana</option>
                                                    <option value="Ovo">Ovo</option>
                                                    <option value="ShopeePay">ShopeePay</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <button type="submit" name="cek" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="../../src/js/script.js">
    </script>
</body>

</html>