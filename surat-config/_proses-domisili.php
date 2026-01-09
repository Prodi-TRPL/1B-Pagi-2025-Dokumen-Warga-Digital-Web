<?php
// err
error_reporting(E_ALL);
ini_set('display_errors', 1);

// link
include '../config/conn.php';
include '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_SESSION['id_warga'];
  $nik = $_POST['nik'];

  // alidasi nik
  $Q_nik = mysqli_query($conn, "SELECT nik from dokumen_domisili where nik = $nik");

  if (mysqli_num_rows($Q_nik) > 0) {
    echo "<script>alert('NIK SUDAH TERDAFTAR SEBELUMNYA'); window.location.href = '../surat/surat-domisili.php';</script>";
    exit;
  }

  // Jika lolos validasi, ambil data
  $nama = $_POST['nama_lengkap'];
  $agama = $_POST['agama'];
  $pekerjaan = $_POST['pekerjaan'];
  $alamat = $_POST['alamat'];
  $alamat_pindah = $_POST['alamat_pindah'];
  // Baca konten file
  $foto_surat_pengantar = addslashes(file_get_contents($_FILES['foto_surat_pengantar']['tmp_name']));
  $foto_kk = addslashes(file_get_contents($_FILES['foto_kk']['tmp_name']));
  $foto_pas = addslashes(file_get_contents($_FILES['foto_pas']['tmp_name']));

  // Query insert
  $query = "INSERT INTO `dokumen_domisili`(`nik`, `nama_lengkap`, `agama`, `pekerjaan`, 
  `alamat`,`alamat_pindah`, `foto_surat_pengantar`, `foto_kk`, `foto_pas`) VALUES ('$nik','$nama',
  '$agama','$pekerjaan','$alamat','$alamat_pindah','$foto_surat_pengantar','$foto_kk','$foto_pas')";

  $validasi = mysqli_query($conn, $query);

  // memasukkan data ke tabel dokumens
  if ($validasi) {
    $id_surat = mysqli_insert_id($conn);

    $qry_dokumen =
      "INSERT INTO `dokumens`( `nama_dokumen`, `id_warga`, `nama_warga`,`id_surat`,
    `status`) VALUES ('SDM','$id','$nama','$id_surat' ,'PENDING')";

    mysqli_query($conn, $qry_dokumen);
    echo "<script>alert('Data Berhasil di simpan'); window.location.href='../warga/riwayat.php'</script>";
    // echo '<meta http-equiv="refresh" content="1; url=../warga/riwayat.php?note=berhasil">';
  } else {
    echo "<script>alert('Data Gagal Disimpan'); window.location.href='../surat/surat-domisili.php';</script>";
  }
} else {
  
  header('Location:../surat/surat-domisili.php');
}
?>