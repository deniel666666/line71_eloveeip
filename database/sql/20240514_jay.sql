ALTER TABLE `product` ADD COLUMN `create_user` INT NULL DEFAULT '2' COMMENT '建立者' AFTER `updated_at`;
ALTER TABLE `product` ADD COLUMN `own_user` INT NULL DEFAULT '2' COMMENT '擁有者' AFTER `updated_at`;
ALTER TABLE `product` ADD COLUMN `style` INT NULL DEFAULT '1' COMMENT '版型' AFTER `updated_at`;