/*
Navicat MySQL Data Transfer

Source Server         : Homestead
Source Server Version : 50721
Source Host           : 192.168.10.10:3306
Source Database       : blowfish

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-06-23 02:22:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` VALUES ('2', 'members', 'General User');

-- ----------------------------
-- Table structure for login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of login_attempts
-- ----------------------------

-- ----------------------------
-- Table structure for user_login
-- ----------------------------
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `encrypt_dt` datetime DEFAULT NULL,
  `encryption_time` varchar(20) DEFAULT NULL,
  `encrypted_text` varchar(255) DEFAULT NULL,
  `random_number` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `verified_date` datetime DEFAULT NULL,
  `received_time` varchar(20) NOT NULL,
  `verified_time` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_login
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', null, null, null, '1268889823', '1526962417', '1', 'Admin', 'istrator', 'be8469d3c073fe78', '+639092720535');
INSERT INTO `users` VALUES ('4', '::1', 'togz', '$2y$08$OW/FZ/feYp6uU3quVd/92eoJ6yFcOg4sCzjD.WiJHqEKJ2QwotJjK', null, 'togz@gmail.com', null, null, null, null, '1523238786', '1523340822', '1', 'Togz', 'Ngiaw', '60457dcff809fcdd', '+639234150604');
INSERT INTO `users` VALUES ('5', '::1', 'Rudy', '$2y$08$U3DhmAc206Pv9KSsxsP6xOL7npIjgyxmqHRk3xHd.lTk1y7azNBaG', null, 'rudy@gmail.com', null, null, null, null, '1523350474', '1523350495', '1', 'Rudy', 'Comawas', 'jdgfhghsdjksdhf', '+639661751101');
INSERT INTO `users` VALUES ('8', '::1', 'Lalaine', '$2y$08$2RyWqDKnYsycCH5McLcFpOUiS4kPurucs5FcokkwrgnKJcB5.KXO.', null, 'lalainereyes1120@gmail.com', null, null, null, null, '1523718967', '1525660232', '1', 'Lalaine', 'Reyes', 'ec9c2a4cefcadc06', '+639198763601');
INSERT INTO `users` VALUES ('9', '::1', 'Audric', '$2y$08$sSC71K8MdZlXR0GqJHov1e6uf7n9vk9aUOxVq/haDjUt7rc24ve7S', null, 'audric@gmail.com', null, null, null, null, '1523884516', '1523884736', '1', 'Audric', 'Reyes', '2954c9c2b807a348', '+639982549305');
INSERT INTO `users` VALUES ('11', '::1', 'Lourdes', '$2y$08$ZPAaE0M5QRXNYpOeNuEsKu5ivjtQQEKc68G8gJKMKs7a4na8a.FY2', null, 'lourdes@gmail.com', null, null, null, null, '1525658356', '1527581141', '1', 'Lourdes', 'Jardinico', 'b7021e4194d3bfc7', '+639489907711');
INSERT INTO `users` VALUES ('12', '::1', 'Rey', '$2y$08$F.HNZP/xTHmrj6u7pPQBH.m2DeUNsd/d43z.I0WQskcNgterIhJnK', null, 'rey@gmail.com', null, null, null, null, '1525841333', '1525842702', '1', 'Rey', 'De Leon', '45b63b203c4fade0', '+639995461205');
INSERT INTO `users` VALUES ('13', '::1', 'Sean', '$2y$08$zMvu4EXso63SQByou5fA7uMeAPtc4OTdLEf5NRiJniBeIXdl6boYW', null, 'sean@gmail.com', null, null, null, null, '1526021492', '1526022705', '1', 'Sean', 'Narit', '1f63b4156d523c7d', '+639074599585');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('1', '1', '1');
INSERT INTO `users_groups` VALUES ('2', '1', '2');
INSERT INTO `users_groups` VALUES ('5', '4', '1');
INSERT INTO `users_groups` VALUES ('6', '5', '1');
INSERT INTO `users_groups` VALUES ('9', '8', '1');
INSERT INTO `users_groups` VALUES ('10', '9', '1');
INSERT INTO `users_groups` VALUES ('12', '11', '1');
INSERT INTO `users_groups` VALUES ('13', '12', '1');
INSERT INTO `users_groups` VALUES ('14', '13', '1');
