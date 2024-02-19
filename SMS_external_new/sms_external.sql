-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2011 at 03:14 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sms_external`
--
CREATE DATABASE `sms_external` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sms_external`;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` int(11) NOT NULL,
  `nameEnglish` varchar(100) DEFAULT NULL,
  `nameSinhala` varchar(300) DEFAULT NULL,
  `courseType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `nameEnglish`, `nameSinhala`, `courseType`) VALUES
(1, 'Diploma in English', 'à¶‰à¶‚à¶œà·Šâ€à¶»à·“à·ƒà·’ à¶©à·’à¶´à·Š', 'Diploma'),
(2, 'Diploma in Sinhala', 'Diploma in Sinhala', 'Diploma');

-- --------------------------------------------------------

--
-- Table structure for table `crs_enroll`
--

CREATE TABLE IF NOT EXISTS `crs_enroll` (
  `regNo` varchar(20) NOT NULL,
  `indexNo` varchar(20) NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `courseID` int(11) NOT NULL,
  `yearEntry` year(4) DEFAULT NULL,
  PRIMARY KEY (`regNo`),
  UNIQUE KEY `indexNo_UNIQUE` (`indexNo`),
  KEY `fk_crs_enroll_course` (`courseID`),
  KEY `fk_crs_enroll_student` (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crs_enroll`
--

INSERT INTO `crs_enroll` (`regNo`, `indexNo`, `studentID`, `courseID`, `yearEntry`) VALUES
('reg1', 'index1', '1', 1, 2008);

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
  PRIMARY KEY (`effortID`),
  KEY `FK_exameffort_studentenrolment` (`indexNo`,`subjectID`),
  KEY `fk_exameffort_sub_enroll` (`indexNo`,`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `exameffort`
--

INSERT INTO `exameffort` (`effortID`, `indexNo`, `subjectID`, `acYear`, `marks`, `grade`, `effort`) VALUES
(1, 'index1', 1, 2009, 61, 'B', 1);

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

--
-- Dumping data for table `examschedule`
--

INSERT INTO `examschedule` (`subjectID`, `acYear`, `medium`, `date`, `time`, `venue`) VALUES
(1, 2009, 'English', '2010-12-28', '12:00:00', 'A1,A2');

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


-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentID` varchar(20) NOT NULL,
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
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `title`, `nameEnglish`, `nameSinhala`, `addressE1`, `addressE2`, `addressE3`, `addressS1`, `addressS2`, `addressS3`, `contactNo`, `email`, `birthday`, `citizenship`, `nationality`, `religion`, `civilStatus`, `employment`, `employer`, `guardName`, `guardAddress`, `guardContactNo`) VALUES
('1', 'Mr.', 'Upul Bulathsinhala', 'à¶‹à¶´à·”à¶½à·Š à¶¶à·”à¶½à¶­à·Šà·ƒà·’à¶‚à·„à¶½', '2/217,', 'Egodawatta Rd,', 'Boralesgamuwa.', '2/217,', 'à¶‘à¶œà·œà¶©à·€à¶­à·Šà¶­ à¶´à·à¶»,', 'à¶¶à·œà¶»à¶½à·à·ƒà·Šà¶œà¶¸à·”à·€.', '0772303990', 'upulbl@gmail.com', '1980-04-17', 'Sri Lanka', 'Sinhala', 'Buddhism', 'Married', 'Eng', 'ACCIMT', '', '', '');

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
('index1', 1, 'English', 1950);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subjectID` int(11) NOT NULL AUTO_INCREMENT,
  `codeEnglish` varchar(20) DEFAULT NULL,
  `nameEnglish` varchar(30) DEFAULT NULL,
  `codeSinhala` varchar(30) DEFAULT NULL,
  `nameSinhala` varchar(100) DEFAULT NULL,
  `faculty` varchar(30) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectID`, `codeEnglish`, `nameEnglish`, `codeSinhala`, `nameSinhala`, `faculty`, `level`, `description`) VALUES
(1, 's1', 'subject 1', 's1', 'subject 1', 'Buddhist', '1', 'sdfsdfds');

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

--
-- Dumping data for table `timeslot`
--


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

--
-- Dumping data for table `timetable`
--


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
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venueNo`, `venue`) VALUES
('1', 'A1'),
('2', 'A2'),
('3', 'B1');

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
