<?php
// Data profil terpusat: ubah di sini, otomatis berubah di semua halaman.
$profil = [
    'nama'      => 'Faisha Ramdani',
    'nim'       => '152025095',
    'email'     => 'faisha.ramdani@mhs.itenas.ac.id',
    'jurusan'   => 'Informatika',
    'kampus'    => 'ITENAS Bandung',
    'tagline'   => 'Content Creator • Gaming Otomotif & Simulasi Balap',
    'pengalaman' => 'Saya aktif dalam bidang content creation dan digital media, dengan fokus utama pada pembuat konten gaming bertema otomotif dan simulasi balap. Saya berpengalaman mengelola channel YouTube untuk kegiatan livestreaming, melakukan editing video secara mandiri, serta membangun engagement bersama komunitas penonton. Selain itu, saya terbiasa memproses konten visual, mengkonfigurasi perangkat streaming, dan mengeksplorasi berbagai judul game balap maupun proyek kreatif digital lainnya secara konsisten.',
    'keahlian'  => ['Content Creation', 'Livestreaming YouTube', 'Video Editing', 'Community Engagement', 'Konfigurasi Perangkat Streaming', 'Game Balap & Simulasi'],
];

function inisial($nama) {
    $p = preg_split('/\s+/', trim($nama));
    $i = '';
    foreach (array_slice($p, 0, 2) as $kata) { $i .= mb_strtoupper(mb_substr($kata, 0, 1)); }
    return $i;
}

// Avatar: pakai images/foto-profil.png jika ada, kalau tidak tampil inisial
function avatar($ukuran = 160) {
    global $profil;
    $ada = is_file(__DIR__ . '/images/foto-profil.png');
    $html  = '<div class="avatar" style="--size:' . (int)$ukuran . 'px">';
    $html .= '<span class="avatar-initial">' . e(inisial($profil['nama'])) . '</span>';
    if ($ada) { $html .= '<img src="images/foto-profil.png" alt="Foto ' . e($profil['nama']) . '">'; }
    return $html . '</div>';
}
