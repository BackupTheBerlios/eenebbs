# Tables dumped 2003-04-28 14:46:20 -0700
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



# Dump of table mottos
# ------------------------------

DROP TABLE IF EXISTS `mottos`;

CREATE TABLE `mottos` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `motto` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `motto` (`motto`)
) TYPE=MyISAM;



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



# Dump of table preferences
# ------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `descr` varchar(255) NOT NULL default '',
  `short_descr` varchar(16) NOT NULL default '',
  `default` int(11) unsigned default NULL,
  `type` enum('bit','text','enum') NOT NULL default 'bit',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `short_descr` (`short_descr`)
) TYPE=MyISAM;

INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("1","Display Automessage","DISP_AUTOMESS","1","bit");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("2","Display Last Users?","DISP_LASTUSERS","1","bit");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("3","Theme","THEME","5","enum");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("4","Newscan Mode","NEWSCAN_MODE","7","enum");
INSERT INTO `preferences` (`id`,`descr`,`short_descr`,`default`,`type`) VALUES ("5","Tagline Display Method","TAGLINES","10","enum");


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
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("12","5","Randomly");
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("10","5","Loop Through Them");
INSERT INTO `preferences_options` (`id`,`pref_id`,`opt`) VALUES ("13","5","Do Not Display Taglines");


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
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM;



# Dump of table subs
# ------------------------------

DROP TABLE IF EXISTS `subs`;

CREATE TABLE `subs` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `anonymous` enum('Y','N') NOT NULL default 'N',
  `created_by_user_id` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `anonymous` (`anonymous`)
) TYPE=MyISAM;

INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("1","Press P for Porn","N","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("2","Another Sub","N","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("3","Anonymous Sub","Y","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("5","Longer Than 16 Characters","N","10");
INSERT INTO `subs` (`id`,`name`,`anonymous`,`created_by_user_id`) VALUES ("6","the sub full of hate","N","21");


# Dump of table taglines
# ------------------------------

DROP TABLE IF EXISTS `taglines`;

CREATE TABLE `taglines` (
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `tagline` text NOT NULL,
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) TYPE=MyISAM;



# Dump of table user_preferences
# ------------------------------

DROP TABLE IF EXISTS `user_preferences`;

CREATE TABLE `user_preferences` (
  `user_id` mediumint(9) unsigned NOT NULL default '0',
  `id` int(11) unsigned NOT NULL auto_increment,
  `pref_id` mediumint(9) unsigned NOT NULL default '0',
  `value` mediumint(9) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;



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
  `sl` tinyint(4) unsigned NOT NULL default '0',
  `site` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `password` (`password`)
) TYPE=MyISAM;



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


