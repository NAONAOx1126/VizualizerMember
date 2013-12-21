CREATE TABLE IF NOT EXISTS `member_customer_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '顧客種別ID',
  `type_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '顧客種別コード',
  `type_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '顧客種別名',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  `update_time` datetime NOT NULL COMMENT 'データ最終更新日時',
  `delete_flg` tinyint(1) NOT NULL COMMENT '削除フラグ',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `customer_type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='顧客種別テーブル';
