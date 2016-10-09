-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-09-08 15:31:36
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `airex`
--

-- --------------------------------------------------------

--
-- 表的结构 `airex_append`
--

CREATE TABLE IF NOT EXISTS `airex_append` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL,
  `append_count` enum('1','2','3') NOT NULL,
  `append_1` text NOT NULL,
  `append_1_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `append_2` text NOT NULL,
  `append_2_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `append_3` text NOT NULL,
  `append_3_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `airex_attention`
--

CREATE TABLE IF NOT EXISTS `airex_attention` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `atten_uid` int(10) unsigned NOT NULL COMMENT '关注用户 id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `airex_attention`
--

INSERT INTO `airex_attention` (`id`, `uid`, `atten_uid`) VALUES
(35, 5, 8),
(37, 5, 7),
(38, 7, 8),
(40, 10, 7),
(41, 17, 15);

-- --------------------------------------------------------

--
-- 表的结构 `airex_category`
--

CREATE TABLE IF NOT EXISTS `airex_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `airex_category`
--

INSERT INTO `airex_category` (`id`, `cat_name`) VALUES
(1, '技术'),
(2, '创意'),
(3, '好玩'),
(4, '工作'),
(5, '问答'),
(6, '系统');

-- --------------------------------------------------------

--
-- 表的结构 `airex_col_node`
--

CREATE TABLE IF NOT EXISTS `airex_col_node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '用户 id',
  `nid` int(10) unsigned NOT NULL COMMENT '节点id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `airex_col_topic`
--

CREATE TABLE IF NOT EXISTS `airex_col_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL COMMENT '话题 id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `airex_col_topic`
--

INSERT INTO `airex_col_topic` (`id`, `uid`, `tid`) VALUES
(1, 5, 5),
(2, 7, 60),
(3, 17, 76);

-- --------------------------------------------------------

--
-- 表的结构 `airex_comment`
--

CREATE TABLE IF NOT EXISTS `airex_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `publish_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('评论','回复') NOT NULL DEFAULT '评论',
  PRIMARY KEY (`id`),
  KEY `u_id` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `airex_comment`
--

