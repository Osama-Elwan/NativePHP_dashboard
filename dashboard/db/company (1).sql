-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 04:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dname` varchar(50) NOT NULL,
  `dnum` tinyint(3) UNSIGNED NOT NULL,
  `mgrssn` int(10) UNSIGNED NOT NULL,
  `mgrstartdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dname`, `dnum`, `mgrssn`, `mgrstartdate`) VALUES
('dp1', 10, 223344, '2005-01-01'),
('dp2', 20, 968574, '2006-03-01'),
('dp3', 30, 512463, '2006-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `dependent`
--

CREATE TABLE `dependent` (
  `essn` int(10) UNSIGNED NOT NULL,
  `dependent_name` varchar(50) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `bdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dependent`
--

INSERT INTO `dependent` (`essn`, `dependent_name`, `gender`, `bdate`) VALUES
(112233, 'Hala Saied Ali', 'f', '1970-10-18'),
(223344, 'Ahmed Kamel Shawki', 'm', '1998-03-27'),
(223344, 'Mona Adel Mohamed', 'f', '1975-04-25'),
(321654, 'Omar Amr Omran', 'm', '1993-03-30'),
(321654, 'Ramy Amr Omran', 'm', '1990-01-26'),
(321654, 'Sanaa Gawish', 'f', '1973-05-16'),
(512463, 'Nora Ghaly', 'f', '1976-06-22'),
(512463, 'Sara Edward ', 'f', '2001-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `ssn` int(10) UNSIGNED NOT NULL,
  `bdate` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `salary` decimal(7,2) DEFAULT NULL,
  `superssn` int(10) UNSIGNED DEFAULT NULL,
  `dno` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`fname`, `lname`, `ssn`, `bdate`, `address`, `gender`, `salary`, `superssn`, `dno`) VALUES
('ahmed', 'ali', 112233, '1965-01-01', '15 ali fahmy st.giza', 'm', 1300.00, 223344, 20),
('kamel', 'osama', 223344, '1970-10-15', '38 mohy el dien abo el ezz  st.cairo', 'm', 2000.00, 112233, 10),
('amr', 'omran', 321654, '1963-09-14', '44 Hilopolis.Cairo', 'm', 2500.00, 112233, 10),
('edward', 'hanna', 512463, '1972-08-19', '18 Abaas El 3akaad St. Nasr City.Cairo', 'm', 1500.00, 321654, 20),
('maged', 'raoof', 521634, '1980-04-06', '18 Kholosi st.Shobra.Cairo', 'm', 1000.00, 321654, 30),
('mariam', 'adel', 669955, '1982-06-12', '269 El-Haram st. Giza', 'f', 750.00, 512463, 20),
('noha', 'mohamed', 968574, '1975-02-01', '55 Orabi St. El Mohandiseen .Cairo', 'f', 1600.00, 968574, 30);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `emp_ssn` int(10) UNSIGNED NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`emp_ssn`, `image_name`) VALUES
(223344, 'byVjnkZBQT_0.jpeg'),
(223344, 'iPEXaN8OXG_0.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `pname` varchar(50) NOT NULL,
  `pnumber` smallint(5) UNSIGNED NOT NULL,
  `plocation` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dnum` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`pname`, `pnumber`, `plocation`, `city`, `dnum`) VALUES
('AL Solimaniah', 100, 'Cairo_Alex Road', 'alex', 10),
('AL rabwah', 200, '6th of October City', 'giza', 10),
('AL rawdah', 300, 'Zaied City', 'giza', 10),
('AL rowad', 400, 'Cairo_Faiyom Road', 'giza', 20),
('AL rehab', 500, 'Nasr City', 'cairo', 30),
('Pitcho american', 600, 'maady', 'cairo', 30),
('Ebad El Rahman', 700, 'ring Road', 'cairo', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`) VALUES
(1, 'osama', 'osama.elwan01@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'ahmed', 'a@a.com', 'e10adc3949ba59abbe56e057f20f883e', 0);

-- --------------------------------------------------------

--
-- Table structure for table `works_for`
--

CREATE TABLE `works_for` (
  `essn` int(10) UNSIGNED NOT NULL,
  `pno` smallint(5) UNSIGNED NOT NULL,
  `hours` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `works_for`
--

INSERT INTO `works_for` (`essn`, `pno`, `hours`) VALUES
(112233, 100, 40),
(223344, 100, 10),
(223344, 200, 10),
(223344, 300, 10),
(223344, 500, 10),
(512463, 500, 10),
(512463, 600, 25),
(521634, 300, 6),
(521634, 400, 4),
(521634, 500, 10),
(521634, 600, 20),
(669955, 300, 10),
(669955, 400, 20),
(669955, 700, 7),
(968574, 300, 10),
(968574, 400, 15),
(968574, 700, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dnum`),
  ADD UNIQUE KEY `mgrssn` (`mgrssn`);

--
-- Indexes for table `dependent`
--
ALTER TABLE `dependent`
  ADD PRIMARY KEY (`essn`,`dependent_name`),
  ADD UNIQUE KEY `dependent_name` (`dependent_name`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ssn`),
  ADD KEY `fk_superssn_employee` (`superssn`),
  ADD KEY `fk_dno_employee` (`dno`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`emp_ssn`,`image_name`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`pnumber`),
  ADD KEY `fk_dnum_project` (`dnum`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `works_for`
--
ALTER TABLE `works_for`
  ADD PRIMARY KEY (`essn`,`pno`),
  ADD KEY `fk_pno_works_for` (`pno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_mgrssn_department` FOREIGN KEY (`mgrssn`) REFERENCES `employee` (`ssn`);

--
-- Constraints for table `dependent`
--
ALTER TABLE `dependent`
  ADD CONSTRAINT `fk_essn_dependent` FOREIGN KEY (`essn`) REFERENCES `employee` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_dno_employee` FOREIGN KEY (`dno`) REFERENCES `department` (`dnum`),
  ADD CONSTRAINT `fk_superssn_employee` FOREIGN KEY (`superssn`) REFERENCES `employee` (`ssn`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`emp_ssn`) REFERENCES `employee` (`ssn`) ON DELETE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_dnum_project` FOREIGN KEY (`dnum`) REFERENCES `department` (`dnum`);

--
-- Constraints for table `works_for`
--
ALTER TABLE `works_for`
  ADD CONSTRAINT `fk_essn_works_for` FOREIGN KEY (`essn`) REFERENCES `employee` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pno_works_for` FOREIGN KEY (`pno`) REFERENCES `project` (`pnumber`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
