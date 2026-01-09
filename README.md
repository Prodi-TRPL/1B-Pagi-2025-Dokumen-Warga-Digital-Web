# 🏛️ Aplikasi Web Pengajuan Dokumen Warga Digital (PBL-TRPL104-B4)

[![GitHub repo size](https://img.shields.io/github/repo-size/BintangDwiImamDermawan/pbl?color=blue)](https://github.com/BintangDwiImamDermawan/pbl)
[![GitHub contributors](https://img.shields.io/github/contributors/BintangDwiImamDermawan/pbl?color=green)](https://github.com/BintangDwiImamDermawan/pbl)

Aplikasi berbasis web yang dirancang untuk memodernisasi layanan administrasi di tingkat **Kelurahan**. Dengan sistem ini, warga dapat mengajukan beberapa surat keterangan secara daring tanpa perlu mengantre di kantor kelurahan, lebih efektif dan efisien dari segi waktu.

---

## 🌟 Fitur Utama

* **Pengajuan Mandiri:** Warga dapat mengisi formulir dan mengunggah dokumen pendukung secara digital.
* **Jenis Dokumen:** Mendukung berbagai surat keterangan:
    * Surat Keterangan Usaha (SKU)
    * Surat Keterangan Pindah Domisili
    * Surat Keterangan Kepemilikan Rumah
    * Surat Keterangan Kematian
    * Surat Keterangan Tidak Mampu (SKTM)
      
* **Verifikasi Petugas:** Petugas dapat melakukuan pemeriksaan data yang sudah di kirim warga dan melakukan verifikasi.
* **E-Output (PDF):** Setelah dokumen diverifikasi dan disetujui, warga dapat mengunduh dan mencetak dokumen dalam format PDF.

---

## 🛠️ Alur Kerja Sistem

1.  **Input:** Warga memilih jenis surat dan dapat mengisi data serta lampiran dokumen pendukung.
2.  **Review:** Petugas melakukan pengecekan data.
3.  **Approval:** Jika data sesuai, petugas menyetujui pengajuan.
4.  **Output:** Warga mendapatkan akses unduh file PDF yang sudah diproses.

---

## 👥 Anggota Tim PBL-TRPL104-B4
Tim yang telah berkontribusi dalam pengembangan projek ini:

<table align="center">
  <tr>
    <td align="center">
      <a href="https://github.com/BintangDwiImamDermawan">
        <img src="https://github.com/BintangDwiImamDermawan.png" width="100px;" alt="Bintang Dwi Imam Dermawan" title="Bintang Dwi Imam(4342501052)"/><br />
        <sub><b>Bintang Dwi Imam D. (Leader) </b></sub>
      </a>
    </td>
    <td align="center">
        <a href="https://github.com/humayra19">
        <img src="https://github.com/humayra19.png" width="100px;" alt="Devika Humayra" title="Devika Humayra(4342501048)"/><br />
        <sub><b>Devika Humayra (Frontend)</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/fajpras">
        <img src="https://github.com/fajpras.png" width="100px;" alt="Fajpras" title="Fajri Nur P(4342501055)"/><br />
        <sub><b>Fajri (Backend)</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/swandyxtry-glitch">
        <img src="https://github.com/swandyxtry-glitch.png" width="100px;" alt="Swandy" title="Swandy Sianturi(4342501056)"/><br />
        <sub><b>Swandy (UI/UX)</b></sub>
      </a>
    </td>
        <td align="center">
      <a href="https://github.com/achel-silitonga">
        <img src="https://github.com/achel-silitonga.png" width="100px;" alt="Achel" title="Achel Verawati(4342501047)"/><br />
        <sub><b>Achel (Business Analyst)</b></sub>
      </a>
    </td>
  </tr>
</table>

---


## 🛠️ Teknologi yang Digunakan
* **Language:** [PHP, Bootstrap]
* **Database:** [MySQL]

---

## 📊 Status Repositori

| Detail | Status |
| :--- | :--- |
| **Last Commit** | ![GitHub last commit](https://img.shields.io/github/last-commit/BintangDwiImamDermawan/pbl?style=flat-square) |
| **Total Files** | ![GitHub repo size](https://img.shields.io/github/repo-size/BintangDwiImamDermawan/pbl?style=flat-square) |

---


## 🏆 Top Contributors

<a href="https://github.com/BintangDwiImamDermawan/pbl/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=BintangDwiImamDermawan/pbl" />
</a>

---

## ⚙️ Instalasi
1. Clone repositori ini:
   ```bash
   git clone https://github.com/BintangDwiImamDermawan/pbl.git
    ```

2. Buat file koneksi di dalam path:
    ```bash
    buat file dengan nama conn.php 

    /pbl/ 
      └─config/
          └─conn.php
    ```

3. Kode koneksi PHP:
    ```bash
    <?php
    $db = 'pbl';
    $user = 'root';
    $host = 'localhost';
    $pass = '';
    $conn = mysqli_connect($host, $user, $pass, $db);
    ?>
    ```
    >koneksi dapat di sesuaikan dengan db yang ada
   



