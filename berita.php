<?php
$articles = [
    [
        'source' => 'RRI.co.id',
        'date' => '16 November 2026',
        'datetime' => '2026-11-16',
        'category' => 'Aktivitas Gunung Ibu',
        'title' => 'Gunung Ibu di Maluku Utara Erupsi Lagi, Ini Peringatan PVMBG untuk Warga',
        'summary' => 'RRI melaporkan erupsi Gunung Ibu pada 15 November dengan kolom abu sekitar 500 meter di atas puncak. Dalam laporan yang dikutip media tersebut, PVMBG meminta warga menjauhi radius 2 kilometer dari kawah serta perluasan sektoral ke arah utara.',
        'url' => 'https://rri.co.id/regional/2898919/gunung-ibu-di-maluku-utara-erupsi-lagi-ini-peringatan-pvmbg-untuk-warga'
    ],
    [
        'source' => 'Liputan6',
        'date' => '14 November 2026',
        'datetime' => '2026-11-14',
        'category' => 'Status Siaga',
        'title' => 'Tiga Gunung Api Berstatus Siaga, Ini Jarak Amannya',
        'summary' => 'Liputan6 merangkum laporan BNPB dan rekomendasi PVMBG untuk Anak Krakatau, Merapi, dan Semeru. Artikel memuat zona bahaya dan imbauan agar masyarakat serta pendaki menghindari area yang dibatasi.',
        'url' => 'https://www.liputan6.com/news/read/8335172/tiga-gunung-api-berstatus-siaga-ini-jarak-amannya'
    ],
    [
        'source' => 'ANTARA News',
        'date' => '10 September 2026',
        'datetime' => '2026-09-10',
        'category' => 'Rekap Aktivitas 2026',
        'title' => '11 gunung api di Indonesia yang erupsi sepanjang 2026',
        'summary' => 'ANTARA merangkum data Badan Geologi hingga 7 September 2026. Rekap tersebut mencatat 11 gunung api mengalami erupsi; Semeru dan Ibu termasuk yang paling sering tercatat dalam periode itu.',
        'url' => 'https://www.antaranews.com/berita/5734176/11-gunung-api-di-indonesia-yang-erupsi-sepanjang-2026'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Gunung Api - Vulkanik</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/berita.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main>
        <section class="news-hero">
            <div class="news-container">
                <span class="news-eyebrow"><i class="fa-regular fa-newspaper me-2" aria-hidden="true"></i>Informasi dari media publik</span>
                <h1>Berita Gunung Api</h1>
                <p>Ringkasan berita terpilih tentang aktivitas gunung api di Indonesia. Buka artikel sumber untuk membaca laporan lengkap.</p>
            </div>
        </section>

        <section class="news-section">
            <div class="news-container">
                <div class="news-section-heading">
                    <div>
                        <span class="news-kicker">Kabar terbaru pilihan</span>
                        <h2>Berita dan perkembangan</h2>
                    </div>
                    <span class="news-count"><?php echo count($articles); ?> artikel</span>
                </div>

                <div class="news-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="news-card">
                            <div class="news-card-meta">
                                <span class="news-source"><?php echo htmlspecialchars($article['source'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <time datetime="<?php echo htmlspecialchars($article['datetime'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                            </div>
                            <span class="news-category"><?php echo htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <h3><?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p><?php echo htmlspecialchars($article['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <a class="news-read-more" href="<?php echo htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                                Baca berita di <?php echo htmlspecialchars($article['source'], ENT_QUOTES, 'UTF-8'); ?>
                                <i class="fa-solid fa-arrow-up-right-from-square ms-2" aria-hidden="true"></i>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <aside class="news-official">
                    <div class="news-official-icon"><i class="fa-solid fa-tower-broadcast" aria-hidden="true"></i></div>
                    <div>
                        <h2>Periksa status gunung api terkini</h2>
                        <p>Ringkasan berita di halaman ini mengikuti tanggal publikasi masing-masing dan bukan pembaruan waktu nyata. Untuk status serta rekomendasi keselamatan terbaru, rujuk kanal resmi MAGMA Indonesia dari PVMBG.</p>
                        <a href="https://magma.esdm.go.id/" target="_blank" rel="noopener noreferrer">Buka MAGMA Indonesia <i class="fa-solid fa-arrow-up-right-from-square ms-1" aria-hidden="true"></i></a>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
