-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 08:27 AM
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
-- Database: `donatetheblood`
--

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `save_life_date` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `blood_group` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `name`, `gender`, `email`, `city`, `dob`, `contact_no`, `save_life_date`, `password`, `blood_group`) VALUES
(1, 'Sakshi Satish Dongare', 'Fe-male', 'Sakshi32@gmail.com', 'Awaran', '', '98765432345', '1965-10-10', 'sakshi4', 'B+'),
(2, 'Pallavi Shamrao Nigote', 'Fe-male', 'nigotepallu45@gmail.com', 'Lahore', '', '99307543945', '1999-04-03', '030303', ''),
(3, 'Prajakta Sakhare', 'Female', 'ps546888@gmail.com', 'Barkhan', '', '87563383789', '1957-02-09', 'praju876', ''),
(4, 'kk', 'Female', 'sakshi@gmail.com', 'Chagai', '', '98765432345', '1965-09-09', '989898', ''),
(5, 'jn', 'Male ', 's@gmail.com', 'Sudhnati', '', '98765432345', '1966-10-11', '989898', 'AB-'),
(6, 'Sakshi Satish Dongare', 'Female', 'SS@gmail.com', 'Barkhan', '', '99987678987', '1959-03-01', 'ss3456', 'O-'),
(7, 'vdfgrhfghnty myhytgnjgv', 'Female', 'dzcfdsfds2@gmail.com', 'Barkhan', '', '12345678901', '1964-09-08', '93279e3308bdbbeed946fc965017f67a', 'AB-'),
(8, 'ta', 'Male ', 'ta@gmail.com', 'Bhimber', '', '92345677553', '1961-04-03', '96c81cdfaf24863dd2d8d2be1079e3f6', 'AB-'),
(9, 'tt', 'Male ', 'a@gmail.com', 'Jhal Magsi', '', '12345678901', '1963--07', 'fbb57a2d056c54e2d9ecf0054cf9f0da', 'AB-'),
(10, 'Nisha ok', 'Female', 's2@gmail.com', 'Gwadar', '1963-01-24', '99999999999', '', '54621b46c1664db5ba7127d8f22aff00', 'O+'),
(11, 'Sakshi Satish Dongare', 'Female', 'o@gmail.com', 'Jafarabad', '', '12345678901', '2024.05.17', '560d0ba89d638a4b9bcd2936e94245c3', 'AB-'),
(12, 'ssk', 'Female', 'sk@gmail.com', 'Bhimber', '', '92345677553', '2024-05-24', 'c3070855901a7c087c9c06aa155a732b', 'AB+'),
(13, 'Prajakta Sakhare', 'Female', 'p@gmail.com', 'Sudhnati', '', '91585172529', '2024-05-24', '88dcedff9f51e7243e3136d12521bebc', 'O-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
