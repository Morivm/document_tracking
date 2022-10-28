/*
SQLyog Trial v13.1.9 (64 bit)
MySQL - 10.4.24-MariaDB : Database - doctrack
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`doctrack` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `doctrack`;

/*Table structure for table `search_order_of_busines_files` */

DROP TABLE IF EXISTS `search_order_of_busines_files`;

CREATE TABLE `search_order_of_busines_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_of_business_code` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `version_no` int(11) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT current_timestamp(),
  `uploaded_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `search_order_of_busines_files` */

insert  into `search_order_of_busines_files`(`id`,`order_of_business_code`,`barcode`,`version_no`,`date_uploaded`,`uploaded_by`) values 
(1,'OB202292832-1','OB202292832-1-1-1',1,'2022-10-28 11:17:33','Peralta Chris'),
(2,'OB202292832-1','OB202292832-1-1-1',2,'2022-10-28 12:53:27','Peralta Chris');

/*Table structure for table `search_order_of_business` */

DROP TABLE IF EXISTS `search_order_of_business`;

CREATE TABLE `search_order_of_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_of_business_id` varchar(100) NOT NULL,
  `order_of_business_code` varchar(100) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `barcode` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `added_date` datetime DEFAULT current_timestamp(),
  `added_by` varchar(100) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `order_of_business_id` (`order_of_business_id`),
  KEY `added_by` (`added_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `search_order_of_business` */

insert  into `search_order_of_business`(`id`,`order_of_business_id`,`order_of_business_code`,`ordering`,`barcode`,`description`,`added_date`,`added_by`) values 
(1,'Proposed Ordinances','OB202292832-1',1,'OB202292832-1-1-1','1. test 1','2022-10-28 09:27:33','Peralta Chris'),
(2,'Proposed Ordinances','OB202292832-1',2,'OB202292832-1-1-2','2. test2','2022-10-28 09:27:39','Peralta Chris'),
(3,'Proposed Resolutions','OB202292832-1',1,'OB202292832-1-2-1','1. test 3','2022-10-28 09:27:46','Peralta Chris'),
(4,'Proposed Resolutions','OB202292832-1',2,'OB202292832-1-2-2','2. test 4','2022-10-28 09:27:52','Peralta Chris');

/*Table structure for table `tbl_contract_forms` */

DROP TABLE IF EXISTS `tbl_contract_forms`;

CREATE TABLE `tbl_contract_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) DEFAULT NULL,
  `contract_form` varchar(100) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`),
  CONSTRAINT `tbl_contract_forms_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `tbl_contract_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_contract_forms` */

insert  into `tbl_contract_forms`(`id`,`contract_id`,`contract_form`,`isAvailable`,`action_by`) values 
(1,1,'Doc1',1,1),
(2,1,'Doc2',1,1),
(4,1,'Doc3',1,1),
(5,2,'Mayors Letter ',1,1),
(6,2,'Vice Mayors Letter',1,1),
(7,3,'Mayors Request',1,1),
(8,3,'It Request',1,1),
(9,3,'Procurement',1,1),
(10,3,'Brochure',1,1);

/*Table structure for table `tbl_contract_types` */

DROP TABLE IF EXISTS `tbl_contract_types`;

CREATE TABLE `tbl_contract_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_name` varchar(100) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_contract_types` */

insert  into `tbl_contract_types`(`id`,`contract_name`,`isAvailable`,`action_by`) values 
(1,'City Ordinance',1,1),
(2,'Memorandum',1,1),
(3,'Request for Quotation',1,1);

/*Table structure for table `tbl_department` */

DROP TABLE IF EXISTS `tbl_department`;

CREATE TABLE `tbl_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `department_code` (`department_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_department` */

insert  into `tbl_department`(`id`,`department_code`,`department`,`isAvailable`,`action_by`) values 
(1,'DEP10123442','HR DEPARTMENT2345',1,1);

/*Table structure for table `tbl_department_sub` */

DROP TABLE IF EXISTS `tbl_department_sub`;

CREATE TABLE `tbl_department_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `sub_department_code` varchar(50) DEFAULT NULL,
  `sub_department` varchar(50) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_department_code` (`sub_department_code`),
  KEY `tbl_department_sub_ibfk_1` (`department_id`),
  CONSTRAINT `tbl_department_sub_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_department_sub` */

insert  into `tbl_department_sub`(`id`,`department_id`,`sub_department_code`,`sub_department`,`isAvailable`,`action_by`) values 
(2,1,'code_sub_pay','Ds_Sub_payroll',1,1);

/*Table structure for table `tbl_doc_per_person` */

DROP TABLE IF EXISTS `tbl_doc_per_person`;

CREATE TABLE `tbl_doc_per_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_person` int(11) DEFAULT NULL,
  `available_doctype` int(11) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_doc_per_person` */

insert  into `tbl_doc_per_person`(`id`,`type_of_person`,`available_doctype`,`isAvailable`,`action_by`) values 
(1,1,1,1,1),
(2,1,2,1,1);

/*Table structure for table `tbl_document_type` */

DROP TABLE IF EXISTS `tbl_document_type`;

