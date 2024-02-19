<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Produk</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <link rel="stylesheet" href="../../src/css/manip.css">
</head>

<body class="h-fit w-full">
    <div>
    <?php require '../../src/config/dbConfig.php' ?>
    <?php include './navbar.php'; ?>
    <div class="w-full flex justify-center">
        <!-- component -->
        <div class="flex flex-wrap -mx-3 mb-5 w-full">
            <div class="w-full max-w-full px-3 mb-6  mx-auto">
                <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
                    <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
                        <!-- card header -->
                        <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                            <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
                                <span class="mr-3 font-semibold text-dark">Pengelolaan Produk</span>
                                <span class="mt-1 font-medium text-secondary-dark text-lg/normal">Kelola produk toko anda disini</span>
                            </h3>
                            <div class="relative flex flex-wrap items-center my-2">
                                <button id="add" class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-lg py-2 px-3 bg-indigo-500 text-white" type="button">Add Product</button>
                            </div>
                        </div>
                        <!-- end card header -->
                        <!-- card body  -->
                        <div class="flex-auto block py-8 pt-6 px-9">
                            <div class="overflow-x-auto">
                                <table class="w-full my-0 align-middle text-dark border-neutral-200">
                                    <thead class="align-bottom">
                                        <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                            <th class="pb-3 text-start min-w-[175px]">NAMA</th>
                                            <th class="pb-3 text-end min-w-[100px]">HARGA</th>
                                            <th class="pb-3 text-end min-w-[100px]">STOK</th>
                                            <th class="pb-3 pr-12 text-end min-w-[175px]">UPDATE</th>
                                            <th class="pb-3 pr-12 text-end min-w-[100px]">DELETE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ambil = mysqli_query($conn, "SELECT * FROM produk");

                                    foreach ($ambil as $data) :

                                    ?>
                                        <tr class="border-b border-dashed last:border-b-0">
                                            <td class="p-3 pl-0">
                                                <div class="flex items-center">
                                                    <div class="relative inline-block shrink-0 rounded-2xl me-3">
                                                        <img src="../../src/uploads/<?= $data['foto'] ?>" class="w-[50px] h-[50px] inline-block shrink-0 rounded-2xl" alt="title">
                                                    </div>
                                                    <div class="flex flex-col justify-start">
                                                        <a href="javascript:void(0)" class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary"><?= $data['nama'] ?></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 pr-0 text-end">
                                                <span class="font-semibold text-light-inverse text-md/normal">Rp. <?= number_format($data['harga'])  ?></span>
                                            </td>
                                            <td class="p-3 pr-0 text-end">
                                                <span class="text-center align-baseline inline-flex px-2 py-1 mr-auto items-center font-semibold text-base/none text-success bg-success-light rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-5 h-5 mr-1" viewBox="0 0 16 16">
                                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                                                    </svg> <?= $data['stok'] ?> </span>
                                            </td>
                                            <td class="p-3 pr-12 text-end">
                                                <a href="update.php?action=update&id_produk=<?= $data['id_produk'] ?>&nama=<?= $data['nama'] ?>&harga=<?= $data['harga'] ?>&stok=<?= $data['stok'] ?>" class="text-blue-600 hover:text-lime-500 underline pl-6">UPDATE</a>
                                            </td>
                                            <td class="pr-0 text-center">
                                                <a onclick="return confirm('Anda yakin ingin menghapus produk ?')" href="hapus.php?id=<?= $data['id_produk'] ?>" class="text-red-600 hover:text-yellow-400 underline pl-2">DELETE</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-form absolute bg-opacity-0">
            <?php include "tambah.php"; ?>
        </div>
    </div>
    </div>
    <?php include './footer.php'; ?>
    <script>
        const add = document.getElementById('add');
const form = document.querySelector('.add-form')
console.log(form);
const cancel = document.querySelector('.cancel')
console.log(cancel);

add.addEventListener('click', () => {
    form.classList.toggle('show')
})
cancel.addEventListener('click', () => {
    form.classList.toggle('show')
})
    </script>
</body>

</html>