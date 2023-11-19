-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 19, 2023 at 10:12 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userform`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventid` int(11) NOT NULL,
  `eventname` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(255) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `numberoftickets` int(11) DEFAULT NULL,
  `ticketprice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventid`, `eventname`, `Date`, `location`, `id`, `numberoftickets`, `ticketprice`) VALUES
(2, 'Afrochella', '2023-10-24 13:21:24', 'ElWak Sports Stadium', 41, 188, '10.00'),
(3, 'Brunch', '2023-10-02 19:22:01', 'Tree House', 41, 30, '20.00'),
(4, 'Buffet', '2023-10-02 19:22:10', 'Vine', 41, 30, '30.00'),
(5, 'Safari Experience', '2023-10-02 19:22:27', 'Mole National Park', 41, 50, '80.00'),
(6, 'Snorkeling Experience', '2023-10-31 00:00:00', 'Tawala Beach', NULL, 30, '5.00'),
(7, 'Paintball Experience', '2023-10-31 00:00:00', 'East Legon', NULL, 50, '10.00'),
(8, 'Testing', '2023-10-29 00:00:00', 'Testing', 41, 100, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` mediumint(50) NOT NULL,
  `status` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `name`, `email`, `password`, `code`, `status`, `is_admin`) VALUES
(1, 'Admin', 'aaronyebuah1234@gmail.com', '$2y$10$ApYTejN9fGprBYo//gGg3ekKRWX2InJ4mMYsVmhk5RaRQf44TFdma', 0, 'verified', 1),
(39, 'Aaron Nii', 'aaronyebuah56@icloud.com', '$2y$10$YHOu/SVuCsu4Z6HdzymibelqCE9Ik2Yv7tgq1vig8CzxBkD3eG8JC', 509921, 'notverified', NULL),
(41, 'Aaron Adom', 'aaron.adom-malm@ashesi.edu.gh', '$2y$10$pbswxNeJM6VLsLb/70ArYezOyV.lWAmN02remkGSZWOWz0ZAXXVCG', 0, 'verified', NULL),
(42, 'Test', 'atsrefidzifaama@gmail.com', '$2y$10$5vs4O.BSpAa08YJ6ODZ3X.kkK9XPaVOR13xSVJp1ncXMZWHoa6Sa6', 0, 'verified', NULL),
(43, 'Gerald', 'gerald_akita@yahoo.com', '$2y$10$ZqWdf9U73xKdGP32/tLhDuT3.FE3FVJ9MfodmncFrJ3MLiR9k1NSK', 0, 'verified', NULL),
(44, 'Adom', 'aaronadom-malm@outlook.com', '$2y$10$vpIVzgllnimlQkK2yFWma.cOd8tmuTY9jTF4UD.X1NyaRFVUzKWqe', 0, 'verified', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventid`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usertable` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
