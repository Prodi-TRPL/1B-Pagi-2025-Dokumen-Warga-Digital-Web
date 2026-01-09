<?php
//link
include "../config/conn.php";
include "../config/auth.php";

//err log
// error_reporting(E_ALL);
// ini_set('display_errors', 3);

//notif ok
if (isset($_GET['note'])) {
  echo "<script>alert('Data Berhasil di simpan')</script>";
}


//ambil POST dari hiden input
$id = $_POST['id_petugas'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$tl = $_POST['tl'];
$tgl = $_POST['tgl'];
$jk = $_POST['jk'];
$hp = $_POST['hp'];

//insert data data_diri_petugas
$query = "INSERT INTO data_diri_petugas (id_petugas, nama_lengkap, nomor, email, tempat_lahir, tanggal_lahir, jenis_kelamin)VALUES($id, '$nama', '$hp', '$email', '$tl', '$tgl', '$jk')";
$insert = mysqli_query($conn, $query);

//jika oke ke back dengan refresh
if ($insert) {
  header("Refresh:0; url=../admin/tambah-petugas.php?note=success");
}
?>
