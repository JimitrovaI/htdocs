ALTER TABLE `genhr`.`business` ADD COLUMN `payment_agreement` ENUM('WEEK','TWICE','MONTH') DEFAULT 'WEEK' NULL AFTER `contact_phone`; 
ALTER TABLE `genhr`.`business_employees` ADD FOREIGN KEY (`business_id`) REFERENCES `genhr`.`business`(`id`) ON DELETE RESTRICT; 

ALTER TABLE `genhr`.`business_transactions` CHANGE `status` `status` ENUM('PENDING','COMPLETE','OVERDUE') CHARSET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'PENDING' NOT NULL; 