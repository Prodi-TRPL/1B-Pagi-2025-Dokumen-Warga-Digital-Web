<?php
// --- CONFIG & AUTH ---
include '../config/conn.php';
include ('../config/auth.php');

// Error Reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Validasi Login
if (!isset($_SESSION['id_petugas'])) {
  echo "<script>alert('Anda tidak memiliki akses!'); window.close();</script>";
  exit();
}

// Ambil parameter
$id = $_GET['id'];
$dok = $_GET['dok'];
$apa = $_GET['a'];

// Validasi Parameter Kosong
if ($id == 0 || empty($dok) || empty($apa)) {
  die('Parameter URL tidak lengkap.');
}

// ini untuk pemilihan jenis  surat
// kodi ini  merupakan penenetuan  jenis foto

// 1. SKTM
if ($dok == 'SKTM') {
  $tabel = 'dokumen_sktm';
  $kolom = match ($apa) {
    'fsp' => 'foto_persetujuan',
    'fr' => 'foto_rumah',
    'fkk' => 'foto_kk',
    'fsg' => 'foto_slip_gaji',
    default => 'foto_tagihan'
  };

  // 2. SURAT KEMATIAN
} elseif ($dok == 'SKK') {
  $tabel = 'dokumen_skk';
  $kolom = match ($apa) {
    'fsrs' => 'foto_surat_RS',
    'fkp' => 'foto_ktp_pelapor',
    'fsp' => 'foto_surat_pengantar',
    default => 'foto_akte_nikah',
  };

  // 3. SURAT RUMAH
} elseif ($dok == 'SRM') {
  $tabel = 'dokumen_rumah';
  $kolom = match ($apa) {
    'fs' => 'foto_sertifikat',
    'fam' => 'foto_akta_mendirikan',
    'fkk' => 'foto_kk',
    'fktp' => 'foto_ktp',
    'fbp' => 'foto_BPPBB',
    'fsts' => 'foto_surat_tidak_sengketa',
    default => 'foto_surat_tidak_sengketa',
  };

  // 4. SURAT IZIN USAHA
} elseif ($dok == 'SIU') {
  $tabel = 'dokumen_izin_usaha';
  $kolom = match ($apa) {
    'fnpwp' => 'foto_npwp',
    'fsp' => 'foto_pengantar',
    'fkk' => 'foto_kk',
    'fktp' => 'foto_ktp',
    'fsd' => 'foto_surat_domisili',
    'fpbb' => 'foto_bukti',
    default => 'foto_surat_domisili',
  };

  // 5. SURAT DOMISILI (Default)
} else {
  $tabel = 'dokumen_domisili';
  $kolom = match ($apa) {
    'fsp' => 'foto_surat_pengantar',
    'fp' => 'foto_pas',
    default => 'foto_kk',
  };
}

// ambil foto dari database
$query = "SELECT `$kolom` FROM `$tabel` WHERE id_surat = $id LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek Data
if (!$data || empty($data[$kolom])) {
  die("<h3 style='text-align:center; margin-top:50px;'>File/Foto belum diunggah atau data kosong.</h3>");
}

// ambil data blob mentah
$blobData = $data[$kolom];

// ini unutk xcek tipe file apa yang di upload dari binary foto
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->buffer($blobData);

// proses encode dari binar agar bisa di tampilkan
$base64 = base64_encode($blobData);
$src = "data:$mimeType;base64,$base64";

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lihat Dokumen</title>
  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      background-color: #525659;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      box-sizing: border-box;
    }

    img {
      max-width: 100%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
      border-radius: 4px;
    }

    .pdf-container {
      width: 100%;
      height: 100vh;
    }
  </style>
</head>

<body>
    <!-- jika mime foto pdf -->
  <?php if ($mimeType === 'application/pdf'): ?>
    <div class="pdf-container">
      <embed src="<?= $src ?>" type="application/pdf" width="100%" height="100%">
    </div>

  <?php else: ?>
    <div class="container">
      <img src="<?= $src ?>" alt="Dokumen Warga">
    </div>

  <?php endif; ?>

</body>

</html>