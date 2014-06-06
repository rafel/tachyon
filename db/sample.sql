-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2014 at 10:06 PM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tachyon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_idx` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userid`) VALUES
(1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `postid` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`userid`),
  KEY `post_id_idx` (`postid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `userid`, `content`, `postid`, `created`) VALUES
(1, 2, 'joi joeijw fioewj fj owijf ijewoij', 47, '2014-05-05 11:22:35'),
(2, 2, 'test', 47, '2014-05-05 12:22:33'),
(3, 2, 'test2', 46, '2014-05-05 12:24:29'),
(4, 2, 'dwada', 45, '2014-05-05 12:35:32'),
(5, 2, 'testrewrwer', 44, '2014-05-05 12:36:48'),
(6, 2, 'Testing comment', 48, '2014-05-05 12:38:22'),
(7, 14, 'testComment', 49, '2014-05-05 14:27:09'),
(8, 15, 'kdiaojdioawj ojio da', 52, '2014-05-05 16:55:48'),
(9, 17, 'jdiaojdio jawdjoaj doa', 55, '2014-05-05 17:17:03'),
(10, 14, 'jidowajdowiajda', 55, '2014-05-05 19:00:35');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id_idx` (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(45) NOT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `userid`, `content`, `created`) VALUES
(2, 2, 'dwadjaidaodawda\r\n', '2014-03-06 18:17:36'),
(3, 6, 'tsda wiojda odja jwadj\r\n', '2014-03-06 18:22:49'),
(4, 6, 'testetstwda dawoidjad\r\n', '2014-03-06 18:28:20'),
(5, 6, 'dwhuaidh dawhuidha\r\n', '2014-03-06 18:33:59'),
(18, 6, 'aaaaaaaaaaaaaaaaaaaaaa', '2014-03-06 20:22:21'),
(19, 6, '1233211233123\r\n', '2014-03-06 21:21:59'),
(22, 6, 'jdwao jdioadj ajdaiowdja djaiowd\r\n djaiwo djawdoawdd', '2014-03-06 21:34:28'),
(23, 2, 'dwadij aidjajd oajd oajd oawoid joa\r\njd ja', '2014-03-06 21:36:36'),
(24, 2, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee e e e e\r\n', '2014-03-06 21:36:51'),
(26, 2, 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww www\r\n', '2014-03-06 21:39:28'),
(27, 7, 'jiwjiajd aiodjoiwj ojdaref ef \r\n', '2014-03-06 21:42:15'),
(28, 9, 'jdioajdiowja iaowjd ijawd jia', '2014-03-07 15:11:42'),
(29, 9, 'jdoiwjaidjaoijd jioawjdoijwaoij idjaoi jdoawj ojdawijd', '2014-03-07 15:11:53'),
(30, 9, 'hduwiadhiuadh  hwudah dhiaw hdwud haidu whhhhhhhhhhhhhh hhhhhhhhhhhhh hhhhhhhhhhhhh hhhhh \r\n', '2014-03-07 15:13:36'),
(31, 10, 'hi hi hih ihi hih ih ih ih ihi ', '2014-03-07 15:18:38'),
(32, 10, 'hudwih hd wh dhwui hdw hiud hwui hdu hd \r\n', '2014-03-07 15:19:15'),
(33, 2, 'test daw kopad k\r\n', '2014-03-10 12:09:34'),
(34, 2, 'wdakdow kadop kapodk poak dopakd opak dpoka poakwk\r\n', '2014-03-10 12:09:54'),
(35, 11, 'dsfg\r\nwert\r\nwert', '2014-03-10 12:33:43'),
(36, 11, 'fdsjifh ehuiwufiw uhf wiuhf iw', '2014-03-10 12:33:54'),
(40, 2, 'something cool #cool #tag', '2014-03-18 09:35:00'),
(44, 2, 'rafel rea faw da da', '2014-03-18 14:47:17'),
(45, 2, 'dwad ad wad oajdo awd dwwwwww', '2014-03-18 14:47:59'),
(46, 2, 'kopadkw kda kpdak ', '2014-03-18 18:49:23'),
(47, 2, 'hdwd ahwuid adhiuaw hdwh dwu hdwjjoidja jdowa \r\n', '2014-05-05 10:48:05'),
(48, 2, 'Testing post', '2014-05-05 12:38:13'),
(49, 14, 'Testcomment', '2014-05-05 14:27:00'),
(50, 14, 'dwadawdwadadw 12 ', '2014-05-05 15:12:42'),
(51, 15, 'Test\r\ndsÃ¥dps ada\r\n', '2014-05-05 16:55:22'),
(52, 15, 'jidwdoiwjadioj aojd ojad\r\n', '2014-05-05 16:55:30'),
(55, 17, 'hiuwhdiua hdiuaw hdiuahiuawh dihdawiuhdafd\r\n', '2014-05-05 17:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `posttemp`
--

CREATE TABLE IF NOT EXISTS `posttemp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_idx` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `userid`, `photo`, `name`, `title`) VALUES
(1, 14, 'photo.jpg', 'Admin Adino', 'Adminstrator'),
(2, 16, 'photo.gif', 'User123', '123 321'),
(3, 17, 'photo.gif', 'Nytt konto', 'Software developer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `created`) VALUES
(2, 'raferwqwe@kth.se', 'rafel', 'FxpS7U3bVA.ebc58fd3607bf39b0540f3eca29e49e1d6c7b10b9cacc8c53f8e99d71d2e5c753261edcb6de1ce7462b092c0a9e41624a11b7b94a7f731a0f06310feb3c3d70f.ZUi3X2vJHk', '2014-03-02 18:49:53'),
(6, 'test@kth.se', 'test', 'kjSrzN5kNd.c96c81f80e13af484998925f862c89073328061c364c308e5c73db327ecf08b19c50cbebe0ca8e401017e33cabfc66e19e26558df97a6f35b02ce42ed97d2461.4t8qFNpmyr', '2014-03-06 18:21:38'),
(7, 'test2@kth.se', 'test2', 'QtyhsogA4E.cf95c6c68dda31383b9389a3ab20e221dfa8d5260ac708c53d39a0612d09413f39d4d2b99a83c241afa2201c43bd2d75f2a2a4a62a37c5e39e1c468190e0a038.jC0z4q9kU7', '2014-03-06 21:41:47'),
(8, 'rafelrafel@kth.se', 'rafelrafel', 'u0mMuAgIxZ.3b8fcaf8cf1cf1b74bb564b1911cca8b6f4843ea97e4ae9a34717a8ab0474f8863fed3f888d2e48762ed83fec4ab63e154fe92b23bf5cc67309ee91bc7f4f116.bd1IeNKZ1d', '2014-03-07 15:09:09'),
(9, 'rafraf@kth.se', 'rafraf', '5DAcU5cCb6.d7b8e586ec678b04bed9b17cdc0f5f252c9f852809aa309ab9b222d740da25dddcacd48797f6b7a6275b132b02e0c3cc6d439118abafa60bd36c68bcb07b506e.B7ZRUoU0uT', '2014-03-07 15:10:48'),
(10, 'tester@kth.se', 'tester', 'txOREsg7SQ.eb1bd26361e2c1c428400178de3479659794c7de9e22b5ba021b86dfb8797c7cf99f5a466e93a9202ffe490bba73036350ecf4e8f38b6ff2cfe711671b061bfa.xtjOY3ZhgZ', '2014-03-07 15:17:15'),
(11, 'asse@kth.se', 'asse', 'KclSHXG4PQ.0d67f378991eec10a839a4cf281a39e36cefc19a753cdbbd1e817a8e8c8126c68717eabdeba0dd95d88e99a3032ef40d8c8e16f78d4760df6d4f9ef123d3b263.7iBp9RtTMg', '2014-03-10 12:31:34'),
(12, 'qwe@kth.se', 'qwe', 'vYQXB1VHT5.1effe287f3fe843a5df4a21901c1565378a9e805d7a52aea0f3b6071931de0b295bd1e9cbb1e141105f5f9946b4ab8167ea8c62fb4a4353ea9dbcd0ec04f7c90.cnN1fFVoXP', '2014-03-16 19:16:18'),
(13, 'asd@kth.se', 'asd', 'OMmnv7lvk1.54dcc0a208e230987e16bfbb1dd0ea5748dab28026506b4b8751daf6ef615b44256c613f59341b5f4abac3003113d054a0959b36bfcc045d4dae4989dae8a03f.50KVjAkQoo', '2014-03-17 14:17:20'),
(14, 'admin@kth.se', 'admin', 'IHQ3rkzKoI.0ac397af562daa5ed251e5158153621476e7af1bb0a6fb38bd1d6302da9afd7d39e48b78248e8ffff25b48382e09e81224520c074779e74faf3404397fcae827.niMelDPeKi', '2014-05-05 12:39:28'),
(15, 'test123@kth.se', 'test123', '1TmeakBuJ6.43ad1fa08d701dc4f88d19664df638c129b83ba41285caeccab3a4234ded65aa28b3ab1d9419765ec2160067989f2a4f517ef1ddbe696428382f81f176353556.yt8xKepTVR', '2014-05-05 16:55:05'),
(16, 'user123@kth.se', 'user123', 'KLNYgVM1dJ.c9d3bcfc1dc6a25123b869897fd5893712e70a3167d6bc920fc4b442e4ed48c1a0b1ece6541be6594107f5bc0b27121dec4ac9e957fb61b47a8e34ccedf7ed94.RLQR1Jr4D1', '2014-05-05 17:02:10'),
(17, 'nyttkonto@kth.se', 'nyttkonto', 'Frke0RiJSK.90b4a5bf0a4a659047ef6c6d0f7f99761b26d1cc71f5533453964532cf452470f727341b1a847561443c02c7d84cb512a50bf20ca3b942be3cccaef1deadbe01.OJTSTTmt5l', '2014-05-05 17:13:13');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `post` (`id`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `post_id` FOREIGN KEY (`postid`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
