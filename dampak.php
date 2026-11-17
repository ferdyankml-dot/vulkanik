<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dampak Erupsi Gunung Berapi - Vulkanik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/dampak.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <section class="hero-section text-white">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">DAMPAK ERUPSI GUNUNG BERAPI</h1>
            <p class="lead">Pengaruh erupsi terhadap kesehatan, lingkungan, kehidupan sosial, dan ekonomi</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <p class="text-muted text-center mb-5">Dampak bergantung pada jenis bahaya, kondisi gunung api, dan wilayah yang terdampak.</p>
            <div class="row g-4">
                <div class="col-lg-6">
                    <article class="card impact-card impact-negative h-100">
                        <div class="card-header bg-danger">
                            <h2 class="h5 mb-0"><i class="fas fa-heart-pulse me-2"></i>Kesehatan</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h6">Dampak yang dapat terjadi</h3>
                            <ul>
                                <li>Abu vulkanik dapat memicu atau memperburuk infeksi saluran pernapasan akut (ISPA).</li>
                                <li>Partikel abu dapat menyebabkan iritasi mata.</li>
                            </ul>
                            <p class="mb-0">Gunakan masker dan kacamata pelindung ketika berada di area terdampak abu, serta ikuti arahan petugas.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="card impact-card impact-negative h-100">
                        <div class="card-header bg-danger">
                            <h2 class="h5 mb-0"><i class="fas fa-leaf me-2"></i>Lingkungan</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h6">Dampak negatif</h3>
                            <ul>
                                <li>Kualitas udara menurun akibat abu vulkanik.</li>
                                <li>Sumber air dapat tercemar material vulkanik.</li>
                                <li>Hutan dapat terbakar dan habitat satwa terganggu.</li>
                                <li>Rantai makanan di lingkungan terdampak dapat terganggu.</li>
                            </ul>
                            <h3 class="h6 mt-4">Dampak positif</h3>
                            <p class="mb-0">Dalam jangka panjang, material vulkanik dapat menyuburkan tanah dan mendukung terbentuknya sumber mata air mineral.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="card impact-card impact-negative h-100">
                        <div class="card-header bg-danger">
                            <h2 class="h5 mb-0"><i class="fas fa-people-group me-2"></i>Sosial</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h6">Dampak negatif</h3>
                            <ul>
                                <li>Warga dapat kehilangan tempat tinggal.</li>
                                <li>Pengungsian besar-besaran dapat memisahkan warga dari rutinitas dan lingkungannya.</li>
                            </ul>
                            <h3 class="h6 mt-4">Dampak positif</h3>
                            <p class="mb-0">Situasi darurat dapat mendorong solidaritas masyarakat dan meningkatkan kesiapsiagaan kebencanaan.</p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="card impact-card impact-negative h-100">
                        <div class="card-header bg-danger">
                            <h2 class="h5 mb-0"><i class="fas fa-chart-line me-2"></i>Ekonomi</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h6">Dampak negatif</h3>
                            <ul>
                                <li>Lahan pertanian dapat rusak.</li>
                                <li>Masyarakat dapat kehilangan mata pencaharian.</li>
                                <li>Aktivitas perdagangan dapat terganggu.</li>
                            </ul>
                            <h3 class="h6 mt-4">Potensi pemulihan</h3>
                            <p class="mb-0">Material vulkanik dapat menjadi sumber pendapatan baru setelah kondisi aman dan pemanfaatannya dikelola dengan memperhatikan keselamatan.</p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="alert alert-warning mt-5 mb-0">
                <strong><i class="fas fa-triangle-exclamation me-2"></i>Keselamatan tetap utama.</strong>
                Manfaat material vulkanik tidak mengurangi risiko saat erupsi. Jangan memasuki zona berbahaya sebelum dinyatakan aman oleh pihak berwenang.
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
