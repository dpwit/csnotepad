-- --------------------------------------------------------

-- 
-- Table structure for table `news`
-- 

CREATE TABLE `news` (
  `uid` int(11) NOT NULL auto_increment,
  `title` tinytext NOT NULL,
  `shorttext` text NOT NULL,
  `content` text NOT NULL,
  `image` tinytext NOT NULL,
  `status` int(11) NOT NULL default '0',
  `date` tinytext,
  `keywords` text NOT NULL,
  PRIMARY KEY  (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=50 ;
