# Tables dumped 2003-04-24 21:34:06 -0700
# Created by CocoaMySQL (Copyright (c) 2002-2003 Lorenz Textor)
#
# Host: localhost   Database: eene
# ******************************

# Dump of table automessages
# ------------------------------

DROP TABLE IF EXISTS `automessages`;

CREATE TABLE `automessages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `automessage` text NOT NULL,
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `automessages` (`id`,`automessage`,`user_id`,`date`) VALUES ("3","osiaduhfkjsadfsaddf","10","2003-04-20 15:40:04");
INSERT INTO `automessages` (`id`,`automessage`,`user_id`,`date`) VALUES ("2","asdfsdadf","10","2003-04-20 15:39:36");
INSERT INTO `automessages` (`id`,`automessage`,`user_id`,`date`) VALUES ("4","saddfsd","10","2003-04-20 15:40:16");
INSERT INTO `automessages` (`id`,`automessage`,`user_id`,`date`) VALUES ("5","hbfgbgfcb","10","2003-04-20 15:42:27");


# Dump of table event_ids
# ------------------------------

DROP TABLE IF EXISTS `event_ids`;

CREATE TABLE `event_ids` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `descr` varchar(255) NOT NULL default '',
  `short_descr` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `short_descr` (`short_descr`)
) TYPE=MyISAM;

INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("1","New User Signup","NEWUSER");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("2","Message Posted","POST");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("3","Login","LOGIN");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("4","Logout","LOGOUT");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("5","Error","ERROR");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("6","Motto Added","MOTTO");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("7","Automessage Changed","AUTOMESS");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("8","Voting Topic Added","VTOPIC");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("9","Message Deleted","MSG_DEL");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("10","Message Edited","MSG_EDIT");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("11","Password Changed","PWCHANGE");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("12","Tagline Changed","TAGLINE");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("13","Sub Created","NEWSUB");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("14","Bad Password","BADPW");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("15","Failed Signup","BADSIGNUP");
INSERT INTO `event_ids` (`id`,`descr`,`short_descr`) VALUES ("16","Voted","VOTE");


# Dump of table log
# ------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `event_id` tinyint(4) unsigned NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` mediumint(9) unsigned default '0',
  `note` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("2","3","2003-04-12 22:25:59","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("3","3","2003-04-13 00:56:06","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("4","3","2003-04-13 00:57:11","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("5","3","2003-04-13 18:44:53","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("6","3","2003-04-13 18:45:03","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("7","14","2003-04-13 18:45:07","10","dflskhf");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("8","3","2003-04-13 18:45:11","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("9","3","2003-04-13 19:20:16","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("10","6","2003-04-13 19:20:27","10","I am a Nobukazu Takemura cover band.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("11","6","2003-04-13 19:21:29","10","Here is a motto");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("12","6","2003-04-13 19:22:23","10","Here is a motto");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("13","6","2003-04-13 19:22:32","10","mottosville");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("14","6","2003-04-13 19:22:40","10","asddf");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("15","6","2003-04-13 19:22:57","10","A fine day for a motto.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("16","3","2003-04-13 19:23:44","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("17","6","2003-04-13 19:23:57","10","Another Bad Motto");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("18","4","2003-04-13 19:24:00","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("19","3","2003-04-13 19:27:44","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("20","6","2003-04-13 19:27:55","10","So you want to add a motto.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("21","4","2003-04-13 19:35:58","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("22","3","2003-04-13 19:36:02","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("23","3","2003-04-13 19:54:52","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("24","4","2003-04-13 20:06:15","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("25","3","2003-04-13 20:11:26","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("26","3","2003-04-13 21:09:29","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("27","3","2003-04-13 21:11:34","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("28","3","2003-04-13 23:34:03","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("29","6","2003-04-13 23:35:10","11","The glory of this world is transient.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("30","4","2003-04-13 23:35:19","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("31","3","2003-04-13 23:39:52","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("32","6","2003-04-13 23:40:23","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("33","6","2003-04-13 23:40:28","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("34","6","2003-04-13 23:40:30","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("35","6","2003-04-13 23:41:35","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("36","6","2003-04-13 23:41:38","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("37","6","2003-04-13 23:41:40","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("38","6","2003-04-13 23:42:47","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("39","6","2003-04-13 23:43:10","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("40","6","2003-04-13 23:43:12","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("41","6","2003-04-13 23:43:25","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("42","3","2003-04-13 23:52:22","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("43","3","2003-04-14 00:54:04","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("44","3","2003-04-14 21:53:36","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("45","4","2003-04-14 21:59:06","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("46","3","2003-04-14 21:59:14","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("47","4","2003-04-14 22:19:44","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("48","3","2003-04-14 22:19:48","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("49","16","2003-04-14 22:22:27","10","12");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("50","4","2003-04-14 22:24:35","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("51","3","2003-04-14 22:24:40","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("52","4","2003-04-14 22:25:56","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("53","3","2003-04-14 22:26:02","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("54","4","2003-04-14 22:26:49","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("55","3","2003-04-14 22:26:53","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("56","4","2003-04-14 22:27:48","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("57","3","2003-04-14 22:28:09","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("58","4","2003-04-14 22:37:04","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("59","3","2003-04-14 22:37:07","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("60","3","2003-04-14 22:37:34","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("61","4","2003-04-14 22:37:37","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("62","3","2003-04-14 22:37:40","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("63","3","2003-04-14 22:40:27","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("64","3","2003-04-14 22:41:09","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("65","4","2003-04-14 22:41:11","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("66","3","2003-04-14 22:41:14","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("67","4","2003-04-14 22:42:15","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("68","3","2003-04-14 22:42:34","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("69","4","2003-04-14 22:42:51","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("70","3","2003-04-14 22:42:55","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("71","4","2003-04-14 22:43:24","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("72","14","2003-04-14 22:43:32","10","wanye");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("73","4","2003-04-14 22:47:25","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("74","14","2003-04-14 22:47:57","10","waynhe");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("75","3","2003-04-14 22:48:00","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("76","4","2003-04-14 22:48:46","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("77","3","2003-04-14 22:48:50","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("78","4","2003-04-14 22:49:07","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("79","3","2003-04-14 22:49:16","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("80","4","2003-04-14 22:51:14","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("81","3","2003-04-14 22:51:28","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("82","16","2003-04-14 22:51:38","11","12");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("83","4","2003-04-14 22:51:55","11","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("84","3","2003-04-14 23:20:24","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("85","6","2003-04-15 00:11:49","10","sadfsdafkjl");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("86","3","2003-04-15 11:23:03","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("87","1","2003-04-15 15:20:56","12","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("88","3","2003-04-15 15:20:56","12","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("89","1","2003-04-15 22:37:30","13","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("90","3","2003-04-15 22:37:31","13","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("91","6","2003-04-15 22:37:55","13","I\\\\\\\'m cold and clammy, bury me deep.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("92","16","2003-04-15 22:38:08","13","12");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("93","4","2003-04-15 22:38:26","13","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("94","3","2003-04-15 22:42:16","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("95","3","2003-04-19 14:05:52","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("96","6","2003-04-19 14:10:31","10","ANOTHER ONE BITES THE DUST");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("97","3","2003-04-19 14:17:08","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("98","3","2003-04-20 14:36:23","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("99","14","2003-04-20 15:17:09","10","weayne");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("100","14","2003-04-20 15:18:04","10","wqayne");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("101","3","2003-04-20 15:18:08","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("102","4","2003-04-20 19:50:23","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("103","3","2003-04-20 19:50:33","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("104","4","2003-04-20 20:00:50","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("105","3","2003-04-20 20:00:54","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("106","3","2003-04-20 20:01:09","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("107","4","2003-04-20 20:02:13","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("108","3","2003-04-20 20:02:51","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("109","3","2003-04-20 20:04:22","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("110","4","2003-04-20 20:11:17","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("111","3","2003-04-20 20:11:21","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("112","14","2003-04-20 20:11:40","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("113","3","2003-04-20 20:11:44","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("114","3","2003-04-20 20:21:39","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("115","3","2003-04-20 20:21:47","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("116","3","2003-04-20 20:37:07","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("117","4","2003-04-20 20:48:17","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("118","3","2003-04-20 20:48:21","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("119","4","2003-04-20 20:59:20","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("120","3","2003-04-20 20:59:25","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("121","3","2003-04-20 21:28:38","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("122","4","2003-04-20 22:47:18","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("123","3","2003-04-20 22:47:21","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("124","4","2003-04-20 23:29:13","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("125","3","2003-04-20 23:29:17","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("126","3","2003-04-21 01:06:38","13","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("127","3","2003-04-21 01:07:00","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("128","6","2003-04-21 01:07:35","13","eeneBBS. Totally not gay, dude.");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("129","3","2003-04-21 01:11:50","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("130","3","2003-04-21 10:43:43","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("131","3","2003-04-21 11:43:16","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("132","3","2003-04-21 17:36:28","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("133","4","2003-04-21 17:43:10","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("134","14","2003-04-21 17:43:13","10","wyane");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("135","3","2003-04-21 17:43:16","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("136","4","2003-04-21 17:43:37","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("137","3","2003-04-21 17:43:40","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("138","4","2003-04-21 17:44:07","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("139","3","2003-04-21 17:44:12","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("140","4","2003-04-21 17:45:08","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("141","3","2003-04-21 17:45:11","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("142","3","2003-04-22 23:37:45","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("143","4","2003-04-23 01:24:35","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("144","3","2003-04-23 01:24:39","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("145","3","2003-04-23 01:36:28","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("146","4","2003-04-23 01:42:17","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("147","3","2003-04-23 01:42:23","10","");
INSERT INTO `log` (`id`,`event_id`,`date`,`user_id`,`note`) VALUES ("148","3","2003-04-24 21:25:32","10","");


# Dump of table messages
# ------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sub_id` smallint(6) unsigned NOT NULL default '0',
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `message` mediumtext NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `message` (`message`)
) TYPE=MyISAM;

INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("1","1","10","This is a test.","2003-04-20 22:35:37");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("2","1","10","hello fag","2003-04-21 00:17:39");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("3","2","10","a message in this sub","2003-04-21 00:26:07");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("4","1","10","this is a test of the <b>html</b> <e>capabilities</em> of the msging system.","2003-04-21 00:41:21");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("5","1","10","<e>no italics?</em> <i>no italics</i>","2003-04-21 00:41:49");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("7","1","10","ok i should be able to <a href=\"http://www.bigtits.com\">make a link</a>","2003-04-21 01:01:44");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("8","1","10","i should be able to <img src=\"http://www.chrishiller.net/img/head.gif\">","2003-04-21 01:02:37");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("9","1","10","THIS ONE IS FOR TEH RECORD","2003-04-21 01:11:03");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("10","1","13","Does anybody know the numbers to any underground boards? I\'ve got some filez to trade and I\'d really like to get Photoshop 3.0. I\'ve used it at school and it\'s really smooth.\r\n\r\nAlso, what do you guys know about pHREAKING and VMS systems?\r\n\r\nthx,\r\nDungeon Master.","2003-04-21 01:12:07");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("11","1","10","u r leet","2003-04-21 01:13:03");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("12","1","10","test another message ehehehe","2003-04-21 01:15:29");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("13","3","10","this should be mad anonymous","2003-04-21 01:22:17");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("14","3","10","asdfsadf","2003-04-21 17:45:44");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("15","5","10","posting in this here sub","2003-04-21 17:46:22");
INSERT INTO `messages` (`id`,`sub_id`,`user_id`,`message`,`date`) VALUES ("16","5","10","asdf","2003-04-21 17:47:38");


# Dump of table mottos
# ------------------------------

DROP TABLE IF EXISTS `mottos`;

CREATE TABLE `mottos` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `motto` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `motto` (`motto`)
) TYPE=MyISAM;

INSERT INTO `mottos` (`id`,`motto`) VALUES ("1","All you need is pork.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("2","The sea is a lovely lady.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("3","A fine day for a motto.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("4","Another Bad Motto");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("5","So you want to add a motto.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("6","The glory of this world is transient.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("14","sadfsdafkjl");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("15","I\\\\\\\'m cold and clammy, bury me deep.");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("16","ANOTHER ONE BITES THE DUST");
INSERT INTO `mottos` (`id`,`motto`) VALUES ("17","eeneBBS. Totally not gay, dude.");


# Dump of table newscan_skip
# ------------------------------

DROP TABLE IF EXISTS `newscan_skip`;

CREATE TABLE `newscan_skip` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `sub_id` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;



# Dump of table pointers
# ------------------------------

DROP TABLE IF EXISTS `pointers`;

CREATE TABLE `pointers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` mediumint(9) NOT NULL default '0',
  `sub_id` smallint(6) unsigned NOT NULL default '0',
  `message_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("128","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("127","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("126","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("125","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("124","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("123","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("122","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("121","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("120","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("119","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("118","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("117","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("116","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("115","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("114","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("113","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("112","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("111","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("110","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("109","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("108","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("107","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("106","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("105","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("104","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("103","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("102","13","5","0");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("101","13","3","0");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("100","13","2","3");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("99","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("98","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("97","13","1","8");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("96","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("95","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("94","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("93","10","3","14");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("92","10","2","3");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("91","10","1","12");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("90","10","5","16");
INSERT INTO `pointers` (`id`,`user_id`,`sub_id`,`message_id`) VALUES ("89","10","3","14");


# Dump of table preferences
# ------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `descr` varchar(255) NOT NULL default '',
  `short_descr` varchar(16) NOT NULL default '',
  `default` int(11) unsigned NOT NULL default '0',
  `type` enum('bit','value','enum') NOT NULL default 'bit',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `short_descr` (`short_descr`)
) TYPE=MyISAM;

INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("1","Display Automessage?","DISP_AUTOMESS","0","bit");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("2","Display Last Users?","DISP_LASTUSERS","0","bit");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("3","Theme","THEME","0","enum");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("4","Newscan Mode","NEWSCAN_MODE","0","enum");


# Dump of table preferences_options
# ------------------------------

DROP TABLE IF EXISTS `preferences_options`;

CREATE TABLE `preferences_options` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `pref_id` int(9) unsigned NOT NULL default '0',
  `opt` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("6","3","Old School Theme");
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("5","3","Default Theme");
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("7","4","All Configured Subs");
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("8","4","Only Configured Subs w/New Messages");


# Dump of table security_levels
# ------------------------------

DROP TABLE IF EXISTS `security_levels`;

CREATE TABLE `security_levels` (
  `sl` tinyint(4) unsigned NOT NULL default '0',
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`sl`)
) TYPE=MyISAM;

INSERT INTO `security_levels` (`sl`,`descr`) VALUES ("50","Normal User");
INSERT INTO `security_levels` (`sl`,`descr`) VALUES ("255","Sysop");


# Dump of table splashes
# ------------------------------

DROP TABLE IF EXISTS `splashes`;

CREATE TABLE `splashes` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `url` (`url`)
) TYPE=MyISAM;



# Dump of table stats
# ------------------------------

DROP TABLE IF EXISTS `stats`;

CREATE TABLE `stats` (
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `posts` int(11) unsigned NOT NULL default '0',
  `logins` int(11) unsigned NOT NULL default '0',
  `automessages` int(11) unsigned NOT NULL default '0',
  `mottos` int(11) unsigned NOT NULL default '0',
  `subs` int(11) unsigned NOT NULL default '0',
  `first_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `read` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM;

INSERT INTO `stats` (`user_id`,`posts`,`logins`,`automessages`,`mottos`,`subs`,`first_login`,`last_login`,`read`) VALUES ("10","7","40","0","2","0","2003-04-12 21:38:07","2003-04-24 21:25:32","0");
INSERT INTO `stats` (`user_id`,`posts`,`logins`,`automessages`,`mottos`,`subs`,`first_login`,`last_login`,`read`) VALUES ("11","0","2","0","0","0","2003-04-13 00:57:11","2003-04-14 22:51:28","0");
INSERT INTO `stats` (`user_id`,`posts`,`logins`,`automessages`,`mottos`,`subs`,`first_login`,`last_login`,`read`) VALUES ("12","0","1","0","0","0","2003-04-15 15:20:56","2003-04-15 15:20:56","0");
INSERT INTO `stats` (`user_id`,`posts`,`logins`,`automessages`,`mottos`,`subs`,`first_login`,`last_login`,`read`) VALUES ("13","1","2","0","2","0","2003-04-15 22:37:30","2003-04-21 01:06:38","0");


# Dump of table subs
# ------------------------------

DROP TABLE IF EXISTS `subs`;

CREATE TABLE `subs` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `anonymous` enum('Y','N') default NULL,
  `created_by_user_id` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `anonymous` (`anonymous`)
) TYPE=MyISAM;

INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("1","Press P for Porn","N","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("2","Another Sub","N","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("3","Anonymous Sub","Y","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("5","Longer Than 16 Characters","N","10");


# Dump of table taglines
# ------------------------------

DROP TABLE IF EXISTS `taglines`;

CREATE TABLE `taglines` (
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `tagline` varchar(255) NOT NULL default '',
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `tagline` (`tagline`)
) TYPE=MyISAM;



# Dump of table user_preferences
# ------------------------------

DROP TABLE IF EXISTS `user_preferences`;

CREATE TABLE `user_preferences` (
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `id` int(11) unsigned NOT NULL auto_increment,
  `pref_id` mediumint(9) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("10","24","4","All Configured Subs");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("13","23","3","Default Theme");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("13","22","2","Y");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("13","21","1","Y");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("10","27","3","Old School Theme");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("10","26","2","Y");
INSERT INTO `user_preferences` (`user_id`,`id`,`pref_id`,`value`) VALUES ("10","25","1","Y");


# Dump of table users
# ------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `alias` varchar(32) NOT NULL default '',
  `password` varchar(32) default NULL,
  `location` varchar(128) default NULL,
  `email` varchar(128) default NULL,
  `comment` varchar(255) default NULL,
  `avatar` varchar(255) default NULL,
  `sl` tinyint(4) unsigned NOT NULL default '0',
  `site` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `password` (`password`),
  KEY `avatar` (`avatar`)
) TYPE=MyISAM;

INSERT INTO `users` (`id`,`alias`,`password`,`location`,`email`,`comment`,`avatar`,`sl`,`site`) VALUES ("10","chiller","2e2bc00d71b5d0d2b38655690f1fabce","bufasdfhk","jsdjhfkjfdh@kjshdf.net",NULL,"","255","http://www.alkdjsflsk.net");
INSERT INTO `users` (`id`,`alias`,`password`,`location`,`email`,`comment`,`avatar`,`sl`,`site`) VALUES ("11","antimony51","45a679e07e0594208fcc59e02875a33a","","",NULL,"","50","");
INSERT INTO `users` (`id`,`alias`,`password`,`location`,`email`,`comment`,`avatar`,`sl`,`site`) VALUES ("12","basehead","55556ae8745782548db206259d87c961","","",NULL,"","50","");
INSERT INTO `users` (`id`,`alias`,`password`,`location`,`email`,`comment`,`avatar`,`sl`,`site`) VALUES ("13","csmith7","b766813901e605cc8d2f251814ff5c03","Eu-Gene","csmith700@attbi.com",NULL,"","50","http://www.nethack.org");


# Dump of table votes
# ------------------------------

DROP TABLE IF EXISTS `votes`;

CREATE TABLE `votes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `topic_id` smallint(6) unsigned NOT NULL default '0',
  `option_id` mediumint(9) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `votes` (`id`,`user_id`,`topic_id`,`option_id`) VALUES ("7","10","12","8");
INSERT INTO `votes` (`id`,`user_id`,`topic_id`,`option_id`) VALUES ("8","11","12","8");
INSERT INTO `votes` (`id`,`user_id`,`topic_id`,`option_id`) VALUES ("9","13","12","7");


# Dump of table voting_options
# ------------------------------

DROP TABLE IF EXISTS `voting_options`;

CREATE TABLE `voting_options` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `topic_id` smallint(6) unsigned NOT NULL default '0',
  `opt` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `voting_options` (`id`,`topic_id`,`opt`) VALUES ("8","12","maybe");
INSERT INTO `voting_options` (`id`,`topic_id`,`opt`) VALUES ("7","12","no");
INSERT INTO `voting_options` (`id`,`topic_id`,`opt`) VALUES ("6","12","yes");


# Dump of table voting_topics
# ------------------------------

DROP TABLE IF EXISTS `voting_topics`;

CREATE TABLE `voting_topics` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

INSERT INTO `voting_topics` (`id`,`name`,`date`) VALUES ("12","are you stupid","2003-04-13 23:56:34");


