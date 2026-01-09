<?php

/*
 * INI PROSES DATA DIRI WARGA
 */

// err
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// link
include ('conn.php');
include ('../config/auth.php');

// pastikan login
if (!isset($_SESSION['id_warga'])) {
  header('Location: ../login.php');
  exit();
}

$id_warga = $_SESSION['id_warga'];

// ambil dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // AMBIL DATA
  $nama = $_POST['nama'] ?? '';
  $nik = $_POST['nik'] ?? '';
  $email = $_POST['email'] ?? '';
  $agama = $_POST['agama'] ?? '';
  $tempat_lahir = $_POST['tempat_lahir'] ?? '';
  $ttl = $_POST['ttl'] ?? '';
  $jk = $_POST['jk'] ?? '';
  $pekerjaan = $_POST['pekerjaan'] ?? '';
  $alamat = $_POST['alamat'] ?? '';
  $provinsi = $_POST['provinsi'] ?? '';
  $kota = $_POST['kota'] ?? '';
  $kecamatan = $_POST['kecamatan'] ?? '';
  $kelurahan = $_POST['kelurahan'] ?? '';

  // validasi harus terpenuhi
  $required = [$nama, $nik, $email, $agama, $tempat_lahir, $ttl, $jk, $pekerjaan, $alamat, $provinsi, $kota, $kecamatan, $kelurahan];
  foreach ($required as $item) {
    if ($item === '') {
      die("<script>alert('Semua field wajib diisi!');history.back();</script>");
    }
  }

  // cek status
  $Q = mysqli_query($conn, "SELECT status_data_diri FROM warga WHERE id_warga = $id_warga");
  $R = mysqli_fetch_assoc($Q);
  $isUpdate = ($R['status_data_diri'] == 1);

  // jika ambil data warg
  $oldData = null;
  if ($isUpdate) {
    $Q2 = mysqli_query($conn, "SELECT * FROM data_diri WHERE id_warga = $id_warga");

    $oldData = mysqli_fetch_assoc($Q2);
  }

  // foto logic
  $file_name = $oldData['foto_profil'] ?? null;  
  if (!empty($_FILES['profil']['name'])) {
    $file_tmp = $_FILES['profil']['tmp_name'];
    $file_size = $_FILES['profil']['size'];
    $ext = pathinfo($_FILES['profil']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    // Validasi 1MB
    if ($file_size > 1048576) {
      die("<script>alert('Gagal! Foto maksimal 1 MB');history.back();</script>");
    }

    if (!in_array(strtolower($ext), $allowed)) {
      die("<script>alert('Format foto tidak valid!');history.back();</script>");
    }

    // menggunakan NIk untuk sebagau nama dari nama foto
    $file_name = $nik . '_' . time() . '.' . $ext;
    $upload_dir = '../uploads/' . $file_name;

    // Proses pindah file ke lokal
    if (move_uploaded_file($file_tmp, $upload_dir)) {
      // Hapus foto lama jika ada (opsional agar tidak memenuhi memori laptop kentang)
      if (!empty($oldData['foto_profil']) && file_exists('../uploads/' . $oldData['foto_profil'])) {
        unlink('../uploads/' . $oldData['foto_profil']);
      }
    } else {
      die("<script>alert('Gagal mengunggah foto ke folder!');history.back();</script>");
    }
  }

  // isi dara langsung
  if (!$isUpdate) {
    $cekknik = mysqli_query($conn, "SELECT nik FROM data_diri WHERE nik = '$nik'");
    if (mysqli_num_rows($cekknik) > 0) {
      echo "<script>
        alert('NIK sudah terdaftar!');
        history.back();
                  </script>";
    } else {
      $sql = "INSERT INTO data_diri 
      (nama_lengkap, 
      foto_profil, nik, email, agama, tempat_lahir, tanggal_lahir, jenis_kelamin, 
      pekerjaan, alamat, provinsi, kabupaten, kecamatan, kelurahan, id_warga) 
      VALUES 
      ('$nama', '$file_name', '$nik', '$email', '$agama', '$tempat_lahir', '$ttl', '$jk', 
      '$pekerjaan', '$alamat', '$provinsi', '$kota', '$kecamatan', '$kelurahan', 
      '$id_warga')";

      $insert = mysqli_query($conn, $sql);
    }

    if ($insert) {
      // update status_data_diri
      mysqli_query($conn, "UPDATE warga SET status_data_diri = 1 WHERE id_warga = $id_warga");

      echo "<script>
        alert('Data berhasil ditambahkan!');
        window.location.href = '../warga/riwayat.php';
                  </script>";
    } else {
      echo "<script>
        alert('Data Tidak Dapat ditambahkan!');
        history.back();
                  </script>";
    }
  }
  // update data
  else {
    $Q_upData = "UPDATE data_diri SET
            nama_lengkap   = '$nama',
            foto_profil    = '$file_name',
            nik            = '$nik',
            email          = '$email',
            agama          = '$agama',
            tempat_lahir   = '$tempat_lahir',
            tanggal_lahir  = '$ttl',
            jenis_kelamin  = '$jk',
            pekerjaan      = '$pekerjaan',
            alamat         = '$alamat',
            provinsi       = '$provinsi',
            kabupaten      = '$kota',
            kecamatan      = '$kecamatan',
            kelurahan      = '$kelurahan'
            WHERE id_warga = '$id_warga'";

    $update = mysqli_query($conn, $Q_upData);

    if ($update) {
      echo "<script>
              alert('Data berhasil diperbarui!');
              window.location.href = '../warga/riwayat.php';
            </script>";
    } else {
      echo "<script>
              alert('Data Tidak Dapat Dibarui');
              history.back();
            </script>";
    }
  }
}
