CREATE TABLE IF NOT EXISTS `member_customer_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '顧客ステータスID',
  `status_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '顧客ステータスコード',
  `status_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '顧客ステータス名',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  `update_time` datetime NOT NULL COMMENT 'データ最終更新日時',
  `delete_flg` tinyint(1) NOT NULL COMMENT '削除フラグ',
  PRIMARY KEY (`status_id`),
  UNIQUE KEY `customer_type_code` (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='顧客ステータステーブル';
