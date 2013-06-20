CREATE TABLE `tl_distributors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `postcode` char(10),
  `city` varchar(255) NOT NULL default '',
  `country` varchar(32) NOT NULL default '',
  `description` TEXT,
  `lat` FLOAT NOT NULL default 0,
  `lng` FLOAT NOT NULL default 0,
  `published` char(1) NOT NULL default '',
  `created` int(10) unsigned NOT NULL default 0,
  `tstamp` int(10) unsigned NOT NULL default 0,
  PRIMARY KEY  (`id`)
) ENGINE = MYISAM ;


CREATE TABLE `tl_distributors_searchlog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `keyword` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
