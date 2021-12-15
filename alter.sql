ALTER TABLE `genhr`.`business` ADD COLUMN `government_id` VARCHAR(64) NOT NULL AFTER `name`, ADD COLUMN `contact_person` VARCHAR(64) NULL AFTER `government_id`, ADD COLUMN `contact_email` VARCHAR(64) NULL AFTER `contact_person`, ADD COLUMN `contact_phone` VARCHAR(64) NULL AFTER `contact_email`; 

CREATE TABLE `genhr`.`business_role_credit` ( `id` INT(11) NOT NULL AUTO_INCREMENT, `business_id` INT(11) NOT NULL, `role` VARCHAR(64) NOT NULL, `credit` INT(11) NOT NULL, PRIMARY KEY (`id`) ); 

ALTER TABLE `genhr`.`business_employees` ADD COLUMN `em_role_id` INT(11) AFTER `em_role`; 

CREATE TABLE `genhr`.`business_payments` ( `id` INT(11) NOT NULL AUTO_INCREMENT, `business_id` INT(11) NOT NULL, `paid_date` DATETIME DEFAULT CURRENT_TIMESTAMP, `paid_amount` INT(11) NOT NULL, `invoice` VARCHAR(64), `balance` VARCHAR(64), `added_amount` VARCHAR(64), PRIMARY KEY (`id`) ); 

ALTER TABLE `genhr`.`business_transactions` ADD COLUMN `payment_id` INT(11) NULL AFTER `status`; 