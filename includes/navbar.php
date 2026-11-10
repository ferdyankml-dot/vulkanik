<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$knowledgePages = ['definisi.php', 'jenis_letusan.php', 'dampak.php', 'penanggulangan.php', 'mitigasi.php'];
$isKnowledgePage = in_array($currentPage, $knowledgePages, true);
$sectionPrefix = $currentPage === 'index.php' ? '' : 'index.php';

if ($currentPage === 'admin.php') {
    $actionHref = 'logout.php';
    $actionLabel = 'Keluar';
} elseif ($currentPage === 'login.php') {
    $actionHref = 'index.php';
    $actionLabel = 'Kembali ke Beranda';
} else {
    $actionHref = 'login.php';
    $actionLabel = 'Masuk Admin';
}
?>
<header class="site-nav">
    <div class="nav-container">
        <a href="index.php" class="nav-brand">
            Vulkanik<span class="brand-dot" aria-hidden="true"></span>
        </a>

        <button class="nav-toggle" type="button" aria-controls="primary-navigation" aria-expanded="false" aria-label="Buka navigasi">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="nav-menu" id="primary-navigation" aria-label="Navigasi utama">
            <ul class="nav-links">
                <li class="nav-link-item<?php echo $currentPage === 'index.php' ? ' active' : ''; ?>">
                    <a href="index.php"<?php echo $currentPage === 'index.php' ? ' aria-current="page"' : ''; ?>>Beranda</a>
                </li>
                <li class="nav-link-item nav-dropdown-item<?php echo $isKnowledgePage ? ' active' : ''; ?>">
                    <details class="nav-dropdown">
                        <summary>Pengetahuan Vulkanik</summary>
                        <ul class="nav-dropdown-menu">
                            <li><a href="definisi.php"<?php echo $currentPage === 'definisi.php' ? ' aria-current="page"' : ''; ?>>Definisi Letusan</a></li>
                            <li><a href="jenis_letusan.php"<?php echo $currentPage === 'jenis_letusan.php' ? ' aria-current="page"' : ''; ?>>Jenis Letusan</a></li>
                            <li><a href="dampak.php"<?php echo $currentPage === 'dampak.php' ? ' aria-current="page"' : ''; ?>>Dampak Bahaya</a></li>
                            <li><a href="penanggulangan.php"<?php echo $currentPage === 'penanggulangan.php' ? ' aria-current="page"' : ''; ?>>Penanggulangan</a></li>
                            <li><a href="mitigasi.php"<?php echo $currentPage === 'mitigasi.php' ? ' aria-current="page"' : ''; ?>>Mitigasi &amp; SOP</a></li>
                        </ul>
                    </details>
                </li>
                <li class="nav-link-item"><a href="<?php echo htmlspecialchars($sectionPrefix, ENT_QUOTES, 'UTF-8'); ?>#peta-sebaran">Peta Sebaran</a></li>
                <li class="nav-link-item"><a href="<?php echo htmlspecialchars($sectionPrefix, ENT_QUOTES, 'UTF-8'); ?>#pencarian">Orang Hilang</a></li>
                <li class="nav-link-item"><a href="<?php echo htmlspecialchars($sectionPrefix, ENT_QUOTES, 'UTF-8'); ?>#tanya-jawab">Tanya Jawab</a></li>
                <li class="nav-link-item<?php echo $currentPage === 'tentang.php' ? ' active' : ''; ?>">
                    <a href="tentang.php"<?php echo $currentPage === 'tentang.php' ? ' aria-current="page"' : ''; ?>>Tentang</a>
                </li>
            </ul>

            <div class="nav-actions">
                <?php if ($currentPage === 'admin.php'): ?>
                    <a href="index.php" class="btn-pill btn-pill-light">Ke Halaman Publik</a>
                <?php endif; ?>
                <a href="<?php echo htmlspecialchars($actionHref, ENT_QUOTES, 'UTF-8'); ?>" class="btn-pill btn-pill-dark"><?php echo htmlspecialchars($actionLabel, ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
        </nav>
    </div>
</header>
<script>
    (function () {
        var header = document.querySelector('.site-nav');
        var toggle = header && header.querySelector('.nav-toggle');

        if (!header || !toggle) {
            return;
        }

        toggle.addEventListener('click', function () {
            var isOpen = header.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Tutup navigasi' : 'Buka navigasi');
        });

        header.querySelectorAll('.nav-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                header.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Buka navigasi');
            });
        });
    }());
</script>