CREATE TABLE `tbl_document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(50) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_name` (`document_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_document_type` */

insert  into `tbl_document_type`(`id`,`document_name`,`isAvailable`,`action_by`) values 
(1,'Bio-Data',1,1),
(2,'Employment Contract',1,1),
(3,'NBI2',1,1);

/*Table structure for table `tbl_documents` */

DROP TABLE IF EXISTS `tbl_documents`;

CREATE TABLE `tbl_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(100) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `document_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_name` (`document_name`),
  KEY `users_id` (`users_id`),
  KEY `document_type` (`document_type`),
  CONSTRAINT `tbl_documents_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_documents_ibfk_2` FOREIGN KEY (`document_type`) REFERENCES `tbl_document_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_documents` */

/*Table structure for table `tbl_generated_cover` */

DROP TABLE IF EXISTS `tbl_generated_cover`;

CREATE TABLE `tbl_generated_cover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_of_business_date` date DEFAULT NULL,
  `order_of_business_code` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `generated_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_generated_cover` */

insert  into `tbl_generated_cover`(`id`,`order_of_business_date`,`order_of_business_code`,`created_by`,`generated_date`) values 
(1,'2022-10-28','OB202292832-1','Peralta Chris','2022-10-28 09:27:53');

/*Table structure for table `tbl_logs` */

DROP TABLE IF EXISTS `tbl_logs`;

CREATE TABLE `tbl_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance_id` varchar(200) DEFAULT NULL,
  `log_action` varchar(30) DEFAULT NULL,
  `log_type` varchar(50) DEFAULT NULL,
  `log_detailed` text DEFAULT NULL,
  `action_by` varchar(200) DEFAULT NULL,
  `action_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_logs` */

insert  into `tbl_logs`(`id`,`maintenance_id`,`log_action`,`log_type`,`log_detailed`,`action_by`,`action_date`) values 
(1,'1','ADD','ADDED DEPARTMENT','Peralta Chris Added new Department:  HR DEPARTMENT , Department Code:  DEP101','Peralta Chris','2022-08-26 15:36:00'),
(2,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris  Update Department code from DEP101 to DEP1012','Peralta Chris','2022-08-26 15:36:18'),
(3,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris Update Department from HR DEPARTMENT to HR DEPARTMENT2 ','Peralta Chris','2022-08-26 15:36:32'),
(4,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris Update Department from HR DEPARTMENT2 to HR DEPARTMENT23 Update Department code from DEP1012 to DEP10123','Peralta Chris','2022-08-26 15:36:39'),
(5,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris Update Department from HR DEPARTMENT23 to HR DEPARTMENT234 ','Peralta Chris','2022-08-26 15:37:27'),
(6,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris  Update Department code from DEP10123 to DEP1012344','Peralta Chris','2022-08-26 15:45:52'),
(7,'1','UPDATE','UPDATE DEPARTMENT','Peralta Chris Update Department from HR DEPARTMENT234 to HR DEPARTMENT2345 Update Department code from DEP1012344 to DEP10123442','Peralta Chris','2022-08-26 15:48:10');

/*Table structure for table `tbl_setup_committees` */

DROP TABLE IF EXISTS `tbl_setup_committees`;

CREATE TABLE `tbl_setup_committees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_name` varchar(80) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `committee_name` (`committee_name`),
  KEY `action_by` (`action_by`),
  CONSTRAINT `tbl_setup_committees_ibfk_1` FOREIGN KEY (`action_by`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_setup_committees` */

insert  into `tbl_setup_committees`(`id`,`committee_name`,`isAvailable`,`action_by`) values 
(1,'Accreditation',1,1),
(2,'Agriculture Veterinary',1,1),
(3,'Barangay Affairs',1,1);

/*Table structure for table `tbl_setup_order_of_business` */

DROP TABLE IF EXISTS `tbl_setup_order_of_business`;

CREATE TABLE `tbl_setup_order_of_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_of_business` varchar(100) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_of_business` (`order_of_business`),
  KEY `action_by` (`action_by`),
  CONSTRAINT `tbl_setup_order_of_business_ibfk_1` FOREIGN KEY (`action_by`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_setup_order_of_business` */

insert  into `tbl_setup_order_of_business`(`id`,`order_of_business`,`isAvailable`,`action_by`) values 
(1,'Proposed Ordinances',1,1),
(2,'Proposed Resolutions',1,1),
(3,'Petitions and Request',1,1),
(4,'Other Communications Subject for Legislation',1,1);

/*Table structure for table `tbl_setup_positions` */

DROP TABLE IF EXISTS `tbl_setup_positions`;

CREATE TABLE `tbl_setup_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(50) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `position_name` (`position_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_setup_positions` */

insert  into `tbl_setup_positions`(`id`,`position_name`,`isAvailable`,`action_by`) values 
(1,'Member',1,1),
(2,'Chairman',1,1),
(3,'Vice Chairman',1,1);

/*Table structure for table `tbl_type_of_person` */

DROP TABLE IF EXISTS `tbl_type_of_person`;

CREATE TABLE `tbl_type_of_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_person` varchar(50) DEFAULT NULL,
  `isAvailable` int(11) DEFAULT 1,
  `action_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_of_person` (`type_of_person`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_type_of_person` */

insert  into `tbl_type_of_person`(`id`,`type_of_person`,`isAvailable`,`action_by`) values 
(1,'Applicant',1,1);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `usertype` int(11) DEFAULT 2,
  `username` varchar(25) DEFAULT NULL,
  `password` char(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `usertype` (`usertype`),
  KEY `userid` (`userid`),
  CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`usertype`) REFERENCES `tbl_usertype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_users_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`userid`,`usertype`,`username`,`password`) values 
(1,1,1,'chris','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u'),
(2,2,2,'carl','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u'),
(3,3,2,'cruz','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u'),
(4,4,2,'ferr','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u'),
(5,5,2,'tajo',NULL),
(6,6,2,'mal','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u'),
(7,7,2,'jose',NULL),
(9,9,2,'jacob',NULL);

/*Table structure for table `tbl_users_detail` */

DROP TABLE IF EXISTS `tbl_users_detail`;

CREATE TABLE `tbl_users_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `account_status` int(11) DEFAULT 1,
  `committee_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committee_id` (`committee_id`),
  KEY `position_id` (`position_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `tbl_users_detail_ibfk_1` FOREIGN KEY (`committee_id`) REFERENCES `tbl_setup_committees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_users_detail_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `tbl_setup_positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_users_detail_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users_detail` */

insert  into `tbl_users_detail`(`id`,`lastname`,`firstname`,`middlename`,`account_status`,`committee_id`,`position_id`,`department_id`) values 
(1,'Peralta','Chris',NULL,1,NULL,NULL,1),
(2,'Oring','Carl Angelo','Duran',1,NULL,NULL,1),
(3,'Cruz','Edwin',NULL,1,1,3,1),
(4,'Ferriols','Sitti Ruaina','K',1,1,2,1),
(5,'Tajuna','Ezekiel','L',1,2,1,1),
(6,'Malicdem','Snooky','D',1,2,2,1),
(7,'Ferrer','Jose','A',1,3,1,1),
(9,'Jacob','Manuel','S',1,3,2,1);

/*Table structure for table `tbl_usertype` */

DROP TABLE IF EXISTS `tbl_usertype`;

CREATE TABLE `tbl_usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usertype` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_usertype` */

insert  into `tbl_usertype`(`id`,`usertype`) values 
(1,'SUPERADMIN'),
(2,'ADMIN');

/*Table structure for table `tblupload` */

DROP TABLE IF EXISTS `tblupload`;

CREATE TABLE `tblupload` (
  `uploadId` int(11) NOT NULL AUTO_INCREMENT,
  `uploadFile` longblob DEFAULT NULL,
  `uploadFileName` varchar(255) DEFAULT NULL,
  `uploadDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`uploadId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tblupload` */

/*Table structure for table `tmp_committees` */

DROP TABLE IF EXISTS `tmp_committees`;

CREATE TABLE `tmp_committees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `action_by` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`),
  KEY `committee_id` (`committee_id`),
  CONSTRAINT `tmp_committees_ibfk_1` FOREIGN KEY (`committee_id`) REFERENCES `tbl_setup_committees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tmp_committees_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tmp_committees` */

/*Table structure for table `tmp_order_of_business` */

DROP TABLE IF EXISTS `tmp_order_of_business`;

CREATE TABLE `tmp_order_of_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_of_business_id` int(11) NOT NULL,
  `order_of_business_code` varchar(100) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `barcode` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `added_date` datetime DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `order_of_business_id` (`order_of_business_id`),
  KEY `added_by` (`added_by`),
  CONSTRAINT `tmp_order_of_business_ibfk_1` FOREIGN KEY (`order_of_business_id`) REFERENCES `tbl_setup_order_of_business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tmp_order_of_business_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `tbl_users_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tmp_order_of_business` */

/* Trigger structure for table `tbl_department` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_setup_department_add` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_setup_department_add` AFTER INSERT ON `tbl_department` FOR EACH ROW BEGIN
		INSERT INTO tbl_logs(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
			VALUES (new.id, 'ADD', 'ADDED DEPARTMENT', 
		CONCAT_WS(' ',`func_fullname`(new.action_by), 'Added new Department: ', new.department, ',', 'Department Code: ', new.department_code),
		func_fullname(new.action_by), CURRENT_TIMESTAMP());
    END */$$


DELIMITER ;

/* Trigger structure for table `tbl_department` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_setup_department_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_setup_department_update` AFTER UPDATE ON `tbl_department` FOR EACH ROW 
	BEGIN
		declare concat_department text;
		declare concat_code text;
		
		IF old.department != new.department THEN 
			SET concat_department = (SELECT CONCAT('Update Department from ', old.department, ' to ', new.department)) ;
		ELSE 
			SET concat_department = '';
		END IF;
	
		
		if old.department_code != new.department_code then 
			set concat_code = (select CONCAT('Update Department code from ', old.department_code, ' to ', new.department_code)) ;
		else 
			SET concat_code = '';
		end if;
	
	
	
		IF old.department_code != new.department_code or old.department != new.department THEN
		
	
			INSERT INTO tbl_logs(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
			VALUES (new.id, 'UPDATE', 'UPDATE DEPARTMENT', 
				CONCAT_WS(' ',`func_fullname`(new.action_by), concat_department, concat_code ),
				func_fullname(new.action_by), CURRENT_TIMESTAMP());
				
		ELSEif old.isAvailable != new.isAvailable then  
	
				
			INSERT INTO tbl_logs(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
			VALUES (new.id, 'DELETE', 'DELETE DEPARTMENT', 
				CONCAT_WS(' ',func_fullname(new.action_by), 'Delete Department', new.department_code),
				func_fullname(new.action_by), CURRENT_TIMESTAMP());
			
			
		END IF;
    END */$$


DELIMITER ;

/* Function  structure for function  `func_Dateformat` */

/*!50003 DROP FUNCTION IF EXISTS `func_Dateformat` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `func_Dateformat`(indatetime DATETIME, intype INT) RETURNS varchar(50) CHARSET utf8mb4
BEGIN
	DECLARE dateformatted VARCHAR(50);
	
	IF indatetime = '' THEN
		SET dateformatted = 'Invalid Date';
	ELSE
		IF intype = '' THEN
			SET dateformatted = 'Invalid Type';
		ELSE
			IF intype = 1 THEN
				SET dateformatted = DATE_FORMAT(indatetime, '%r');
			ELSEIF intype = 2 THEN
				SET dateformatted = DATE_FORMAT(indatetime, '%b %d %Y');
			ELSEIF intype = 3 THEN
				SET dateformatted = DATE_FORMAT(indatetime, '%b %d %Y %r');
			ELSE
				SET dateformatted = 'Cant Retrieve Date Format';
			END IF;
		END IF;
	END IF;
	
	RETURN dateformatted;
    
    END */$$
DELIMITER ;

/* Function  structure for function  `func_document_type` */

/*!50003 DROP FUNCTION IF EXISTS `func_document_type` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `func_document_type`(in_doctype int
			) RETURNS varchar(50) CHARSET utf8mb4
BEGIN
    
	DECLARE doctypeid VARCHAR(50);
	
	SET doctypeid = (SELECT document_name FROM `tbl_document_type` WHERE id = in_doctype );
	
	RETURN doctypeid ;
    
    
    END */$$
DELIMITER ;

/* Function  structure for function  `func_fullname` */

/*!50003 DROP FUNCTION IF EXISTS `func_fullname` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `func_fullname`(in_userid int
		) RETURNS varchar(100) CHARSET utf8mb4
BEGIN
	declare fullname varchar(100);
	
	set fullname = (SELECT CONCAT_WS(' ',lastname, firstname, middlename) FROM `tbl_users_detail` WHERE id =in_userid  );
	
	return fullname;
    END */$$
DELIMITER ;

/* Function  structure for function  `func_type_of_person` */

/*!50003 DROP FUNCTION IF EXISTS `func_type_of_person` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `func_type_of_person`(in_id int
    ) RETURNS varchar(50) CHARSET utf8mb4
BEGIN
	declare typeperson varchar(50);
	
	set typeperson = (SELECT type_of_person FROM  `tbl_type_of_person` WHERE id = in_id );
	
	return typeperson ;
    
    
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_generate_barcode` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_generate_barcode` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generate_barcode`(
					in in_action varchar(10),
					in in_userid int,
					in in_typeofperson int,
					in in_action_by int
				)
BEGIN
	
		if in_action = 'generate' then
		
		
			INSERT INTO tbl_printed_barcodes (userid, type_of_person, document_type, printed_by)
			SELECT in_userid, type_of_person, available_doctype, in_action_by
			FROM tbl_doc_per_person
			WHERE 
			tbl_doc_per_person.`isAvailable` = 1
			AND
			tbl_doc_per_person.`type_of_person` = in_typeofperson
			;
		
		
	
			SELECT 'success' AS message_success , 'Success' AS message_title, in_action_by AS message_body;
															
		
		
		elseif in_action = 'upbarcode' THEN
		
			UPDATE tbl_printed_barcodes SET isPrinted = 1 where printed_by = in_action_by; 
			
			SELECT 'success' AS message_success , 'Success' AS message_title, 'Succesfully Printed' AS message_body;
			
		else 
		
			SELECT 'error' AS message_success , 'Error Found' AS message_title, 'Please Reload page first.' AS message_body;
			
		
		end if;
		
	
	
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_generate_cover_photo` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_generate_cover_photo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generate_cover_photo`(
				in in_action varchar(20),
				in in_barcode varchar(100),
				in in_order_business_date date,
				in in_action_by int
			)
BEGIN
	
		if in_action = 'generate' then
		
		
			insert into tbl_generated_cover(order_of_business_date, order_of_business_code, created_by) values
			(in_order_business_date, in_barcode, func_fullname(in_action_by) );
		
		
		
			INSERT INTO search_order_of_business (order_of_business_id, order_of_business_code, ordering, barcode, DESCRIPTION, added_date, added_by)
			SELECT (SELECT c.order_of_business FROM tbl_setup_order_of_business c WHERE c.id = b.order_of_business_id  ), b.order_of_business_code, b.ordering, b.barcode,
			b.description, b.added_date, func_fullname(b.added_by)
			FROM tmp_order_of_business b
			WHERE added_by = in_action_by and order_of_business_code = in_barcode;
	
	
		-- 	INSERT INTO search_committees(barcode, committee_id, userid, action_by, action_date)
			
			SELECT 'success' AS message_success , 'Success' AS message_title, in_barcode AS message_body, (	SELECT GROUP_CONCAT(barcode) FROM search_order_of_business WHERE order_of_business_code =in_barcode) as barcodeloop;
			
		elseif in_action = 'deletefirst_tmps' then
			DELETE FROM `tmp_committees` WHERE action_by = in_action_by;	
 			DELETE FROM `tmp_order_of_business` WHERE added_by = in_action_by;
		
			
			SELECT 'success' AS message_success , 'Success' AS message_title, 'succesfully deleted' AS message_body;
		
		
		else 
		
			seLECT 'error' AS message_success , 'Error Found' AS message_title, 'Please Reload Page First' AS message_body;
		end if;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_reset` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_reset` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reset`()
BEGIN
		truncate table `search_committees`;
		TRUNCATE TABLE `search_order_of_business`;
		TRUNCATE TABLE `tmp_committees`;
		TRUNCATE TABLE `tmp_order_of_business`;
		TRUNCATE TABLE `tbl_activities`;
		
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_setup_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_setup_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_setup_department`(
				in in_id int,
				in in_action varchar(10),
				in in_param1 varchar(50),
				IN in_param2 VARCHAR(50),
				in in_action_by int
			)
BEGIN
		if in_action = 'ADD' then
		
			INSERT INTO `tbl_department`(department_code, department, action_by)
			VALUES(in_param1,in_param2, in_action_by);
			
			SELECT 'success' AS response_type , 'Success' AS response_title , CONCAT('Successfully Added ', in_param1,' As Department Code ' , in_param2, ' As Department Name') as response_message;
		
		elseif in_action = 'UPDATE' then
			
			select department_code, department 
			into @param1 , @param2
			
			from tbl_department where id = in_id;
			
			
			if @param1 = in_param1 and @param2 = in_param2 then 
			
				SELECT 'error' AS response_type , 'Error Found' AS response_title , 'No Changes Has Been Made' AS response_message;
		
			else 
			
				update tbl_department set department_code = in_param1 , department = in_param2, action_by = in_action_by where id = in_id;
				
				SELECT 'success' AS response_type , 'Success' AS response_title , 'Details Succesfully Change.' AS response_message;
		
			
			end if;
			
		
		end if;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_setup_document_type` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_setup_document_type` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_setup_document_type`(
				IN in_id INT,
				IN in_action VARCHAR(10),
				IN in_param1 VARCHAR(50),
				IN in_action_by INT
				)
BEGIN
		IF in_action = 'ADD' THEN
		
			INSERT INTO `tbl_document_type`(document_name, action_by)
			VALUES(in_param1, in_action_by);
			
			SELECT 'success' AS response_type , 'Success' AS response_title , CONCAT('Successfully Added ', in_param1,' As Document type') AS response_message;
		
		ELSEIF in_action = 'UPDATE' THEN
			
			SELECT document_name
			INTO @param1
			
			FROM tbl_document_type WHERE id = in_id;
			
			
			IF @param1 = in_param1  THEN 
			
				SELECT 'error' AS response_type , 'Error Found' AS response_title , 'No Changes Has Been Made' AS response_message;
	
			ELSE 
			
				UPDATE tbl_document_type SET document_name = in_param1,   action_by = in_action_by WHERE id = in_id;
				
				SELECT 'success' AS response_type , 'Success' AS response_title , 'Details Succesfully Change.' AS response_message;
		
			
			END IF;
			
		
		END IF;
	END */$$
DELIMITER ;

/*Table structure for table `vw_contract_forms` */

DROP TABLE IF EXISTS `vw_contract_forms`;

/*!50001 DROP VIEW IF EXISTS `vw_contract_forms` */;
/*!50001 DROP TABLE IF EXISTS `vw_contract_forms` */;

/*!50001 CREATE TABLE  `vw_contract_forms`(
 `row1` int(11) ,
 `row2` int(11) ,
 `row3` varchar(100) ,
 `row4` int(11) ,
 `row5` varchar(100) 
)*/;

/*Table structure for table `vw_contract_types` */

DROP TABLE IF EXISTS `vw_contract_types`;

/*!50001 DROP VIEW IF EXISTS `vw_contract_types` */;
/*!50001 DROP TABLE IF EXISTS `vw_contract_types` */;

/*!50001 CREATE TABLE  `vw_contract_types`(
 `row1` int(11) ,
 `row2` varchar(100) ,
 `row3` int(11) ,
 `row4` int(11) ,
 `row5` varchar(100) 
)*/;

/*Table structure for table `vw_order_of_business` */

DROP TABLE IF EXISTS `vw_order_of_business`;

/*!50001 DROP VIEW IF EXISTS `vw_order_of_business` */;
/*!50001 DROP TABLE IF EXISTS `vw_order_of_business` */;

/*!50001 CREATE TABLE  `vw_order_of_business`(
 `row1` int(11) ,
 `row2` varchar(100) ,
 `row3` int(11) ,
 `row4` varchar(100) 
)*/;

/*Table structure for table `vw_search_order_of_business` */

DROP TABLE IF EXISTS `vw_search_order_of_business`;

/*!50001 DROP VIEW IF EXISTS `vw_search_order_of_business` */;
/*!50001 DROP TABLE IF EXISTS `vw_search_order_of_business` */;

/*!50001 CREATE TABLE  `vw_search_order_of_business`(
 `row1` int(11) ,
 `row2` date ,
 `row3` varchar(100) ,
 `row4` varchar(100) ,
 `row5` mediumtext ,
 `row6` mediumtext ,
 `row7` mediumtext ,
 `row8` mediumtext ,
 `row9` mediumtext 
)*/;

/*Table structure for table `vw_setup_committee` */

DROP TABLE IF EXISTS `vw_setup_committee`;

/*!50001 DROP VIEW IF EXISTS `vw_setup_committee` */;
/*!50001 DROP TABLE IF EXISTS `vw_setup_committee` */;

/*!50001 CREATE TABLE  `vw_setup_committee`(
 `row1` int(11) ,
 `row2` varchar(80) ,
 `row3` int(11) ,
 `row4` varchar(100) 
)*/;

/*Table structure for table `vw_setup_department` */

DROP TABLE IF EXISTS `vw_setup_department`;

/*!50001 DROP VIEW IF EXISTS `vw_setup_department` */;
/*!50001 DROP TABLE IF EXISTS `vw_setup_department` */;

/*!50001 CREATE TABLE  `vw_setup_department`(
 `row1` int(11) ,
 `row2` varchar(50) ,
 `row3` varchar(50) ,
 `row4` int(11) 
)*/;

/*Table structure for table `vw_setup_document_type` */

DROP TABLE IF EXISTS `vw_setup_document_type`;

/*!50001 DROP VIEW IF EXISTS `vw_setup_document_type` */;
/*!50001 DROP TABLE IF EXISTS `vw_setup_document_type` */;

/*!50001 CREATE TABLE  `vw_setup_document_type`(
 `row1` int(11) ,
 `row2` varchar(50) ,
 `row3` int(11) ,
 `row4` varchar(100) 
)*/;

/*Table structure for table `vw_setup_sub_department` */

DROP TABLE IF EXISTS `vw_setup_sub_department`;

/*!50001 DROP VIEW IF EXISTS `vw_setup_sub_department` */;
/*!50001 DROP TABLE IF EXISTS `vw_setup_sub_department` */;

/*!50001 CREATE TABLE  `vw_setup_sub_department`(
 `row1` int(11) ,
 `row2` varchar(103) ,
 `row3` varchar(50) ,
 `row4` varchar(50) ,
 `row5` int(11) 
)*/;

/*Table structure for table `vw_tmp_commitees` */

DROP TABLE IF EXISTS `vw_tmp_commitees`;

/*!50001 DROP VIEW IF EXISTS `vw_tmp_commitees` */;
/*!50001 DROP TABLE IF EXISTS `vw_tmp_commitees` */;

/*!50001 CREATE TABLE  `vw_tmp_commitees`(
 `row1` int(11) ,
 `row2` int(11) ,
 `row3` varchar(80) ,
 `row4` int(11) ,
 `row5` varchar(100) ,
 `row6` varchar(50) ,
 `row7` int(11) 
)*/;

/*Table structure for table `vw_tmp_order_business` */

DROP TABLE IF EXISTS `vw_tmp_order_business`;

/*!50001 DROP VIEW IF EXISTS `vw_tmp_order_business` */;
/*!50001 DROP TABLE IF EXISTS `vw_tmp_order_business` */;

/*!50001 CREATE TABLE  `vw_tmp_order_business`(
 `row1` int(11) ,
 `row2` varchar(100) ,
 `row3` varchar(100) ,
 `row4` int(11) ,
 `row5` varchar(100) ,
 `row6` text ,
 `row7` datetime ,
 `row8` varchar(100) ,
 `row9` int(11) 
)*/;

/*Table structure for table `vw_type_of_person` */

DROP TABLE IF EXISTS `vw_type_of_person`;

/*!50001 DROP VIEW IF EXISTS `vw_type_of_person` */;
/*!50001 DROP TABLE IF EXISTS `vw_type_of_person` */;

/*!50001 CREATE TABLE  `vw_type_of_person`(
 `row1` int(11) ,
 `row2` varchar(50) ,
 `row3` int(11) ,
 `row4` varchar(100) 
)*/;

/*Table structure for table `vw_users_docs` */

DROP TABLE IF EXISTS `vw_users_docs`;

/*!50001 DROP VIEW IF EXISTS `vw_users_docs` */;
/*!50001 DROP TABLE IF EXISTS `vw_users_docs` */;

/*!50001 CREATE TABLE  `vw_users_docs`(
 `row1` int(11) ,
 `row2` varchar(100) ,
 `row3` int(11) ,
 `row4` varchar(100) ,
 `row5` int(11) ,
 `row6` varchar(50) 
)*/;

/*Table structure for table `vw_users_w_docs` */

DROP TABLE IF EXISTS `vw_users_w_docs`;

/*!50001 DROP VIEW IF EXISTS `vw_users_w_docs` */;
/*!50001 DROP TABLE IF EXISTS `vw_users_w_docs` */;

/*!50001 CREATE TABLE  `vw_users_w_docs`(
 `row1` varchar(100) ,
 `row2` int(11) 
)*/;

/*Table structure for table `vw_user_details` */

DROP TABLE IF EXISTS `vw_user_details`;

/*!50001 DROP VIEW IF EXISTS `vw_user_details` */;
/*!50001 DROP TABLE IF EXISTS `vw_user_details` */;

/*!50001 CREATE TABLE  `vw_user_details`(
 `row1` int(11) ,
 `row2` int(11) ,
 `row3` varchar(25) ,
 `row4` char(128) ,
 `row5` varchar(100) ,
 `row6` int(11) ,
 `row7` varchar(20) ,
 `row8` varchar(50) 
)*/;

/*View structure for view vw_contract_forms */

/*!50001 DROP TABLE IF EXISTS `vw_contract_forms` */;
/*!50001 DROP VIEW IF EXISTS `vw_contract_forms` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_contract_forms` AS select `tbl_contract_forms`.`id` AS `row1`,`tbl_contract_forms`.`contract_id` AS `row2`,`tbl_contract_forms`.`contract_form` AS `row3`,`tbl_contract_forms`.`isAvailable` AS `row4`,`func_fullname`(`tbl_contract_forms`.`action_by`) AS `row5` from `tbl_contract_forms` */;

/*View structure for view vw_contract_types */

/*!50001 DROP TABLE IF EXISTS `vw_contract_types` */;
/*!50001 DROP VIEW IF EXISTS `vw_contract_types` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_contract_types` AS select `tbl_contract_types`.`id` AS `row1`,`tbl_contract_types`.`contract_name` AS `row2`,`tbl_contract_types`.`isAvailable` AS `row3`,`tbl_contract_types`.`action_by` AS `row4`,`func_fullname`(`tbl_contract_types`.`action_by`) AS `row5` from `tbl_contract_types` */;

/*View structure for view vw_order_of_business */

/*!50001 DROP TABLE IF EXISTS `vw_order_of_business` */;
/*!50001 DROP VIEW IF EXISTS `vw_order_of_business` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_order_of_business` AS select `tbl_setup_order_of_business`.`id` AS `row1`,`tbl_setup_order_of_business`.`order_of_business` AS `row2`,`tbl_setup_order_of_business`.`isAvailable` AS `row3`,`func_fullname`(`tbl_setup_order_of_business`.`action_by`) AS `row4` from `tbl_setup_order_of_business` */;

/*View structure for view vw_search_order_of_business */

/*!50001 DROP TABLE IF EXISTS `vw_search_order_of_business` */;
/*!50001 DROP VIEW IF EXISTS `vw_search_order_of_business` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_search_order_of_business` AS select `a`.`id` AS `row1`,`a`.`order_of_business_date` AS `row2`,`a`.`order_of_business_code` AS `row3`,`a`.`created_by` AS `row4`,(select group_concat(distinct `b`.`order_of_business_id` separator ',') from `search_order_of_business` `b` where `b`.`order_of_business_code` = `a`.`order_of_business_code`) AS `row5`,(select group_concat(`c`.`description` separator ',') from `search_order_of_business` `c` where `c`.`order_of_business_code` = `a`.`order_of_business_code`) AS `row6`,(select group_concat(`d`.`barcode` separator ',') from `search_order_of_business` `d` where `d`.`order_of_business_code` = `a`.`order_of_business_code`) AS `row7`,(select group_concat(distinct `e`.`added_by` separator ',') from `search_order_of_business` `e` where `e`.`order_of_business_code` = `a`.`order_of_business_code`) AS `row8`,(select group_concat(distinct `f`.`added_date` separator ',') from `search_order_of_business` `f` where `f`.`order_of_business_code` = `a`.`order_of_business_code`) AS `row9` from `tbl_generated_cover` `a` */;

/*View structure for view vw_setup_committee */

/*!50001 DROP TABLE IF EXISTS `vw_setup_committee` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_committee` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_committee` AS select `tbl_setup_committees`.`id` AS `row1`,`tbl_setup_committees`.`committee_name` AS `row2`,`tbl_setup_committees`.`isAvailable` AS `row3`,`func_fullname`(`tbl_setup_committees`.`action_by`) AS `row4` from `tbl_setup_committees` */;

/*View structure for view vw_setup_department */

/*!50001 DROP TABLE IF EXISTS `vw_setup_department` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_department` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_department` AS select `tbl_department`.`id` AS `row1`,`tbl_department`.`department_code` AS `row2`,`tbl_department`.`department` AS `row3`,`tbl_department`.`isAvailable` AS `row4` from `tbl_department` */;

/*View structure for view vw_setup_document_type */

/*!50001 DROP TABLE IF EXISTS `vw_setup_document_type` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_document_type` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_document_type` AS select `tbl_document_type`.`id` AS `row1`,`tbl_document_type`.`document_name` AS `row2`,`tbl_document_type`.`isAvailable` AS `row3`,`func_fullname`(`tbl_document_type`.`action_by`) AS `row4` from `tbl_document_type` */;

/*View structure for view vw_setup_sub_department */

/*!50001 DROP TABLE IF EXISTS `vw_setup_sub_department` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_sub_department` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_sub_department` AS select `a`.`id` AS `row1`,concat(`b`.`department_code`,' - ',`b`.`department`) AS `row2`,`a`.`sub_department_code` AS `row3`,`a`.`sub_department` AS `row4`,`a`.`isAvailable` AS `row5` from (`tbl_department_sub` `a` left join `tbl_department` `b` on(`b`.`id` = `a`.`department_id`)) */;

/*View structure for view vw_tmp_commitees */

/*!50001 DROP TABLE IF EXISTS `vw_tmp_commitees` */;
/*!50001 DROP VIEW IF EXISTS `vw_tmp_commitees` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tmp_commitees` AS select `a`.`id` AS `row1`,`a`.`committee_id` AS `row2`,`b`.`committee_name` AS `row3`,`a`.`userid` AS `row4`,`func_fullname`(`a`.`userid`) AS `row5`,(select `d`.`position_name` from (`tbl_users_detail` `c` left join `tbl_setup_positions` `d` on(`d`.`id` = `c`.`position_id`)) where `c`.`id` = `a`.`userid`) AS `row6`,`a`.`action_by` AS `row7` from (`tmp_committees` `a` left join `tbl_setup_committees` `b` on(`b`.`id` = `a`.`committee_id`)) */;

/*View structure for view vw_tmp_order_business */

/*!50001 DROP TABLE IF EXISTS `vw_tmp_order_business` */;
/*!50001 DROP VIEW IF EXISTS `vw_tmp_order_business` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tmp_order_business` AS select `a`.`id` AS `row1`,`b`.`order_of_business` AS `row2`,`a`.`order_of_business_code` AS `row3`,`a`.`ordering` AS `row4`,`a`.`barcode` AS `row5`,`a`.`description` AS `row6`,`a`.`added_date` AS `row7`,`func_fullname`(`a`.`added_by`) AS `row8`,`a`.`added_by` AS `row9` from (`tmp_order_of_business` `a` left join `tbl_setup_order_of_business` `b` on(`b`.`id` = `a`.`order_of_business_id`)) */;

/*View structure for view vw_type_of_person */

/*!50001 DROP TABLE IF EXISTS `vw_type_of_person` */;
/*!50001 DROP VIEW IF EXISTS `vw_type_of_person` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_type_of_person` AS select `tbl_type_of_person`.`id` AS `row1`,`tbl_type_of_person`.`type_of_person` AS `row2`,`tbl_type_of_person`.`isAvailable` AS `row3`,`func_fullname`(`tbl_type_of_person`.`action_by`) AS `row4` from `tbl_type_of_person` */;

/*View structure for view vw_users_docs */

/*!50001 DROP TABLE IF EXISTS `vw_users_docs` */;
/*!50001 DROP VIEW IF EXISTS `vw_users_docs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_users_docs` AS select `tbl_documents`.`id` AS `row1`,`tbl_documents`.`document_name` AS `row2`,`tbl_documents`.`users_id` AS `row3`,`func_fullname`(`tbl_documents`.`users_id`) AS `row4`,`tbl_documents`.`document_type` AS `row5`,`func_document_type`(`tbl_documents`.`document_type`) AS `row6` from `tbl_documents` */;

/*View structure for view vw_users_w_docs */

/*!50001 DROP TABLE IF EXISTS `vw_users_w_docs` */;
/*!50001 DROP VIEW IF EXISTS `vw_users_w_docs` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_users_w_docs` AS select distinct `func_fullname`(`tbl_documents`.`users_id`) AS `row1`,`tbl_documents`.`users_id` AS `row2` from `tbl_documents` */;

/*View structure for view vw_user_details */

/*!50001 DROP TABLE IF EXISTS `vw_user_details` */;
/*!50001 DROP VIEW IF EXISTS `vw_user_details` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user_details` AS select `a`.`userid` AS `row1`,`a`.`usertype` AS `row2`,`a`.`username` AS `row3`,`a`.`password` AS `row4`,`func_fullname`(`b`.`id`) AS `row5`,`b`.`account_status` AS `row6`,`c`.`usertype` AS `row7`,`e`.`department` AS `row8` from (((`tbl_users` `a` left join `tbl_users_detail` `b` on(`a`.`userid` = `b`.`id`)) left join `tbl_usertype` `c` on(`c`.`id` = `a`.`usertype`)) left join `tbl_department` `e` on(`e`.`id` = `b`.`department_id`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
