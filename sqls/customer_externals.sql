CREATE TABLE IF NOT EXISTS `member_customer_externals` (
  `customer_external_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '外部連携ID',
  `customer_id` int(11) NOT NULL COMMENT '顧客ID',
  `external_type_id` int(11) NOT NULL COMMENT '外部連携種別ID',
  `external_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '外部連携用キー',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  `update_time` datetime NOT NULL COMMENT 'データ最終更新日時',
  PRIMARY KEY (`customer_external_id`),
  UNIQUE KEY `customer_id` (`customer_id`,`external_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='外部連携キーテーブル';
