<?php
require '../../src/config/dbConfig.php';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Foto Produk
    $target_dir = "../../src/uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check !== false) {
        //echo "<p class='success-message'>File is an image - " . $check["mime"] . ".</p>";
        $uploadOk = 1;
    } else {
        echo "<script>alert('File is not an image.')
        document.location.href = 'produk.php';
        </script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["foto"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.');
        document.location.href = 'produk.php';
        </script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
        document.location.href = 'produk.php';
        </script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');
        document.location.href = 'produk.php';
        </script>";

    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "<script>
            document.location.href = 'produk.php';
            </script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');
            document.location.href = 'produk.php';
            </script>";
        }

        $stmt = $conn->prepare("INSERT INTO produk (foto, nama, harga, stok) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $target_file, $nama, $harga, $stok);
        if ($stmt->execute()) {
            //echo "<p class='success-message'>Data berhasil disimpan</p>";
            //echo '<br><a href="form.php">Kembali ke Form</a>';
        } else {
            //echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <link rel="stylesheet" href="../../src/css/manip.css">
</head>

<body>

    <div class="min-h-fit bg-opacity-0 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto ">
            <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <div class="max-w-md mx-auto">
                    <div class="flex items-center space-x-5">
                        <div class="h-14 w-14 bg-lime-500 rounded-full flex flex-shrink-0 justify-center items-center text-lime-800 text-2xl font-mono">+</div>
                        <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                            <h2 class="leading-relaxed">Tambah Produk</h2>
                            <p class="text-sm text-gray-500 font-normal leading-relaxed">Masukkan detail produk yang ingin dijual</p>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Foto</label>
                                    <input type="file" name="foto" accept="/image*" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="leading-loose">Nama Produk</label>
                                    <input type="text" name="nama" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Masukkan Nama Produk">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Harga</label>
                                    <input type="number" name="harga" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Masukkan Harga Jual">
                                </div>

                                <div class="flex flex-col">
                                    <label class="leading-loose">Stok</label>
                                    <input type="Number" name="stok" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Masukkan Stok Yang Tersedia">
                                </div>
                        </div>
                        <div class="pt-4 flex items-center space-x-4">
                            <button class="cancel flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg> Batal
                            </button>
                            <button type="submit" name="tambah" class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Tambah</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script></script>
</body>

</html>