-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2016 at 09:19 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learnforlife`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applicants`
--

CREATE TABLE `tbl_applicants` (
  `id` int(11) NOT NULL,
  `prjt_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employer_project`
--

CREATE TABLE `tbl_employer_project` (
  `id` int(11) NOT NULL,
  `prjt_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_prjt_std`
--

CREATE TABLE `tbl_emp_prjt_std` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `prjt_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `prjt_progress` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE `tbl_project` (
  `id` int(11) NOT NULL,
  `prjt_title` varchar(64) NOT NULL,
  `prjt_description` text NOT NULL,
  `skills` varchar(100) NOT NULL,
  `payment` varchar(32) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `description` text NOT NULL,
  `vetted` int(1) NOT NULL DEFAULT '0',
  `appointed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_std_prjt`
--

CREATE TABLE `tbl_std_prjt` (
  `id` int(11) NOT NULL,
  `prjt_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_employer`
--

CREATE TABLE `tbl_user_employer` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `address` varchar(64) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_student`
--

CREATE TABLE `tbl_user_student` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `address` varchar(64) NOT NULL,
  `skills` text NOT NULL,
  `work_experience` text NOT NULL,
  `educational_brief` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employer_project`
--
ALTER TABLE `tbl_employer_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emp_prjt_std`
--
ALTER TABLE `tbl_emp_prjt_std`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_std_prjt`
--
ALTER TABLE `tbl_std_prjt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_employer`
--
ALTER TABLE `tbl_user_employer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_user_student`
--
ALTER TABLE `tbl_user_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_employer_project`
--
ALTER TABLE `tbl_employer_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_emp_prjt_std`
--
ALTER TABLE `tbl_emp_prjt_std`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_project`
--
ALTER TABLE `tbl_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_std_prjt`
--
ALTER TABLE `tbl_std_prjt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user_employer`
--
ALTER TABLE `tbl_user_employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user_student`
--
ALTER TABLE `tbl_user_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
