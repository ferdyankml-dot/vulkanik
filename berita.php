<?php
require_once __DIR__ . '/config.php';

$default_articles = [
    [
        'id' => 1,
        'source' => 'RRI.co.id',
        'date' => '16 November 2026',
        'datetime' => '2026-11-16',
        'category' => 'Aktivitas Erupsi',
        'title' => 'Gunung Ibu di Maluku Utara Erupsi Lagi, Ini Peringatan PVMBG untuk Warga',
        'summary' => 'RRI melaporkan erupsi Gunung Ibu dengan kolom abu sekitar 500 meter di atas puncak. PVMBG meminta warga dan wisatawan menjauhi radius 2 kilometer dari kawah aktif serta perluasan sektoral.',
        'image' => 'assets/img/erupsi-gunung-api.webp',
        'url' => 'https://rri.co.id/regional/2898919/gunung-ibu-di-maluku-utara-erupsi-lagi-ini-peringatan-pvmbg-untuk-warga'
    ],
    [
        'id' => 2,
        'source' => 'Liputan6',
        'date' => '14 November 2026',
        'datetime' => '2026-11-14',
        'category' => 'Status Siaga',
        'title' => 'Tiga Gunung Api di Indonesia Berstatus Siaga, Ini Rekomendasi Jarak Aman',
        'summary' => 'Liputan6 merangkum data BNPB dan PVMBG untuk Anak Krakatau, Merapi, dan Semeru. Artikel merinci zona bahaya serta imbauan resmi agar pendaki dan warga menghindari radius rawan.',
        'image' => 'assets/img/gunung-semeru.jpg',
        'url' => 'https://www.liputan6.com/news/read/8335172/tiga-gunung-api-berstatus-siaga-ini-jarak-amannya'
    ],
    [
        'id' => 3,
        'source' => 'ANTARA News',
        'date' => '10 September 2026',
        'datetime' => '2026-09-10',
        'category' => 'Aktivitas Erupsi',
        'title' => '11 Gunung Api di Indonesia yang Tercatat Erupsi Sepanjang Periode 2026',
        'summary' => 'Badan Geologi mencatat 11 gunung api di Indonesia mengalami erupsi sepanjang tahun 2026. Gunung Semeru dan Gunung Ibu termasuk yang paling sering mengalami letusan kolom abu.',
        'image' => 'assets/img/gunung-semeru.jpg',
        'url' => 'https://www.antaranews.com/berita/5734176/11-gunung-api-di-indonesia-yang-erupsi-sepanjang-2026'
    ],
    [
        'id' => 4,
        'source' => 'Kompas.com',
        'date' => '20 November 2026',
        'datetime' => '2026-11-20',
        'category' => 'Aktivitas Erupsi',
        'title' => 'Aktivitas Vulkanik Merapi Terus Dipantau, Guguran Lava Teramati di Lereng',
        'summary' => 'BPPTKG melaporkan aktivitas guguran lava dan kegempaan yang stabil tinggi di Gunung Merapi. Warga di bantaran sungai berhulu Merapi diimbau mengantisipasi bahaya lahar hujan.',
        'image' => 'assets/img/erupsi-gunung-api.webp',
        'url' => 'https://www.kompas.com/'
    ],
    [
        'id' => 5,
        'source' => 'CNN Indonesia',
        'date' => '18 November 2026',
        'datetime' => '2026-11-18',
        'category' => 'Mitigasi Bencana',
        'title' => 'Kesiapsiagaan Pos Pengungsian dan Rambu Evakuasi di Kawasan Rawan Bencana',
        'summary' => 'BPBD bersama aparat wilayah memperkuat jalur evakuasi darurat, stok masker, serta kesiapan logistik posko bagi penduduk yang bertempat tinggal di Kawasan Rawan Bencana (KRB) III.',
        'image' => 'assets/img/gunung-semeru.jpg',
        'url' => 'https://www.cnnindonesia.com/'
    ],
    [
        'id' => 6,
        'source' => 'Detik News',
        'date' => '12 November 2026',
        'datetime' => '2026-11-12',
        'category' => 'Edukasi Vulkanologi',
        'title' => 'Panduan Tingkatan Status Gunung Api: Dari Normal, Waspada, Siaga, hingga Awas',
        'summary' => 'Panduan memahami 4 tingkatan status aktivitas gunung api berdasarkan klasifikasi PVMBG, lengkap dengan arti warna peringatan dan protokol keselamatan yang wajib diperhatikan.',
        'image' => 'assets/img/erupsi-gunung-api.webp',
        'url' => 'https://news.detik.com/'
    ]
];

