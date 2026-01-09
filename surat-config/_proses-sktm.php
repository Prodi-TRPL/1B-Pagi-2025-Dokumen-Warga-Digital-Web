<?php
// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// link config
include '../config/conn.php';
include '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_SESSION['id_warga'];
  $nik = $_POST['nik'];

  // validsi nik
  $Q_nik = mysqli_query($conn, "SELECT nik from dokumen_sktm where nik = $nik");
  if (mysqli_num_rows($Q_nik) > 0) {
    echo "<script>
      alert('NIK SUDAH TERDAFTAR SEBELUMNYA');
      window.history.back();
    </script>";
    exit;
  }

  // Ambil data teks
  $nama_lengkap = $_POST['nama_lengkap'];
  $agama = $_POST['agama'];
  $pekerjaan = $_POST['pekerjaan'];
  $alamat = $_POST['alamat'];

  // Baca konten file menjadi blob
  $surat_tidak_mampu = addslashes(file_get_contents($_FILES['surat_tidak_mampu']['tmp_name']));
  $foto_rumah = addslashes(file_get_contents($_FILES['fotorumah']['tmp_name']));
  $foto_kk = addslashes(file_get_contents($_FILES['fotokk']['tmp_name']));
  $foto_slip = addslashes(file_get_contents($_FILES['fotoslip']['tmp_name']));
  $foto_tagihan = addslashes(file_get_contents($_FILES['fototagihan']['tmp_name']));

  // Query insert ke dokumen_sktm
  $query = "INSERT INTO `dokumen_sktm`( `nik`, `nama_lengkap`, `agama`, `pekerjaan`, 
  `alamat`, `foto_persetujuan`, `foto_rumah`, `foto_kk`, `foto_slip_gaji`, 
  `foto_tagihan`) VALUES ('$nik','$nama_lengkap','$agama','$pekerjaan','$alamat',
  '$surat_tidak_mampu','$foto_rumah','$foto_kk','$foto_slip','$foto_tagihan')";

  $sql = mysqli_query($conn, $query);

  if ($sql) {
    $id_surat = mysqli_insert_id($conn);
    // Query insert ke tabel dokumens

    $qry_dokumen = "INSERT INTO `dokumens`( `nama_dokumen`, `id_warga`, `nama_warga`,
     `id_surat`,`status`) VALUES ('SKTM','$id','$nama_lengkap','$id_surat' ,'PENDING')";
    mysqli_query($conn, $qry_dokumen);
echo "<script>alert('Data Berhasil di simpan'); window.location.href='../warga/riwayat.php'</script>";
    // echo '<meta http-equiv="refresh" content="1; url=../warga/riwayat.php?note=berhasil">';
  } else {
    echo "<script> 
      alert('Terjadi kesalahan saat menyimpan data.');
      window.history.back();
    </script>";
  }
} else {
  header('Location:../surat/surat-SKTM.php');
}
?>