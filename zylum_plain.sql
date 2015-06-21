-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2015 at 02:07 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zylum_plain`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `pic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `disc_groups`
--

CREATE TABLE IF NOT EXISTS `disc_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `pass` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `archive` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `original` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `name`, `subject`, `content`) VALUES
(1, 'approval', 'Your Zylum registration has been approved', '<p>Dear ||name||,</p>\r\n<p>Welcome to Zylum. We have approved your registration and you are now the Owner of a Zylum group. Use your email address and the password below to log in here: <a href="http://www.zylum.org/login">https://www.zylum.org/login</a></p>\r\n<p>Your Zylum password is: <strong>||pass||</strong></p>\r\n<p><strong>Please keep your password safe.</strong></p>\r\n<p>If you need help, please look at our support page<a href="../help"> https://zylum.org/help</a>. You can also contact us through the website&nbsp;<a href="https://zylum.org/contact">https://zylum.org/contact</a></p>\r\n<p><strong>USING ZYLUM WHILE IT IS IN DEVELOPMENT</strong></p>\r\n<p>At this stage Zylum is in beta form and some of the tools are still in development so we must warn you not to commit any irreplaceable or top secret data to the system just yet. We will be in touch in the next few weeks when we feel that the system is ready to be fully used, when most of the bugs and issues have been ironed out and we have confirmed that the system is as secure as it aims to be, and works as it should.</p>\r\n<p>Please explore what Zylum has to offer and get in touch with any comments.</p>\r\n<p>Thanks for registering!</p>\r\n<p>The Zylum team.</p>'),
(2, 'reset', 'Zylum password reset', '<p>Dear ||name||,</p>\r\n<p>Here is your new password ||pass||</p>\r\n<p>the ||site name|| team.</p>'),
(3, 'contributor invite', 'An invitation to Zylum', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to contribute to ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Here is your new password ||pass||</p>\r\n<p>Please login here <a href="https://||site url||">https://||site url||</a></p>\r\n<p>the ||site name|| team.</p>'),
(4, 'participant invite', 'An invitation to Zylum', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to participate in ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Here is your new password ||pass||</p>\r\n<p>Please login here <a href="https://||site url||">https://||site url||</a></p>\r\n<p>the ||site name|| team.</p>'),
(5, 'Check sign up', 'Zylum sign up confirmation', '<p>Hi</p>\r\n<p>We have received a request to join the mailing list at ||sub site name||. If this is not you just ignore this email, it is please confirm your sign up by clicking this ||link||</p>\r\n<p>the ||site name|| team.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `forwardings`
--

CREATE TABLE IF NOT EXISTS `forwardings` (
  `destination` varchar(255) DEFAULT 'vmail',
  `source` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

-- --------------------------------------------------------

--
-- Table structure for table `mailing_list`
--

CREATE TABLE IF NOT EXISTS `mailing_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `pass` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `web_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_archive`
--

CREATE TABLE IF NOT EXISTS `newsletter_archive` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `recipients` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` enum('Home','Page','News') NOT NULL,
  `web_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `pic` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `redirects`
--

CREATE TABLE IF NOT EXISTS `redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `security` enum('Public','Member','Contributor','Owner','Superuser') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `redirects`
--

INSERT INTO `redirects` (`id`, `url`, `file`, `template`, `security`) VALUES
(1, '/', 'home.php', 'home', 'Public'),
(2, '/manage', 'home.php', 'admin', 'Superuser'),
(3, '/manage/new', 'new_sign_ups.php', 'admin', 'Superuser'),
(4, '/login', 'login.php', 'public', 'Public'),
(5, '/contributors', 'contributors.php', 'public', 'Owner'),
(6, '/dashboard', 'dashboard.php', 'public', 'Contributor'),
(7, '/forgotten_password', 'forgotten_password.php', 'public', 'Public'),
(8, '/logout', 'logout.php', 'public', 'Public'),
(11, '/manage/login', 'login.php', 'admin', 'Public'),
(10, '/thank_you', 'thank_you.php', 'public', 'Public'),
(12, '/mailing_list', 'mailing_list.php', 'public', 'Owner'),
(16, '/manage/users', 'users.php', 'admin', 'Superuser'),
(14, '/dashboard/turn_it_on', 'dashboard.php', 'public', 'Contributor'),
(15, '/dashboard/turn_it_off', 'dashboard.php', 'public', 'Contributor'),
(17, '/manage/users/all', 'users.php', 'admin', 'Superuser'),
(18, '/manage/users/suspended', 'users.php', 'admin', 'Superuser'),
(19, '/manage/users/owners', 'users.php', 'admin', 'Superuser'),
(20, '/document_sharing', 'document_sharing.php', 'public', 'Contributor'),
(21, '/about', 'about.php', 'home', 'Public'),
(22, '/contact', 'contact.php', 'home', 'Public'),
(23, '/help', 'help.php', 'home', 'Public'),
(24, '/manage/emails', 'emails.php', 'admin', 'Superuser'),
(0, '/404', '404.php', 'home', 'Public'),
(26, '/terms', 'terms.php', 'home', 'Public'),
(27, '/privacy', 'privacy.php', 'home', 'Public'),
(28, '/unsub', 'unsubscribe.php', 'public', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `resets`
--

CREATE TABLE IF NOT EXISTS `resets` (
  `id` int(11) NOT NULL,
  `pass` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sign_ups`
--

CREATE TABLE IF NOT EXISTS `sign_ups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `superusers`
--

CREATE TABLE IF NOT EXISTS `superusers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `superusers`
--

INSERT INTO `superusers` (`id`, `email`, `password`) VALUES
(1, 'admin@null.null', 'youradminpasswordhashhere');

-- --------------------------------------------------------

--
-- Table structure for table `to_be_sent`
--

CREATE TABLE IF NOT EXISTS `to_be_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_date` varchar(255) NOT NULL,
  `sent` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `deputies` varchar(255) NOT NULL,
  `why` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('Superuser','Contributor','Participant') NOT NULL,
  `valid` enum('No','Yes') NOT NULL DEFAULT 'No',
  `site_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `deputies`, `why`, `title`, `url`, `password`, `type`, `valid`, `site_id`, `timestamp`) VALUES
(14, 'Name', 'email@domain.com', 'a:2:{i:0;s:17:"anotheremail@domain.com";i:1;s:17:"yetanother@domain.com";}', 'Testing', 'Testing', '/user', '098f6bcd4621d373cade4e832627b4f6', 'Superuser', 'Yes', 14, '2015-06-15 12:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE IF NOT EXISTS `website` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `pages` int(11) NOT NULL,
  `logo` int(11) NOT NULL,
  `title_pic` int(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `email` int(11) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `on` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