INSERT INTO `airex_comment` (`id`, `tid`, `uid`, `content`, `publish_time`, `type`) VALUES
(1, 13, 7, '啊', '2016-06-11 15:06:57', '评论'),
(2, 13, 7, '123', '2016-06-11 15:06:39', '评论'),
(3, 19, 7, '123', '2016-06-11 15:06:42', '评论'),
(4, 30, 7, '测试', '2016-06-13 14:06:29', '评论'),
(5, 30, 7, '测试。', '2016-06-15 13:06:45', '评论'),
(6, 31, 7, 'aaaa啊', '2016-06-15 14:06:41', '评论'),
(7, 30, 7, '我继续来测试！', '2016-06-16 15:06:22', '评论'),
(8, 32, 7, '1', '2016-06-16 16:06:53', '评论'),
(9, 32, 5, '啊', '2016-06-22 11:06:53', '评论'),
(10, 32, 5, '123', '2016-06-22 11:26:54', '评论'),
(11, 32, 5, '234', '2016-06-22 11:31:41', '评论'),
(12, 32, 5, '1', '2016-06-22 11:32:16', '评论'),
(13, 54, 5, '测试', '2016-06-22 12:43:58', '评论'),
(14, 54, 5, '2222', '2016-06-22 12:44:03', '评论'),
(15, 54, 5, '33', '2016-06-22 12:44:08', '评论'),
(16, 54, 7, '测试', '2016-06-22 12:44:30', '评论'),
(17, 54, 7, 'test', '2016-06-26 12:35:28', '评论'),
(18, 30, 5, '测试', '2016-06-26 13:48:33', '评论'),
(19, 30, 5, '测试2', '2016-06-26 13:50:56', '评论'),
(20, 30, 5, '测试3', '2016-06-26 13:51:04', '评论'),
(21, 53, 7, '没有回复', '2016-06-27 10:24:19', '评论'),
(22, 54, 10, '@<a href="/index.php/Home/User/info/member/patrick95.html" title="">patrick95</a>: 234234', '2016-07-03 14:01:36', '回复'),
(23, 54, 10, '@<a href="/index.php/Home/User/info/member/Teemo.html" title="">Teemo</a>: 234234324', '2016-07-03 14:01:50', '回复'),
(24, 54, 10, '@<a href="/index.php/Home/User/info/member/Teemo.html" title="">Teemo</a>: 789', '2016-07-03 14:02:37', '回复'),
(25, 54, 10, '<a href="/index.php/Home/User/info/member/Teemo.html" title="">@Teemo</a>: 123123', '2016-07-03 14:03:47', '回复'),
(26, 54, 10, '415646', '2016-07-03 15:33:24', '评论'),
(27, 54, 10, '<a href="/index.php/Home/User/info/member/patrick95.html" title="">@patrick95</a>: qw3213', '2016-07-03 15:33:54', '回复'),
(28, 55, 10, '231', '2016-07-03 16:14:55', '评论'),
(29, 54, 10, '<a href="/index.php/Home/User/info/member/Teemo.html" title="">@Teemo</a>: 456456', '2016-07-04 05:09:17', '回复'),
(30, 30, 7, '2134', '2016-07-04 06:44:37', '评论'),
(31, 54, 7, '123', '2016-07-04 07:18:40', '评论'),
(32, 30, 7, '123123', '2016-07-04 07:18:50', '评论'),
(33, 30, 7, '435345', '2016-07-04 07:22:35', '评论'),
(34, 54, 7, '123', '2016-07-04 07:30:39', '评论'),
(35, 54, 7, '阿斯达', '2016-07-04 07:41:47', '评论'),
(36, 60, 7, '撒打算的', '2016-07-04 07:41:59', '评论'),
(37, 56, 7, '123213', '2016-07-04 07:42:37', '评论'),
(38, 56, 7, '123123123', '2016-07-04 07:46:09', '评论'),
(39, 68, 7, '123', '2016-07-04 07:53:01', '评论'),
(40, 67, 7, '123', '2016-07-04 07:53:06', '评论'),
(41, 60, 7, '567', '2016-07-04 07:54:25', '评论'),
(42, 58, 7, '54465', '2016-07-04 09:05:10', '评论'),
(43, 72, 17, '啊', '2016-07-09 16:55:23', '评论'),
(44, 76, 7, '8k-12k浮动吧应该', '2016-07-09 17:05:07', '评论'),
(45, 76, 10, '我在某三线城市，差不多6k-8k', '2016-07-09 17:05:54', '评论'),
(46, 76, 17, '<a href="/index.php/Home/User/info/member/Teemo.html" title="">@Teemo</a>: 应该差不多。', '2016-07-09 17:07:15', '回复');

-- --------------------------------------------------------

--
-- 表的结构 `airex_node`
--

CREATE TABLE IF NOT EXISTS `airex_node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `node_name` varchar(20) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `logo_path` varchar(255) NOT NULL DEFAULT '',
  `topic_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `p_id` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `airex_node`
--

