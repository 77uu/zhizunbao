
CREATE TABLE IF NOT EXISTS `wp_wb_spider` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `marker` varchar(64) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB;

-- row split --

CREATE TABLE IF NOT EXISTS `wp_wb_spider_log` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `spider` varchar(64) DEFAULT NULL,
  `visit_date` datetime NOT NULL,
  `code` varchar(32) DEFAULT NULL,
  `visit_ip` varchar(32) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `url_md5` varchar(32) DEFAULT NULL,
  `url_type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spider` (`spider`),
  KEY `visit_date` (`visit_date`),
  KEY `url_md5` (`url_md5`),
  KEY `url_type` (`url_type`)
) ENGINE=InnoDB;

-- row split --

CREATE TABLE IF NOT EXISTS `wp_wb_spider_sum` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ymdh` int(10) UNSIGNED NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `spider` tinyint(3) UNSIGNED NOT NULL,
  `visit_times` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ymdh` (`ymdh`),
  KEY `spider` (`spider`)
) ENGINE=InnoDB;

-- row split --

CREATE TABLE IF NOT EXISTS `wp_wb_spider_visit` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `spider` tinyint(3) UNSIGNED NOT NULL,
  `ymdh` int(10) UNSIGNED NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `visit_times` int(10) UNSIGNED NOT NULL,
  `url_md5` varchar(32) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ymdh` (`ymdh`),
  KEY `spider` (`spider`),
  KEY `url_md5` (`url_md5`)
) ENGINE=InnoDB;




