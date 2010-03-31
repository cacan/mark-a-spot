/**
 * Mark-a-Spot SQL Dump
 *
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    0.98
 */


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB700583`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `model` varchar(255) collate utf8_unicode_ci NOT NULL,
  `foreign_key` int(11) NOT NULL default '0',
  `dirname` varchar(255) collate utf8_unicode_ci default NULL,
  `basename` varchar(255) collate utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) collate utf8_unicode_ci NOT NULL,
  `alternative` varchar(50) collate utf8_unicode_ci default NULL,
  `group` varchar(255) collate utf8_unicode_ci default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=117 ;

--
-- Daten für Tabelle `attachments`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cats`	= Categories :">
--

CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `name` varchar(255) character set utf8 default NULL,
  `hex` varchar(6) character set utf8 NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `cats`
--

INSERT INTO `cats` (`id`, `parent_id`, `name`, `hex`) VALUES
(1, NULL, 'Category 1', '287fbd'),
(2, 1, 'Category 2', 'ff00bb'),
(3, 2, 'Category 3', 'ccaabb'),
(4, 2, 'Category 4', '6fb003'),
(5, 2, 'Category 5', 'aa5225'),
(6, 2, 'Category 6', '235f9b'),
(16, 2, 'Category 7', 'ccddaa');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(2) unsigned NOT NULL auto_increment,
  `marker_id` int(11) NOT NULL default '0',
  `user_id` varchar(36) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `group_id` varchar(36) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `name` varchar(128) character set utf8 collate utf8_unicode_ci default NULL,
  `email` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `comment` text character set utf8 collate utf8_unicode_ci,
  `status` int(10) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=57 ;

--
-- Daten für Tabelle `comments`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `districts`
--

CREATE TABLE IF NOT EXISTS `districts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `city_id` varchar(36) collate utf8_unicode_ci NOT NULL default '',
  `district_id` varchar(36) collate utf8_unicode_ci NOT NULL default '',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `lat` float(10,6) NOT NULL default '0.000000',
  `lon` float(10,6) NOT NULL default '0.000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `rating` (`district_id`,`name`,`lat`,`lon`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `districts`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` varchar(36) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', 'System Developers', '2009-09-24 18:49:23', '2010-01-16 11:32:49'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', 'Admins', '2009-09-26 16:44:37', '2010-01-17 06:07:35'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', 'Users', '2009-09-26 16:57:13', '2010-01-16 14:15:08');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_permissions`
--

