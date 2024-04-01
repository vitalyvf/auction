DROP TABLE IF EXISTS `vf_setting`;
CREATE TABLE `vf_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `setting_type` varchar(16) NOT NULL default 'input',
  `variants` varchar(255) NOT NULL default '',
  PRIMARY KEY (`setting_id`)
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `vf_user`;
CREATE TABLE `vf_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` enum('C', 'A') NOT NULL default 'C',
  `login` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `firstname` varchar(32) NOT NULL default '',
  `lastname` varchar(32) NOT NULL default '',
  `status` enum('A', 'D') NOT NULL default 'A',
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `vf_user` (`user_id`, `user_type`, `login`, `password`, `firstname`, `lastname`, `status`) VALUES
(1, 'A', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Admin', 'A');

DROP TABLE IF EXISTS `vf_lot`;
CREATE TABLE `vf_lot` (
  `lot_id` int(11) NOT NULL AUTO_INCREMENT,
  `lot_time` int(11) NOT NULL,
  `lot_name` varchar(255) NOT NULL default '',
  `lot_descr` text NOT NULL,
  `status` enum('N', 'S', 'F', 'P', 'C') NOT NULL default 'N',
  `min_price` float(10,2) NOT NULL default '0.00',
  `max_price` float(10,2) NOT NULL default '0.00',
  `lot_step` int(11) NOT NULL defailt '0',
  `winner_bid` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `vf_image`;
CREATE TABLE `vf_image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `object` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL default '',
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `vf_bid`;
CREATE TABLE `vf_bid` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `bid_time` int(11) NOT NULL,
  `price` float(10,2) NOT NULL default '0.00',
  PRIMARY KEY (`bid_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `vf_payment`;
CREATE TABLE `vf_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `payment_time` int(11) NOT NULL,
  `price` float(10,2) NOT NULL default '0.00',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
