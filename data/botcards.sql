

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2016 at 11:50 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `botcards`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `Token` varchar(6) DEFAULT NULL,
  `Piece` varchar(5) DEFAULT NULL,
  `Player` varchar(6) DEFAULT NULL,
  `Datetime` varchar(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `players`
-- **add auto_increment at playerid 

CREATE TABLE `players` (
  `Playerid` INTEGER NOT NULL AUTO_INCREMENT,
  `Player` varchar(6) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `Peanuts` int(3) DEFAULT NULL,
  
 PRIMARY KEY `Playerid`(`Playerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `Series` int(2) DEFAULT NULL,
  `Description` varchar(16) DEFAULT NULL,
  `Frequency` int(3) DEFAULT NULL,
  `Value` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `DateTime` varchar(19) DEFAULT NULL,
  `Player` varchar(6) DEFAULT NULL,
  `Series` varchar(2) DEFAULT NULL,
  `Trans` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;