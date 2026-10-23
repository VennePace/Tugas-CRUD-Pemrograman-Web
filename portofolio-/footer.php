</main>
<footer class="site-footer">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span>&copy; <?= date('Y') ?> <?= e($profil['nama']) ?> &middot; <?= e($profil['kampus']) ?></span>
        <a href="mailto:<?= e($profil['email']) ?>"><i class="bi bi-envelope me-1"></i><?= e($profil['email']) ?></a>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
