<?php
// link
include '../config/conn.php';
include ('../config/auth.php');

// err
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// validasi login
if (!isset($_SESSION['id_petugas'])) {
  echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location='../login.php';</script>";
  exit();
}

if (isset($_GET['id'])) {
  $id_surat = $_GET['id'];
  $nama_dok = $_GET['dok'];
  $id_warga = $_GET['idw'];

  $Q_update = "UPDATE dokumens SET status = 'SELESAI', pada = NOW()  WHERE id_surat = '$id_surat' and nama_dokumen = '$nama_dok' and id_warga ='$id_warga'";

  $S_update = mysqli_query($conn, $Q_update);
  if ($S_update) {
    echo "<script> 
      alert('Surat berhasil dikirim ke Warga!');
      window.location.href = '../petugas/petugas-disetujui.php'; 
      </script>";
  } else {
    echo "<script>
      alert('Gagal mengirim surat.');
      window.history.back();
      </script>";
  }
}