// Fungsi database [READ]: mengambil berita dari tabel berita jika koneksi aktif.
// Jika tabel kosong atau database tidak tersedia, tampilan memakai $default_articles.
$articles = [];
if (!empty($conn)) {
    $q_berita = @$conn->query("SELECT * FROM berita ORDER BY created_at DESC");
    if ($q_berita && $q_berita->num_rows > 0) {
        $idx = 1;
        while ($row = $q_berita->fetch_assoc()) {
            $img = !empty($row['gambar']) ? $row['gambar'] : 'assets/img/erupsi-gunung-api.webp';
            if (!preg_match('/^(https?:\/\/|\/|assets\/|uploads\/)/', $img)) {
                $img = 'uploads/' . $img;
            }
            $articles[] = [
                'id' => $idx++,
                'source' => 'Redaksi Vulkanik',
                'date' => date('d F Y', strtotime($row['created_at'])),
                'datetime' => date('Y-m-d', strtotime($row['created_at'])),
                'category' => 'Kabar Vulkanik',
                'title' => $row['judul'],
                'summary' => (mb_strlen($row['konten']) > 160) ? mb_substr(strip_tags($row['konten']), 0, 160) . '...' : strip_tags($row['konten']),
                'image' => $img,
                'url' => '#'
            ];
        }
    }
}

if (empty($articles)) {
    $articles = $default_articles;
}

$featured_article = $articles[0] ?? null;
$grid_articles = count($articles) > 1 ? array_slice($articles, 1) : [];

