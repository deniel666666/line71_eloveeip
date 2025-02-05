ALTER TABLE `account` ADD COLUMN `email` VARCHAR(255) NULL COMMENT 'email' AFTER `user_name`;
ALTER TABLE `contact_type` ADD COLUMN `product_id` INT NOT NULL DEFAULT 0 COMMENT '對應行銷ID' AFTER `conta_type_name`;
ALTER TABLE `account` ADD COLUMN `cost` VARCHAR(200) NULL DEFAULT NULL COMMENT '費用' AFTER `email`;
ALTER TABLE `account` ADD COLUMN `start_time` DATE NULL DEFAULT NULL COMMENT '開始時間' AFTER `cost`;
ALTER TABLE `account` ADD COLUMN `end_time` DATE NULL DEFAULT NULL COMMENT '結束時間' AFTER `start_time`;