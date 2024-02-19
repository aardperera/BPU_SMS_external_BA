-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2018 at 11:27 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sms_external`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT,
  `courseCode` varchar(10) NOT NULL,
  `nameEnglish` varchar(100) DEFAULT NULL,
  `nameSinhala` varchar(300) DEFAULT NULL,
  `courseType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseCode`, `nameEnglish`, `nameSinhala`, `courseType`) VALUES
(1, 'PhDd', 'Doctor of Philosophy', 'à¶†à¶ à·à¶»à·Šà¶º à¶‹à¶´à·à¶°à·’ à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'PhD'),
(2, 'MPhil', 'Master of Philosophy', 'à¶¯à¶»à·Šà·à¶±à¶´à¶­à·’ à¶‹à¶´à·à¶°à·’ à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'MPhil'),
(3, 'MA', 'Master of Arts', 'à·à·à·ƒà·Šà¶­à·Šâ€à¶»à¶´à¶­à·’ à¶‹à¶´à·à¶°à·’à¶º', 'Master'),
(4, 'PGD', 'Postgraduate Diploma', 'à¶´à·à·Šà¶ à·à¶¯à·Š à¶‹à¶´à·à¶°à·’ à¶©à·’à¶´à·Šà¶½à·à¶¸à· à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'PG Diploma'),
(5, 'BA', 'Bachelor of Arts General Degree', 'à·à·à·ƒà·Šà¶­à·Šâ€à¶»à·€à·šà¶¯à·“ (à·ƒà·à¶¸à·à¶±à·Šâ€à¶º) à¶¶à·à·„à·’à¶» à¶‹à¶´à·à¶°à·’à¶º', 'Bachelor'),
(6, 'B Dip', 'Diploma in Buddhism', 'à¶¶à·”à¶¯à·Šà¶°à¶°à¶»à·Šà¶¸ à¶©à·’à¶´à·Šà¶½à·à¶¸à· à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'Diploma'),
(7, ' E Dip', 'Diploma in English', 'à¶‰à¶‚à¶œà·Šâ€à¶»à·“à·ƒà·“ à¶©à·’à¶´à·Šà¶½à·à¶¸à· à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'Diploma'),
(8, 'T Dip', 'Diploma in Tamil', 'à¶¯à·™à¶¸à¶½ à¶©à·’à¶´à·Šà¶½à·à¶¸à· à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'Diploma'),
(9, 'BC Dip', 'Diploma in Buddhist Counselling', 'à¶¶à·žà¶¯à·Šà¶° à¶‹à¶´à¶¯à·šà·à¶± à¶©à·’à¶´à·Šà¶½à·à¶¸à· à¶´à·à¶¨à¶¸à·à¶½à·à·€', 'Diploma');

-- --------------------------------------------------------

--
-- Table structure for table `course_combination`
--

CREATE TABLE IF NOT EXISTS `course_combination` (
  `CourseID` varchar(30) DEFAULT NULL,
  `combinationID` int(10) NOT NULL AUTO_INCREMENT,
  `subcrsID` int(11) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `compulsary` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`combinationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `course_combination`
--

