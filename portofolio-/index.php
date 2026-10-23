<?php $pageTitle = 'Beranda'; require 'db.php'; include 'header.php'; ?>

<section class="hero">
    <div class="row align-items-center g-5">
        <div class="col-lg-7 order-2 order-lg-1">
            <span class="badge-soft mb-3"><i class="bi bi-lightning-charge-fill"></i> <?= e($profil['tagline']) ?></span>
            <h1 class="mb-3">Halo, saya <span class="text-grad"><?= e($profil['nama']) ?></span></h1>
            <p class="lead mb-4">
                Mahasiswa <?= e($profil['jurusan']) ?> di <?= e($profil['kampus']) ?> yang aktif membuat konten gaming
                bertema otomotif dan simulasi balap.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="sertifikasi.php" class="btn btn-accent"><i class="bi bi-award me-2"></i>Lihat Sertifikasi</a>
                <a href="about.php" class="btn btn-ghost">Tentang Saya</a>
            </div>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center">
            <?= avatar(240) ?>
        </div>
    </div>
</section>

<section class="mt-5">
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <div class="card-x hover">
                <div class="icon-box"><i class="bi bi-person-fill"></i></div>
                <div class="info-label">Nama</div>
                <div class="info-value"><?= e($profil['nama']) ?></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-x hover">
                <div class="icon-box"><i class="bi bi-credit-card-2-front-fill"></i></div>
                <div class="info-label">NIM</div>
                <div class="info-value"><?= e($profil['nim']) ?></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-x hover">
                <div class="icon-box"><i class="bi bi-mortarboard-fill"></i></div>
                <div class="info-label">Jurusan</div>
                <div class="info-value"><?= e($profil['jurusan']) ?></div>
                <div class="muted small"><?= e($profil['kampus']) ?></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-x hover">
                <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
                <div class="info-label">Email</div>
                <div class="info-value"><a href="mailto:<?= e($profil['email']) ?>" class="text-decoration-none text-reset"><?= e($profil['email']) ?></a></div>
            </div>
        </div>
    </div>
</section>

<section class="mt-5">
    <h3 class="section-title">Pengalaman Saya</h3>
    <div class="card-x">
        <p class="mb-4" style="line-height:1.8"><?= e($profil['pengalaman']) ?></p>
        <div>
            <?php foreach ($profil['keahlian'] as $k): ?>
                <span class="chip"><?= e($k) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
