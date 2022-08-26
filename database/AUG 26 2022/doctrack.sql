/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 10.4.17-MariaDB : Database - doctrack
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`userid`,`usertype`,`username`,`password`) values 
(1,1,1,'chris','$2y$10$al44s0UkeH2zSlpIbOil2ON03awp9g3f2gjsLXFbrhIHUJfD1Kc5u');

/*Table structure for table `tbl_users_detail` */

DROP TABLE IF EXISTS `tbl_users_detail`;

CREATE TABLE `tbl_users_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `account_status` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_users_detail` */

insert  into `tbl_users_detail`(`id`,`lastname`,`firstname`,`middlename`,`account_status`) values 
(1,'Peralta','Chris',NULL,1);

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

/* Trigger structure for table `tbl_department` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_setup_department_add` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_setup_department_add` AFTER INSERT ON `tbl_department` FOR EACH ROW BEGIN

		INSERT INTO tbl_logs(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
			VALUES (new.id, 'ADD', 'ADDED DEPARTMENT', 
		CONCAT_WS(' ',`func_fullname`(new.action_by), 'Added new Department: ', new.department, ',', 'Department Code: ', new.department_code),
		func_fullname(new.action_by), CURRENT_TIMESTAMP());



-- 	IF old.department_name = new.department_name AND new.remove_by != '' THEN
-- 		
-- 			INSERT INTO logs_new_setup(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
-- 			VALUES (new.department_id, 'DELETE', 'DELETE DEPARTMENT', 
-- 				CONCAT_WS(' ',get_fullname_woutbadge(new.remove_by), 'Delete Department', old.department_name),
-- 				get_fullname(new.remove_by), CURRENT_TIMESTAMP());
-- 				
-- 		ELSE
-- 	
-- 			INSERT INTO logs_new_setup(maintenance_id, log_action, log_type, log_detailed, action_by, action_date )
-- 			VALUES (new.department_id, 'UPDATE', 'UPDATE DEPARTMENT', 
-- 				CONCAT_WS(' ',get_fullname_woutbadge(new.update_by), 'Update Agency', old.department_name, 'to', new.department_name ),
-- 				get_fullname(new.update_by), CURRENT_TIMESTAMP());
-- 			
-- 			
-- 		END IF;

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
 `row7` varchar(20) 
)*/;

/*View structure for view vw_setup_department */

/*!50001 DROP TABLE IF EXISTS `vw_setup_department` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_department` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_department` AS select `tbl_department`.`id` AS `row1`,`tbl_department`.`department_code` AS `row2`,`tbl_department`.`department` AS `row3`,`tbl_department`.`isAvailable` AS `row4` from `tbl_department` */;

/*View structure for view vw_setup_sub_department */

/*!50001 DROP TABLE IF EXISTS `vw_setup_sub_department` */;
/*!50001 DROP VIEW IF EXISTS `vw_setup_sub_department` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_setup_sub_department` AS select `a`.`id` AS `row1`,concat(`b`.`department_code`,' - ',`b`.`department`) AS `row2`,`a`.`sub_department_code` AS `row3`,`a`.`sub_department` AS `row4`,`a`.`isAvailable` AS `row5` from (`tbl_department_sub` `a` left join `tbl_department` `b` on(`b`.`id` = `a`.`department_id`)) */;

/*View structure for view vw_user_details */

/*!50001 DROP TABLE IF EXISTS `vw_user_details` */;
/*!50001 DROP VIEW IF EXISTS `vw_user_details` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user_details` AS select `a`.`userid` AS `row1`,`a`.`usertype` AS `row2`,`a`.`username` AS `row3`,`a`.`password` AS `row4`,`func_fullname`(`b`.`id`) AS `row5`,`b`.`account_status` AS `row6`,`c`.`usertype` AS `row7` from ((`tbl_users` `a` left join `tbl_users_detail` `b` on(`a`.`userid` = `b`.`id`)) left join `tbl_usertype` `c` on(`c`.`id` = `a`.`usertype`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
