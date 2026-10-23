<?php $pageTitle = 'About Me'; require 'db.php'; include 'header.php'; ?>

<div class="page-head"><h2>About Me</h2></div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-x text-center">
            <?= avatar(170) ?>
            <h4 class="mt-4 mb-1"><?= e($profil['nama']) ?></h4>
            <div class="muted mb-4"><?= e($profil['tagline']) ?></div>
            <hr class="border-secondary-subtle">
            <div class="text-start">
                <div class="mb-3">
                    <div class="info-label">NIM</div>
                    <div class="info-value"><?= e($profil['nim']) ?></div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Jurusan</div>
                    <div class="info-value"><?= e($profil['jurusan']) ?> &middot; <?= e($profil['kampus']) ?></div>
                </div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value"><a href="mailto:<?= e($profil['email']) ?>" class="text-decoration-none"><?= e($profil['email']) ?></a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-x mb-4">
            <h4 class="mb-3">Tentang Saya</h4>
            <p class="mb-3" style="line-height:1.8">
                Halo, saya <strong><?= e($profil['nama']) ?></strong>, mahasiswa <?= e($profil['jurusan']) ?>
                di <?= e($profil['kampus']) ?> (NIM <?= e($profil['nim']) ?>).
            </p>
            <p class="mb-0" style="line-height:1.8"><?= e($profil['pengalaman']) ?></p>
        </div>

        <div class="card-x">
            <h4 class="mb-3">Keahlian &amp; Minat</h4>
            <?php foreach ($profil['keahlian'] as $k): ?>
                <span class="chip"><?= e($k) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
