-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2014 at 06:37 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseCode`, `nameEnglish`, `nameSinhala`, `courseType`) VALUES
(1, 'MA', 'Master of Arts (Buddist Studies) Sinhala  Meadiam', 'à·à·à·ƒà·Šà¶­à·Šâ€à¶»à¶´à¶­à·’ à¶‹à¶´à·à¶°à·’à¶º à·ƒà·’à¶‚à·„à¶½  à¶¸à·à¶°à·Šâ€à¶º (à¶¶à·žà¶¯à·Šà¶° à¶…à¶°à·Šâ€à¶ºà¶ºà¶±)', 'Master'),
(2, 'BA', 'Bacholar of Arts ( General) Examination', 'à·à·à·ƒà·Šà¶­à·Šâ€à¶»à·€à·šà¶¯à·“ (à·ƒà·à¶¸à·à¶±à·Šâ€à¶º) à¶¶à·à·„à·’à¶» à¶‹à¶´à·à¶°à·’à¶º', 'Bachelor'),
(3, 'MA', 'Master of Arts (Social Studies) Sinhala Meadiam', 'à·à·à·ƒà·Šà¶­à·Šâ€à¶»à¶´à¶­à·’ à¶‹à¶´à·à¶°à·’à¶º à·ƒà·’à¶‚à·„à¶½ à¶¸à·à¶°à·Šâ€à¶º (à·ƒà¶¸à·à¶¢ à¶…à¶°à·Šâ€à¶ºà¶ºà¶±)', 'Master');

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
('BA/G/2014/082 	', '082', 'EC/LS/2012/03', 2, 2015),
('BA/G/2014/85', '085', 'EC/LS/2012/01', 2, 2016),
('MA/BS/2014/099', '099', 'EC/LS/2012/11', 1, 2014);

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
  `marks1` int(11) DEFAULT NULL,
  `marks2` int(11) DEFAULT NULL,
  PRIMARY KEY (`effortID`),
  KEY `FK_exameffort_studentenrolment` (`indexNo`,`subjectID`),
  KEY `fk_exameffort_sub_enroll` (`indexNo`,`subjectID`),
  KEY `subjectID` (`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `exameffort`
--

INSERT INTO `exameffort` (`effortID`, `indexNo`, `subjectID`, `acYear`, `marks`, `grade`, `effort`, `marks1`, `marks2`) VALUES
(1, '082', 5, 2015, 68, 'B', 1, NULL, NULL),
(2, '085', 4, 2016, 89, 'A', 1, 87, 90);

-- --------------------------------------------------------

--
-- Table structure for table `examschedule`
--

