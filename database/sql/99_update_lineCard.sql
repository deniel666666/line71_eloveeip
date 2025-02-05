UPDATE `property_tag` SET `prop_tag_name` = '公司名顏色：' WHERE `property_tag`.`prop_tag_id` = 2;
UPDATE `property_tag` SET `prop_tag_name` = '中文名：' WHERE `property_tag`.`prop_tag_id` = 3;
UPDATE `property_tag` SET `prop_tag_name` = '中文名顏色：' WHERE `property_tag`.`prop_tag_id` = 4;
UPDATE `property_tag` SET `prop_tag_name` = '介紹文字：' WHERE `property_tag`.`prop_tag_id` = 5;
UPDATE `property_tag` SET `prop_tag_name` = '文字顏色：' WHERE `property_tag`.`prop_tag_id` = 6;


INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('8', '8', '職稱：', '1', '5', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('9', '8', '職稱顏色：', '1', '6', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('10', '8', '區塊底色：', '1', '7', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('11', '8', '區塊底色：', '1', '8', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('12', '8', '英文名：', '1', '9', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('13', '8', '英文名顏色：', '1', '10', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('14', '8', '標題：', '1', '11', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('15', '8', '標題顏色：', '1', '12', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('16', '8', '社群文字：', '1', '13', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('17', '8', '文字顏色：', '1', '14', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('18', '8', '社群文字：', '1', '15', '1', '1', NULL, NULL);
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES ('19', '8', '文字顏色：', '1', '16', '1', '1', NULL, NULL);

ALTER TABLE `product` ADD `prod_img3` VARCHAR(30) NULL DEFAULT NULL COMMENT '主圖3' AFTER `prod_img2`;