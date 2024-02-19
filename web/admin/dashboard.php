    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Dashboard</title>
        <link rel="stylesheet" href="../../src/css/output.css">
    </head>

    <body>
        <?php include  './navbar.php'; ?>
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Selamat Datang Admin</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl flex gap-10 px-4 py-6 sm:px-6 h-auto lg:px-20">
                <div class="bg-white rounded-lg p-8 shadow-md w-64 flex flex-col items-center justify-center">
                    <h2 class="text-right font-semibold text-xl">Laporan Penjualan</h2>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z" />
                    </svg>
                    <a href="laporan.php" class="text-gray-700 mt-auto">Lihat Detail</a>
                </div>
                <div class="bg-white rounded-lg p-8 shadow-md w-64 flex flex-col items-center justify-center">
                    <h2 class="text-right font-semibold text-xl">Pengelola Produk</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" class="bi bi-box-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.004-.001.274-.11a.75.75 0 0 1 .558 0l.274.11.004.001zm-1.374.527L8 5.962 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339Z" />
                    </svg>
                    <a href="produk.php" class="text-gray-700 mt-auto">Lihat Detail</a>
                </div>
            </div>
        </main>
        <?php include './footer.php'; ?>
    </body>

    </html>