INSERT INTO `course_combination` (`CourseID`, `combinationID`, `subcrsID`, `Description`, `compulsary`) VALUES
('3', 1, 6, 'Combination1', 'Yes'),
('3', 2, 1, 'combination2', 'Yes'),
('3', 3, 1, 'Comnation2', 'Yes'),
('5', 4, 1, 'PALI 1', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `crs_enroll`
--

CREATE TABLE IF NOT EXISTS `crs_enroll` (
  `Enroll_id` int(11) NOT NULL AUTO_INCREMENT,
  `regNo` varchar(20) NOT NULL,
  `indexNo` varchar(20) DEFAULT NULL,
  `studentID` varchar(20) NOT NULL,
  `courseID` int(11) NOT NULL,
  `yearEntry` year(4) DEFAULT NULL,
  `combinationID` int(10) DEFAULT NULL,
  `subcrsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Enroll_id`),
  UNIQUE KEY `indexNo_UNIQUE` (`indexNo`),
  KEY `fk_crs_enroll_course` (`courseID`),
  KEY `fk_crs_enroll_student` (`studentID`),
  KEY `indexNo` (`indexNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Dumping data for table `crs_enroll`
--

INSERT INTO `crs_enroll` (`Enroll_id`, `regNo`, `indexNo`, `studentID`, `courseID`, `yearEntry`, `combinationID`, `subcrsID`) VALUES
(1, '', '', '1234', 9, 2010, NULL, NULL),
(2, '', '1', '1111w', 5, 2010, NULL, 1),
(3, '', '12', 'phd student', 1, 2010, 0, 1),
(4, '', '1234', 'kykyuk', 5, 2010, NULL, NULL),
(5, '', '255', '123', 4, 2010, NULL, NULL),
(6, '', '44', 'dfh', 3, 2010, 0, 1),
(7, '', '56', 'lakmali', 5, 2010, 0, 1),
(8, '', '88', '875', 3, 2010, 0, 1),
(15, '875', '8', '875', 3, 2010, 0, 1),
(17, '875', '21', '875', 3, 2010, 0, 1),
(18, '875', '36', '875', 3, 2010, 0, 1),
(20, '875', '96', '875', 3, 2010, 0, 1),
(22, 'chamila3', '78', 'chamila3', 3, 2010, 0, 1),
(23, '8744', '4', '875', 3, 2010, 0, 1),
(24, '87', '7', '875', 3, 2010, 0, 5),
(25, '875', '77', '875', 3, 2010, 0, 1),
(26, '875', '2', '875', 3, 2010, 0, 1),
(27, '875', '69', '875', 3, 2010, 0, 1),
(29, '875', '5', '875', 3, 2010, 0, 1),
(30, '875', '75', '875', 3, 2010, 0, 1),
(33, '875', '9454', '875', 3, 2010, 0, 1),
(35, '875', '55', '875', 3, 2010, 0, 1),
(36, '875', '43', '875', 3, 2010, 0, 1),
(41, '875', '5757', '875', 3, 2010, 0, 1),
(42, '875', '66', '875', 3, 2010, 0, 1),
(43, '875', '755', '875', 3, 2010, 0, 1),
(46, '875', '3', '875', 3, 2010, 0, 1),
(47, 'chamila3', '345', 'chamila3', 3, 2010, 0, 1),
(49, '875', '963', '875', 3, 2010, 0, 1),
(52, '876', '665', '875', 3, 2010, 0, 1),
(55, '875', '6', '875', 3, 2010, 0, 1),
(58, '875', '1111', '875', 3, 2010, 0, 1),
(60, '875', '4534', '875', 3, 2010, 0, 1),
(62, '875', '324', '875', 3, 2010, 0, 1),
(64, '875', '65456', '875', 3, 2010, 0, 1),
(70, '875', '123456', '875', 3, 2010, 0, 1),
(71, '875', '7854', '875', 3, 2010, 0, 1),
(72, '875', '54', '875', 3, 2010, 0, 1),
(73, '875', '666', '875', 3, 2010, 0, 1),
(75, '875', '7676', '875', 3, 2010, 0, 1),
(76, '875', '111', '875', 3, 2010, 0, 1),
(80, '875', '1212', '875', 3, 2010, 0, 0),
(83, '1245', '33', '1245', 3, 2010, 0, 1),
(87, '1245', '48', '1245', 3, 2010, 0, 1),
(89, '1245', '4891', '1245', 3, 2010, 0, 1),
(90, '1245', '897', '1245', 3, 2010, 0, 5),
(92, '1245', '796', '1245', 3, 2010, 0, 3),
(93, '1245', '632', '1245', 3, 2010, 0, 4),
(96, '1245', '12211', '1245', 3, 2010, 0, 1),
(98, '1245', '7878', '1245', 3, 2010, 0, 1),
(99, '1245', '2223', '1245', 3, 2010, 0, 1),
(100, '1245', '656', '1245', 3, 2010, 0, 1),
(101, 'chamila3', '171717', 'chamila3', 3, 2010, 0, 1),
(102, '1245', '76', '1245', 3, 2010, 0, 1),
(103, '1245', '12312', '1245', 3, 2010, 0, 1),
(104, 'chamila3', '554', 'chamila3', 3, 2010, 0, 1),
(105, 'chamila3', '3434', 'chamila3', 3, 2010, 0, 1),
(107, '1111', '332', '1111', 3, 2010, 0, 1),
(108, '1111', '66675', '1111', 3, 2010, 0, 1),
(109, '1111', '5656', '1111', 3, 2010, 0, 1),
(110, '1111', '7970', '1111', 3, 2010, 0, 1),
(111, '1111', '31', '1111', 3, 2010, 0, 1),
(113, '1111', '3838', '1111', 3, 2010, 0, 1),
(115, '1111', '3131', '1111', 3, 2010, 0, 1),
(116, '1111', '5768', '1111', 3, 2010, 0, 1),
(118, '1111', '9', '1111', 3, 2010, 0, 1),
(121, '1111', '125', '1111', 3, 2010, 0, 1),
(123, '1111', '6867', '1111', 3, 2010, 0, 1),
(124, '1245', '1919', '1245', 3, 2010, 0, 1),
(125, '1111', '7895', '1111', 3, 2010, 0, 1),
(126, '1111', '5651', '1111', 3, 2010, 0, 1),
(128, '1111', '111336', '1111', 3, 2010, 0, 1),
(130, '1111', '5565', '1111', 3, 2010, 0, 1),
(131, '1111', '55555', '1111', 3, 2010, 0, 1),
(132, '1111', '555', '1111', 3, 2010, 0, 1),
(133, '1111', '4433', '1111', 3, 2010, 0, 1),
(134, '1111', '444', '1111', 3, 2010, 0, 1),
(135, '1111', '6222', '1111', 3, 2010, 0, 1),
(136, '1111', '29639', '1111', 3, 2010, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `crs_select`
--

CREATE TABLE IF NOT EXISTS `crs_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` varchar(50) NOT NULL,
  `courseID` int(11) NOT NULL,
  `status` varchar(2) NOT NULL,
  `subcrsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `crs_select`
--

INSERT INTO `crs_select` (`id`, `studentId`, `courseID`, `status`, `subcrsID`) VALUES
(1, '85858585', 9, 'Y', NULL),
(2, '', 0, 'Y', 1),
(3, '23456V', 3, 'Y', 0);

-- --------------------------------------------------------

--
-- Table structure for table `crs_sub`
--

CREATE TABLE IF NOT EXISTS `crs_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseID` int(11) NOT NULL,
  `subcrsID` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `crs_sub`
--

INSERT INTO `crs_sub` (`id`, `courseID`, `subcrsID`, `description`) VALUES
(6, 1, 1, 'PhD sinhala '),
(7, 5, 1, 'Examination1'),
(8, 5, 2, 'Examination2'),
(9, 5, 3, 'Examination3'),
(10, 3, 1, 'BS'),
(11, 3, 2, 'SI'),
(12, 3, 3, 'PL'),
(14, 3, 4, 'SN'),
(15, 3, 5, 'EN'),
(16, 3, 6, 'BS(E)'),
(17, 3, 7, 'PL(E)'),
(18, 3, 8, 'SN(E)'),
(21, 7, 1, 'Higher Diploma'),
(22, 7, 2, 'Diploma Level'),
(23, 7, 3, 'Advanced Certificate Level'),
(24, 7, 4, 'Certificate Level'),
(25, 8, 1, 'Higher Diploma Level'),
(26, 8, 2, 'Diploma Level'),
(27, 8, 3, 'Advanced Certificate Level'),
(28, 8, 4, 'Certificate Level'),
(29, 9, 1, 'Certificate Level'),
(30, 9, 2, 'Diploma Level'),
(31, 9, 3, 'Higher Diploma Level'),
(32, 6, 1, 'Diploma in Buddhism (SM)'),
(33, 6, 2, 'Diploma in Buddhism (EM)'),
(34, 6, 3, 'Higher Diploma in Buddhism (SM)'),
(35, 6, 4, 'Higher Diploma in Buddhism (EM)'),
(36, 6, 5, 'Diploma in Pali (SM)'),
(37, 6, 6, 'Diploma in Pali (EM)'),
(38, 6, 7, 'Higher Diploma in Pali (SM)'),
(39, 6, 8, 'Higher Diploma in Pali (EM)'),
(40, 6, 9, 'Diploma in Sanskrit (SM)'),
(41, 6, 10, 'Diploma in Sanskrit (EM)');

-- --------------------------------------------------------

--
-- Table structure for table `crs_subject`
--

CREATE TABLE IF NOT EXISTS `crs_subject` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) DEFAULT NULL,
  `subjectID` int(11) DEFAULT NULL,
  `compulsary` char(3) DEFAULT NULL,
  `subcrsid` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `crs_subject`
--

INSERT INTO `crs_subject` (`ID`, `CourseID`, `subjectID`, `compulsary`, `subcrsid`) VALUES
(1, 5, 133, 'Yes', 0),
(2, 5, 246, 'Yes', 0),
(3, 5, 151, 'Yes', 0),
(4, 5, 133, 'Yes', 0),
(5, 5, 154, 'Yes', 0),
(6, 5, 152, 'Yes', 0),
(7, 5, 153, 'Yes', 0),
(8, 5, 151, 'Yes', 0),
(9, 5, 150, 'Yes', 0),
(10, 5, 133, 'Yes', 0),
(11, 5, 133, 'Yes', 0),
(12, 5, 133, 'Yes', 0),
(13, 5, 133, 'No', 0),
(14, 5, 147, 'Yes', 0),
(15, 0, 0, 'Yes', 0),
(16, 0, 0, 'Yes', 0),
(17, 5, 0, 'Yes', 0),
(18, 5, 0, 'No', 0),
(19, 5, 0, 'No', 0),
(20, 5, 0, 'Yes', 0),
(21, 5, 0, 'No', 0),
(22, 5, 0, 'No', 0),
(23, 5, 0, 'No', 0),
(24, 5, 0, 'No', 151),
(25, 5, 0, 'Yes', 133),
(26, 5, 0, 'No', 0),
(27, 5, 0, 'Yes', 0),
(28, 0, 0, 'Yes', 0),
(29, 5, 0, 'Yes', 141),
(30, 5, 0, 'Yes', 137),
(31, 5, 0, 'Yes', 190),
(32, 5, 0, 'No', 133),
(33, 5, 0, 'No', 0),
(34, 0, 0, 'Yes', 0),
(35, 5, 0, 'No', 0),
(36, 5, 0, 'Yes', 0),
(37, 5, 0, 'No', 2),
(38, 5, 0, 'No', 2),
(39, 5, 0, 'No', 3),
(40, 5, 0, 'No', 3),
(41, 5, 0, 'Yes', 1),
(42, 5, 0, 'Yes', 1),
(43, 5, 0, 'Yes', 1),
(44, 5, 0, 'No', 2),
(45, 5, 0, 'No', 3),
(46, 5, NULL, NULL, NULL),
(47, 5, NULL, NULL, NULL),
(48, 5, NULL, NULL, NULL),
(49, 5, NULL, NULL, 2),
(50, 5, 0, NULL, 3),
(51, 5, 137, 'No', 3),
(52, 5, 157, 'No', 1),
(53, 5, 156, 'No', 1),
(54, 0, 0, 'Yes', 0),
(55, 3, 156, 'No', 4),
(56, 3, 271, 'No', 5),
(57, 3, 287, 'No', 2),
(58, 3, 271, 'No', 5),
(59, 3, 290, 'No', 5),
(60, 0, 0, 'Yes', 0),
(61, 0, 0, 'Yes', 0),
(62, 0, 0, 'Yes', 0),
(63, 0, 0, 'Yes', 0),
(64, 3, 271, 'No', 2),
(65, 3, 287, 'No', 3);

-- --------------------------------------------------------

--
-- Table structure for table `exameffort`
--

CREATE TABLE IF NOT EXISTS `exameffort` (
  `effortID` int(11) NOT NULL AUTO_INCREMENT,
  `indexNo` varchar(20) NOT NULL,
  `subjectID` int(11) NOT NULL,
  `acYear` year(4) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `effort` int(11) DEFAULT NULL,
  `mark1` int(11) DEFAULT NULL,
  `mark2` int(11) DEFAULT NULL,
  PRIMARY KEY (`effortID`),
  KEY `FK_exameffort_studentenrolment` (`indexNo`,`subjectID`),
  KEY `fk_exameffort_sub_enroll` (`indexNo`,`subjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `examschedule`
--

CREATE TABLE IF NOT EXISTS `examschedule` (
  `subjectID` int(11) NOT NULL,
  `acYear` year(4) NOT NULL,
  `medium` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `venue` varchar(20) NOT NULL,
  PRIMARY KEY (`subjectID`,`acYear`,`medium`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE IF NOT EXISTS `lecturer` (
  `epfNo` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`epfNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`epfNo`, `name`) VALUES
('123', 'fdfdf');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentID` varchar(20) NOT NULL,
  `nic` varchar(10) NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `nameEnglish` varchar(100) DEFAULT NULL,
  `nameSinhala` varchar(400) DEFAULT NULL,
  `addressE1` varchar(50) DEFAULT NULL,
  `addressE2` varchar(50) DEFAULT NULL,
  `addressE3` varchar(50) DEFAULT NULL,
  `addressS1` varchar(200) DEFAULT NULL,
  `addressS2` varchar(200) DEFAULT NULL,
  `addressS3` varchar(200) DEFAULT NULL,
  `contactNo` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `citizenship` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `religion` varchar(20) DEFAULT NULL,
  `civilStatus` varchar(20) DEFAULT NULL,
  `employment` varchar(20) DEFAULT NULL,
  `employer` varchar(50) DEFAULT NULL,
  `guardName` varchar(60) DEFAULT NULL,
  `guardAddress` varchar(300) DEFAULT NULL,
  `guardContactNo` varchar(20) DEFAULT NULL,
  `courseID` int(11) DEFAULT NULL,
  PRIMARY KEY (`studentID`),
  UNIQUE KEY `nic` (`nic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `nic`, `title`, `nameEnglish`, `nameSinhala`, `addressE1`, `addressE2`, `addressE3`, `addressS1`, `addressS2`, `addressS3`, `contactNo`, `email`, `birthday`, `citizenship`, `nationality`, `religion`, `civilStatus`, `employment`, `employer`, `guardName`, `guardAddress`, `guardContactNo`, `courseID`) VALUES
('101', '4544646v', 'Prof.', '566', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, NULL),
('1111', '111', 'Ven.', '11', '11', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, 3),
('1111w', '11w', 'Ven.', '1w', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2018-07-04', '1', NULL, NULL, 'Married', '1', '1', NULL, NULL, NULL, 5),
('123', '23456V', 'Prof.', 'sdfsdgf', '', 'Ã¡d', 'sdg', 'Ã¡gdg', '', '', '', '45555', 'gdf@fdgdfg.com', '2017-08-15', 'fdsÃ¡', 'fgfg', 'fgfg', 'fgg', 'fgg', 'fg', 'gf', 'sÃ¡f', 'fg', NULL),
('1234', '5824555', 'Mr.', 'vfdvf', 'fvfgfg', 'fv', 'fv', 'f', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 5),
('1245', '915364110v', 'Dr.', 'chamila', 'chamila', 'maharagama', '', '', 'maharagama', '', '', '0713137557', 'cgunarathna4@gmail.com', '2018-07-12', 'yes', NULL, NULL, 'Unmarried', 'yes', 'yes', NULL, NULL, NULL, 3),
('15', '1', 'Ven.', 'f', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, NULL),
('2', '2', 'Ven.', '2', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, NULL),
('222', '28', 'Ven.', 'gr', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL),
('3e3', '3e3', 'Ven.', '3e', 'e3', 'e3', '', '', 'e3', '', '', 'e3', 'e3', '2018-07-06', 'e3', NULL, NULL, 'Married', 'e3', 'e3', NULL, NULL, NULL, 5),
('44', '4', 'Ven.', '4', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, NULL),
('5', 't', 'Ven.', 'ty', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL),
('5554', 'ttr', 'Ven.', '64', '46', '46', '', '', '64', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, 5),
('565', '656', 'Ven.', '65', '65', '65', '', '', '65', '', '', '65', '65', '2018-07-05', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, 5),
('5r5', 'rr', 'Ven.', 'r', 'r', 'r', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, 5),
('6436', 'dg', 'Ven.', 'd', 'gd', 'dg', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, NULL),
('65', '55', 'Ven.', 'hgj', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL),
('76', '76', 'Ven.', 'fhgj', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, NULL),
('87', '65', 'Ven.', 'jy', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, NULL),
('875', '915378110V', 'Dr.', 'jhuy', '', 'hui', 'jiu9', 'hy8ou', '', '', '', '458', 'huiy@wdf.com', '0000-00-00', '', '', '', '', '', '', '', '', '', 3),
('90', '7', 'Ven.', 'gjg', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, NULL),
('chamila3', '123456', 'Mr.', 'ewew', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Unmarried', '', '', NULL, NULL, NULL, 3),
('dfh', '5556', 'Dr.', 'hgtygyujk', '', 'huyh', 'k8u8', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 3),
('ds', 'ds', 'Ven.', 'ds', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL),
('ewe', 'e', 'Ven.', 'ew', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, '', '', '', NULL, NULL, NULL, 3),
('gdg', 'gd', 'Dr.', 'gd', 'g', 'g', '', '', '', 'g', '', 'g', 'g', '2018-07-04', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 5),
('kykyuk', '', 'Ven.', 'hgfhh', 'fggfhgf', 'gbgfb', '', 'gfbgb', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', NULL),
('lakmali', 'dfdf', 'Ven.', 'fd', 'fd', 'fd', '', '', 'fd', '', '', '545', 'fdf', '2018-07-04', '', NULL, NULL, 'Unmarried', 'gd', 'd', NULL, NULL, NULL, 5),
('phd student', '564', 'Dr.', '64', '64', '64', '', '', '64', '', '', '6', '65', '2018-07-03', '56', NULL, NULL, 'Unmarried', '65', '6', NULL, NULL, NULL, 1),
('q2', 'q2', 'Ven.', 'q2', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 5),
('tdipTest', '1235566', 'Ven.', 'test', '', '', '', '', '', '', '', '', '', '0000-00-00', '', NULL, NULL, 'Married', '', '', NULL, NULL, NULL, 8),
('TEST', '12345', 'Ven.', 'D', 'D', 'D', '', 'D', 'D', '', 'D', '54', 'F@GMAIL.COM', '2018-07-04', 'DSG', 'GSDG', 'DSG', 'G', 'VX', 'VX', 'V', 'V', '453', 3),
('wr', 'fsd', 'Ven.', 'fsf', 'fs', '', '', '', '', '', '', '', '', '2018-08-08', '', NULL, NULL, 'Married', 'fs', '', NULL, NULL, NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `stu_qualification`
--

CREATE TABLE IF NOT EXISTS `stu_qualification` (
  `studentID` varchar(20) NOT NULL,
  `OL` varchar(3) NOT NULL,
  `AL` varchar(3) NOT NULL,
  `Diploma` varchar(3) NOT NULL,
  `HigherDiploma` varchar(3) NOT NULL,
  `FirsDegree` varchar(3) NOT NULL,
  `Post_OneYear` varchar(3) NOT NULL,
  `Post_TwoYears` varchar(3) NOT NULL,
  `Others` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stu_qualification`
--

INSERT INTO `stu_qualification` (`studentID`, `OL`, `AL`, `Diploma`, `HigherDiploma`, `FirsDegree`, `Post_OneYear`, `Post_TwoYears`, `Others`) VALUES
('', 'YES', '', '', '', '', '', '', ''),
('', 'YES', '', '', '', '', '', '', ''),
('ds', 'YES', 'YES', '', '', '', '', '', ''),
('5', 'YES', 'YES', 'YES', '', '', '', '', ''),
('76', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', '', ''),
('87', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', ''),
('90', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'retetete '),
('101', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'TEST OTHER\r\n			'),
('1111w', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', '1111	'),
('6436', 'YES', 'YES', '', '', '', '', '', '\r\n			'),
('5554', 'YES', 'YES', 'YES', '', '', '', '', '\r\n			'),
('565', 'YES', 'YES', 'YES', '', '', '', '', '\r\n			'),
('5r5', 'YES', 'YES', 'YES', '', '', '', '', '\r\n			'),
('3e3', 'YES', 'YES', 'YES', '', '', '', '', '\r\n			'),
('lakmali', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', '', '\r\n			'),
('phd student', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'yt\r\n			'),
('chamila3', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'wqrw\r\n			'),
('1245', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'test other chamila	'),
('ewe', '', '', '', '', '', '', '', '\r\n			'),
('1111', '', '', '', '', '', '', '', '\r\n			'),
('tdipTest', 'YES', 'YES', '', '', '', '', '', '\r\n			'),
('wr', 'YES', 'YES', '', '', '', '', '', '\r\n			');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subjectID` int(11) NOT NULL AUTO_INCREMENT,
  `codeEnglish` varchar(20) DEFAULT NULL,
  `nameEnglish` varchar(100) DEFAULT NULL,
  `codeSinhala` varchar(100) DEFAULT NULL,
  `nameSinhala` varchar(200) DEFAULT NULL,
  `faculty` varchar(30) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `semester` varchar(30) NOT NULL,
  `creditHours` float DEFAULT NULL,
  `courseID` varchar(30) DEFAULT NULL,
  `Compulsary` varchar(20) DEFAULT NULL,
  `subcrsID` int(11) NOT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=308 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectID`, `codeEnglish`, `nameEnglish`, `codeSinhala`, `nameSinhala`, `faculty`, `level`, `semester`, `creditHours`, `courseID`, `Compulsary`, `subcrsID`) VALUES
(133, 'PALI E 13015', 'Introduction to pali Grammar', 'PALI E 13015', 'à¶´à·à¶½à·’ à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Language', '', 'Other', 10, '5 ', 'No', 0),
(134, 'PALI E 13025', 'Pali Prescribed Texts - I', 'PALI E 13025', 'à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® - I', 'Language', '', 'Other', 10, '5 ', 'No', 0),
(135, 'SINH E 13014', 'à·ƒà·’à¶‚à·„à¶½ à¶·à·à·‚à·à·€ à·„à· à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'SINH E 13014', 'à·ƒà·’à¶‚à·„à¶½ à¶·à·à·‚à·à·€ à·„à· à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(136, 'SINH E 13024', 'à·ƒà¶¸à·Šà¶·à·à·€à·Šâ€à¶º à·„à· à¶±à·–à¶­à¶± à·ƒà·’à¶‚à·„à¶½ à¶´à¶¯à·Šâ€à¶º  à·ƒà·à·„à·’à¶­à·Šâ', 'SINH E 13024', 'à·ƒà¶¸à·Šà¶·à·à·€à·Šâ€à¶º à·„à· à¶±à·–à¶­à¶± à·ƒà·’à¶‚à·„à¶½ à¶´à¶¯à·Šâ€à¶º à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(137, 'SANS E 13014', 'Sanskrit Grammar', 'SANS E 13014', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(138, 'SANS E 13024', 'Sanskrit Prescribed Text - I', 'SANS E 13024', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® -  I', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(141, 'REST E 13014', 'Introduction to Religious Studies', 'REST E 13014', 'à·ƒà¶¸à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶± à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(142, 'REST E 13024', 'Theorotical Approches in Religious Studies', 'REST E 13024', 'à·ƒà¶¸à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶ºà·™à·„à·’ à¶±à·Šâ€à¶ºà·à¶ºà·à¶­à·Šà¶¸à¶š à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Buddhist', '', 'Other', 8, ' ', 'No', 0),
(143, 'REST E 13024', 'Theorotical Approches in Religious Studies', 'REST E 13024', 'à·ƒà¶¸à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶ºà·™à·„à·’ à¶±à·Šâ€à¶ºà·à¶ºà·à¶­à·Šà¶¸à¶š à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Buddhist', '', 'Other', 8, ' ', 'No', 0),
(146, 'REST E 13024', 'Theorotical Approches in Religious Studies', 'REST E 13024', 'à·ƒà¶¸à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶ºà·™à·„à·’ à¶±à·Šâ€à¶ºà·à¶ºà·à¶­à·Šà¶¸à¶š à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(147, 'BUCU E 13014', 'Pre- Buddhist Indian Culture ', 'BUCU E 13014', 'à¶´à·Šâ€à¶»à·à¶œà·Š à¶¶à·žà¶¯à·Šà¶° à¶·à·à¶»à¶­à·“à¶º à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­à·’à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(148, 'BUCU E 13024', 'Origin of Buddhism and the Basic Concepts of Buddhist Culture ', 'BUCU E 13024', 'à¶¶à·”à¶¯à·”à·ƒà¶¸à¶ºà·š à¶´à·Šâ€à¶»à¶·à·€à¶º à·„à· à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­à·’à¶ºà·š à¶¸à·–à¶½à·’à¶š à·ƒà¶‚à¶šà¶½à·Šà¶´', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(149, 'BUPH E - 13014', 'Early Buddhism - Fundamental Teachings', 'BUPH E - 13014', 'à¶¸à·”à¶½à·Š à¶¶à·”à¶¯à·”à·ƒà¶¸à¶º - à¶¸à·–à¶½à·’à¶š à¶‰à¶œà·à¶±à·Šà·€à·“à¶¸à·Š', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(150, 'BUPH E - 13024', 'Pre Buddhist Religious and Philosophical Background in India', 'BUPH E - 13024', 'à¶´à·Šâ€à¶»à·à¶œà·Š à¶¶à·žà¶¯à·Šà¶° à¶·à·à¶»à¶­à·“à¶º à¶†à¶œà¶¸à·’à¶š à·„à· à¶¯à·à¶»à·Šà·à¶±à·’à¶š à¶´à·ƒà·”à¶¶à·’à¶¸', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(151, 'ARCH E 13014', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà·à·™à·€à·Š à¶‰à¶­à·’à·„à·à·ƒà¶º', 'ARCH E 13014', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà·à·™à·€à·Š à¶‰à¶­à·’à·„à·à·ƒà¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(152, 'ARCH E 13024', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà· à·€à·’à¶°à·’ à¶±à·’à¶ºà¶¸ à·„à· à·à·’à¶½à·Šà¶´ à¶šà·Šâ€à¶»à¶¸', 'ARCH E 13024', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà· à·€à·’à¶°à·’ à¶±à·’à¶ºà¶¸ à·„à· à·à·’à¶½à·Šà¶´ à¶šà·Šâ€à¶»à¶¸', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(154, 'PALI E 13023', 'Study of Pali Grammar ', 'PALI E 13023', 'à¶´à·à¶½à·’ à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º', 'Language', '', 'Other', 6, '5 ', 'Yes', 0),
(156, 'ITECE (C) 13025', 'Information Technology', 'ITECE (C) 13025', 'à¶­à·œà¶»à¶­à·”à¶»à· à¶­à·à¶šà·Šà·‚à¶«à¶º', 'Buddhist', '', 'Other', 5, '5 ', 'Yes', 0),
(157, 'BUCL 13073', 'Buddhist Counselling', 'BUCL 13073', 'à¶¶à·žà¶¯à·Šà¶° à¶‹à¶´à¶¯à·šà·à¶±à¶º', 'Buddhist', '', 'Other', 4, '5 ', 'No', 0),
(158, 'SINH E 13034', 'à·ƒà·’à¶‚à·„à¶½ à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'SINH E 13034', 'à·ƒà·’à¶‚à·„à¶½ à·€à·Šâ€à¶ºà·à¶šà¶»à¶« à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Buddhist', '', 'Other', 4, '5 ', 'No', 0),
(159, 'TAMI E 13054', 'Introduction to Tamil Language', 'TAMI E 13054', 'à¶¯à·™à¶¸à·… à¶·à·à·‚à· à¶´à·Šâ€à¶»à·™à·€à·Šà·à¶º', 'Language', '', 'Other', 4, '5 ', 'No', 0),
(160, 'PALI E 23035', 'History of Pali Canonical Literature ', 'PALI E 13045', 'à¶´à·à¶½à·’ à¶­à·Šâ€à¶»à·’à¶´à·’à¶§à¶š à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'Language', '', 'Other', 10, '5 ', 'No', 0),
(161, 'PALI E 23045', 'Pali Language Analytical Study', 'PALI E 13045', 'à¶´à·à¶½à·’ à¶·à·à·‚à· à·€à·’à¶¸à¶»à·Šà·à¶±à¶º', 'Other', '', 'Other', 10, '5 ', 'No', 0),
(162, 'ARCH E 23034', 'à¶šà¶½à· à¶‰à¶­à·’à·„à·à·ƒà¶º à·„à· à·€à·à·ƒà·Šà¶­à·” à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'ARCH E 23034', 'à¶šà¶½à· à¶‰à¶­à·’à·„à·à·ƒà¶º à·„à· à·€à·à·ƒà·Šà¶­à·” à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(163, 'ARCH E 23044', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà·à¶­à·Šà¶¸à¶š à·ƒà¶‚à¶»à¶šà·Šà·‚à¶«à¶º à·„à· à¶šà·žà¶­à·”à¶šà·à¶œà', 'ARCH E 23044', 'à¶´à·”à¶»à·à·€à·’à¶¯à·Šâ€à¶ºà·à¶­à·Šà¶¸à¶š à·ƒà¶‚à¶»à¶šà·Šà·‚à¶«à¶º à·„à· à¶šà·žà¶­à·”à¶šà·à¶œà·à¶» à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(164, 'REST E 23034', 'Estern Religions', 'REST E 23034', 'à¶´à·™à¶»à¶¯à·’à¶œ à¶†à¶œà¶¸à·Š', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(165, 'SANS E 23034', 'Vedic Litreture ', 'SANS E 23034', 'à·€à·›à¶¯à·’à¶š à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(166, 'SANS E 23044', 'Buddhist Sanskrit Literature', 'SANS E 23044', 'à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(169, 'SINH E 23034', 'à·ƒà·’à¶‚à·„à¶½ à¶±à·€à¶šà¶®à·à·€ à¶šà·™à¶§à·’à¶šà¶®à·à·€ à·€à·’à·à·Šà·€ à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'SINH E 23034', 'à·ƒà·’à¶‚à·„à¶½ à¶±à·€à¶šà¶®à·à·€ à¶šà·™à¶§à·’à¶šà¶®à·à·€ à·€à·’à·à·Šà·€ à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º à·„à· à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º à·€à·’à¶ à·à¶»à¶º', 'Language', '', 'Other', 8, '5 ', 'Yes', 0),
(170, 'SINH E 23044', 'à¶¢à¶±à·à·Šâ€à¶»à·à¶­à·’à¶º à·„à· à¶šà¶½à·à·à·’à¶½à·Šà¶´', 'SINH E 23044', 'à¶¢à¶±à·à·Šâ€à¶»à·à¶­à·’à¶º à·„à· à¶šà¶½à·à·à·’à¶½à·Šà¶´', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(171, 'BUPH E - 23034', 'Buddhist Schools - I  Theravada Schools', 'BUPH E - 23034', 'à¶±à·’à¶šà·à¶ºà·à¶±à·Šà¶­à¶» à¶¶à·”à¶¯à·” à·ƒà¶¸à¶º - I à¶®à·šà¶»à·€à·à¶¯ à¶œà·”à¶»à·”à¶šà·”à¶½', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(172, 'BUPH E - 23044', 'Buddhist Schools  II - Mahayana Schools', 'BUPH E - 23044', 'à¶±à·’à¶šà·à¶ºà·à¶±à·Šà¶­à¶» à¶¶à·”à¶¯à·”à·ƒà¶¸à¶º - II', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(173, 'BUCU E 23034', 'Geographical Expansion of Buddhist Culture in South and the East Asia', 'BUCU E 23034', 'à¶¯à¶šà·”à¶«à·” à·„à· à¶…à¶œà·Šà¶±à·’à¶¯à·’à¶œ à¶†à·ƒà·’à¶ºà·à·€à·š à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­à·’à¶ºà·š à¶·à·–à¶œà·à¶½à·“à¶º à·€à·Šâ€à¶ºà·à¶´à·Šà¶­à·’à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(174, 'BUCU E 23044', 'Buddhist Social Institutions', 'BUCU E 23044', 'à¶¶à·žà¶¯à·Šà¶° à·ƒà¶¸à·à¶¢ à·ƒà¶‚à·ƒà·Šà¶®à·', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(175, 'PALI E 33055', 'Pali Prescribed Texts - II', 'PALI E 33055', 'à¶´à·à¶½à·’ à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® - II ', 'Language', '', 'Other', 10, '5 ', 'No', 0),
(176, 'PALI E 33065', 'Pali Commentarial Literature', 'PALI E 33065', 'à¶´à·à¶½à·’ à¶…à¶§à·Šà¶¨à¶šà¶®à· à·ƒà·à·„à·’à¶­à·Šâ€à¶º', 'Language', '', 'Other', 10, '5 ', 'No', 0),
(177, 'ARCH E 33054', 'à¶…à¶·à·’à¶½à·šà¶›à¶± à·„à· à¶±à·à¶«à¶š à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'ARCH E 33054', 'à¶…à¶·à·’à¶½à·šà¶›à¶± à·„à· à¶±à·à¶«à¶š à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(178, 'ARCH E 33064', 'à¶´à·Šâ€à¶»à·à¶œà·Š à¶‰à¶­à·’à·„à·à·ƒà¶º à·„à· à¶´à¶»à·’à·ƒà¶» à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º', 'ARCH E 33064', 'à¶´à·Šâ€à¶»à·à¶œà·Š à¶‰à¶­à·’à·„à·à·ƒà¶º à·„à· à¶´à¶»à·’à·ƒà¶» à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(179, 'REST E 33054', 'Religion and Modern World', 'REST E 33054', 'à¶†à¶œà¶¸ à·„à· à¶±à·–à¶­à¶± à¶½à·à¶šà¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(180, 'REST E 33064', 'Religion and Comtemporary Issuse', 'REST E 33064', 'à¶†à¶œà¶¸ à·„à· à·ƒà¶¸à¶šà·à¶½à·“à¶± à¶œà·à¶§à¶½à·”', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(181, 'SANS E 33054', 'Sanskrit Literature and Inscription', 'SANS E 33054', 'à·à·Šâ€à¶»à·“ à¶½à¶‚à¶šà·à·€à·š à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º à·„à· à·ƒà·™à¶½à·Šà¶½à·’à¶´à·’', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(182, 'SANS E 33064', 'à·ƒà¶¸à·Šà¶·à·à·€à·Šâ€à¶º à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶œà¶¯à·Šâ€à¶º à¶šà·à·€à·Šâ€à¶º à·ƒà·à·„à·’à¶­', 'SANS E 33064', 'Classical Sanskrit Prose Poetic Literature', 'Other', '', 'Other', 8, '5 ', 'No', 0),
(185, 'SINH E 33054', 'à·ƒà¶¸à·Šà¶·à·à·€à·Šâ€à¶º à·ƒà·’à¶‚à·„à¶½ à¶œà¶¯à·Šâ€à¶º à·„à· à·ƒà·’à¶‚à·„à¶½ à·€à·Šâ€à¶ºà·à¶', 'SINH E 33064', 'à·ƒà¶¸à·Šà¶·à·à·€à·Šâ€à¶º à·ƒà·’à¶‚à·„à¶½ à¶œà¶¯à·Šâ€à¶º à·„à· à·ƒà·’à¶‚à·„à¶½ à·€à·Šâ€à¶ºà·à¶›à·Šâ€à¶ºà·à¶± à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(186, 'SINH E 33064', 'à¶±à·à¶§à·Šâ€à¶º à¶šà¶½à·à·€', 'SINH E 33064', 'à¶±à·à¶§à·Šâ€à¶º à¶šà¶½à·à·€', 'Language', '', 'Other', 8, '5 ', 'No', 0),
(187, 'BUPH E - 33054', 'Buddhist Social Philosophy', 'BUPH E - 33054', 'à¶¶à·žà¶¯à·Šà¶° à·ƒà¶¸à·à¶¢ à¶¯à¶»à·Šà·à¶±à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(188, 'BUPH E - 33064', 'Buddhism and Law', 'BUPH E - 33064', 'à¶¶à·”à¶¯à·” à¶¯à·„à¶¸ à·ƒà·„ à¶±à·“à¶­à·’à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(189, 'BUCU E 33054', 'Buddhist Culture in Central and East Asia', 'BUCU E 33054', 'à¶¸à¶°à·Šâ€à¶ºà¶¸ à¶†à·ƒà·’à¶ºà·à·€à·š à·„à· à¶±à·à¶œà·™à¶±à·„à·’à¶» à¶†à·ƒà·’à¶ºà·à·€à·š à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­à·’à¶º', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(190, 'BUCU E 33064', 'Buddhist Arts', 'BUCU E 33064', 'à¶¶à·žà¶¯à·Šà¶° à¶šà¶½à· à·à·’à¶½à·Šà¶´', 'Buddhist', '', 'Other', 8, '5 ', 'No', 0),
(191, 'EDAG 01', 'English language-Advanced Grammar', '', '', 'Language', 'Diploma', 'Other', 30, '7 ', 'Yes', 0),
(192, 'EDLP 02', 'English Literature-Poetry & Drama', '', '', 'Language', 'Diploma ', 'Other', 30, '7 ', 'Yes', 0),
(193, 'EDLF 03', 'English Literature:Fiction (Novels and Short Stories)', '', '', 'Language', 'Diploima', 'Other', 30, ' ', 'Yes', 0),
(194, 'EDWR 04', 'Advanced Writing and Reading', '', '', 'Language', 'Diploma', 'Other', 30, ' ', 'Yes', 0),
(195, 'EDSL 05', 'Speech and Listening', '', '', 'Other', '', 'Other', 30, ' ', 'Yes', 0),
(196, 'EDFB 06', 'Fundamental Teachings of Buddhism', '', '', 'Language', 'Diploma ', 'Frist Semester', 30, ' ', 'Yes', 0),
(197, 'EDBL 07', 'Buddhist Literature', '', '', 'Language', '', 'Other', 30, ' ', 'Yes', 0),
(198, 'EDLF 03', 'English Literature: Fiction (Novels and Short Stories)', '', '', 'Language', '', 'Frist Semester', 30, '7 ', 'Yes', 0),
(199, 'EDWR 04', 'Advanced Writing and Reading', '', '', 'Language', 'Diploma', 'Other', 30, '7 ', 'Yes', 0),
(200, 'EDSL 05', 'Speech and Listening', '', '', 'Language', 'Diploma', 'Other', 30, '7 ', 'Yes', 0),
(201, 'EDFB 06', 'Fundamental Teachings of Buddhism', '', '', 'Language', 'Diploma', 'Other', 30, '7 ', 'Yes', 0),
(202, 'EFBL 07', 'Buddhist Literature', '', '', 'Language', 'Diploma ', 'Other', 30, '7 ', 'Yes', 0),
(203, 'EGAW 01', 'English Grammar and writing', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '7 ', 'Yes', 0),
(204, 'RAC 02', 'Reading and Comprehension', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '7 ', 'Yes', 0),
(205, 'IL 04 ', 'English Literature (only the basics of literature)', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '7 ', 'Yes', 0),
(206, 'ILB 05', 'Buddhist Literature', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '7 ', 'Yes', 0),
(207, 'EGAW 01', 'English Grammar and Writing', '', '', 'Language', 'Certificate level', 'Other', 0, '7 ', 'Yes', 0),
(208, 'RAC 02', 'Reading and Comprehension ', '', '', 'Language', 'Certificate level', 'Other', 0, '7 ', 'Yes', 0),
(209, 'SAL 03', 'Speaking and listening', '', '', 'Language', 'Certificate level', 'Other', 0, '7 ', 'Yes', 0),
(210, 'ILB 05', 'Buddhist Literature (basic understanding of Buddhism)', '', '', 'Language', 'Certificate Level', 'Other', 0, '7 ', 'Yes', 0),
(211, '01', 'Grammar', '', '', 'Language', 'Certificate level', 'Other', 0, '8 ', 'Yes', 0),
(212, '02', 'Comprehension', '', '', 'Language', 'Certificate level', 'Other', 0, '8 ', 'Yes', 0),
(213, '03', 'Speech', '', '', 'Language', 'Certificate level', 'Other', 0, '8 ', 'Yes', 0),
(214, '04', 'Composition', '', '', 'Language', 'Certificate level', 'Other', 0, '8 ', 'Yes', 0),
(215, '01', 'Grammar', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '8 ', 'Yes', 0),
(216, '02', 'Comprehsnsion', '', '', 'Language', 'Advanced Certificate', 'Other', 0, '8 ', 'Yes', 0),
(217, '03', 'Speech', '', '', 'Other', 'Advanced Certificate', 'Other', 0, '8 ', 'Yes', 0),
(218, '04', 'Composition', '', '', 'Other', 'Advanced Certifiucat', 'Other', 0, '8 ', 'Yes', 0),
(219, 'DTML 33015', 'Tamil Grammar and Advanced Tamil Writing-I', '', '', 'Language', 'Diploma level', 'Other', 30, '8 ', 'Yes', 0),
(220, 'DTML 33025', 'Introduction to Tamil Literature I', '', '', 'Language', 'Diploma level', 'Other', 0, '8 ', 'Yes', 0),
(221, 'DTML 33035', 'Practice of Tamil usage and Conversations I', '', '', 'Language', 'Diploma Level', 'Other', 30, '8 ', 'Yes', 0),
(222, 'DTML 33045', 'Tamil Grammar and Advanced Tamil Writing II', '', '', 'Language', 'Diploma level', 'Other', 30, '8 ', 'Yes', 0),
(223, 'DTML 33055', 'Tamil language and Culture', '', '', 'Language', 'Diploma level', 'Other', 30, '8 ', 'Yes', 0),
(224, 'DTML 33065', 'Translation and Translation Methods I', '', '', 'Language', 'Diploma', 'Other', 30, '8 ', 'Yes', 0),
(225, 'HDTML43015', 'Tamil Grammar and Advanced Tamil Writing III', '', '', 'Language', 'Higher Diploma ', 'Other', 30, '8 ', 'Yes', 0),
(226, 'HDTML 43025', 'Introdction to Tamil Literature', '', '', 'Language', 'Higher Diploma', 'Other', 30, '8 ', 'Yes', 0),
(227, 'HDTML43025', 'Introduction to Tamil Literature II', '', '', 'Language', 'Higher Diploma', 'Other', 30, '8 ', 'Yes', 0),
(228, 'HDTML 43035', 'Practice of Tamil usage and conmversations II', '', '', 'Language', 'Higher Diploma', 'Other', 30, '8 ', 'Yes', 0),
(229, 'HDTML 43045', 'Introduction to Tamil Literature II', '', '', 'Language', 'Higher Diploma ', 'Other', 30, '8 ', 'Yes', 0),
(232, 'DBUS 33015', 'Fundamental Teachings of Buddhism', 'DBUS 33015', 'à¶¶à·”à¶¯à·”à·ƒà¶¸à¶ºà·š à¶¸à·”à¶½à·’à¶š à¶‰à¶œà·à¶±à·Šà·€à·’à¶¸à·’', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(233, 'DBUS 33025', 'Buddhist Sociology', 'DBUS 33025', 'à¶¶à·™à·Ÿà¶¯à·Šà¶° à·ƒà¶¸à·à¶¢ à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(234, 'DBUS 33035', 'Theravada Buddhist Culture', 'DBUs 33035', 'à¶®à·™à¶»à·€à·à¶¯ à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­à·’à¶º', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(235, 'DBUS 33045', 'Buddhist Tradition in Sri Lanka; Early Period', 'DBUS 33045', 'à·à·Šâ€à¶»à·“ à¶½à·à¶‚à¶šà·šà¶º à¶¶à·žà¶¯à·Šà¶° à·ƒà¶¸à·’à¶´à·Šâ€à¶»à¶¯à·à¶ºà¶­ à¶´à·”à¶»à·à¶­à¶± à¶ºà·”à¶œà¶º', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(236, 'BDUS 33055', 'Buddhism and World Religions', 'DBUS 3305', 'à¶¶à·”à¶¯à·”à·ƒà¶¸à¶º à·„à· à¶½à·à¶š à¶†à¶œà¶¸à·’', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(237, 'DBUS 33065', 'Introduction to Pali Language', 'DBUS 33065', 'à¶´à·à¶½à·’ à¶·à·à·‚à· à¶´à·Šâ€à¶»à·™à·€à·’à·à¶º', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(238, 'HDBUS 43015', 'Fundamental Teachings Of Mahayana Buddhism', 'HDBUS 43015', 'à¶¸à·„à·à¶ºà·à¶± à¶¶à·”à¶¯à·”à·ƒà¶¸à¶ºà·š à¶¸à·–à¶½à·’à¶š à¶‰à¶œà·à¶±à·Šà·€à·“à¶¸à·’', 'Buddhist', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(239, 'HDBUS 43025', 'Buddhist Psychology', 'HDBUS 43025', 'à¶¶à·žà¶¯à·Šà¶° à¶¸à¶±à· à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(240, 'HDBUS 43035', 'Practical Buddhism in Sri Lanka', 'HDBUS 43035', 'à·à·Šâ€à¶»à·“ à¶½à¶‚à¶šà·à·€à·™à·’ à·€à·Šâ€à¶ºà·€à·„à·à¶»à·’à¶š à¶¶à·”à¶¯à·”à·ƒà¶¸à¶º', 'Buddhist', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(241, 'HDBUS 43045', 'Buddhist Tradition in Sri Lanka;Modern Period', 'HDBUS 43045', 'à·à·Šâ€à¶»à·“ à¶½à·à¶‚à¶šà·šà¶º à¶¶à·žà¶¯à·Šà¶° à·ƒà¶¸à·’à¶´à·Šâ€à¶»à¶¯à·à¶º; à¶±à·–à¶­à¶± à¶ºà·”à¶œà¶º', 'Buddhist', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(242, 'HDBUS 43055', 'World Religions and Contemporary Issues', 'HDBUS 43055', 'à¶½à·à¶š à¶†à¶œà¶¸à·’ à·„à· à·ƒà¶¸à¶šà·à¶½à·“à¶± à¶œà·à¶§à¶½à·”', 'Buddhist', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(243, 'HDBUS 43065', 'Pali Language and Study of Tripitaka Literature', 'HDBUS 43065', 'à¶´à·à¶½à·’ à¶·à·à·‚à·à·€ à·„à· à¶­à·Šâ€à¶»à·’à¶´à·“à¶§à¶š à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(244, 'DPAL 33015', 'Prescribed Text 1', 'DPAL 33015', 'à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º 1', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(245, 'DPAL 33025', 'Prescribed Text 11', 'DPAL 33025', 'à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º 11', 'Language', 'SQLF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(246, 'DPAL 33035', 'Introduction to Pali Grammar', 'DPAL 33035', 'à¶´à·à¶½à·’ à·€à·Šâ€à¶ºà·à¶šà¶»à¶«   à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 1', 'Language', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(247, 'DPAL 33045', 'Pali Unprescribeb Text and Practice of Pali Language 1', 'DPAL 33045', 'à¶´à·à¶½à·’ à¶…à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à·„à· à¶´à·à¶½à·’ à¶·à·à·‚à· à¶´à¶»à·’à¶ à¶º 1', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(248, 'DPAL 33055', 'Study of Pali Tripitaka Literature', 'DPAL 33055', 'à¶­à·Šâ€à¶»à·’à¶´à·“à¶§à¶š à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º ', 'Language', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(249, 'DAPL 33065', 'Translations of Pali 1', 'DAPL 33065', 'à¶´à·à¶½à·’ à¶´à¶»à·’à·€à¶»à·Šà¶­à¶± 1', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(250, 'HDPAL 43015', 'Prescribed Texts 111', 'HDPAL 43015', 'à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º 111', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(251, 'HDAPL 43025', 'Prescribed Texts  1V', 'HDAPL 43025', 'à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à¶…à¶°à·Šâ€à¶ºà¶ºà¶±à¶º 1V', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(252, 'HDPAL 43035', 'Introduction to Pali Grammar 11', 'HDPAL 43035', 'à¶´à·à¶½à·’ à·€à·Šâ€à¶ºà·à¶šà¶»à¶«   à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 11', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(253, 'HDPAL 43045', 'Pali Unprescribeb Text and Practice of Pali Language 11 ', 'HDPAL 43045', 'à¶´à·à¶½à·’ à¶…à¶±à·’à¶»à·Šà¶¯à·’à·‚à·Šà¶§ à¶œà·Šâ€à¶»à¶±à·Šà¶® à·„à· à¶´à·à¶½à·’ à¶·à·à·‚à· à¶´à¶»à·’à¶ à¶º 11', 'Language', 'SLQF Level  04', 'Frist Semester', 30, '6', 'Yes', 0),
(254, 'HDPAL 43055', 'Dharma Concept Based on Tripitaka', 'HDPAL 43055', 'à¶­à·Šâ€à¶»à·’à¶´à·“à¶§à¶šà·à¶œà¶­ à¶°à¶»à·Šà¶¸ à·ƒà¶‚à¶šà¶½à·Šà¶´à¶º ', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(255, 'HDPAL 43065', 'Translations of Pali 11', 'HDPAL 43065', 'à¶´à·à¶½à·’ à¶´à¶»à·’à·€à¶»à·Šà¶­à¶± 11', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(256, 'DSNS 33015', 'Introduction to Sanskrit Grammar 1', 'DSNS 33015', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·€à·Šâ€à¶ºà·à¶šà¶»à¶«  à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 1', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(257, 'DSNS 33025', 'History of Sanskrit Literature 1', 'DSNS 33025', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶‰à¶­à·’à·„à·à·ƒà¶º 1', 'Language', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(258, 'DSNS 33035', 'Introduction to Buddhist Sanskrit Literature 1', 'DSNS 33035', 'à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 1', 'Buddhist', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(259, 'DSNS 33045', 'Sanskrit Poetic Literature 1', 'DSNS 33045', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶´à¶¯à·Šâ€à¶º à¶šà·à·€à·Šâ€à¶º à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º 1', 'Language', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(260, 'DSNS 33055 ', 'Didactic Literature 1', 'DSNS 33055', 'à¶‹à¶´à¶¯à·šà·à·à¶­à·Šà¶¸à¶š à¶šà¶®à· à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º 1', 'Language', 'SLQF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(261, 'DSNS 33065', 'Sanskrit Dramatic Literature 1', 'DSNS 33065', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶±à·à¶§à·Šâ€à¶º à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 1', 'Language', 'SQLF Level 03', 'Frist Semester', 30, '6', 'Yes', 0),
(262, 'HDSNS 43015', 'Introduction to Sanskrit Grammar 11', 'HDSNS 43015', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·€à·Šâ€à¶ºà·à¶šà¶»à¶«  à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 11', 'Language', 'SQLF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(263, 'HDSNS 43025', 'History of Sanskrit Literature 11', 'HDSNS 43025', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶‰à¶­à·’à·„à·à·ƒà¶º 11', 'Language', 'SQLF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(264, 'HDSNS 43035', 'Introduction to Buddhist Sanskrit Literature 11', 'HDSNS 43035', 'à¶¶à·žà¶¯à·Šà¶° à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à·ƒà·à·„à·’à¶­à·Šâ€à¶º à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 11', 'Language', 'SQLF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(265, 'HDSNS 43045', 'Sanskrit Poetic Literature 11', 'HDSNS 43045', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶´à¶¯à·Šâ€à¶º à¶šà·à·€à·Šâ€à¶º à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º 11', 'Language', 'SQLF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(266, 'HDSNS 43055', 'Didactic Literature 11', 'HDSNS 43055', 'à¶‹à¶´à¶¯à·šà·à·à¶­à·Šà¶¸à¶š à¶šà¶®à· à·ƒà·à·„à·’à¶­à·Šâ€à¶ºà¶º 11', 'Language', 'SLQF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(267, 'HDSNS 43065', 'Sanskrit Dramatic Literature 11', 'HDSNS 43065', 'à·ƒà¶‚à·ƒà·Šà¶šà·˜à¶­ à¶±à·à¶§à·Šâ€à¶º à¶´à·Šâ€à¶»à·€à·™à·’à·à¶º 11', 'Language', 'SQLF Level 04', 'Frist Semester', 30, '6', 'Yes', 0),
(268, '01', 'Buddhism and Psychology', '01', 'à¶¶à·”à¶¯à·” à¶¯à·„à¶¸ à·ƒà·„ à¶¸à¶±à·à·€à·’à¶¯à·Šâ€à¶ºà·à·€', 'Buddhist', 'Diploma', 'Other', 30, '9 ', 'Yes', 0),
(269, '02', 'Buddhism and Psychological Counselling', '01', 'à¶¶à·”à¶¯à·”à¶¯à·„à¶¸ à·ƒà·„ à¶‹à¶´à¶¯à·šà·à¶±à¶º', 'Buddhist', 'Diploma', 'Frist Semester', 30, '9 ', 'Yes', 0),
(270, 'MABS 93014', 'Philosophical Trends in Buddhism', 'MABS 93014', 'nqÃ¿iufha odÂ¾Yksl m%jK;d', 'Buddhist', '', 'Other', 30, ' ', 'Yes', 0),
(271, 'MABS 93014', 'Philosophical Trends in Buddhism', 'MABS 93014', '', 'Buddhist', 'SLQF 09', 'Other', 0, '3', 'Yes', 0),
(272, 'MABS 93024', 'Buddhism and Inter-Religious Philosophy ', 'MABS 93024', '', 'Buddhist', 'SLQF 09', 'Other', 0, '3', 'Yes', 3),
(273, 'MABS 93034', 'Buddhist Principles of Management', 'MABS 93034', '', 'Buddhist', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(274, 'MABS 93044', 'Buddhist Psychiatry', 'MABS 93044', '', 'Buddhist', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(275, 'MABS 93054', 'The Social Philosophy of Buddhism and the Modern World ', 'MABS 93054', '', 'Buddhist', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(276, 'MABS 93064', 'Research Methodology', 'MABS 93064', '', 'Buddhist', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(277, 'MABS 93074', 'Buddhist Art and Architecture in Sri Lanka ', 'MABS 93074', '', 'Buddhist', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(278, 'MAPL 93024', 'Pali prescribed Texts', 'MAPL 93024', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(279, '03', 'Western Psychological Counselling', '03', 'à¶¶à¶§à·„à·’à¶» à¶¸à¶±à· à¶‹à¶´à¶¯à·šà·à¶±à¶º', 'Buddhist', 'Diploma', 'Other', 30, '9 ', 'Yes', 0),
(280, 'MAPL 93034', 'Pali Grammar and composition of prose and verse ', 'MAPL 93034', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(281, 'MAPL 93044', 'Literature of Inter-Sectarian Texts', 'MAPl 93044', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(282, 'MAPl 93014', 'Philosophical Trends in Buddhism', 'MAPL 93014', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(283, 'MAPL 93054', 'Pali Poetry and Literary Criticism', 'MAPL 93054', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(284, 'MAPL 93064', 'Research Methodology', 'MAPL 93064', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(285, 'MASN 93014', 'Philosophical Trends in Buddhism', 'MASN 93014', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(286, '04', 'Counselling Techniques and Skills', '04', 'à¶‹à¶´à¶¯à·šà·à¶± à¶šà·Šâ€à¶»à¶¸ à·à·’à¶½à·Šà¶´ à·„à· à¶šà·”à·ƒà¶½à¶­à· ', 'Buddhist', 'Diploma', 'Frist Semester', 30, '9 ', 'Yes', 0),
(287, 'MASN 93024', 'Study of Prescribed Texts	I', 'MASN 93024', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(288, 'MASN 93034', 'Study of Prescribed Texts	II', 'MASN 93034', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(289, 'MASN 93044', 'Study of Prescribed Texts	III', 'MANS 93044', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(290, 'MASN 93054', ' Indian Culture and Civilization	', 'MANS 93054', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(291, 'MASN 93064', 'Research Methodology', 'MASN 93054', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(292, 'MAEN 93014', 'Philosophical Trends in Buddhism', 'MAEN 93014', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(293, 'MAEN 93024 ', 'Critical Reading and Writing', 'MAEN 93024', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(294, 'MAEN 93034', 'Poetry	', 'MAEN 93034', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 0),
(295, 'MAEN 93044', ' Fiction	', 'MAEN 93044', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 1),
(296, 'MAEN 93054', 'Language Pedagogy	', 'MAEN 93054', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 3),
(297, 'MAEN 93064', 'Research Methodology', 'MAEN 93064', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 3),
(298, 'MASI 93014', 'Philosophical Trends in Buddhism', 'MASI 93014', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 3),
(299, 'MASI 93024', '000', 'MASI 93024', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 1),
(300, 'MASI 93034 ', '000', 'MASI 93034 ', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 1),
(301, 'MASI 93044', '000', 'MASI 93044', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 2),
(302, 'MASI 93054 ', '000', 'MASI 93054 ', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 1),
(303, 'MASI 93064', 'Research Methodology', 'MASI 93064', '', 'Language', 'SLQF 09', 'Other', 30, '3', 'Yes', 3),
(304, 'ty', '45', 'hg', 'test', 'Buddhist', '', 'Second Semester', 0, '3 ', '', 1),
(305, 'A1001', 'chamila', 'chamila', 'chamila', 'Language', '', 'Second Semester', 0, '3 ', '', 5),
(306, '12', 'w', 'w', 'w', 'Language', '', 'Second Semester', 12, '3 ', '', 3),
(307, '13', 'w', 'w', 'w', 'Language', '', 'Second Semester', 1, '3 ', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subject_enroll`
--

CREATE TABLE IF NOT EXISTS `subject_enroll` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Enroll_id` int(11) NOT NULL,
  `subjectID` int(11) NOT NULL,
  `enroll_date` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `subject_enroll`
--

INSERT INTO `subject_enroll` (`ID`, `Enroll_id`, `subjectID`, `enroll_date`) VALUES
(1, 0, 875, '0000-00-00'),
(2, 0, 875, '2018-07-18'),
(3, 0, 875, '2018-07-18'),
(4, 0, 875, '2018-07-18'),
(5, 0, 875, '2018-07-18'),
(6, 0, 875, '2018-07-18'),
(7, 0, 875, '2018-07-18'),
(8, 0, 875, '2018-07-18'),
(9, 0, 0, '2018-07-18'),
(10, 0, 0, '2018-07-18'),
(11, 52, 1, '2018-02-12'),
(12, 55, 1, '2018-02-12'),
(13, 58, 1, '2018-02-12'),
(14, 60, 1, '2018-07-18'),
(15, 62, 1, '2018-07-18'),
(16, 64, 0, '2018-07-18'),
(17, 70, 1, '2018-07-18'),
(18, 70, 1, '2018-07-18'),
(19, 71, 271, '2018-07-18'),
(20, 71, 272, '2018-07-18'),
(21, 71, 274, '2018-07-18'),
(22, 72, 271, '2018-07-23'),
(23, 72, 272, '2018-07-23'),
(24, 72, 273, '2018-07-23'),
(25, 72, 274, '2018-07-23'),
(26, 73, 271, '2018-07-23'),
(27, 73, 272, '2018-07-23'),
(28, 73, 274, '2018-07-23'),
(29, 73, 277, '2018-07-23'),
(30, 73, 280, '2018-07-23'),
(31, 73, 281, '2018-07-23'),
(32, 75, 271, '2018-07-23'),
(33, 75, 272, '2018-07-23'),
(34, 75, 276, '2018-07-23'),
(35, 75, 277, '2018-07-23'),
(36, 75, 278, '2018-07-23'),
(37, 76, 271, '2018-07-24'),
(38, 76, 272, '2018-07-24'),
(39, 76, 273, '2018-07-24'),
(40, 89, 271, '2018-07-31'),
(41, 89, 273, '2018-07-31'),
(42, 99, 271, '2018-07-31'),
(43, 99, 272, '2018-07-31'),
(44, 99, 274, '2018-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `sub_enroll`
--

CREATE TABLE IF NOT EXISTS `sub_enroll` (
  `indexNo` varchar(20) NOT NULL,
  `subjectID` int(11) NOT NULL,
  `medium` varchar(10) DEFAULT NULL,
  `acYear` year(4) DEFAULT NULL,
  PRIMARY KEY (`indexNo`,`subjectID`),
  KEY `fk_sub_enroll_crs_enroll` (`indexNo`),
  KEY `fk_sub_enroll_subject` (`subjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_enroll`
--

INSERT INTO `sub_enroll` (`indexNo`, `subjectID`, `medium`, `acYear`) VALUES
('1234', 137, 'English', 2010),
('255', 152, 'English', 2010),
('255', 188, 'English', 2010),
('88', 133, 'English', 2010),
('88', 152, 'English', 2010);

-- --------------------------------------------------------

--
-- Table structure for table `timeslot`
--

CREATE TABLE IF NOT EXISTS `timeslot` (
  `slotID` int(11) NOT NULL,
  `dayOfWeekE` varchar(20) NOT NULL,
  `dayOfWeekS` varchar(50) NOT NULL,
  `timeSlot` varchar(20) NOT NULL,
  PRIMARY KEY (`slotID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE IF NOT EXISTS `timetable` (
  `subjectID` int(11) NOT NULL,
  `venueNo` varchar(10) NOT NULL,
  `epfNo` varchar(20) NOT NULL,
  `slotID` int(11) NOT NULL,
  `medium` varchar(10) NOT NULL,
  PRIMARY KEY (`subjectID`,`venueNo`,`epfNo`,`slotID`),
  KEY `FK_timetable_lecturer` (`epfNo`),
  KEY `FK_timetable_venue` (`venueNo`),
  KEY `FK_timetable_timeslot` (`slotID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE IF NOT EXISTS `user_tbl` (
  `userID` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `courseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`userID`, `password`, `courseID`) VALUES
('administrator', '21232f297a57a5a743894a0e4a801fc3', 0),
('phd', '202cb962ac59075b964b07152d234b70', 1),
('mphil', '5db638529f693643786e3d98f3bc2b4d', 2),
('ma', '202cb962ac59075b964b07152d234b70', 3),
('pgd', '7986ce197daf1130024377e1afcc4964', 4),
('ba', '202cb962ac59075b964b07152d234b70', 5),
('bdip', '87b546708959620eb7f47e5fc83f1cee', 6),
('edip', 'cc66aa9d169869c2881b1240c1e8134b', 7),
('tdip', '202cb962ac59075b964b07152d234b70', 8),
('bcdip', 'e64bc4a25b8c72288276c8a156371bae', 9);

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
  `venueNo` varchar(10) NOT NULL,
  `venue` varchar(20) NOT NULL,
  PRIMARY KEY (`venueNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crs_enroll`
--
ALTER TABLE `crs_enroll`
  ADD CONSTRAINT `fk_crs_enroll_course` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_crs_enroll_student` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `exameffort`
--
ALTER TABLE `exameffort`
  ADD CONSTRAINT `fk_exameffort_sub_enroll` FOREIGN KEY (`indexNo`, `subjectID`) REFERENCES `sub_enroll` (`indexNo`, `subjectID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `examschedule`
--
ALTER TABLE `examschedule`
  ADD CONSTRAINT `examschedule_ibfk_1` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON UPDATE CASCADE;

--
-- Constraints for table `sub_enroll`
--
ALTER TABLE `sub_enroll`
  ADD CONSTRAINT `fk_sub_enroll_crs_enroll` FOREIGN KEY (`indexNo`) REFERENCES `crs_enroll` (`indexNo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sub_enroll_subject` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `FK_timetable_lecturer` FOREIGN KEY (`epfNo`) REFERENCES `lecturer` (`epfNo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_timetable_subject` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_timetable_venue` FOREIGN KEY (`venueNo`) REFERENCES `venue` (`venueNo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`slotID`) REFERENCES `timeslot` (`slotID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