CREATE TABLE IF NOT EXISTS `examschedule` (
  `subjectID` int(11) NOT NULL,
  `acYear` year(4) NOT NULL,
  `medium` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(20) NOT NULL,
  `venue` varchar(20) NOT NULL,
  PRIMARY KEY (`subjectID`,`acYear`,`medium`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examschedule`
--

INSERT INTO `examschedule` (`subjectID`, `acYear`, `medium`, `date`, `time`, `venue`) VALUES
(1, 2014, 'English', '2014-11-08', '9to12', 'Hall No1'),
(2, 2014, 'English', '2014-11-08', '1to4', 'Hall No1'),
(3, 2014, 'English', '2014-11-15', '9to12', 'Hall No1'),
(4, 2014, 'English', '2014-11-15', '1to4', 'Hall No1'),
(5, 2014, 'English', '2014-11-23', '9to12', 'Hall No1'),
(6, 2014, 'English', '2014-11-23', '1to4', 'Hall No1');

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
('1', 'asdf');

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
  PRIMARY KEY (`studentID`),
  UNIQUE KEY `nic` (`nic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `nic`, `title`, `nameEnglish`, `nameSinhala`, `addressE1`, `addressE2`, `addressE3`, `addressS1`, `addressS2`, `addressS3`, `contactNo`, `email`, `birthday`, `citizenship`, `nationality`, `religion`, `civilStatus`, `employment`, `employer`, `guardName`, `guardAddress`, `guardContactNo`) VALUES
('EC/LS/2012/01', '913111770V', 'Mr.', 'Mr. Herath Mudiyanselage Polwattegedara Chandana Manoj Weerarathna', '', '449/A, ', 'Piliyandala Road,.', ' Maharagama', '', '', '', '', '', '0000-00-00', '', 'Sri lankan', '', '', '', '', '', '', ''),
('EC/LS/2012/02', '891533942V', 'Ven.', 'Ven Kalawelgala Jinaratana Thero', '', 'Sri Wimalaramaya, ', 'St. Reeta Rd,', ' Rathmalana', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/03', '815264240V', 'Miss.', 'Mrs. Ranaweerasinghe Arachchillage Kanchana Dilruksi', '', '35/1A, ', 'Wekanda Rd, ', 'Homagama', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/04', '926880730V', 'Miss.', 'Miss. Thanthiri Wattage Puluni Madhushika ', '', '56/12, ', 'Sri Sangaraja Rd, ', 'Colombo 10', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/05', '791125090V', 'Ven.', 'Ven. Wegama Khemasara Thero', '', 'Sri Pannananda Maha Pirivena, ', 'Nagahawaththa Rd,', ' Maharagama', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/06', '890231500V', 'Mr.', 'Mr. Omaththage Dilantha Amila Perera', '', '66/C, ', 'Temple Rd, ', 'Diulpitiya, Boralesgamuwa', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/07', '842393540V', 'Ven.', 'Ven. Karagahawala Chandananda Thero', '', 'Rajamaha Viharaya, ', 'Bellanvila, ', 'Boralesgamuwa', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/08', '843323707V', 'Mr.', 'Mr. Pandura Acharige Jagath Perera', '', '165, ', 'Kajugahawaththa, ', 'Gothatuwa, Angoda', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/09', '903494301V', 'Ven.', 'Ven. Mahawewe Muditha Thero', '', 'Sri Wimalaramaya,', ' St. Reeta Rd, ', 'Rathmalana', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/10', '880703340V', 'Ven.', 'Ven. Okkampitiye Vidyananda Thero', '', 'Rajamaha Viharaya, ', 'Bellanvila, ', 'Boralesgamuwa', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/11', '912443795V', 'Ven.', 'Ven. Asirigama Pannananda Thero', '', 'No. 28/H, ', 'Sangharaja Viharaya, ', 'Saranankara Rd, Dehiwala.', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/12', '922202630V', 'Ven.', 'Ven. Mahaindiweva Piyarathana Thero', '', '58/11 A, ', 'Sri Saddarmaramaya, Neelammahara Rd, ', 'Godigamuwa, Maharagama', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/13', '923393843V', 'Ven.', 'Ven. Kotapola Damitha Thero', '', 'Weheragoda Ancent  Temple, ', 'Sedawaththa, ', 'Wellampitiya', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/14', '571112426V', 'Mr.', 'Mr. Naranpitage Percy Chandranath Perera', '', '149/1,', 'Temple Rd,Thalapathpitiya,', ' Nugegoda', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/15', '490313354V', 'Mr.', 'Mr. Wijayasiri Mihindukulasuriya', '', '1/D2, ', 'Galwalalanda Mawatha, ', 'Makuluduwa, Piliyandala', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/16', '922853576V', 'Ven.', 'Ven. Thalangalle Anuruddha Thero', '', 'Vidyodaya Pirivena, ', 'Maligakanda Road,', ' Colombo 10.', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/17', '921912757V', 'Ven.', 'Ven. Kirigalwewe Wimalabuddhi Thero', '', 'No. 149,', ' Deniya Road, Siyambalagoda,', ' Polgasowita.', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/18', '912813762V', 'Ven.', 'Ven. Delthara Gnanananda Thero', '', 'Siri Gangaramaya, Delthara, Piliyandala.', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/19', '923091084V', 'Ven.', 'Ven. Pitakele Kusaladamma Thero', '', 'Mayurapada Pirivena, Thalangama South, Pelawatta, ', 'Battaramulla', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/20', '891013191V', 'Ven.', 'Ven. Mapalagama Vajira Thero', '', 'Samadhi Buddhist Centre, Kothalawalapura, ', 'Rathmalana.', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/21', '860033330V', 'Ven.', 'Ven. Kaduruwelene Sarada Thero', '', 'Jayathilakarama Purana Viharaya, Dutugemunu Mawath', 'Peliyagoda.', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/22', '651810582V', 'Mr.', 'Mr. Wanasingha Mudiyanselage Karunarathne', '', '106/4 A, Pitipana North, ', 'Homagama.', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/23', '656961333V', 'Ven.', 'Mrs. Induruwa Gamage Koshali Kanchanamala Kalyanarathne', '', '106/4 A, Pitipana North, Homagama.', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/24', '', 'Miss.', 'Ms. Bulathsinhalage Dona Vasundara Bulathsinhala', '', '03rd Mile Post, Panalawa, Watareka, Padukka.', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/25', '843053092 ', 'Ven.', 'Ven. Embilipitiye Rathanajothi Thero', '', 'Siri Thisarana Dharmayathanaya, Mawiththara,.', ' Piliyandala', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/26', '925201502V', 'Ven.', 'Miss. Ajani Dilunika Mendis', '', '427/A3, Dematagolla, Horompella, Minuwangoda', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/27', '595501849V', 'Ven.', 'Nawalapitiye Khemadhammani Silmatha', '', 'Luwisa Meheni Aramaya, Pathigoda, Badalgama', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/28', '893124837V', 'Ven.', 'Ven. Etampitiye Sirisarananda Thero', '', 'Baudhist Centre Viharaya, National Housing Scheme,', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/29', '891233841V', 'Mr.', 'Mr. Maddumage Kasun Ravindu Maddumage', '', '191-F, Ihala Yagoda, Gampaha', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', ''),
('EC/LS/2012/30', '  70589232', 'Mrs.', 'Mrs. Kumarasingha Matara Arachchige Yasoma Indrakanthi', '', '32, Natha devala Rd, Galborella, Kelaniya', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subjectID` int(11) NOT NULL AUTO_INCREMENT,
  `codeEnglish` varchar(20) DEFAULT NULL,
  `nameEnglish` varchar(300) DEFAULT NULL,
  `codeSinhala` varchar(30) DEFAULT NULL,
  `nameSinhala` varchar(100) DEFAULT NULL,
  `faculty` varchar(30) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `semester` varchar(30) NOT NULL,
  `creditHours` float DEFAULT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectID`, `codeEnglish`, `nameEnglish`, `codeSinhala`, `nameSinhala`, `faculty`, `level`, `semester`, `creditHours`) VALUES
(1, 'P.F.E 101', 'English Language - Advanced Grammar', '', '', 'Language', 'Diploma Level', 'Frist Semester', 0),
(2, NULL, 'English Literature - Poetry & Drama', NULL, NULL, NULL, 'Diploma Level', '', NULL),
(3, '', 'English Language - Advanced Writing & Reading', NULL, NULL, NULL, 'Diploma Level', '', NULL),
(4, NULL, 'Buddhist Literature', NULL, NULL, NULL, 'Diploma Level', '', NULL),
(5, 'P.F.E 108', 'English Literature - Fiction', NULL, NULL, NULL, 'Diploma Level', '', NULL),
(6, NULL, 'English Language - Oral Test', NULL, NULL, NULL, 'Diploma Level', '', NULL),
(7, NULL, '', NULL, NULL, NULL, 'Diploma Level', '', NULL);

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
('082', 5, 'Sinhala', 2015),
('085', 2, 'English', 2016),
('085', 4, 'Sinhala', 2016);

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

INSERT INTO `timeslot` (`slotID`, `dayOfWeekE`, `dayOfWeekS`, `timeSlot`) VALUES
(1, '4', '2', '0009-1200'),
(2, '4', '2', '1300-1600');

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

INSERT INTO `timetable` (`subjectID`, `venueNo`, `epfNo`, `slotID`, `medium`) VALUES
(1, '1', '1', 1, 'English'),
(2, '1', '1', 2, 'English'),
(3, '1', '1', 1, 'English'),
(4, '1', '1', 2, 'English'),
(5, '1', '1', 1, 'English'),
(6, '1', '1', 2, 'English'),
(7, '1', '1', 1, 'English');

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
('1', 'Hall No1');

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
  ADD CONSTRAINT `exameffort_ibfk_3` FOREIGN KEY (`indexNo`) REFERENCES `sub_enroll` (`indexNo`),
  ADD CONSTRAINT `exameffort_ibfk_4` FOREIGN KEY (`subjectID`) REFERENCES `sub_enroll` (`subjectID`),
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
