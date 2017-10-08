-- Host: localhost
		-- Generation Time: Jun 12, 2014 at 02:04 PM
		-- Server version: 5.6.12-log
		-- PHP Version: 5.4.16
		
		SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
		SET time_zone = "+00:00";
		
		
		/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
		/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
		/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
		/*!40101 SET NAMES utf8 */;
		
		--
		-- Database: enrolmentsystem
		--
		CREATE DATABASE IF NOT EXISTS enrolmentsystem DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
		USE enrolmentsystem;
/*---------------------------------------------------------------
  TABLE: `assessmentoffee`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `assessmentoffee`;
CREATE TABLE `assessmentoffee` (
  `TNO` int(11) NOT NULL AUTO_INCREMENT,
  `DateOfAssessment` varchar(255) NOT NULL,
  `MiscFee` varchar(255) NOT NULL,
  `TuitionFee` varchar(255) NOT NULL,
  `StudentIDNumber` varchar(255) NOT NULL,
  `RegistrationCode` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `MiscBreakdown` varchar(255) NOT NULL,
  PRIMARY KEY (`TNO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
INSERT INTO `assessmentoffee` VALUES   ('2','2015-05-07 22:58:36','4880','3000','15-OUS-0001','356a19','','');
INSERT INTO `assessmentoffee` VALUES ('4','2015-05-07 23:29:57','2155','4500','15-OUS-0002','b6589f','Fully Paid','');
INSERT INTO `assessmentoffee` VALUES ('5','2015-05-08 15:09:10','2305','2820','15-3GS-M-004','ac3478','','');

/*---------------------------------------------------------------
  TABLE: `cashier`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `cashier`;
CREATE TABLE `cashier` (
  `TNO` int(11) NOT NULL AUTO_INCREMENT,
  `StudentIDNumber` varchar(255) NOT NULL,
  `DateOfPayment` varchar(255) NOT NULL,
  `AmountPaid` int(11) NOT NULL,
  `RecieptNumber` varchar(255) NOT NULL,
  `RegistrationCode` varchar(255) NOT NULL,
  PRIMARY KEY (`TNO`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
INSERT INTO `cashier` VALUES   ('1','15-OUS-0002','2015-05-03','500','123456','1b6453');
INSERT INTO `cashier` VALUES ('18','15-OUS-0003','2015-05-02','300','1059596','');
INSERT INTO `cashier` VALUES ('19','15-OUS-0001','2015-05-03','1000','1059597','');
INSERT INTO `cashier` VALUES ('20','15-OUS-0001','2015-05-07','500','1111111','');
INSERT INTO `cashier` VALUES ('21','15-OUS-0003','2015-05-07','305','1231223','');
INSERT INTO `cashier` VALUES ('22','15-OUS-0002','2015-05-07','4000','213522','b6589f');
INSERT INTO `cashier` VALUES ('23','15-OUS-0002','2015-05-07','2655','453564','b6589f');
INSERT INTO `cashier` VALUES ('24','15-OUS-0001','2015-05-08','5000','343454','356a19');
INSERT INTO `cashier` VALUES ('26','15-OUS-0001','2015-05-11','1000','394827','356a19');

/*---------------------------------------------------------------
  TABLE: `courses`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `CourseNumber` int(11) NOT NULL AUTO_INCREMENT,
  `CourseCode` varchar(10) NOT NULL,
  `DescriptiveTitle` varchar(255) NOT NULL,
  `Units` varchar(255) NOT NULL,
  `Lab` varchar(255) NOT NULL,
  `CourseTitle` varchar(255) NOT NULL,
  `Program` varchar(255) NOT NULL,
  PRIMARY KEY (`CourseNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;
INSERT INTO `courses` VALUES   ('1','Aqua 201','Project Development Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('2','Aqua 202','Soil and Water Quality Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('3','Aqua 203','Fish Genetics and Breeding','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('4','Aqua 204','Research Design and Analysis','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('5','Aqua 211','Advances in Hatchery/Nursery Operation and Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('6','Aqua 212','Advances in Fishing Health Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('7','Aqua 213','Advances in Aquaculture Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('8','Aqua 214','Advances in Aquaculture Engineering','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('9','Aqua 215','Advances in Fish Nutrition','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('10','Aqua 216','Coastal Resource Management','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('11','Aqua 217','Aquaculture Entrepreneurship','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('12','Aqua 218','Advances in Fish Stock Assessment','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('13','Aqua 219','Basic Computer Applications for Fisheries Management','3','1','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('14','Aqua 220','Aquaculture Extension and Communication','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('15','Aqua 221','Integrated Fish Farming','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('16','Aqua 222','Post-Harvest Technology','3','','MASTER OF SCIENCE IN AQUACULTURE (MS Aqua)','Masteral');
INSERT INTO `courses` VALUES ('17','AF 201','Experiencing Designs and Analysis','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('18','AF 202','Biochemistry','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('19','AF 203','Project Development','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('20','AF 204','Methods of Research','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('21','AS 211','Advanced Poultry and Livestock Diseases and Parasites','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('22','AS 212','Advanced Animal Reproduction','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('23','AS 213','Advanced Swine Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('24','AS 214','Advanced Poultry Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('25','AS 215','Advanced Small and Large Ruminants Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('26','AS 216','Environmental Physiology','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('27','AE 211','Adult Education in Agriculture','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('28','AE 212','Rural Sociology','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('29','AE 213','Extension Approaches and Methods','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('30','AS 217','Computer Applications in Agriculture','3','1','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('31','AS 299','Thesis Writing','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('32','AF 201','Experiencing Designs and Analysis','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('33','AF 202','Biochemistry','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('34','AF 203','Project Development','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('35','AF 204','Methods of Research','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('36','CS 211','Advanced Field Crops Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('37','CS 212','Advanced Fruit Crops Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('38','CS 213','Advanced vegetable Crops Production','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('39','CS 214','Post-Harvest Technology','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('40','CS 215','Advanced Plant Pests and Diseases','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('41','CS 216','Advanced Soil and Water Management','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('42','AE 211','Adult Education in Agriculture','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('43','AE 212','Rural Sociology','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('44','AE 213','Extension Approaches and Methods','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('45','CS 217','Computer Applications in Agriculture','3','1','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('46','CS 299','Thesis Writing','3','','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN CROP SCIENCE','Masteral');
INSERT INTO `courses` VALUES ('47','FDM 210','Principles and Processes of development Management','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('48','FDM 202','Ethics and Accountability in Public Services','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('49','FDM 203','Methods of  Research','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('50','FDM 204','Social Statistics','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('51','DM 211','Project Development and Management','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('52','DM 212','Human Resource Management','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('53','DM 213','Fiscal Administration','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('54','DM 214','Strategic Planning','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('55','DM 215','Local Government and Regional Administration','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('56','DM 216','Public Policy and Program','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('57','DM 217','Organizational Studies','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('58','DM 218','Human Behavior in Organization','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('59','DM 219','Change and Disaster Management','3','','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('60','Comp. 1','Word Processing, Spreadsheet and Using Multi-Media and Internet','3','1','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('61','Comp. 2','Statistical Analysis Using Computer','3','1','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('62','DM 299','Thesis Writing','3','1','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','Masteral');
INSERT INTO `courses` VALUES ('63','EDF 201','Philo-Psycho Foundations of Education','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('64','EDF 204','Statistics in Education','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('65','EDF 202','Socio-Anthro Foundations of Education','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('66','EDF 205','Educational Management','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('67','EDM 211','Institutional Fiscal Management','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('68','EDM 212','Program/Project Planning and Evaluation','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('69','EDM 213','Legal Bases Education and Policy Analysis','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('70','EDM 214','Personnel Management','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('71','EDM 215','Curriculum Development','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('72','EDM 216','Dynamics of Rural Development','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('73','EDM 217','Seminar in Manpower Development','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('74','IL 211','Communications for School Managers','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('75','IL 212','Teaching-Learning Environment','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('76','IL 213','Transformational Leadership','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('77','IL 214','Instructional Supervisor','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('78','IL 215','Staff Development','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('79','IL 216','School Based Evaluation','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('80','IL 217','Innovation/Change in the Classroom','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('81','IL 218','Practicum in Instructional Leadership','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('82','Comp. 1','Word Processing, Spreadsheet and Using Multi-media and Internet','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('83','Comp. 2','Statistical Analysis Using Computer','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('84','EDM 299','Thesis Writing','3','','MASTER OF ATRS IN EDUCATION MAJORS IN EDUCATIONAL MANAGEMENT AND INSTRUCTIONAL LEADERSHIP','Masteral');
INSERT INTO `courses` VALUES ('85','EDM 301','Seminar in Advanced Research','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('86','EDM 302','Seminar in Advanced Sociology of Education','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('87','EDM 303','Seminar in Advanced Psychology of Education','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('88','EDM 304','Seminar in Advanced Philosophy of Education','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('89','EDM 311','Management of Educational Institutions','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('90','EDM 312','Financing Educational Systems','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('91','EDM 313','Human Resource Development in Education','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('92','EDM 314','Dynamics and Ecology of Education and Management','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('93','EDM 315','Educational Innovations and Technology','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('94','EDM 316','Advance Human Behavior in Organization','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('95','EDM 317','Management Communication Systems','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('96','EDM 318','Comparative Educational Management Systems','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('97','EDM 319','Practicum in Management of Educational Institutions','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('98','EDM 331','Crisis Management On Indigenous Decision making Pattern','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('99','EDM 332','Educational Evaluation Pattern','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('100','EDM 333','Policy Process and Analysis','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('101','EDM 334','Management Information Systems','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('102','COMP. 1','Word Processing, Spreadsheet and Using Multi-media and Internet','3','','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('103','COMP. 2','Statistical Analysis Using Computer','3','1','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');
INSERT INTO `courses` VALUES ('104','EDM 299 ','Dissertation Writing','3','1','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','Doctoral');

/*---------------------------------------------------------------
  TABLE: `enrolledsubject`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `enrolledsubject`;
CREATE TABLE `enrolledsubject` (
  `TNO` int(11) NOT NULL AUTO_INCREMENT,
  `StudentIDNumber` varchar(255) NOT NULL,
  `CourseCode` varchar(255) NOT NULL,
  `Professor` varchar(255) NOT NULL,
  `Rating` varchar(255) NOT NULL,
  `YearSem` varchar(255) NOT NULL,
  `RegistrationCode` varchar(255) NOT NULL,
  `DateOfEnrolment` varchar(255) NOT NULL,
  `StudentStatus` varchar(255) NOT NULL,
  PRIMARY KEY (`TNO`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
INSERT INTO `enrolledsubject` VALUES   ('1','15-OUS-0002','EDM 316','Dr. Manolito C. Manuel','3','2015/Summer','b6589f','','');
INSERT INTO `enrolledsubject` VALUES ('8','15-OUS-0001','Aqua 201','Dr. Lydia C. Buduhan','','2015/Summer','356a19','','');
INSERT INTO `enrolledsubject` VALUES ('9','15-OUS-0001','Aqua 202','Dr. Alfredo F. Aquino','','2015/Summer','356a19','','');
INSERT INTO `enrolledsubject` VALUES ('10','15-OUS-0003','Aqua 203','','','2015/Summer','77de68','','');
INSERT INTO `enrolledsubject` VALUES ('11','15-OUS-0003','Aqua 204','','','2015/Summer','77de68','','');
INSERT INTO `enrolledsubject` VALUES ('18','15-OUS-0002','AF 201','Dr. Priscilla L. Jimenez','','2015/Summer','902ba3','','');
INSERT INTO `enrolledsubject` VALUES ('19','15-OUS-0002','AF 202','Dr. Priscilla L. Jimenez','','2015/Summer','902ba3','','');
INSERT INTO `enrolledsubject` VALUES ('20','15-OUS-0002','AF 204','Dr. Priscilla L. Jimenez','','2015/Summer','902ba3','','');
INSERT INTO `enrolledsubject` VALUES ('22','11-OUS-1111','AF 202','PSU LC','1.75','2015/Summer','','','');
INSERT INTO `enrolledsubject` VALUES ('23','11-OUS-1111','AF 203','PSU LC','1.50','2015/Summer','','','');
INSERT INTO `enrolledsubject` VALUES ('24','11-OUS-1111','AF 204','PSU LC','2.00','2015/Summer','','','');
INSERT INTO `enrolledsubject` VALUES ('26','11-OUS-1111','AS 211','PSU LC','3.00','2015/Summer','','','');
INSERT INTO `enrolledsubject` VALUES ('27','11-OUS-1111','AS 212','PSU LC','1.75','2015/Summer','','','');
INSERT INTO `enrolledsubject` VALUES ('28','11-OUS-1111','AS 213','STI','2.00','2015/Summer','','','');

/*---------------------------------------------------------------
  TABLE: `faculty`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `TNO` int(11) NOT NULL AUTO_INCREMENT,
  `ProfessorName` varchar(255) NOT NULL,
  `SubjectNumber` varchar(255) NOT NULL,
  PRIMARY KEY (`TNO`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
INSERT INTO `faculty` VALUES   ('1','Dr. Manolito C. Manuel','94');
INSERT INTO `faculty` VALUES ('2','Dr. Lydia C. Buduhan','1');
INSERT INTO `faculty` VALUES ('3','Dr. Alfredo F. Aquino','2');
INSERT INTO `faculty` VALUES ('4','Dr. Priscilla L. Jimenez','17');
INSERT INTO `faculty` VALUES ('5','Mr. Antonio F. De Guzman','60');
INSERT INTO `faculty` VALUES ('6','Dr. Nelia C. Resultay','48');
INSERT INTO `faculty` VALUES ('7','Dr. Sally A. Jarin','');
INSERT INTO `faculty` VALUES ('8','Dr. Irmina B. Francisco','');
INSERT INTO `faculty` VALUES ('9','Dr. Rosie S. Abalos','');
INSERT INTO `faculty` VALUES ('10','Dr. Ruby Rosa V. Cruz','');
INSERT INTO `faculty` VALUES ('11','Dr. Reynaldo T. Gelido','');

/*---------------------------------------------------------------
  TABLE: `fee`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `fee`;
CREATE TABLE `fee` (
  `FeeNumber` int(11) NOT NULL AUTO_INCREMENT,
  `FeeName` varchar(255) NOT NULL,
  `FeePrice` varchar(255) NOT NULL,
  `FeePrice2` varchar(5) NOT NULL COMMENT 'International Student''s fee',
  `Required` varchar(1) NOT NULL,
  PRIMARY KEY (`FeeNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
INSERT INTO `fee` VALUES   ('3','Registration','630','1130','1');
INSERT INTO `fee` VALUES ('4','Units(Masteral)','1500','1000','');
INSERT INTO `fee` VALUES ('5','Units(Doctoral)','470','1000','');
INSERT INTO `fee` VALUES ('7','Library','200','500','1');
INSERT INTO `fee` VALUES ('8','School Publication/Journal','150','200','1');
INSERT INTO `fee` VALUES ('9','Entrance Fee(New Student)','100','300','');
INSERT INTO `fee` VALUES ('10','Students Body Organization','75','150','1');
INSERT INTO `fee` VALUES ('11','Identification Card','100','100','1');
INSERT INTO `fee` VALUES ('12','Computer Laboratory Fee/Subject','600','1000','');
INSERT INTO `fee` VALUES ('13','Internet','200','500','1');
INSERT INTO `fee` VALUES ('14','Dropping/Changing/Adding of Subject','75','100','2');
INSERT INTO `fee` VALUES ('15','Development Fee','500','1000','1');
INSERT INTO `fee` VALUES ('16','Late Registration','200','1000','');
INSERT INTO `fee` VALUES ('17','Authentication','100','200','2');
INSERT INTO `fee` VALUES ('18','Completion','100','200','2');
INSERT INTO `fee` VALUES ('19','Class Card','30','50','2');
INSERT INTO `fee` VALUES ('20','Certification','100','200','2');
INSERT INTO `fee` VALUES ('21','Accreditation','100','200','2');
INSERT INTO `fee` VALUES ('22','Transfer Credential','100','200','2');
INSERT INTO `fee` VALUES ('23','DOC STAMP TAX','30','50','2');
INSERT INTO `fee` VALUES ('24','Graduation','700','1000','2');
INSERT INTO `fee` VALUES ('25','Alumni','200','500','2');
INSERT INTO `fee` VALUES ('26','Chinese Payments','1000','1000','2');
INSERT INTO `fee` VALUES ('27','Diploma','500','1000','2');
INSERT INTO `fee` VALUES ('28','Panel Dissertation','250','500','2');
INSERT INTO `fee` VALUES ('29','COMPRE','500','700','2');

/*---------------------------------------------------------------
  TABLE: `settings`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `SettingsID` varchar(255) NOT NULL,
  `SettingsLabel` varchar(255) NOT NULL,
  `SettingsStatus` varchar(255) NOT NULL,
  PRIMARY KEY (`SettingsID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `settings` VALUES   ('77de68daecd823babbb58edb1c8e14d7106e83bb','CutOffDate','2015-05-20 00:00:00');
INSERT INTO `settings` VALUES ('77de68daecd823babbb58edb1c8e14d7106e83bc','EnrolmentCutOffDate','2015-06-16 00:00:00');

/*---------------------------------------------------------------
  TABLE: `students`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `StudentID` varchar(255) NOT NULL DEFAULT '',
  `StudentIDNumber` varchar(255) NOT NULL,
  `StudentFirstName` varchar(255) NOT NULL,
  `StudentMiddleName` varchar(255) NOT NULL,
  `StudentSurname` varchar(255) NOT NULL,
  `StudentGender` varchar(255) NOT NULL,
  `StudentAddress` varchar(255) NOT NULL,
  `StudentMobileNumber` varchar(255) NOT NULL,
  `StudentCivilStatus` varchar(255) NOT NULL,
  `StudentDateOfBirth` varchar(255) NOT NULL,
  `StudentEmail` varchar(255) NOT NULL,
  `StudentGuardian` varchar(255) NOT NULL,
  `StudentGuardianMobileNumber` varchar(255) NOT NULL,
  `StudentPicture` varchar(255) NOT NULL DEFAULT 'Default.png',
  `StudentWorkHistory` varchar(255) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `students` VALUES   ('1b6453892473a467d07372d45eb05abc2031647a','15-OUS-0004','Christian','Aquino','Fajardo','Male','3 Malued District DAgupan City','09167848750','Married','February 13, 1983','Fajardo@yahoo.com','Rex Fajardo','09187542847','Default.png','');
INSERT INTO `students` VALUES ('356a192b7913b04c54574d18c28d46e6395428ab','15-OUS-0002','Rufo','Narcisi','Gabrillo','Male','84 Macabito Calasiao Pangasinan','09465040804','Single','January 26, 1993','rufongabrillojr93@gmail.com','Ma. Elena Gabrillo','09484993958','18a20ce3fa7edb2defd4d2dcba4477eebe5cb19d-1430597140.jpg','');
INSERT INTO `students` VALUES ('77de68daecd823babbb58edb1c8e14d7106e83bb','15-OUS-0005','Sheryl','Rebualos','Sunga','Female','1 Alvear Street East Lingayen, Pamgasinan','09478468714','Married','February 3, 1989','sunga@yahoo.com','Rafael Sunga','09478512347','Default.png','');
INSERT INTO `students` VALUES ('902ba3cda1883801594b6e1b452790cc53948fda','15-OUS-0007','Dela Cruz','Dela Cruz','Dela Cruz','Male','94 Macabito Calasiao Pangasinan','09465040804','Single','January 1, 1950','rufo@yahoo.com','Dela Cruz','09465040804','5af2604e8950c85314141d8702073081111a2ca6-1431215143.jpg','');
INSERT INTO `students` VALUES ('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4','15-OUS-0006','Gabrillo','Gabrillo','Gabrillo','Male','9 Macabto Clasiao Pangasiana','09465040804','Single','January 1, 1950','rufo@yahoo.com','Gabrillo','09465040804','29cfb85db34a2bdeb68800682afd8d7b6ed0a9b0-1431214718.jpg','');
INSERT INTO `students` VALUES ('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c','15-OUS-0001','Clark Kim','Crisostomo','Castro','Male','1 New Street East Lingayen, Pangasinan','09484411624','Single','March 3, 1985','deathmaker_17@yahoo.com','Mr. Raymundo Castro ','09484411624','Default.png','Instructor 1<x>PSU Lingayen<x>2015-2014/1st semester</>Instructor 2<x>PSU Lingayen<x>2015-2014/2nd semester</>Instructor 3<x>PSU Lingayen<x>2015-2014 / summer</>Instructor 4<x>PSU Lingayen<x>2015-2016 / 1st semester</>');
INSERT INTO `students` VALUES ('c1dfd96eea8cc2b62785275bca38ac261256e278','15-OUS-0012','Dela Cruz','Dela Cruz','Dela Cruz','Male','94 Macabito Calasiao Pangasinan','09465040804','Single','January 1, 1950','rufo@yahoo.com','Dela Cruz','09465040804','f191d2efccb5d6103d320b5f73905c40a0fa5d5b-1431214939.jpg','');
INSERT INTO `students` VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0','15-OUS-0003','Juan','Gabrillo','Dela Cruz','Male','84 Macabito Calasiao Pangasinan','09465040804','Single','January 26, 1993','rufongabrillojr93@gmail.com','Rufo Gabrillo Sr.','09484993958','1bfd27a9483318f7b5e886fdabbdc6fcbfc17a1f-1430944074.jpg','');
INSERT INTO `students` VALUES ('fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f','11-OUS-1111','Santos','Santos','Santos','Male','69 Macabito Calasiao Pangasinan','09465048040','Single','January 1, 1950','rufo@yahoo.com','Santos','09465040804','08b9ca8399a917ed71f1d95f86f934d0d02dd461-1431216073.jpg','');

/*---------------------------------------------------------------
  TABLE: `studentscourse`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `studentscourse`;
CREATE TABLE `studentscourse` (
  `StudentCourseID` varchar(50) NOT NULL,
  `StudentProgram` varchar(50) NOT NULL,
  `StudentCourse` varchar(255) NOT NULL,
  `StudentIDNumber` varchar(50) NOT NULL,
  `Scholarship` varchar(255) NOT NULL,
  `ScholarDiscount` varchar(255) NOT NULL,
  `StudentType` varchar(50) NOT NULL,
  `StudentCourseGraduated` varchar(255) NOT NULL,
  `StudentStatus` varchar(50) NOT NULL,
  `DateEnrolled` varchar(50) NOT NULL COMMENT 'Y-M-D',
  `DateUnderGrad` varchar(50) NOT NULL,
  `StudentCategory` varchar(255) NOT NULL,
  PRIMARY KEY (`StudentCourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `studentscourse` VALUES   ('1b6453892473a467d07372d45eb05abc2031647a','Doctoral','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','15-OUS-0006','','','Transferee','BS ECE','','','2005','Regular');
INSERT INTO `studentscourse` VALUES ('356a192b7913b04c54574d18c28d46e6395428ab','Doctoral','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','15-OUS-0002','','0','New','BS ICT','','','2015','Regular');
INSERT INTO `studentscourse` VALUES ('77de68daecd823babbb58edb1c8e14d7106e83bb','Masteral','MASTERS IN DEVELOPMENT MANAGEMENT MAJOR IN PUBLIC MANAGEMENT','15-OUS-0012','','0','New','BS Computer Science','','','2009','Regular');
INSERT INTO `studentscourse` VALUES ('902ba3cda1883801594b6e1b452790cc53948fda','Doctoral','','15-OUS-0004','','','New','BS ICT','','','1970','Regular');
INSERT INTO `studentscourse` VALUES ('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4','Doctoral','','15-OUS-0007','','','New','BS ICT','','','1970','Regular');
INSERT INTO `studentscourse` VALUES ('b6589fc6ab0dc82cf12099d1c2d40ab994e8410c','Doctoral','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','15-OUS-0001','PSU-Faculty','50','New','BS Computer Engineering','','','2007','International');
INSERT INTO `studentscourse` VALUES ('c1dfd96eea8cc2b62785275bca38ac261256e278','Doctoral','DOCTOR OF EDUCATION MAJOR IN EDUCATIONAL MANAGEMENT','15-OUS-0005','','','New','BS ICT','','','1970','Regular');
INSERT INTO `studentscourse` VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0','Doctoral','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','15-OUS-0003','','','New','BS ICT','','','2015','Regular');
INSERT INTO `studentscourse` VALUES ('fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f','Masteral','MASTER OF SCIENCE IN AGRICULTURE MAJOR IN ANIMAL SCIENCE','11-OUS-1111','','','Shift','BS ICT','','','1970','Regular');

/*---------------------------------------------------------------
  TABLE: `users`
  ---------------------------------------------------------------*/
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserNode` varchar(255) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `users` VALUES   ('0ade7c2cf97f75d009975f4d720d1fa6c19f4897','Mr. Antonio F. De Guzman','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('17ba0791499db908433b80f37c5fbc89b870084b','Dr. Sally A. Jarin','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('1b6453892473a467d07372d45eb05abc2031647a','assessment','1de9d55f6707399747d6b8f5846aa58a9663a69c','ASSESSMENT');
INSERT INTO `users` VALUES ('22d200f8670dbdb3e253a90eee5098477c95c23d','administrator','b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3','ADMIN');
INSERT INTO `users` VALUES ('7719a1c782a1ba91c031a682a0a2f8658209adbf','registrar','cd89b1537c0e6664405c383cee9db1f2a6d1a5ac','REGISTRAR');
INSERT INTO `users` VALUES ('7b52009b64fd0a2a49e6d8a939753077792b0554','Dr. Irmina B. Francisco','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('902ba3cda1883801594b6e1b452790cc53948fda','Dr. Alfredo F. Aquino','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4','Dr. Manolito C. Manuel','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('b1d5781111d84f7b3fe45a0852e59758cd7a87e5','Dr. Nelia C. Resultay','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('bd307a3ec329e10a2cff8fb87480823da114f8f4','Dr. Rosie S. Abalos','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('c1dfd96eea8cc2b62785275bca38ac261256e278','Dr. Lydia C. Buduhan','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0','cashier','a5b42198e3fb950b5ab0d0067cbe077a41da1245','CASHIER');
INSERT INTO `users` VALUES ('f1abd670358e036c31296e66b3b66c382ac00812','Dr. Reynaldo T. Gelido','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b','Dr. Ruby Rosa V. Cruz','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
INSERT INTO `users` VALUES ('fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f','Dr. Priscilla L. Jimenez','01b307acba4f54f55aafc33bb06bbbf6ca803e9a','FACULTY');
