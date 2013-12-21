CREATE TABLE IF NOT EXISTS `member_point_logs` (
  `point_log_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ポイントログID',
  `customer_id` int(11) NOT NULL COMMENT '顧客ID',
  `reward_id` int(11) NOT NULL COMMENT 'リワードID',
  `log_time` datetime NOT NULL COMMENT 'ポイント変動日時',
  `subject` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ログのタイトル',
  `point` int(11) NOT NULL COMMENT '変動ポイント',
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '補足（対象リワード先など）',
  `commit_flg` tinyint(1) NOT NULL COMMENT 'ポイント適用済みフラグ',
  `create_time` datetime NOT NULL COMMENT 'データ登録日時',
  PRIMARY KEY (`point_log_id`),
  KEY `log_time` (`log_time`),
  KEY `advertise_key` (`description`,`create_time`),
  KEY `reward_id` (`reward_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ポイント取得／利用履歴のログ';
