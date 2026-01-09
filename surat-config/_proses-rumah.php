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

  // validasi nik
  $Q_nik = mysqli_query($conn, "SELECT nik from dokumen_rumah where nik = $nik");
  if (mysqli_num_rows($Q_nik) > 0) {
    echo "<script>
      alert('NIK SUDAH TERDAFTAR SEBELUMNYA');
      window.history.back();
    </script>";
    exit;
  }

  // Jika lolos validasi, ambil data teks
  $nama = $_POST['nama_lengkap'];
  $kecamatan = $_POST['kecamatan'];
  $desa = $_POST['desa'];
  $alamat = $_POST['alamat'];

  // Baca konten file menjadi blob
  $foto_sertifikat = addslashes(file_get_contents($_FILES['foto_sertifikat']['tmp_name']));
  $foto_akta_rumah = addslashes(file_get_contents($_FILES['foto_akta_mendirikan']['tmp_name']));
  $foto_kk = addslashes(file_get_contents($_FILES['foto_kk']['tmp_name']));
  $foto_ktp = addslashes(file_get_contents($_FILES['foto_ktp']['tmp_name']));
  $foto_bppbb = addslashes(file_get_contents($_FILES['foto_BPPBB']['tmp_name']));
  $foto_surat_sengketa = addslashes(file_get_contents($_FILES['foto_surat_tidak_sengketa']['tmp_name']));

  // Query insert ke dokumen_rumah
  $query = "INSERT INTO `dokumen_rumah`( `nik`, `nama_lengkap`, `kecamatan`, `desa`, 
  `alamat`, `foto_sertifikat`, `foto_akta_mendirikan`, `foto_kk`, `foto_ktp`, 
  `foto_BPPBB`, `foto_surat_tidak_sengketa`) VALUES ('$nik','$nama','$kecamatan','$desa',
  '$alamat','$foto_sertifikat','$foto_akta_rumah','$foto_kk','$foto_ktp','$foto_bppbb',
  '$foto_surat_sengketa')";

  $sql = mysqli_query($conn, $query);

  if ($sql) {
    $id_surat = mysqli_insert_id($conn);

    $Q_inDoks = "INSERT INTO `dokumens`( `nama_dokumen`,`id_surat`, `id_warga`, 
    `nama_warga`,`status`) VALUES ('SRM','$id_surat','$id','$nama' ,'PENDING')";
    mysqli_query($conn, $Q_inDoks);
echo "<script>alert('Data Berhasil di simpan'); window.location.href='../warga/riwayat.php'</script>";
    // echo '<meta http-equiv="refresh" content="1; url=../warga/riwayat.php?note=berhasil">';
  } else {
    echo "<script> 
      alert('Terjadi kesalahan saat menyimpan data.');
      window.history.back();
    </script>";
  }
} else {
  header('Location:../surat/surat-rumah.php');
}
?>