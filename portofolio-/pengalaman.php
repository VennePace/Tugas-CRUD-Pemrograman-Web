<?php
require 'db.php';

$aksi = $_GET['aksi'] ?? 'index';
$id   = (int)($_GET['id'] ?? 0);

// ---------- PROSES FORM (POST) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $do = $_POST['do'] ?? '';

    if ($do === 'simpan') {
        $st = $pdo->prepare("INSERT INTO pengalaman (nama_kegiatan, waktu, jabatan, instansi) VALUES (?, ?, ?, ?)");
        $st->execute([trim($_POST['nama_kegiatan']), trim($_POST['waktu']), trim($_POST['jabatan']), trim($_POST['instansi'])]);
        flash('Pengalaman berhasil ditambahkan!');
    }

    if ($do === 'update') {
        $st = $pdo->prepare("UPDATE pengalaman SET nama_kegiatan = ?, waktu = ?, jabatan = ?, instansi = ? WHERE id = ?");
        $st->execute([trim($_POST['nama_kegiatan']), trim($_POST['waktu']), trim($_POST['jabatan']), trim($_POST['instansi']), (int)$_POST['id']]);
        flash('Pengalaman berhasil diperbarui!');
    }

    if ($do === 'hapus') {
        $pdo->prepare("DELETE FROM pengalaman WHERE id = ?")->execute([(int)$_POST['id']]);
        flash('Pengalaman berhasil dihapus!');
    }

    header('Location: pengalaman.php');
    exit;
}

$pageTitle = 'Pengalaman';
include 'header.php';

// ---------- FORM TAMBAH ----------
if ($aksi === 'tambah'): ?>
    <div class="page-head"><h2>Tambah Pengalaman</h2></div>
    <div class="card-x"><form method="POST" class="row g-3">
        <input type="hidden" name="do" value="simpan">
        <div class="col-md-6">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Waktu</label>
            <input type="text" name="waktu" class="form-control" placeholder="contoh: 2022-2023" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jabatan/Role</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Instansi</label>
            <input type="text" name="instansi" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-accent">Simpan</button>
            <a href="pengalaman.php" class="btn btn-ghost">Kembali</a>
        </div>
    </form></div>

<?php
// ---------- FORM EDIT ----------
elseif ($aksi === 'edit'):
    $st = $pdo->prepare("SELECT * FROM pengalaman WHERE id = ?");
    $st->execute([$id]);
    $p = $st->fetch();
    if (!$p) { echo '<div class="alert alert-danger">Data tidak ditemukan.</div>'; include 'footer.php'; exit; }
?>
    <div class="page-head"><h2>Edit Pengalaman</h2></div>
    <div class="card-x"><form method="POST" class="row g-3">
        <input type="hidden" name="do" value="update">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <div class="col-md-6">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" value="<?= e($p['nama_kegiatan']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Waktu</label>
            <input type="text" name="waktu" class="form-control" value="<?= e($p['waktu']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jabatan/Role</label>
            <input type="text" name="jabatan" class="form-control" value="<?= e($p['jabatan']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Instansi</label>
            <input type="text" name="instansi" class="form-control" value="<?= e($p['instansi']) ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-accent">Update</button>
            <a href="pengalaman.php" class="btn btn-ghost">Kembali</a>
        </div>
    </form></div>

<?php
// ---------- DAFTAR ----------
else:
    $data = $pdo->query("SELECT * FROM pengalaman ORDER BY id DESC")->fetchAll();
?>
    <div class="page-head">
        <h2>Daftar Pengalaman</h2>
        <a href="pengalaman.php?aksi=tambah" class="btn btn-accent"><i class="bi bi-plus-lg me-1"></i>Tambah Pengalaman</a>
    </div>

    <div class="table-wrap">
    <div class="table-responsive">
    <table class="table table-x">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Waktu</th>
                <th>Jabatan/Role</th>
                <th>Instansi</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$data): ?>
            <tr><td colspan="5"><div class="empty"><i class="bi bi-briefcase"></i>Belum ada data pengalaman</div></td></tr>
        <?php endif; ?>
        <?php foreach ($data as $p): ?>
            <tr>
                <td class="fw-semibold"><?= e($p['nama_kegiatan']) ?></td>
                <td><span class="chip m-0"><?= e($p['waktu']) ?></span></td>
                <td><?= e($p['jabatan']) ?></td>
                <td><?= e($p['instansi']) ?></td>
                <td class="text-end text-nowrap">
                    <a href="pengalaman.php?aksi=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="do" value="hapus">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Yakin ingin menghapus pengalaman ini?')"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
