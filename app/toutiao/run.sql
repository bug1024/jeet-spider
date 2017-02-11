
CREATE TABLE `toutiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT '',
  `href` varchar(500) DEFAULT '',
  `source` varchar(500) DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `blog_date` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
