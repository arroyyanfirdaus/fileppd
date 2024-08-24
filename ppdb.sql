-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2024 at 03:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_admin`
--

CREATE TABLE `data_admin` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_admin`
--

INSERT INTO `data_admin` (`id`, `nama`, `email`, `password`) VALUES
(27, '', 'admin@admin.com', '$2y$10$ZRpgmf6IA3MhGXmJzLDBwO2MdsTrKmhKC4l7Wu86dow6vsl58rNqu');

-- --------------------------------------------------------

--
-- Table structure for table `data_berkas`
--

CREATE TABLE `data_berkas` (
  `id` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `foto_kk_ktp_akta_kelahiran` varchar(1000) NOT NULL,
  `foto_pkh_kis_kks` varchar(1000) NOT NULL,
  `foto_rapor` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_berkas`
--

INSERT INTO `data_berkas` (`id`, `id_siswa`, `foto_kk_ktp_akta_kelahiran`, `foto_pkh_kis_kks`, `foto_rapor`) VALUES
(4, 16, '1719649702_IMG_0543.JPEG', '1719649702_KIS Prasetyono Putra.pdf', '1719649702_test.pdf'),
(5, 17, '1720098143_14. SKRIPSI - FINAL.pdf', '1720098143_sertifikat.pdf', '1720098143_129-File Utama Naskah-542-1-10-20220826.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `data_orang_tua`
--

CREATE TABLE `data_orang_tua` (
  `id` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL,
  `no_telepon_ortu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_orang_tua`
--

INSERT INTO `data_orang_tua` (`id`, `id_siswa`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_telepon_ortu`) VALUES
(6, 16, 'Bapa', 'main', 'ibu', 'masak', '082121403000'),
(7, 17, 'asd', 'fgh', 'qwe', 'vbn', '45423');

-- --------------------------------------------------------

--
-- Table structure for table `data_prodi`
--

CREATE TABLE `data_prodi` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_prodi`
--

INSERT INTO `data_prodi` (`id`, `nama`) VALUES
(1, 'Desain Permodelan & Informasi Bangunan'),
(2, 'Teknik Komputer & Jaringan'),
(3, 'Tata Busana');

-- --------------------------------------------------------

--
-- Table structure for table `data_siswa`
--

CREATE TABLE `data_siswa` (
  `id` bigint(20) NOT NULL,
  `nisn` varchar(50) NOT NULL,
  `nama_siswa` varchar(500) NOT NULL,
  `nik` decimal(10,0) DEFAULT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `tempat_lahir` varchar(500) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` varchar(50) NOT NULL,
  `golongan_darah` varchar(3) DEFAULT NULL,
  `alamat` varchar(1000) NOT NULL,
  `email_siswa` varchar(500) DEFAULT NULL,
  `rumah_milik` varchar(500) DEFAULT NULL,
  `no_telp_rumah` decimal(10,0) DEFAULT NULL,
  `no_telp_siswa` decimal(10,0) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `alamat_asal_sekolah` varchar(500) DEFAULT NULL,
  `jurusan` bigint(20) NOT NULL,
  `prestasi` varchar(1000) DEFAULT NULL,
  `hobi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_siswa`
--

INSERT INTO `data_siswa` (`id`, `nisn`, `nama_siswa`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `agama`, `golongan_darah`, `alamat`, `email_siswa`, `rumah_milik`, `no_telp_rumah`, `no_telp_siswa`, `asal_sekolah`, `alamat_asal_sekolah`, `jurusan`, `prestasi`, `hobi`) VALUES
(16, '20411323', 'Tyo', 1231412, 'Laki-laki', 'Zimbabwe', '2024-06-13', 'Islam', 'B', 'Bandung RR', 'prasetyonoptr@gmail.com', 'Orang Tua', 123, 123, 'SMKN 6 Bandung', 'GEDEBAGE', 2, 'waduhh', 'Makan'),
(17, '412321', 'Tyoooooo', 312321, 'Perempuan', '12312', '2024-07-18', 'Katolik', 'AB', 'dwadwa', 'dwa@gawaw.com', 'Kost', 1231, 1231, '12322', 'VVWW', 2, 'AWdsw', 'GFDSWE');

-- --------------------------------------------------------

--
-- Table structure for table `data_wali`
--

CREATE TABLE `data_wali` (
  `id` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `nama_wali` varchar(100) NOT NULL,
  `pekerjaan_wali` varchar(100) NOT NULL,
  `alamat_wali` varchar(500) NOT NULL,
  `no_telepon_wali` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_wali`
--

INSERT INTO `data_wali` (`id`, `id_siswa`, `nama_wali`, `pekerjaan_wali`, `alamat_wali`, `no_telepon_wali`) VALUES
(6, 16, '', '', '', ''),
(7, 17, 'wadw', 'dwa', '213', '213');

-- --------------------------------------------------------

--
-- Table structure for table `status_pendaftaran`
--

CREATE TABLE `status_pendaftaran` (
  `id` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `catatan_panitia` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pendaftaran`
--

INSERT INTO `status_pendaftaran` (`id`, `id_siswa`, `status`, `catatan_panitia`) VALUES
(5, 16, 'Ditolak', 'Bagus'),
(6, 17, 'Menunggu', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_berkas`
--
ALTER TABLE `data_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `data_orang_tua`
--
ALTER TABLE `data_orang_tua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `data_prodi`
--
ALTER TABLE `data_prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan` (`jurusan`);

--
-- Indexes for table `data_wali`
--
ALTER TABLE `data_wali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `status_pendaftaran`
--
ALTER TABLE `status_pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_admin`
--
ALTER TABLE `data_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `data_berkas`
--
ALTER TABLE `data_berkas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_orang_tua`
--
ALTER TABLE `data_orang_tua`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_prodi`
--
ALTER TABLE `data_prodi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_siswa`
--
ALTER TABLE `data_siswa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `data_wali`
--
ALTER TABLE `data_wali`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status_pendaftaran`
--
ALTER TABLE `status_pendaftaran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_berkas`
--
ALTER TABLE `data_berkas`
  ADD CONSTRAINT `data_berkas_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_orang_tua`
--
ALTER TABLE `data_orang_tua`
  ADD CONSTRAINT `data_orang_tua_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD CONSTRAINT `data_siswa_ibfk_1` FOREIGN KEY (`jurusan`) REFERENCES `data_prodi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_wali`
--
ALTER TABLE `data_wali`
  ADD CONSTRAINT `data_wali_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `status_pendaftaran`
--
ALTER TABLE `status_pendaftaran`
  ADD CONSTRAINT `status_pendaftaran_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
