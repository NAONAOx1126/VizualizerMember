CREATE TABLE IF NOT EXISTS `member_customer_external_types` (
  `external_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '外部連携種別ID',
  `external_type_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '外部連携種別コード',
  `external_type_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '外部連携種別名',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  `update_time` datetime NOT NULL COMMENT 'データ最終更新日時',
  PRIMARY KEY (`external_type_id`),
  UNIQUE KEY `external_type_code` (`external_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='外部連携用IDの種別テーブル';