INSERT INTO `airex_node` (`id`, `pid`, `node_name`, `hits`, `desc`, `logo_path`, `topic_num`) VALUES
(1, 1, '程序员', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 40),
(2, 1, 'Python', 23, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 24),
(3, 1, 'iDev', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 43),
(4, 1, 'Android', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 44),
(5, 1, '云计算', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(6, 1, '宽带症候群', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 36),
(7, 2, '分享创造', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(8, 2, '设计', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 43),
(9, 2, '奇思妙想', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 4),
(10, 2, '心得', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 57),
(11, 3, '分享发现', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 1),
(12, 3, '电子游戏', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(13, 3, '电影', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(14, 3, '剧集', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 1),
(15, 3, '音乐', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(16, 3, '旅游', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(17, 3, '午夜俱乐部', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(18, 4, '二手交易', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(19, 4, '物物交换', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(20, 4, '免费赠送', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 1),
(21, 4, '域名', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(22, 4, '团购', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(23, 4, '安全提示', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(24, 5, '未解决', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(25, 5, '已解决', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(26, 6, '外包', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(27, 6, '酷工作', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(28, 6, '求职', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(29, 6, '测试', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0),
(30, 6, '测试', 0, '这里讨论各种 Python 语言编程话题，也包括 Django，Tornado 等框架的讨论。这里是一个能够帮助你解决实际问题的地方。', 'home/img/node/python.png', 0);

-- --------------------------------------------------------

--
-- 表的结构 `airex_reply`
--

CREATE TABLE IF NOT EXISTS `airex_reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '评论 id',
  `to_uid` int(11) unsigned NOT NULL COMMENT '回复给。。',
  `from_uid` int(11) unsigned NOT NULL COMMENT '来自谁的回复',
  `is_read` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否已读',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '回复时间',
  PRIMARY KEY (`id`),
  KEY `t_uid` (`to_uid`),
  KEY `f_uid` (`from_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `airex_reply`
--

INSERT INTO `airex_reply` (`id`, `tid`, `to_uid`, `from_uid`, `is_read`, `create_time`) VALUES
(1, 1, 5, 5, '否', '2016-05-30 08:09:55'),
(2, 54, 5, 10, '否', '2016-07-03 14:01:36'),
(3, 54, 7, 10, '否', '2016-07-03 14:01:50'),
(4, 54, 7, 10, '否', '2016-07-03 14:02:37'),
(5, 54, 7, 10, '否', '2016-07-03 14:03:47'),
(6, 54, 5, 10, '否', '2016-07-03 15:33:54'),
(7, 54, 7, 10, '否', '2016-07-04 05:09:17'),
(8, 76, 7, 17, '否', '2016-07-09 17:07:15');

-- --------------------------------------------------------

--
-- 表的结构 `airex_resetpw`
--

CREATE TABLE IF NOT EXISTS `airex_resetpw` (
  `hash` varchar(32) NOT NULL,
  `expire` int(13) NOT NULL,
  `user_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `airex_siteinfo`
--

CREATE TABLE IF NOT EXISTS `airex_siteinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_num` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_num` int(10) unsigned NOT NULL DEFAULT '0',
  `member_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `airex_siteinfo`
--

INSERT INTO `airex_siteinfo` (`id`, `topic_num`, `comment_num`, `member_num`) VALUES
(1, 48, 100, 9);

-- --------------------------------------------------------

--
-- 表的结构 `airex_topic`
--

CREATE TABLE IF NOT EXISTS `airex_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '话题标题',
  `content` text NOT NULL COMMENT '话题内容',
  `publish_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '作者id',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `collections` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被收藏数',
  `comments` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `last_comment_user` varchar(20) DEFAULT '',
  `last_comment_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `airex_topic`
--

INSERT INTO `airex_topic` (`id`, `title`, `content`, `publish_time`, `uid`, `hits`, `collections`, `comments`, `node_id`, `cat_id`, `last_comment_user`, `last_comment_time`) VALUES
(30, '测试', '123<br>123', '2016-06-13 02:06:17', 7, 0, 0, 9, 6, 1, 'Teemo', '2016-07-04 15:22:35'),
(31, '我爱你', '啊', '2016-06-15 02:06:21', 5, 0, 0, 1, 10, 2, 'Teemo', '2016-06-15 22:06:41'),
(32, '1', '2', '2016-06-16 03:06:32', 7, 0, 0, 5, 2, 1, 'patrick95', '2016-06-22 19:32:16'),
(53, '测试时间戳', '啊', '2016-06-22 05:59:18', 5, 0, 0, 1, 1, 1, 'Teemo', '2016-06-27 18:24:19'),
(54, 'asdasd', 'asdasd', '2016-06-22 06:37:18', 8, 0, 0, 15, 1, 1, 'Teemo', '2016-07-04 15:41:47'),
(55, '123123', '213132<br>123<hr>追加内容：324234<hr><p>546456</p><hr><p class=''small''>546456</p><span class=''append''><hr><p class=''small''>345345</p></span>n class=''append''><hr><p class=''append-small'' style=''background-color:#F0F0F0''>324234</p></span><span class=''append''><hr><p class=''append-small'' style=''background-color:#F0F0F0''>213213</p></span><span class=''append''><hr><p class=''small'' style=''background-color:#F0F0F0''>123123</p></span><span class=''append''><hr><p class=''small'' style=''background-color:#F0F0F0''>345</p></span>', '2016-07-03 14:55:59', 10, 0, 0, 1, 1, 1, 'Win10', '2016-07-04 00:14:55'),
(56, '123', '123', '2016-07-03 16:15:05', 10, 0, 0, 2, 1, 1, 'Teemo', '2016-07-04 15:46:09'),
(57, '123123', '123123', '2016-07-03 16:46:04', 10, 0, 0, 0, 1, 1, '', '0000-00-00 00:00:00'),
(58, 'Airex是一个基于ThinkPHP的轻型BBS项目', 'Airex是一个基于ThinkPHP的轻型BBS项目，欢迎使用。', '2016-07-03 16:47:32', 10, 0, 0, 1, 11, 3, 'Teemo', '2016-07-04 17:05:10'),
(59, '234', '324234', '2016-07-04 07:22:29', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:22:29'),
(60, '啊是大三的', '撒旦', '2016-07-04 07:41:38', 7, 0, 0, 2, 1, 1, 'Teemo', '2016-07-04 15:54:25'),
(61, '12312', '312321321', '2016-07-04 07:42:58', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:42:58'),
(62, '123', '123213', '2016-07-04 07:43:05', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:43:05'),
(63, '123', '123123', '2016-07-04 07:43:12', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:43:12'),
(64, '123', '123123213', '2016-07-04 07:43:18', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:43:18'),
(65, '123', '123123', '2016-07-04 07:43:25', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:43:25'),
(66, '23423', '4234234234', '2016-07-04 07:43:33', 7, 0, 0, 0, 1, 1, '', '2016-07-04 15:43:33'),
(67, '2342', '34234234234', '2016-07-04 07:43:42', 7, 0, 0, 1, 1, 1, 'Teemo', '2016-07-04 15:53:06'),
(68, '234234', '234234234', '2016-07-04 07:43:50', 7, 0, 0, 1, 1, 1, 'Teemo', '2016-07-04 15:53:01'),
(69, '123123', '123213', '2016-07-04 08:56:05', 7, 0, 0, 0, 14, 3, '', '2016-07-04 16:56:05'),
(70, '231', '21312', '2016-07-04 08:56:19', 7, 0, 0, 0, 20, 4, '', '2016-07-04 16:56:19'),
(71, 'Airex是一个基于ThinkPHP的轻型BBS项目', '123', '2016-07-09 16:47:42', 7, 0, 0, 0, 1, 1, '', '2016-07-10 00:47:42'),
(72, '关于Thinkphp的mysql事务回滚', '啊', '2016-07-09 16:49:42', 14, 0, 0, 1, 1, 1, 'coldplay', '2016-07-10 00:55:23'),
(73, '学Python2好还是3好？', '123', '2016-07-09 16:50:14', 8, 0, 0, 0, 2, 1, '', '2016-07-10 00:50:14'),
(74, '现在android开发饱和了吗？', '啊', '2016-07-09 16:52:22', 15, 0, 0, 0, 4, 1, '', '2016-07-10 00:52:22'),
(75, '江苏移动怎么样？坑不坑？', '啊', '2016-07-09 16:53:27', 16, 0, 0, 0, 6, 1, '', '2016-07-10 00:53:27'),
(76, '两年PHP程序员，一线城市薪资大概多少？', '啊', '2016-07-09 16:55:09', 17, 0, 0, 3, 1, 1, 'coldplay', '2016-07-10 01:07:15');

-- --------------------------------------------------------

--
-- 表的结构 `airex_user`
--

CREATE TABLE IF NOT EXISTS `airex_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(30) NOT NULL DEFAULT '',
  `gender` enum('保密','女','男') NOT NULL DEFAULT '保密' COMMENT '性别',
  `password` varchar(40) NOT NULL DEFAULT '',
  `imgpath` varchar(50) NOT NULL DEFAULT '/home/img/avatar/default.png' COMMENT '头像保存路径',
  `nodes` int(11) NOT NULL DEFAULT '0' COMMENT '收藏节点',
  `attentions` int(11) NOT NULL DEFAULT '0' COMMENT '特别关注',
  `topics` int(11) NOT NULL DEFAULT '0' COMMENT '收藏话题',
  `wealth` int(11) NOT NULL DEFAULT '0' COMMENT '财富值',
  `status` enum('正常','禁用') NOT NULL DEFAULT '正常' COMMENT '账号状态',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '账号创建时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '信息更新时间',
  `login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '登陆ip',
  `url` varchar(40) NOT NULL DEFAULT '',
  `resume` varchar(50) NOT NULL DEFAULT '',
  `last_reply_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `u_name` (`user_name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `airex_user`
--

INSERT INTO `airex_user` (`id`, `user_name`, `email`, `gender`, `password`, `imgpath`, `nodes`, `attentions`, `topics`, `wealth`, `status`, `create_time`, `update_time`, `login_ip`, `url`, `resume`, `last_reply_uid`) VALUES
(5, 'patrick95', '11@qq.com', '女', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/default.png', 0, 2, 3, 0, '正常', '2016-05-31 08:04:49', '2016-06-23 05:11:16', 2130706433, 'http://baidu.com', '一个好人。', 0),
(6, 'micanss', '11@qq.com', '保密', 'c65f8a112b1e9c70f4996a97ecffa696', '/home/img/avatar/6.jpg', 0, 0, 0, 0, '正常', '2016-06-03 13:14:28', '2016-06-06 08:23:00', 2130706433, '', '', 0),
(7, 'Teemo', 'l11@qq.com2', '男', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/7.jpg', 3, 1, 1, 0, '正常', '2016-06-08 11:32:04', '2016-07-04 10:23:47', 0, 'http://muguang.me', '提莫队长。', 0),
(8, 'test', '123@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/default.png', 0, 0, 0, 0, '正常', '2016-06-11 15:17:31', '2016-07-09 16:49:55', 0, '', '', 0),
(9, 'test2', 'kawc@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/default.png', 0, 0, 0, 0, '正常', '2016-06-11 15:18:45', '0000-00-00 00:00:00', 0, '', '', 0),
(10, 'Win10', 'win10@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/default.png', 0, 1, 0, 0, '正常', '2016-07-03 07:01:41', '2016-07-03 15:04:37', 0, 'http://weibo.com/ajaxlogin.php?framel', 'sadasd', 0),
(11, '123123', '1231@qq.com', '保密', '10470c3b4b1fed12c3baac014be15fac', '/home/img/avatar/default.png', 0, 0, 0, 0, '正常', '2016-07-04 08:10:53', '0000-00-00 00:00:00', 0, '', '', 0),
(12, '123213', 'asd@q.com', '保密', '10470c3b4b1fed12c3baac014be15fac', '/home/img/avatar/default.png', 0, 0, 0, 0, '正常', '2016-07-04 08:11:26', '0000-00-00 00:00:00', 0, '', '', 0),
(13, '123123213', '12231@qq.com', '保密', '040bd08a4290267535cd247b8ba2eca1', '/home/img/avatar/default.png', 0, 0, 0, 0, '正常', '2016-07-04 08:12:55', '0000-00-00 00:00:00', 0, '', '', 0),
(14, 'Patrick', '1@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/14.jpg', 0, 0, 0, 0, '正常', '2016-07-09 16:48:05', '2016-07-09 16:48:58', 0, '', '', 0),
(15, 'bitch', 'asd@a.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/15.jpg', 0, 0, 0, 0, '正常', '2016-07-09 16:50:47', '2016-07-09 16:51:49', 0, '', '', 0),
(16, 'Sky', 'asdf@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/16.jpg', 0, 0, 0, 0, '正常', '2016-07-09 16:52:53', '2016-07-09 16:53:11', 0, '', '', 0),
(17, 'coldplay', 'afc2@qq.com', '保密', '52957a79203b1b29c06cc5bc3d9a19f4', '/home/img/avatar/17.jpg', 0, 1, 1, 0, '正常', '2016-07-09 16:54:43', '2016-07-09 16:56:31', 0, '', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
