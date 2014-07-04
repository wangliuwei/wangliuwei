-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-03 19:40:07
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yj`
--

-- --------------------------------------------------------

--
-- 表的结构 `tb_category`
--

CREATE TABLE IF NOT EXISTS `tb_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gid` int(4) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tb_category`
--

INSERT INTO `tb_category` (`id`, `title`, `gid`, `type`, `disable`) VALUES
(1, 'film', 2, 2, 0),
(2, 'author', 1, 1, 0),
(3, 'stylist', 2, 1, 0),
(4, 'movie', 3, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tb_content`
--

CREATE TABLE IF NOT EXISTS `tb_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `path` text COLLATE utf8_unicode_ci,
  `url` text COLLATE utf8_unicode_ci,
  `jumpUrl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categoryID` int(11) NOT NULL,
  `position` tinyint(1) NOT NULL,
  `priority` int(4) NOT NULL,
  `showIndex` tinyint(1) NOT NULL,
  `showAuthor` int(1) NOT NULL,
  `showCategory` int(1) NOT NULL,
  `showImage` text COLLATE utf8_unicode_ci NOT NULL,
  `disable` tinyint(1) NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tb_content`
--

INSERT INTO `tb_content` (`id`, `title`, `subTitle`, `type`, `path`, `url`, `jumpUrl`, `categoryID`, `position`, `priority`, `showIndex`, `showAuthor`, `showCategory`, `showImage`, `disable`, `createDate`, `updateDate`) VALUES
(1, 'test', 'test', 1, 'files//imgpath_1404050373_7051.jpg,files//imgpath_1404050377_4557.jpg,files//imgpath_1404050381_6216.jpg,files//imgpath_1404050384_8791.jpg,files//imgpath_1404050388_6918.jpg,files//imgpath_1404050393_3179.jpg', '', '', 1, 1, 1, 1, 0, 0, 'files/img_1404221685_8643.jpg', 0, '2014-06-29 22:07:34', '2014-07-01 21:37:55'),
(2, 'aaa', 'aaa', 1, 'files/img_1404401721_4201.jpg,files/img_1404401724_8244.jpg', NULL, '', 1, 0, 1, 1, 1, 1, 'files/img_1404402245_8514.jpg', 0, '2014-07-03 23:36:30', '2014-07-03 23:44:07'),
(3, 'vvv', 'vvv', 1, 'files/img_1404401869_4689.jpg', NULL, '', 4, 0, 1, 1, 1, 1, 'files/img_1404401998_4261.jpg', 0, '2014-07-03 23:37:51', '2014-07-03 23:40:01'),
(4, 'ccc', 'ccc', 1, 'files/img_1404402670_7013.jpg', NULL, '', 4, 0, 1, 1, 1, 1, 'files/img_1404402662_6533.jpg', 0, '2014-07-03 23:51:12', '2014-07-03 23:51:12');

-- --------------------------------------------------------

--
-- 表的结构 `tb_news`
--

CREATE TABLE IF NOT EXISTS `tb_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1-新闻,2-联系我们',
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tb_news`
--

INSERT INTO `tb_news` (`id`, `title`, `content`, `image`, `type`, `createDate`, `updateDate`) VALUES
(1, '万庆良被宣布受调查前1小时临时取消行程', '十八大后广东首只“大老虎”、广州市委书记万庆良应声落马。\r\n中央纪委监察部网站在6月27日下午3时55分发布重磅消息：广东省委常委、广州市委书记万庆良涉嫌严重违纪违法，目前正接受组织调查。\r\n仅仅35个字，却足以给广东官场带来一场强震。万庆良是十八大之后，广东首位落马的省部级官员。 ', 'files/_1403938957.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '', '<p>\r\n	1111</p>\r\n', '', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `createDate`, `updateDate`) VALUES
(1, 'root', 'e10adc3949ba59abbe56e057f20f883e', '2014-06-25 00:00:00', '2014-06-25 00:00:00'),
(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
