<?php
// Koneksi database (SQLite, file dibuat otomatis) + fungsi bantu
session_start();

$pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec("CREATE TABLE IF NOT EXISTS sertifikasi (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    judul TEXT NOT NULL,
    ringkasan TEXT NOT NULL,
    file_pdf TEXT,
    foto TEXT
)");
$pdo->exec("CREATE TABLE IF NOT EXISTS pengalaman (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama_kegiatan TEXT NOT NULL,
    waktu TEXT NOT NULL,
    jabatan TEXT NOT NULL,
    instansi TEXT NOT NULL
)");

if (!is_dir(__DIR__ . '/uploads')) {
    mkdir(__DIR__ . '/uploads', 0777, true);
}

// Escape output
function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Upload file, return nama file baru atau null
function upload($field, $extOk) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $extOk)) {
        return null;
    }
    $nama = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . '/uploads/' . $nama);
    return $nama;
}

function hapusFile($nama) {
    if ($nama && is_file(__DIR__ . '/uploads/' . $nama)) {
        unlink(__DIR__ . '/uploads/' . $nama);
    }
}

function flash($pesan) {
    $_SESSION['flash'] = $pesan;
}
