-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 01 月 12 日 14:14
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `myshop5`
--

-- --------------------------------------------------------

--
-- 表的结构 `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pos` tinyint(4) NOT NULL,
  `img` varchar(100) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `ads`
--

INSERT INTO `ads` (`id`, `pos`, `img`, `info`) VALUES
(17, 0, '54b3c63e62698.png', '这是广告1！！！！'),
(18, 0, '54b3c64e4cb60.png', '这是广告2！！！！！！！！');

-- --------------------------------------------------------

--
-- 表的结构 `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `brand`
--

INSERT INTO `brand` (`id`, `name`, `class_id`) VALUES
(15, '计算机类书', 10),
(16, '数学类书', 10),
(17, '联想', 11),
(18, '华为', 11),
(19, '森麦', 12),
(20, '品胜', 12),
(21, '双飞燕', 14),
(22, '罗技', 13),
(23, '宏碁', 10),
(24, '华硕', 14);

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(10, '书籍'),
(11, '手机'),
(12, '耳机'),
(13, '键盘'),
(14, '电脑');

-- --------------------------------------------------------

--
-- 表的结构 `commit`
--

CREATE TABLE IF NOT EXISTS `commit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `info` text NOT NULL,
  `time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `commit`
--

INSERT INTO `commit` (`id`, `info`, `time`, `user_id`, `shop_id`) VALUES
(1, '不过度但是大多数都是大飒飒', 1421071800, 36, 64);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `num` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `relation_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `code`, `user_id`, `shop_id`, `price`, `num`, `time`, `relation_id`, `status_id`) VALUES
(1, '1421071774902024916', 36, 64, 6, 2, 1421071774, 2, 2),
(2, '1421071774902024916', 36, 61, 11, 4, 1421071774, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `praise`
--

CREATE TABLE IF NOT EXISTS `praise` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `shop_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `time` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- 转存表中的数据 `praise`
--

INSERT INTO `praise` (`id`, `shop_id`, `user_id`, `time`) VALUES
(59, 60, 35, 1421068223),
(60, 0, 35, 1421068227),
(61, 61, 35, 1421068301),
(62, 60, 35, 1421071352),
(63, 60, 35, 1421071356),
(64, 60, 35, 1421071361),
(65, 61, 35, 1421071380),
(66, 63, 35, 1421071516),
(67, 62, 35, 1421071519),
(68, 64, 35, 1421071524),
(69, 60, 35, 1421071538),
(70, 61, 35, 1421071541);

-- --------------------------------------------------------

--
-- 表的结构 `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `addr` varchar(200) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `relation`
--

INSERT INTO `relation` (`id`, `name`, `addr`, `tel`, `email`, `user_id`) VALUES
(1, '小张', '地球', '18335124757', '123321@qq.com', 36),
(2, '小乔', '火星', '18335124757', '12345@qq.com', 36);

-- --------------------------------------------------------

--
-- 表的结构 `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `shelf` tinyint(4) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `user_in_id` int(15) NOT NULL,
  `info` text NOT NULL,
  `time` int(25) NOT NULL,
  `totpraise` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- 转存表中的数据 `shop`
--

INSERT INTO `shop` (`id`, `name`, `img`, `price`, `stock`, `shelf`, `brand_id`, `user_in_id`, `info`, `time`, `totpraise`) VALUES
(60, '张恩桥1号', '54b3c79f8b29a.png', 23.3, 9, 1, 15, 35, '这是张恩桥添加的计算机类的书籍商品！', 1421068191, 5),
(61, '张恩桥2号', '54b3c807e6341.png', 11, 6, 1, 15, 35, '这是张恩桥添加的计算机书2号商品！', 1421068296, 3),
(62, '张恩桥3号', '54b3d454233f7.png', 2, 5, 1, 16, 35, '张恩桥上传的数学类书3号', 1421071444, 1),
(63, '张恩桥4号', '54b3d46e4ca11.png', 3, 6, 1, 16, 35, '张恩桥上传的数学类书4号', 1421071470, 1),
(64, '张恩桥5号', '54b3d493dce22.png', 6, 4, 1, 23, 35, '张恩桥上传的数学类书5号', 1421071507, 1);

-- --------------------------------------------------------

--
-- 表的结构 `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, '未发货'),
(2, '已发货'),
(3, '已付款');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `flag` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `time`, `tel`, `email`, `flag`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1416484717, '', '', 0),
(35, 'zhangenqiao', 'fb26e6e349b1628abf2e0626b624c1f2', 1421067966, '18335124757', '641741453@qq.com', 1),
(36, 'tianwei', '88c63c7ccf3935756d93db486af422cd', 1421071690, '18335162656', '648360274@qq.com', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
