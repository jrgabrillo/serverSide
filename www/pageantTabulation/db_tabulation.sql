-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2017 at 02:22 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tabulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contestant`
--

CREATE TABLE IF NOT EXISTS `tbl_contestant` (
  `id` varchar(50) NOT NULL,
  `criteria_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` varchar(2) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `detail` varchar(1000) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contestant`
--

INSERT INTO `tbl_contestant` (`id`, `criteria_id`, `name`, `age`, `picture`, `detail`, `category`, `status`) VALUES
('0716d9708d321ffb6a00818614779e779925365c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #9","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #6","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('1574bddb75c78a6fd2251d61e2993b5146201319', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #8","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('17ba0791499db908433b80f37c5fbc89b870084b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #6","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('1b6453892473a467d07372d45eb05abc2031647a', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #5","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('356a192b7913b04c54574d18c28d46e6395428ab', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #2","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #3","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('7b52009b64fd0a2a49e6d8a939753077792b0554', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #7","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('902ba3cda1883801594b6e1b452790cc53948fda', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #4","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #2","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #4","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #1","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('bd307a3ec329e10a2cff8fb87480823da114f8f4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #8","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('c1dfd96eea8cc2b62785275bca38ac261256e278', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #3","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #1","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('f1abd670358e036c31296e66b3b66c382ac00812', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #7","",""]', '', 'avatar.jpg', '', 'Student', '1'),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #9","",""]', '', 'avatar.jpg', '', 'Faculty', '1'),
('fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '["CONTESTANT #5","",""]', '', 'avatar.jpg', '', 'Student', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_criteria`
--

CREATE TABLE IF NOT EXISTS `tbl_criteria` (
  `id` varchar(50) NOT NULL,
  `criteria` varchar(1000) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_criteria`
--

INSERT INTO `tbl_criteria` (`id`, `criteria`, `status`) VALUES
('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"30","sliderStageAppearance":"15","sliderCreativity":"40","sliderCoordination":"15"}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_judges`
--

CREATE TABLE IF NOT EXISTS `tbl_judges` (
  `id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access_code` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `criteria_id` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_judges`
--

INSERT INTO `tbl_judges` (`id`, `name`, `access_code`, `picture`, `details`, `criteria_id`, `status`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'MS. ROSELLE P. GALE', 'd04f0d02', 'avatar.jpg', '', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '1'),
('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'MR. ADRIAN SORIO', 'cc57ed47', 'avatar.jpg', '', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '1'),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'HON. DEXTER MALICDEM', '57dc1821', 'avatar.jpg', '', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score`
--

CREATE TABLE IF NOT EXISTS `tbl_score` (
  `id` varchar(50) NOT NULL,
  `contestant_id` varchar(50) NOT NULL,
  `criteria_id` varchar(50) NOT NULL,
  `judge_id` varchar(50) NOT NULL,
  `scores` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`id`, `contestant_id`, `criteria_id`, `judge_id`, `scores`) VALUES
('0286dd552c9bea9a69ecb3759e7b94777635514b', 'bd307a3ec329e10a2cff8fb87480823da114f8f4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('0716d9708d321ffb6a00818614779e779925365c', '0716d9708d321ffb6a00818614779e779925365c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('0a57cb53ba59c46fc4b692527a38a87c78d84028', '17ba0791499db908433b80f37c5fbc89b870084b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"87","sliderStageAppearance":"81","sliderCreativity":"83","sliderCoordination":"84"}'),
('0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'c1dfd96eea8cc2b62785275bca38ac261256e278', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"72","sliderStageAppearance":"57","sliderCreativity":"77","sliderCoordination":"43"}'),
('12c6fc06c99a462375eeb3f43dfd832b08ca9e17', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"80","sliderStageAppearance":"78","sliderCreativity":"83","sliderCoordination":"80"}'),
('1574bddb75c78a6fd2251d61e2993b5146201319', 'bd307a3ec329e10a2cff8fb87480823da114f8f4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('17ba0791499db908433b80f37c5fbc89b870084b', '0716d9708d321ffb6a00818614779e779925365c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('1b6453892473a467d07372d45eb05abc2031647a', '902ba3cda1883801594b6e1b452790cc53948fda', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"80","sliderStageAppearance":"85","sliderCreativity":"80","sliderCoordination":"85"}'),
('22d200f8670dbdb3e253a90eee5098477c95c23d', '1574bddb75c78a6fd2251d61e2993b5146201319', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"95","sliderStageAppearance":"93","sliderCreativity":"94","sliderCoordination":"94"}'),
('2e01e17467891f7c933dbaa00e1459d23db3fe4f', '1b6453892473a467d07372d45eb05abc2031647a', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('356a192b7913b04c54574d18c28d46e6395428ab', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"80","sliderStageAppearance":"88","sliderCreativity":"88","sliderCoordination":"90"}'),
('472b07b9fcf2c2451e8781e944bf5f77cd8457c8', 'b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('4d134bc072212ace2df385dae143139da74ec0ef', '356a192b7913b04c54574d18c28d46e6395428ab', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"89","sliderStageAppearance":"85","sliderCreativity":"86","sliderCoordination":"83"}'),
('5b384ce32d8cdef02bc3a139d4cac0a22bb029e8', 'fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('632667547e7cd3e0466547863e1207a8c0c0c549', '17ba0791499db908433b80f37c5fbc89b870084b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"75","sliderStageAppearance":"79","sliderCreativity":"74","sliderCoordination":"88"}'),
('64e095fe763fc62418378753f9402623bea9e227', 'b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('761f22b2c1593d0bb87e0b606f990ba4974706de', '0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"98","sliderStageAppearance":"100","sliderCreativity":"98","sliderCoordination":"99"}'),
('7719a1c782a1ba91c031a682a0a2f8658209adbf', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"90","sliderStageAppearance":"88","sliderCreativity":"80","sliderCoordination":"81"}'),
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'c1dfd96eea8cc2b62785275bca38ac261256e278', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"80","sliderStageAppearance":"75","sliderCreativity":"60","sliderCoordination":"50"}'),
('7b52009b64fd0a2a49e6d8a939753077792b0554', '902ba3cda1883801594b6e1b452790cc53948fda', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"62","sliderStageAppearance":"51","sliderCreativity":"54","sliderCoordination":"57"}'),
('827bfc458708f0b442009c9c9836f7e4b65557fb', '77de68daecd823babbb58edb1c8e14d7106e83bb', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('887309d048beef83ad3eabf2a79a64a389ab1c9f', 'b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('902ba3cda1883801594b6e1b452790cc53948fda', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"80","sliderStageAppearance":"91","sliderCreativity":"83","sliderCoordination":"90"}'),
('91032ad7bbcb6cf72875e8e8207dcfba80173f7c', '77de68daecd823babbb58edb1c8e14d7106e83bb', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('92cfceb39d57d914ed8b14d0e37643de0797ae56', 'f1abd670358e036c31296e66b3b66c382ac00812', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"30","sliderStageAppearance":"37","sliderCreativity":"40","sliderCoordination":"51"}'),
('972a67c48192728a34979d9a35164c1295401b71', '1574bddb75c78a6fd2251d61e2993b5146201319', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"95","sliderStageAppearance":"98","sliderCreativity":"92","sliderCoordination":"93"}'),
('98fbc42faedc02492397cb5962ea3a3ffc0a9243', '0716d9708d321ffb6a00818614779e779925365c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('9e6a55b6b4563e652a23be9d623ca5055c356940', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"53","sliderStageAppearance":"58","sliderCreativity":"58","sliderCoordination":"66"}'),
('a9334987ece78b6fe8bf130ef00b74847c1d3da6', '1574bddb75c78a6fd2251d61e2993b5146201319', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"96","sliderStageAppearance":"94","sliderCreativity":"96","sliderCoordination":"98"}'),
('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"95","sliderStageAppearance":"80","sliderCreativity":"85","sliderCoordination":"85"}'),
('af3e133428b9e25c55bc59fe534248e6a0c0f17b', 'fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"100","sliderStageAppearance":"90","sliderCreativity":"97","sliderCoordination":"93"}'),
('b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'bd307a3ec329e10a2cff8fb87480823da114f8f4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('b3f0c7f6bb763af1be91d9e74eabfeb199dc1f1f', '356a192b7913b04c54574d18c28d46e6395428ab', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"73","sliderStageAppearance":"80","sliderCreativity":"67","sliderCoordination":"66"}'),
('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"35","sliderStageAppearance":"40","sliderCreativity":"49","sliderCoordination":"52"}'),
('b6692ea5df920cad691c20319a6fffd7a4a766b8', 'fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('b7eb6c689c037217079766fdb77c3bac3e51cb4c', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"93","sliderStageAppearance":"95","sliderCreativity":"93","sliderCoordination":"93"}'),
('bc33ea4e26e5e1af1408321416956113a4658763', '1b6453892473a467d07372d45eb05abc2031647a', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('bd307a3ec329e10a2cff8fb87480823da114f8f4', 'fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"96","sliderStageAppearance":"95","sliderCreativity":"100","sliderCoordination":"94"}'),
('c1dfd96eea8cc2b62785275bca38ac261256e278', '0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"93","sliderStageAppearance":"92","sliderCreativity":"95","sliderCoordination":"90"}'),
('c5b76da3e608d34edb07244cd9b875ee86906328', 'fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('ca3512f4dfa95a03169c5a670a4c91a19b3077b4', '902ba3cda1883801594b6e1b452790cc53948fda', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"40","sliderStageAppearance":"40","sliderCreativity":"30","sliderCoordination":"35"}'),
('cb4e5208b4cd87268b208e49452ed6e89a68e0b8', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"83","sliderStageAppearance":"86","sliderCreativity":"91","sliderCoordination":"82"}'),
('cb7a1d775e800fd1ee4049f7dca9e041eb9ba083', 'c1dfd96eea8cc2b62785275bca38ac261256e278', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"10","sliderStageAppearance":"10","sliderCreativity":"12","sliderCoordination":"11"}'),
('d435a6cdd786300dff204ee7c2ef942d3e9034e2', '1b6453892473a467d07372d45eb05abc2031647a', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"93","sliderStageAppearance":"92","sliderCreativity":"90","sliderCoordination":"90"}'),
('e1822db470e60d090affd0956d743cb0e7cdf113', '17ba0791499db908433b80f37c5fbc89b870084b', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"93","sliderStageAppearance":"94","sliderCreativity":"89","sliderCoordination":"91"}'),
('f1abd670358e036c31296e66b3b66c382ac00812', 'f1abd670358e036c31296e66b3b66c382ac00812', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"50","sliderStageAppearance":"49","sliderCreativity":"47","sliderCoordination":"40"}'),
('f1f836cb4ea6efb2a0b1b99f41ad8b103eff4b59', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"51","sliderStageAppearance":"37","sliderCreativity":"38","sliderCoordination":"37"}'),
('f6e1126cedebf23e1463aee73f9df08783640400', '77de68daecd823babbb58edb1c8e14d7106e83bb', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"}'),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', '0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '{"sliderAudienceResponce":"85","sliderStageAppearance":"80","sliderCreativity":"82","sliderCoordination":"81"}'),
('fb644351560d8296fe6da332236b1f8d61b2828a', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"60","sliderStageAppearance":"50","sliderCreativity":"50","sliderCoordination":"52"}'),
('fc074d501302eb2b93e2554793fcaf50b3bf7291', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"85","sliderStageAppearance":"76","sliderCreativity":"85","sliderCoordination":"84"}'),
('fe2ef495a1152561572949784c16bf23abb28057', '356a192b7913b04c54574d18c28d46e6395428ab', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', '356a192b7913b04c54574d18c28d46e6395428ab', '{"sliderAudienceResponce":"85","sliderStageAppearance":"90","sliderCreativity":"86","sliderCoordination":"88"}'),
('fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'f1abd670358e036c31296e66b3b66c382ac00812', 'b6589fc6ab0dc82cf12099d1c2d40ab994e8410c', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '{"sliderAudienceResponce":"81","sliderStageAppearance":"84","sliderCreativity":"86","sliderCoordination":"86"}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_level` int(2) NOT NULL,
  `user_picture` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_level`, `user_picture`) VALUES
('1', 'administrator', '01b307acba4f54f55aafc33bb06bbbf6ca803e9a', 'rufo.gabrillo@gmail.com', 1, '862075acf96b35f4166faea449b69d6e40f18385-1452445843.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
