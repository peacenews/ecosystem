-- ecosystem database & field structures
-- DB version 2.1
-- Note: default character set is now utf8 throughout

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ecosystem`
--

CREATE DATABASE IF NOT EXISTS `ecosystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecosystem`;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `web_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- @TODO: convert to datetime
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `archive` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `original` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` VALUES(1, 'approval', 'Your Ecosystem registration has been approved', '<p>Dear ||name||,</p><p>Welcome to Ecosystem. We have approved your registration and you are now the Owner of an Ecosystem group. Use your email address and the password below to log in here: <a href="http://www.ecosystem.new/login">https://www.ecosystem.new/login</a></p><p>Your Ecosystem password is: <strong>||pass||</strong></p><p><strong>Please keep your password safe.</strong></p><p>If you need help, please look at our support page<a href="../help"> https://ecosystem.new/help</a>. You can also contact us through the website&nbsp;<a href="https://ecosystem.new/contact">https://ecosystem.new/contact</a></p><p><strong>USING Ecosystem WHILE IT IS IN DEVELOPMENT</strong></p><p>At this stage Ecosystem is in beta form and some of the tools are still in development so we must warn you not to commit any irreplaceable or top secret data to the system just yet. We will be in touch in the next few weeks when we feel that the system is ready to be fully used, when most of the bugs and issues have been ironed out and we have confirmed that the system is as secure as it aims to be, and works as it should.</p><p>Please explore what Ecosystem has to offer and get in touch with any comments.</p><p>Thanks for registering!</p><p>The Ecosystem team.</p>');
INSERT INTO `emails` VALUES(2, 'reset', 'Ecosystem password reset', '<p>Dear ||name||,</p>\r\n<p>Here is your new password ||pass||</p>\r\n<p>the ||site name|| team.</p>');
INSERT INTO `emails` VALUES(3, 'contributor invite', 'An invitation to Ecosystem', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to contribute to ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Here is your new password ||pass||</p>\r\n<p>Please login here <a href="https://||site url||">http://||site url||</a></p>\r\n<p>the ||site name|| team.</p>');
INSERT INTO `emails` VALUES(4, 'participant invite', 'An invitation to Ecosystem', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to participate in ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Here is your new password ||pass||</p>\r\n<p>Please login here <a href="https://||site url||">https://||site url||</a></p>\r\n<p>the ||site name|| team.</p>');
INSERT INTO `emails` VALUES(5, 'Check sign up', 'Ecosystem sign up confirmation', '<p>Hi</p>\r\n<p>We have received a request to join the mailing list at ||sub site name||. If this is not you just ignore this email, it is please confirm your sign up by clicking this ||link||</p>\r\n<p>the ||site name|| team.</p>\r\n');
INSERT INTO `emails` VALUES(6, 'existinguser_groupapproval', 'Your Ecosystem Group has been approved', '<p>Dear ||name||,</p>\r\n<p>Welcome to Ecosystem. We have approved your group registration and you are now the Owner of an Ecosystem group. Use your existing email address and the password&nbsp; to log in here: https://www.ecosystem.new/login</p>\r\n<p>If you need help, please look at our support page<a href="../help"> https://ecosystem.new/help</a>. You can also contact us through the website&nbsp;<a href="https://ecosystem.new/contact">https://ecosystem.new/contact</a></p>\r\n<p><strong>USING Ecosystem WHILE IT IS IN DEVELOPMENT</strong></p>\r\n<p>At this stage Ecosystem is in beta form and some of the tools are still in development so we must warn you not to commit any irreplaceable or top secret data to the system just yet. We will be in touch in the next few weeks when we feel that the system is ready to be fully used, when most of the bugs and issues have been ironed out and we have confirmed that the system is as secure as it aims to be, and works as it should.</p>\r\n<p>Please explore what Ecosystem has to offer and get in touch with any comments.</p>\r\n<p>Thanks for registering!</p>\r\n<p>The Ecosystem team.</p>');
INSERT INTO `emails` VALUES(7, 'contributor invitation for existing users', 'An invitation to Ecosystem', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to contribute to ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Please login here <a href="https://||site url||">http://||site url||</a></p>\r\n<p>the ||site name|| team.</p>');
INSERT INTO `emails` VALUES(8, 'participant invitation for existing users', 'An invitation to Ecosystem', '<p>Dear ||name||</p>\r\n<p>||inviter|| has invited you to participate in ||sub site name||</p>\r\n<blockquote>||message||</blockquote>\r\n<p>Please login here <a href="https://||site url||">http://||site url||</a></p>\r\n<p>the ||site name|| team.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `forwardings`
--

CREATE TABLE IF NOT EXISTS `forwardings` (
  `destination` varchar(255) DEFAULT 'vmail',
  `source` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, -- @TODO: convert to datetime
  `web_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_archive`
--

CREATE TABLE IF NOT EXISTS `newsletter_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `recipients` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- @TODO: convert to datetime
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` VALUES(1, '', '', 'Home', 180, '<h1>Add your Heading for your introduction here</h1>\n        <h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n        <p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(2, 'News', 'news', 'News', 180, '', 0, '');
INSERT INTO `pages` VALUES(3, '', '', 'Home', 181, '<h1>Add your Heading for your introduction here</h1>\n        <h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n        <p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(4, 'News', 'news', 'News', 181, '', 0, '');
INSERT INTO `pages` VALUES(5, '', '', 'Home', 182, '<h1>Add your Heading for your introduction here</h1>\n        <h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n        <p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(6, 'News', 'news', 'News', 182, '', 0, '');
INSERT INTO `pages` VALUES(8, 'testpage', 'testpage', 'Page', 1, '<h1>Sorry that page does not exist.</h1>', 0, '');
INSERT INTO `pages` VALUES(9, '', '', 'Home', 184, '<h1>Add your Heading for your introduction here</h1>\n        <h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n        <p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(10, 'News', 'news', 'News', 184, '', 0, '');
INSERT INTO `pages` VALUES(11, '', '', 'Home', 185, '<h1 style="color: rgb(0, 155, 46);" data-mce-style="color: #00469b;">Add your Heading for your introduction here</h1><h2 style="color: rgb(0, 155, 46);" data-mce-style="color: #00469b;">Welcome to Srinu''s Marriage Buareau<br></h2>', 0, '');
INSERT INTO `pages` VALUES(12, 'News', 'news', 'News', 185, '', 0, '');
INSERT INTO `pages` VALUES(13, '', '', 'Home', 186, '<h1 style="color: rgb(34, 187, 31);" data-mce-style="color: #00469b;">Cyborgasmic - For that online Oooh!<br></h1><h2 style="color: rgb(34, 187, 31);" data-mce-style="color: #00469b;">Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2><p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(14, 'News', 'news', 'News', 186, '', 0, '');
INSERT INTO `pages` VALUES(15, '', '', 'Home', 187, '<h1>Add your Heading for your introduction here</h1>\n			<h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n			<p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(16, 'News', 'news', 'News', 187, '', 0, '');
INSERT INTO `pages` VALUES(17, '', '', 'Home', 188, '<h1>Add your Heading for your introduction here</h1>\n			<h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>\n			<p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(18, 'News', 'news', 'News', 188, '', 0, '');
INSERT INTO `pages` VALUES(19, '', '', 'Home', 189, '<h1 style="color: #d8ab00;" data-mce-style="color: #d8ab00;">Welcome to My Area</h1><h2 style="color: #ccc;" data-mce-style="color: #ccc;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.</h2>', 0, '');
INSERT INTO `pages` VALUES(20, 'News', 'news', 'News', 189, '', 0, '');
INSERT INTO `pages` VALUES(21, 'Contact', 'contact', 'Page', 189, '<h1 style="color: #d8ab00;" data-mce-style="color: #d8ab00;">Contact Us</h1><h2 style="color: #d8ab00;" data-mce-style="color: #d8ab00;">Email: ashok@believecreative.com<br>Mobile: +91-8801455732</h2><p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(22, 'Products', 'products', 'Page', 189, '<h1 style="color: #d8ab00;" data-mce-style="color: #d8ab00;">Our Services<br></h1><h2 style="color: #d8ab00;" data-mce-style="color: #d8ab00;">Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2><p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(23, '', '', 'Home', 190, '<h1 style="color: rgb(41, 172, 0);" data-mce-style="color: #00469b;">Welcome HTML<br></h1><h2 style="color: rgb(41, 172, 0);" data-mce-style="color: #00469b;">Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2><p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(24, 'News', 'news', 'News', 190, '', 0, '');
INSERT INTO `pages` VALUES(25, 'Location', 'location', 'Page', 190, '<h1 style="color: #29ac00;" data-mce-style="color: #29ac00;">Location<br></h1><h2 style="color: #29ac00;" data-mce-style="color: #29ac00;">Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2><p>Start typing or insert your copy here…</p>', 0, '');
INSERT INTO `pages` VALUES(26, '', '', 'Home', 191, '<h1 style="color: #00469b;" data-mce-style="color: #00469b;">hello<br></h1><h2 style="color: #00469b;" data-mce-style="color: #00469b;">sometexthere&nbsp;Start typing or insert your copy<br></h2>', 4, '');
INSERT INTO `pages` VALUES(28, 'anotherpage', 'anotherpage', 'Page', 191, '<h1 style="color: #92009b;" data-mce-style="color: #92009b;">It is time we all woke up<br></h1><h2 style="color: #92009b;" data-mce-style="color: #92009b;">and did one or two useful things to make sure that stuff happens. In this article we explore what precisely that stuff might involve - if it was all Latin gobeldygook.<br></h2><div id="lipsum"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum congue nibh at sagittis. Quisque vehicula vitae ligula sed aliquam. Duis quis nulla vitae dui iaculis dictum. Cras at tellus iaculis, aliquet felis et, placerat dui. Cras malesuada sapien interdum efficitur facilisis. Ut sed luctus est. Nullam commodo nisl consequat, luctus neque et, ultrices arcu. Nulla a sapien risus. Maecenas id mi quis ipsum pharetra condimentum. Mauris mauris leo, tincidunt finibus ipsum ac, facilisis consequat nisl. Morbi porta vel lorem eget sollicitudin.</p><p>Curabitur ut finibus orci. Nam vel nisl consequat, efficitur lorem ut, posuere quam. Donec non posuere eros. Nunc et lorem sit amet justo porttitor pulvinar. Duis pharetra rutrum libero id blandit. Vestibulum eget interdum massa, nec bibendum justo. Pellentesque neque sapien, lacinia vitae efficitur vitae, pulvinar sit amet urna.</p><p>Curabitur tempor lacus arcu, sed venenatis nisi sodales eu. Donec commodo velit ac urna blandit, eget pretium elit consequat. Vestibulum a rhoncus elit. Curabitur tempus, felis id sagittis blandit, diam metus ullamcorper augue, ac congue neque tellus vitae mauris. Vivamus ultrices magna vel justo mattis aliquam. Suspendisse sem metus, varius nec ipsum et, laoreet venenatis lectus. Donec ut dictum orci, vel gravida quam. Praesent vel ligula a neque tincidunt laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><p>Etiam pellentesque orci vitae nisl aliquam venenatis. Donec convallis, enim ac egestas pharetra, diam eros hendrerit odio, ac pulvinar orci metus non ligula. Aenean dapibus auctor bibendum. Nulla facilisi. Curabitur faucibus euismod sollicitudin. Morbi tristique vel justo non maximus. Sed placerat urna tellus, non consequat ipsum malesuada ac. Proin pretium ligula non iaculis laoreet. Nunc in interdum dolor. Duis non mollis tortor. Cras pulvinar, arcu eget tincidunt sodales, libero purus tristique nunc, non tincidunt eros orci vitae lorem. In feugiat tortor libero, quis pellentesque tellus luctus fringilla. Vestibulum imperdiet, nisl quis lobortis tristique, leo lacus faucibus velit, et gravida tortor tortor eu lorem. Proin nibh ex, tempor ut venenatis sit amet, faucibus ut lorem. Nullam sodales dui ullamcorper tellus dapibus, commodo pulvinar ligula auctor. Aenean urna urna, pellentesque eu condimentum sit amet, placerat vel leo.</p><p>Cras diam ex, sagittis eu ultricies id, dictum id dui. Sed facilisis odio a ante elementum cursus. Sed sodales, magna vitae eleifend gravida, nunc felis semper arcu, dignissim tincidunt magna urna sit amet tellus. Etiam eleifend vulputate dignissim. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed aliquam laoreet accumsan. Phasellus at ligula id arcu tincidunt imperdiet eget blandit purus. Nam consequat sit amet mi at fermentum. Nam sit amet odio ut arcu consequat interdum ut sollicitudin elit. Integer euismod et lorem vel condimentum. Nullam elementum nisl enim, id blandit justo semper vel.</p></div>', 5, '');
INSERT INTO `pages` VALUES(27, 'News', 'news', 'News', 191, '', 0, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `redirects`
--

INSERT INTO `redirects` VALUES(1, '/', 'home.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(2, '/manage', 'home.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(3, '/manage/new', 'new_sign_ups.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(4, '/login', 'login.php', 'public', 'Public');
INSERT INTO `redirects` VALUES(5, '/contributors', 'contributors.php', 'public', 'Owner');
INSERT INTO `redirects` VALUES(6, '/dashboard', 'dashboard.php', 'public', 'Contributor');
INSERT INTO `redirects` VALUES(7, '/forgotten_password', 'forgotten_password.php', 'public', 'Public');
INSERT INTO `redirects` VALUES(8, '/logout', 'logout.php', 'public', 'Public');
INSERT INTO `redirects` VALUES(11, '/manage/login', 'login.php', 'admin', 'Public');
INSERT INTO `redirects` VALUES(10, '/thank_you', 'thank_you.php', 'public', 'Public');
INSERT INTO `redirects` VALUES(12, '/mailing_list', 'mailing_list.php', 'public', 'Owner');
INSERT INTO `redirects` VALUES(16, '/manage/users', 'users.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(14, '/dashboard/turn_it_on', 'dashboard.php', 'public', 'Contributor');
INSERT INTO `redirects` VALUES(15, '/dashboard/turn_it_off', 'dashboard.php', 'public', 'Contributor');
INSERT INTO `redirects` VALUES(17, '/manage/users/all', 'users.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(18, '/manage/users/suspended', 'users.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(19, '/manage/users/owners', 'users.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(20, '/document_sharing', 'document_sharing.php', 'public', 'Contributor');
INSERT INTO `redirects` VALUES(21, '/about', 'about.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(22, '/contact', 'contact.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(23, '/help', 'help.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(24, '/manage/emails', 'emails.php', 'admin', 'Superuser');
INSERT INTO `redirects` VALUES(0, '/404', '404.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(26, '/terms', 'terms.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(27, '/privacy', 'privacy.php', 'home', 'Public');
INSERT INTO `redirects` VALUES(28, '/unsub', 'unsubscribe.php', 'public', 'Public');
INSERT INTO `redirects` VALUES(29, '/register', 'register.php', 'home', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `resets`
--

CREATE TABLE IF NOT EXISTS `resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `superusers`
--

CREATE TABLE IF NOT EXISTS `superusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `superusers`
-- Note: default login username is: admin@ecosystem
--                     password is: ecosystem
--

INSERT INTO `superusers` VALUES(1, 'admin@ecosystem', 'f808b00346d666fbc388f82dd90c7c08');

-- --------------------------------------------------------

--
-- Table structure for table `to_be_sent`
--

CREATE TABLE IF NOT EXISTS `to_be_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, -- @TODO: convert to datetime
  `sent_date` varchar(255) NOT NULL, -- @TODO: convert to datetime
  `sent` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE IF NOT EXISTS `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `why` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `website_users`
--

CREATE TABLE IF NOT EXISTS `website_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `role_on_Website` varchar(25) NOT NULL, -- @TODO: convert to lowercase
  `email_preferences` varchar(100) NOT NULL,
  `valid` bit(1) NOT NULL DEFAULT b'0',
  `registration_date_on_website` datetime NOT NULL,
  `last_login_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

