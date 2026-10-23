<?php
require 'db.php';

$aksi = $_GET['aksi'] ?? 'index';
$id   = (int)($_GET['id'] ?? 0);

// ---------- PROSES FORM (POST) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $do = $_POST['do'] ?? '';

    if ($do === 'simpan') {
        $pdf  = upload('file_pdf', ['pdf']);
        $foto = upload('foto', ['jpg', 'jpeg', 'png']);
        $st = $pdo->prepare("INSERT INTO sertifikasi (judul, ringkasan, file_pdf, foto) VALUES (?, ?, ?, ?)");
        $st->execute([trim($_POST['judul']), trim($_POST['ringkasan']), $pdf, $foto]);
        flash('Sertifikasi berhasil ditambahkan!');
    }

    if ($do === 'update') {
        $id = (int)$_POST['id'];
        $lama = $pdo->prepare("SELECT * FROM sertifikasi WHERE id = ?");
        $lama->execute([$id]);
        $lama = $lama->fetch();
        if ($lama) {
            $pdf  = upload('file_pdf', ['pdf']);
            $foto = upload('foto', ['jpg', 'jpeg', 'png']);
            if ($pdf)  { hapusFile($lama['file_pdf']); } else { $pdf  = $lama['file_pdf']; }
            if ($foto) { hapusFile($lama['foto']); }     else { $foto = $lama['foto']; }
            $st = $pdo->prepare("UPDATE sertifikasi SET judul = ?, ringkasan = ?, file_pdf = ?, foto = ? WHERE id = ?");
            $st->execute([trim($_POST['judul']), trim($_POST['ringkasan']), $pdf, $foto, $id]);
            flash('Sertifikasi berhasil diperbarui!');
        }
    }

    if ($do === 'hapus') {
        $id = (int)$_POST['id'];
        $lama = $pdo->prepare("SELECT * FROM sertifikasi WHERE id = ?");
        $lama->execute([$id]);
        $lama = $lama->fetch();
        if ($lama) {
            hapusFile($lama['file_pdf']);
            hapusFile($lama['foto']);
            $pdo->prepare("DELETE FROM sertifikasi WHERE id = ?")->execute([$id]);
            flash('Sertifikasi berhasil dihapus!');
        }
    }

    header('Location: sertifikasi.php');
    exit;
}

$pageTitle = 'Sertifikasi';
include 'header.php';

// ---------- FORM TAMBAH ----------
if ($aksi === 'tambah'): ?>
    <div class="page-head"><h2>Tambah Sertifikasi</h2></div>
    <div class="card-x"><form method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="do" value="simpan">
        <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">Ringkasan</label>
            <textarea name="ringkasan" rows="4" class="form-control" required></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Upload PDF</label>
            <input type="file" name="file_pdf" class="form-control" accept="application/pdf">
        </div>
        <div class="col-md-6">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-accent">Simpan</button>
            <a href="sertifikasi.php" class="btn btn-ghost">Kembali</a>
        </div>
    </form></div>

<?php
// ---------- FORM EDIT ----------
elseif ($aksi === 'edit'):
    $st = $pdo->prepare("SELECT * FROM sertifikasi WHERE id = ?");
    $st->execute([$id]);
    $s = $st->fetch();
    if (!$s) { echo '<div class="alert alert-danger">Data tidak ditemukan.</div>'; include 'footer.php'; exit; }
?>
    <div class="page-head"><h2>Edit Sertifikasi</h2></div>
    <div class="card-x"><form method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="do" value="update">
        <input type="hidden" name="id" value="<?= $s['id'] ?>">
        <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= e($s['judul']) ?>" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">Ringkasan</label>
            <textarea name="ringkasan" rows="4" class="form-control" required><?= e($s['ringkasan']) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Upload PDF (opsional)</label>
            <input type="file" name="file_pdf" class="form-control" accept="application/pdf">
            <?php if ($s['file_pdf']): ?>
                <p class="mt-2">File saat ini: <a href="uploads/<?= e($s['file_pdf']) ?>" target="_blank">Lihat PDF</a></p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="form-label">Upload Foto (opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <?php if ($s['foto']): ?>
                <p class="mt-2">Foto saat ini:</p>
                <img src="uploads/<?= e($s['foto']) ?>" width="100" class="rounded">
            <?php endif; ?>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-accent">Update</button>
            <a href="sertifikasi.php" class="btn btn-ghost">Kembali</a>
        </div>
    </form></div>

<?php
// ---------- DAFTAR ----------
else:
    $data = $pdo->query("SELECT * FROM sertifikasi ORDER BY id DESC")->fetchAll();
?>
    <div class="page-head">
        <h2>Daftar Sertifikasi</h2>
        <a href="sertifikasi.php?aksi=tambah" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i>Tambah Sertifikasi</a>
    </div>

    <?php if (!$data): ?>
        <div class="card-x"><div class="empty"><i class="bi bi-award"></i>Belum ada data sertifikasi</div></div>
    <?php endif; ?>

    <div class="row g-4">
    <?php foreach ($data as $s): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card-x hover cert-card">
                <?php if ($s['foto']): ?>
                    <img src="uploads/<?= e($s['foto']) ?>" alt="<?= e($s['judul']) ?>" class="cert-thumb">
                <?php else: ?>
                    <div class="cert-thumb cert-thumb-empty"><i class="bi bi-award"></i></div>
                <?php endif; ?>
                <div class="cert-body">
                    <h5><?= e($s['judul']) ?></h5>
                    <p><?= nl2br(e($s['ringkasan'])) ?></p>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <?php if ($s['file_pdf']): ?>
                        <a href="uploads/<?= e($s['file_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-light"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
                    <?php endif; ?>
                    <a href="sertifikasi.php?aksi=edit&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="do" value="hapus">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Yakin ingin menghapus sertifikasi ini?')"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
