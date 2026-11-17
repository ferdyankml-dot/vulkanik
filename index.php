<?php
require 'config.php';

// Data informatif orang hilang
$default_orang_hilang = [
    [
        'nama' => 'Ismail bin Ahmad',
        'umur' => 25,
        'alamat' => 'Jl. Kaliurang Km 19, Pakem, Sleman, Yogyakarta',
        'ciri_fisik' => 'Tinggi 170 cm, jaket parasut merah marun, celana kargo abu-abu, tahi lalat di pipi kiri',
        'tanggal_hilang' => '2024-01-15',
        'lokasi_hilang' => 'Lereng Sektor Selatan Gunung Merapi (Radius 4 km)',
        'foto' => null,
        'status' => 'hilang'
    ],
    [
        'nama' => 'Siti Rahayu',
        'umur' => 32,
        'alamat' => 'Ds. Sumber Klopo, Candipuro, Lumajang, Jawa Timur',
        'ciri_fisik' => 'Berkacamata bingkai hitam, kulit sawo matang, ransel gunung navy, tinggi 158 cm',
        'tanggal_hilang' => '2024-01-10',
        'lokasi_hilang' => 'Kawasan Aliran Besuk Kobokan, Lereng Gunung Semeru',
        'foto' => null,
        'status' => 'hilang'
    ],
    [
        'nama' => 'Budi Santoso',
        'umur' => 45,
        'alamat' => 'Dusun Kinahrejo, Cangkringan, Sleman',
        'ciri_fisik' => 'Postur tinggi tegap, rompi relawan hijau, topi rimba rimau, berkumis tipis',
        'tanggal_hilang' => '2024-01-08',
        'lokasi_hilang' => 'Pos Pengamatan Darurat Gunung Merapi',
        'foto' => null,
        'status' => 'ditemukan'
    ]
];

// Ambil daftar orang hilang dari DB
$orang_hilang_list = [];
if ($conn) {
    $q = $conn->query("SELECT * FROM orang_hilang ORDER BY (status = 'hilang') DESC, tanggal_hilang DESC LIMIT 6");
    if ($q && $q->num_rows > 0) {
        while ($row = $q->fetch_assoc()) {
            $orang_hilang_list[] = $row;
        }
    }
}
if (empty($orang_hilang_list)) {
    $orang_hilang_list = $default_orang_hilang;
}

