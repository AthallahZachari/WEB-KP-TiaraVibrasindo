-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 02:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiara_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `nip` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `admin_name`, `nip`, `password`, `gender`, `role`) VALUES
(1, 'admin', 1234, 'password', 'pria', 'admin'),
(2, 'Michael Schumacher', 7201, 'michael', 'pria', 'employee'),
(3, 'David Coulthard', 2201, 'hubi', 'pria', 'employee'),
(4, 'Madison Beer', 6661, 'madzbeer', 'wanita', 'employee'),
(5, 'Athallah Zachari', 94, 'password', 'pria', 'student'),
(8, 'Siswa1', 1111, '&xd6Yf2i', 'pria', 'student'),
(9, 'Siswa2', 1112, 'jh0VZ1DA', 'wanita', 'student'),
(10, 'Siswa3', 1113, 'W3NmKk2l', 'wanita', 'student'),
(11, 'Siswa4', 1114, 'sisfour', 'wanita', 'student'),
(12, 'Siswa5', 1115, 'sisfive', 'pria', 'student'),
(14, 'Vettel', 4411, '&qn%RW(3', 'pria', 'employee'),
(15, 'Keichi Tsuchiya', 1999, 'U%SMkGyZ', 'pria', 'employee'),
(16, 'Mika Hakkinen', 9911, 'hjkly(ro', 'pria', 'employee'),
(17, 'Nobuhiro', 5555, 'nobunobu', 'pria', 'employee'),
(18, 'Bagong', 2266, '*ya)(tAE', 'pria', 'employee'),
(19, 'Brian', 1212, '4oI(sbNB', 'pria', 'student'),
(20, 'Diesel', 1997, 'qJBsum$9', 'pria', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `status` enum('present','absent') DEFAULT 'absent',
  `time` time NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `class_id`, `status`, `time`, `created_at`) VALUES
(1, 5, 41, 'present', '17:03:22', '2024-10-11 02:04:27'),
(2, 8, 41, 'present', '20:17:45', '2024-10-20 03:04:10'),
(3, 9, 41, 'absent', '20:17:45', '2024-10-20 03:04:10'),
(4, 12, 41, 'present', '20:17:45', '2024-10-20 03:06:47'),
(5, 5, 1, 'present', '17:02:55', '2025-02-03 08:34:56'),
(6, 5, 2, 'present', '00:00:00', '2025-02-03 08:36:57'),
(12, 5, 8, 'present', '20:16:45', '2025-02-03 10:07:24'),
(13, 12, 1, 'present', '20:34:50', '2025-02-03 13:23:19'),
(14, 12, 2, 'absent', '20:32:50', '2025-02-03 13:33:05'),
(15, 12, 5, 'absent', '20:33:36', '2025-02-03 13:33:51'),
(16, 12, 8, 'absent', '20:34:07', '2025-02-03 13:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id_class` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `pengajar` int(11) NOT NULL,
  `materi` int(11) NOT NULL,
  `ruangan` varchar(30) NOT NULL,
  `durasi` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id_class`, `nama_kelas`, `pengajar`, `materi`, `ruangan`, `durasi`, `tanggal`, `jam`) VALUES
(1, 'How to Cut Corner', 2, 1, 'SINI AJA', 70, '2024-08-25', '09:00:00'),
(2, 'Hairpin', 3, 3, 'Monaco', 90, '2024-08-28', '10:00:00'),
(5, 'Matriks dan Vektor', 14, 4, 'FRANCORCHAMP', 60, '2024-08-27', '10:00:00'),
(8, 'Dasar Basis Data', 3, 4, 'SINI AJA', 60, '2024-09-22', '10:00:00'),
(41, 'B.Inggris', 4, 27, 'SINI AJA', 90, '2024-10-03', '10:00:00'),
(42, 'Kelas KKN', 15, 14, 'Gedongan', 100, '2025-01-29', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `listed_class`
--

CREATE TABLE `listed_class` (
  `id_kelas` int(11) NOT NULL,
  `id_murid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listed_class`
--

INSERT INTO `listed_class` (`id_kelas`, `id_murid`) VALUES
(1, 5),
(1, 11),
(1, 12),
(2, 5),
(2, 8),
(2, 10),
(2, 11),
(2, 12),
(5, 12),
(8, 5),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(41, 5),
(41, 8),
(41, 9),
(41, 10),
(41, 11),
(41, 12);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `nama_materi` varchar(30) NOT NULL,
  `deskripsi_materi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `nama_materi`, `deskripsi_materi`) VALUES
(1, 'Basic Cornering', 'Back to Basic'),
(2, 'Stop and Go', 'Basic practice of stop and go '),
(3, 'Semi Complex Cornering ', '2 apex corner'),
(4, 'apex in hills', 'tackling corner in uneven elevation'),
(12, 'Stop & Go', 'Akselerasi dan berhenti dalam waktu yang sesingkat singkat nya'),
(13, 'Dasar Javascript', '12'),
(14, 'Semi Memplex', 'Memplex Memplex'),
(15, 'Semi Complex', 'real complex'),
(27, 'RX7 FD', '560hp, fr, 1060kg'),
(30, 'Buyer\'s Remorse', 'NEVER ENOUGH (Bonus Version)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `fk_materi` (`materi`),
  ADD KEY `fk_pengajar` (`pengajar`);

--
-- Indexes for table `listed_class`
--
ALTER TABLE `listed_class`
  ADD PRIMARY KEY (`id_kelas`,`id_murid`),
  ADD KEY `id_murid` (`id_murid`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id_class`);

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_materi` FOREIGN KEY (`materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajar` FOREIGN KEY (`pengajar`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `listed_class`
--
ALTER TABLE `listed_class`
  ADD CONSTRAINT `listed_class_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `class` (`id_class`),
  ADD CONSTRAINT `listed_class_ibfk_2` FOREIGN KEY (`id_murid`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
