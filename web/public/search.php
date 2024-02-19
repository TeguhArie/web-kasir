<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir | Search</title>
    <link rel="stylesheet" href="../../src/css/output.css">
</head>

<body>
    <?php include './navbar.php'; ?>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:max-w-full lg:px-8">
            <div class="flex justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Hasil Pencarian</h2>
                <div class="mb-3">
                    <div class="flex gap-4">
                        <a href="index.php" class="w-64 h-8 bg-gray-300 rounded-lg">
                            <span class="flex justify-center items-center text-black mt-1 font-semibold">Back to Home</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php
                // Menghubungkan ke database
                require '../../src/config/dbConfig.php';

                // Mendefinisikan kata kunci pencarian
                $keyword = $_GET['keyword'];

                // Membuat query pencarian
                $query = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";

                // Menjalankan query
                $result = mysqli_query($conn, $query);

                // Mengecek apakah query berhasil dijalankan
                if (!$result) {
                    die("Query error: " . mysqli_error($conn));
                }

                // Mengecek apakah ada hasil dari pencarian
                if (mysqli_num_rows($result) > 0) {
                    // Output data dari setiap baris hasil pencarian
                    while ($data = mysqli_fetch_assoc($result)) {
                ?>



                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="../../src/uploads/<?= $data['foto'] ?>" alt="Title" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700"><?= $data['nama'] ?></h3>
                                    <p class="mt-1 text-sm text-gray-500">Stok: <?= $data['stok'] ?></p>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <p class="text-sm text-right font-medium text-gray-900">Rp. <?= number_format($data['harga']) ?></p>

                                    <form action="carts.php" method="post">
                                        <input type="hidden" value="<?= $data['nama'] ?>" name="nama">
                                        <input class="" type="hidden" value="<?= $data['harga'] ?>" name="harga">
                                        <input type="hidden" value="<?= $data['foto'] ?>" name="foto">
                                        <input class="w-75" type="hidden" value="1" name="qty">
                                        <button type="submit" name="pesan" class="w-40 h-8 bg-gray-300 rounded-md">
                                            <span class="flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                                </svg> Cart
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "Data tidak ditemukan";
                }

                // Menutup koneksi database
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</body>

</html>