// Pencarian orang hilang
$search_term = '';
$search_results_list = null;
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search_term = sanitize($_GET['search']);
    $search_results_list = [];

    if ($conn) {
        $search_query = "
            SELECT * FROM orang_hilang 
            WHERE nama LIKE '%$search_term%' 
               OR alamat LIKE '%$search_term%' 
               OR ciri_fisik LIKE '%$search_term%'
               OR lokasi_hilang LIKE '%$search_term%'
            ORDER BY tanggal_hilang DESC
        ";
        $res = $conn->query($search_query);
        if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) {
                $search_results_list[] = $r;
            }
        }
    } else {
        foreach ($default_orang_hilang as $item) {
            if (stripos($item['nama'], $search_term) !== false || 
                stripos($item['ciri_fisik'], $search_term) !== false || 
                stripos($item['lokasi_hilang'], $search_term) !== false ||
                stripos($item['alamat'], $search_term) !== false) {
                $search_results_list[] = $item;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulkanik — Sistem Informasi Mitigasi & Kesiapsiagaan Gunung Berapi</title>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
    
    <!-- Custom Editorial CSS -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="site-wrapper">
                <div class="hero-title-wrap">
                    <h1 class="hero-main-title">Sistem Informasi Vulkanik.</h1>
                    <p class="hero-subtitle">
                        Sistem informasi terpadu pemantauan aktivitas gunung berapi, edukasi kesiapsiagaan mitigasi bencana, dan pusat koordinasi pencarian orang hilang di Indonesia.
                    </p>
                </div>
            </div>
        </section>

        <!-- Institutional Partners / Ticker Strip -->
        <section class="ticker-strip">
            <div class="site-wrapper">
                <div class="ticker-label">Rujukan Standar Data & Protokol Kebencanaan Nasional</div>
                <div class="ticker-grid">
                    <div class="ticker-item"><i class="fas fa-volcano"></i> PVMBG Geologi</div>
                    <div class="ticker-item"><i class="fas fa-cloud-sun"></i> BMKG Indonesia</div>
                    <div class="ticker-item"><i class="fas fa-shield-halved"></i> BNPB Indonesia</div>
                    <div class="ticker-item"><i class="fas fa-fire-flame-curved"></i> MAGMA Indonesia</div>
                    <div class="ticker-item"><i class="fas fa-mountain"></i> KESDM RI</div>
                    <div class="ticker-item"><i class="fas fa-life-ring"></i> BASARNAS</div>
                </div>
            </div>
        </section>

        <!-- Section: We've cracked the code -->
        <section class="section-spacer">
            <div class="site-wrapper">
                <div class="features-header">
                    <span class="eyebrow-tag">Sistem & Solusi Terpadu</span>
                    <h2>Web Kami</h2>
                    <p style="max-width: 620px;">
                        Menyatukan data pengamatan visual, geofisika gempa tremor, peringatan dini otomatis, panduan mitigasi lapangan, hingga basis data koordinasi evakuasi korban.
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-col">
                        <div class="feat-icon"><i class="fas fa-wave-square"></i></div>
                        <h4>Pemantauan Seismik & Tremor</h4>
                        <p>Menganalisis getaran tremor vulkanik dan gempa fase dalam/dangkal untuk mengukur migrasi fluida magma menuju permukaan kubah.</p>
                    </div>
                    <div class="feature-col">
                        <div class="feat-icon"><i class="fas fa-map-location-dot"></i></div>
                        <h4>Pemetaan Spasial KRB</h4>
                        <p>Pemetaan zona Kawasan Rawan Bencana (KRB I, II, dan III) serta delineasi radius larangan aktivitas warga secara presisi.</p>
                    </div>
                    <div class="feature-col">
                        <div class="feat-icon"><i class="fas fa-kit-medical"></i></div>
                        <h4>Protokol Mitigasi 3 Fase</h4>
                        <p>Panduan komprehensif fase pra-bencana (persiapan tas darurat 72 jam), fase saat letusan (perlindungan abu & evakuasi), dan pemulihan pasca-erupsi.</p>
                    </div>
                    <div class="feature-col">
                        <div class="feat-icon"><i class="fas fa-users-viewfinder"></i></div>
                        <h4>Pencarian Korban Terpadu</h4>
                        <p>Sistem basis data terverifikasi untuk mempublikasikan identitas orang hilang, ciri fisik, serta menyelaraskan komunikasi keluarga dan tim SAR.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Panoramic Banner: Pemantauan Gunung Semeru -->
        <section class="section-spacer">
            <div class="site-wrapper">
                <div class="testimonial-grid">
                    <div class="testimonial-image-card">
                        <img src="assets/img/gunung-semeru.jpg" alt="Balanced Stone Cairn">
                    </div>

                    <div class="testimonial-quote-box">
                        <blockquote>
                            Sistem informasi Vulkanik mentransformasi cara masyarakat dan relawan memahami risiko bahaya gunung berapi. Visualisasi spasial Kawasan Rawan Bencana dan pemantauan data begitu jernih, intuitif, dan responsif ketika detik-detik evakuasi sangat krusial
                        </blockquote>
                        <!-- <div class="quote-author">
                            <h5>Dr. Surono (Mbah Rono)</h5>
                            <p>Mantan Kepala Pusat Vulkanologi dan Mitigasi Bencana Geologi (PVMBG)</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>

        

        <section id="peta-sebaran" class="section-spacer">
            <div class="site-wrapper">
                <div class="map-card-wrapper">
                    <div class="map-card-header">
                        <div>
                            <span class="eyebrow-tag" style="margin-bottom: 8px;">Peta Geospasial Interaktif</span>
                            <h3>Persebaran Gunung Berapi Aktif di Indonesia</h3>
                            <p>Pantau titik koordinat, elevasi, tingkatan status aktivitas, serta catatan bahaya KRB pada peta interaktif.</p>
                        </div>
                        <div class="map-filters">
                            <button class="map-filter-btn active" type="button" data-map-filter="all" aria-pressed="true">Semua Gunung</button>
                            <button class="map-filter-btn" type="button" data-map-filter="awas" aria-pressed="false">Awas (Level IV)</button>
                            <button class="map-filter-btn" type="button" data-map-filter="siaga" aria-pressed="false">Siaga (Level III)</button>
                            <button class="map-filter-btn" type="button" data-map-filter="waspada" aria-pressed="false">Waspada (Level II)</button>
                        </div>
                    </div>
                    <div id="volcanoMap" class="volcano-map" role="region" aria-label="Peta interaktif gunung berapi di Indonesia">
                        <p class="map-status" id="mapStatus" role="status">Memuat peta gunung berapi...</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Why Choose Area? / Classification Table -->
        <section class="section-spacer comparison-section">
            <div class="site-wrapper">
                <div class="comparison-header">
                    <span class="eyebrow-tag">Standarisasi PVMBG</span>
                    <h2>Klasifikasi Status Gunung Api</h2>
                    <p>
                        Pedoman resmi klasifikasi tingkatan bahaya gunung api di Indonesia serta tindakan wajib yang harus dipatuhi masyarakat dan aparat kewilayahan.
                    </p>
                    <span class="btn-pill btn-pill-sage" style="cursor: default;">Pedoman Resmi Nasional</span>
                </div>

                <div class="table-card">
                    <div class="comparison-columns">
                        <!-- Column 1: Waspada -->
                        <div class="comp-col">
                            <span class="comp-badge waspada">Level II • Waspada</span>
                            <h3>Waspada</h3>
                            <div class="col-desc">Peningkatan aktivitas visual dan kegempaan di atas ambang batas normal.</div>
                            
                            <ul class="comp-list">
                                <li><i class="fas fa-check"></i> Asap kawah membubung putih tipis hingga sedang</li>
                                <li><i class="fas fa-check"></i> Mulai terekam gempa vulkanik dan tremor berkala</li>
                                <li><i class="fas fa-check"></i> Sosialisasi jalur evakuasi & pengecekan rambu KRB</li>
                                <li><i class="fas fa-check"></i> Rekomendasi radius steril: 2 – 3 km dari kawah</li>
                                <li><i class="fas fa-check"></i> Pendakian ke puncak ditutup bagi umum</li>
                            </ul>
                        </div>

                        <!-- Column 2: Siaga -->
                        <div class="comp-col">
                            <span class="comp-badge siaga">Level III • Siaga</span>
                            <h3>Siaga</h3>
                            <div class="col-desc">Peningkatan seismik intensif, letusan berpotensi besar terjadi dalam waktu dekat.</div>
                            
                            <ul class="comp-list">
                                <li><i class="fas fa-check"></i> Semburan abu vulkanik tampak jelas, kubah lava tumbuh cepat</li>
                                <li><i class="fas fa-check"></i> Gempa tremor harmonik dan vulkanik dangkal sangat aktif</li>
                                <li><i class="fas fa-check"></i> Warga menyiapkan Tas Siaga Bencana & gladi evakuasi</li>
                                <li><i class="fas fa-check"></i> Rekomendasi radius steril: 3 – 5 km dari kawah</li>
                                <li><i class="fas fa-check"></i> Armada evakuasi siaga 24 jam untuk kelompok rentan</li>
                            </ul>
                        </div>

                        <!-- Column 3: Awas -->
                        <div class="comp-col">
                            <span class="comp-badge awas">Level IV • Awas</span>
                            <h3>Awas</h3>
                            <div class="col-desc">Kondisi kritis, erupsi eksplosif utama sedang berlangsung atau segera terjadi.</div>
                            
                            <ul class="comp-list">
                                <li><i class="fas fa-check"></i> Letusan abu tinggi, luncuran awan panas & lontaran batu pijar</li>
                                <li><i class="fas fa-check"></i> Ancaman bahaya primer dan sekunder mengancam permukiman</li>
                                <li><i class="fas fa-check"></i> <strong>Evakuasi wajib total</strong> seluruh warga dalam zona KRB</li>
                                <li><i class="fas fa-check"></i> Rekomendasi radius steril: 5 – 10 km (sesuai bukaan kawah)</li>
                                <li><i class="fas fa-check"></i> Posko darurat & tempat pengungsian dibuka penuh</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: See the Big Picture (2-column split) -->
        <section class="section-spacer">
            <div class="site-wrapper">
                <div class="big-picture-grid">
                    <div class="big-picture-left">
                        <span class="eyebrow-tag">Pemahaman Komprehensif</span>
                        <h2>Tingkatan Status</h2>
                        <p>
                            Erupsi gunung berapi bukan hanya peristiwa letusan sesaat, melainkan rangkaian fenomena geologis yang membutuhkan pemahaman menyeluruh demi keselamatan warga.
                        </p>

                        <ul class="numbered-checklist">
                            <li class="checklist-item">
                                <div class="checklist-num">01</div>
                                <div class="checklist-text">
                                    <h5>Tingkatan Status Resmi PVMBG</h5>
                                    <p>Memahami transisi aktivitas: Level I (Normal), Level II (Waspada), Level III (Siaga), hingga Level IV (Awas) berdasarkan data instrumentasi.</p>
                                </div>
                            </li>
                            <li class="checklist-item">
                                <div class="checklist-num">02</div>
                                <div class="checklist-text">
                                    <h5>Bahaya Primer & Sekunder Erupsi</h5>
                                    <p>Mewaspadai bahaya primer (awan panas / <em>pyroclastic density current</em>, bom vulkanik, gas beracun $SO_2$) dan bahaya sekunder (lahar hujan lahar dingin).</p>
                                </div>
                            </li>
                            <li class="checklist-item">
                                <div class="checklist-num">03</div>
                                <div class="checklist-text">
                                    <h5>Standar Operasional Evakuasi</h5>
                                    <p>Penetapan titik kumpul aman, pengungsian kelompok rentan (lansia, anak-anak, ibu hamil), serta manajemen posko logistik darurat.</p>
                                </div>
                            </li>
                            <li class="checklist-item">
                                <div class="checklist-num">04</div>
                                <div class="checklist-text">
                                    <h5>Pelaporan & Rekonsiliasi Korban Hilang</h5>
                                    <p>Membantu pelacakan terpadu korban yang terpisah saat kepanikan evakuasi dengan verifikasi identitas real-time.</p>
                                </div>
                            </li>
                        </ul>

                        <a href="mitigasi.php" class="btn-pill btn-pill-sage">
                            <span>Pelajari Protokol Mitigasi Lengkap</span>
                            <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>

                    <!-- Right Column: Volcanic eruption image -->
                    <div class="big-picture-card">
                        <img src="assets/img/erupsi-gunung-api.webp" alt="Erupsi gunung api dengan kolom abu vulkanik">
                    </div>
                </div>
            </div>
        </section>


        <!-- Section: Map Your Success (3 Steps) -->
        <section class="section-spacer">
            <div class="site-wrapper">
                <div class="steps-top">
                    <div>
                        <h2>Kesiapsiagaan Mandiri Warga</h2>
                    </div>
                    <a href="mitigasi.php" class="btn-pill btn-pill-sage">
                        <span>SOP Panduan</span>
                        <!-- <i class="fas fa-download" style="font-size: 0.8rem;"></i> -->
                    </a>
                </div>

                <div class="steps-grid">
                    <div class="step-col">
                        <div class="step-num">01</div>
                        <h4>Kenali Sinyal & Gejala</h4>
                        <p>Perhatikan kenaikan suhu sumber air, gempa tremor yang terasa, bau belerang menyengat, serta perubahan perilaku satwa lereng yang turun gunung.</p>
                    </div>

                    <div class="step-col">
                        <div class="step-num">02</div>
                        <h4>Siapkan Tas Siaga 72 Jam</h4>
                        <p>Pastikan persediaan masker respirator N95, kacamata goggle, obat pribadi, senter, peluit darurat, air minum, dan dokumen berharga siap dibawa kapan saja.</p>
                    </div>

                    <div class="step-col">
                        <div class="step-num">03</div>
                        <h4>Evakuasi Tertib ke Posko</h4>
                        <p>Hindari lembah sungai rawan lahar, ikuti jalur evakuasi resmi, dan segera laporkan keberadaan anggota keluarga di meja pendaftaran posko perlindungan.</p>
                    </div>
                </div>
            </div>
        </section>



        <!-- Interactive Map Section: Persebaran Gunung Berapi Aktif -->
        

        <!-- Missing Persons Search Section (Pencarian Orang Hilang) -->
        <section id="pencarian" class="search-section">
            <div class="site-wrapper">
                <div class="search-header-box">
                    <span class="eyebrow-tag">Pusat Koordinasi Tanggap Darurat</span>
                    <h2>Pencarian Orang Hilang</h2>
                    <p>
                        Basis data pelaporan terverifikasi korban erupsi dan warga yang terpisah dari keluarga di kawasan lereng gunung berapi.
                    </p>
                </div>

                <!-- Search Form -->
                <div class="search-bar-wrap">
                    <form method="GET" action="#pencarian" class="search-bar-form">
                        <i class="fas fa-search" style="color: var(--text-muted); margin-right: 12px;"></i>
                        <input type="text" name="search" placeholder="Cari berdasarkan nama, ciri fisik, atau lokasi (contoh: Siti, kacamata, lereng semeru)..." value="<?php echo htmlspecialchars($search_term); ?>">
                        <button type="submit" class="btn-pill btn-pill-dark" style="padding: 9px 22px;">Cari Data</button>
                    </form>
                </div>

                <!-- Search Results If Triggered -->
                <?php if (isset($_GET['search']) && trim($_GET['search']) !== ''): ?>
                    <div style="margin-bottom: 40px;">
                        <h4 style="font-size: 1.25rem; margin-bottom: 20px;">
                            Hasil Pencarian untuk: "<em><?php echo htmlspecialchars($search_term); ?></em>"
                        </h4>
                        
                        <?php if (!empty($search_results_list)): ?>
                            <div class="person-grid">
                                <?php foreach ($search_results_list as $person): ?>
                                    <div class="person-card">
                                        <div class="person-photo-area">
                                            <?php if (!empty($person['foto']) && file_exists($person['foto'])): ?>
                                                <img src="<?php echo htmlspecialchars($person['foto']); ?>" alt="<?php echo htmlspecialchars($person['nama']); ?>">
                                            <?php else: ?>
                                                <div class="photo-placeholder">
                                                    <i class="fas fa-user-circle fa-4x"></i>
                                                    <span>Foto Dokumen Belum Diunggah</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="person-body">
                                            <h5><?php echo htmlspecialchars($person['nama']); ?></h5>
                                            <div class="person-meta">
                                                <strong>Usia:</strong> <?php echo $person['umur']; ?> tahun<br>
                                                <strong>Terakhir Dilihat:</strong> <?php echo htmlspecialchars($person['lokasi_hilang'] ?: '-'); ?><br>
                                                <strong>Tanggal:</strong> <?php echo $person['tanggal_hilang'] ? date('d M Y', strtotime($person['tanggal_hilang'])) : '-'; ?><br>
                                                <strong>Ciri Khusus:</strong> <?php echo htmlspecialchars($person['ciri_fisik'] ?: '-'); ?><br>
                                                <strong>Alamat:</strong> <?php echo htmlspecialchars($person['alamat'] ?: '-'); ?>
                                            </div>
                                            <div>
                                                <?php if ($person['status'] === 'hilang'): ?>
                                                    <span class="status-pill hilang"><i class="fas fa-clock"></i> Masih Dalam Pencarian</span>
                                                <?php else: ?>
                                                    <span class="status-pill ditemukan"><i class="fas fa-check-circle"></i> Telah Ditemukan Selamat</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div style="background: #ffffff; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 32px; text-align: center; color: var(--text-secondary);">
                                <i class="fas fa-info-circle fa-2x mb-2" style="color: var(--text-muted);"></i>
                                <p style="margin: 8px 0 0;">Tidak ditemukan data orang hilang dengan kata kunci "<?php echo htmlspecialchars($search_term); ?>".</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Latest Missing Persons -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px;">
                        <h3 style="font-size: 1.4rem; margin: 0;">Laporan Orang Hilang Terbaru</h3>
                        <span style="font-size: 0.88rem; color: var(--text-muted);">Terkoneksi Posko SAR & Tim Evakuasi</span>
                    </div>

                    <?php if (!empty($orang_hilang_list)): ?>
                        <div class="person-grid">
                            <?php foreach ($orang_hilang_list as $person): ?>
                                <div class="person-card">
                                    <div class="person-photo-area">
                                        <?php if (!empty($person['foto']) && file_exists($person['foto'])): ?>
                                            <img src="<?php echo htmlspecialchars($person['foto']); ?>" alt="<?php echo htmlspecialchars($person['nama']); ?>">
                                        <?php else: ?>
                                            <div class="photo-placeholder">
                                                <i class="fas fa-user-circle fa-4x"></i>
                                                <span>Foto Dokumen Belum Diunggah</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="person-body">
                                        <h5><?php echo htmlspecialchars($person['nama']); ?></h5>
                                        <div class="person-meta">
                                            <strong>Usia:</strong> <?php echo $person['umur']; ?> tahun<br>
                                            <strong>Terakhir Dilihat:</strong> <?php echo htmlspecialchars($person['lokasi_hilang'] ?: '-'); ?><br>
                                            <strong>Tanggal:</strong> <?php echo $person['tanggal_hilang'] ? date('d M Y', strtotime($person['tanggal_hilang'])) : '-'; ?><br>
                                            <strong>Ciri Khusus:</strong> <?php echo htmlspecialchars($person['ciri_fisik'] ?: '-'); ?>
                                        </div>
                                        <div>
                                            <?php if ($person['status'] === 'hilang'): ?>
                                                <span class="status-pill hilang"><i class="fas fa-clock"></i> Masih Dalam Pencarian</span>
                                            <?php else: ?>
                                                <span class="status-pill ditemukan"><i class="fas fa-check-circle"></i> Telah Ditemukan Selamat</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="background: #ffffff; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 32px; text-align: center; color: var(--text-muted);">
                            Saat ini belum ada data orang hilang yang tercatat.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Section: Connect with us (CTA) -->
        <section class="connect-section">
            <div class="site-wrapper">
                <div class="connect-box">
                    <span class="eyebrow-tag">Posko Siaga Darurat 24 Jam</span>
                    <h2>Connect with us</h2>
                    <p>
                        Hubungi posko siaga bencana, laporkan informasi orang hilang, atau dapatkan rute evakuasi terverifikasi bersama relawan Vulkanik.
                    </p>
                    <a href="mailto:124250018@upnyk.ac.id?subject=Hubungi%20Posko%20Terpadu&amp;body=Halo%20Posko%20Vulkanik%2C%0A%0ASaya%20ingin%20menghubungi%20posko%20terkait%3A%0A" class="btn-pill btn-pill-dark" style="padding: 14px 36px; font-size: 1rem;">
                        Hubungi Posko Terpadu
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Leaflet JS for Map -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
    
    <script>
        // Interactive Volcano Map Implementation
        var map = null;
        var volcanoMarkers = [];
        var allVolcanoesData = [];

        var fallbackVolcanoes = [
            { name: "Gunung Merapi", provinsi: "D.I. Yogyakarta & Jawa Tengah", lat: -7.5407, lon: 110.4457, tinggi: "2.930 mdpl", status: "Siaga (Level III)", deskripsi: "Aktivitas guguran lava dan awan panas berkala ke arah barat daya (Sungai Bebeng & Krasak)." },
            { name: "Gunung Semeru", provinsi: "Jawa Timur", lat: -8.108, lon: 112.922, tinggi: "3.676 mdpl", status: "Siaga (Level III)", deskripsi: "Erupsi berkala dengan kolom abu pekat dan ancaman lahar hujan di Besuk Kobokan." },
            { name: "Gunung Lewotobi Laki-laki", provinsi: "Nusa Tenggara Timur", lat: -8.538, lon: 122.768, tinggi: "1.584 mdpl", status: "Awas (Level IV)", deskripsi: "Aktivitas erupsi tinggi dengan zona larangan radius 7 km dari pusat kawah aktif." },
            { name: "Gunung Marapi", provinsi: "Sumatera Barat", lat: -0.381, lon: 100.473, tinggi: "2.891 mdpl", status: "Siaga (Level III)", deskripsi: "Terekam hembusan abu vulkanik serta gempa letusan berkala, radius aman 4.5 km." },
            { name: "Gunung Sinabung", provinsi: "Sumatera Utara", lat: 3.170, lon: 98.392, tinggi: "2.460 mdpl", status: "Waspada (Level II)", deskripsi: "Pemantauan kubah lava dan tremor stabil di tingkat waspada." },
            { name: "Gunung Anak Krakatau", provinsi: "Lampung / Selat Sunda", lat: -6.102, lon: 105.423, tinggi: "157 mdpl", status: "Siaga (Level III)", deskripsi: "Aktivitas vulkanik kepulauan dengan potensi bahaya gelombang pasang / tsunami lokal." },
            { name: "Gunung Bromo", provinsi: "Jawa Timur", lat: -7.942, lon: 112.953, tinggi: "2.329 mdpl", status: "Waspada (Level II)", deskripsi: "Asap kawah kawah aktif membubung putih kelabu dengan tremor vulkanik menerus." },
            { name: "Gunung Rinjani", provinsi: "Nusa Tenggara Barat", lat: -8.411, lon: 116.457, tinggi: "3.726 mdpl", status: "Normal (Level I)", deskripsi: "Kondisi stabil tanpa peningkatan aktivitas gempa vulkanik berarti." }
        ];

        function initMap() {
            var mapElement = document.getElementById('volcanoMap');
            if (!mapElement) return;

            if (typeof L === 'undefined') {
                setMapStatus('Peta tidak dapat dimuat. Periksa koneksi internet lalu muat ulang halaman.');
                return;
            }

            map = L.map('volcanoMap', {
                scrollWheelZoom: false
            }).setView([-2.5, 118.0], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap & PVMBG'
            }).addTo(map);

            fetch('api/volcanoes.php')
                .then(function(res) {
                    if (!res.ok) {
                        throw new Error('Data gunung tidak dapat dimuat.');
                    }
                    return res.json();
                })
                .then(function(data) {
                    if (!Array.isArray(data)) {
                        throw new Error('Format data gunung tidak valid.');
                    }
                    allVolcanoesData = data;
                    renderMarkers(data);
                    setMapStatus('');
                })
                .catch(function() {
                    allVolcanoesData = fallbackVolcanoes;
                    renderMarkers(fallbackVolcanoes);
                    setMapStatus('Data dari server tidak tersedia. Menampilkan data contoh.');
                });

            document.querySelectorAll('[data-map-filter]').forEach(function(button) {
                button.addEventListener('click', function() {
                    filterMap(button.dataset.mapFilter);
                });
            });
        }

        function setMapStatus(message) {
            var statusElement = document.getElementById('mapStatus');
            if (!statusElement) return;

            statusElement.textContent = message;
            statusElement.hidden = message === '';
        }

        function getMarkerColor(status) {
            var s = (status || '').toLowerCase();
            if (s.includes('awas')) return '#7f1d1d';
            if (s.includes('siaga')) return '#dc2626';
            if (s.includes('waspada')) return '#d97706';
            return '#16a34a';
        }

        function renderMarkers(data) {
            volcanoMarkers.forEach(function(m) { map.removeLayer(m); });
            volcanoMarkers = [];

            data.forEach(function(v) {
                var color = getMarkerColor(v.status);
                var marker = L.circleMarker([v.lat, v.lon], {
                    radius: 8,
                    fillColor: color,
                    color: '#ffffff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.95
                }).addTo(map);

                var popupContent = 
                    '<div style="font-family: inherit; padding: 4px;">' +
                    '<h4 style="margin: 0 0 4px; font-size: 1rem; color: #151813;">' + v.name + '</h4>' +
                    '<div style="font-size: 0.8rem; color: #575c52; margin-bottom: 6px;">' + v.provinsi + ' (' + (v.tinggi || '') + ')</div>' +
                    '<div style="display: inline-block; padding: 3px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; background: ' + color + '; color: #ffffff; margin-bottom: 6px;">' + v.status + '</div>' +
                    '<p style="font-size: 0.82rem; margin: 0; color: #444;">' + (v.deskripsi || '') + '</p>' +
                    '</div>';

                marker.bindPopup(popupContent);
                marker.volcanoData = v;
                volcanoMarkers.push(marker);
            });
        }

        function filterMap(level) {
            document.querySelectorAll('[data-map-filter]').forEach(function(button) {
                var isActive = button.dataset.mapFilter === level;
                button.classList.toggle('active', isActive);
                button.setAttribute('aria-pressed', String(isActive));
            });

            if (level === 'all') {
                renderMarkers(allVolcanoesData);
                return;
            }

            var filtered = allVolcanoesData.filter(function(v) {
                return (v.status || '').toLowerCase().includes(level.toLowerCase());
            });
            renderMarkers(filtered);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
</body>
</html>
