<?php 
// error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// link config
include "../config/conn.php";
include "../config/auth.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

  $id = $_SESSION['id_warga'];
  $nik = $_POST['nik'];

  //validasi nik
  $Q_nik = mysqli_query($conn, "SELECT nik from dokumen_skk where nik = $nik");
  if(mysqli_num_rows($Q_nik) > 0 ){
    echo "<script>
      alert('NIK SUDAH TERDAFTAR SEBELUMNYA');
      window.history.back();
    </script>";
    exit;
  }

  

  // Ambil data teks
  $nama = $_POST['nama_lengkap'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $pekerjaan = $_POST['pekerjaan'];
  $alamat = $_POST['alamat'];
  $penyebab = $_POST['penyebab'];
  $tanggal = $_POST['tanggal_kematian'];

  // Konversi file menjadi blob
  $foto_surat_rs = addslashes(file_get_contents($_FILES['surat_rumah_sakit']['tmp_name']));
  $foto_ktp =  addslashes(file_get_contents($_FILES['ktp_pelapor']['tmp_name']));
  $foto_surat_pengantar =  addslashes(file_get_contents($_FILES['surat_pengantar']['tmp_name']));
  $foto_akte_nikah =  addslashes(file_get_contents($_FILES['akte_nikah']['tmp_name'])); 

  // Query insert ke dokumen_skk
  $query = "INSERT INTO `dokumen_skk`( `nik`,`nama_lengkap`, `jenis_kelamin`, 
  `pekerjaan`, `alamat`, `penyebab`, `tanggal_kematian`, `foto_surat_RS`, 
  `foto_ktp_pelapor`, `foto_surat_pengantar`, `foto_akte_nikah`) VALUES ('$nik','$nama',
  '$jenis_kelamin','$pekerjaan','$alamat','$penyebab','$tanggal','$foto_surat_rs',
  '$foto_ktp','$foto_surat_pengantar','$foto_akte_nikah')";

  $sql = mysqli_query($conn, $query);

  if($sql){
    $id_surat = mysqli_insert_id($conn);

    // Masukkan log ke tabel dokumens
    $Q_inDoks = "INSERT INTO `dokumens`( `nama_dokumen`, `id_warga`,`id_surat`, 
    `nama_warga`,`status`) VALUES ('SKK','$id' ,'$id_surat','$nama' ,'PENDING')";
    mysqli_query($conn, $Q_inDoks);
echo "<script>alert('Data Berhasil di simpan'); window.location.href='../warga/riwayat.php'</script>";
    // echo '<meta http-equiv="refresh" content="1; url=../warga/riwayat.php?note=berhasil">';

  } else {
    echo "<script> 
      alert('Data Gagal Disimpan');
      window.history.back();
    </script>";
  }

} else {
    header("Location:../surat/surat-SKK.php");
}
?>