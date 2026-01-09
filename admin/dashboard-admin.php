<?php
//link
include "../config/conn.php";
include "../config/auth.php";

// --- LOGIKA PAGINATION (10 BARIS) ---
$limit = 10; 
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$result_count = mysqli_query($conn, "SELECT count(*) as total FROM dokumens WHERE status='SELESAI' OR status='DITOLAK'");
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_pages = ceil($total_data / $limit);
// ------------------------------------

//notif ok
if (isset($_GET['note'])) {
  echo "<script>alert('Data Berhasil di simpan')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin | AJUK</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/dashboard-admin.css" />

<style>
 .card-table-container {
            background: #e1dfdfff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            border: none;
            margin-top: 20px;
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background-color: #e1dfdfff;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 2px solid #898b8dff;
            border-top: none;
        }

        .table-modern tbody td {
            vertical-align: middle;
            padding: 15px;
            font-size: 0.95rem;
            color: #333;
            border-bottom: 1px solid #a0a0a0ff;
            background-color: #e1e1e1ff !important;
        }
      
        .table-modern tbody tr:hover {
            background-color: #9d9d9dff;
        }

/* ANIMASI STAT CARD TETAP TERJAGA */
.stat-card {
  border: none;
  border-radius: 15px;
  padding: 25px;
  color: white;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease; /* Penting untuk animasi */
  height: 100%;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.bg-gradient-primary {
  background: linear-gradient(45deg, #4e73df, #224abe);
}

.bg-gradient-success {
  background: linear-gradient(45deg, #1cc88a, #13855c);
}

.stat-icon-bg {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 4rem;
  opacity: 0.15;
  color: white;
  transition: all 0.3s ease;
}

.stat-card:hover .stat-icon-bg {
  transform: translateY(-50%) scale(1.1);
}

/* PAGINATION STYLING */
.pagination .page-link {
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #dee2e6;
}
.pagination .page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}
</style>
</head>

<body>

  <div class="container-fluid ">
    <div class="row flex-nowrap ">
      <div class="col-auto px-0 sidebar ">
        <div id="sidebar" class="collapse collapse-horizontal show  ">
          <div class="d-flex container-fluid ">
            <a href="#" class="text-black text-decoration-none">
              <img class="logo p-3" src="../assets/logo.svg" alt="logo" />
            </a>
            <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
              class="border fs-1  p-1 text-decoration-none text-light align-items-center border1"><i
                class="bi bi-x bi-lg py-2 p-1 "></i>
            </a>
          </div>
          <hr />
          <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
            <ul class="nav menu  fw-medium nav-pills flex-column mb-sm-auto mb-0 align-items-sm-start px-3" id="menu">
              <li class="">
                <a href="#" class="nav-link align-middle ">
                  <i class="bi  bi-person"></i>Dashboard
                </a>
              </li>
              <li class="">
                <a href="tambah-petugas.php" class="nav-link align-middle ">
                  <i class="bi  bi-person"></i>Tambah Petugas
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>


      <main class="col p-0 main-cons">
        <header class="topbar">
          <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
            class="border fs-1  p-1 text-decoration-none text-light border1"><i class="bi bi-list bi-lg py-2 p-1 "></i>
          </a>
          <div class="flex-nowrap d-flex">
            <div class="profile mt-1">
              <a class="me-4 d-flex align-items-center text-decoration-none text-light " href="#"> Halo
                <?php echo $_SESSION['nama_admin'] ?><i class="bi bi-person-circle text-light ms-2"></i></a>
            </div>
            <a class=" fs-6 my-2 align-items btn-sm btn btn-danger" href="../config/_close.php"
              onclick="return confirm('Anda Yakin Ingin Keluar')"><i class="bi  bi-box-arrow-right me-1"></i>Keluar</a>
          </div>
        </header>

        <section class="riwayat-section p-4">

          <div class="row mb-4">
            <h2 class="col-md-12 font-weight-bold" style="color: #fff; font-weight:bold;">Dashboard Overview</h2>
          </div>

          <?php
          $totalSurat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(nama_dokumen) as banyakDOK from dokumens where status='SELESAI' or status='DITOLAK'"));
          $totalPET = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(nama_petugas) as banyakPET from petugas"));
          ?>

          <div class="row mb-2">
            <div class="col-md-6 mb-3">
              <div class="stat-card bg-gradient-primary">
                <div class="stat-content">
                  <h5>Total Petugas</h5>
                  <h2><?= $totalPET['banyakPET'] ?></h2>
                </div>
                <div class="stat-icon-bg"><i class="fas fa-users"></i></div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="stat-card bg-gradient-success">
                <div class="stat-content">
                  <h5>Surat Diajukan</h5>
                  <h2><?= $totalSurat['banyakDOK'] ?></h2>
                </div>
                <div class="stat-icon-bg"><i class="fas fa-file-alt"></i></div>
              </div>
            </div>
          </div>

        <div class="row ">
          <h3 class="fw-bold my-3">Surat yang sudah diperiksa</h3>
          <hr style="height:3px; width: 90%; opacity:1; border-top: 0;  background:#838383ff; ">
           <div class="card-table-container">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover">
                              <thead>
                      <tr>
                        <th >No</th>
                        <th>Nama Warga</th>
                        <th>Jenis Dokumen</th>
                        <th>Tanggal Diajukan</th>
                        <th>Status</th>
                        <th>Pada</th>
                        <th>Petugas</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $n = $start + 1;
                      $Q_riwayat = "SELECT *, date_format(tanggal, '%d %M %Y ') as tgl, date_format(pada, '%d-%m-%Y <br>%h:%i:%s') as kpn from dokumens where status='SELESAI' or status='DITOLAK' order by pada DESC LIMIT $start, $limit";
                      $S_riwayat = mysqli_query($conn, $Q_riwayat);

                      if (mysqli_num_rows($S_riwayat) > 0) {
                        while ($row = mysqli_fetch_assoc($S_riwayat)) {
                          if ($row['status'] == 'SELESAI') {
                            $bg = 'bg-success rounded-4 px-2';

                            // selesai
                          } elseif ($row['status'] == 'DITOLAK') {
                            $bg = 'bg-danger rounded-4 px-2';

                       
                          }


                          echo '
                        <tr>
                        <td class="bg-light text-black">' . $n++ . '</td>
                        <td>' . $row['nama_warga'] . '</td>
                        <td>' . $row['nama_dokumen'] . '</td>
                        <td>' . $row['tgl'] . '</td>
                        <td><label class="' . $bg . ' text-white">' . $row['status'] . '</label></td>
                        <td>' . $row['kpn'] . '</td>
                        <td>
                        <div>
                        <i class="bi bi-person-fill"></i> ' . $row['nama_petugas'] . '
                        </div>
                        </td>
                        </tr>';
                        }
                      }
                      ?>
                    </tbody>
                            </table>
                        </div>

                        <nav class="mt-4">
                          <ul class="pagination justify-content-center flex-wrap">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                              <a class="page-link" href="?halaman=<?= $page - 1 ?>">Previous</a>
                            </li>
                            <?php for($x=1; $x<=$total_pages; $x++): ?>
                              <li class="page-item <?= ($page == $x) ? 'active' : '' ?>">
                                <a class="page-link" href="?halaman=<?= $x ?>"><?= $x ?></a>
                              </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                              <a class="page-link" href="?halaman=<?= $page + 1 ?>">Next</a>
                            </li>
                          </ul>
                        </nav>
                    </div>
        </div>
        </section>
        
        <footer class="container-fluid ">
          <p class="text-center text-muted small">AJUK - Copyright © 2025. All rights reserved.</p>
        </footer>
      </main>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>