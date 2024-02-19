<?php
// Memanggil file koneksi.php untuk membuat koneksi
require '../../src/config/dbConfig.php';

// Inisialisasi variabel untuk menyimpan nilai dari formulir
$id_produk = $nama = $harga = $stok = "";

// Mengelola pengiriman formulir untuk memperbarui data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memastikan data formulir tersedia dan tidak kosong
    if (isset($_POST['ubah']) && !empty($_POST['id_produk']) && !empty($_POST['nama']) && !empty($_POST['harga']) && !empty($_POST['stok'])) {
        // Mengambil nilai dari formulir
        $id_produk = $_POST['id_produk'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        // Memperbarui data produk dalam database
        $stmt = $conn->prepare("UPDATE produk SET nama = ?, harga = ?, stok = ? WHERE id_produk = ?");
        $stmt->bind_param("sdsi", $nama, $harga, $stok, $id_produk); // Mengikat parameter ke statement

        if ($stmt->execute()) {
            echo "<p class='success-message'>Data berhasil diperbarui</p>";
            header("location: produk.php"); // Redirect ke halaman produk setelah berhasil memperbarui
            exit(); // Keluar dari skrip setelah redirect
        } else {
            echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close(); // Tutup statement
    } else {
        echo "<p class='error-message'>Formulir tidak lengkap</p>";
    }
}

// Memeriksa apakah ada nilai GET id_produk dan mengekstrak informasi produk
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET["id_produk"];

    // Mengambil data produk berdasarkan id_produk
    $query = "SELECT * FROM produk WHERE id_produk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $harga = $row['harga'];
        $stok = $row['stok'];
    } else {
        echo "<p class='error-message'>Data tidak ditemukan dalam database</p>";
        exit(); // Setelah memberikan peringatan, keluar dari skrip untuk menghentikan eksekusi selanjutnya
    }
    $stmt->close();
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <link rel="stylesheet" href="../../src/css/manip.css">
</head>

<body>
    <div class="min-h-fit bg-opacity-0 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto ">
            <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <div class="max-w-md mx-auto">
                    <div class="flex items-center space-x-5">
                        <div
                            class="h-14 w-14 bg-lime-500 rounded-full flex flex-shrink-0 justify-center items-center text-lime-800 text-2xl font-mono">
                            +</div>
                        <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                            <h2 class="leading-relaxed">Ubah Produk</h2>
                            <p class="text-sm text-gray-500 font-normal leading-relaxed">Masukkan detail produk yang
                                ingin dijual</p>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Nama Produk</label>
                                    <input type="text" name="nama"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Masukkan Nama Produk" value="<?= $nama; ?>">
                                </div>
                                <div class="flex flex-col">
                                    <label class="leading-loose">Harga</label>
                                    <input type="number" name="harga"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Masukkan Harga Jual" value="<?= $harga; ?>">
                                </div>
                                <div class="flex flex-col">
                                    <label class="leading-loose">Stok</label>
                                    <input type="number" name="stok"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Masukkan Stok Yang Tersedia" value="<?= $stok; ?>">
                                </div>
                                <div class="pt-4 flex items-center space-x-4">
                                    <button
                                        class="cancel flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg> Batal
                                    </button>
                                    <button type="submit" name="ubah"
                                        class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Simpan</button>
                                </div>
                            </form </div>

                        </div>
                    </div>
                </div>
            </div>
            <script></script>
</body>

</html>