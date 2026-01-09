<?php
// link
include '../config/conn.php';
include '../config/auth.php';

// err log
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// notif ok
if (isset($_GET['note'])) {
  echo "<script>alert('Data Berhasil di simpan')</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // ambil dari  form
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $Password = password_hash($password, PASSWORD_DEFAULT);

  // query insert petugas
  $query = "INSERT INTO petugas (nama_petugas, email , password_petugas) values ('$nama','$email','$Password')";
  $insert = mysqli_query($conn, $query);

  // kembali ke halaman back
  if ($insert) {
    header('Refresh:0; url=../admin/tambah-petugas.php');
  } else {
    echo '<script>
            alert("Email sudah terdaftar."); 
            window.location.href="../admin/tambah-petugas.php";
          </script>';
    exit();
  }
}

?>

