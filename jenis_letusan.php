<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Letusan - Nada Vulkanik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/jenis_letusan.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="display-4 fw-bold">JENIS-JENIS LETUSAN GUNUNG BERAPI</h1>
                    <p class="lead">Mengenal Karakteristik Berbagai Tipe Erupsi Vulkanik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Hawaiian -->
                <div class="col-lg-6 mb-4">
                    <div class="eruption-card card h-100">
                        <div class="card-header text-center">
                            <i class="fas fa-fire me-2"></i>Letusan Hawaiian
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-orange">Karakteristik:</h5>
                            <ul>
                                <li>Lava cair dan encer</li>
                                <li>Aliran lava yang tenang</li>
                                <li>Minimal ledakan</li>
                                <li>Fountain lava</li>
                            </ul>
                            <h5 class="card-title text-orange">Contoh:</h5>
                            <p>Gunung Kilauea (Hawaii), Mauna Loa</p>
                        </div>
                    </div>
                </div>

                <!-- Strombolian -->
                <div class="col-lg-6 mb-4">
                    <div class="eruption-card card h-100">
                        <div class="card-header text-center">
                            <i class="fas fa-bomb me-2"></i>Letusan Strombolian
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-orange">Karakteristik:</h5>
                            <ul>
                                <li>Ledakan sedang secara berkala</li>
                                <li>Lava kental</li>
                                <li>Bom vulkanik dan lapili</li>
                                <li>Suara gemuruh</li>
                            </ul>
                            <h5 class="card-title text-orange">Contoh:</h5>
                            <p>Gunung Stromboli (Italia), Erebus (Antartika)</p>
                        </div>
                    </div>
                </div>

                <!-- Vulcanian -->
                <div class="col-lg-6 mb-4">
                    <div class="eruption-card card h-100">
                        <div class="card-header text-center">
                            <i class="fas fa-explosion me-2"></i>Letusan Vulcanian
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-orange">Karakteristik:</h5>
                            <ul>
                                <li>Ledakan keras dan singkat</li>
                                <li>Awan abu tebal</li>
                                <li>Bom vulkanik besar</li>
                                <li>Kolom erupsi tinggi</li>
                            </ul>
                            <h5 class="card-title text-orange">Contoh:</h5>
                            <p>Gunung Vulcano (Italia), Sakurajima (Jepang)</p>
                        </div>
                    </div>
                </div>

                <!-- Plinian -->
                <div class="col-lg-6 mb-4">
                    <div class="eruption-card card h-100">
                        <div class="card-header text-center">
                            <i class="fas fa-cloud-meatball me-2"></i>Letusan Plinian
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-orange">Karakteristik:</h5>
                            <ul>
                                <li>Ledakan sangat hebat</li>
                                <li>Kolom erupsi sangat tinggi</li>
                                <li>Abu vulkanik meluas</li>
                                <li>Kaldera terbentuk</li>
                            </ul>
                            <h5 class="card-title text-orange">Contoh:</h5>
                            <p>Gunung Vesuvius (79 M), Pinatubo (1991)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Perbandingan -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-orange text-white">
                            <h4 class="mb-0"><i class="fas fa-table me-2"></i>Tabel Perbandingan Jenis Letusan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Jenis Letusan</th>
                                            <th>Kekuatan</th>
                                            <th>Material</th>
                                            <th>Frekuensi</th>
                                            <th>Tingkat Bahaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Hawaiian</strong></td>
                                            <td>Rendah</td>
                                            <td>Lava cair</td>
                                            <td>Terus menerus</td>
                                            <td><span class="badge bg-success">Rendah</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Strombolian</strong></td>
                                            <td>Sedang</td>
                                            <td>Lava, bom</td>
                                            <td>Periodik</td>
                                            <td><span class="badge bg-warning">Sedang</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Vulcanian</strong></td>
                                            <td>Tinggi</td>
                                            <td>Abu, bom</td>
                                            <td>Spasial</td>
                                            <td><span class="badge bg-danger">Tinggi</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Plinian</strong></td>
                                            <td>Sangat Tinggi</td>
                                            <td>Abu, pumis</td>
                                            <td>Jarang</td>
                                            <td><span class="badge bg-dark">Sangat Tinggi</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
