-- 調整欄位排序，從「文字顏色：」到「公司名字型大小(像素(px))」有跳號
-- 調整欄位名稱，對應實際使用
UPDATE `property_tag` SET `prop_tag_order` = '17' WHERE `property_tag`.`prop_tag_id` = 22;
UPDATE `property_tag` SET `prop_tag_order` = '18' WHERE `property_tag`.`prop_tag_id` = 23;
UPDATE `property_tag` SET `prop_tag_order` = '19' WHERE `property_tag`.`prop_tag_id` = 24;
UPDATE `property_tag` SET `prop_tag_order` = '20' WHERE `property_tag`.`prop_tag_id` = 25;
UPDATE `property_tag` SET `prop_tag_order` = '21', `prop_tag_name` = '標題字型大小(像素(px))(暫無用)' WHERE `property_tag`.`prop_tag_id` = 26;
UPDATE `property_tag` SET `prop_tag_order` = '22', `prop_tag_name` = '介紹文字字型大小(像素(px))、區塊內文字型大小' WHERE `property_tag`.`prop_tag_id` = 27;
UPDATE `property_tag` SET `prop_tag_order` = '23' WHERE `property_tag`.`prop_tag_id` = 28;
UPDATE `property_tag` SET `prop_tag_order` = '24' WHERE `property_tag`.`prop_tag_id` = 29;

-- 20240923 強制同步line_card屬性欄位
DELETE FROM `property_tag` WHERE property_tag_id=8;
INSERT INTO `property_tag` (`prop_tag_id`, `property_tag_id`, `prop_tag_name`, `prop_type`, `prop_tag_order`, `prop_tag_status`, `lang_id`, `created_at`, `updated_at`) VALUES
(2, 8, '公司名顏色：', '1', 0, 1, 1, '2022-04-29 01:31:16', '2022-04-29 01:49:51'),
(3, 8, '中文名：', '1', 1, 1, 1, '2022-04-29 01:32:07', '2022-04-29 01:49:55'),
(4, 8, '中文名顏色：', '1', 2, 1, 1, '2022-04-29 01:32:14', '2022-04-29 01:49:59'),
(5, 8, '介紹文字：', '1', 3, 1, 1, '2022-04-29 01:32:51', '2022-04-29 01:50:03'),
(6, 8, '文字顏色：', '1', 4, 1, 1, '2022-05-02 18:55:40', '2022-05-02 18:55:40'),
(8, 8, '職稱：', '1', 5, 1, 1, NULL, NULL),
(9, 8, '職稱顏色：', '1', 6, 1, 1, NULL, NULL),
(10, 8, '卡尾區塊底色：', '1', 7, 1, 1, NULL, '2024-09-16 03:38:11'),
(11, 8, '卡身區塊底色(暫無用)：', '1', 8, 1, 1, NULL, '2024-09-16 03:41:47'),
(12, 8, '英文名：', '1', 9, 1, 1, NULL, NULL),
(13, 8, '英文名顏色：', '1', 10, 1, 1, NULL, NULL),
(14, 8, '標題：', '1', 11, 1, 1, NULL, NULL),
(15, 8, '標題顏色：', '1', 12, 1, 1, NULL, NULL),
(16, 8, '社群文字：', '1', 13, 1, 1, NULL, NULL),
(17, 8, '文字顏色：', '1', 14, 1, 1, NULL, NULL),
(18, 8, '社群文字：', '1', 15, 1, 1, NULL, NULL),
(19, 8, '文字顏色：', '1', 16, 1, 1, NULL, NULL),
(22, 8, '公司名字型大小(像素(px))', '1', 17, 1, 1, NULL, '2024-09-20 07:10:14'),
(23, 8, '中文名字型大小(像素(px))', '1', 18, 1, 1, NULL, '2024-09-20 07:10:17'),
(24, 8, '英文名字型大小(像素(px))', '1', 19, 1, 1, NULL, '2024-09-20 07:10:23'),
(25, 8, '職稱字型大小(像素(px))', '1', 20, 1, 1, NULL, '2024-09-20 07:10:31'),
(26, 8, '標題字型大小(像素(px))(暫無用)', '1', 21, 1, 1, NULL, '2024-09-20 07:49:44'),
(27, 8, '介紹文字字型大小(像素(px))、區塊內文字型大小', '1', 22, 1, 1, NULL, '2024-09-20 07:45:42'),
(28, 8, '社群文字1字型大小(像素(px))', '1', 23, 1, 1, NULL, '2024-09-20 07:10:35'),
(29, 8, '社群文字2字型大小(像素(px))', '1', 24, 1, 1, NULL, '2024-09-20 07:10:38');
