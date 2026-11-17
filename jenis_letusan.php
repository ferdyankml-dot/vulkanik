<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk dan Bahaya Erupsi - Vulkanik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/jenis_letusan.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <section class="hero-section text-white">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">PRODUK DAN BAHAYA ERUPSI</h1>
            <p class="lead">Kenali material yang dikeluarkan gunung api dan bahaya yang dapat ditimbulkannya</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-cloud me-2"></i>Abu, tephra, dan lontaran pijar</div>
                        <div class="card-body">
                            <p>Erupsi dapat membentuk kolom abu dan melontarkan tephra, termasuk bom vulkanik dan material pijar.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Hujan abu lebat dapat mengganggu pernapasan dan aktivitas. Material yang terlontar dapat membahayakan wilayah di sekitar gunung api.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-fire me-2"></i>Awan panas piroklastik</div>
                        <div class="card-body">
                            <p>Campuran gas dan material vulkanik panas yang dapat mengalir cepat menuruni lereng.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Suhu tinggi dan alirannya sangat berbahaya. Jauhi zona yang ditetapkan berbahaya dan patuhi perintah evakuasi.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-water me-2"></i>Aliran lava</div>
                        <div class="card-body">
                            <p>Lava adalah magma yang sudah mencapai permukaan dan dapat mengalir keluar dari kawah.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Lava dapat membakar atau merusak area yang dilaluinya. Arah dan jangkauan bahayanya mengikuti kondisi gunung api.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-cloud-bolt me-2"></i>Gas vulkanik</div>
                        <div class="card-body">
                            <p>Gas vulkanik dapat keluar saat erupsi maupun melalui lubang keluarnya gas seperti fumarol.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Gas tertentu dapat beracun atau mengganggu kesehatan. Hindari kawah dan area yang dibatasi petugas.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-house-flood-water me-2"></i>Lahar dan banjir lahar</div>
                        <div class="card-body">
                            <p>Material vulkanik yang bercampur air dapat membentuk lahar dan mengalir mengikuti alur sungai.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Aliran lahar dapat mengancam warga dan bangunan di lembah sungai. Waspada terutama saat hujan deras dan jauhi aliran sungai.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="eruption-card card h-100">
                        <div class="card-header text-center"><i class="fas fa-mountain-sun me-2"></i>Longsoran dan tsunami</div>
                        <div class="card-body">
                            <p>Erupsi dapat disertai longsoran bahan rombakan di lereng. Tsunami juga termasuk potensi bahaya pada kondisi tertentu.</p>
                            <h2 class="h5 text-orange">Potensi bahaya</h2>
                            <p class="mb-0">Dampaknya bergantung pada kondisi gunung dan wilayah sekitar. Ikuti peringatan dan arahan resmi, termasuk evakuasi bila diperintahkan.</p>
                        </div>
                    </article>
                </div>
            </div>

            <div class="alert alert-warning mt-5 mb-0" role="note">
                <strong><i class="fas fa-circle-info me-2"></i>Catatan:</strong>
                halaman ini membahas produk dan bahaya erupsi yang dijelaskan dalam materi presentasi, bukan klasifikasi gaya letusan gunung api.
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