// Ambil kategori unik untuk filter tabs
$categories = ['Semua'];
foreach ($articles as $art) {
    if (!empty($art['category']) && !in_array($art['category'], $categories, true)) {
        $categories[] = $art['category'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warta & Berita Vulkanik - Informasi Terpercaya Gunung Api Indonesia</title>
    <link rel="stylesheet" href="css/navbar.css?v=20261123">
    <link rel="stylesheet" href="css/footer.css?v=20261123">
    <link rel="stylesheet" href="css/berita.css?v=20261123">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main>
        <!-- Header Hero Section -->
        <section class="news-hero">
            <div class="news-container">
                <nav class="news-breadcrumb" aria-label="Breadcrumb">
                    <a href="index.php"><i class="fa-solid fa-house"></i> Beranda</a>
                    <span class="news-breadcrumb-separator">/</span>
                    <span class="news-breadcrumb-current">Warta &amp; Berita</span>
                </nav>

                <div class="news-hero-content">
                    <span class="news-badge-label">
                        <i class="fa-regular fa-newspaper"></i> Informasi Publik
                    </span>
                    <h1>Berita &amp; Aktivitas Gunung Api</h1>
                    <p>Pusat rangkuman kabar terkini seputar vulkanologi Indonesia, perkembangan status gunung api, dan dokumentasi mitigasi dari sumber-sumber terpercaya.</p>
                </div>
            </div>
        </section>

        <!-- Main Content Section -->
        <section class="news-section">
            <div class="news-container">

                <?php if ($featured_article): ?>
                    <!-- Berita Utama / Featured Article -->
                    <div class="news-featured-card" data-category="<?php echo htmlspecialchars($featured_article['category'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="news-featured-image-wrapper">
                            <img src="<?php echo htmlspecialchars($featured_article['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                 alt="<?php echo htmlspecialchars($featured_article['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                 onerror="this.onerror=null; this.src='assets/img/erupsi-gunung-api.webp';">
                            <span class="news-featured-badge">
                                <i class="fa-solid fa-bolt"></i> Berita Utama
                            </span>
                        </div>
                        <div class="news-featured-body">
                            <div class="news-meta-row">
                                <span class="news-tag-category"><?php echo htmlspecialchars($featured_article['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="news-source-meta">
                                    <i class="fa-solid fa-newspaper"></i> <?php echo htmlspecialchars($featured_article['source'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                                <time datetime="<?php echo htmlspecialchars($featured_article['datetime'], ENT_QUOTES, 'UTF-8'); ?>" class="news-date-meta">
                                    <i class="fa-regular fa-calendar"></i> <?php echo htmlspecialchars($featured_article['date'], ENT_QUOTES, 'UTF-8'); ?>
                                </time>
                            </div>

                            <h2 class="news-featured-heading">
                                <a href="<?php echo htmlspecialchars($featured_article['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo htmlspecialchars($featured_article['title'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h2>

                            <p class="news-featured-summary">
                                <?php echo htmlspecialchars($featured_article['summary'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>

                            <div class="news-featured-action">
                                <a class="btn-news-primary" href="<?php echo htmlspecialchars($featured_article['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                                    <span>Baca Berita Selengkapnya</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Toolbar: Filter Kategori & Pencarian Berita -->
                <div class="news-toolbar">
                    <div class="news-toolbar-header">
                        <div>
                            <span class="news-subheading-tag">Kabar Terpilih</span>
                            <h2 class="news-subheading-title">Daftar Berita &amp; Informasi</h2>
                        </div>
                        <span class="news-count-pill" id="articleCountPill"><?php echo count($articles); ?> Total Artikel</span>
                    </div>

                    <div class="news-filter-wrapper">
                        <!-- Category Tabs -->
                        <div class="news-filter-tabs" id="categoryTabs">
                            <?php foreach ($categories as $i => $cat): ?>
                                <button type="button" 
                                        class="news-filter-btn <?php echo $i === 0 ? 'active' : ''; ?>" 
                                        data-filter="<?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Search Box -->
                        <div class="news-search-box">
                            <i class="fa-solid fa-magnifying-glass news-search-icon"></i>
                            <input type="text" id="newsSearchInput" placeholder="Cari artikel berita..." aria-label="Cari artikel berita">
                            <button type="button" id="clearSearchBtn" class="news-search-clear" title="Hapus pencarian" style="display: none;">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Berita -->
                <div class="news-grid" id="newsGrid">
                    <?php foreach ($grid_articles as $article): ?>
                        <article class="news-card" data-category="<?php echo htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="news-card-thumb-wrapper">
                                <img src="<?php echo htmlspecialchars($article['image'] ?? 'assets/img/erupsi-gunung-api.webp', ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='assets/img/erupsi-gunung-api.webp';">
                                <span class="news-card-tag"><?php echo htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>

                            <div class="news-card-content">
                                <div class="news-card-meta">
                                    <span class="news-source-meta">
                                        <i class="fa-solid fa-newspaper"></i> <?php echo htmlspecialchars($article['source'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                    <time datetime="<?php echo htmlspecialchars($article['datetime'], ENT_QUOTES, 'UTF-8'); ?>" class="news-date-meta">
                                        <i class="fa-regular fa-calendar"></i> <?php echo htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8'); ?>
                                    </time>
                                </div>

                                <h3 class="news-card-title">
                                    <a href="<?php echo htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h3>

                                <p class="news-card-summary">
                                    <?php echo htmlspecialchars($article['summary'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>

                                <div class="news-card-footer">
                                    <a class="news-link-action" href="<?php echo htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                                        <span>Baca di <?php echo htmlspecialchars($article['source'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Empty State (jika hasil pencarian kosong) -->
                <div class="news-empty-state" id="newsEmptyState" style="display: none;">
                    <div class="news-empty-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3>Tidak ada berita ditemukan</h3>
                    <p>Kata kunci yang Anda cari tidak cocok dengan judul atau isi artikel manapun.</p>
                    <button type="button" class="btn-news-outline" id="resetFilterBtn">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter &amp; Pencarian
                    </button>
                </div>

                <!-- Notice Status MAGMA Indonesia -->
                <aside class="news-official-banner">
                    <div class="news-official-icon">
                        <i class="fa-solid fa-tower-broadcast"></i>
                    </div>
                    <div class="news-official-content">
                        <h3>Periksa Status Gunung Api Terkini Secara Real-Time</h3>
                        <p>Kabar media publik menyajikan rekap dokumentasi kejadian. Untuk peta risiko bahaya terkini, rekomendasi radius keselamatan, dan pemantauan seismik real-time, selalu rujuk kanal resmi PVMBG Kementerian ESDM.</p>
                        <a href="https://magma.esdm.go.id/" target="_blank" rel="noopener noreferrer" class="news-official-link">
                            <span>Kunjungi MAGMA Indonesia (Badan Geologi)</span>
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    </div>
                </aside>

            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Script Filter & Pencarian Berita Sederhana -->
    <script>
        (function() {
            var searchInput = document.getElementById('newsSearchInput');
            var clearSearchBtn = document.getElementById('clearSearchBtn');
            var filterButtons = document.querySelectorAll('.news-filter-btn');
            var cards = document.querySelectorAll('.news-card');
            var featuredCard = document.querySelector('.news-featured-card');
            var emptyState = document.getElementById('newsEmptyState');
            var resetFilterBtn = document.getElementById('resetFilterBtn');
            var countPill = document.getElementById('articleCountPill');

            var currentCategory = 'Semua';

            function filterNews() {
                var query = (searchInput.value || '').trim().toLowerCase();
                var visibleCount = 0;

                // Tampilkan/sembunyikan tombol clear
                if (clearSearchBtn) {
                    clearSearchBtn.style.display = query ? 'block' : 'none';
                }

                // Filter Berita Utama (Featured Card)
                if (featuredCard) {
                    var featCat = featuredCard.getAttribute('data-category') || '';
                    var featText = featuredCard.textContent.toLowerCase();
                    var matchCat = (currentCategory === 'Semua' || featCat.toLowerCase() === currentCategory.toLowerCase());
                    var matchQuery = !query || featText.indexOf(query) !== -1;

                    if (matchCat && matchQuery) {
                        featuredCard.style.display = '';
                        visibleCount++;
                    } else {
                        featuredCard.style.display = 'none';
                    }
                }

                // Filter Kartu Grid
                cards.forEach(function(card) {
                    var cardCat = card.getAttribute('data-category') || '';
                    var cardText = card.textContent.toLowerCase();
                    var matchCat = (currentCategory === 'Semua' || cardCat.toLowerCase() === currentCategory.toLowerCase());
                    var matchQuery = !query || cardText.indexOf(query) !== -1;

                    if (matchCat && matchQuery) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update count dan empty state
                if (countPill) {
                    countPill.textContent = visibleCount + ' Artikel Ditampilkan';
                }

                if (emptyState) {
                    emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
                }
            }

            // Event listener pencarian
            if (searchInput) {
                searchInput.addEventListener('input', filterNews);
            }

            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    filterNews();
                    searchInput.focus();
                });
            }

            // Event listener tombol kategori
            filterButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    filterButtons.forEach(function(b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    currentCategory = btn.getAttribute('data-filter') || 'Semua';
                    filterNews();
                });
            });

            // Reset Filter
            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    currentCategory = 'Semua';
                    filterButtons.forEach(function(b) {
                        if (b.getAttribute('data-filter') === 'Semua') {
                            b.classList.add('active');
                        } else {
                            b.classList.remove('active');
                        }
                    });
                    filterNews();
                });
            }
        })();
    </script>
</body>
</html>