CREATE TABLE IF NOT EXISTS `groups_permissions` (
  `group_id` char(36) NOT NULL default '',
  `permission_id` char(36) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups_permissions`
--

INSERT INTO `groups_permissions` (`group_id`, `permission_id`) VALUES
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae5291b-cde0-4e35-9e95-95f0510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b38c515-8254-4d2d-814c-759950431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae5311d-3e10-4485-9408-98b4510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae528c8-4dc8-46f7-bdc5-9348510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe2fe9-9c78-4276-b08d-4bbc510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe2fdb-2560-4412-aaef-4af9510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae529b4-3968-4460-9f0f-95d1510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe291f-d190-4c88-9693-e88e510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae5291b-cde0-4e35-9e95-95f0510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae528c8-4dc8-46f7-bdc5-9348510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abe28eb-38a4-46de-bc64-fcd3510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4abba2fb-c6fc-4007-ae78-437b510ab7ac'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4abe2fdb-2560-4412-aaef-4af9510ab7ac'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4ae528f7-590c-4f76-ab45-8f33510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae5311d-3e10-4485-9408-98b4510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b52af74-4684-45d8-b95e-379850431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b38c515-8254-4d2d-814c-759950431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b3f4da3-e6d0-41df-9091-594750431ca3'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b3f0b99-4b70-48f0-8d14-6d3350431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b3f4da3-e6d0-41df-9091-594750431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b5c158b-d88c-4bca-8f64-6e1e50431ca3'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4afef661-aa5c-4206-b6d7-c6e5510ab7ac'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4aec21e0-312c-4909-82b7-9b40510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b744907-b488-4d3e-8da3-599b50431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b744907-b488-4d3e-8da3-599b50431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b7d12ac-ae98-48ca-8c97-07a750431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b8a6e76-f874-422b-a9ef-122c50431ca3'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b8a6e76-f874-422b-a9ef-122c50431ca3'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4b8a8c4b-8b84-4f66-8483-453a50431ca3'),
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4b8a8c4b-8b84-4f66-8483-453a50431ca3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` char(36) NOT NULL default '',
  `user_id` char(36) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups_users`
--

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
('4abe28d5-bab4-4ea0-a696-e930510ab7ac', '4ae49e52-68d8-4d9f-927e-217d510ab7ac'),
('4abba313-d3e8-45be-b5f5-48bb510ab7ac', '4ae48c76-2348-4cf4-a6d4-06eb510ab7ac'),
('4abe2bc9-2554-427f-bb9e-e88e510ab7ac', '4b4c7acb-bd90-429d-b5f1-63dd50431ca3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markers`
--

CREATE TABLE IF NOT EXISTS `markers` (
  `id` int(10) NOT NULL auto_increment,
  `gov_id` int(11) NOT NULL default '0',
  `user_id` varchar(36) collate utf8_unicode_ci NOT NULL default '',
  `processcat_id` int(11) NOT NULL default '0',
  `district_id` int(11) default NULL,
  `subject` varchar(128) collate utf8_unicode_ci NOT NULL default '',
  `hint` text collate utf8_unicode_ci NOT NULL,
  `cat_id` tinyint(4) NOT NULL default '0',
  `street` varchar(128) character set utf8 NOT NULL,
  `zip` varchar(6) character set utf8 NOT NULL,
  `city` varchar(128) character set utf8 NOT NULL,
  `lat` float(10,6) NOT NULL default '0.000000',
  `lon` float(10,6) NOT NULL default '0.000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `rating` decimal(3,1) unsigned default '0.0',
  `votes` int(11) unsigned default '0',
  `dirname` varchar(255) collate utf8_unicode_ci NOT NULL,
  `basename` varchar(255) collate utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) collate utf8_unicode_ci NOT NULL,
  `event_start` varchar(11) collate utf8_unicode_ci default NULL,
  `event_end` varchar(11) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `processcat_id` (`processcat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=438 ;

--
-- Daten für Tabelle `markers`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markers_revs`
--

CREATE TABLE IF NOT EXISTS `markers_revs` (
  `id` int(10) NOT NULL default '0',
  `version_id` int(11) NOT NULL auto_increment,
  `version_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `gov_id` int(11) NOT NULL default '0',
  `user_id` varchar(36) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `processcat_id` int(11) NOT NULL default '0',
  `district_id` int(11) default NULL,
  `subject` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `hint` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `cat_id` tinyint(4) NOT NULL default '0',
  `street` varchar(128) character set utf8 NOT NULL default '',
  `zip` varchar(6) character set utf8 NOT NULL default '',
  `city` varchar(128) character set utf8 NOT NULL default '',
  `lat` float(10,6) NOT NULL default '0.000000',
  `lon` float(10,6) NOT NULL default '0.000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `rating` decimal(3,1) unsigned default '0.0',
  `votes` int(11) unsigned default '0',
  `dirname` varchar(255) NOT NULL default '',
  `basename` varchar(255) NOT NULL default '',
  `checksum` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`version_id`),
  KEY `processcat_id` (`processcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2787 ;

--
-- Daten für Tabelle `markers_revs`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` varchar(36) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created`, `modified`) VALUES
('4abba2fb-c6fc-4007-ae78-437b510ab7ac', '*', '2009-09-24 18:48:59', '2009-09-24 18:48:59'),
('4abe28eb-38a4-46de-bc64-fcd3510ab7ac', 'permissons:*', '2009-09-26 16:44:59', '2010-02-28 14:22:53'),
('4abe291f-d190-4c88-9693-e88e510ab7ac', 'groups:*', '2009-09-26 16:45:51', '2010-02-28 14:22:58'),
('4abe2fdb-2560-4412-aaef-4af9510ab7ac', 'users:edit', '2009-09-26 17:14:35', '2009-10-26 06:14:20'),
('4abe2fe9-9c78-4276-b08d-4bbc510ab7ac', 'users:add', '2009-09-26 17:14:49', '2009-09-26 17:14:49'),
('4ae528c8-4dc8-46f7-bdc5-9348510ab7ac', 'markers:admin', '2009-10-26 05:42:48', '2009-11-06 15:31:48'),
('4ae528f7-590c-4f76-ab45-8f33510ab7ac', 'markers:edit', '2009-10-26 05:43:35', '2009-10-31 18:26:34'),
('4ae5291b-cde0-4e35-9e95-95f0510ab7ac', 'markers:add', '2009-10-26 05:44:11', '2010-02-19 05:55:33'),
('4ae529b4-3968-4460-9f0f-95d1510ab7ac', 'markers:delete', '2009-10-26 05:46:44', '2009-10-26 05:46:44'),
('4aec21e0-312c-4909-82b7-9b40510ab7ac', 'markers:ajaxlist', '2009-10-31 12:39:12', '2010-01-26 16:03:11'),
('4ae5311d-3e10-4485-9408-98b4510ab7ac', 'users:index', '2009-10-26 06:18:21', '2010-02-28 14:23:11'),
('4afef661-aa5c-4206-b6d7-c6e5510ab7ac', 'markers:ajaxmylist', '2009-11-14 19:26:41', '2010-01-26 16:02:47'),
('4b52af74-4684-45d8-b95e-379850431ca3', '*:*', '2010-01-17 07:34:28', '2010-01-17 07:34:28'),
('4b38c515-8254-4d2d-814c-759950431ca3', 'markers:geosave', '2009-12-28 15:47:49', '2009-12-28 15:47:49'),
('4b3f0b99-4b70-48f0-8d14-6d3350431ca3', 'markers:undo', '2010-01-02 10:02:17', '2010-01-02 18:09:50'),
('4b3f4da3-e6d0-41df-9091-594750431ca3', 'markers:makeCurrent', '2010-01-02 14:44:03', '2010-01-02 14:44:03'),
('4b5c158b-d88c-4bca-8f64-6e1e50431ca3', 'users:delete', '2010-01-24 10:40:27', '2010-01-24 10:40:27'),
('4b744907-b488-4d3e-8da3-599b50431ca3', 'comments:free', '2010-02-11 19:14:31', '2010-02-11 19:14:31'),
('4b7d12ac-ae98-48ca-8c97-07a750431ca3', 'markers:preview', '2010-02-18 11:13:00', '2010-02-18 11:13:00'),
('4b8a6e76-f874-422b-a9ef-122c50431ca3', 'markers:mylist', '2010-02-28 14:24:06', '2010-02-28 14:24:06'),
('4b8a8c4b-8b84-4f66-8483-453a50431ca3', 'comments:delete', '2010-02-28 16:31:23', '2010-02-28 16:31:23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `processcats`
--

CREATE TABLE IF NOT EXISTS `processcats` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default '',
  `hex` varchar(6) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `processcats`
--

INSERT INTO `processcats` (`id`, `name`, `hex`) VALUES
(1, 'red alert', 'e90e0f'),
(2, 'status yellow', 'ffcc00'),
(3, 'status yellow 2', 'ffcc00'),
(4, 'not my problem', '8fe83b'),
(5, 'finished', '8fe83b'),
(6, 'archived', '6ba2d6');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` varchar(36) character set utf8 NOT NULL default '',
  `model_id` varchar(36) character set utf8 NOT NULL default '',
  `model` varchar(100) character set utf8 NOT NULL default '',
  `rating` tinyint(2) unsigned NOT NULL default '0',
  `name` varchar(100) character set utf8 default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `rating` (`model_id`,`model`,`rating`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=151 ;

--
-- Daten für Tabelle `ratings`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `search_index`
--

CREATE TABLE IF NOT EXISTS `search_index` (
  `id` int(10) NOT NULL auto_increment,
  `model` varchar(100) collate utf8_unicode_ci default NULL,
  `model_id` int(10) default NULL,
  `data` longtext collate utf8_unicode_ci,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `association_key` (`model`,`model_id`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;

--
-- Daten für Tabelle `search_index`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL auto_increment,
  `hash` varchar(255) default NULL,
  `data` varchar(255) default NULL,
  `created` datetime default NULL,
  `expires` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `tickets`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` varchar(36) collate utf8_unicode_ci NOT NULL default '',
  `user_id` varchar(36) collate utf8_unicode_ci NOT NULL default '',
  `name` varchar(255) character set utf8 default NULL,
  `marker_id` varchar(36) character set utf8 NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `transactions`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) collate utf8_unicode_ci NOT NULL,
  `email_address` varchar(127) collate utf8_unicode_ci NOT NULL,
  `password` varchar(40) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL default '0',
  `nickname` varchar(128) collate utf8_unicode_ci NOT NULL,
  `prename` varchar(127) collate utf8_unicode_ci NOT NULL,
  `sirname` varchar(128) collate utf8_unicode_ci NOT NULL,
  `fon` varchar(20) collate utf8_unicode_ci NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email_address`, `password`, `active`, `nickname`, `prename`, `sirname`, `fon`, `created`, `modified`) VALUES
('4ae48c76-2348-4cf4-a6d4-06eb510ab7ac', 'sysadmin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 1, 'SysAdmin', 'Achim', 'Admin', '', '2009-10-25 18:35:50', '2010-01-01 15:36:03'),
('4ae49e52-68d8-4d9f-927e-217d510ab7ac', 'admin@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 1, 'Admin', 'Martina', 'Mittag', '', '2009-10-25 19:52:02', '2010-01-16 06:32:50'),
('4b4c7acb-bd90-429d-b5f1-63dd50431ca3', 'user@markaspot.org', '1ce3468d1ebef012bb2c87fe7fb969414e34991d', 1, 'User', 'Max', 'Mustermann', '02232/233423453535', '2010-01-12 14:36:11', '2010-01-16 06:28:20');
