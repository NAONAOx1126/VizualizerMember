CREATE TABLE IF NOT EXISTS `member_customer_favorites` (
  `customer_favorite_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'お気に入りID',
  `customer_id` int(11) DEFAULT NULL COMMENT '顧客ID',
  `product_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `create_time` datetime DEFAULT NULL COMMENT '登録日時',
  `update_time` datetime DEFAULT NULL COMMENT '最終更新日時',
  PRIMARY KEY (`customer_favorite_id`),
  KEY `fk_customer_favorites_customer_id` (`customer_id`),
  KEY `fk_customer_favorites_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
