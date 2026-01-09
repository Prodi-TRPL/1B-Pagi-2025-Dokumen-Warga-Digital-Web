<?php
// link
include '../config/conn.php';
include ('../config/auth.php');

// err
error_reporting(E_ALL);
ini_set('display_errors', 1);

// validasi login
if (!isset($_SESSION['id_petugas'])) {
  echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location='../login.php';</script>";
  exit();
}

// ambil tanggla dan waktu
date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d h:i:s');

// ambil dari modal alasan untuk table dokumens
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['idSurat'];
  $id_petugas = $_SESSION['id_petugas'];
  $dok = $_POST['nama_dokumen'];
  $status = $_POST['status'];
  $petugas = $_POST['petugas'];
  $alasan = $_POST['alasan'];

  // status DISETUJUI
  if ($status == 'disetujui') {
    $Q_upDok = "UPDATE dokumens set 
      status = 'DISETUJUI', 
      id_petugas = '$id_petugas',
      nama_petugas = '$petugas',
      komentar = '$alasan', pada = NOW()
      where id_surat = $id AND nama_dokumen = '$dok'";
    $cek = mysqli_query($conn, $Q_upDok);
    if ($cek) {
      header('location:../petugas/petugas-pending.php?status=berhasil');
    }

    // status DITOLAK
  } else {
    $Q_upDoks = "UPDATE dokumens set status = 'DITOLAK', id_petugas = $id_petugas, nama_petugas = '$petugas', komentar = '$alasan' ,pada = NOW() where id_surat =  $id AND nama_dokumen = '$dok'";
    $cek = mysqli_query($conn, $Q_upDoks);

    if ($cek) {
      if ($dok == 'SKTM') {
        $query = "DELETE from dokumen_sktm where id_surat = $id";
      } elseif ($dok == 'SKK') {
        $query = "DELETE from dokumen_skk where id_surat = $id";
      } elseif ($dok == 'SRM') {
        $query = "DELETE from dokumen_rumah where id_surat = $id";
      } elseif ($dok == 'SIU') {
        $query = "DELETE from dokumen_izin_usaha where id_surat = $id";
      } else {
        $query = "DELETE from dokumen_domisili where id_surat = $id";
      }

      $sql = mysqli_query($conn, $query);

      header('Location:../petugas/petugas-pending.php?status=tolak');
    }
  }
}
?>