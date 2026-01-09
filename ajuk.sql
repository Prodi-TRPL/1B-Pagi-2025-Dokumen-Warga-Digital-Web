SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS = 0;

-- Buat dan Gunakan Database
CREATE DATABASE IF NOT EXISTS `pbl` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `pbl`;

-- --------------------------------------------------------
-- 1. Tabel admin
-- --------------------------------------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email`, `password`) VALUES
(1, 'fajrii', 'admin1@gmail', 'Bangpras.07'),
(2, 'fajri', 'fajri@gmail.com', 'Fajri240'),
(3, 'admin', 'admin@gmail', 'Admin.07');

-- --------------------------------------------------------
-- 2. Tabel warga
-- --------------------------------------------------------
DROP TABLE IF EXISTS `warga`;
CREATE TABLE `warga` (
  `id_warga` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_data_diri` int DEFAULT NULL,
  PRIMARY KEY (`id_warga`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. Tabel petugas
-- --------------------------------------------------------
DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password_petugas` varchar(255) NOT NULL,
  PRIMARY KEY (`id_petugas`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. Tabel data_diri
-- --------------------------------------------------------
DROP TABLE IF EXISTS `data_diri`;
CREATE TABLE `data_diri` (
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `provinsi` varchar(30) NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `kecamatan` varchar(40) NOT NULL,
  `kelurahan` varchar(40) NOT NULL,
  `id_warga` int UNSIGNED NOT NULL,
  PRIMARY KEY (`nik`),
  UNIQUE KEY `id_warga` (`id_warga`),
  CONSTRAINT `fk_data_diri_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. Tabel data_diri_petugas
-- --------------------------------------------------------
DROP TABLE IF EXISTS `data_diri_petugas`;
CREATE TABLE `data_diri_petugas` (
  `id_data_diri` int NOT NULL AUTO_INCREMENT,
  `id_petugas` int NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  PRIMARY KEY (`id_data_diri`),
  CONSTRAINT `fk_diri_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. Tabel dokumens (Utama)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumens`;
CREATE TABLE `dokumens` (
  `id_dokumen` int NOT NULL AUTO_INCREMENT,
  `nama_dokumen` varchar(30) NOT NULL,
  `id_warga` int UNSIGNED NOT NULL,
  `nama_warga` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_surat` int DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `nama_petugas` varchar(50) DEFAULT NULL,
  `komentar` text,
  `pada` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dokumen`),
  CONSTRAINT `fk_dok_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE,
  CONSTRAINT `fk_dok_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. Tabel dokumen_sktm
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumen_sktm`;
CREATE TABLE `dokumen_sktm` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `pekerjaan` varchar(40) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `foto_persetujuan` mediumblob NOT NULL,
  `foto_rumah` mediumblob NOT NULL,
  `foto_kk` mediumblob NOT NULL,
  `foto_slip_gaji` mediumblob NOT NULL,
  `foto_tagihan` mediumblob NOT NULL,
  PRIMARY KEY (`id_surat`),
  CONSTRAINT `fk_sktm_nik` FOREIGN KEY (`nik`) REFERENCES `data_diri` (`nik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 8. Tabel dokumen_skk (Kematian)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumen_skk`;
CREATE TABLE `dokumen_skk` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(30) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `penyebab` varchar(50) NOT NULL,
  `tanggal_kematian` date NOT NULL,
  `foto_surat_RS` mediumblob NOT NULL,
  `foto_ktp_pelapor` mediumblob NOT NULL,
  `foto_surat_pengantar` mediumblob NOT NULL,
  `foto_akte_nikah` mediumblob,
  PRIMARY KEY (`id_surat`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 9. Tabel dokumen_domisili
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumen_domisili`;
CREATE TABLE `dokumen_domisili` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `alamat_pindah` varchar(255) NOT NULL,
  `foto_surat_pengantar` mediumblob NOT NULL,
  `foto_kk` mediumblob NOT NULL,
  `foto_pas` mediumblob,
  PRIMARY KEY (`id_surat`),
  CONSTRAINT `fk_domisili_nik` FOREIGN KEY (`nik`) REFERENCES `data_diri` (`nik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 10. Tabel dokumen_izin_usaha
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumen_izin_usaha`;
CREATE TABLE `dokumen_izin_usaha` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nama_kbli` varchar(255) NOT NULL,
  `nomor_kbli` varchar(30) NOT NULL,
  `kecamatan` varchar(30) NOT NULL,
  `desa` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `foto_npwp` mediumblob NOT NULL,
  `foto_pengantar` mediumblob NOT NULL,
  `foto_kk` mediumblob NOT NULL,
  `foto_ktp` mediumblob NOT NULL,
  `foto_surat_domisili` mediumblob NOT NULL,
  `foto_bukti` mediumblob NOT NULL,
  PRIMARY KEY (`id_surat`),
  CONSTRAINT `fk_usaha_nik` FOREIGN KEY (`nik`) REFERENCES `data_diri` (`nik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 11. Tabel dokumen_rumah
-- --------------------------------------------------------
DROP TABLE IF EXISTS `dokumen_rumah`;
CREATE TABLE `dokumen_rumah` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `desa` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `foto_sertifikat` mediumblob NOT NULL,
  `foto_akta_mendirikan` mediumblob NOT NULL,
  `foto_kk` mediumblob NOT NULL,
  `foto_ktp` mediumblob NOT NULL,
  `foto_BPPBB` mediumblob NOT NULL,
  `foto_surat_tidak_sengketa` mediumblob NOT NULL,
  PRIMARY KEY (`id_surat`),
  CONSTRAINT `fk_rumah_nik` FOREIGN KEY (`nik`) REFERENCES `data_diri` (`nik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Aktifkan kembali pengecekan relasi
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;