-- 調整通知設定
ALTER TABLE `mailbox` CHANGE `line_id` `line_id` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'line notify id';
ALTER TABLE `mailbox` ADD `line_id_message` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'line message id' AFTER `line_id`;
