-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-05-14 05:34:21
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `web_template`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE `account` (
  `id` int(10) UNSIGNED NOT NULL,
  `acct` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號',
  `user_pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密碼',
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '暱稱',
  `user_info` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用戶內容',
  `user_ids` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '社交id',
  `user_role` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色',
  `user_type` int(11) NOT NULL DEFAULT 0 COMMENT '0外員1內員',
  `user_status` int(11) NOT NULL COMMENT '0停用1啟用2黑單',
  `show_status` int(1) NOT NULL DEFAULT 0,
  `admin_show` int(5) DEFAULT 1 COMMENT '0隱藏 1顯示',
  `user_active` int(11) NOT NULL DEFAULT 0 COMMENT '0未激1已激',
  `active_code` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '激活碼',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `account`
--

INSERT INTO `account` (`id`, `acct`, `user_pw`, `user_name`, `user_info`, `user_ids`, `user_role`, `user_type`, `user_status`, `show_status`, `admin_show`, `user_active`, `active_code`, `created_at`, `updated_at`) VALUES
(1, 'photonic', 'photo3599', 'photonic', NULL, NULL, '[\"admin\",\"manager\",\"trader\",\"member\"]', 1, 1, 1, 0, 1, '', '2020-04-07 01:20:08', '2020-04-07 01:20:08'),
(2, 'admin', 'admin', '管理者', NULL, NULL, '[\"admin\",\"manager\",\"trader\",\"member\"]', 1, 1, 1, 1, 1, '', '2019-07-01 09:30:26', '2019-07-01 09:30:26'),
(3, 'test', 'test', 'test', NULL, NULL, '[\"member\",\"manager\"]', 1, 1, 0, 1, 1, '', '2020-10-22 03:28:38', '2020-10-22 03:28:38');

-- --------------------------------------------------------

--
-- 資料表結構 `category_pro_order`
--

CREATE TABLE `category_pro_order` (
  `category_id` int(255) UNSIGNED NOT NULL COMMENT '對應category_tag -> cate_tag_id',
  `product_id` int(255) UNSIGNED NOT NULL COMMENT '對應product-> prod_id',
  `category_order` int(255) DEFAULT 0 COMMENT '類別排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `category_tag`
--

CREATE TABLE `category_tag` (
  `cate_tag_id` int(10) UNSIGNED NOT NULL,
  `cate_id` int(10) DEFAULT 1 COMMENT 'product_num',
  `cate_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '類別名稱',
  `cate_subtitle` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '圖片(小)',
  `tag_img_wide` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片(大)',
  `cate_tag_img` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片網址',
  `cate_tag_desc` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '類別說明',
  `cate_order` int(11) NOT NULL DEFAULT 0,
  `cate_status` tinyint(4) NOT NULL COMMENT '1:啟用 0:停用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `hierarchy_id` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '階層對應cate_tag_id',
  `hierarchy_count` int(11) DEFAULT NULL COMMENT '階層數，第一階=1',
  `parent_id` int(5) DEFAULT NULL COMMENT '類別父ID',
  `promote` tinyint(4) NOT NULL DEFAULT 0 COMMENT '(0:普通 1:推薦)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cms`
--

CREATE TABLE `cms` (
  `cms_id` int(10) UNSIGNED NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `cms_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `order_id` int(11) DEFAULT NULL COMMENT '內容順序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cms_layout`
--

CREATE TABLE `cms_layout` (
  `cms_id` int(10) UNSIGNED NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `cms_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `order_id` int(11) DEFAULT NULL COMMENT '內容順序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cms_layout_relation`
--

CREATE TABLE `cms_layout_relation` (
  `child_template_id` int(11) NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type id',
  `name` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '子模板名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cms_layout_type`
--

CREATE TABLE `cms_layout_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `cont_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '型別',
  `cms_type_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '名稱',
  `cate_order` int(11) NOT NULL DEFAULT 0,
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `lang_id` tinyint(4) NOT NULL COMMENT '對應語言版id',
  `cate_status` int(4) NOT NULL COMMENT '1:啟用 0:停用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cms_type`
--

CREATE TABLE `cms_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `cont_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '型別',
  `cms_type_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '名稱',
  `cate_order` int(11) NOT NULL DEFAULT 0,
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `lang_id` tinyint(4) NOT NULL COMMENT '對應語言版id',
  `cate_status` int(4) NOT NULL COMMENT '1:啟用 0:停用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `cms_type`
--

INSERT INTO `cms_type` (`id`, `cont_type`, `cms_type_name`, `cate_order`, `child_template_id`, `lang_id`, `cate_status`, `created_at`, `updated_at`) VALUES
(1, 'public_cms', '共用設定', 0, 0, 1, 1, NULL, NULL),
(2, 'about', '關於我們', 1, 0, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `contact`
--

CREATE TABLE `contact` (
  `conta_id` int(10) UNSIGNED NOT NULL,
  `conta_type_id` int(11) NOT NULL COMMENT '聯絡型別',
  `conta_item_id` int(11) NOT NULL DEFAULT 0 COMMENT '聯絡選項',
  `conta_datetime` datetime NOT NULL COMMENT '日期',
  `conta_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `conta_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '連絡電話',
  `conta_email` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '電子郵件',
  `conta_company` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司機關',
  `conta_cont` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '詢問內容',
  `conta_resp` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '處理狀態紀錄',
  `contact_status` tinyint(4) NOT NULL COMMENT '0:新郵件 1:打開 2:已處理 3:垃圾桶',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `contact_item`
--

CREATE TABLE `contact_item` (
  `conta_item_id` int(10) UNSIGNED NOT NULL,
  `conta_type_id` int(11) NOT NULL COMMENT '聯絡型別',
  `conta_item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '選項名稱',
  `conta_item_status` tinyint(4) NOT NULL COMMENT '0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `contact_type`
--

CREATE TABLE `contact_type` (
  `conta_type_id` int(10) UNSIGNED NOT NULL,
  `conta_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡型別',
  `conta_type_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡型別名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `contact_type`
--

INSERT INTO `contact_type` (`conta_type_id`, `conta_type`, `conta_type_name`, `created_at`, `updated_at`) VALUES
(1, 'conta1', '聯絡我們表單A', NULL, NULL),
(2, 'conta2', '聯絡我們表單B', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `customer`
--

CREATE TABLE `customer` (
  `id` int(10) NOT NULL,
  `acct` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號(手機)',
  `user_pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密碼',
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `email` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '信箱',
  `birth_day` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '生日',
  `line_id` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Line帳號編號',
  `city` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '縣市',
  `district` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '區',
  `zipcode` int(11) DEFAULT NULL COMMENT '郵遞區號',
  `road` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `telephone` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '市話',
  `user_status` int(11) NOT NULL DEFAULT 0 COMMENT '0停用1啟用2黑單',
  `complete_reg` tinyint(1) NOT NULL DEFAULT 0 COMMENT '註冊狀態 0.未完成 1.完成',
  `tracking_shop` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '追蹤店家(以, join shop_id)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `customer`
--

INSERT INTO `customer` (`id`, `acct`, `user_pw`, `user_name`, `email`, `birth_day`, `line_id`, `city`, `district`, `zipcode`, `road`, `telephone`, `user_status`, `complete_reg`, `tracking_shop`, `created_at`, `updated_at`) VALUES
(1, '0900000000', 'a1234', '陳彥安', 'andyccoge@gmail.com', '2020-11-21', 'Uc240dd482fbc124a041f77afe1a396e9', '基隆市', '信義區', 201, 'Test', '0900000000', 1, 1, '13,9', '2020-11-17 04:00:04', '2021-03-24 08:51:36'),
(3, '0900252025', '123', 'test', 'andyplanner@photonic.com.tw', '2020-11-04', '', '臺東縣', '長濱鄉', 962, 'ggggdfgsdfgdfgdfg', '02-27386266', 1, 1, NULL, '2020-11-17 05:49:52', '2020-11-17 05:49:52'),
(4, '0900252555', '123', 'etest', 'test@gmail.tw', '2020-11-07', '', '臺東縣', '大武鄉', 965, 'asdfasdfas', '0800-2882-5252', 1, 1, NULL, '2020-11-17 07:21:57', '2020-11-20 02:23:59'),
(7, '0900000005', '123', 'sdfasdf', '', '', '', '屏東縣', '崁頂鄉', 924, 'sdafasd', '', 1, 1, NULL, '2020-11-18 04:03:52', '2020-11-20 02:23:59'),
(11, '0988888888', '123', 'WWWW', 'test@gmail.com', '2020-11-13', NULL, '基隆市', '仁愛區', 200, '123', NULL, 1, 0, NULL, '2020-11-20 08:48:19', '2020-11-20 08:48:59'),
(13, '0800000000', '123', 'fasfsdfasd', 'rqeqe@gmail.com', '', '', '基隆市', '信義區', 201, '敦化南路二段180號', '', 1, 1, NULL, '2020-11-20 08:58:28', '2020-11-20 08:58:28'),
(14, '09000123123', '123', '佳節快樂', '1231@123.com', '', 'Ua501c0b752f766c335484f94e2d86e90', '基隆市', '信義區', 201, '123123123', '', 1, 1, NULL, '2020-11-20 09:11:32', '2020-11-20 09:11:32'),
(15, '0937983569', 'a1234', '彥安', 'andyccoge@gmail.com', '', '', '新北市', '永和區', 234, 'Wwww', '', 1, 1, NULL, '2021-03-24 08:53:19', '2021-03-24 08:53:19');

-- --------------------------------------------------------

--
-- 資料表結構 `fare`
--

CREATE TABLE `fare` (
  `fare_id` int(10) UNSIGNED NOT NULL,
  `fare_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '運費名稱',
  `fare_cost` int(11) NOT NULL COMMENT '金額',
  `free_rule` float DEFAULT NULL COMMENT '滿額免運',
  `fare_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `fare`
--

INSERT INTO `fare` (`fare_id`, `fare_name`, `fare_cost`, `free_rule`, `fare_status`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, '本島運費', 300, 500, 1, 1, '2019-07-01 09:30:27', '2020-10-27 08:35:21'),
(3, 'AAAA', 123, NULL, 0, 1, '2020-02-21 09:31:35', '2020-10-27 08:35:25'),
(4, 'dsfasdf', 0, NULL, 0, 1, '2020-10-27 08:19:12', '2020-10-27 08:35:25');

-- --------------------------------------------------------

--
-- 資料表結構 `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(10) UNSIGNED NOT NULL,
  `gallery_type_id` int(11) NOT NULL COMMENT 'gallery_type id',
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '圖檔名稱',
  `img_name_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '行動版圖檔名稱',
  `slider_order` int(11) NOT NULL COMMENT '輪撥順序',
  `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片替代文字',
  `img_status` int(11) NOT NULL COMMENT '0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `gallery_cont` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片相關設定',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `gallery_type`
--

CREATE TABLE `gallery_type` (
  `gallery_type_id` int(10) UNSIGNED NOT NULL,
  `gallery_module` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '輪撥代碼',
  `gallery_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '輪撥名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `gallery_type`
--

INSERT INTO `gallery_type` (`gallery_type_id`, `gallery_module`, `gallery_name`, `created_at`, `updated_at`) VALUES
(1, 'gallery', '大圖輪播', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `journal_order`
--

CREATE TABLE `journal_order` (
  `jn_od_id` int(10) UNSIGNED NOT NULL,
  `od_sn` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '訂單序號',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '0:非會員',
  `buyer` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '訂購人',
  `recipient` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '收件人',
  `od_cont` text COLLATE utf8_unicode_ci NOT NULL COMMENT '訂閱內容',
  `od_info` text COLLATE utf8_unicode_ci NOT NULL COMMENT '訂單資訊',
  `pay_status` int(11) NOT NULL DEFAULT 0 COMMENT '是否已付費',
  `shipping_status` int(11) NOT NULL DEFAULT 0 COMMENT '貨物是否已寄出',
  `lang_id` int(11) NOT NULL COMMENT '多國語言編號',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `lang`
--

CREATE TABLE `lang` (
  `lang_id` int(10) UNSIGNED NOT NULL,
  `lang_type` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '語言代號',
  `lang_word` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'icon語言顯示',
  `lang_color` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'icon 背景色',
  `lang_order` int(11) NOT NULL,
  `lang_status` tinyint(4) NOT NULL COMMENT '1:啟用 0:停用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `lang`
--

INSERT INTO `lang` (`lang_id`, `lang_type`, `lang_word`, `lang_color`, `lang_order`, `lang_status`, `created_at`, `updated_at`) VALUES
(1, 'tw', '繁', '#0088A8', 1, 1, '2019-07-01 09:30:27', '2019-07-01 09:30:27'),
(2, 'en', '英', '#0088A8', 1, 1, '2019-07-01 09:30:27', '2019-07-01 09:30:27');

-- --------------------------------------------------------

--
-- 資料表結構 `love_record`
--

CREATE TABLE `love_record` (
  `id` int(11) NOT NULL,
  `model` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '資料表',
  `primary_id` int(11) NOT NULL COMMENT '資料表主key',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '會員id',
  `count` int(11) NOT NULL DEFAULT 1 COMMENT '計數',
  `lang_id` int(11) NOT NULL DEFAULT 1 COMMENT '語言版',
  `ip` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'ip地址',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `mailbox`
--

CREATE TABLE `mailbox` (
  `mb_id` int(10) UNSIGNED NOT NULL,
  `rx_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '收件人',
  `rx_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '收件信箱',
  `mb_status` int(11) NOT NULL COMMENT '0:停用 1:啟用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `mailbox`
--

INSERT INTO `mailbox` (`mb_id`, `rx_name`, `rx_mail`, `mb_status`, `created_at`, `updated_at`) VALUES
(1, 'client', 'client@photonic.com.tw', 1, '2019-07-01 09:30:25', '2020-11-13 05:41:43');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `id` int(10) NOT NULL,
  `acct` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號',
  `user_pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密碼',
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `user_ids` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '社交id',
  `category` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '種類 ex:餐飲,金融',
  `pic` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主圖',
  `logo` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'logo圖',
  `id_code` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '身份證字號/統編',
  `service_type` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服務類型',
  `city` text COLLATE utf8_unicode_ci NOT NULL COMMENT '縣市',
  `district` text COLLATE utf8_unicode_ci NOT NULL COMMENT '區',
  `zipcode` int(11) DEFAULT NULL COMMENT '郵遞區號',
  `road` text COLLATE utf8_unicode_ci NOT NULL COMMENT '地址',
  `cellphone` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手機',
  `telephone` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '電話',
  `user_info` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用戶內容',
  `sub_pics` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '副圖',
  `user_status` int(11) NOT NULL DEFAULT 0 COMMENT '0停用1啟用2黑單',
  `show_status` int(11) NOT NULL COMMENT '內容顯示',
  `user_active` int(11) NOT NULL COMMENT '0未激1已激',
  `active_code` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '激活碼',
  `shop_link` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '店家購物車網址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `member_contact`
--

CREATE TABLE `member_contact` (
  `conta_id` int(10) UNSIGNED NOT NULL,
  `conta_type_id` int(11) NOT NULL COMMENT '聯絡型別',
  `conta_item_id` int(11) NOT NULL COMMENT '聯絡選項',
  `member_id` int(11) NOT NULL COMMENT '會員id',
  `conta_datetime` datetime NOT NULL COMMENT '日期',
  `conta_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `conta_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '連絡電話',
  `conta_email` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '電子郵件',
  `conta_company` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司機關',
  `conta_cont` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '詢問內容',
  `conta_resp` longtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '處理狀態紀錄',
  `contact_status` tinyint(4) NOT NULL COMMENT '0:新郵件 1:打開 2:已處理 3:垃圾桶',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `member_contact_item`
--

CREATE TABLE `member_contact_item` (
  `conta_item_id` int(10) UNSIGNED NOT NULL,
  `conta_type_id` int(11) NOT NULL COMMENT '聯絡型別',
  `member_id` int(11) NOT NULL COMMENT '會員id',
  `conta_item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '選項名稱',
  `conta_item_status` tinyint(4) NOT NULL COMMENT '0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `member_contact_type`
--

CREATE TABLE `member_contact_type` (
  `conta_type_id` int(10) UNSIGNED NOT NULL,
  `conta_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡型別',
  `conta_type_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡型別名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `member_contact_type`
--

INSERT INTO `member_contact_type` (`conta_type_id`, `conta_type`, `conta_type_name`, `created_at`, `updated_at`) VALUES
(1, 'contact', '回函表', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `member_gallery`
--

CREATE TABLE `member_gallery` (
  `gallery_id` int(11) NOT NULL,
  `gallery_type_id` int(11) NOT NULL COMMENT 'gallery_type id',
  `member_id` int(11) NOT NULL COMMENT '會員id',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '圖檔名稱',
  `img_name_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '行動版圖檔名稱',
  `slider_order` int(11) NOT NULL COMMENT '輪撥順序',
  `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片替代文字',
  `img_status` int(11) NOT NULL COMMENT '0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `gallery_cont` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片相關設定',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `member_gallery` ADD `member_article_type` TEXT CHARACTER 
SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '文章分類(,分隔)' AFTER `member_id`;
-- --------------------------------------------------------

--
-- 資料表結構 `member_gallery_cms`
--

CREATE TABLE `member_gallery_cms` (
  `cms_id` int(10) UNSIGNED NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `cms_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `order_id` int(11) DEFAULT NULL COMMENT '內容順序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `member_gallery_type`
--

CREATE TABLE `member_gallery_type` (
  `gallery_type_id` int(11) NOT NULL,
  `gallery_module` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '輪撥代碼',
  `gallery_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '輪撥名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `member_gallery_type`
--

INSERT INTO `member_gallery_type` (`gallery_type_id`, `gallery_module`, `gallery_name`, `created_at`, `updated_at`) VALUES
(1, 'news', '最新消息', NULL, NULL),
(2, 'services', '服務內容', NULL, NULL),
(3, 'articles', '文章管理', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `member_type_relation`
--

CREATE TABLE `member_type_relation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '會員id',
  `type` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '方案類別 A、B、C、D',
  `start_time` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '開始時間(0時0分)',
  `end_time` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '結束時間(23時59分)',
  `contract_number` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '合約編號',
  `note` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '備註',
  `online` tinyint(1) NOT NULL DEFAULT 1 COMMENT '狀態 1.啟用 0.停用',
  `created_at` datetime NOT NULL COMMENT '建立時間',
  `updated_at` datetime NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `menu_lang`
--

CREATE TABLE `menu_lang` (
  `menu_lang_id` int(10) UNSIGNED NOT NULL,
  `menu_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_lang_order` int(11) NOT NULL,
  `menu_color` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_code` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_11_14_061958_create_cms_type_models_table', 1),
(2, '2018_11_14_062335_create_cms_models_table', 1),
(3, '2018_11_15_065433_create_gallery_models_table', 1),
(4, '2018_11_15_065449_create_gallery_type_models_table', 1),
(5, '2018_11_26_071752_create_mailbox_models_table', 1),
(6, '2018_11_27_094718_create_contact_item_models_table', 1),
(7, '2018_11_27_094728_create_contact_models_table', 1),
(8, '2018_11_27_094749_create_contact_type_models_table', 1),
(9, '2018_11_27_102623_create_hire_models_table', 1),
(10, '2018_11_27_102632_create_hire_item_models_table', 1),
(11, '2018_11_28_030130_create_miscellaneous_models_table', 1),
(12, '2018_11_28_070420_create_account_models_table', 1),
(13, '2018_12_25_044844_create_lang_models_table', 1),
(14, '2018_12_25_045819_create_menu_lang_models_table', 1),
(15, '2019_01_06_194545_create_category_tag_models_table', 1),
(16, '2019_01_08_055932_create_property_tag_models_table', 1),
(17, '2019_01_08_195357_create_seo_models_table', 1),
(18, '2019_01_08_211709_create_product_models_table', 1),
(19, '2019_01_08_211728_create_product_type_models_table', 1),
(20, '2019_01_08_211746_create_product_describe_models_table', 1),
(21, '2019_01_08_211759_create_product_property_models_table', 1),
(22, '2019_01_08_211813_create_product_img_models_table', 1),
(23, '2019_01_08_211822_create_prod_specification_models_table', 1),
(24, '2019_01_08_211850_create_prod_content_models_table', 1),
(25, '2019_01_10_022130_create_product_category_models_table', 1),
(26, '2019_01_16_030515_create_fare_models_table', 1),
(27, '2019_01_21_012755_create_product2_models_table', 1),
(28, '2019_01_21_012806_create_prod_content2_models_table', 1),
(29, '2019_01_21_012816_create_prod_specification2_models_table', 1),
(30, '2019_01_21_012827_create_product_category2_models_table', 1),
(31, '2019_01_21_012837_create_product_describe2_models_table', 1),
(32, '2019_01_21_012847_create_product_img2_models_table', 1),
(33, '2019_01_21_012857_create_product_property2_models_table', 1),
(34, '2019_01_21_012906_create_product_type2_models_table', 1),
(35, '2019_01_21_012916_create_property_tag2_models_table', 1),
(36, '2019_01_22_020531_create_category_tag2_models_table', 1),
(37, '2019_02_14_035625_create_order_models_table', 1),
(38, '2019_02_20_182557_create_journal_order_models_table', 1),
(39, '2019_02_26_143557_create_content_models_table', 1),
(40, '2019_03_04_180910_create_content_tag_models_table', 1),
(41, '2019_03_04_180943_create_content_category_models_table', 1),
(42, '2019_05_29_170053_create_role_task_table', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `miscellaneous`
--

CREATE TABLE `miscellaneous` (
  `misc_id` int(10) UNSIGNED NOT NULL,
  `misc_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '雜項型別',
  `misc_value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '雜項內容',
  `misc_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '雜項備註',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `miscellaneous`
--

INSERT INTO `miscellaneous` (`misc_id`, `misc_type`, `misc_value`, `misc_note`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, 'policy', '非常歡迎您光臨「傳訊光-萬用後台」（以下簡稱本網站），為了讓您能夠安心的使用本網站的各項服務與資訊，特此向您說明本網站的隱私權保護政策，以保障您的權益，請您詳閱下列內容：  一、隱私權保護政策的適用範圍 隱私權保護政策內容，包括本網站如何處理在您使用網站服務時收集到的個人識別資料。隱私權保護政策不適用於本網站以外的相關連結網站，也不適用於非本網站所委託或參與管理的人員。  二、個人資料的蒐集、處理及利用方式 當您造訪本網站或使用本網站所提供之功能服務時，我們將視該服務功能性質，請您提供必要的個人資料，並在該特定目的範圍內處理及利用您的個人資料；非經您書面同意，本網站不會將個人資料用於其他用途。 本網站在您使用服務信箱、問卷調查等互動性功能時，會保留您所提供的姓名、電子郵件地址、聯絡方式及使用時間等。 於一般瀏覽時，伺服器會自行記錄相關行徑，包括您使用連線設備的IP位址、使用時間、使用的瀏覽器、瀏覽及點選資料記錄等，做為我們增進網站服務的參考依據，此記錄為內部應用，決不對外公佈。 為提供精確的服務，我們會將收集的問卷調查內容進行統計與分析，分析結果之統計數據或說明文字呈現，除供內部研究外，我們會視需要公佈統計數據及說明文字，但不涉及特定個人之資料。  三、資料之保護 本網站主機均設有防火牆、防毒系統等相關的各項資訊安全設備及必要的安全防護措施，加以保護網站及您的個人資料採用嚴格的保護措施，只由經過授權的人員才能接觸您的個人資料，相關處理人員皆簽有保密合約，如有違反保密義務者，將會受到相關的法律處分。 如因業務需要有必要委託其他單位提供服務時，本網站亦會嚴格要求其遵守保密義務，並且採取必要檢查程序以確定其將確實遵守。  四、網站對外的相關連結 本網站的網頁提供其他網站的網路連結，您也可經由本網站所提供的連結，點選進入其他網站。但該連結網站不適用本網站的隱私權保護政策，您必須參考該連結網站中的隱私權保護政策。  五、與第三人共用個人資料之政策 本網站絕不會提供、交換、出租或出售任何您的個人資料給其他個人、團體、私人企業或公務機關，但有法律依據或合約義務者，不在此限。 前項但書之情形包括不限於： 經由您書面同意。 法律明文規定。 為免除您生命、身體、自由或財產上之危險。 與公務機關或學術研究機構合作，基於公共利益為統計或學術研究而有必要，且資料經過提供者處理或蒐集者依其揭露方式無從識別特定之當事人。 當您在網站的行為，違反服務條款或可能損害或妨礙網站與其他使用者權益或導致任何人遭受損害時，經網站管理單位研析揭露您的個人資料是為了辨識、聯絡或採取法律行動所必要者。 有利於您的權益。 本網站委託廠商協助蒐集、處理或利用您的個人資料時，將對委外廠商或個人善盡監督管理之責。  六、Cookie之使用 為了提供您最佳的服務，本網站會在您的電腦中放置並取用我們的Cookie，若您不願接受Cookie的寫入，您可在您使用的瀏覽器功能項中設定隱私權等級為高，即可拒絕Cookie的寫入，但可能會導致網站某些功能無法正常執行 。  七、隱私權保護政策之修正 本網站隱私權保護政策將因應需求隨時進行修正，修正後的條款將刊登於網站上。', '隱私政策', 1, '2019-07-01 09:30:26', '2020-11-10 07:58:55'),
(2, 'consent', '會員條款\n為保障您的權益，請您在同意註冊為南門書局網路書店官網網站(以下稱本網站)會員前，詳細閱讀本同意書。本同意書內容詳述南門書局網路書店(以下簡稱本公司)所提供的服務，本同意書之目的，乃在於盡能保護會員在使用本網站服務時的權益，同時確認本公司會員之間的權利義務關係。請您在同意註冊成為會員前，詳細閱讀，並按下同意鍵，即可完成註冊動作。\n本公司有權於任何時間基於需要而修訂或變更本同意書內容，並取代先前的內容，修改後的同意書內容將公佈在本服務『最新消息』的網站上，本公司將不會個別通知會員。您使用本網站時，應隨時注意相關內容的修改與變更。您於任何修改或變更之後繼續使用本服務，將視為您已經閱讀、瞭解且同意接受已完成的相關修改與變更，並以您同意接受的相關修改與變更作為雙方的契約更新內容。若您不同意上述的本同意書修訂或更新方式，或不接受本同意書的其他任一約定，您應立即停止使用本服務。\n\n一、 個人資料保護政策的適用範圍\n1. 本公司遵守個人資料保護相關法令的規定。本公司對於您所登錄或留存的個人資料，在未獲得您的同意以前，絕不對非相關業務合作夥伴(含相關履行輔助人及代理人，以下合稱「策略夥伴」)以外之人揭露您的姓名、地址、電子郵件地址及其他依法受保護的個人資料。\n2. 如果涉及司法調查、法律訴訟及主管機關來函要求時，不在此適用範圍內。\n\n二、 個人資料之收集及使用\n1. 您同意本公司蒐集您的個人資料，以便在本公司經營範圍內執行會員事務(如會員管理、行銷、內部統計調查與分析、銷售產品及配運等)，您並同意在會員期間屆滿後本公司仍得在經營管理所需之法定期間內保存您的資料。您享有個人資料保護法第三條相關權利如下，但本公司因執行職務或業務所必須者，得拒絕之: (1)查詢或請求閱覽。(2)請求製給複製本。(3)請求補充或更正。(4)請求停止蒐集、處理及利用。(5)請求刪除。\n2. 本公司可利用您這些資料寄送公司相關資料或服務，包括新產品及最近促銷活動。\n3. 本公司會將您的個人資料做成會員統計資料，在不揭露您個人資料之前提下，可進行合法的使用以及公開。本公司也可能提供整體的統計資料予相關廣告商分析，但不會將您個人資料個別揭露。本公司不會銷售或租借其本公司之顧客名單給任何第三人。\n4. 在下列的情況下，本公司有可能會提供您的個人資料給相關機關，或主張其權利受侵害並提示司法機關正式文件之第三人：\n(1)基於法律之規定、或受司法機關與其他有權機關基於法定程序之要求；\n(2)在緊急情況下為維護其他會員或第三人之合法權益；\n(3)為維護會員服務系統的正常運作；\n(4)會員透過本服務購物、兌換贈品，因而產生的金流、物流必要資訊；\n(5)使用者有任何違反政府法令或本使用條款之情形。\n關於您所登錄或留存之個人資料及其他特定資料（例如交易資料），悉依本公司「隱私權保護政策」受到保護與規範。\n\n三、 關於會員資料\n1. 您於本網站註冊會員資料時，本網站為交易上安全，將以您的E-Mail為會員帳號。此外，您必須自行設定一組密碼做為個人辨識使用，以保障您的交易安全。\n2. 您註冊會員時必須填寫確實資料，若發現有不實之登錄，或原所登錄資料已不符合真實未更新，本網站保留隨時暫停或終止您網路會員資格即使用各項服務資格之權益。若您冒用他人名義，並造成其他會員或本站之損失，本網站將追究相關法律責任，並提供資料配合司法機關調查。\n3. 就本網站而言，各該使用者帳號及密碼的組合即代表使用者個人，其於使用本網站服務上之行為，均視為使用者的本人行為。您必須妥善設定、維護及保管您的帳號及密碼，包含但不限使用本網站服務結束時的適時登出手續。如果您洩漏自己的個人資料、會員密碼或付款資料，並使得第三人有使用的機會時，您必須就第三人的行為負全部責任。\n4. 若未滿法定成人年齡欲加入會員時，在瀏覽網頁及執行購物行為時，請由監護人陪同在旁指導，若發生不當之購物行為，監護人應出面代表協調處理事宜。\n5. 您如果選擇以信用卡方式購物時，必須填寫確實的信用卡資料。若發現有不實登錄或任何未經持卡人許可而盜刷其信用卡的情形時，本網站得以暫停或終止其會員資格，若違反相關法律，亦將依法追究。本網站為保護會員的隱私及權益，並不會留存會員在網站上登錄的信用卡號等金融資料。\n6. 您的帳號若有被冒用時，應立即通知本公司。本公司於知悉您的帳號密碼被冒用時，將立即暫停該帳號所生交易的處理及後續利用。\n\n四、 關於網站經營\n1. 本公司有權不經通知隨時停止或是更改各項服務內容。\n2. 本網站所有資料包含文字、軟體、圖片、影片、音樂等，均受中華民國著作權法、商標法及國際智慧財產權等相關規定之保護，禁止未經授權的修改、抄襲、出租、外借、出售等行為，請充分尊重智慧財產權、著作權、專利權等相關權利，違者依法處置。\n3. 本網站內部份刊登的文章及資訊引用專家學者的言論，僅供參考，不代表本網站的立場，您對於內容若有任何疑問，宜求教於專業人員，依個人狀況進行諮詢。\n4. 本公司有權視情況採取電子郵件勸誡、減除某些會員權益、取消您的會員資格等措施，或是交由執法機關或主管單位處理。\n\n五、 資料保全\n1. 為保障您的個人資料及使用安全，您在本網站的個人資料會用密碼保護。\n2. 承諾保護您個人資訊的安全，保護個人資料以防止未經授權的資料存取、使用或公開。\n\n六、停止或中斷提供服務\n本公司確保以符合目前一般可合理期待安全性之方式及技術，維護本網站的正常運作。但在下列情況之下，本公司將有權暫停、中斷或拒絕提供本服務的全部或一部份，且不負責事先通知您的義務，本公司對使用者任何直接或間接的損害，均不負任何賠償或補償的義務：\n1.對本服務相關軟硬體設備進行搬遷、更換、升級、保養或維修時；\n2.使用者有任何違反政府法令或本同意書的情形；\n3.天災或其他不可抗力因素所導致的服務停止或中斷；\n4.其他不可歸責於本公司事由所致的服務停止或中斷；\n5.非本公司事由而致本服務資訊顯示不正確、或遭偽造、竄改、刪除或擷取、或致系統中斷或不能正常運作時。\n6.使用本公司簡訊發送或其他電子訊息傳輸服務時，出現誹謗、攻擊或傷害性文字，或其他違背公序良俗的內容，本公司有權拒絕您使用本服務。\n7.其他本公司認為有需要停止或中斷服務的情形。\n8.本公司針對可預知的軟硬體維護計畫，有可能導致系統中斷或是暫停時，將盡可能地於該狀況發生前，以適當方式於本網站公告。\n9.本網站僅是依提供服務當時的既有項目、功能及現狀提供您使用，本公司並不負任何的擔保、保證或損害賠償責任。\n\n七、退換貨須知\n本網站提供所有消費者收受商品後七天猶豫期之權利，自您收訖商品後起算七天內，如您不願買受所收受之商品，請您退回商品並以書面或E-mail通知本網站，本網站將立即為您處理退貨事宜，並請您注意以下事項：\n1.在您收到貨品後，請儘速確認您所訂購的商品，如有非人為因素所致之商品損毀、刮傷、或運輸過程造成包裝破損不完整的情形，請您儘速通知本公司客服人員，我們會進行商品瑕疵或損壞鑑定，並儘速為您更換新品。\n2.如您需辦理退換貨時，請E-mail或來電至本公司，並提供以下資訊：\n(1)訂單號碼；\n(2)姓名及聯絡電話，以及收件地址；\n(3)退、換貨原因(非必填)\n3.當您欲退貨時，依民法規定，您與本店鋪應互負交易解除回復原狀之責，因此：\n(1)請您維持商品之全新狀態，並請確保所有商品、使用手冊、註冊回函、周邊零件、發票、相關配件等均無任何遺漏，連同原來的包裝一併退回，以便本網站為您處裡退款事宜。\n(2)若商品發生因不當使用、拆卸等人為因素所致之故障、損毀、磨損、擦傷、刮傷、髒汙、包裝破損不完整之情況，導致無法完整退回本網站時，本網站將向您酌收回復原狀之費用，或依商品之保存狀況按比例向您請求商品之價額。\n(3)如需退換貨，請洽本公司客服專線：02-29118833；本網站「聯絡我們」留言。\n\n八、產品保固\n1.本產品之保固期：\n(1)按保固書所載之保固到期日為保固期限。惟自您購買本產品之日起至保固到期日為止不滿一年，或保固書未記載保固到期日，保固期則以您購買本產品之日起算一年。\n(2)若保固書未記載保固到期日或經塗改，或有前項不滿一年之情形，而您又無相關購買憑證證明購買日期，保固期則以本產品之進口日起算壹年。\n(3)本公司係依您購買本產品之相關購買憑證（如：發票、收據）及產品保 固書認定保固期，請您務必妥善保存相關購買憑證，以確保您的權益。\n2.本產品保固範圍為保固期內，且正常使用本產品，如有下述情形者，則不在本產品保固服務範圍內：\n(1) 未遵循本產品之規格、使用手冊內容之方式操作或不當使用本產品者。 \n(2) 自行拆裝、修理、添加附件、產品機身遭塗改、更新非本公司軟體、或修改、調整本產品之電路、機械結構者。 \n(3) 自然耗損或屬消耗品之零件、附件及配件，例如：電池、充電器/座、相機帶、皮套、傳輸線及電源變壓器等。\n3.產品在保固期內，依使用手冊正常使用產品、新品不良，本公司提供免費維修服務，但如遇下列情況者，本公司得酌收材料與人工費用：\n(1)產品之保固資料不完整或不實者。\n(2)遭遇不可抗拒之天災、地變與人禍而導致產品損壞者。 \n(3)使用非本公司進口、製造或銷售之原廠耗材、配件或與型號不符之耗材 而導致產品損壞者。 \n(4)非屬產品保固範圍內之調整、保養、維修，或非本產品本身問題而導致產品損壞者(本公司得酌收檢修工時之費用)。\n(5)因您未正常使用本產品而導致產品損壞者。\n4.於保固期內而屬產品保固範圍內之維修，若遇有零件停產之情事，本公司得以其他機種之相容性零件代之，或以同等級之機種提供換機服務。\n5.當產品需要送修、保養或調整時，請您與本公司客服聯絡(請勿自行拆卸任何零件以免造成其他損壞)，就近送至各授權維修廠商。\n6.若無產品保固書將會影響您應有之權益，請您妥善保存您的產品保固書(即使保固期已過)，以便享有更完整之售後服務。如有遺失．破損，恕不補發。\n\n九、到貨時間\n訂購之商品將於訂單成立、付款完成後，2~5工作天內到貨;若未收到貨，請與本公司客服人員聯繫。\n\n十、活動優惠規則\n1.本網站之各項活動優惠不得合併使用。\n2.除本公司免運活動外，任一折扣方式皆不得抵扣運費。\n\n十一、相關資訊\n1.客服專線 TEL:（02）2911-8833。\n2.銀行代號:臺灣企銀(050)新店分行;帳號02512120043;戶名南門書局有限公司\n匯款完成後麻煩請至會員後台→會員專區填寫帳號後五碼及相關資訊或mail至 sunchin.books@gmail.com。\n\n十二、購物條款 \n1.本商城商品數量眾多，多少會產生缺貨或停售之情況！如遇商品缺貨或停售之情況，我們將會以電話或email與您聯繫，確認出貨事宜。\n2.下標成功或匯款成功不代表實質交易完成。我們保有保留接受訂單與否的權利！ \n3.每台電腦因螢幕解析度不同，多少會有些許色差，物品皆以實品顏色為標準，若您是對顏色標準相當嚴格之買家，請不要下標購買。 \n4.下標前請慎選款式及顏色並仔細詳閱商品、價格、運費等相關事宜。\n5.依動產交易法第三條之規定，買賣同意在商品未出貨前，貨品之所有權仍屬於賣方。', '會員同意書', 1, '2019-07-01 09:30:26', '2020-11-12 07:26:40');

-- --------------------------------------------------------

--
-- 資料表結構 `order_form`
--

CREATE TABLE `order_form` (
  `od_id` int(10) UNSIGNED NOT NULL,
  `od_sn` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '訂單序號',
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '0:非會員',
  `buyer` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '訂購人',
  `recipient` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '收件人',
  `od_cont` text COLLATE utf8_unicode_ci NOT NULL COMMENT '訂單內容',
  `od_info` text COLLATE utf8_unicode_ci NOT NULL COMMENT '訂單資訊',
  `pay_status` int(11) NOT NULL DEFAULT 0 COMMENT '是否已付費',
  `shipping_status` int(11) NOT NULL DEFAULT 0 COMMENT '貨物是否已寄出',
  `trash_status` int(11) NOT NULL DEFAULT 0 COMMENT '垃圾桶',
  `product_num` int(11) NOT NULL DEFAULT 1 COMMENT '商品管理編號',
  `lang_id` int(11) NOT NULL COMMENT '多國語言編號',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `prod_id` int(10) UNSIGNED NOT NULL,
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `prod_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '商品名稱',
  `prod_subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '副標題',
  `prod_main_sku` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '型號',
  `prod_show_s_datetime` datetime DEFAULT NULL COMMENT '日期開始',
  `prod_show_e_datetime` datetime DEFAULT NULL COMMENT '日期結束',
  `prod_s_datetime` datetime NOT NULL COMMENT '開始時間',
  `prod_e_datetime` datetime NOT NULL COMMENT '結束時間',
  `promote_prod` tinyint(4) NOT NULL DEFAULT 0 COMMENT '(0:普通 1:推薦)',
  `prod_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主圖',
  `prod_img2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主圖2',
  `prod_shelf` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:下架 1:上架',
  `prod_sale` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:停購 1:正常',
  `prod_order` int(11) DEFAULT 0 COMMENT '順序',
  `prod_status` tinyint(4) NOT NULL COMMENT '0:完成 1:主體+細節 2:詳細內容',
  `product_num` int(11) NOT NULL DEFAULT 1,
  `memory` int(10) DEFAULT 0 COMMENT '記憶 0:停用 1:啟用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_category`
--

CREATE TABLE `product_category` (
  `prod_cate_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `cate_tag_id` int(11) NOT NULL COMMENT '對應 category_tag id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_cms`
--

CREATE TABLE `product_cms` (
  `cms_id` int(10) UNSIGNED NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `cms_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `order_id` int(11) DEFAULT NULL COMMENT '內容順序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_cms_layout`
--

CREATE TABLE `product_cms_layout` (
  `cms_id` int(10) UNSIGNED NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type',
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `cms_img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片',
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `order_id` int(11) DEFAULT NULL COMMENT '內容順序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_cms_layout_relation`
--

CREATE TABLE `product_cms_layout_relation` (
  `child_template_id` int(11) NOT NULL,
  `cms_type_id` int(11) NOT NULL COMMENT '對應cms_type id',
  `name` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '子模板名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_cms_layout_type`
--

CREATE TABLE `product_cms_layout_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `cont_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '型別',
  `cms_type_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '名稱',
  `cate_order` int(11) NOT NULL DEFAULT 0,
  `child_template_id` int(11) NOT NULL DEFAULT 0 COMMENT '子模板id',
  `lang_id` tinyint(4) NOT NULL COMMENT '對應語言版id',
  `cate_status` int(4) NOT NULL COMMENT '1:啟用 0:停用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_describe`
--

CREATE TABLE `product_describe` (
  `prod_describe_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `prod_describe_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `prod_describe` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_img`
--

CREATE TABLE `product_img` (
  `prod_img_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `prod_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_desc` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片說明',
  `prod_order` int(10) DEFAULT 0,
  `prod_img_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `prod_img_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `prod_file_size` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_property`
--

CREATE TABLE `product_property` (
  `prod_type_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `prop_tag_id` int(11) NOT NULL COMMENT '對應 property_tag id',
  `prod_prop` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `prod_img_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_type`
--

CREATE TABLE `product_type` (
  `prod_type_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `prod_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '規格名稱',
  `type_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '價格',
  `type_sales_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '售價',
  `type_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:下架 1:上架',
  `prod_sn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '商品/套裝 編號',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_label`
--

CREATE TABLE `prod_label` (
  `prod_id` int(10) UNSIGNED NOT NULL,
  `label_tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_label_tag`
--

CREATE TABLE `prod_label_tag` (
  `label_tag_id` int(10) UNSIGNED NOT NULL,
  `label_prod_num` int(10) DEFAULT 1 COMMENT 'product_num',
  `label_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '類別名稱',
  `label_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '圖片',
  `label_img_desc` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '圖片說明',
  `label_tag_cont` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `label_order` int(11) NOT NULL DEFAULT 0,
  `label_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:啟用 0:停用',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_seo_property`
--

CREATE TABLE `prod_seo_property` (
  `prod_type_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL COMMENT '對應 product id',
  `prop_tag_id` int(11) UNSIGNED NOT NULL COMMENT '對應 prod_seo_property_tag seo_tag_id',
  `prod_prop` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `prod_img_path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_seo_property_tag`
--

CREATE TABLE `prod_seo_property_tag` (
  `seo_tag_id` int(10) UNSIGNED NOT NULL,
  `seo_prod_num` int(10) NOT NULL COMMENT '對應product_num',
  `seo_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',
  `seo_meta_property` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'meta屬性',
  `seo_placeholder` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1:text 2:img',
  `seo_tag_order` int(11) NOT NULL,
  `seo_status` int(5) DEFAULT 1 COMMENT '0:隱藏 1:顯示',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `prod_seo_property_tag`
--

INSERT INTO `prod_seo_property_tag` (`seo_tag_id`, `seo_prod_num`, `seo_name`, `seo_meta_property`, `seo_placeholder`, `seo_type`, `seo_tag_order`, `seo_status`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, 1, '網站內容說明', 'name=\"description\"', '網站內容說明', '1', 0, 1, 1, NULL, NULL),
(2, 1, 'FB內容說明', 'property=\"og:description\"', 'FB內容說明', '1', 1, 1, 1, NULL, NULL),
(3, 2, '網站內容說明', 'name=\"description\"', '網站內容說明', '1', 0, 1, 2, NULL, NULL),
(4, 2, 'FB內容說明', 'property=\"og:description\"', 'FB內容說明', '1', 1, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `prod_specification`
--

CREATE TABLE `prod_specification` (
  `prod_spec_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) NOT NULL COMMENT '對應 product id',
  `spec_no` int(11) NOT NULL COMMENT '第n組產品規格，給下拉選單用',
  `spec_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_tabs_property`
--

CREATE TABLE `prod_tabs_property` (
  `prod_type_id` int(10) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL COMMENT '對應 product id',
  `prop_tag_id` int(11) UNSIGNED NOT NULL COMMENT '對應 prod_tabs_property_tag tabs_tag_id',
  `prod_prop` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '內容',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `prod_tabs_property_tag`
--

CREATE TABLE `prod_tabs_property_tag` (
  `tabs_tag_id` int(10) UNSIGNED NOT NULL,
  `tabs_prod_num` int(10) NOT NULL COMMENT '對應product_num',
  `tabs_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',
  `tabs_order` int(11) NOT NULL,
  `tabs_status` int(5) DEFAULT 1 COMMENT '0:隱藏 1:顯示',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `property_tag`
--

CREATE TABLE `property_tag` (
  `prop_tag_id` int(10) UNSIGNED NOT NULL,
  `property_tag_id` int(10) DEFAULT 1,
  `prop_tag_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '內容名稱',
  `prop_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1:text 2:img',
  `prop_tag_order` int(11) NOT NULL,
  `prop_tag_status` int(5) DEFAULT 1 COMMENT '0:隱藏 1:顯示',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `property_tag_has_category_tag`
--

CREATE TABLE `property_tag_has_category_tag` (
  `prop_tag_id` int(10) UNSIGNED NOT NULL,
  `cate_tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `role_task`
--

CREATE TABLE `role_task` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色',
  `controller` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Controller名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `role_task`
--

INSERT INTO `role_task` (`id`, `role`, `controller`, `created_at`, `updated_at`) VALUES
(1, 'admin', '[\r\n									\"AccountController\",\r\n									\"accountCreate\",\r\n									\"accountEdit\",\r\n									\"AdminController\",\r\n									\"CategoryTagController\",\r\n									\"CategoryTag2Controller\",\r\n									\"CmsController\",\r\n									\"ContactController\",\r\n									\"ContactEditorController\",\r\n									\"ContentController\",\r\n									\"ContentTagController\",\r\n									\"ContTagController\",\r\n									\"FareController\",\r\n									\"GalleryController\",\r\n									\"GalleryCreateController\",\r\n									\"GalleryEditController\",\r\n									\"HireController\",\r\n									\"HireEditorController\",\r\n									\"JournalOrderController\",\r\n									\"LangController\",\r\n									\"MailboxController\",\r\n									\"MailboxCreateController\",\r\n									\"MailboxEditorController\",\r\n									\"MenuLangController\",\r\n									\"OrderController\",\r\n									\"OrderEditController\",\r\n									\"ProductController\",\r\n									\"Product2Controller\",\r\n									\"PropertyTagController\",\r\n									\"PropertyTag2Controller\",\r\n									\"RecruitController\",\r\n									\"SeoController\"\r\n								]', '2019-07-01 09:30:28', '2019-07-01 09:30:28'),
(2, 'manager', '[\r\n									\"AdminController\",\r\n									\"CategoryTagController\",\r\n									\"CategoryTag2Controller\",\r\n									\"CmsController\",\r\n									\"ContactController\",\r\n									\"ContactEditorController\",\r\n									\"ContentController\",\r\n									\"ContentTagController\",\r\n									\"ContTagController\",\r\n									\"FareController\",\r\n									\"GalleryController\",\r\n									\"GalleryCreateController\",\r\n									\"GalleryEditController\",\r\n									\"HireController\",\r\n									\"HireEditorController\",\r\n									\"JournalOrderController\",\r\n									\"LangController\",\r\n									\"MenuLangController\",\r\n									\"OrderController\",\r\n									\"OrderEditController\",\r\n									\"ProductController\",\r\n									\"Product2Controller\",\r\n									\"PropertyTagController\",\r\n									\"PropertyTag2Controller\",\r\n									\"RecruitController\"\r\n								]', '2019-07-01 09:30:28', '2019-07-01 09:30:28'),
(3, 'member', '[\r\n\"MemberGalleryController\",						]', '2019-07-01 09:30:28', '2019-07-01 09:30:28');

-- --------------------------------------------------------

--
-- 資料表結構 `seo`
--

CREATE TABLE `seo` (
  `seo_id` int(10) UNSIGNED NOT NULL,
  `web_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '網頁標題',
  `web_keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '關鍵字',
  `web_description` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '網頁描述',
  `fb_company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'FB顯示公司名稱',
  `fb_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'FB標題',
  `fb_description` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'FB描述',
  `fb_share_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'FB分享圖片',
  `tiwt_company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tiwtter顯示公司名稱',
  `tiwt_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tiwtter標題',
  `tiwt_description` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tiwtter描述',
  `google_verify` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Google驗證',
  `google_analysis_code` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Google分析追蹤碼',
  `google_sales_code` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Google再行銷碼',
  `yahoo_sales_code` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Yahoo再行銷碼',
  `hiden_description` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '隱藏描述詞',
  `robots` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Robots',
  `map_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Map',
  `lang_id` int(11) NOT NULL COMMENT '對應 lang id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `seo`
--

INSERT INTO `seo` (`seo_id`, `web_title`, `web_keyword`, `web_description`, `fb_company`, `fb_title`, `fb_description`, `fb_share_img`, `tiwt_company`, `tiwt_title`, `tiwt_description`, `google_verify`, `google_analysis_code`, `google_sales_code`, `yahoo_sales_code`, `hiden_description`, `robots`, `map_img`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, '萬用後台', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ggggg_tw', 'hhhhh_tw', 1, '2019-07-01 09:30:27', '2020-11-13 10:16:10'),
(2, '萬用後台_英', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 't2222', 't2222', 2, '2019-07-01 09:30:27', '2021-05-13 18:53:18');

-- --------------------------------------------------------

--
-- 資料表結構 `system_development`
--

CREATE TABLE `system_development` (
  `system_id` int(10) UNSIGNED NOT NULL,
  `client_title` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客戶名稱',
  `client_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客戶LOGO',
  `dev_team` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '系統開發',
  `dev_team_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `marketing` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '網路行銷',
  `marketing_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '網址',
  `com_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '連絡電話',
  `com_mail` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '信箱',
  `com_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `system_development`
--

INSERT INTO `system_development` (`system_id`, `client_title`, `client_logo`, `dev_team`, `dev_team_img`, `marketing`, `marketing_img`, `com_url`, `com_phone`, `com_mail`, `com_address`, `created_at`, `updated_at`) VALUES
(1, '萬用後台', '/public/upload/admin/system_development//file_2021-05-14_67002cc9e8.png', '傳訊光科技', '/public/upload/admin/system_development//file_2020-09-01_d0c25cc682.png', '和承國際整合行銷', '/public/upload/admin/system_development//file_2020-09-01_78db8bb26e.png', 'http://photonic.com.tw/', '0227386266', 'service@photonic.com.tw', '臺北市信義區基隆路2段189號16樓之8', '2020-04-07 06:35:00', '2021-05-13 19:28:18');

-- --------------------------------------------------------

--
-- 資料表結構 `system_intro`
--

CREATE TABLE `system_intro` (
  `system_id` int(10) UNSIGNED NOT NULL,
  `system_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '系統名稱',
  `system_version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '系統版本',
  `system_note` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '系統備註',
  `front_end` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT ' 前台開發程式',
  `back_end` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT ' 後台開發程式',
  `php_version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'php版本',
  `sql_version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'sql版本',
  `closing_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT ' 結案時間',
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '備註',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `system_intro`
--

INSERT INTO `system_intro` (`system_id`, `system_title`, `system_version`, `system_note`, `front_end`, `back_end`, `php_version`, `sql_version`, `closing_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 'laravel', '7.3', '1.其中有修改Laravel框架vendor\\laravel\\framework\\src\\Illuminate\\View\\Compilers\\Concerns的compileRegularEchos方法，使前台可以使用{{$variable or \"default\" }}語法，測試變數並輸出變數或預設值', 'Js,Angular,Jquery', 'PHP,Laravel', '7.0', '5.6.43', '', '1.0版本-修改日期20200730-更新項目tree顯示/product建置流程/product記憶/order遞增/分類排序\n2020-12-07 調修萬用後台程式結構\n2021-02-18 調修cms_type api:可用primary_keys搜尋id們\n\n2021-03-15 加入record功能(並應用到product上)\n2021-03-15 gallery新增和編輯頁面整併\n2021-03-15 product_property_tag編輯api路徑調整，避免相衝無法修改內容\n2021-03-16 product的副圖上傳新增圖片說明欄位\n2021-03-16 product修改搜尋條件，新增time_zone(時間區間 0.當前+預告, 1.當前, 2.預告 3.過往，以prod_show_s_datetime,prod_show_e_datetime判斷)\n\n2021-04-20 修改cms模板及RWD_eidtor_style.css，可使用api調用渲染後的html\n2021-05-10 product新增編輯畫面整合\n2021-05-11 自動勾選列表語言版並取得對應資料\n------ 2021-05-14 laravel框架版本更新至7.3\n\n2021-05-26 後台選單修改、gallery新增/編輯修改', '2020-04-07 08:11:38', '2021-05-13 19:31:06');

-- --------------------------------------------------------

--
-- 資料表結構 `view_record`
--

CREATE TABLE `view_record` (
  `id` int(11) NOT NULL,
  `model` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '資料表',
  `primary_id` int(11) NOT NULL COMMENT '資料表主key',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '會員id',
  `count` int(11) NOT NULL DEFAULT 1 COMMENT '計數',
  `lang_id` int(11) NOT NULL DEFAULT 1 COMMENT '語言版',
  `ip` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'ip地址',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `category_pro_order`
--
ALTER TABLE `category_pro_order`
  ADD PRIMARY KEY (`category_id`,`product_id`),
  ADD KEY `category_pro_order_has_product_id_foreign` (`product_id`);

--
-- 資料表索引 `category_tag`
--
ALTER TABLE `category_tag`
  ADD PRIMARY KEY (`cate_tag_id`);

--
-- 資料表索引 `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`cms_id`);

--
-- 資料表索引 `cms_layout`
--
ALTER TABLE `cms_layout`
  ADD PRIMARY KEY (`cms_id`);

--
-- 資料表索引 `cms_layout_relation`
--
ALTER TABLE `cms_layout_relation`
  ADD PRIMARY KEY (`child_template_id`);

--
-- 資料表索引 `cms_layout_type`
--
ALTER TABLE `cms_layout_type`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `cms_type`
--
ALTER TABLE `cms_type`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`conta_id`);

--
-- 資料表索引 `contact_item`
--
ALTER TABLE `contact_item`
  ADD PRIMARY KEY (`conta_item_id`);

--
-- 資料表索引 `contact_type`
--
ALTER TABLE `contact_type`
  ADD PRIMARY KEY (`conta_type_id`);

--
-- 資料表索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `fare`
--
ALTER TABLE `fare`
  ADD PRIMARY KEY (`fare_id`);

--
-- 資料表索引 `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- 資料表索引 `gallery_type`
--
ALTER TABLE `gallery_type`
  ADD PRIMARY KEY (`gallery_type_id`);

--
-- 資料表索引 `journal_order`
--
ALTER TABLE `journal_order`
  ADD PRIMARY KEY (`jn_od_id`),
  ADD UNIQUE KEY `journal_order_od_sn_unique` (`od_sn`);

--
-- 資料表索引 `lang`
--
ALTER TABLE `lang`
  ADD PRIMARY KEY (`lang_id`),
  ADD UNIQUE KEY `lang_lang_type_unique` (`lang_type`),
  ADD UNIQUE KEY `lang_lang_word_unique` (`lang_word`);

--
-- 資料表索引 `love_record`
--
ALTER TABLE `love_record`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`mb_id`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `member_contact`
--
ALTER TABLE `member_contact`
  ADD PRIMARY KEY (`conta_id`);

--
-- 資料表索引 `member_contact_item`
--
ALTER TABLE `member_contact_item`
  ADD PRIMARY KEY (`conta_item_id`);

--
-- 資料表索引 `member_contact_type`
--
ALTER TABLE `member_contact_type`
  ADD PRIMARY KEY (`conta_type_id`);

--
-- 資料表索引 `member_gallery`
--
ALTER TABLE `member_gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- 資料表索引 `member_gallery_cms`
--
ALTER TABLE `member_gallery_cms`
  ADD PRIMARY KEY (`cms_id`);

--
-- 資料表索引 `member_gallery_type`
--
ALTER TABLE `member_gallery_type`
  ADD PRIMARY KEY (`gallery_type_id`);

--
-- 資料表索引 `member_type_relation`
--
ALTER TABLE `member_type_relation`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `menu_lang`
--
ALTER TABLE `menu_lang`
  ADD PRIMARY KEY (`menu_lang_id`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD PRIMARY KEY (`misc_id`);

--
-- 資料表索引 `order_form`
--
ALTER TABLE `order_form`
  ADD PRIMARY KEY (`od_id`),
  ADD UNIQUE KEY `order_form_od_sn_unique` (`od_sn`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- 資料表索引 `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`prod_cate_id`),
  ADD UNIQUE KEY `unique` (`prod_id`,`cate_tag_id`);

--
-- 資料表索引 `product_cms`
--
ALTER TABLE `product_cms`
  ADD PRIMARY KEY (`cms_id`);

--
-- 資料表索引 `product_cms_layout`
--
ALTER TABLE `product_cms_layout`
  ADD PRIMARY KEY (`cms_id`);

--
-- 資料表索引 `product_cms_layout_relation`
--
ALTER TABLE `product_cms_layout_relation`
  ADD PRIMARY KEY (`child_template_id`);

--
-- 資料表索引 `product_cms_layout_type`
--
ALTER TABLE `product_cms_layout_type`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_describe`
--
ALTER TABLE `product_describe`
  ADD PRIMARY KEY (`prod_describe_id`);

--
-- 資料表索引 `product_img`
--
ALTER TABLE `product_img`
  ADD PRIMARY KEY (`prod_img_id`);

--
-- 資料表索引 `product_property`
--
ALTER TABLE `product_property`
  ADD PRIMARY KEY (`prod_type_id`);

--
-- 資料表索引 `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`prod_type_id`);

--
-- 資料表索引 `prod_label`
--
ALTER TABLE `prod_label`
  ADD PRIMARY KEY (`prod_id`,`label_tag_id`),
  ADD KEY `prod_label_tag` (`label_tag_id`);

--
-- 資料表索引 `prod_label_tag`
--
ALTER TABLE `prod_label_tag`
  ADD PRIMARY KEY (`label_tag_id`);

--
-- 資料表索引 `prod_seo_property`
--
ALTER TABLE `prod_seo_property`
  ADD PRIMARY KEY (`prod_type_id`,`prod_id`,`prop_tag_id`) USING BTREE,
  ADD KEY `prod_seo_property_prop_tag_id_foreign` (`prop_tag_id`),
  ADD KEY `prod_seo_property_prod_id_foreign` (`prod_id`);

--
-- 資料表索引 `prod_seo_property_tag`
--
ALTER TABLE `prod_seo_property_tag`
  ADD PRIMARY KEY (`seo_tag_id`);

--
-- 資料表索引 `prod_specification`
--
ALTER TABLE `prod_specification`
  ADD PRIMARY KEY (`prod_spec_id`);

--
-- 資料表索引 `prod_tabs_property`
--
ALTER TABLE `prod_tabs_property`
  ADD PRIMARY KEY (`prod_type_id`,`prod_id`,`prop_tag_id`) USING BTREE,
  ADD KEY `prod_tabs_property_prop_tag_id_foreign` (`prop_tag_id`),
  ADD KEY `prod_tabs_property_prod_id_foreign` (`prod_id`);

--
-- 資料表索引 `prod_tabs_property_tag`
--
ALTER TABLE `prod_tabs_property_tag`
  ADD PRIMARY KEY (`tabs_tag_id`);

--
-- 資料表索引 `property_tag`
--
ALTER TABLE `property_tag`
  ADD PRIMARY KEY (`prop_tag_id`);

--
-- 資料表索引 `property_tag_has_category_tag`
--
ALTER TABLE `property_tag_has_category_tag`
  ADD PRIMARY KEY (`prop_tag_id`,`cate_tag_id`),
  ADD KEY `property_tag_has_category_tag_tags` (`cate_tag_id`);

--
-- 資料表索引 `role_task`
--
ALTER TABLE `role_task`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`seo_id`) USING BTREE;

--
-- 資料表索引 `system_development`
--
ALTER TABLE `system_development`
  ADD PRIMARY KEY (`system_id`);

--
-- 資料表索引 `system_intro`
--
ALTER TABLE `system_intro`
  ADD PRIMARY KEY (`system_id`);

--
-- 資料表索引 `view_record`
--
ALTER TABLE `view_record`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `category_tag`
--
ALTER TABLE `category_tag`
  MODIFY `cate_tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cms`
--
ALTER TABLE `cms`
  MODIFY `cms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cms_layout`
--
ALTER TABLE `cms_layout`
  MODIFY `cms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cms_layout_relation`
--
ALTER TABLE `cms_layout_relation`
  MODIFY `child_template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cms_layout_type`
--
ALTER TABLE `cms_layout_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cms_type`
--
ALTER TABLE `cms_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `contact`
--
ALTER TABLE `contact`
  MODIFY `conta_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `contact_item`
--
ALTER TABLE `contact_item`
  MODIFY `conta_item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `contact_type`
--
ALTER TABLE `contact_type`
  MODIFY `conta_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `fare`
--
ALTER TABLE `fare`
  MODIFY `fare_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `gallery_type`
--
ALTER TABLE `gallery_type`
  MODIFY `gallery_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `journal_order`
--
ALTER TABLE `journal_order`
  MODIFY `jn_od_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `lang`
--
ALTER TABLE `lang`
  MODIFY `lang_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `love_record`
--
ALTER TABLE `love_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `mb_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_contact`
--
ALTER TABLE `member_contact`
  MODIFY `conta_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_contact_item`
--
ALTER TABLE `member_contact_item`
  MODIFY `conta_item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_contact_type`
--
ALTER TABLE `member_contact_type`
  MODIFY `conta_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_gallery`
--
ALTER TABLE `member_gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_gallery_cms`
--
ALTER TABLE `member_gallery_cms`
  MODIFY `cms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_gallery_type`
--
ALTER TABLE `member_gallery_type`
  MODIFY `gallery_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member_type_relation`
--
ALTER TABLE `member_type_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `menu_lang`
--
ALTER TABLE `menu_lang`
  MODIFY `menu_lang_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `miscellaneous`
--
ALTER TABLE `miscellaneous`
  MODIFY `misc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order_form`
--
ALTER TABLE `order_form`
  MODIFY `od_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_category`
--
ALTER TABLE `product_category`
  MODIFY `prod_cate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_cms`
--
ALTER TABLE `product_cms`
  MODIFY `cms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_cms_layout`
--
ALTER TABLE `product_cms_layout`
  MODIFY `cms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_cms_layout_relation`
--
ALTER TABLE `product_cms_layout_relation`
  MODIFY `child_template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_cms_layout_type`
--
ALTER TABLE `product_cms_layout_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_describe`
--
ALTER TABLE `product_describe`
  MODIFY `prod_describe_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_img`
--
ALTER TABLE `product_img`
  MODIFY `prod_img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_property`
--
ALTER TABLE `product_property`
  MODIFY `prod_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_type`
--
ALTER TABLE `product_type`
  MODIFY `prod_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_label_tag`
--
ALTER TABLE `prod_label_tag`
  MODIFY `label_tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_seo_property`
--
ALTER TABLE `prod_seo_property`
  MODIFY `prod_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_seo_property_tag`
--
ALTER TABLE `prod_seo_property_tag`
  MODIFY `seo_tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_specification`
--
ALTER TABLE `prod_specification`
  MODIFY `prod_spec_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_tabs_property`
--
ALTER TABLE `prod_tabs_property`
  MODIFY `prod_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `prod_tabs_property_tag`
--
ALTER TABLE `prod_tabs_property_tag`
  MODIFY `tabs_tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `property_tag`
--
ALTER TABLE `property_tag`
  MODIFY `prop_tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `role_task`
--
ALTER TABLE `role_task`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `seo`
--
ALTER TABLE `seo`
  MODIFY `seo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `system_development`
--
ALTER TABLE `system_development`
  MODIFY `system_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `system_intro`
--
ALTER TABLE `system_intro`
  MODIFY `system_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `view_record`
--
ALTER TABLE `view_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `category_pro_order`
--
ALTER TABLE `category_pro_order`
  ADD CONSTRAINT `category_pro_order_has_category_tag_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_tag` (`cate_tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_pro_order_has_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `prod_label`
--
ALTER TABLE `prod_label`
  ADD CONSTRAINT `prod_label_label_tag_id_foreign` FOREIGN KEY (`label_tag_id`) REFERENCES `prod_label_tag` (`label_tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prod_label_prod_id_foreign` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `prod_seo_property`
--
ALTER TABLE `prod_seo_property`
  ADD CONSTRAINT `prod_seo_property_prod_id_foreign` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prod_seo_property_prop_tag_id_foreign` FOREIGN KEY (`prop_tag_id`) REFERENCES `prod_seo_property_tag` (`seo_tag_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `prod_tabs_property`
--
ALTER TABLE `prod_tabs_property`
  ADD CONSTRAINT `prod_tabs_property_prod_id_foreign` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prod_tabs_property_prop_tag_id_foreign` FOREIGN KEY (`prop_tag_id`) REFERENCES `prod_tabs_property_tag` (`tabs_tag_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `property_tag_has_category_tag`
--
ALTER TABLE `property_tag_has_category_tag`
  ADD CONSTRAINT `prod_property_has_category_tag_foreign` FOREIGN KEY (`cate_tag_id`) REFERENCES `category_tag` (`cate_tag_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prod_property_has_property_tag_foreign` FOREIGN KEY (`prop_tag_id`) REFERENCES `property_tag` (`prop_tag_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
