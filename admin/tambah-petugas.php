<?php
//link
include "../config/conn.php";
include "../config/auth.php";

//err log
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//notif ok
if (isset($_GET['note']) && $_GET['note'] === "success") {
     echo "<script>alert('Data Berhasil di simpan')</script>";
}

$id = $_SESSION['id_admin'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Tambah Petugas | AJUK</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard-admin.css" />

    <style>
        .riwayat-section{
            height:120vh !important;
        }

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

        /* Button Add New */
        .btn-add-custom {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
            transition: all 0.3s ease;
        }

        .btn-add-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(13, 110, 253, 0.3);
            color: white;
        }

        .swal-dark-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
            text-align: left;
        }

        .swal-label {
            color: #adb5bd;
            font-size: 0.85rem;
            margin-bottom: 5px;
            display: block;
        }

        .swal-input-custom {
            background-color: #45474d !important;
            border: 1px solid #5a5c63 !important;
            color: #fff !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
            font-size: 1rem !important;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .swal-input-custom:focus {
            border-color: #0d6efd !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }
    </style>

</head>

<body>

    <div class="container-fluid">
        <div class="row flex-nowrap">

            <div class="col-auto px-0 sidebar">
                <div id="sidebar" class="collapse collapse-horizontal show">
                    <div class="d-flex container-fluid">
                        <a href="#" class="text-black text-decoration-none">
                            <img class="logo p-3" src="../assets/logo.svg" alt="logo" />
                        </a>
                        <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
                            class="border fs-1  p-1 text-decoration-none text-light align-items-center border1"><i class="bi bi-x bi-lg py-2 p-1 "></i>
                        </a>
                    </div>

                    <hr />
                    <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
                        <ul class="nav menu  fw-medium nav-pills flex-column mb-sm-auto mb-0 align-items-sm-start px-3"
                            id="menu">
                            <li class="">
                                <a href="dashboard-admin.php" class="nav-link align-middle ">
                                    <i class="bi  bi-person"></i>Dashboard
                                </a>
                            </li>
                            <li class="">
                                <a href="#" class="nav-link align-middle ">
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

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="fw-bold m-0" style="color: #fff;">Manajemen Petugas</h2>

                        <button class="btn-add-custom" type="button" onclick="openPetugasModal()">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Petugas
                        </button>
                    </div>

                    <div class="card-table-container">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">NO</th>
                                        <th scope="col">Nama Petugas</th>
                                        <th scope="col">Email Petugas</th>
                                        <th scope="col" width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                    //guna ini membuat list tabel dari tabel petugas 
                                    $F_riwatat = mysqli_query($conn, "select * from petugas order by id_petugas DESC");

                                    //membuat looping dari tabel
                                    if (mysqli_num_rows($F_riwatat) > 0) {
                                        while ($row = mysqli_fetch_assoc($F_riwatat)) {
                                            $idP = $row['id_petugas'];
                                            $F_data_diri = mysqli_query($conn, "select id_petugas from data_diri_petugas where id_petugas =$idP");

                                            //mematikan dan menghidupkan btn 
                                            if (mysqli_num_rows($F_data_diri) > 0) {
                                                $dis = "disabled";
                                                $btnClass = "btn-secondary";
                                                $icon = "bi-check-circle-fill";
                                            } else {
                                                $dis = "";
                                                $btnClass = "btn-outline-primary"; // Lebih bersih
                                                $icon = "bi-pencil-square";
                                            }

                                            //menampilkan data
                                            echo '
                                            <tr>
                                                <td class="text-center text-muted fw-bold">' . $n++ . '</td>
                                                <td class="fw-bold text-dark">' . $row['nama_petugas'] . '</td>
                                                <td class="text-muted"> ' . $row['email'] . ' </td>
                                                <td>
                                                    <form id="formAlasan_' . $row['id_petugas'] . '" action="../admin-config/_tambah-data-petugas.php" method="POST">
                                                        <input type="hidden" name="nama" id="hidden_nama_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="email" id="hidden_email_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="hp" id="hidden_hp_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="tl" id="hidden_tl_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="tgl" id="hidden_tgl_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="jk" id="hidden_jk_' . $row['id_petugas'] . '">
                                                        <input type="hidden" name="id_petugas" value="' . $row['id_petugas'] . '">

                                                        <button ' . $dis . ' type="button" 
                                                            onclick="isiDataDiri(' . $row['id_petugas'] . ')" 
                                                            class="btn ' . $btnClass . ' btn-sm w-100 rounded-pill">
                                                            <i class="' . $icon . ' me-1"></i> Isi Profil
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data petugas</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                <footer class="container-fluid  text-center text-muted small">
                    <p class="m-0">AJUK - Copyright © 2025. All rights reserved.</p>
                </footer>
            </main>
        </div>

    </div>

</body>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Modal Tambah Petugas (Dark Modern)
    function openPetugasModal() {
        Swal.fire({
            title: 'Tambah Petugas Baru',
            width: '500px',
            padding: '2rem',
            background: '#37383b', // Tema Gelap sesuai kode asli
            color: '#f0f0f0',

            // HTML Custom yang lebih rapi
            html: `
            <div class="swal-dark-container">
                <div>
                    <input id="nama" class="swal-input-custom" placeholder="Nama Lengkap">
                </div>
                <div>
                    <input id="email" class="swal-input-custom" placeholder="Alamat Email" type="email">
                </div>
                <div>
                    <input id="password" class="swal-input-custom" placeholder="Password Login" type="password">
                </div>
            </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan Data',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#d33',
            focusConfirm: false,
            preConfirm: () => {
                const nama = document.getElementById('nama').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!nama || !email || !password) {
                    Swal.showValidationMessage("Semua kolom harus diisi!");
                    return false;
                }

                return fetch("../admin-config/_tambah-petugas.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `nama=${encodeURIComponent(nama)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data petugas telah ditambahkan.',
                    background: '#37383b',
                    color: '#fff',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    }


    function isiDataDiri(id) {
        Swal.fire({
            title: "Lengkapi Data Diri",
            width: "650px",
            background: "#2f3033",
            color: "#efefef",

            html: `
            <div class="swal-dark-container">
                
                <div>
                    <label class="swal-label">Nama Lengkap</label>
                    <input id="nama_lengkap" class="swal-input-custom" placeholder="Sesuai KTP">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="swal-label">Nomor HP</label>
                        <input id="no_hp" type="number" class="swal-input-custom" placeholder="08...">
                    </div>
                    <div>
                        <label class="swal-label">Email Pribadi</label>
                        <input id="email_pribadi" type="email" class="swal-input-custom" placeholder="email@gmail.com">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="swal-label">Tempat Lahir</label>
                        <input id="tempat_lahir" class="swal-input-custom">
                    </div>
                    <div>
                        <label class="swal-label">Tanggal Lahir</label>
                        <input id="tanggal_lahir" type="date" class="swal-input-custom">
                    </div>
                </div>

                <div>
                    <label class="swal-label">Jenis Kelamin</label>
                    <select id="jenis_kelamin" class="swal-input-custom">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

            </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Simpan Profil",
            cancelButtonText: "Batal",
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#d33',

            preConfirm: () => {
                const nama = document.getElementById("nama_lengkap").value;
                const hp = document.getElementById("no_hp").value;
                const email = document.getElementById("email_pribadi").value;
                const tl = document.getElementById("tempat_lahir").value;
                const tgl = document.getElementById("tanggal_lahir").value;
                const jk = document.getElementById("jenis_kelamin").value;

                if (!nama || !hp || !email || !tl || !tgl || !jk) {
                    Swal.showValidationMessage("Harap lengkapi semua data!");
                    return false;
                }

                return {
                    nama,
                    hp,
                    email,
                    tl,
                    tgl,
                    jk
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const data = result.value;

                // MENGGUNAKAN ID UNIK (Penting agar tidak tertukar datanya)
                const f = document.getElementById("formAlasan_" + id);

                document.getElementById("hidden_nama_" + id).value = data.nama;
                document.getElementById("hidden_hp_" + id).value = data.hp;
                document.getElementById("hidden_email_" + id).value = data.email;
                document.getElementById("hidden_tl_" + id).value = data.tl;
                document.getElementById("hidden_tgl_" + id).value = data.tgl;
                document.getElementById("hidden_jk_" + id).value = data.jk;

                f.submit();

                Swal.fire({
                    icon: "success",
                    title: "Tersimpan!",
                    text: "Profil petugas berhasil diperbarui.",
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#2f3033',
                    color: '#fff'
                })
            }
        });
    }
</script>

</html>