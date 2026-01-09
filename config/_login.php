<?php

// link
include ('conn.php');

// err
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

// ambil form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ambil
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // cek admin
  $QcekAdmin = "SELECT * from admin where email = '$email'";
  $cekAdmin = mysqli_query($conn, $QcekAdmin);

  // cek petugas
  $QcekPetugas = "  SELECT * FROM petugas  WHERE email = '$email'";
  $cekPetugas = mysqli_query($conn, $QcekPetugas);

  // warga
  $QcekWarga = "SELECT * FROM warga  WHERE email = '$email' ";
  $cekWarga = mysqli_query($conn, $QcekWarga);

  // validasi email belum ada
  if (mysqli_num_rows($cekAdmin) == 0 && mysqli_num_rows($cekPetugas) == 0 && mysqli_num_rows($cekWarga) == 0) {
    echo '<script>
            alert("Email tidak di temukan."); 
            window.location.href="../daftar.php";
          </script>';
    exit();
  }

  // cek email petuggas
  if (mysqli_num_rows($cekPetugas) > 0) {
    $dataPetugas = mysqli_fetch_assoc($cekPetugas);

    // jika petugas cek pass
    if (password_verify($password, $dataPetugas['password_petugas'])) {
      $_SESSION['id_petugas'] = $dataPetugas['id_petugas'];
      $_SESSION['nama_petugas'] = $dataPetugas['nama_petugas'];
      $_SESSION['email'] = $dataPetugas['email'];

      // ambil nama dari database unutk alert
      $user = $dataPetugas['nama_petugas'];
      echo "<script>
      alert('Selamat datang $user')
      window.location.href = ' ../petugas/petugas-pending.php';</script>";
      exit();

      // jika tidak
    } else {
      $errpass = 'Password anda salah';
      header('Location:../login.php?errpass=' . urlencode($errpass));
    }

    // cek email warga
  } elseif (mysqli_num_rows($cekWarga) > 0) {
    // jika email warga
      $dataWarga = mysqli_fetch_assoc($cekWarga);

      // cek pass
      if (password_verify($password, $dataWarga['password'])) {
        $_SESSION['id_warga'] = $dataWarga['id_warga'];
        $_SESSION['nama'] = $dataWarga['nama'];
        $_SESSION['email'] = $dataWarga['email'];
        $_SESSION['status'] = $dataWarga['status_data_diri'];

        // ambil nama unutk alert
        $user = $dataWarga['nama'];
        echo "<script>
        alert('Selamat datang $user');
        window.location.href = ' ../dashboard.php';</script>";
        exit();

        // jika tidak
      } else {
        $errpass = 'Password anda salah';
        header('Location:../login.php?errpass=' . urlencode($errpass));
      }

    // cek email petugas
  } elseif (mysqli_num_rows($cekAdmin) === 1) {
    $dataAdmin = mysqli_fetch_assoc($cekAdmin);

    // cek pass
    if ($password == $dataAdmin['password']) {
      $_SESSION['id_admin'] = $dataAdmin['id_admin'];
      $_SESSION['nama_admin'] = $dataAdmin['nama_admin'];
      $_SESSION['email'] = $dataAdmin['email'];

      // ambil nama unutk alert
      $user = $dataAdmin['nama_admin'];
      echo "<script>
      alert('Selamat datang $user');
      window.location.href = ' ../admin/dashboard-admin.php';</script>";
      exit();

      // jika tidak
    } else {
      $errpass = 'Password anda salah';
      header('Location:../login.php?errpass=' . urlencode($errpass));
    }

    // email belum terdaftar
  } else {
    $erremail = 'Email yang anda masukkan tidak valid  ';
    header('Location:../login.php?email_eror=' . urlencode($erremail));
  }
}
?>
