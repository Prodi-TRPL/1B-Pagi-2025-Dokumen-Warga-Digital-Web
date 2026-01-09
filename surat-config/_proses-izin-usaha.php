<?php
// error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// link config
include '../config/conn.php';
include '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_SESSION['id_warga'];
  $nik = $_POST['nik'];

  // validasi nik
  $Q_nik = mysqli_query($conn, "SELECT nik from dokumen_izin_usaha where nik = $nik");
  if (mysqli_num_rows($Q_nik) > 0) {
    echo "<script>
      alert('NIK SUDAH TERDAFTAR SEBELUMNYA');
      window.history.back();
    </script>";
    exit;
  }

  // Ambil data form
  $nama = $_POST['nama_lengkap'];
  $nama_kbli = $_POST['nama_kbli'];
  $nomor_kbli = $_POST['nomor_kbli'];
  $kecamatan = $_POST['kecamatan'];
  $desa = $_POST['desa'];
  $alamat = $_POST['alamat'];

  // Baca konten file
  $foto_npwp = addslashes(file_get_contents($_FILES['foto_npwp']['tmp_name']));
  $foto_pengantar = addslashes(file_get_contents($_FILES['foto_pengantar']['tmp_name']));
  $foto_kk = addslashes(file_get_contents($_FILES['foto_kk']['tmp_name']));
  $foto_ktp = addslashes(file_get_contents($_FILES['foto_ktp']['tmp_name']));
  $foto_surat_domisili = addslashes(file_get_contents($_FILES['foto_surat_domisili']['tmp_name']));
  $foto_bukti = addslashes(file_get_contents($_FILES['foto_bukti']['tmp_name']));

  // Query insert
  $query = "INSERT INTO `dokumen_izin_usaha`(`nik`, `nama_lengkap`, `nama_kbli`, 
  `nomor_kbli`, `kecamatan`, `desa`, `alamat`, `foto_npwp`, `foto_pengantar`, `foto_kk`, 
  `foto_ktp`, `foto_surat_domisili`, `foto_bukti`) VALUES ('$nik','$nama','$nama_kbli',
  '$nomor_kbli','$kecamatan','$desa','$alamat','$foto_npwp','$foto_pengantar','$foto_kk',
  '$foto_ktp','$foto_surat_domisili','$foto_bukti')";

  $sql = mysqli_query($conn, $query);

  if ($sql) {
    $id_surat = mysqli_insert_id($conn);

    $Q_inDoks = "INSERT INTO `dokumens`( `nama_dokumen`, `id_warga`, `id_surat`,
    `nama_warga`,`status`) VALUES ('SIU','$id','$id_surat','$nama' ,'PENDING')";
    mysqli_query($conn, $Q_inDoks);
echo "<script>alert('Data Berhasil di simpan'); window.location.href='../warga/riwayat.php'</script>";
    // echo '<meta http-equiv="refresh" content="1; url=../warga/riwayat.php?note=berhasil">';
  } else {
    echo "<script> 
      alert('Data Gagal Disimpan ke Database');
      window.history.back();
    </script>";
  }
} else {
  header('Location:../surat/surat-izin-usaha.php');
}
?>