-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 25, 2013 at 05:00 PM
-- Server version: 5.1.72
-- PHP Version: 5.3.2-1ubuntu4.22

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kuluar`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminauth`
--

DROP TABLE IF EXISTS `adminauth`;
CREATE TABLE IF NOT EXISTS `adminauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `expire` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `adminauth`
--

INSERT INTO `adminauth` (`id`, `userid`, `hash`, `openid`, `expire`, `email`, `agent`, `ip`) VALUES
(1, 1, 'e6bf29338b93ab1242bff079be9cdf99', 'J7PKdyc20GK+fYanFZKZlr7tKQc=', 1417936617, 'flybots@gmail.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:25.0) Gecko/20100101 Firefox/25.0', '127.0.0.1'),
(2, 1, 'e380e327b22ea712cc4717041dee14a6', '7rT+I+RN715c3HibWBX104mXRwI=', 1418322637, 'flybots@gmail.com', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '127.0.0.1'),
(3, 1, '34b78ed8754ec6c75148b618b55aac09', 'cH6+uFPSiElWyoQX2Q0XfatemLo=', 1418883331, 'flybots@gmail.com', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:20.0) Gecko/20100101 Firefox/20.0', '127.0.0.1'),
(4, 14, '41de3209129d3d73b74b783b054b06e4', 'qZJgsT/lh6sKoo70XDwsD1QTn8U=', 1419495193, 'flybots@gmail.com', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:20.0) Gecko/20100101 Firefox/20.0', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `admindebug`
--

DROP TABLE IF EXISTS `admindebug`;
CREATE TABLE IF NOT EXISTS `admindebug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` longtext NOT NULL,
  `error` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `admindebug`
--

INSERT INTO `admindebug` (`id`, `date`, `text`, `error`) VALUES
(1, '2013-12-09 20:34:10', '[2013-12-09 20:34:10:751] Error while update row in DB\n[2013-12-09 20:34:10:774] \n', 1),
(2, '2013-12-09 20:34:18', '[2013-12-09 20:34:18:326] Error while update row in DB\n[2013-12-09 20:34:18:327] \n', 1),
(3, '2013-12-09 20:34:33', '[2013-12-09 20:34:33:653] Error while update row in DB\n[2013-12-09 20:34:33:653] \n', 1),
(4, '2013-12-09 20:34:43', '[2013-12-09 20:34:43:985] Error while update row in DB\n[2013-12-09 20:34:43:985] \n', 1),
(5, '2013-12-09 23:35:28', '[2013-12-09 23:35:28:556] Updater: initialized\n[2013-12-09 23:35:28:556] Updater: get current version: 2013-11-14 16:09:11\n[2013-12-09 23:35:28:556] Updater: cURL is exists\n[2013-12-09 23:35:28:556] Updater say: cURL доступен [green]\n[2013-12-09 23:35:28:556] Updater say: Phar (gz) поддерживается [green]\n[2013-12-09 23:35:28:556] Updater say: Версия вашего программного обеспечения: 2013-11-14 16:09:11 [green]\n[2013-12-09 23:35:28:886] Updater: get update data: {"date":"2013-11-18 12:09:43","md5":"e447d3333950dc12aeaa16a103aa27f0","available":"1","purpose":"<p>Fix login firm<\\/p><p>Fix auth sessions lifetime<\\/p><p>Fix request to i18n tables from functions.php<\\/p>","history":[{"date":"2013-11-18 12:09:43","md5":"e447d3333950dc12aeaa16a103aa27f0","available":"1","purpose":"<p>Fix login firm<\\/p><p>Fix auth sessions lifetime<\\/p><p>Fix request to i18n tables from functions.php<\\/p>","time":1384769383,"link":"http:\\/\\/update.computers.net.ua\\/getit.php?getit=1","wiki":"http:\\/\\/update.computers.net.ua\\/wiki\\/index.php\\/2013-11-18_12:09:43"},{"date":"2013-11-14 16:09:11","md5":"0a1c9a8e973f5e63827eba00c3cb4b40","available":"1","purpose":"<p>TODO<\\/p>","time":1384438151,"link":"http:\\/\\/update.computers.net.ua\\/getit.php?getit=1","wiki":"http:\\/\\/update.computers.net.ua\\/wiki\\/index.php\\/2013-11-14_16:09:11"}],"time":1384769383,"link":"http:\\/\\/update.computers.net.ua\\/getit.php?getit=1","wiki":"http:\\/\\/update.computers.net.ua\\/wiki\\/index.php\\/2013-11-18_12:09:43"}\n[2013-12-09 23:35:28:887] Updater say: Последняя доступная версия: 2013-11-18 12:09:43 [green]\n[2013-12-09 23:35:28:888] Updater error: Невозможна запись в директорию /home/serg/www/localhost/admin/common\n[2013-12-09 23:35:28:888] Updater error: Невозможна запись в директорию /home/serg/www/localhost/admin/bukups\n[2013-12-09 23:35:28:889] Updater error: Невозможна запись в директорию /home/serg/www/localhost/admin/temporal\n[2013-12-09 23:35:28:889] Updater say: Ваша система не готова к обновлениям. Отсутствуют необходимые права на запись в директории. [red]\n[2013-12-09 23:35:28:890] Updater: PreUpdate check is complete. System is not ready to update\n', 1),
(6, '2013-12-10 20:59:45', '[2013-12-10 20:59:45:934] Error while update row in DB\n[2013-12-10 20:59:45:934] \n', 1),
(7, '2013-12-10 20:59:55', '[2013-12-10 20:59:55:343] Error while update row in DB\n[2013-12-10 20:59:55:343] \n', 1),
(8, '2013-12-10 21:30:59', '[2013-12-10 21:30:59:370] Error while update row in DB\n[2013-12-10 21:30:59:370] \n', 1),
(9, '2013-12-10 21:31:20', '[2013-12-10 21:31:20:81] Error while update row in DB\n[2013-12-10 21:31:20:81] \n', 1),
(10, '2013-12-10 21:33:59', '[2013-12-10 21:33:59:45] Error while update row in DB\n[2013-12-10 21:33:59:45] \n', 1),
(11, '2013-12-17 19:56:41', '[2013-12-17 19:56:41:586] Error while update row in DB\n[2013-12-17 19:56:41:615] \n', 1),
(12, '2013-12-17 19:58:10', '[2013-12-17 19:58:10:131] Error while update row in DB\n[2013-12-17 19:58:10:131] \n', 1),
(13, '2013-12-17 20:02:25', '[2013-12-17 20:02:25:236] Error while update row in DB\n[2013-12-17 20:02:25:236] \n', 1),
(14, '2013-12-17 20:53:14', '[2013-12-17 20:53:14:971] Error while update row in DB\n[2013-12-17 20:53:14:971] \n', 1),
(15, '2013-12-17 20:56:53', '[2013-12-17 20:56:53:535] Error while update row in DB\n[2013-12-17 20:56:53:535] \n', 1),
(16, '2013-12-17 20:57:01', '[2013-12-17 20:57:01:173] Error while update row in DB\n[2013-12-17 20:57:01:174] \n', 1),
(17, '2013-12-17 21:00:13', '[2013-12-17 21:00:13:30] Error while update row in DB\n[2013-12-17 21:00:13:31] \n', 1),
(18, '2013-12-17 21:00:21', '[2013-12-17 21:00:21:540] Error while update row in DB\n[2013-12-17 21:00:21:540] \n', 1),
(19, '2013-12-17 21:01:21', '[2013-12-17 21:01:21:645] Error while update row in DB\n[2013-12-17 21:01:21:645] \n', 1),
(20, '2013-12-17 21:01:36', '[2013-12-17 21:01:36:726] Error while update row in DB\n[2013-12-17 21:01:36:726] \n', 1),
(21, '2013-12-17 21:01:45', '[2013-12-17 21:01:45:456] Error while update row in DB\n[2013-12-17 21:01:45:456] \n', 1),
(22, '2013-12-17 21:04:52', '[2013-12-17 21:04:52:218] Error while update row in DB\n[2013-12-17 21:04:52:218] \n', 1),
(23, '2013-12-17 21:07:38', '[2013-12-17 21:07:38:487] Error while update row in DB\n[2013-12-17 21:07:38:487] \n', 1),
(24, '2013-12-17 21:17:30', '[2013-12-17 21:17:30:292] Error while update row in DB\n[2013-12-17 21:17:30:293] \n', 1),
(25, '2013-12-17 21:18:25', '[2013-12-17 21:18:25:686] Error while update row in DB\n[2013-12-17 21:18:25:686] \n', 1),
(26, '2013-12-17 21:19:42', '[2013-12-17 21:19:42:439] Error while update row in DB\n[2013-12-17 21:19:42:440] \n', 1),
(27, '2013-12-17 21:25:24', '[2013-12-17 21:25:24:172] Error while update row in DB\n[2013-12-17 21:25:24:173] \n', 1),
(28, '2013-12-17 21:26:11', '[2013-12-17 21:26:11:290] Error while update row in DB\n[2013-12-17 21:26:11:290] \n', 1),
(29, '2013-12-17 21:29:14', '[2013-12-17 21:29:14:121] Error while update row in DB\n[2013-12-17 21:29:14:121] \n', 1),
(30, '2013-12-17 21:55:53', '[2013-12-17 21:55:53:75] Error while update row in DB\n[2013-12-17 21:55:53:76] \n', 1),
(31, '2013-12-17 21:59:22', '[2013-12-17 21:59:22:180] Error while update row in DB\n[2013-12-17 21:59:22:180] \n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `adminhistory`
--

DROP TABLE IF EXISTS `adminhistory`;
CREATE TABLE IF NOT EXISTS `adminhistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table` varchar(255) NOT NULL,
  `row_id` int(11) NOT NULL,
  `column` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `old_value` text NOT NULL,
  `new_value` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `table` (`table`),
  KEY `row_id` (`row_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=436 ;

--
-- Dumping data for table `adminhistory`
--

INSERT INTO `adminhistory` (`id`, `table`, `row_id`, `column`, `type`, `old_value`, `new_value`, `date`, `admin_id`) VALUES
(1, 'adminmenu', 156, 'id', 'delete_all', '156', '', '2013-12-07 07:44:25', 1),
(2, 'adminmenu', 156, 'name', 'data', 'Блог', '', '2013-12-07 07:44:25', 1),
(3, 'adminmenu', 156, 'descr', 'data', 'Блог на сайте', '', '2013-12-07 07:44:25', 1),
(4, 'adminmenu', 156, 'url', 'data', '/admin/blog/posts.php', '', '2013-12-07 07:44:25', 1),
(5, 'adminmenu', 156, 'priority', 'data', '19', '', '2013-12-07 07:44:25', 1),
(6, 'adminmenu', 157, 'id', 'delete_all', '157', '', '2013-12-07 07:44:31', 1),
(7, 'adminmenu', 157, 'name', 'data', 'Посты', '', '2013-12-07 07:44:31', 1),
(8, 'adminmenu', 157, 'parent', 'data', '156', '', '2013-12-07 07:44:31', 1),
(9, 'adminmenu', 157, 'descr', 'data', 'Посты в блоге', '', '2013-12-07 07:44:31', 1),
(10, 'adminmenu', 157, 'url', 'data', '/admin/blog/posts.php?orderby=id&desc=1', '', '2013-12-07 07:44:31', 1),
(11, 'adminmenu', 157, 'priority', 'data', '20', '', '2013-12-07 07:44:31', 1),
(12, 'adminmenu', 155, 'id', 'delete_all', '155', '', '2013-12-07 07:44:42', 1),
(13, 'adminmenu', 155, 'name', 'data', 'Цены iPhone iPad', '', '2013-12-07 07:44:42', 1),
(14, 'adminmenu', 155, 'descr', 'data', 'Специально для Димы', '', '2013-12-07 07:44:42', 1),
(15, 'adminmenu', 155, 'url', 'data', 'http://computers.net.ua/admin/static/static.php?menuxxx=5&page_name=%D0%A6%D0%B5%D0%BD%D1%8B%20%D0%BD%D0%B0%20iPad,%D0%9C%D0%BE%D0%B1%D0%B8%D0%BB%D1%8C%D0%BD%D1%8B%D0%B5%20iPhone,%D0%9F%D0%BB%D0%B0%D0%BD%D1%88%D0%B5%D1%82%D1%8B%20The%20new%20iPad%203', '', '2013-12-07 07:44:42', 1),
(16, 'adminmenu', 155, 'priority', 'data', '18', '', '2013-12-07 07:44:42', 1),
(17, 'adminmenu', 158, 'id', 'delete_all', '158', '', '2013-12-07 07:44:48', 1),
(18, 'adminmenu', 158, 'name', 'data', 'Тэги', '', '2013-12-07 07:44:48', 1),
(19, 'adminmenu', 158, 'parent', 'data', '156', '', '2013-12-07 07:44:48', 1),
(20, 'adminmenu', 158, 'descr', 'data', 'Теги блога', '', '2013-12-07 07:44:48', 1),
(21, 'adminmenu', 158, 'url', 'data', '/admin/blog/tags.php', '', '2013-12-07 07:44:48', 1),
(22, 'adminmenu', 158, 'priority', 'data', '21', '', '2013-12-07 07:44:48', 1),
(23, 'adminmenu', 159, 'id', 'delete_all', '159', '', '2013-12-07 07:45:09', 1),
(24, 'adminmenu', 159, 'name', 'data', 'Разделы', '', '2013-12-07 07:45:09', 1),
(25, 'adminmenu', 159, 'parent', 'data', '156', '', '2013-12-07 07:45:09', 1),
(26, 'adminmenu', 159, 'descr', 'data', 'Разделы блога', '', '2013-12-07 07:45:09', 1),
(27, 'adminmenu', 159, 'url', 'data', '/admin/blog/headings.php', '', '2013-12-07 07:45:09', 1),
(28, 'adminmenu', 159, 'priority', 'data', '22', '', '2013-12-07 07:45:09', 1),
(29, 'adminmenu', 160, 'id', 'delete_all', '160', '', '2013-12-07 07:45:13', 1),
(30, 'adminmenu', 160, 'name', 'data', 'Параметры', '', '2013-12-07 07:45:13', 1),
(31, 'adminmenu', 160, 'parent', 'data', '156', '', '2013-12-07 07:45:13', 1),
(32, 'adminmenu', 160, 'descr', 'data', 'Настройка параметров блога', '', '2013-12-07 07:45:13', 1),
(33, 'adminmenu', 160, 'url', 'data', '/admin/blog/config.php', '', '2013-12-07 07:45:13', 1),
(34, 'adminmenu', 160, 'priority', 'data', '23', '', '2013-12-07 07:45:13', 1),
(35, 'adminmenu', 161, 'id', 'delete_all', '161', '', '2013-12-07 07:45:17', 1),
(36, 'adminmenu', 161, 'name', 'data', 'Магазин', '', '2013-12-07 07:45:17', 1),
(37, 'adminmenu', 161, 'descr', 'data', 'Магазин на сайте', '', '2013-12-07 07:45:17', 1),
(38, 'adminmenu', 161, 'url', 'data', '/admin/shop/category.php', '', '2013-12-07 07:45:17', 1),
(39, 'adminmenu', 161, 'priority', 'data', '24', '', '2013-12-07 07:45:17', 1),
(40, 'adminmenu', 176, 'id', 'delete_all', '176', '', '2013-12-07 07:45:23', 1),
(41, 'adminmenu', 176, 'name', 'data', 'Магазин - заказы', '', '2013-12-07 07:45:23', 1),
(42, 'adminmenu', 176, 'descr', 'data', 'Заказы в магазине', '', '2013-12-07 07:45:23', 1),
(43, 'adminmenu', 176, 'url', 'data', '/admin/shop/orders.php', '', '2013-12-07 07:45:23', 1),
(44, 'adminmenu', 176, 'priority', 'data', '25', '', '2013-12-07 07:45:23', 1),
(45, 'adminmenu', 162, 'id', 'delete_all', '162', '', '2013-12-07 07:45:30', 1),
(46, 'adminmenu', 162, 'name', 'data', 'Категории', '', '2013-12-07 07:45:30', 1),
(47, 'adminmenu', 162, 'parent', 'data', '161', '', '2013-12-07 07:45:30', 1),
(48, 'adminmenu', 162, 'descr', 'data', 'Категории товаров в магазине', '', '2013-12-07 07:45:30', 1),
(49, 'adminmenu', 162, 'url', 'data', '/admin/shop/category.php', '', '2013-12-07 07:45:30', 1),
(50, 'adminmenu', 162, 'priority', 'data', '27', '', '2013-12-07 07:45:30', 1),
(51, 'adminmenu', 163, 'id', 'delete_all', '163', '', '2013-12-07 07:45:42', 1),
(52, 'adminmenu', 163, 'name', 'data', 'Продукты', '', '2013-12-07 07:45:42', 1),
(53, 'adminmenu', 163, 'parent', 'data', '161', '', '2013-12-07 07:45:42', 1),
(54, 'adminmenu', 163, 'descr', 'data', 'Продукты доступные в магазине', '', '2013-12-07 07:45:42', 1),
(55, 'adminmenu', 163, 'url', 'data', '/admin/shop/products.php', '', '2013-12-07 07:45:42', 1),
(56, 'adminmenu', 163, 'priority', 'data', '28', '', '2013-12-07 07:45:42', 1),
(57, 'adminmenu', 164, 'id', 'delete_all', '164', '', '2013-12-07 07:45:46', 1),
(58, 'adminmenu', 164, 'name', 'data', 'Фотографии', '', '2013-12-07 07:45:46', 1),
(59, 'adminmenu', 164, 'parent', 'data', '161', '', '2013-12-07 07:45:46', 1),
(60, 'adminmenu', 164, 'descr', 'data', 'Фотографии продуктов и категорий', '', '2013-12-07 07:45:46', 1),
(61, 'adminmenu', 164, 'url', 'data', '/admin/shop/photo.php', '', '2013-12-07 07:45:46', 1),
(62, 'adminmenu', 164, 'priority', 'data', '29', '', '2013-12-07 07:45:46', 1),
(63, 'adminmenu', 165, 'id', 'delete_all', '165', '', '2013-12-07 07:45:51', 1),
(64, 'adminmenu', 165, 'name', 'data', 'Валюты', '', '2013-12-07 07:45:51', 1),
(65, 'adminmenu', 165, 'parent', 'data', '161', '', '2013-12-07 07:45:51', 1),
(66, 'adminmenu', 165, 'descr', 'data', 'Валюты, доступные в магазине', '', '2013-12-07 07:45:51', 1),
(67, 'adminmenu', 165, 'url', 'data', '/admin/shop/currency.php', '', '2013-12-07 07:45:51', 1),
(68, 'adminmenu', 165, 'priority', 'data', '30', '', '2013-12-07 07:45:51', 1),
(69, 'adminmenu', 166, 'id', 'delete_all', '166', '', '2013-12-07 07:45:54', 1),
(70, 'adminmenu', 166, 'name', 'data', 'Курсы валют', '', '2013-12-07 07:45:54', 1),
(71, 'adminmenu', 166, 'parent', 'data', '161', '', '2013-12-07 07:45:54', 1),
(72, 'adminmenu', 166, 'descr', 'data', 'Множители при преобразовании валют', '', '2013-12-07 07:45:54', 1),
(73, 'adminmenu', 166, 'url', 'data', '/admin/shop/exchange.php', '', '2013-12-07 07:45:54', 1),
(74, 'adminmenu', 166, 'priority', 'data', '31', '', '2013-12-07 07:45:54', 1),
(75, 'adminmenu', 167, 'id', 'delete_all', '167', '', '2013-12-07 07:45:59', 1),
(76, 'adminmenu', 167, 'name', 'data', 'Фильтр - типы', '', '2013-12-07 07:45:59', 1),
(77, 'adminmenu', 167, 'parent', 'data', '161', '', '2013-12-07 07:45:59', 1),
(78, 'adminmenu', 167, 'descr', 'data', 'Типы параметров фильтра продуктов', '', '2013-12-07 07:45:59', 1),
(79, 'adminmenu', 167, 'url', 'data', '/admin/shop/filter/parameters.php', '', '2013-12-07 07:45:59', 1),
(80, 'adminmenu', 167, 'priority', 'data', '32', '', '2013-12-07 07:45:59', 1),
(81, 'adminmenu', 168, 'id', 'delete_all', '168', '', '2013-12-07 07:46:03', 1),
(82, 'adminmenu', 168, 'name', 'data', 'Фильтр - значения', '', '2013-12-07 07:46:03', 1),
(83, 'adminmenu', 168, 'parent', 'data', '161', '', '2013-12-07 07:46:03', 1),
(84, 'adminmenu', 168, 'descr', 'data', 'Доступные значения для фильтрования', '', '2013-12-07 07:46:03', 1),
(85, 'adminmenu', 168, 'url', 'data', '/admin/shop/filter/values.php', '', '2013-12-07 07:46:03', 1),
(86, 'adminmenu', 168, 'priority', 'data', '33', '', '2013-12-07 07:46:03', 1),
(87, 'adminmenu', 169, 'id', 'delete_all', '169', '', '2013-12-07 07:46:07', 1),
(88, 'adminmenu', 169, 'name', 'data', 'Цвета', '', '2013-12-07 07:46:07', 1),
(89, 'adminmenu', 169, 'parent', 'data', '161', '', '2013-12-07 07:46:07', 1),
(90, 'adminmenu', 169, 'descr', 'data', 'Управление доступными цветами товаров', '', '2013-12-07 07:46:07', 1),
(91, 'adminmenu', 169, 'url', 'data', '/admin/shop/colors.php', '', '2013-12-07 07:46:07', 1),
(92, 'adminmenu', 169, 'priority', 'data', '34', '', '2013-12-07 07:46:07', 1),
(93, 'adminmenu', 170, 'id', 'delete_all', '170', '', '2013-12-07 07:46:10', 1),
(94, 'adminmenu', 170, 'name', 'data', 'Видео', '', '2013-12-07 07:46:10', 1),
(95, 'adminmenu', 170, 'parent', 'data', '161', '', '2013-12-07 07:46:10', 1),
(96, 'adminmenu', 170, 'descr', 'data', 'Видео к продуктам', '', '2013-12-07 07:46:10', 1),
(97, 'adminmenu', 170, 'url', 'data', '/admin/shop/video.php', '', '2013-12-07 07:46:10', 1),
(98, 'adminmenu', 170, 'priority', 'data', '34', '', '2013-12-07 07:46:10', 1),
(99, 'adminmenu', 171, 'id', 'delete_all', '171', '', '2013-12-07 07:46:14', 1),
(100, 'adminmenu', 171, 'name', 'data', 'Фильтр - группы', '', '2013-12-07 07:46:14', 1),
(101, 'adminmenu', 171, 'parent', 'data', '161', '', '2013-12-07 07:46:14', 1),
(102, 'adminmenu', 171, 'descr', 'data', 'Группы параметров фильтров', '', '2013-12-07 07:46:14', 1),
(103, 'adminmenu', 171, 'url', 'data', '/admin/shop/filter/groups.php', '', '2013-12-07 07:46:14', 1),
(104, 'adminmenu', 171, 'priority', 'data', '35', '', '2013-12-07 07:46:14', 1),
(105, 'adminmenu', 172, 'id', 'delete_all', '172', '', '2013-12-07 07:46:18', 1),
(106, 'adminmenu', 172, 'name', 'data', 'Доставка (типы)', '', '2013-12-07 07:46:18', 1),
(107, 'adminmenu', 172, 'parent', 'data', '161', '', '2013-12-07 07:46:18', 1),
(108, 'adminmenu', 172, 'descr', 'data', 'Варианты доставки', '', '2013-12-07 07:46:18', 1),
(109, 'adminmenu', 172, 'url', 'data', '/admin/shop/delivery.php', '', '2013-12-07 07:46:18', 1),
(110, 'adminmenu', 172, 'priority', 'data', '36', '', '2013-12-07 07:46:18', 1),
(111, 'adminmenu', 173, 'id', 'delete_all', '173', '', '2013-12-07 07:46:26', 1),
(112, 'adminmenu', 173, 'name', 'data', 'Доставка (поля)', '', '2013-12-07 07:46:26', 1),
(113, 'adminmenu', 173, 'parent', 'data', '161', '', '2013-12-07 07:46:26', 1),
(114, 'adminmenu', 173, 'descr', 'data', 'Поля для типов доставок', '', '2013-12-07 07:46:26', 1),
(115, 'adminmenu', 173, 'url', 'data', '/admin/shop/delivery_fields.php', '', '2013-12-07 07:46:26', 1),
(116, 'adminmenu', 173, 'priority', 'data', '37', '', '2013-12-07 07:46:26', 1),
(117, 'adminmenu', 174, 'id', 'delete_all', '174', '', '2013-12-07 07:46:30', 1),
(118, 'adminmenu', 174, 'name', 'data', 'Статусы заказов', '', '2013-12-07 07:46:30', 1),
(119, 'adminmenu', 174, 'parent', 'data', '161', '', '2013-12-07 07:46:30', 1),
(120, 'adminmenu', 174, 'descr', 'data', 'Статусы для заказов', '', '2013-12-07 07:46:30', 1),
(121, 'adminmenu', 174, 'url', 'data', '/admin/shop/order_statuses.php', '', '2013-12-07 07:46:30', 1),
(122, 'adminmenu', 174, 'priority', 'data', '38', '', '2013-12-07 07:46:30', 1),
(123, 'adminmenu', 175, 'id', 'delete_all', '175', '', '2013-12-07 07:46:33', 1),
(124, 'adminmenu', 175, 'name', 'data', 'Продукты на главной', '', '2013-12-07 07:46:33', 1),
(125, 'adminmenu', 175, 'parent', 'data', '161', '', '2013-12-07 07:46:33', 1),
(126, 'adminmenu', 175, 'descr', 'data', 'Продукты на главной', '', '2013-12-07 07:46:33', 1),
(127, 'adminmenu', 175, 'url', 'data', '/admin/shop/products_main.php', '', '2013-12-07 07:46:33', 1),
(128, 'adminmenu', 175, 'priority', 'data', '39', '', '2013-12-07 07:46:33', 1),
(129, 'adminmenu', 177, 'id', 'delete_all', '177', '', '2013-12-07 07:46:45', 1),
(130, 'adminmenu', 177, 'name', 'data', 'Заказы', '', '2013-12-07 07:46:45', 1),
(131, 'adminmenu', 177, 'parent', 'data', '176', '', '2013-12-07 07:46:45', 1),
(132, 'adminmenu', 177, 'descr', 'data', 'Заказы в магазине', '', '2013-12-07 07:46:45', 1),
(133, 'adminmenu', 177, 'url', 'data', '/admin/shop/orders.php', '', '2013-12-07 07:46:45', 1),
(134, 'adminmenu', 177, 'priority', 'data', '40', '', '2013-12-07 07:46:45', 1),
(135, 'adminmenu', 178, 'id', 'delete_all', '178', '', '2013-12-07 07:46:50', 1),
(136, 'adminmenu', 178, 'name', 'data', 'Заполненные поля', '', '2013-12-07 07:46:50', 1),
(137, 'adminmenu', 178, 'parent', 'data', '176', '', '2013-12-07 07:46:50', 1),
(138, 'adminmenu', 178, 'descr', 'data', 'Бардак!!!', '', '2013-12-07 07:46:50', 1),
(139, 'adminmenu', 178, 'url', 'data', '/admin/shop/order_fields.php', '', '2013-12-07 07:46:50', 1),
(140, 'adminmenu', 178, 'priority', 'data', '41', '', '2013-12-07 07:46:50', 1),
(141, 'adminmenu', 179, 'id', 'delete_all', '179', '', '2013-12-07 07:46:54', 1),
(142, 'adminmenu', 179, 'name', 'data', 'Группы категорий', '', '2013-12-07 07:46:54', 1),
(143, 'adminmenu', 179, 'parent', 'data', '161', '', '2013-12-07 07:46:54', 1),
(144, 'adminmenu', 179, 'descr', 'data', 'Боковое меню магазина', '', '2013-12-07 07:46:54', 1),
(145, 'adminmenu', 179, 'url', 'data', '/admin/shop/shop_menu.php', '', '2013-12-07 07:46:54', 1),
(146, 'adminmenu', 179, 'priority', 'data', '42', '', '2013-12-07 07:46:54', 1),
(147, 'adminmenu', 181, 'id', 'delete_all', '181', '', '2013-12-07 07:47:19', 1),
(148, 'adminmenu', 181, 'name', 'data', 'Сообщения', '', '2013-12-07 07:47:19', 1),
(149, 'adminmenu', 181, 'parent', 'data', '179', '', '2013-12-07 07:47:19', 1),
(150, 'adminmenu', 181, 'descr', 'data', 'Сообщения (комменты)', '', '2013-12-07 07:47:19', 1),
(151, 'adminmenu', 181, 'url', 'data', '/admin/comments/messages.php', '', '2013-12-07 07:47:19', 1),
(152, 'adminmenu', 181, 'priority', 'data', '44', '', '2013-12-07 07:47:19', 1),
(153, 'adminmenu', 182, 'parent', 'data', '179', '0', '2013-12-07 07:48:32', 1),
(154, 'adminmenu', 183, 'parent', 'data', '179', '0', '2013-12-07 07:48:58', 1),
(155, 'adminmenu', 192, 'id', 'delete_all', '192', '', '2013-12-07 07:51:20', 1),
(156, 'adminmenu', 192, 'name', 'data', 'Тестовые задания', '', '2013-12-07 07:51:20', 1),
(157, 'adminmenu', 192, 'parent', 'data', '186', '', '2013-12-07 07:51:20', 1),
(158, 'adminmenu', 192, 'descr', 'data', '...', '', '2013-12-07 07:51:20', 1),
(159, 'adminmenu', 192, 'url', 'data', '/admin/job/test-tasks.php', '', '2013-12-07 07:51:20', 1),
(160, 'adminmenu', 192, 'priority', 'data', '55', '', '2013-12-07 07:51:20', 1),
(161, 'adminmenu', 191, 'id', 'delete_all', '191', '', '2013-12-07 07:51:24', 1),
(162, 'adminmenu', 191, 'name', 'data', 'Статусы кандидатов', '', '2013-12-07 07:51:24', 1),
(163, 'adminmenu', 191, 'parent', 'data', '186', '', '2013-12-07 07:51:24', 1),
(164, 'adminmenu', 191, 'descr', 'data', '...', '', '2013-12-07 07:51:24', 1),
(165, 'adminmenu', 191, 'url', 'data', '/admin/job/status.php', '', '2013-12-07 07:51:24', 1),
(166, 'adminmenu', 191, 'priority', 'data', '54', '', '2013-12-07 07:51:24', 1),
(167, 'adminmenu', 190, 'id', 'delete_all', '190', '', '2013-12-07 07:51:36', 1),
(168, 'adminmenu', 190, 'name', 'data', 'Настройка писем', '', '2013-12-07 07:51:36', 1),
(169, 'adminmenu', 190, 'parent', 'data', '186', '', '2013-12-07 07:51:36', 1),
(170, 'adminmenu', 190, 'descr', 'data', '...', '', '2013-12-07 07:51:36', 1),
(171, 'adminmenu', 190, 'url', 'data', '/admin/job/mail_config.php', '', '2013-12-07 07:51:36', 1),
(172, 'adminmenu', 190, 'priority', 'data', '53', '', '2013-12-07 07:51:36', 1),
(173, 'adminmenu', 189, 'id', 'delete_all', '189', '', '2013-12-07 07:51:40', 1),
(174, 'adminmenu', 189, 'name', 'data', 'FAQ', '', '2013-12-07 07:51:40', 1),
(175, 'adminmenu', 189, 'parent', 'data', '186', '', '2013-12-07 07:51:40', 1),
(176, 'adminmenu', 189, 'descr', 'data', '...', '', '2013-12-07 07:51:40', 1),
(177, 'adminmenu', 189, 'url', 'data', '/admin/job/faq.php', '', '2013-12-07 07:51:40', 1),
(178, 'adminmenu', 189, 'priority', 'data', '52', '', '2013-12-07 07:51:40', 1),
(179, 'adminmenu', 188, 'id', 'delete_all', '188', '', '2013-12-07 07:51:44', 1),
(180, 'adminmenu', 188, 'name', 'data', 'Кандидаты', '', '2013-12-07 07:51:44', 1),
(181, 'adminmenu', 188, 'parent', 'data', '186', '', '2013-12-07 07:51:44', 1),
(182, 'adminmenu', 188, 'descr', 'data', '...', '', '2013-12-07 07:51:44', 1),
(183, 'adminmenu', 188, 'url', 'data', '/admin/job/candidat.php', '', '2013-12-07 07:51:44', 1),
(184, 'adminmenu', 188, 'priority', 'data', '51', '', '2013-12-07 07:51:44', 1),
(185, 'adminmenu', 187, 'id', 'delete_all', '187', '', '2013-12-07 07:51:48', 1),
(186, 'adminmenu', 187, 'name', 'data', 'Вакансии', '', '2013-12-07 07:51:48', 1),
(187, 'adminmenu', 187, 'parent', 'data', '186', '', '2013-12-07 07:51:48', 1),
(188, 'adminmenu', 187, 'descr', 'data', '...', '', '2013-12-07 07:51:48', 1),
(189, 'adminmenu', 187, 'url', 'data', '/admin/job/job.php', '', '2013-12-07 07:51:48', 1),
(190, 'adminmenu', 187, 'priority', 'data', '50', '', '2013-12-07 07:51:48', 1),
(191, 'adminmenu', 186, 'id', 'delete_all', '186', '', '2013-12-07 07:51:52', 1),
(192, 'adminmenu', 186, 'name', 'data', 'Вакансии', '', '2013-12-07 07:51:52', 1),
(193, 'adminmenu', 186, 'descr', 'data', '...', '', '2013-12-07 07:51:52', 1),
(194, 'adminmenu', 186, 'url', 'data', '/admin/job/job.php', '', '2013-12-07 07:51:52', 1),
(195, 'adminmenu', 186, 'priority', 'data', '49', '', '2013-12-07 07:51:52', 1),
(196, 'adminmenu', 183, 'parent', 'data', '0', '180', '2013-12-07 07:53:15', 1),
(197, 'menu', 1, 'id', 'add_new', '', '1', '2013-12-07 11:43:19', 1),
(198, 'pages', 1, 'id', 'add_new', '', '1', '2013-12-07 16:15:48', 1),
(199, 'menu', 1, 'parent', 'data', '0', '1', '2013-12-07 16:17:10', 1),
(200, 'menu', 1, 'parent', 'data', '1', '', '2013-12-07 16:17:17', 1),
(201, 'menu', 2, 'id', 'add_new', '', '2', '2013-12-07 17:57:17', 1),
(202, 'pages', 1, 'menu_id', 'data', '1', '2', '2013-12-07 17:57:29', 1),
(203, 'adminmenu', 193, 'id', 'add_new', '', '193', '2013-12-07 21:17:59', 1),
(204, 'menu_types', 1, 'id', 'add_new', '', '1', '2013-12-07 21:22:52', 1),
(205, 'menu_types', 2, 'id', 'add_new', '', '2', '2013-12-07 21:23:05', 1),
(206, 'menu', 2, 'url', 'data', 'main', '', '2013-12-07 21:24:50', 1),
(207, 'adminmenu', 44, 'url', 'data', '/admin/menus.php', '/admin//site_menu.php', '2013-12-07 21:31:05', 1),
(208, 'menu', 3, 'id', 'add_new', '', '3', '2013-12-07 21:39:30', 1),
(209, 'menu', 1, 'name', 'data', 'First menu item', 'Крым', '2013-12-07 21:39:52', 1),
(210, 'menu', 1, 'desc', 'data', '', 'Крым', '2013-12-07 21:39:52', 1),
(211, 'menu', 1, 'url', 'data', '', 'region', '2013-12-07 21:39:52', 1),
(212, 'menu', 1, 'type_id', 'data', '0', '1', '2013-12-07 21:39:52', 1),
(213, 'menu', 1, 'url', 'data', 'region', 'region/krimea', '2013-12-07 21:40:22', 1),
(214, 'menu', 1, 'url', 'data', 'region/krimea', '/region/krimea', '2013-12-07 21:41:16', 1),
(215, 'menu', 2, 'name', 'data', 'Second menu item', 'Маршруты', '2013-12-07 21:42:39', 1),
(216, 'menu', 2, 'desc', 'data', '', 'Маршруты', '2013-12-07 21:42:39', 1),
(217, 'menu', 2, 'url', 'data', '', '/hike/krimea', '2013-12-07 21:42:39', 1),
(218, 'menu', 2, 'type_id', 'data', '0', '1', '2013-12-07 21:42:39', 1),
(219, 'menu', 3, 'name', 'data', 'Крым', 'Отзывы', '2013-12-07 21:47:24', 1),
(220, 'menu', 3, 'desc', 'data', 'Крым', 'Отзывы', '2013-12-07 21:47:24', 1),
(221, 'menu', 3, 'url', 'data', 'region', 'feedback/krimea', '2013-12-07 21:47:24', 1),
(222, 'menu', 2, 'parent', 'data', '0', '1', '2013-12-07 21:49:59', 1),
(223, 'menu', 3, 'parent', 'data', '0', '1', '2013-12-07 21:50:10', 1),
(224, 'menu', 4, 'id', 'add_new', '', '4', '2013-12-07 21:53:31', 1),
(225, 'menu', 5, 'id', 'add_new', '', '5', '2013-12-07 21:55:20', 1),
(226, 'menu', 6, 'id', 'add_new', '', '6', '2013-12-07 21:56:23', 1),
(227, 'menu', 7, 'id', 'add_new', '', '7', '2013-12-07 21:57:14', 1),
(228, 'adminmenu', 194, 'id', 'add_new', '', '194', '2013-12-07 22:01:17', 1),
(229, 'menu', 3, 'url', 'data', 'feedback/krimea', '/feedback/krimea', '2013-12-07 23:32:47', 1),
(230, 'menu', 4, 'url', 'data', 'features/krimea', '/features/krimea', '2013-12-07 23:32:56', 1),
(231, 'menu', 3, 'url', 'data', '/feedback/krimea', '/review/krimea', '2013-12-07 23:37:20', 1),
(232, 'menu', 2, 'url', 'data', '/hike/krimea', '/route/krimea', '2013-12-07 23:51:09', 1),
(233, 'adminmenu', 195, 'id', 'add_new', '', '195', '2013-12-08 09:56:30', 1),
(234, 'article_types', 1, 'id', 'add_new', '', '1', '2013-12-08 10:09:38', 1),
(235, 'adminmenu', 194, 'url', 'data', '/admin/articles/posts.php', '/admin/articles/articles.php', '2013-12-08 17:36:51', 1),
(236, 'articles', 1, 'id', 'add_new', '', '1', '2013-12-08 19:11:46', 1),
(237, 'articles', 1, 'article_type', 'data', '0', '1', '2013-12-08 19:12:07', 1),
(238, 'articles', 1, 'text_short', 'data', '', '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '2013-12-08 19:14:33', 1),
(239, 'articles', 1, 'text_long', 'data', '', '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '2013-12-08 19:14:33', 1),
(240, 'articles', 1, 'text_short', 'data', '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '', '2013-12-08 19:15:04', 1),
(241, 'articles', 1, 'thumb', 'data', '', '/files/articles/1386524417_92.jpg', '2013-12-08 19:40:17', 1),
(242, 'articles', 1, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/articles/1386524417_92.jpg', '2013-12-08 19:40:17', 1),
(243, 'articles', 1, 'thumb', 'data', '/files/articles/1386524417_92.jpg', '/files/articles/1386524721_41.jpg', '2013-12-08 19:45:21', 1),
(244, 'articles', 1, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1386524417_92.jpg', '/home/serg/www/localhost/files/articles/1386524721_41.jpg', '2013-12-08 19:45:21', 1),
(245, 'articles', 1, 'thumb', 'data', '/files/articles/1386524721_41.jpg', '', '2013-12-08 19:45:55', 1),
(246, 'articles', 1, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1386524721_41.jpg', '', '2013-12-08 19:45:55', 1),
(247, 'articles', 1, 'thumb', 'data', '', '/files/articles/1386524812_48.jpg', '2013-12-08 19:46:52', 1),
(248, 'articles', 1, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/articles/1386524812_48.jpg', '2013-12-08 19:46:52', 1),
(249, 'articles', 1, 'thumb', 'data', '/files/articles/1386524812_48.jpg', '/files/articles/1386524851_16.jpg', '2013-12-08 19:47:31', 1),
(250, 'articles', 1, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1386524812_48.jpg', '/home/serg/www/localhost/files/articles/1386524851_16.jpg', '2013-12-08 19:47:31', 1),
(251, 'articles', 1, 'thumb', 'data', '/files/articles/1386524851_16.jpg', '/files/articles/1386525626_24.jpg', '2013-12-08 20:00:26', 1),
(252, 'articles', 1, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1386524851_16.jpg', '/home/serg/www/localhost/files/articles/1386525626_24.jpg', '2013-12-08 20:00:26', 1),
(253, 'articles', 1, 'text_short', 'data', '', '<p>Кількасот людей повалили пам&#39;ятник Леніну на Бессарабці. Перед цим опозиція та мітингувальники заблокували урядовий квартал: встановили намети та побудували барикади біля Верховної Ради, Кабміну та Адміністрації президента.</p>', '2013-12-08 21:19:56', 1),
(254, 'articles', 1, 'keywords', 'data', '', 'Крым, Форос, article', '2013-12-08 21:19:56', 1),
(255, 'articles', 1, 'text_short', 'data', '<p>Кількасот людей повалили пам&#39;ятник Леніну на Бессарабці. Перед цим опозиція та мітингувальники заблокували урядовий квартал: встанови', '<p>Як повідомляє &quot;Інтерфакс-Україна&quot;, міліція відкрила кримінальне провадження через знесення пам&rsquo;ятника Леніну за частиною 1 статті 294 Кримінального кодексу &ndash; масові безлади, проте поки затриманих немає.</p><p>Щоб ви розуміли: ЖОДНОГО міліціонера біля Леніна зараз немає. Жодного. Проїжджаючи, всі сигналять. Народу - чоловік 500 тих, що співають гімн, кричать &quot;слава нації - смерть ворогам&quot;, &quot;героям слава&quot;, &quot;Україна понад усе&quot;. Хтось рубає Леніна. За кожним шматочком вгору здіймаються сотні рук.</p>', '2013-12-08 21:22:24', 1),
(256, 'articles', 1, 'text_short', 'data', '<p>Як повідомляє &quot;Інтерфакс-Україна&quot;, міліція відкрила кримінальне провадження через знесення пам&rsquo;ятника Леніну за частиною 1 статт', '<p>Як повідомляє &quot;Інтерфакс-Україна&quot;, міліція відкрила кримінальне провадження через знесення пам&rsquo;ятника Леніну за частиною 1 статті 294 Кримінального кодексу &ndash; масові безлади, проте поки затриманих немає.</p><p>Щоб ви розуміли: ЖОДНОГО міліціонера біля Леніна зараз немає. Жодного. Проїжджаючи, всі сигналять. Народу - чоловік 500 тих, що співають гімн, кричать &quot;слава нації - смерть ворогам&quot;, &quot;героям слава&quot;, &quot;Україна понад усе&quot;. Хтось рубає Леніна. За кожним шматочком вгору здіймаються сотні рук.</p>', '2013-12-08 21:23:37', 1),
(257, 'menu', 5, 'url', 'data', 'articles', '/articles', '2013-12-09 20:34:10', 1),
(258, 'menu', 6, 'url', 'data', 'about', '/about', '2013-12-09 20:34:18', 1),
(259, 'menu', 5, 'url', 'data', 'articles', '/articles/', '2013-12-09 20:34:33', 1),
(260, 'menu', 7, 'url', 'data', 'faq', '/faq', '2013-12-09 20:34:43', 1),
(261, 'menu', 8, 'id', 'add_new', '', '8', '2013-12-09 20:54:17', 1),
(262, 'menu', 9, 'id', 'add_new', '', '9', '2013-12-09 20:54:53', 1),
(263, 'menu', 9, 'parent_id', 'data', '0', '1', '2013-12-09 20:57:20', 1),
(264, 'menu', 10, 'id', 'add_new', '', '10', '2013-12-09 20:58:02', 1),
(265, 'menu', 9, 'parent_id', 'data', '1', '8', '2013-12-09 20:58:09', 1),
(266, 'menu', 11, 'id', 'add_new', '', '11', '2013-12-09 20:58:49', 1),
(267, 'menu', 5, 'id', 'delete_all', '5', '', '2013-12-09 21:32:24', 1),
(268, 'menu', 5, 'name', 'data', 'Статьи', '', '2013-12-09 21:32:24', 1),
(269, 'menu', 5, 'desc', 'data', 'Статьи', '', '2013-12-09 21:32:24', 1),
(270, 'menu', 5, 'url', 'data', 'articles', '', '2013-12-09 21:32:24', 1),
(271, 'menu', 5, 'type_id', 'data', '2', '', '2013-12-09 21:32:24', 1),
(272, 'menu', 5, 'priority', 'data', '4', '', '2013-12-09 21:32:24', 1),
(273, 'menu', 6, 'id', 'delete_all', '6', '', '2013-12-09 21:32:27', 1),
(274, 'menu', 6, 'name', 'data', 'О нас', '', '2013-12-09 21:32:27', 1),
(275, 'menu', 6, 'desc', 'data', 'О нас', '', '2013-12-09 21:32:27', 1),
(276, 'menu', 6, 'url', 'data', 'about', '', '2013-12-09 21:32:27', 1),
(277, 'menu', 6, 'type_id', 'data', '2', '', '2013-12-09 21:32:27', 1),
(278, 'menu', 6, 'priority', 'data', '5', '', '2013-12-09 21:32:27', 1),
(279, 'menu', 7, 'id', 'delete_all', '7', '', '2013-12-09 21:32:30', 1),
(280, 'menu', 7, 'name', 'data', 'ЧАВо', '', '2013-12-09 21:32:30', 1),
(281, 'menu', 7, 'desc', 'data', 'ЧАВо', '', '2013-12-09 21:32:30', 1),
(282, 'menu', 7, 'url', 'data', 'faq', '', '2013-12-09 21:32:30', 1),
(283, 'menu', 7, 'type_id', 'data', '2', '', '2013-12-09 21:32:30', 1),
(284, 'menu', 7, 'priority', 'data', '6', '', '2013-12-09 21:32:30', 1),
(285, 'adminmenu', 194, 'url', 'data', '/admin/articles/articles.php', '/admin/article/article.php', '2013-12-09 22:57:34', 1),
(286, 'adminmenu', 195, 'url', 'data', '/admin/articles/types.php', '/admin/article/types.php', '2013-12-09 22:57:46', 1),
(287, 'pages', 1, 'page_link', 'data', 'p1', 'about', '2013-12-10 21:30:59', 1),
(288, 'pages', 1, 'page_link', 'data', 'p1', 'about', '2013-12-10 21:31:20', 1),
(289, 'pages', 1, 'page_link', 'data', 'p1', 'about', '2013-12-10 21:33:59', 1),
(290, 'pages', 1, 'menu_id', 'data', '2', '0', '2013-12-10 21:33:59', 1),
(291, 'adminmenu', 194, 'url', 'data', '/admin/article/article.php', '/admin/articles/article.php', '2013-12-10 22:57:09', 1),
(292, 'adminmenu', 195, 'url', 'data', '/admin/article/types.php', '/admin/articles/types.php', '2013-12-10 22:57:17', 1),
(293, 'article_types', 2, 'id', 'add_new', '', '2', '2013-12-10 23:21:50', 1),
(294, 'articles', 1, 'thumb', 'data', '/files/articles/1386525626_24.jpg', '', '2013-12-11 20:32:26', 1),
(295, 'articles', 1, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1386525626_24.jpg', '', '2013-12-11 20:32:26', 1),
(296, 'articles', 1, 'thumb', 'data', '', '/files/articles/1386786760_63.jpg', '2013-12-11 20:32:40', 1),
(297, 'articles', 1, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/articles/1386786760_63.jpg', '2013-12-11 20:32:40', 1),
(298, 'articles', 2, 'id', 'add_new', '', '2', '2013-12-11 20:51:48', 1),
(299, 'articles', 2, 'thumb', 'data', '', '/files/articles/1386787920_40.png', '2013-12-11 20:52:00', 1),
(300, 'articles', 2, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/articles/1386787920_40.png', '2013-12-11 20:52:00', 1),
(301, 'articles', 2, 'descr', 'data', '<p>XSLT технологии&nbsp; начинают входить в реальную жизнь и практику HTML-верстальщиков. Несмотр на кризис в&nbsp; Яндексе и Рэмблере практически постоянно были открыты вакансии XSLT-верстальщиков. И не только там. Многие отечественные веб-студии, исполь', '<p>XSLT технологии&nbsp; начинают входить в реальную жизнь и практику HTML-верстальщиков. Несмотр на кризис в&nbsp; Яндексе и Рэмблере практически постоянно были открыты вакансии XSLT-верстальщиков. И не только там. Многие отечественные веб-студии, исполь</p>', '2013-12-11 20:52:00', 1),
(302, 'articles', 3, 'id', 'add_new', '', '3', '2013-12-11 20:54:33', 1),
(303, 'menu', 2, 'url', 'data', '/route/krimea', '/route/crimea', '2013-12-11 22:25:06', 1),
(304, 'menu', 3, 'url', 'data', '/review/krimea', '/review/crimea', '2013-12-11 22:25:16', 1),
(305, 'menu', 4, 'url', 'data', '/features/krimea', '/features/crimea', '2013-12-11 22:25:24', 1),
(306, 'menu_types', 1, 'name', 'data', 'Menu group 1', 'Главное меню сайта', '2013-12-11 23:01:08', 1),
(307, 'menu_types', 2, 'id', 'delete_all', '2', '', '2013-12-11 23:01:14', 1),
(308, 'menu_types', 2, 'name', 'data', 'Menu group 2', '', '2013-12-11 23:01:14', 1),
(309, 'menu_types', 2, 'alias', 'data', 'menu_top_2', '', '2013-12-11 23:01:14', 1),
(310, 'menu_types', 1, 'name', 'data', 'Главное меню сайта', 'Главное меню', '2013-12-11 23:01:29', 1),
(311, 'adminmenu', 196, 'id', 'add_new', '', '196', '2013-12-11 23:03:22', 1),
(312, 'slides', 1, 'id', 'add_new', '', '1', '2013-12-11 23:19:57', 1),
(313, 'slides', 1, 'image', 'data', '/files/slides/1386796797_71.jpg', '/files/slides/1386796881_29.jpg', '2013-12-11 23:21:21', 1),
(314, 'slides', 1, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386796797_71.jpg', '/home/serg/www/localhost/files/slides/1386796881_29.jpg', '2013-12-11 23:21:21', 1),
(315, 'slides', 1, 'image', 'data', '/files/slides/1386796881_29.jpg', '/files/slides/1386796939_7.jpg', '2013-12-11 23:22:19', 1),
(316, 'slides', 1, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386796881_29.jpg', '/home/serg/www/localhost/files/slides/1386796939_7.jpg', '2013-12-11 23:22:19', 1),
(317, 'slides', 2, 'id', 'add_new', '', '2', '2013-12-11 23:23:30', 1),
(318, 'slides', 3, 'id', 'add_new', '', '3', '2013-12-11 23:24:13', 1),
(319, 'slides', 4, 'id', 'add_new', '', '4', '2013-12-11 23:24:44', 1),
(320, 'adminmenu', 197, 'id', 'add_new', '', '197', '2013-12-12 21:49:23', 1),
(321, 'adminmenu', 198, 'id', 'add_new', '', '198', '2013-12-12 21:50:45', 1),
(322, 'adminmenu', 199, 'id', 'add_new', '', '199', '2013-12-12 21:51:44', 1),
(323, 'adminmenu', 197, 'url', 'data', '/admin/routes/regions.php', '/admin/routes/hikes.php', '2013-12-12 23:21:59', 1),
(324, 'pages', 1, 'page_name', 'data', '', 'О нас', '2013-12-17 19:56:41', 1),
(325, 'pages', 1, 'menu_id', 'data', '2', '0', '2013-12-17 19:58:10', 1),
(326, 'pages', 1, 'page_name', 'data', '', 'О нас', '2013-12-17 20:02:25', 1),
(327, 'pages', 1, 'menu_id', 'data', '2', '0', '2013-12-17 20:02:25', 1),
(328, 'regions', 1, 'id', 'add_new', '', '1', '2013-12-17 20:04:40', 1),
(329, 'regions', 2, 'id', 'add_new', '', '2', '2013-12-17 20:08:30', 1),
(330, 'pages', 1, 'page_name', 'data', '', 'О нас', '2013-12-17 20:08:43', 1),
(331, 'pages', 1, 'menu_id', 'data', '2', '0', '2013-12-17 20:08:43', 1),
(332, 'pages', 2, 'id', 'add_new', '', '2', '2013-12-17 20:09:00', 1),
(333, 'pages', 3, 'id', 'add_new', '', '3', '2013-12-17 20:12:29', 1),
(334, 'pages', 4, 'id', 'add_new', '', '4', '2013-12-17 20:18:59', 1),
(335, 'pages', 5, 'id', 'add_new', '', '5', '2013-12-17 20:21:01', 1),
(336, 'pages', 6, 'id', 'add_new', '', '6', '2013-12-17 20:22:49', 1),
(337, 'pages', 7, 'id', 'add_new', '', '7', '2013-12-17 20:25:18', 1),
(338, 'regions', 3, 'id', 'add_new', '', '3', '2013-12-17 20:26:24', 1),
(339, 'routes', 1, 'id', 'add_new', '', '1', '2013-12-17 20:51:06', 1);
INSERT INTO `adminhistory` (`id`, `table`, `row_id`, `column`, `type`, `old_value`, `new_value`, `date`, `admin_id`) VALUES
(340, 'routes', 1, 'descr_long', 'data', '', '<h2 style="text-align: justify;">План похода по горному Крыму:</h2><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">1 день. Симферополь &ndash; нижнее плато Чатыр-Даг (7,6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Группа собирается на железнодорожном вокзале Симферополя, где все знакомятся, и инструктор раздает каждому его часть общего снаряжения и продуктов. Далее, садимся на троллейбус и едем в Сосновку, где и начнется пешая честь похода. Недалеко от трассы начинается Красная тропа, названная так из-за характерного красноватого цвета камня. Подъем по ней весьма не прост и придется попотеть, пока не поднимемся на нижнее плато Чатыр-Даг. На плато нас ждут две красивейшие пещеры &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/emine-bair-hosar.html" target="_blank">Эмине-Баир-Хосар</a> и Мраморная, в которые все желающие могут сходить на экскурсию. На ночевку остановимся неподалеку от пещер.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest11.jpg" style=""><img alt="у костра" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest11-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest9.jpg" style=""><img alt="идем по плато" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest9-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina15.jpg" style=""><img alt="В пещере Эмине-Баир-Хосар" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina15-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">2 день. Ангар-Бурун &ndash; Кутузовские озера (8,2 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Нижнее плато <a href="http://www.kuluarbc.com.ua/interesnye-mesta/chatur-dag.html" target="_blank">Чатыр-Дага</a> богато на пещеры, большинство из них &ndash; это вертикальные колодцы, но есть и много доступных без специального снаряжения. В парочку таких можно будет зайти по пути. Сегодня мы поднимемся на верхнее плато и на вершину Ангар-Бурун (1453 м), а если будет хватать сил и времени, то и на Эклизи-Бурун, высотой 1527 м. С обоих вершин открывается красивейший вид на Демерджи, Алушту и Бабуган яйлу. Налюбовавшись красотами и сделав парочку снимков на память, спускаемся к Кутозовским озерам, где и заночуем.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest098.jpg" style=""><img alt="на пути к вершине" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest098-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina.JPG" style=""><img alt="Наслаждаемся пейзажами=))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina3.JPG" style=""><img alt="Вершина Эклизи-Бурун" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina3-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">3 день. Долина Привидений, Демерджи, Джурла (12,3 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Каждый, кто мало-мальски интересуется красотами природы, слышал (или уже бывал) о <a href="http://www.kuluarbc.com.ua/interesnye-mesta/dolina-prividenij.html" target="_blank">Долине Привидений</a> &ndash; одном из красивейших мест горного Крыма. Сегодня и мы побываем тут, но сначала зайдем на экскурсию в крепость Фуна &ndash; средневековое укрепление феодоритов, служившее для охраны торгового пути. На входе в долину растет знаменитое дерево Никулина, возле которого снималась &laquo;Кавказская пленница&raquo;. Пройдя Долину Привидений, поднимаемся к вершине южной Демерджи, с которой открывается просто превосходная панорама на ЮБК &ndash; от Судака и до Медведь-горы. Заночуем сегодня возле озера на стоянке Джурла, а если хватит времени, то пройдем немного дальше, к водопаду.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina13.jpg" style=""><img alt="Долина Привидений" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina13-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina14.jpg" style=""><img alt="На вершине Демерджи" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina14-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest17.JPG" style=""><img alt="скала Катерина" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest17-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">4 день. Водопад Джур-Джур, т/с Ай-Алексий (14 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Быстро собираем лагерь, завтракаем и в путь! Сегодня нам нужно много пройти и много увидеть. Совсем рядом со стоянкой любуемся небольшим, но очень живописным водопадом <a href="http://www.kuluarbc.com.ua/interesnye-mesta/vodopad-dzhurla.html" target="_blank">Джурла</a>. Далее, по хорошей тропе топаем к самому полноводному водопаду Крыма &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/vodopad-dzhur-dzhur.html">Джур-Джур</a>. Мощные струи реки Улу-Узень падают с 16-ти метрового уступа и это действительно впечатляющее зрелище! К сожалению, покупаться в водопаде не удастся, так как идет забор питьевой воды и купание запрещено. Вдоволь насмотревшись и сделав достаточное количество снимков идем к стоянке Ай-Алексий, где и заночуем.</span></span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest01.jpg" style=""><img alt="восход" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest01-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina17.jpg" style=""><img alt="Водопад Джур-Джур" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina17-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></span></span><a href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina9.JPG" rel="lightbox[]" target="_blank" title="Играем в валейбол на стоянке"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"> </span></span></a><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina7.JPG" style=""><img alt="Грибочки всегда хорошо))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina7-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">5 день. Караби-яйла. Озеро Хун (10,9 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;">Основные достопримечательности этого похода по горному Крыму пройдены, но еще можно насладиться дикими пейзажами Караби яйлы. Плато просто пестрит от карстовых воронок и пещер-колодцев, но оно безводное и туристы там ходят не так часто. Мы же не спеша спускаемся к большому озеру Хун, где можно вдоволь накупаться и помыться.</span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest6.jpg" style=""><img alt="на дереве" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest6-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur " href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina16.jpg" style=""><img alt="Отдых на маршруте" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina16-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest15.JPG" style=""><img alt="возле озера" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest15-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">6 день. Рыбачье. Симферополь (6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">До конца маршрута осталось всего ничего &ndash; спуститься в Рыбачье по дороге, идущей сквозь виноградники. Особенно хороша она осенью, когда виноград уже поспел. Постоянно останавливаешься, что бы скушать вкусную ягодку. Главное &ndash; знать меру, а то следующая ночь в поезде вам и вашим соседям покажется длинной:-) От Рыбачьего регулярно ходят маршрутки и добраться к Симферополю не составит проблем.</span></span></p>', '2013-12-17 20:51:55', 1),
(341, 'routes', 1, 'reviews', 'data', '', '<p>Хорошо сходили)Погода,конечно,немного подвела,но как говорится:У природы нет плохой погоды.)Было мокро,сыро и холодно ,но это даже добавило какого то приключенческого духа.))Пейзажи неописуемые,особенно впечатляет,когда видишь как огромную гору &quot;сьедает&quot; еще более огромное облако,все кажется одновременно и очень маленьким и неописуемо большим,короче контрастов много.Вел нас человек-энциклопедия.))На протяжении всего маршрута наш проводник рассказывал нам обо всем что мы видели:о горах,травах,камнях,облаках буквально обо всем и это особенно запомнилось,т.к.поход оказался не только красивым но и полезным.Всем кто ни разу не был в горах или в походе вообще однозначно советую,это интересно и впечатляюще и по уровню подготовки в самый раз.))</p>', '2013-12-17 20:52:19', 1),
(342, 'routes', 1, 'cost_rur', 'data', '0', '4960', '2013-12-17 20:53:14', 1),
(343, 'routes', 1, 'cost_usd', 'data', '0', '150', '2013-12-17 20:53:14', 1),
(344, 'routes', 1, 'start', 'data', '', 'Симферополь', '2013-12-17 20:53:14', 1),
(345, 'routes', 1, 'finish', 'data', '', 'Симферополь', '2013-12-17 20:53:14', 1),
(346, 'routes', 1, 'cost_rur', 'data', '0', '4960', '2013-12-17 20:56:53', 1),
(347, 'routes', 1, 'cost_usd', 'data', '0', '150', '2013-12-17 20:56:53', 1),
(348, 'routes', 1, 'start', 'data', '', 'Симферополь', '2013-12-17 20:56:53', 1),
(349, 'routes', 1, 'finish', 'data', '', 'Симферополь', '2013-12-17 20:56:53', 1),
(350, 'routes', 1, 'cost_rur', 'data', '0', '4960', '2013-12-17 21:00:13', 1),
(351, 'routes', 1, 'cost_usd', 'data', '0', '150', '2013-12-17 21:00:13', 1),
(352, 'routes', 1, 'start', 'data', '', 'Симферополь', '2013-12-17 21:00:13', 1),
(353, 'routes', 1, 'finish', 'data', '', 'Симферополь', '2013-12-17 21:00:13', 1),
(354, 'routes', 1, 'videos', 'data', '', '<p>1312453451</p>', '2013-12-17 21:01:36', 1),
(355, 'routes', 1, 'videos', 'data', '', '<p>13245123415</p>', '2013-12-17 21:01:45', 1),
(356, 'routes', 1, 'videos', 'data', '', '<p>1235615н46</p>', '2013-12-17 21:21:35', 1),
(357, 'routes', 1, 'cost_rur', 'data', '123', '111', '2013-12-17 21:54:07', 1),
(358, 'routes', 1, 'cost_usd', 'data', '150', '1500', '2013-12-17 21:54:07', 1),
(359, 'routes', 1, 'cost_rur', 'data', '111', '4960', '2013-12-17 21:54:56', 1),
(360, 'routes', 1, 'cost_usd', 'data', '1500', '150', '2013-12-17 21:54:56', 1),
(361, 'routes', 1, 'start', 'data', '', 'Симферополь', '2013-12-17 21:57:45', 1),
(362, 'routes', 1, 'finish', 'data', '', 'Симферополь', '2013-12-17 21:57:45', 1),
(363, 'routes', 1, 'middle', 'data', '', '/files/routes/middle/1387310265_63.jpg', '2013-12-17 21:57:45', 1),
(364, 'routes', 1, 'middle_p', 'data', '', '/home/serg/www/localhost/files/routes/middle/1387310265_63.jpg', '2013-12-17 21:57:45', 1),
(365, 'routes', 1, 'thumb', 'data', '', '/files/routes/thumb/1387310265_9.jpg', '2013-12-17 21:57:45', 1),
(366, 'routes', 1, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/routes/thumb/1387310265_9.jpg', '2013-12-17 21:57:45', 1),
(367, 'routes', 1, 'cost_grn', 'data', '0', '1240', '2013-12-17 22:01:09', 1),
(368, 'hikes', 1, 'id', 'add_new', '', '1', '2013-12-17 22:01:54', 1),
(369, 'adminmenu', 200, 'id', 'add_new', '', '200', '2013-12-17 22:42:49', 1),
(370, 'trainers', 1, 'id', 'add_new', '', '1', '2013-12-17 22:46:48', 1),
(371, 'hikes', 1, 'trainer_id', 'data', '0', '1', '2013-12-17 22:50:13', 1),
(372, 'slides', 4, 'image', 'data', '/files/slides/1386797084_8.jpg', '', '2013-12-18 09:59:52', 1),
(373, 'slides', 4, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386797084_8.jpg', '', '2013-12-18 09:59:52', 1),
(374, 'slides', 4, 'image', 'data', '', '/files/slides/1387353638_68.jpeg', '2013-12-18 10:00:38', 1),
(375, 'slides', 4, 'image_p', 'data', '', '/home/serg/www/dev3/files/slides/1387353638_68.jpeg', '2013-12-18 10:00:38', 1),
(376, 'slides', 1, 'image', 'data', '/files/slides/1386796939_7.jpg', '', '2013-12-18 10:00:49', 1),
(377, 'slides', 1, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386796939_7.jpg', '', '2013-12-18 10:00:49', 1),
(378, 'slides', 1, 'image', 'data', '', '/files/slides/1387353662_44.jpeg', '2013-12-18 10:01:02', 1),
(379, 'slides', 1, 'image_p', 'data', '', '/home/serg/www/dev3/files/slides/1387353662_44.jpeg', '2013-12-18 10:01:02', 1),
(380, 'slides', 2, 'image', 'data', '/files/slides/1386797010_59.jpg', '', '2013-12-18 10:07:15', 1),
(381, 'slides', 2, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386797010_59.jpg', '', '2013-12-18 10:07:15', 1),
(382, 'slides', 2, 'image', 'data', '', '/files/slides/1387354048_96.jpeg', '2013-12-18 10:07:28', 1),
(383, 'slides', 2, 'image_p', 'data', '', '/home/serg/www/dev3/files/slides/1387354048_96.jpeg', '2013-12-18 10:07:28', 1),
(384, 'slides', 3, 'image', 'data', '/files/slides/1386797053_100.jpg', '', '2013-12-18 10:07:37', 1),
(385, 'slides', 3, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1386797053_100.jpg', '', '2013-12-18 10:07:37', 1),
(386, 'slides', 3, 'image', 'data', '', '/files/slides/1387354071_45.jpeg', '2013-12-18 10:07:51', 1),
(387, 'slides', 3, 'image_p', 'data', '', '/home/serg/www/dev3/files/slides/1387354071_45.jpeg', '2013-12-18 10:07:51', 1),
(388, 'hikes', 2, 'id', 'add_new', '', '2', '2013-12-18 14:42:47', 1),
(389, 'menu', 2, 'url', 'data', '/route/crimea', '/routes/crimea', '2013-12-18 15:02:23', 1),
(390, 'menu', 9, 'url', 'data', '/route/karpaty', '/routes/karpaty', '2013-12-18 15:02:42', 1),
(391, 'routes', 1, 'complexity', 'data', '1', '2', '2013-12-18 16:03:32', 1),
(392, 'routes', 1, 'complexity', 'data', '2', '3', '2013-12-18 16:06:16', 1),
(393, 'hikes', 2, 'date_start', 'data', '2014-01-20', '2014-01-15', '2013-12-18 16:19:43', 1),
(394, 'article_types', 2, 'descr', 'data', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</sp', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</span></p>', '2013-12-18 17:27:56', 1),
(395, 'article_types', 1, 'name', 'data', 'Тема статей первая', 'Блог о туризме', '2013-12-18 17:28:43', 1),
(396, 'article_types', 1, 'text', 'data', '<p>Содержание первой темы статей</p>', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Блог о туризме.. Хм. О чем же ж тут писать? =)) Конечно, о туризме и о всем, что его касается! Здесь будут стать о снаряжении, об особенностях походной жизни, о погоде в горах, просто размышления у костра - в общем все что взбредет в голову и чем захочется поделиться! Возмоно будут не только мои статьи, а и других авторов.</span></p>', '2013-12-18 17:28:43', 1),
(397, 'article_types', 1, 'title', 'data', 'theme1', 'blog', '2013-12-18 17:28:43', 1),
(398, 'article_types', 1, 'descr', 'data', '', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Блог о туризме.. Хм. О чем же ж тут писать? =)) Конечно, о туризме и о всем, что его касается! Здесь будут стать о снаряжении, об особенностях походной жизни, о погоде в горах, просто размышления у костра - в общем все что взбредет в голову и чем захочется поделиться! Возмоно будут не только мои статьи, а и других авторов.</span></p>', '2013-12-18 17:28:43', 1),
(399, 'article_types', 3, 'id', 'add_new', '', '3', '2013-12-18 17:30:13', 1),
(400, 'article_types', 2, 'descr', 'data', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</sp', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</span></p>', '2013-12-18 17:30:18', 1),
(401, 'article_types', 4, 'id', 'add_new', '', '4', '2013-12-18 17:30:58', 1),
(402, 'articles', 1, 'article_type', 'data', '1', '2', '2013-12-18 19:09:54', 1),
(403, 'articles', 1, 'name', 'data', 'Heading1', 'Как добраться в Лазещину с Ивано-Франковска', '2013-12-18 19:09:54', 1),
(404, 'articles', 1, 'text_short', 'data', '<p>Як повідомляє &quot;Інтерфакс-Україна&quot;, міліція відкрила кримінальне провадження через знесення пам&rsquo;ятника Леніну за частиною 1 статті 294 Кримінального кодексу &ndash; масові безлади, проте поки затриманих немає.</p><p>Щоб ви розуміли: ЖОДНОГО міліціонера біля Леніна зараз немає. Жодного. Проїжджаючи, всі сигналять. Народу - чоловік 500 тих, що співають гімн, кричать &quot;слава нації - смерть ворогам&quot;, &quot;героям слава&quot;, &quot;Україна понад усе&quot;. Хтось рубає Леніна. За кожним шматочком вгору здіймаються сотні рук.</p>', '<p>Друзья, привет! В первую очередь эта статья адресована тем, кто едет с нами <a href="http://www.kuluarbc.com.ua/zimniy-otdyh/novyi-god-v-karpatah.html">на Новый год в Карпаты</a>. А если быть еще точнее, то тем из них, кто приезжает после контрольного времени сбора группы и у кого возник вопрос: &laquo;<strong>А как нам добраться до Лазещины?</strong>&raquo;</p>', '2013-12-18 19:09:54', 1),
(405, 'articles', 1, 'text_long', 'data', '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '<p>&nbsp;</p><p>Теперь по порядку. Группа собирается в 7-10 утра (точное время будет примерно за 10 дней до выезда, проверяйте почту!) и мы едем &nbsp;в Лазещину все вместе. Тут вопросов у вас не возникаем, ибо мы их решаем. Но есть и такие, кто приезжает позже контрольного времени. Всей группе вас ждать смысла нет, ведь уже в первый день можно покататься на лыжах и съездить на Драгобрат или Буковель! &nbsp;Поэтому, опоздавшим нужно будет добраться до Лазещины самостоятельно. Если вы на своей машине, тогда пользуетесь gps. Для тех, кто приехал в Ивано-Франковск поездом или автобусом есть три способа:</p><ol>\r\n<li>\r\n	<strong>Заказной автобус/такси</strong> &ndash; этот вариант хорош, если вас группа из нескольких человек. Так же это самый комфортный и быстрый способ, но и самый дорогой. Стоимость 50-70 грн в зависимости от размера машины и количества человек. Дороже смысла нет договариваться, разве что в крайнем случае. Если вы сам, то можно найти попутчиков прямо на вокзале и скооперироваться с ними. Как найти таксистов? Лучше бы спросили как их не найти! При выходе с вокзала со стороны автовокзала (он левее в 200 метрах) стоит куча водил, которые как рыбы прилипалы пытаются перетащить вас к себе. Торгуемся!</li>\r\n<li>\r\n	<strong>Рейсовый автобус</strong>. Стоимость билета Ивано-Франковск &ndash; Лазещина составляет 35 грн, но есть проблема. С ноября 2013 что-то там не поделили держатели и теперь прямых рейсов с вокзала нет(( Остается вариант с пересадкой в Татарове. С воказала почти все автобусы едут через него, билеты покупаются в кассе автовокзала. Выходим с вокзала, стоим лицом к городу, поворачиваем налево и идем метров 200 &ndash; тут и найдете автовокзал. Выходим в Татарове и ловим автобус на Лазещину. Прямые рейсы перенесли на автостанцию 2 в Ивано-Франковске. Туда добираться проблемно.. На всякий случай расписание:</li>\r\n</ol><table border="1" cellpadding="0" cellspacing="0" style="height: 400px; width: 664px;">\r\n<tbody>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Сообщение</td>\r\n		<td style="text-align: center;" valign="top">\r\n			Время отправления</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			7.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			9.00</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Ясиня</td>\r\n		<td style="text-align: center;" valign="top">\r\n			9.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			11.00</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			11.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Ясиня</td>\r\n		<td style="text-align: center;" valign="top">\r\n			12.55</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Хуст</td>\r\n		<td style="text-align: center;" valign="top">\r\n			13.25</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Хуст</td>\r\n		<td style="text-align: center;" valign="top">\r\n			14.25</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Тячево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			15.45</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			16.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			17.55</td>\r\n	</tr>\r\n</tbody>\r\n</table><p>Есть еще пару автобусов позже, но лучше успевать на эти.</p><p>3. <strong>Дизелем/поездом.</strong> Это самый дешевый способ, но и самый долгий. Раньше был хороший дизель, который отправлялся в 9.15. Но я им давно не ездил и что-то в расписании не нахожу на это время.&nbsp; Так что есть два варианта: поездом Львов-Рахов, отправляется в 19.20 с Франковска, к Лазещине едет 3 часа и 10 минут или дизелем 6404 Ивано-Франковск &ndash; Рахов, он отправляется в 3:28 ночи. Неплохой вариант для тех, кто приезжает ночью.</p><p style="text-align: center;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/blog/laz1.jpg" style=""><img alt="как добраться до Лазещины" height="400" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-blog-laz1-600x400.jpg" width="600" /></a></p><p>Других простых способов добраться с Ивано-Франковска в Лазещину в голову не приходит. Я бы советовал ехать заказным автобусом. По приезду в Лазещину мы вас встретим,&nbsp; только позвоните заранее инструктору &ndash; его данные будут присланы вместе со временем сбора. До встречи, друзья!</p>', '2013-12-18 19:09:54', 1),
(406, 'articles', 1, 'title', 'data', 'first_post', 'kak-dobratsya-v-lazehshcinu', '2013-12-18 19:09:54', 1),
(407, 'articles', 4, 'id', 'add_new', '', '4', '2013-12-18 19:12:21', 1),
(408, 'articles', 4, 'thumb', 'data', '/files/articles/1387386741_87.jpg', '/files/articles/1387386781_19.jpg', '2013-12-18 19:13:01', 1),
(409, 'articles', 4, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1387386741_87.jpg', '/home/serg/www/localhost/files/articles/1387386781_19.jpg', '2013-12-18 19:13:01', 1),
(410, 'articles', 4, 'thumb', 'data', '/files/articles/1387386781_19.jpg', '/files/articles/1387386795_19.jpg', '2013-12-18 19:13:15', 1),
(411, 'articles', 4, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1387386781_19.jpg', '/home/serg/www/localhost/files/articles/1387386795_19.jpg', '2013-12-18 19:13:15', 1),
(412, 'articles', 4, 'thumb', 'data', '/files/articles/1387386795_19.jpg', '/files/articles/1387386846_49.jpg', '2013-12-18 19:14:06', 1),
(413, 'articles', 4, 'thumb_p', 'data', '/home/serg/www/localhost/files/articles/1387386795_19.jpg', '/home/serg/www/localhost/files/articles/1387386846_49.jpg', '2013-12-18 19:14:06', 1),
(414, 'articles', 5, 'id', 'add_new', '', '5', '2013-12-18 19:15:47', 1),
(415, 'articles', 5, 'thumb', 'data', '', '/files/articles/1387386960_55.jpg', '2013-12-18 19:16:00', 1),
(416, 'articles', 5, 'thumb_p', 'data', '', '/home/serg/www/localhost/files/articles/1387386960_55.jpg', '2013-12-18 19:16:00', 1),
(417, 'trainers', 2, 'id', 'add_new', '', '2', '2013-12-18 19:21:53', 1),
(418, 'trainers', 3, 'id', 'add_new', '', '3', '2013-12-18 19:23:14', 1),
(419, 'routes', 2, 'id', 'add_new', '', '2', '2013-12-18 19:28:14', 1),
(420, 'routes', 3, 'id', 'add_new', '', '3', '2013-12-18 19:30:35', 1),
(421, 'hikes', 2, 'route_id', 'data', '1', '2', '2013-12-18 19:31:03', 1),
(422, 'hikes', 3, 'id', 'add_new', '', '3', '2013-12-18 19:31:27', 1),
(423, 'hikes', 4, 'id', 'add_new', '', '4', '2013-12-18 19:31:40', 1),
(424, 'hikes', 5, 'id', 'add_new', '', '5', '2013-12-18 19:32:09', 1),
(425, 'routes', 1, 'preparation', 'data', '', '<p><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">К вашему вниманию список обязательных и не очень вещей для зимнего похода. Он составлен опираясь на личный опыт и здравый смысл, поэтому&nbsp; начинающим туристам искренне советую его придерживаться. В случае, если вы не хотите брать что-то с данного списка или хотите взять что-то еще, обязательно посоветуйтесь с инструктором. </span></span></p><p><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Статью о снаряжении для летнего похода можно прочитать тут:&nbsp;<a href="http://www.kuluarbc.com.ua/vse/chto-vzyat-v-pohod.html"> Что взять в поход? Список снаряжения для летнего похода.</a></span></span></span></span></p>', '2013-12-21 23:30:10', 1),
(426, 'routes', 1, 'videos', 'data', '<p>1235615н46</p>', '<p><iframe class="youtube-player" frameborder="0" height="390" src="http://www.youtube.com/embed/http://www.youtube.com/v/Qmus9GchI-4?rel=0" title="YouTube video player" type="text/html" width="480"></iframe></p><p><iframe class="youtube-player" frameborder="0" height="390" src="http://www.youtube.com/embed/http://www.youtube.com/v/kzV7ZFGTy8s?rel=0" title="YouTube video player" type="text/html" width="480"></iframe></p>', '2013-12-21 23:30:10', 1),
(427, 'menu', 2, 'url', 'data', '/routes/crimea', '/routes/filter/crimea', '2013-12-22 00:10:21', 1),
(428, 'menu', 9, 'url', 'data', '/routes/karpaty', '/routes/filter/karpaty', '2013-12-22 00:10:39', 1),
(429, 'trainers', 1, 'birthday', 'data', '1988-01-01', '1988-01-02', '2013-12-25 10:13:41', 14),
(430, 'trainers', 1, 'practice', 'data', '2008-01-01', '2008-01-10', '2013-12-25 11:02:33', 14),
(431, 'adminmenu', 201, 'id', 'add_new', '', '201', '2013-12-25 11:59:28', 14),
(432, 'reviews', 1, 'id', 'add_new', '', '1', '2013-12-25 14:01:06', 14),
(433, 'reviews', 1, 'image', 'data', '/files/slides/1387972866_19.jpeg', '/files/reviews/1387972954_8.jpeg', '2013-12-25 14:02:34', 14),
(434, 'reviews', 1, 'image_p', 'data', '/home/serg/www/localhost/files/slides/1387972866_19.jpeg', '/home/serg/www/localhost/files/reviews/1387972954_8.jpeg', '2013-12-25 14:02:34', 14),
(435, 'reviews', 2, 'id', 'add_new', '', '2', '2013-12-25 14:10:09', 14);

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

DROP TABLE IF EXISTS `adminlog`;
CREATE TABLE IF NOT EXISTS `adminlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;

--
-- Dumping data for table `adminlog`
--

INSERT INTO `adminlog` (`id`, `admin`, `type`, `action`, `time`) VALUES
(1, 1, 'edit', 'Изменены данные в ''Администраторы'' с `id`=1', '2013-12-07 09:17:14'),
(2, 1, 'delete', 'Удалена запись 156 из adminmenu', '2013-12-07 09:44:25'),
(3, 1, 'delete', 'Удалена запись 157 из adminmenu', '2013-12-07 09:44:31'),
(4, 1, 'delete', 'Удалена запись 155 из adminmenu', '2013-12-07 09:44:42'),
(5, 1, 'delete', 'Удалена запись 158 из adminmenu', '2013-12-07 09:44:48'),
(6, 1, 'delete', 'Удалена запись 159 из adminmenu', '2013-12-07 09:45:09'),
(7, 1, 'delete', 'Удалена запись 160 из adminmenu', '2013-12-07 09:45:13'),
(8, 1, 'delete', 'Удалена запись 161 из adminmenu', '2013-12-07 09:45:17'),
(9, 1, 'delete', 'Удалена запись 176 из adminmenu', '2013-12-07 09:45:23'),
(10, 1, 'delete', 'Удалена запись 162 из adminmenu', '2013-12-07 09:45:30'),
(11, 1, 'delete', 'Удалена запись 163 из adminmenu', '2013-12-07 09:45:42'),
(12, 1, 'delete', 'Удалена запись 164 из adminmenu', '2013-12-07 09:45:46'),
(13, 1, 'delete', 'Удалена запись 165 из adminmenu', '2013-12-07 09:45:51'),
(14, 1, 'delete', 'Удалена запись 166 из adminmenu', '2013-12-07 09:45:54'),
(15, 1, 'delete', 'Удалена запись 167 из adminmenu', '2013-12-07 09:45:59'),
(16, 1, 'delete', 'Удалена запись 168 из adminmenu', '2013-12-07 09:46:03'),
(17, 1, 'delete', 'Удалена запись 169 из adminmenu', '2013-12-07 09:46:07'),
(18, 1, 'delete', 'Удалена запись 170 из adminmenu', '2013-12-07 09:46:10'),
(19, 1, 'delete', 'Удалена запись 171 из adminmenu', '2013-12-07 09:46:14'),
(20, 1, 'delete', 'Удалена запись 172 из adminmenu', '2013-12-07 09:46:18'),
(21, 1, 'delete', 'Удалена запись 173 из adminmenu', '2013-12-07 09:46:26'),
(22, 1, 'delete', 'Удалена запись 174 из adminmenu', '2013-12-07 09:46:30'),
(23, 1, 'delete', 'Удалена запись 175 из adminmenu', '2013-12-07 09:46:33'),
(24, 1, 'delete', 'Удалена запись 177 из adminmenu', '2013-12-07 09:46:45'),
(25, 1, 'delete', 'Удалена запись 178 из adminmenu', '2013-12-07 09:46:50'),
(26, 1, 'delete', 'Удалена запись 179 из adminmenu', '2013-12-07 09:46:54'),
(27, 1, 'delete', 'Удалена запись 181 из adminmenu', '2013-12-07 09:47:19'),
(28, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=182', '2013-12-07 09:48:32'),
(29, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=183', '2013-12-07 09:48:58'),
(30, 1, 'delete', 'Удалена запись 192 из adminmenu', '2013-12-07 09:51:20'),
(31, 1, 'delete', 'Удалена запись 191 из adminmenu', '2013-12-07 09:51:24'),
(32, 1, 'delete', 'Удалена запись 190 из adminmenu', '2013-12-07 09:51:36'),
(33, 1, 'delete', 'Удалена запись 189 из adminmenu', '2013-12-07 09:51:40'),
(34, 1, 'delete', 'Удалена запись 188 из adminmenu', '2013-12-07 09:51:44'),
(35, 1, 'delete', 'Удалена запись 187 из adminmenu', '2013-12-07 09:51:48'),
(36, 1, 'delete', 'Удалена запись 186 из adminmenu', '2013-12-07 09:51:52'),
(37, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=183', '2013-12-07 09:53:15'),
(38, 1, 'add', 'Добавлены данные в menu', '2013-12-07 11:43:19'),
(39, 1, 'add', 'Добавлены данные в pages', '2013-12-07 16:15:48'),
(40, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=1', '2013-12-07 16:17:10'),
(41, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=1', '2013-12-07 16:17:17'),
(42, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-07 16:17:34'),
(43, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-07 17:07:41'),
(44, 1, 'add', 'Добавлены данные в menu', '2013-12-07 17:57:17'),
(45, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-07 17:57:29'),
(46, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-07 20:09:30'),
(47, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-07 21:17:59'),
(48, 1, 'add', 'Добавлены данные в menu_types', '2013-12-07 21:22:52'),
(49, 1, 'add', 'Добавлены данные в menu_types', '2013-12-07 21:23:05'),
(50, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=2', '2013-12-07 21:24:50'),
(51, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=44', '2013-12-07 21:31:05'),
(52, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:37:00'),
(53, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:39:30'),
(54, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=1', '2013-12-07 21:39:52'),
(55, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=1', '2013-12-07 21:40:22'),
(56, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=1', '2013-12-07 21:41:16'),
(57, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-07 21:42:39'),
(58, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=3', '2013-12-07 21:47:24'),
(59, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-07 21:49:59'),
(60, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=3', '2013-12-07 21:50:10'),
(61, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=1', '2013-12-07 21:52:31'),
(62, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:53:31'),
(63, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:55:20'),
(64, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:56:23'),
(65, 1, 'add', 'Добавлены данные в menu', '2013-12-07 21:57:14'),
(66, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-07 22:01:17'),
(67, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=3', '2013-12-07 23:32:47'),
(68, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=4', '2013-12-07 23:32:56'),
(69, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=3', '2013-12-07 23:37:20'),
(70, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-07 23:51:09'),
(71, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-08 09:56:30'),
(72, 1, 'add', 'Добавлены данные в article_types', '2013-12-08 10:09:38'),
(73, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=194', '2013-12-08 17:36:51'),
(74, 1, 'add', 'Добавлены данные в articles', '2013-12-08 18:43:17'),
(75, 1, 'add', 'Добавлены данные в articles', '2013-12-08 18:45:12'),
(76, 1, 'add', 'Добавлены данные в articles', '2013-12-08 18:45:33'),
(77, 1, 'add', 'Добавлены данные в articles', '2013-12-08 18:57:36'),
(78, 1, 'add', 'Добавлены данные в articles', '2013-12-08 18:58:43'),
(79, 1, 'add', 'Добавлены данные в articles', '2013-12-08 19:00:13'),
(80, 1, 'add', 'Добавлены данные в articles', '2013-12-08 19:03:02'),
(81, 1, 'add', 'Добавлены данные в articles', '2013-12-08 19:09:29'),
(82, 1, 'add', 'Добавлены данные в articles', '2013-12-08 19:11:46'),
(83, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:12:07'),
(84, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:14:33'),
(85, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:14:45'),
(86, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:15:04'),
(87, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:40:17'),
(88, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:45:21'),
(89, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:45:55'),
(90, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:46:52'),
(91, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 19:47:31'),
(92, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 20:00:26'),
(93, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 21:19:56'),
(94, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 21:22:24'),
(95, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-08 21:23:37'),
(96, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=5', '2013-12-09 20:34:10'),
(97, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=6', '2013-12-09 20:34:18'),
(98, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=5', '2013-12-09 20:34:33'),
(99, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=7', '2013-12-09 20:34:43'),
(100, 1, 'add', 'Добавлены данные в menu', '2013-12-09 20:54:17'),
(101, 1, 'add', 'Добавлены данные в menu', '2013-12-09 20:54:53'),
(102, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=9', '2013-12-09 20:57:20'),
(103, 1, 'add', 'Добавлены данные в menu', '2013-12-09 20:58:02'),
(104, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=9', '2013-12-09 20:58:09'),
(105, 1, 'add', 'Добавлены данные в menu', '2013-12-09 20:58:49'),
(106, 1, 'delete', 'Удалена запись 5 из menu', '2013-12-09 21:32:24'),
(107, 1, 'delete', 'Удалена запись 6 из menu', '2013-12-09 21:32:27'),
(108, 1, 'delete', 'Удалена запись 7 из menu', '2013-12-09 21:32:30'),
(109, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=194', '2013-12-09 22:57:34'),
(110, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=195', '2013-12-09 22:57:46'),
(111, 1, 'edit', 'Изменены данные в ''Темы статей'' с `id`=1', '2013-12-10 20:40:45'),
(112, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-10 20:59:45'),
(113, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-10 20:59:55'),
(114, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-10 21:30:59'),
(115, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-10 21:31:20'),
(116, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-10 21:33:59'),
(117, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=194', '2013-12-10 22:57:09'),
(118, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=195', '2013-12-10 22:57:17'),
(119, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-10 22:57:31'),
(120, 1, 'add', 'Добавлены данные в article_types', '2013-12-10 23:21:50'),
(121, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-11 20:32:26'),
(122, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-11 20:32:40'),
(123, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-11 20:38:30'),
(124, 1, 'add', 'Добавлены данные в articles', '2013-12-11 20:51:48'),
(125, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=2', '2013-12-11 20:52:00'),
(126, 1, 'add', 'Добавлены данные в articles', '2013-12-11 20:54:33'),
(127, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-11 22:25:06'),
(128, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=3', '2013-12-11 22:25:16'),
(129, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=4', '2013-12-11 22:25:24'),
(130, 1, 'edit', 'Изменены данные в ''Группы меню'' с `id`=1', '2013-12-11 23:01:08'),
(131, 1, 'delete', 'Удалена запись 2 из menu_types', '2013-12-11 23:01:14'),
(132, 1, 'edit', 'Изменены данные в ''Группы меню'' с `id`=1', '2013-12-11 23:01:29'),
(133, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-11 23:03:22'),
(134, 1, 'add', 'Добавлены данные в slides', '2013-12-11 23:19:57'),
(135, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=1', '2013-12-11 23:21:21'),
(136, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=1', '2013-12-11 23:22:19'),
(137, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=1', '2013-12-11 23:22:25'),
(138, 1, 'add', 'Добавлены данные в slides', '2013-12-11 23:23:30'),
(139, 1, 'add', 'Добавлены данные в slides', '2013-12-11 23:24:13'),
(140, 1, 'add', 'Добавлены данные в slides', '2013-12-11 23:24:44'),
(141, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-12 21:49:23'),
(142, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-12 21:50:45'),
(143, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-12 21:51:44'),
(144, 1, 'edit', 'Изменены данные в ''Меню'' с `id`=197', '2013-12-12 23:21:59'),
(145, 1, 'add', 'Добавлены данные в pages', '2013-12-17 19:55:44'),
(146, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-17 19:56:41'),
(147, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-17 19:58:10'),
(148, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-17 20:02:25'),
(149, 1, 'edit', 'Изменены данные в ''Администраторы'' с `id`=1', '2013-12-17 20:03:52'),
(150, 1, 'add', 'Добавлены данные в regions', '2013-12-17 20:04:40'),
(151, 1, 'add', 'Добавлены данные в regions', '2013-12-17 20:08:30'),
(152, 1, 'edit', 'Изменены данные в ''Static pages'' с `id`=1', '2013-12-17 20:08:43'),
(153, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:09:00'),
(154, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:12:29'),
(155, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:18:59'),
(156, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:21:01'),
(157, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:22:49'),
(158, 1, 'add', 'Добавлены данные в pages', '2013-12-17 20:25:18'),
(159, 1, 'add', 'Добавлены данные в regions', '2013-12-17 20:26:24'),
(160, 1, 'add', 'Добавлены данные в routes', '2013-12-17 20:30:06'),
(161, 1, 'add', 'Добавлены данные в routes', '2013-12-17 20:33:12'),
(162, 1, 'add', 'Добавлены данные в routes', '2013-12-17 20:51:06'),
(163, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:51:55'),
(164, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:52:19'),
(165, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:52:28'),
(166, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:53:14'),
(167, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:56:53'),
(168, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 20:57:01'),
(169, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:00:13'),
(170, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:00:21'),
(171, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:01:21'),
(172, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:01:36'),
(173, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:01:45'),
(174, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:04:52'),
(175, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:07:38'),
(176, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:17:30'),
(177, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:18:25'),
(178, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:19:42'),
(179, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:21:35'),
(180, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:21:43'),
(181, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:25:24'),
(182, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:26:11'),
(183, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:29:14'),
(184, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:54:07'),
(185, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:54:56'),
(186, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:55:03'),
(187, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:55:53'),
(188, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:57:28'),
(189, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:57:45'),
(190, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:57:55'),
(191, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 21:59:22'),
(192, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-17 22:01:09'),
(193, 1, 'add', 'Добавлены данные в hikes', '2013-12-17 22:01:54'),
(194, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=1', '2013-12-17 22:01:58'),
(195, 1, 'add', 'Добавлены данные в adminmenu', '2013-12-17 22:42:49'),
(196, 1, 'add', 'Добавлены данные в trainers', '2013-12-17 22:46:48'),
(197, 1, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-17 22:46:57'),
(198, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=1', '2013-12-17 22:50:13'),
(199, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=1', '2013-12-17 22:50:22'),
(200, 1, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-17 23:16:41'),
(201, 1, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-18 09:51:56'),
(202, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=4', '2013-12-18 09:59:52'),
(203, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=4', '2013-12-18 10:00:38'),
(204, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=1', '2013-12-18 10:00:49'),
(205, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=1', '2013-12-18 10:01:02'),
(206, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=2', '2013-12-18 10:07:15'),
(207, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=2', '2013-12-18 10:07:28'),
(208, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=3', '2013-12-18 10:07:37'),
(209, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=3', '2013-12-18 10:07:51'),
(210, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=1', '2013-12-18 14:32:05'),
(211, 1, 'add', 'Добавлены данные в hikes', '2013-12-18 14:42:47'),
(212, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-18 15:02:23'),
(213, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=8', '2013-12-18 15:02:31'),
(214, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=9', '2013-12-18 15:02:42'),
(215, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-18 16:03:32'),
(216, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-18 16:03:42'),
(217, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-18 16:06:16'),
(218, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=2', '2013-12-18 16:19:43'),
(219, 1, 'edit', 'Изменены данные в ''Темы статей'' с `id`=2', '2013-12-18 17:27:56'),
(220, 1, 'edit', 'Изменены данные в ''Темы статей'' с `id`=1', '2013-12-18 17:28:43'),
(221, 1, 'add', 'Добавлены данные в article_types', '2013-12-18 17:30:13'),
(222, 1, 'edit', 'Изменены данные в ''Темы статей'' с `id`=2', '2013-12-18 17:30:18'),
(223, 1, 'edit', 'Изменены данные в ''Темы статей'' с `id`=3', '2013-12-18 17:30:25'),
(224, 1, 'add', 'Добавлены данные в article_types', '2013-12-18 17:30:58'),
(225, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=1', '2013-12-18 19:09:54'),
(226, 1, 'add', 'Добавлены данные в articles', '2013-12-18 19:12:21'),
(227, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=4', '2013-12-18 19:13:01'),
(228, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=4', '2013-12-18 19:13:15'),
(229, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=4', '2013-12-18 19:14:06'),
(230, 1, 'add', 'Добавлены данные в articles', '2013-12-18 19:15:47'),
(231, 1, 'edit', 'Изменены данные в ''Статьи'' с `id`=5', '2013-12-18 19:16:00'),
(232, 1, 'add', 'Добавлены данные в trainers', '2013-12-18 19:21:53'),
(233, 1, 'add', 'Добавлены данные в trainers', '2013-12-18 19:23:14'),
(234, 1, 'add', 'Добавлены данные в routes', '2013-12-18 19:28:14'),
(235, 1, 'add', 'Добавлены данные в routes', '2013-12-18 19:30:35'),
(236, 1, 'edit', 'Изменены данные в ''Походы'' с `id`=2', '2013-12-18 19:31:03'),
(237, 1, 'add', 'Добавлены данные в hikes', '2013-12-18 19:31:27'),
(238, 1, 'add', 'Добавлены данные в hikes', '2013-12-18 19:31:40'),
(239, 1, 'add', 'Добавлены данные в hikes', '2013-12-18 19:32:09'),
(240, 1, 'edit', 'Изменены данные в ''Маршруты'' с `id`=1', '2013-12-21 23:30:10'),
(241, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=2', '2013-12-22 00:10:21'),
(242, 1, 'edit', 'Изменены данные в ''Меню сайта'' с `id`=9', '2013-12-22 00:10:39'),
(243, 1, 'edit', 'Изменены данные в ''Слайды'' с `id`=4', '2013-12-24 11:04:34'),
(244, 14, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-25 10:13:41'),
(245, 14, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-25 11:02:33'),
(246, 14, 'edit', 'Изменены данные в ''Инструкторы'' с `id`=1', '2013-12-25 11:02:40'),
(247, 14, 'add', 'Добавлены данные в adminmenu', '2013-12-25 11:59:28'),
(248, 14, 'add', 'Добавлены данные в reviews', '2013-12-25 14:01:06'),
(249, 14, 'edit', 'Изменены данные в ''Отзывы'' с `id`=1', '2013-12-25 14:02:34'),
(250, 14, 'edit', 'Изменены данные в ''Отзывы'' с `id`=1', '2013-12-25 14:04:54'),
(251, 14, 'add', 'Добавлены данные в reviews', '2013-12-25 14:10:09'),
(252, 14, 'edit', 'Изменены данные в ''Отзывы'' с `id`=2', '2013-12-25 14:10:15');

-- --------------------------------------------------------

--
-- Table structure for table `adminmenu`
--

DROP TABLE IF EXISTS `adminmenu`;
CREATE TABLE IF NOT EXISTS `adminmenu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `adminmenu`
--

INSERT INTO `adminmenu` (`id`, `parent`, `name`, `descr`, `url`, `priority`) VALUES
(17, 0, 'Логи', 'Логи панели управления', '/admin/common/adminlog.php', 26),
(43, 136, 'Страницы', 'Статические страницы', '/admin/static/static.php', 4),
(27, 0, 'Админы', 'Список админов', '/admin/common/admins.php', 11),
(44, 136, 'Меню сайта', 'Меню сайта', '/admin//site_menu.php', 10),
(45, 0, 'Меню админки', 'Управление меню административного интерфейса', '/admin/common/menus.php', 21),
(38, 0, 'Выход', 'Безопасный выход из административной панели', '/admin/common/logout.php', 48),
(136, 0, 'Сайт', 'Управление сайтом', '#', -1),
(200, 197, 'Инструкторы', 'Инструкторы', '/admin/trainers/trainers.php', 56),
(199, 197, 'Маршруты', 'Маршруты', '/admin/routes/routes.php', 55),
(198, 197, 'Регионы', 'Регионы', '/admin/routes/regions.php', 54),
(180, 0, 'Комментарии', 'Модуль социальных комментариев', '/admin/comments/messages.php', 45),
(197, 0, 'Походы', 'Список походов', '/admin/routes/hikes.php', 53),
(182, 0, 'Пользователи', 'Автоматические пользователи', '/admin/comments/users.php', 47),
(183, 180, 'Новые', 'Комментарии ожидающие проверки', '/admin/comments/messages.php?moderate=0', 46),
(184, 0, 'Справка', 'Справка', 'https://docs.google.com/document/d/1PVdZG72a9UYUyxzYOr3bwRpEZhBCQcjHiia7YdCiUNA/edit', 49),
(185, 27, 'Группы админов', '...', '/admin/common/ugroups.php', 12),
(193, 136, 'Группы меню', 'Группы меню сайта', '/admin/site_menu_types.php', 50),
(194, 0, 'Статьи', '...', '/admin/articles/article.php', 51),
(195, 194, 'Темы статей', 'Темы статей', '/admin/articles/types.php', 52),
(196, 136, 'Слайды', 'слайды на главной странице', '/admin/slides/slides.php', 9),
(201, 197, 'Отзывы', 'Отзывы клиентов', '/admin/reviews/main.php', 57);

-- --------------------------------------------------------

--
-- Table structure for table `adminugroups`
--

DROP TABLE IF EXISTS `adminugroups`;
CREATE TABLE IF NOT EXISTS `adminugroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `adminugroups`
--

INSERT INTO `adminugroups` (`id`, `alias`, `name`, `comment`) VALUES
(1, 'admins', 'Administrators', '...'),
(2, 'superHR', 'superHR', 'Могут видеть все вакансии'),
(3, 'HR', 'Ответственный', 'Ответственные. Могут видеть только вакансии в которых они ответственные.');

-- --------------------------------------------------------

--
-- Table structure for table `adminusers`
--

DROP TABLE IF EXISTS `adminusers`;
CREATE TABLE IF NOT EXISTS `adminusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `adminusers`
--

INSERT INTO `adminusers` (`id`, `email`, `group_id`) VALUES
(1, 'shevayura@gmail.com', 1),
(2, 'dkarmazin@gmail.com', 1),
(3, 'strudelstyle2@gmail.com', 1),
(4, 'g@computers.net.ua', 1),
(5, 'zolotaryov.anton@gmail.com', 1),
(6, 'grom193@gmail.com', 1),
(7, 'rizol@computers.net.ua', 1),
(8, 'al@computers.net.ua', 1),
(9, 'anekrasof@gmail.com', 1),
(10, 'dm@computers.net.ua', 1),
(11, 's@computers.net.ua', 1),
(12, 'e@computers.net.ua', 1),
(13, 'suhovey.tanya@gmail.com', 1),
(14, 'flybots@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `thumb_p` varchar(255) NOT NULL,
  `text_short` text NOT NULL,
  `text_long` longtext NOT NULL,
  `title` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `article_type`, `name`, `thumb`, `thumb_p`, `text_short`, `text_long`, `title`, `descr`, `keywords`, `updated_on`) VALUES
(1, 2, 'Как добраться в Лазещину с Ивано-Франковска', '/files/articles/1386786760_63.jpg', '/home/serg/www/localhost/files/articles/1386786760_63.jpg', '<p>Друзья, привет! В первую очередь эта статья адресована тем, кто едет с нами <a href="http://www.kuluarbc.com.ua/zimniy-otdyh/novyi-god-v-karpatah.html">на Новый год в Карпаты</a>. А если быть еще точнее, то тем из них, кто приезжает после контрольного времени сбора группы и у кого возник вопрос: &laquo;<strong>А как нам добраться до Лазещины?</strong>&raquo;</p>', '<p>&nbsp;</p><p>Теперь по порядку. Группа собирается в 7-10 утра (точное время будет примерно за 10 дней до выезда, проверяйте почту!) и мы едем &nbsp;в Лазещину все вместе. Тут вопросов у вас не возникаем, ибо мы их решаем. Но есть и такие, кто приезжает позже контрольного времени. Всей группе вас ждать смысла нет, ведь уже в первый день можно покататься на лыжах и съездить на Драгобрат или Буковель! &nbsp;Поэтому, опоздавшим нужно будет добраться до Лазещины самостоятельно. Если вы на своей машине, тогда пользуетесь gps. Для тех, кто приехал в Ивано-Франковск поездом или автобусом есть три способа:</p><ol>\r\n<li>\r\n	<strong>Заказной автобус/такси</strong> &ndash; этот вариант хорош, если вас группа из нескольких человек. Так же это самый комфортный и быстрый способ, но и самый дорогой. Стоимость 50-70 грн в зависимости от размера машины и количества человек. Дороже смысла нет договариваться, разве что в крайнем случае. Если вы сам, то можно найти попутчиков прямо на вокзале и скооперироваться с ними. Как найти таксистов? Лучше бы спросили как их не найти! При выходе с вокзала со стороны автовокзала (он левее в 200 метрах) стоит куча водил, которые как рыбы прилипалы пытаются перетащить вас к себе. Торгуемся!</li>\r\n<li>\r\n	<strong>Рейсовый автобус</strong>. Стоимость билета Ивано-Франковск &ndash; Лазещина составляет 35 грн, но есть проблема. С ноября 2013 что-то там не поделили держатели и теперь прямых рейсов с вокзала нет(( Остается вариант с пересадкой в Татарове. С воказала почти все автобусы едут через него, билеты покупаются в кассе автовокзала. Выходим с вокзала, стоим лицом к городу, поворачиваем налево и идем метров 200 &ndash; тут и найдете автовокзал. Выходим в Татарове и ловим автобус на Лазещину. Прямые рейсы перенесли на автостанцию 2 в Ивано-Франковске. Туда добираться проблемно.. На всякий случай расписание:</li>\r\n</ol><table border="1" cellpadding="0" cellspacing="0" style="height: 400px; width: 664px;">\r\n<tbody>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Сообщение</td>\r\n		<td style="text-align: center;" valign="top">\r\n			Время отправления</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			7.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			9.00</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Ясиня</td>\r\n		<td style="text-align: center;" valign="top">\r\n			9.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			11.00</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			11.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Ясиня</td>\r\n		<td style="text-align: center;" valign="top">\r\n			12.55</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Хуст</td>\r\n		<td style="text-align: center;" valign="top">\r\n			13.25</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Хуст</td>\r\n		<td style="text-align: center;" valign="top">\r\n			14.25</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Тячево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			15.45</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Рахов</td>\r\n		<td style="text-align: center;" valign="top">\r\n			16.40</td>\r\n	</tr>\r\n	<tr valign="middle">\r\n		<td valign="top">\r\n			Ивано-Франковск &ndash; Мукачево</td>\r\n		<td style="text-align: center;" valign="top">\r\n			17.55</td>\r\n	</tr>\r\n</tbody>\r\n</table><p>Есть еще пару автобусов позже, но лучше успевать на эти.</p><p>3. <strong>Дизелем/поездом.</strong> Это самый дешевый способ, но и самый долгий. Раньше был хороший дизель, который отправлялся в 9.15. Но я им давно не ездил и что-то в расписании не нахожу на это время.&nbsp; Так что есть два варианта: поездом Львов-Рахов, отправляется в 19.20 с Франковска, к Лазещине едет 3 часа и 10 минут или дизелем 6404 Ивано-Франковск &ndash; Рахов, он отправляется в 3:28 ночи. Неплохой вариант для тех, кто приезжает ночью.</p><p style="text-align: center;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/blog/laz1.jpg" style=""><img alt="как добраться до Лазещины" height="400" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-blog-laz1-600x400.jpg" width="600" /></a></p><p>Других простых способов добраться с Ивано-Франковска в Лазещину в голову не приходит. Я бы советовал ехать заказным автобусом. По приезду в Лазещину мы вас встретим,&nbsp; только позвоните заранее инструктору &ndash; его данные будут присланы вместе со временем сбора. До встречи, друзья!</p>', 'kak-dobratsya-v-lazehshcinu', '', 'Крым, Форос, article', '2013-12-18 19:09:54'),
(2, 1, 'Стивен Холзнер. XSLT библиотека программиста.', '/files/articles/1386787920_40.png', '/home/serg/www/localhost/files/articles/1386787920_40.png', '<p>Это единственная книга, которую я могу порекомендовать в качестве&nbsp; учебника. Она &nbsp;достаточно лаконична и написана живым человеческим языком&nbsp; и рассчитана на тех, &nbsp;кто&nbsp;не имеет многолетней привычки читать на ночь спецификации W3С.&nbsp;&nbsp;Книга построена таким образом, что все примеры берут за основу один и тот же XML-источник, поэтому путь от одного примера к другому идет существенно легче. &nbsp; При желании pdf-версию этого учебника &nbsp;можно найти в онлайновых библиотеках</p>', '<p>В своих заметках я постараюсь быть как можно короче, пропуская и не комментируя подробно, многие&nbsp; важные, но не существенные для быстрого старта вещи, отсылая к&nbsp; другим источникам.&nbsp;&nbsp; В первую очередь это&nbsp;подборка примеров на сайте <a href="http://www.zvon.or/">zvon.org</a>. &nbsp;Пока заметки находятся на стадии черновика, я буду всюду где смогу давать ссылки на примеры с этого сайта.&nbsp;&nbsp;<br /><br />Так же как и в HTML-верстке в XSLT существуют разные подходы к верстке и точно так же существуют разногласия по поводу возможности использования&nbsp; тех или иных приемов, стилей программирования (вспомним древнюю дискуссию о дивно-табличной верстке). &nbsp;На практике же, &nbsp;применяются все методы в различной комбинации, в зависимости от задачи.&nbsp;<br /><br />Я начну с легких для понимания методов, и &nbsp;относительно сложными. Относительно, потому что то с чем приходится сталкиваться при верстке <span style="font-weight: bold;">в большинстве случаев</span> не требует особых ухищрений. Сложности возникают, или на очень нетривиальных сайтах, &nbsp;или там,&nbsp; где архитекторы проекта поленились проработать&nbsp;структуру данных&nbsp; и вывалили на&nbsp; XSLT выполнение&nbsp;нехарактерных и ресурсоемких вычислительных функций. &nbsp;Сам по себе&nbsp; XSLT такой же язык стилевых таблиц как и CSS, но с большими возможностями. Большие возможности определяются наличием элементов, характерных для обычных языков программирования (обработка условий, циклы, процедуры, переменные) и специфических элементов <a href="http://ru.wikipedia.org/wiki/%D0%A4%D1%83%D0%BD%D0%BA%D1%86%D0%B8%D0%BE%D0%BD%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%BC%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5">функциональных языков</a> программирования, &nbsp;к которым относится XSLT. Там где возможно я стараюсь проводить аналогии между XSLT, CSS и JavaScript(PHP) и SQL, полагая&nbsp;, что HTML-верстальщик должен иметь представление об этих&nbsp; языках, и уж в обязательном порядке знать CSS.</p>', 'xslt', '<p>XSLT технологии&nbsp; начинают входить в реальную жизнь и практику HTML-верстальщиков. Несмотр на кризис в&nbsp; Яндексе и Рэмблере практически постоянно были открыты вакансии XSLT-верстальщиков. И не только там. Многие отечественные веб-студии, исполь', 'XSLT, HTML', '2013-12-11 20:52:00'),
(3, 2, 'Особенности походов на Кавказ', '/files/articles/1386788073_3.jpg', '/home/serg/www/localhost/files/articles/1386788073_3.jpg', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Красота Кавказа воспета во множестве баллад и стихотворений, ведь в этих горах объединились и суровые скальные вершины, и стремительные горные реки с водопадами, и разноцветье альпийских лугов. Словом все, что душа желает тут есть!</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Но есть и другая сторона медали &ndash; сложность. Дело в том, что Кавказ &ndash; это уже самые настоящие высокие горы, тут есть множество категорийный маршрутов, сложных перевалов и вершин. Именно это и привлекает сюда спортсменов-туристов. Они берут веревки, системы, кошки, железо и отправляются за новыми разрядами и впечатлениями. Мы же стараемся построить наши походы по Кавказу так, чтобы красоты природы сделать доступными всем желающим. От вас не требуется специальных навыков, а только хорошая физическая форма, сильная воля и желание.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p>', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:bold;font-style:normal;text-decoration:none;color:#333333;">Особенности походов по Кавказу:</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Вес рюкзака. В основном маршруты походов не круговые и проходят в отдалении от цивилизации. Возможности докупить продуктов не будет, поэтому с самого начала и до конца маршрута все несем на себе. Рюкзаки будут тяжелее, чем в походах по Крыму или Карпатам. Стараемся уменьшить вес используя сушку, сублиматы, заменитель сахара.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Высота. Большинство маршрутов проходит на высоте более 2000 метров, где дров уже нет, соответственно и костер палить не из чего. Еду готовим на горелках.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Чувство голода. На чистом воздухе, при больших нагрузках, организму постоянно хочется кушать. Помня об ограниченном весе рюкзака, это желание придется перебороть и свыкнуться с ним. Обычно оно возникает уже на 2-3-й день похода. Меню составлено так, что энергии и калорий будет достаточно, но за поход вы все же похудеете и подсушитесь.&nbsp; Кстати, кому надо &ndash; возьмите на заметку))</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Мокрые ноги. Будет много бродов, поэтому ноги зачастую мокрые. Как ни странно, но толи климат такой, толи еще что, но простудные заболевания на Кавказе редкость. А вот мозоли нет, поэтому запасаемся пластырем. Лично меня от мозолей спасали хорошие треккинговые ботинки и термоноски.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Вода. В чем-чем, а вот в воде недостатков нет. Тысячи небольших ручейков, водопадиков и речушек будут на нашем пути.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Погода. Утро обычно солнечное, но к обеду собираются тучи, а к вечеру уже может пойти дождь. При чем, не просто пойти, а полить, как из ведра. До этого времени уже нужно стать лагерем. Впрочем, бывают и походы с одним-двумя небольшими дождиками. Как повезет.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Погранзона. Некоторые маршруты проходят через погранзону, пропуска туда оформляются за 2 месяца до начала похода. На такие туры заявки нужно подавать очень заранее.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Удаленность. Большинство маршрутов удалены от цивилизации и до ближайшего поселка может быть несколько дней пути. Поэтому, если решились идти в поход, то надо идти до конца. Тут уже не получится так просто сойти с маршрута, как в походах по Крыму.</span></p>', 'article-kavkaz-1', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">завтрак на Кавказе</span></p>', 'Кавказ', '2013-12-11 20:54:33'),
(4, 2, 'Особенности походов по Турции ', '/files/articles/1387386846_49.jpg', '/home/serg/www/localhost/files/articles/1387386846_49.jpg', '<p>Турция очень интересная и разнообразная страна. Для большинства людей она в первую очередь ассоциируется с пляжным отдыхом, ведь погода здесь большую часть года радует солнышком, а побережья действительно прекрасные. Но нам-то более интересны горы, а их в Турции тоже предостаточно! К слову, большую часть страны занимает именно горный рельеф, а самая высокая точка &ndash; гора Арарат, высотой целых 5137 метров!</p><p>История Турции очень насыщена и насчитывает более 10 тысяч лет. Благодаря этому на всей территории сохранилось множество исторических памятников, таких как античные города, древние крепости, красивейшие дворцы. Конечно, от прошлого великолепия строений древности остались лишь развалины, но они тоже очень интересны и красивы. Кроме этого Турция богата и на природные достопримечательности, такие как &nbsp;глубокие каньоны, водопады, горы соленые озера, пещеры и другие. Так что будет очень интересно!</p>', '<h2>Климат Турции</h2><p>Климат в Турции весьма жаркий, по сравнению с привычным нам. Отдыхать здесь можно с апреля по ноябрь, но летние месяцы слишком жаркие для активного туризма, поэтому мы стараемся ставить в расписание наши <a href="http://www.kuluarbc.com.ua/ekzotika/">походы по Турции</a> весной и осенью. Именно в это время самая комфортная температура, а вода в море уже/еще достаточно теплая для купания. В декабре начинается сезон дождей, за месяц может быть и до 12-ти дождливых дней.</p><h2>Документы</h2><p>Очень хорошая новость, так как с 2012 года визовый режим для граждан Украины, России и Беларуси отменен. Теперь вам нужен только действующий загран паспорт &ndash; <a href="http://www.kuluarbc.com.ua/ekzotika/pohod-po-likiyskoy-trope.html">походы по Турции</a> стали еще доступнее))</p><p style="text-align: center;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/blog/osobennosti/turciya.jpg" style=""><img alt="особенности Турции" height="337" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-blog-osobennosti-turciya-600x337.jpg" width="600" /></a></p><h2>Как добраться</h2><p>Добираться лучше всего лоукост компаниями, такими как Виззейир или Пегасус. Билеты обойдуться примерно в 150-250$ в обе стороны. Покупать лучше заранее! По городам: <a href="http://wizzair.com/" target="_blank">WizzAir</a> летает из Киева, <a href="http://www.flypgs.com/ru/" target="_blank">Pegasus</a> из Харьков, Донецка, Львова, Омска, Краснодара, <a href="http://www.turkishairlines.com/" target="_blank">Turkish Airlines</a> с Киева и Москвы. Выбирайте, чем удобнее и полетели)</p><h2>Безопасность</h2><p>Местное население очень любит туристов и всячески им помогает. И это даже не потому, что туристы несут им деньги, а просто менталитет такой у них. Подобное отношение действительно очень приятно. Большинство турок мусульмане, девушкам стоит одеваться скромнее.</p><p>Некоторую угрозу несут сколопендры и скорпионы. Они встречаются не очень часто, но все возможно. Чтобы свести шансы встречи с пренеприятными насекомыми к минимуму, нужно всегда закрывать палатку, проверять обувь, вытрушивать вещи, осторожно собирать дрова. Их укусы не смертельны, но очень болезненные, что само по себе неприятно.</p><h2>Для кого?</h2><p>В первую очередь походы по Турции рекомендуются тем, кто уже находился по Украине и хочет разнообразить, сделать более интересным и экзотическим свой отдых. Средний поход по турецким горам сложнее аналогичного <a href="http://www.kuluarbc.com.ua/pohody-krym/">похода по Крыму</a> или Карпатам, то есть Турция может послужить вам неплохой подготовкой для более сложных <a href="http://www.kuluarbc.com.ua/pohody-kavkaz/">походов по Кавказу</a>, Альпам, <a href="http://www.kuluarbc.com.ua/ekzotika/trekking-v-nepale-kolco-annapurny.html">Непалу</a> или другим высоким регионам. Но если вы еще не были в походах, все равно можете смело &nbsp;идти в Турцию! Маршруты построены так, что они под силу каждому!</p><p>Посмотреть на удивительную природу Турции стоит однозначно, так что присоединяйтесь!</p>', 'osobennosti-pohodov-po-turcii', '', 'туризм, снаряжение', '2013-12-18 19:14:06'),
(5, 1, 'Горная болезнь (горнячка)', '/files/articles/1387386960_55.jpg', '/home/serg/www/localhost/files/articles/1387386960_55.jpg', '<p><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><strong>Горная болезнь</strong>, она же <strong>горнячка</strong>, <strong>горняшка</strong>, <strong>высотная болезнь</strong> &ndash; болезненное состояние, возникающее у людей, что подымаются на высоту от 3&nbsp;000 метров. Вызвано кислородным голоданием организма (гипоксия).&nbsp; В следствии малого поступления кислорода в кровь, клетки не могут выполнять свои функции полноценно и выбрасывают шлаковый балласт в кровь, он быстро разносится по организму и вас &quot;накрывает&quot;.</span></span></p>', '<p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Сложность протекания и симптомы горной болезни зависят от высоты, степени акклиматизации, вашего физического состояние, нагрузок, времени нахождения на высоте.. <strong>Очень условно</strong> можно разделить симптоматику и сложность протекания горнячки &nbsp;по высотным коридорам:</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><strong>Легкая стадия</strong>, возникает на высоте 3&nbsp;000 &ndash; 4&nbsp;000 метров. Основные симптомы:</span></span></p><div style="text-align: justify;"><ul>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Легкое расстройство желудка (диарея);</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Потеря аппетита. Даже после сложного и насыщенного дня вам не хочется кушать, более того, от<a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/blog/gornaya-bolezn.jpg" style=""><img alt="высотный коридор" height="282" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-blog-gornaya-bolezn-214x282.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="214" /></a> одной мысли о еде вас мутит &ndash; это она, горнячка. А если по приходу в лагерь вы голодны как лев &ndash; это очень хороший признак, значит акклиматизация проходит хорошо.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Повышенное давление. Характерно появлением пульсирующих точек, шума в ушах.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Скачки настроения. В считанные минуты заряд бодрости сменяется чувством пофигизма и апатии ко всему, упадническим настроем.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Плохой сон, бессонница.</span></span></li>\r\n</ul></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Для уменьшения неприятных симптомов рекомендуется пить как можно больше воды.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><strong>Средняя стадия</strong>, возникает на высоте 4&nbsp;000 &ndash; 5&nbsp;500 метров, тут симптомы уже будут посерьезнее:</span></span></p><div style="text-align: justify;"><ul>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Общее подавленное состояние. Наступает полная апатия и не желание делать хоть что-то. Ни в коем случае нельзя поддаваться такому настрою, рассказывайте анекдоты, пейте песни, лепите снеговую бабу=)</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Пульсирующая или давящая головная боль. Боремся анальгетиками.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Тошнота, рвота. Терпим, стараемся отвлечься общением и нагрузками. Если не помогает можно принять таблетку церувала.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Повышенная температура. Пугаться не стоит, это характерно для акклиматизации.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Понижение эффективности работы. Из-за гипоксии мозг начинает работать гораздо медленнее, вам сложно сосредоточиться хоть на чем-то. То, что раньше занимало 10 минут, приходится делать час.</span></span></li>\r\n</ul></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><strong>Тяжелая стадия</strong>, возникает на высоте 5&nbsp;500 &ndash; 6&nbsp;000 метров. Симптомы такие:</span></span></p><div style="text-align: justify;"><ul>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Сильная рвота. </span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Непреходящая головная боль, иногда и таблетки не помогают.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Потеря координации, головокружение, дезориентация.</span></span></li>\r\n<li>\r\n	<span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Постоянный кашель.</span></span></li>\r\n</ul></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Горячий сладкий чай, тепло, покой. Если состояние не улучшается спуск на 500-600 метров и повторная попытка через сутки.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><strong>Очень тяжелая стадия</strong>, высоты более 6&nbsp;000 метров. Все вышеперечисленные признаки, сильно умноженные. Так как на такой высоте организм работает исключительно на износ, обязательным является спуск вниз. Крайние стадии горной болезни &ndash; отек мозга и отек легких.</span></span></p><h3 style="text-align: justify;">Правильная акклиматизация</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><strong>Правильная акклиматизация</strong> поможет если не избежать, то значительно уменьшить неприятные признаки горной болезни. Любые непривычные высоты &ndash; это стресс для организма. Но человек такое существо, что может адаптироваться практически ко всему, только дай достаточно времени. Отсюда и первое правило успешное акклиматизации &ndash; медленный набор высоты, что бы в организма было достаточно времени привыкнуть к разреженному воздуху.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Высотную акклиматизацию можно поделить на две стадии: краткосрочная и долговременная. Краткосрочная &ndash; это ускорение метаболизма организма, запуск регенеративных процессов, проходит в первые 2-4 дня подъема. Далее наступает долговременная, именно она покажет на сколько хорошо вы подготовлены к высоте.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Главное правило успешной акклиматизации гласит: &laquo;Иди выше, спи ниже&raquo;. То есть мы получаем зубчатую схему подъема на высоту.<a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/blog/gornaya-bolezn2.jpg" style=""><img alt="акклиматизация" height="260" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-blog-gornaya-bolezn2-326x260.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="326" /></a>Она выглядит так: вы поднялись к месту предполагаемой ночевки, но не остаетесь на этой высоте, а подымаетесь еще метров на 300 выше. На новой высоте нужно провести некоторое время, желательно активно, с нагрузками для организма. Далее спускаемся к месту ночевки и спим спокойно. Если повезет, горнячку вы &laquo;оставите&raquo; выше и сможете нормально выспаться.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">После 3&nbsp;000 метров старайтесь не подыматься за день больше чем на 500-600 метров, а после каждой набранной тысячи делать дневку. Ведь организму нужно время.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Лучшее время для проверки качества адаптации организма к высоте ночь. Если днем вы можете переносить трудности благодаря железной воле и самоконтролю, то ночью вы расслабляетесь, исчезает (хотя бы частично) мобилизация ЦНС. Хороший способ проверки &ndash; сравнение утреннего и вечернего пульса. Утренний должен быть меньше вечернего и составлять 80-90%. Если же утром пульс выше, для акклиматизации на этой высоте нужно дополнительное время.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Никогда не подымайтесь на большую высоту транспортом, иначе вас накроет по полной!</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Важно понимать и помнить, что высотная акклиматизация индивидуальна и каждому нужно разное время для адаптации и восстановления. Замечено, что женщины лучше переносят гипоксию, чем мужчины, люди старшего возврата - чем молодежь. Лишний вес мешает адаптации, ведь что бы насытить большой организм, нужно больше кислорода. Поэтому хрупкая девчонка гораздо лучше переносит нехватку кислорода, чем качек-спортсмен.</span></span></p><h3 style="text-align: justify;">Способы лечения горной болезни</h3><div style="text-align: justify;"><span style="font-size: 12pt;">Е<span style="font-family: times new roman,times;">сли акклиматизация прошла не совсем успешно и все же &laquo;прихватило&raquo; нужно пить очень много жидкости, отдохнуть и прекратить подъем. Прекращение подъема, как правило, позволяет утратить признаки горнячки в течении 24-48 часов. Если без лекарств не обойтись, примите обезболивающие, &nbsp;анальгетики (парацетамол, ибупрофен). Так же рекомендуют принимать диамокс (ацетазоламид, дикарб), это мочегонный препарат, уменьшающий внутреннее давление. Рекомендуется дозы до 250 мг каждые 8 часов. Ну и не забываем о витамине С, он обладает антиоксидантними свойставми. Кушать аскорбинки нужно много, до 400 мг в сутки.</span></span></div>', 'gornaya-bolezn', '', 'туризм, снаряжение', '2013-12-18 19:16:00');

-- --------------------------------------------------------

--
-- Table structure for table `article_types`
--

DROP TABLE IF EXISTS `article_types`;
CREATE TABLE IF NOT EXISTS `article_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `article_types`
--

INSERT INTO `article_types` (`id`, `name`, `text`, `title`, `descr`, `keywords`, `priority`) VALUES
(1, 'Блог о туризме', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Блог о туризме.. Хм. О чем же ж тут писать? =)) Конечно, о туризме и о всем, что его касается! Здесь будут стать о снаряжении, об особенностях походной жизни, о погоде в горах, просто размышления у костра - в общем все что взбредет в голову и чем захочется поделиться! Возмоно будут не только мои статьи, а и других авторов.</span></p>', 'blog', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Блог о туризме.. Хм. О чем же ж тут писать? =)) Конечно, о туризме и о всем, что его касается! Здесь будут стать о снаряжении, об ос', 'Крым, Форос', 2),
(2, 'Особенности походной жизни', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</span></p>', 'pohod', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о жизни в походе. Чем она отличается от обычной, что делать, что бы походы были в удовольствие, а не превращались в каторгу)</sp', 'Особенности походной жизни', -3),
(3, 'О снаряжении', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Все о туристическом снаряжении. Технологии, материалы, способы использования, новинки и тд..</span></p>', 'sn', '', 'туризм, снаряжение', 3),
(4, 'Костер в походе', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Особенности походного костра, хитрости и тоноксти, которые помогут вам без проблем разжечь костер в любую погоду.</span></p>', 'koster', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Особенности походного костра, хитрости и тоноксти, которые помогут вам без проблем разжечь костер в любую погоду.</span></p>', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `hikes`
--

DROP TABLE IF EXISTS `hikes`;
CREATE TABLE IF NOT EXISTS `hikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_finish` date NOT NULL,
  `trainer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `hikes`
--

INSERT INTO `hikes` (`id`, `route_id`, `date_start`, `date_finish`, `trainer_id`) VALUES
(1, 1, '2013-12-31', '2014-01-07', 1),
(2, 2, '2014-01-15', '2014-01-28', 1),
(3, 3, '2014-02-05', '2014-02-10', 2),
(4, 3, '2013-12-31', '2014-01-07', 3),
(5, 1, '2014-02-22', '2014-02-25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `name`, `desc`, `url`, `priority`, `type_id`, `module_id`) VALUES
(1, 0, 'Крым', 'Крым', '/region/krimea', 0, 1, 0),
(2, 1, 'Маршруты', 'Маршруты', '/routes/filter/crimea', 1, 1, 0),
(3, 1, 'Отзывы', 'Отзывы', '/review/crimea', 2, 1, 0),
(4, 1, 'Особенности', 'Особенности', '/features/crimea', 3, 1, 0),
(8, 0, 'Карпаты', 'Карпаты', '/region/karpaty', 7, 1, 0),
(9, 8, 'Маршруты', 'Маршруты', '/routes/filter/karpaty', 8, 1, 0),
(10, 8, 'Отзывы', 'Отзывы', '/review/karpaty', 9, 1, 0),
(11, 8, 'Особенности', 'Особенности', '/features/karpaty', 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_types`
--

DROP TABLE IF EXISTS `menu_types`;
CREATE TABLE IF NOT EXISTS `menu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu_types`
--

INSERT INTO `menu_types` (`id`, `name`, `alias`, `desc`) VALUES
(1, 'Главное меню', 'menu_top_1', '');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `dir`, `active`, `priority`) VALUES
(1, 'Статические страницы', 'static', 1, 13),
(8, 'news', 'news', 0, 9),
(9, 'reviews', 'reviews', 1, 7),
(10, 'routes', 'routes', 1, 12),
(15, 'trainers', 'trainers', 1, 11),
(14, 'articles', 'articles', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_text` mediumtext NOT NULL,
  `page_description` text NOT NULL,
  `page_keywords` text NOT NULL,
  `page_link` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `show_changes` tinyint(1) NOT NULL,
  `changes` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `page_text`, `page_description`, `page_keywords`, `page_link`, `menu_id`, `show_changes`, `changes`) VALUES
(1, 'О нас', '<p>Одной из задач IT службы предприятия (аутсорсинговой, или штатной) является обеспечение сохранности данных как в штатных так и в исключительных ситуациях. Профессионалы же делают исключительные ситуации штатными, детально их прорабатывая. С этой целью около полугода назад мы подняли backup сервер для резервного копирования данных наших клиентов.</p><p>Резервное копирование бывает ручное и автоматическое. Также не стоит путать резервное копирование с архивированием. Задача резервного копирования - хранить несколько актуальных версий данных на случай &ldquo;все пропало, нужно срочно восстановить&rdquo;. Архивирование же предназначено для доступа к данным за прошлый год, или прошлую пятилетку. Мы эти две услуги объединяем. Обычно ежедневные резервные копии хранятся в течении месяца, а ежемесячные - пожизненно. При необходимости срок хранения можно изменить.</p>', 'backup', 'backup', 'about', 0, 0, '2013-12-17 20:08:43'),
(2, 'ЧАВо', '<p>Иногда встречается русский аналог этого сокращения&nbsp;&mdash; <b>ЧАВО</b> (что, как полагают, означает <b>ча</b>стые <b>во</b>просы или же <b>ча</b>сто задаваемые <b>в</b>опросы и <b>о</b>тветы) или простой перевод английской аббревиатуры <b>ЧЗВ</b> (<b>ч</b>асто <b>з</b>адаваемые <b>в</b>опросы). Нередко в <a href="http://ru.wikipedia.org/wiki/%D0%A0%D1%83%D0%BD%D0%B5%D1%82" title="Рунет">рунете</a> встречается и прямая <a href="http://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%B0%D0%BD%D1%81%D0%BB%D0%B8%D1%82%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D1%8F" title="Транслитерация">транслитерация</a>, ФАК (&laquo;посмотри в ФАКе&raquo;).</p><p>Существует множество FAQ, посвящённых самым разным темам. Некоторые сайты каталогизируют их и обеспечивают возможность поиска&nbsp;&mdash; например, <a class="new" href="http://ru.wikipedia.org/w/index.php?title=Internet_FAQ_Consortium&amp;action=edit&amp;redlink=1" title="Internet FAQ Consortium (страница отсутствует)">Internet FAQ Consortium</a> .</p><p>В <a href="http://ru.wikipedia.org/wiki/%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82" title="Интернет">Интернете</a> часто можно встретить грубое произношение, то есть, &quot;<a href="http://ru.wikipedia.org/wiki/Fuck" title="Fuck">fuck</a> you&quot;.</p>', '', '', 'faq', 0, 0, '2013-12-17 20:09:00'),
(3, 'Контакты', '<p class="single-first-p">The purpose of any website is to get people from your target audience interested in what you&rsquo;re offering. Whether it be a product or service, 9 times out of 10, someone is going to want to communicate with you further. Because of this, in almost any industry, you&rsquo;re going to want to create a contact page.</p><p>For some, this is that last page on the site map where you just throw a bunch of information. You can leave it up to the person to decide how they want to contact you and what they want to contact you about. For others, this is the last attempt to get your potential customer to give you their business.</p><p>The contact page is much more important than many give it credit. Many basic websites just throw some numbers and e-mails up and move along. But in most cases, this is the page your customer sees before they decide they want you on their project. Or before they decide they want to visit you to purchase your product.</p><p>It&rsquo;s extremely important to make sure your contact page delivers in the best way possible. It can be a tricky thing to handle, so today, we&rsquo;ve gathered 20 sites with great contact pages and forms to give you a bit of a creative boost.</p>', '', 'contact page', 'contact', 0, 0, '2013-12-17 20:12:29'),
(4, 'Как пойти в поход? ', '<div class="headline"><h1 class="title">Как пойти в поход?</h1></div><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/anketa/anketa1.jpg" style=""><img alt="Как пойти в поход Крым" height="200" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-anketa-anketa1-267x200.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="267" /></a>Если у вас появилась неделька свободного времени, ее хочется провести активно, незабываемо и максимально интересно. А что для этого нужно сделать? Правильно, пойти в походы по Крыму или Карпатам! Где еще познакомишься&nbsp; с замечательными людьми, налюбуешься красотами природы, отдохнешь и наберешься сил за такой короткий отрезок времени? Масса приятных эмоций и теплых воспоминаний гарантировано каждому участнику!</p><p style="text-align: justify;">И так, желание у вас есть, а в этой статье я напишу, что нужно сделать, что бы пойти с нами.</p><h3 style="text-align: justify;">Общение и выбор тура.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В колонке справа на сайте есть расписание маршрутов. </span></span><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/anketa/anketa2.jpg" style=""><img alt="Как пойти в поход" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-anketa-anketa2-225x150.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="225" /></a></span></span><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Выберите подходящий </span></span><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"> </span></span><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">(почитать детальное описание можно перейдя по ссылке с расписания или в маршрутах походов) и заполните заявку на участие в походе. Я вам пришлю анкету, обязательную для заполнения каждым участником похода. Заполните ее как можно полнее, но если какое-то из полей заполнить не можете &ndash; ничего страшного, присылайте как есть. Далее с вами будем общаться по телефону, почте или вконтакте &ndash; кому как удобнее. Естественно, у вас возникнет куча вопросов, на которые я отвечу. По мере поступления новостей относительно похода, буду держать всех в курсе.</span></span></p><h3 style="text-align: justify;">Покупка билетов.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Желательно за месяц &nbsp;до начала похода уже купить билеты. Сообщите мне&nbsp;<a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/anketa/anketa3.jpg" style=""><img alt="В походе по Крыму" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-anketa-anketa3-200x150.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="200" /></a> номер поезда и время прибытия, так я буду уверен, что вы прибудете вовремя (нужно стараться в 10-11 утра быть на месте) и это будет подтверждением вашего участия, ведь предоплата не берется. Посмотреть расписание поездов можно на оф сайте Укрзалізниці <a href="http://www.uz.gov.ua/" rel="nofollow">http://www.uz.gov.ua/</a>, а заказать билет и узнать о наличие мест можно тут <a href="http://www.e-kvytok.com.ua/" rel="nofollow">http://www.e-kvytok.com.ua</a> или на сайтах других компаний, что занимаются продажей билетов.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><strong>Всегда покупайте билет заранее!</strong> На майские праздники и перед Новым Годом их разметают за считаные дни (и даже часы). Продажа билетов начинается за 45 дней до отправки поезда и лучше купить билет уже в первый день.</span></span></p><h3 style="text-align: justify;">Подготовка к походу.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Для вас подготовка в основном заключается в подборе нужного снаряжения. Предварительно познакомиться со <a href="http://www.kuluarbc.com.ua/vse/chto-vzyat-v-pohod.html">списком снаряжения для похода</a> можно на сайте. Зимой холоднее и нужно больше теплых вещей, поэтому и <a href="http://www.kuluarbc.com.ua/snaryaga/spisok-snarjazheniya-dlya-zimnego-pohoda.html">список снаряжения для зимнего похода </a>немного другой. Ближе к походу я вам вышлю точный список вещей, в зависимости от региона и ожидаемой погоды.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Если у вас нет рюкзака, спальника, коврика &ndash; их можно <a href="http://www.kuluarbc.com.ua/snaryaga/prokat.html">взять на прокат</a> или поискать у друзей. Наверняка, во время сборки у вас будет возникать множество вопросов &ndash; пишите, обязательно отвечу.</span></span></p><h3 style="text-align: justify;">Встреча группы.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;">Группа встречается на ж/д вокзале города, указанного стартовым в описание похода. <a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/anketa/anketa4.jpg" style=""><img alt="В Карпатах" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-anketa-anketa4-200x150.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="200" /></a>Обычно это Симферополь или Бахчисарай для Крыма, Ивано-Франковск для Карпат. Примерно за неделю до похода мы сообщим вам точное место и время встречи, а также контакты инструктора, который поведет группу.</span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;">При встрече инструктор осмотрит ваше снаряжение и раздаст каждому его долю продуктов (2-7 кг). После этого группа переедет к началу маршрута рейсовым транспортом или заказной машиной. О пешей части похода детальнее можно почитать в статьях об <a href="http://www.kuluarbc.com.ua/poradu/">особенности походной жизни</a>.</span></p><h3 style="text-align: justify;">Прощание</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Походные дни пролетают очень быстро, они насыщены новыми впечатлениями,<a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/anketa/anketa5.jpg" style=""><img alt="Общение возле костра" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-anketa-anketa5-225x150.jpg" style="margin: 7px; float: right; border: 1px solid #000000;" width="225" /></a> красотами окружающего мира и общением в веселой компании. Компании, которая из кучки не знакомых людей к концу похода становится настоящим дружным коллективом. Очень и очень многие находят в походах отличных друзей (ну и проверяют старых=).</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Все хорошее рано или поздно кончается, так и наш поход.. это немного грустно, но неизбежно. За последним походным ужином или завтраком все участники обмениваются контактами, договариваются про обмен фотками.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Обычно походы заканчиваются в курортных поселках возле моря, и вы можете продолжить свой отдых, сняв домик или оставшись жить в платке.</span></span></p><h3 style="text-align: justify;">Пишите отзывы.</h3><div style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">По возвращению домой обязательно напишите отзыв о походе (буду очень благодарен). Это может быть отдельная статья или просто пара фраз на форуме. Статьи присылайте мне, я опубликую их на сайте.</span></span></div>', '', '', 'how_to_go', 0, 0, '2013-12-17 20:18:59'),
(5, 'Подготовка', '<h3 style="text-align: justify;">Подготовка к походу.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Для вас подготовка в основном заключается в подборе нужного снаряжения. Предварительно познакомиться со <a href="http://www.kuluarbc.com.ua/vse/chto-vzyat-v-pohod.html">списком снаряжения для похода</a> можно на сайте. Зимой холоднее и нужно больше теплых вещей, поэтому и <a href="http://www.kuluarbc.com.ua/snaryaga/spisok-snarjazheniya-dlya-zimnego-pohoda.html">список снаряжения для зимнего похода </a>немного другой. Ближе к походу я вам вышлю точный список вещей, в зависимости от региона и ожидаемой погоды.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Если у вас нет рюкзака, спальника, коврика &ndash; их можно <a href="http://www.kuluarbc.com.ua/snaryaga/prokat.html">взять на прокат</a> или поискать у друзей. Наверняка, во время сборки у вас будет возникать множество вопросов &ndash; пишите, обязательно отвечу.</span></span></p>', '', '', 'prepare', 0, 0, '2013-12-17 20:21:01');
INSERT INTO `pages` (`id`, `page_name`, `page_text`, `page_description`, `page_keywords`, `page_link`, `menu_id`, `show_changes`, `changes`) VALUES
(6, 'Что взять в поход? ', '<div class="headline"><h1 class="title">Что взять в поход? Список вещей для похода.</h1></div><h2 class="subtitle" style="text-align: center;">Что взять с собой в поход в горы? Список вещей в поход, которые Вам пригодятся в горах!</h2><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><strong>Что взять с собой в поход в горы?</strong> Этот вопрос задают многие, особенно новички и те, кто идут в поход впервые. Но и опытные волки иногда уделяют слишком мало внимания сборам и забывают нужные вещи, поэтому перед Вами <strong>список вещей в поход</strong>, которые Вам обязательно пригодятся.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Это список для летнего похода, а для зимнего можно посмотреть тут: <a href="http://www.kuluarbc.com.ua/snaryaga/spisok-snarjazheniya-dlya-zimnego-pohoda.html">Что взять в поход? Список снаряжения для зимнего похода в Крым и Карпаты.</a></span></span></p><br /><h3 style="text-align: justify;">Рюкзак.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod.jpg" style=""><img alt="Рюкзак для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod-167x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="167" /></a><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Рюкзак, спальник и каримат - это вещи без которых поход маловозможен. Конечно, можно пойти с сумкой на колесиках, одеялом и гамаком, но после этого вам больше не захочется ходить в походы, поверте на слово!</span></span></p><br /><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Рюкзак должен быть такого обьема, что бы туда все влезло и ничего не было снаружи. Для мужчин это 80-100 л, для женщин - 60-90 л.&nbsp; Можно ходить с рюкзаком меньшего объёма, но часть вещей придётся привязывать снаружи. Такой рюкзак будет не так ветро- и веткообтекаем, и в случае дождя эти вещи наверняка намокнут. Лучше взять больший рюкзак, например 130л, его можно подтянуть,&nbsp; а вот рюкзак на 40л не увеличишь..</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">В выборе рюкзака для походов вам поможет статья: <a href="http://www.kuluarbc.com.ua/snaryaga/backpack.html">Как выбирать, паковать и одевать рюкзак для похода.</a></span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Если у Вас нет своего рюкзака, Вы можете взять его у нас <a href="http://www.kuluarbc.com.ua/snaryaga/prokat.html">на прокат</a>.</span></span></p><h3 id="sleeping-bag" style="text-align: justify;">Спальник.</h3><div style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod1.jpg" style=""><img alt="Спальник для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod1-220x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="220" /></a><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Выбор спальника зависит от времени года, когда проводится поход и от места и его климатических особенностей. Соответственно, если вы идете летом в Крым - вам подойдет летний вариант спальника. Если же поход планируется весной или осенью(а тем более зимой)&nbsp; тут вам уже нужен зимний спальник. Что можно ожидать от похода и какой лучше брать вы можете спросить у вашего инструктура, температурный режим спальников можна увидеть на чехле.</span></span></div><div style="text-align: justify;">&nbsp;</div><h3 style="text-align: justify;">Каримат.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod3.jpg" style=""><img alt="Каримат для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod3-257x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="257" /></a></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Основная цель каримата - теплоизоляция тела и холода от земли. Кроме этого они легкие, пластичные и защитят вас не только от холода, а и от влажности, что делает каримат просто не заменимой вещью в походи.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В даный момент лучшие по соотношению цена/качество &quot;Ижевские&quot; кариматы(такие двухцветные). их и лучше всего брать в поход.</span></span></p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Сидушка.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod2.jpg" style=""><img alt="Походная сидушка" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod2-196x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="196" /></a><span style="font-size: 12pt;"> <span style="font-family: times new roman,times;">Кусок каримата, к которому прикреленная резинка. Именно с помощью ее сидушка крепиться к вашему поясу. Можно изготовить самому, а можно купить в магазине, стоят они не дорого.</span></span></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><h3 style="text-align: justify;">Дождевик.</h3><div style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Дождевик можно изготовить самому или купить на базаре (магазине). Сразу скажу что покупать на базаре не стоит, хоть они и дешевые, но качества никудышнего и очень быстро порвутся. Можно купить в специализированных магазинах туристического снаряжения непромокаемую накидку, она хоть и дорогая но надежная, и защитит не только вас, но и ваш рюкзак. Если делать самому - то из плотного полиэтилена, такие дождевики долго будут служить вам верой и правдой.</span></span></div><h3 style="text-align: justify;">Кроссовки (ботинки).</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod4.jpg" style=""><img alt="Ботинки для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod4-164x150.jpg" style="float: left; border: 1px solid #000000;" width="164" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod5.jpg" style=""><img alt="Правильная подошва" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod5-295x150.jpg" style="margin: 0px 7px 0px 0px; float: left; border: 1px solid #000000;" width="295" /></a> <span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В поход нужно брать две пары обуви. </span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Основной обувью должна быть пара туристических кросовок или трекинговых ботинок. Первые легче и быстрее сохнут, зато вторые предохраняют ноги от вывихов и более надежны на сложных поверхностях.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Запасной парой могут быть обычные кросовки или кеды, они нужны для небольших радиальных выходов и когда основные полностью промокнут.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Детальнее о том, какую обувь выбрать читаем в статье &quot;<a href="http://www.kuluarbc.com.ua/snaryaga/shoes.html" title="Обувь в поход">Обувь для похода</a>&quot;</span></span></p><h3 style="text-align: justify;">Носки.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod10.jpg" style=""><img alt="Носки для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod10-150x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="150" /></a></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Носков нужно брать в поход около 5-ти пар. Желательно что бы были специальные термоноски, но можно обойтись и обычными.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Так же нужно взять отдельную пару теплых носков для сна.</span></span></p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Спортивные штаны.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Штаны могут быть как обычными спортивными так и туристическим. Главное что бы они были легкими, быстро сохли или не промокали вовсе. Джинси и похожие штаны брать не желательно</span></span>.</p><h3 style="text-align: justify;">Футболки.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod6.jpg" style=""><img alt="Термобелье для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod6-150x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="150" /></a></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Обычная х/б футболка - как раз то, что вам надо для летнего похода. Такие футболки хорошо охлаждаются, впитывая влагу с тела и вам уже будет не так жарко.&nbsp; Футболок нужно около 3-х штук. Так же можно брать синтетическии или термофутболки. Термофутболки сохранят вашу кожу сухой и обеспечат масимально возможную термоизоляцию.</span></span></p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Шорты.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В летнем походе шорты будут вам незаменимой вещью! Я предпочитаю брать легкие шорты, которые фактически не чуствуются на теле во время ходьбы.</span></span></p><h3 style="text-align: justify;">Рубашка.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Кроме обычных футболок в поход обязательно нужно взять гольф или рубашку с длинными рукавами, они защитят вас от солнечных лучей и от ветра</span></span>.</p><h3 style="text-align: justify;">Полар/флис/свитер.</h3><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod7.jpg" style=""><img alt="Флиска " height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod7-145x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="145" /></a> <span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Даже в летних походах в Крыму вечерами на высоте бывает весьма прохладно. Для таких случаев у вас должен быть полар или флис, купить их можно в каждом туристическом магазине. Важное свойство флиса - то что он отводит флагу, при этом удерживая теплоту в средине.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Можно обойтись и обычным свитером, но весить и занимать места в рюкзаке он будет значительно больше! К тому же, в случае намокания, будет гораздо дольше сохнуть.</span></span></p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Ветровка.</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod8.jpg" style=""><img alt="Походная легкая куртка" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod8-111x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="111" /></a></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Легкая ветровка - то что вам нужно в ветренную погоду. Не стоить брать тяжелых курток, она должна мало весить и занимать места с кулак.</span></span></p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Панама (кепка, бандана, бафф).</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod12.jpg" style=""><img alt="Применение баффа" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod12-160x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="160" /></a></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Эти головные уборы призваны защищать вашу голову от солнечных лучей. Кепка лучше панамы защищает лицо, но будьте готовы к тому, что у вас обгорят уши. Наиболее приемлем для похода вариант с широкополыми шляпами, однако в случае ветра шляпы то и дело норовят улететь от своего хозяина.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Бафф - очень удобная и практичная вещица, с ним можно делать много чего интересного, начиная от повязки на шее и до легкой шапки на голове.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Что взять в поход, решать вам. Главное не забывать носить головной убор в солнечную погоду.</span></span></p><h3 style="text-align: justify;">Тёплая шапка.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Шапка в походе пригодится вам в основом для сна. Так как&nbsp; 80% тепла уходит из тела через голову, очень важно что бы она всегда&nbsp; была в тепле. В противном случае вы можете простудиться и заработать насморк.</span></span></p><h3 style="text-align: justify;">Купальник.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Ну куда же в летний поход без купальника? Парням проще, они вполне могут обойтись шортами, в которых проходили маршрут.</span></span></p><h3 style="text-align: justify;">Сандалии или шлёпанцы.</h3><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/obuv5.jpg" style=""><img alt="Сандали для похода" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-obuv5-300x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" title="Сандали для активного отдыха" width="300" /></a><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Шлепанцы и сандали в основном служат для хотьбы по лагерю. Когда вы уставший прийдете на место стоянки, ходить в надоевших за день кросовках/ботинках вам точно не захочется, уж поверте! Тут то вас и спасут шлепки! А в сандалях&nbsp; вполне можно проходить несложные этапы маршрута.</span></span></p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Запасной (спальный) комплект одежды.</h3><div style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Как вы догадались, этот комплект одежды вам понадобится для сна и хотьбы по лагерю. Лучше всего подойдет набор термобелья, оно отводит влагу от повехности кожи и сохраняет полезное тепло. Но обычные подштанники и футболку тоже вполне можно брать, лучше что бы они были с натурального материала.</span></span></div><h3 style="text-align: justify;">Городской комплект.</h3><div style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Всем хочется на людях(да и не только) быть красивыми и чистыми. Именно для этого вам понадобится запасной комплект чистой одежды. Не надо ничего сверхестественного, костюмы и вечерние платья с собой брать вас никто не просит, - достаточно будет чистой футболочки и акуратненьких шортиков. Желательно их упаковать в отдельный пакет и без нужды не доставать, обидно будет помарать последние чистые шмотки, что у вас есть</span></span>.</div><h3 style="text-align: justify;">Паспорт и деньги.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Документы и деньги лучше всего хранить в герметическом пакете, ведь их промокание не допустимо. На ночь&nbsp; документы нужно забирать с собой в палатку, а можно даже и в спальник(у многих спальниках сейчас есть специальный кармашка для хранения документов) там они сберегутся вернее всего.</span></span></p><h3 style="text-align: justify;">Посуда: КЛМН (кружка, ложка, миска, ножик).</h3><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod16.jpg" style=""><img alt="КЛМН - кружка, ложка, миска, нож" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod16-200x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="200" /></a></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Посуду в поход можно брать как металическую так и пластмасовую. Металическая точно не поламается, но будет сильно обжигать руки, а пластмасовая руки так сильно не будет обжигать, но есть шанс ее поломки. Можно взять и современную термопосуду, она легкая, не обжигает руки и сохраняет тепло. Последнее не всегда хорошо, ведь поначалу пить чай с термокружек фактически не возможно и все уже дольют свой, а вы только приступите.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">У каждого участника похода в обязательном порядке должен быть нож. Какой выбрать - решайте сами. Главное не переборщить с размером и что бы он не был холодным оружием.</span></span></p><h3 style="text-align: justify;">Туалетная бумага.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Ее можно использовать как по назначению, так и для других целей&hellip; Опытные туристы говорят, что существует 37 вариантов применения туалетной бумаги в походе. А возможно &ndash; и больше.Так что экспериментируйте;)</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В поход стоит взять рулон или полрулона и не забудьте упаковать ее в пакет! А то были случаи сушки бумаги у костра, выглядело весьма забавно=)</span></span></p><h3 style="text-align: justify;">Предметы личной гигиены.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">К предметам личной гигиены относятся зубная паста, зубная счетка, мыло, полотенце. Не нужно брать слишком много зубной пасты и мыла, ведь как бы вы не старались, но тюбик пасты и упаковку мыла за поход вы врятли используете. Возьмите примерно столько, сколько вам нужно. Так же не забудьте о бритве и зеркальце)</span></span></p><h3 style="text-align: justify;">Фонарик-налобник.</h3><div style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/chto-vzyat-v-pohod/chto-vzyat-v-pohod17.jpg" style=""><img alt="налобный фонарик" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-chto-vzyat-v-pohod-chto-vzyat-v-pohod17-199x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" width="199" /></a></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Фонарик в походе вещь обязательная. Пробовали в одной руке держать фонарик а другой есть? Не удобно, правда? Поэтому лучше всего покупать налобний.</span></span></p><div style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Цена&nbsp; и&nbsp; качество таких фонариков могут быть совершенно различными, как от дешевых китайских за 25 грн на базаре, так и до фирменных&nbsp; Petzl которые стоят от пары сотен. Какой покупать - решать вам, но фонарики с базара редко живут дольше одного похода.</span></span></div><h3 style="text-align: justify;">Спички.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Спички обязательно с поход брать всем, они должны быть герметически упакованы. Ведь промокшие спички в походе - крайне не желательное явление. Можно коробок спичек завернуть в полиэтилен и обмотать его скотчема Второй вариант - в коробочку спод фотопленки или витаминов положить как можно больше спичек и терки, такая упаковка не промокнет, даже упав у воду.</span></span></p><h3 style="text-align: justify;">Индивидуальный медпакет.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В походе есть общая аптечка, в которой есть многое, но далеко не все. Рюкзак медика отнють не набит кучей пластырей и лекарствами о сущуствование которых знаете только вы! Там есть все необходимое для типичных травм и болезней, что случаются в походах. Если же у вас есть какое-либо &quot;свое&quot; заболевание обязательно возьмите с собой лекарство против него и расскажите о нем инструктору.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Почитайте подробнее об <a href="http://www.kuluarbc.com.ua/poradu/aptechka-v-pohode.html">индивидуальной аптечке</a>.</span></span></p><h3 style="text-align: justify;">Индивидуальный ремнабор.</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Иметь индидуальный ремнабор необязательно, но все же желательно. В случае маленького ЧП, например, поломки/потери пряжки рюкзака инструктор поможет справиться вам с проблемой. Но если вы будете иметь при себе пару запасных пряжек, иголку и нитку - любые ЧП сможете усунуть сами в кратчайшие сроки.</span></span></p><h3 style="text-align: justify;">Фотоаппарат, видеокамера.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Беря с собой фото-, видеокамеры не забудьте что вы йдете в горы и зарядить акамулятор, скорее всего, там будет негде. Поэтому парочка запасных батареек или акамуляторов вам не помешают. Так же возьмите с собой запасные карты памяти, что бы не пришлось экономить на фотках.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Детальнее про <a href="http://www.kuluarbc.com.ua/poradu/fotografiya-v-pohode.html">фотосьмку в походе</a> тут.</span></span></p><h3 style="text-align: justify;">Солнцезащитный крем.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Наибольшую актуальность имеет в Крыму, особенно уже возле моря, когда хочется загорать круглые сутки! Но и в горах не стоит забывать - руки, уши, нос и шея постоянно открыты и имеют свойство сгорать. Тем, кто обгорает взять крем является обязательным, а то будете потом&nbsp; спать стоя и ходить вымазанными с ног до головы сметаной или кефиром, вместо того что бы наслаждаться отдыхом на море.</span></span></p><h3 style="text-align: justify;">Трекинговые палки.</h3><div style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohod/palki.jpg" style=""><img alt="Трекинговые палки" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohod-palki-180x150.jpg" style="margin: 7px; float: left; border: 1px solid #000000;" title="Трекинговые палки для похода в Крым" width="180" /></a></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Сравнительно недавно они воошли в туризм, но некоторые уже не представляют поход без них. Трекинговые палки - это почти лыжные, только регулируемой длины, часто с антишоком - при столкновении с жесткой поверхней палка немного амортизирует, тем самым убирая нагрузку на суставы. Палки помогут вам лучше держать равновесие, разгрузить колени.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Во время ходьбы можно просто переставлять палки, а можно активно ими работать, разгружая ноги и перебирая часть веса на руки. Когда последние будут уставать больше ног - значит вы правильно используете трекинговые палки.</span></span></p><p style="text-align: justify;">&nbsp;</p><h3 style="text-align: justify;">Пластиковая бутылка на 2л.</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Каждому участнику похода обязательно иметь при себе пластиковую бутылку. Подойдет обычная спод минералки, что бы вода не так быстро нагревалась в ней летом, бутылку можно завернуть в фольгу.</span></span></p><p style="text-align: justify;">&nbsp;</p><p><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Этот список вещей для похода составлен опираясь на личный опыт и здравый смысл. Он не претендует на универсальность и кристальную ясность. <strong>Перед каждым путешествием обязательно спросить у инструктора, что взять именно в этот поход</strong>, он обязательно подскажет как подкорректировать список, что бы он максимально подходил региону похода. Если знаете, что еще нужно взять в поход в горы - пишите, добавим. Я вполне мог опустить и что-то важное=))</span></span></p>', '', '', 'what_to_take', 0, 0, '2013-12-17 20:22:49'),
(7, 'Кого взять в поход?', '<h3 style="text-align: justify;">А что за люди едут? Какой возраст? Количество участников?</h3><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Едут все желающие и уже в процессе знакомятся. Одна из вещей, за которые я люблю походы, - это куча новых знакомых и друзей после каждой поездки! Разве это не замечательно? Так что, если никто из ваших друзей не идет, не стоит расстраиваться &ndash; найдете новых! &nbsp;Количеству участников от 3 до 20 человек.</span></span></p><h3 style="text-align: justify;">У меня есть маленький ребенок. С какого возраста можно в поход?</h3><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Однозначно ответить сложно, многое зависит от выбранного маршрута. В несложные походы по Крыму вполне можно брать детей с 8-ми лет. Вообще, замечено, что дети очень хорошо себя чувствуют в походах. Они быстро приспосабливаются к походным условиям, ведь им не приходится ломать привычек и стереотипов.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Стоит понимать, что многое зависит не только от возраста ребенка, а и от воспитания, поведения, здоровья&hellip; Поэтому перед походом лучше сходить в однодневный пикник за город, что бы посмотреть, понравится ли ребенку.</span></span></p>', '', '', 'whom_take', 0, 0, '2013-12-17 20:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `title`, `descr`, `alias`) VALUES
(1, 'Крым', 'Крым', '<p>Крым</p>', 'crimea'),
(2, 'Карпаты', 'Карпаты', '<p>Карпаты</p>', 'karpaty'),
(3, 'Кавказ', 'Кавказ', '', 'kavkaz');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `route_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_p` varchar(255) NOT NULL,
  `desc_short` text NOT NULL,
  `desc_long` longtext NOT NULL,
  `show_on_main_page` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_region` tinyint(1) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `route_id`, `author`, `image`, `image_p`, `desc_short`, `desc_long`, `show_on_main_page`, `show_in_region`, `priority`, `created_at`) VALUES
(1, 'Горы как источник бодрости', 1, 'Кириченко Иван', '/files/reviews/1387972954_8.jpeg', '/home/serg/www/localhost/files/reviews/1387972954_8.jpeg', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Честно говоря, в поход пошел в силу своей природной импульсивности. Друг предложил, а я решил &ndash; почему бы и нет? Почему бы не испытать себя. Сразу оговорюсь, что я человек городской и неспортивный. Подобная затея для меня в новинку. Своего рода безумие. Подливало масло в огонь еще и то, что мой друг, уже бывавший в походах, всячески уверял меня в том, что нам предстоит сущий ад.</span></p>', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Честно говоря, в поход пошел в силу своей природной импульсивности. Друг предложил, а я решил &ndash; почему бы и нет? Почему бы не испытать себя. Сразу оговорюсь, что я человек городской и неспортивный. Подобная затея для меня в новинку. Своего рода безумие. Подливало масло в огонь еще и то, что мой друг, уже бывавший в походах, всячески уверял меня в том, что нам предстоит сущий ад.</span></p><div class="u168" id="u168" style="cursor: pointer;" tabindex="0"><div id="u168_rtf"><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:underline;color:#0000FF;">Отзывы </span><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:underline;color:#0000FF;">&gt;</span></p></div></div><div class="u169" id="u169"><div id="u169_rtf"><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:underline;color:#0000FF;">Горы как источник бодрости</span></p></div></div><div class="u170" id="u170"><div id="u170_rtf"><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Вечером первого дня я даже частично готов был ему поверить, ибо часть пути при подъеме на нижнее плато горы Чатыр-Даг и вправду была весьма непроста. На следующий день мы должны были подниматься уже на самую вершину горы Чатыр-Даг и этот подъем, по заверениям друга,&nbsp; должен был стать самым тяжелым за весь поход. Однако, на удивление, я заметил, что преодоление данного рубежа дается мне довольно легко. Как говорится, не так страшен черт, как его малюют. После второго дня все последующие переходы и подъемы уже не вызывали у меня страха или неуверенности. А радиальная вылазка на плато Демерджи без рюкзаков (мой ворчливый друг остался в лагере и следил за вещами) и вовсе показалась детской прогулкой. Безусловно, не было легко в привычном понимании этого слова. Приходилось применять некоторые усилия, где-то, возможно, даже преодолевать себя, однако данный поход, на мой взгляд, целиком и полностью заслуживает определение &laquo;легкий&raquo;.</span></p></div></div><div class="u171_container" id="u171"><div id="u171_img"><img class="raw_image" src="https://dl.dropboxusercontent.com/u/173651865/%D0%A2%D1%83%D1%80%D0%B8%D1%81%D1%82%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B9%20%D1%81%D0%B0%D0%B9%D1%82/%D0%93%D0%BE%D1%80%D1%8B_%D0%BA%D0%B0%D0%BA_%D0%B8%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%B8%D0%BA_%D0%B1%D0%BE%D0%B4%D1%80%D0%BE%D1%81%D1%82%D0%B8_files/u171_normal.jpg" /></div><div class="u172" id="u172" style="visibility:hidden;">&nbsp;</div></div><div class="u173_container" id="u173"><div class="u174" id="u174" style="visibility:hidden;">&nbsp;</div></div><div class="u175" id="u175"><div id="u175_rtf"><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Однако, легкий отнюдь не означает скучный и неинтересный. Всю дорогу нас сопровождали красивейшие виды а по вечерам у костра мы коротали время распевая песни, травя анекдоты и играя в забавные игры типа &laquo;киллера&raquo; (это что-то вроде мафии). А до наступления темноты также можно было поиграть в футбол либо волейбол. В общем, скучать уж точно не приходилось.</span></p></div></div><p>&nbsp;</p>', 1, 1, 0, '0000-00-00 00:00:00'),
(2, 'А все ж таки Вони того варті =)', 2, 'Олена Ковальчук', '/files/reviews/1387973409_70.jpg', '/home/serg/www/localhost/files/reviews/1387973409_70.jpg', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Всі ми різні і це факт. Комусь і на картинках достатньо подивитись на неймовірну красу нашої Землі, а комусь і своїх власних очей мало, щоб побачити все в живу.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Мій перший досвід гір пройшов в чарівних Карпатах. Після нього я вже точно знала, що піду ще разок). Довго хотіла-хотіла, однак,&nbsp; не було компанії..( Та спасибі небесам, якось натрапила на групу &laquo;Кулуар&raquo; у ВК і цього літечка наважилась, ще й потягла за собою 2-х друзів.</span></p>', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Всі ми різні і це факт. Комусь і на картинках достатньо подивитись на неймовірну красу нашої Землі, а комусь і своїх власних очей мало, щоб побачити все в живу.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Мій перший досвід гір пройшов в чарівних Карпатах. Після нього я вже точно знала, що піду ще разок). Довго хотіла-хотіла, однак,&nbsp; не було компанії..( Та спасибі небесам, якось натрапила на групу &laquo;Кулуар&raquo; у ВК і цього літечка наважилась, ще й потягла за собою 2-х друзів.</span></p>', 1, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `distance` int(11) NOT NULL,
  `complexity` tinyint(4) NOT NULL DEFAULT '0',
  `popularity` tinyint(4) NOT NULL DEFAULT '0',
  `descr_short` text NOT NULL,
  `descr_long` longtext NOT NULL,
  `preparation` text NOT NULL,
  `photos` text NOT NULL,
  `videos` text NOT NULL,
  `reviews` text NOT NULL,
  `cost_grn` double NOT NULL,
  `cost_rur` double NOT NULL,
  `cost_usd` double NOT NULL,
  `start` varchar(255) NOT NULL,
  `finish` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_p` varchar(255) NOT NULL,
  `middle` varchar(255) NOT NULL,
  `middle_p` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `thumb_p` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `region_id`, `name`, `distance`, `complexity`, `popularity`, `descr_short`, `descr_long`, `preparation`, `photos`, `videos`, `reviews`, `cost_grn`, `cost_rur`, `cost_usd`, `start`, `finish`, `image`, `image_p`, `middle`, `middle_p`, `thumb`, `thumb_p`) VALUES
(1, 1, 'Поход по горному Крыму - Долиной Привидений', 59, 3, 0, '<p>Пожалуй, это мой самый любимый маршрут из всех <strong>походов по горному Крыму</strong>. Он чрезвычайно насыщен, интересен и разнообразен. Мы пройдем по горным вершинам, спустимся &nbsp;в сказочный мир красивейших пещер, окунемся в атмосферу Долины привидений и средневековой крепости Фуна, а в конце спустимся к водопаду Джур-Джур &ndash; крупнейшему на полуострове. Пейзажи по сторонам будут постоянно меняться, так что далеко прятать фотоаппарат не придется=)) Поход подойдет как начинающим, так и более опытным туристам. Маршрут более чем универсален и его сложность можно менять по желанию группы. Если вы идете в первый раз &ndash; смело выбирайте этот тур, море приятных ощущений вам обеспечено!</p>', '<h2 style="text-align: justify;">План похода по горному Крыму:</h2><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">1 день. Симферополь &ndash; нижнее плато Чатыр-Даг (7,6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Группа собирается на железнодорожном вокзале Симферополя, где все знакомятся, и инструктор раздает каждому его часть общего снаряжения и продуктов. Далее, садимся на троллейбус и едем в Сосновку, где и начнется пешая честь похода. Недалеко от трассы начинается Красная тропа, названная так из-за характерного красноватого цвета камня. Подъем по ней весьма не прост и придется попотеть, пока не поднимемся на нижнее плато Чатыр-Даг. На плато нас ждут две красивейшие пещеры &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/emine-bair-hosar.html" target="_blank">Эмине-Баир-Хосар</a> и Мраморная, в которые все желающие могут сходить на экскурсию. На ночевку остановимся неподалеку от пещер.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest11.jpg" style=""><img alt="у костра" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest11-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest9.jpg" style=""><img alt="идем по плато" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest9-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina15.jpg" style=""><img alt="В пещере Эмине-Баир-Хосар" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina15-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">2 день. Ангар-Бурун &ndash; Кутузовские озера (8,2 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Нижнее плато <a href="http://www.kuluarbc.com.ua/interesnye-mesta/chatur-dag.html" target="_blank">Чатыр-Дага</a> богато на пещеры, большинство из них &ndash; это вертикальные колодцы, но есть и много доступных без специального снаряжения. В парочку таких можно будет зайти по пути. Сегодня мы поднимемся на верхнее плато и на вершину Ангар-Бурун (1453 м), а если будет хватать сил и времени, то и на Эклизи-Бурун, высотой 1527 м. С обоих вершин открывается красивейший вид на Демерджи, Алушту и Бабуган яйлу. Налюбовавшись красотами и сделав парочку снимков на память, спускаемся к Кутозовским озерам, где и заночуем.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest098.jpg" style=""><img alt="на пути к вершине" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest098-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina.JPG" style=""><img alt="Наслаждаемся пейзажами=))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina3.JPG" style=""><img alt="Вершина Эклизи-Бурун" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina3-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">3 день. Долина Привидений, Демерджи, Джурла (12,3 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Каждый, кто мало-мальски интересуется красотами природы, слышал (или уже бывал) о <a href="http://www.kuluarbc.com.ua/interesnye-mesta/dolina-prividenij.html" target="_blank">Долине Привидений</a> &ndash; одном из красивейших мест горного Крыма. Сегодня и мы побываем тут, но сначала зайдем на экскурсию в крепость Фуна &ndash; средневековое укрепление феодоритов, служившее для охраны торгового пути. На входе в долину растет знаменитое дерево Никулина, возле которого снималась &laquo;Кавказская пленница&raquo;. Пройдя Долину Привидений, поднимаемся к вершине южной Демерджи, с которой открывается просто превосходная панорама на ЮБК &ndash; от Судака и до Медведь-горы. Заночуем сегодня возле озера на стоянке Джурла, а если хватит времени, то пройдем немного дальше, к водопаду.</span></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina13.jpg" style=""><img alt="Долина Привидений" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina13-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina14.jpg" style=""><img alt="На вершине Демерджи" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina14-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest17.JPG" style=""><img alt="скала Катерина" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest17-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">4 день. Водопад Джур-Джур, т/с Ай-Алексий (14 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Быстро собираем лагерь, завтракаем и в путь! Сегодня нам нужно много пройти и много увидеть. Совсем рядом со стоянкой любуемся небольшим, но очень живописным водопадом <a href="http://www.kuluarbc.com.ua/interesnye-mesta/vodopad-dzhurla.html" target="_blank">Джурла</a>. Далее, по хорошей тропе топаем к самому полноводному водопаду Крыма &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/vodopad-dzhur-dzhur.html">Джур-Джур</a>. Мощные струи реки Улу-Узень падают с 16-ти метрового уступа и это действительно впечатляющее зрелище! К сожалению, покупаться в водопаде не удастся, так как идет забор питьевой воды и купание запрещено. Вдоволь насмотревшись и сделав достаточное количество снимков идем к стоянке Ай-Алексий, где и заночуем.</span></span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest01.jpg" style=""><img alt="восход" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest01-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina17.jpg" style=""><img alt="Водопад Джур-Джур" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina17-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></span></span><a href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina9.JPG" rel="lightbox[]" target="_blank" title="Играем в валейбол на стоянке"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"> </span></span></a><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina7.JPG" style=""><img alt="Грибочки всегда хорошо))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina7-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></span></span></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">5 день. Караби-яйла. Озеро Хун (10,9 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;">Основные достопримечательности этого похода по горному Крыму пройдены, но еще можно насладиться дикими пейзажами Караби яйлы. Плато просто пестрит от карстовых воронок и пещер-колодцев, но оно безводное и туристы там ходят не так часто. Мы же не спеша спускаемся к большому озеру Хун, где можно вдоволь накупаться и помыться.</span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest6.jpg" style=""><img alt="на дереве" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest6-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur " href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/dolina16.jpg" style=""><img alt="Отдых на маршруте" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-dolina16-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/dolina/kvest15.JPG" style=""><img alt="возле озера" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-dolina-kvest15-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></p><p style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">6 день. Рыбачье. Симферополь (6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">До конца маршрута осталось всего ничего &ndash; спуститься в Рыбачье по дороге, идущей сквозь виноградники. Особенно хороша она осенью, когда виноград уже поспел. Постоянно останавливаешься, что бы скушать вкусную ягодку. Главное &ndash; знать меру, а то следующая ночь в поезде вам и вашим соседям покажется длинной:-) От Рыбачьего регулярно ходят маршрутки и добраться к Симферополю не составит проблем.</span></span></p>', '<p><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">К вашему вниманию список обязательных и не очень вещей для зимнего похода. Он составлен опираясь на личный опыт и здравый смысл, поэтому&nbsp; начинающим туристам искренне советую его придерживаться. В случае, если вы не хотите брать что-то с данного списка или хотите взять что-то еще, обязательно посоветуйтесь с инструктором. </span></span></p><p><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Статью о снаряжении для летнего похода можно прочитать тут:&nbsp;<a href="http://www.kuluarbc.com.ua/vse/chto-vzyat-v-pohod.html"> Что взять в поход? Список снаряжения для летнего похода.</a></span></span></span></span></p>', '', '<p><iframe class="youtube-player" frameborder="0" height="390" src="http://www.youtube.com/embed/http://www.youtube.com/v/Qmus9GchI-4?rel=0" title="YouTube video player" type="text/html" width="480"></iframe></p><p><iframe class="youtube-player" frameborder="0" height="390" src="http://www.youtube.com/embed/http://www.youtube.com/v/kzV7ZFGTy8s?rel=0" title="YouTube video player" type="text/html" width="480"></iframe></p>', '<p>Хорошо сходили)Погода,конечно,немного подвела,но как говорится:У природы нет плохой погоды.)Было мокро,сыро и холодно ,но это даже добавило какого то приключенческого духа.))Пейзажи неописуемые,особенно впечатляет,когда видишь как огромную гору &quot;сьедает&quot; еще более огромное облако,все кажется одновременно и очень маленьким и неописуемо большим,короче контрастов много.Вел нас человек-энциклопедия.))На протяжении всего маршрута наш проводник рассказывал нам обо всем что мы видели:о горах,травах,камнях,облаках буквально обо всем и это особенно запомнилось,т.к.поход оказался не только красивым но и полезным.Всем кто ни разу не был в горах или в походе вообще однозначно советую,это интересно и впечатляюще и по уровню подготовки в самый раз.))</p>', 1240, 4960, 150, 'Симферополь', 'Симферополь', '', '', '/files/routes/middle/1387310265_63.jpg', '/home/serg/www/localhost/files/routes/middle/1387310265_63.jpg', '/files/routes/thumb/1387310265_9.jpg', '/home/serg/www/localhost/files/routes/thumb/1387310265_9.jpg'),
(2, 1, 'Туристический поход по Крыму – Пещерными городами Крыма ', 47, 0, 0, '<p style="text-align: justify;">Этот туристический поход в Крым не сложный и максимально насыщенный различными достопримечательностями. Он идеально подходит&nbsp; новичкам, так как на маршруте есть лишь незначительные перепады высот, не длительные переходы и много радиалок (экскурсий на легке, без рюкзака). В то же время? поход чрезвычайно интересен, ведь каждый день мы будем посещать новые пещерные города, таинственные каньоны, древние монастыри в отвесных скалах... Мы с головой погрузимся в историю и пропитаемся таинственным духом былых дней!</p><p style="text-align: justify;">Каждый просто обязан хоть раз в жизни увидеть пещерные города! Я считаю, что тот, кто их не видел &ndash; не видел Крыма! Так что прочь сомнения и присоединяйтесь к походу=))</p>', '<h2 style="text-align: justify;">План туристического похода по Крыму</h2><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">1 день. Бахчисарай. Успенский монастырь. Радиалка Чуфут-Кале (6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Встреча участников происходит на Симферопольском ж/д вокзале, где все знакомятся и распределяется снаряжение. Далее едем в Бахчисарай &ndash; древнюю столицу Крымского ханства. Тут мы маршруткой подъедем почти к самому <a href="http://www.kuluarbc.com.ua/interesnye-mesta/uspenskij-monastyr-v-bakhchisarae.html" target="_blank">Успенскому монастырю</a>, возле которого находится источник с чистейшей родниковой водой.&nbsp; Пополняем запасы воды (в Крыму это всегда актуально, особенно в теплую пору года) и идем в <a href="http://www.kuluarbc.com.ua/interesnye-mesta/gorod-chufut-kale.html" target="_blank">пещерный город Чуфут-Кале</a> &ndash; один из красивейших и наиболее сохранившихся в Крыму! Ночуем на поляне, возле родника.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami12.JPG" style=""><img alt="Успенский монастырь" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami12-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami13.JPG" style=""><img alt="Чуфут-Кале" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami13-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery4.JPG" style=""><img alt="на Чуфут-Кале" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery4-225x150.JPG" style="border: 1px solid #000000;" width="225" /></a></span></span></p><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">2 день. Караимское кладбище. Качи-Кальон. Алимова балка (11,7 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Сегодняшний наш переход начнется с самого крупного тюркского захоронения в Европе &ndash; Караимского некрополиса.&nbsp; Здесь находится около 10&nbsp;000 надгробий. Идя древним кладбищем, погружаешься в атмосферу таинственности и невольно задумываешься о вечном. К обеду спустимся в каньон реки Качи, где прохладно даже самим жарким летом. Недалеко находится пещерный монастырь Качи-Кальон, что в переводе значит &laquo;Крестовый корабль&raquo;. Названием монастырь обязан форме скалы, изрезанной крестоподобными трещинами. Ночевать будем в Алимовой балке, именно здесь в свое время ночевал известный крымский разбойник Алим, почитаемый местными жителями не хуже Робин Гуда англичанами.</span></span></p><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami15.jpg" style=""><img alt="Караимское кладбище" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami15-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery5.JPG" style=""><img alt="Кулуар =))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery5-225x150.JPG" style="border: 1px solid #000000;" width="225" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery2.jpg" style=""><img alt="чудный восход" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery2-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a> <strong><span style="color: #69593a;"><span style="font-size: 13pt;"> </span></span></strong></p><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">3 день. Челтер-Коба. Сюйренская крепость (6,6 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">После довольно длинного утреннего перехода спустимся к реке Бельбек, на берегу которой расположено село Большое Садовое. Сразу за селом находится действующий пещерный монастырь Челтер-Коба. Осмотрим сам монастырь, желающие могут поставить свечку в молебне.&nbsp; Далее мы прогуляемся к Сюйренской крепости. Крепость находится на мысе Куле-Бурун и с трех сторон окружена отвесными скалами. Отсюда и название &laquo;Острая&raquo;. С мыса открывается красивейшая панорама на долину реки Бельбек, где и заночуем.</span></span></p><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery7.JPG" style=""><img alt="Челтер-Коба" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery7-225x150.JPG" style="border: 1px solid #000000;" width="225" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery6.JPG" style=""><img alt="купаемся ))" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery6-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery10.JPG" style=""><img alt="мы и Сюйрень" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery10-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a></p><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">4 день. Мангуп-Кале (10 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">По тропинке, ведущей вверх, через Каралезскую долину, направляемся к столице древнего княжества Феодоро &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/mangup-kale.html" target="_blank">пещерному городу Мангуп-Кале</a>. На плато находится несколько источников воды, что делает его удобным для обитания. Конечно, древние люди уже не живут на Мангупе, но на смену им пришли хиппи&nbsp; и другие неформалы, живущие тут круглогодично. Само плато занимает довольно большую площадь и мы будем долго гулять по нему. Заночуем возле одного из источников. Внимательно следите за вещами, на Мангупе не редки случаи кражи!!</span></span></p><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami9.jpg" style=""><img alt="Пещерный город Мангуп-Кале" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami9-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami10.jpg" style=""><img alt="ворота Мангуп-Кале" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami10-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery12.jpg" style=""><img alt="ночевка на Мангупе" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery12-225x150.jpg" style="border: 1px solid #000000;" width="225" /></a> <strong><span style="color: #69593a;"><span style="font-size: 13pt;"> </span></span></strong></p><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">5 день.&nbsp;Монастарь Шулдан, Челтер. Эски-Кермен&nbsp; (10 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-size: 12pt;"><span style="font-family: times new roman,times;">Спускаемся с Мангупа к трасе, сразу за которой тропа идет вверх, к действующему монастырю Шулдан. Далее &nbsp;пройдем к еще одному монастырю, который постепенно оживает &ndash; это монастырь Челтер. После осмотра монастыря направляемся к самому красивому пещерному городу Крыма &ndash; <a href="http://www.kuluarbc.com.ua/interesnye-mesta/eski-kermen.html" target="_blank">Эски-Кермен.</a> Он находится на гигантском утесе, одиноко стоящем посреди поля.&nbsp; Гуляем по городу и его окрестностям (посещаем башню Кыз-Куле и храм Донаторов), а ближе к вечеру становимся на ночлег.</span></span></p><p><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechery13.JPG" style=""><img alt="Эски-Кермен" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechery13-225x150.JPG" style="border: 1px solid #000000;" width="225" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami2.JPG" style=""><img alt="Монастырь Шулдан" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami2-200x150.JPG" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pecherni-goroda/pechernimy-gorodami3.jpg" style=""><img alt="Горный Крым" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pecherni-goroda-pechernimy-gorodami3-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a> <strong><span style="color: #69593a;"><span style="font-size: 13pt;"> </span></span></strong></p><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">6 день. с. Красный Мак (3 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Со стоянки по хорошей дороге направляемся к селу Залесное или Красный Мак. Из села ходят автобусы на Бахчисарай, Севастополь и Симферополь, едем кому куда удобнее. На этом и заканчивается наш поход по пещерным городам Крыма.</span></span></p><h2>Условия похода:</h2><ul>\r\n<li>\r\n	Это настоящий <a href="http://www.kuluarbc.com.ua/pohody-krym/" target="_blank">пеший поход по Крыму</a> &ndash; мы идем с рюкзаками, еду готовим на костре, спим в палатках. Один из самых простых и насыщенных походов - множество древнейших пещерынх городов и крутых каньонов предстанут нашему взгляду!</li>\r\n<li>\r\n	Если у вас нет личного снаряжения, его можно взять на <a href="http://www.kuluarbc.com.ua/snaryaga/prokat.html" target="_blank">прокат</a>.</li>\r\n<li>\r\n	Действует система <a href="http://www.kuluarbc.com.ua/vse/skidki.html" target="_blank">скидкок</a>!</li>\r\n<li>\r\n	Деньги сдаются гиду в первый день похода. О порядке и способах оплаты можно почитать <a href="http://www.kuluarbc.com.ua/teh/poryadok-oplaty.html" target="_blank">тут</a>.</li>\r\n<li>\r\n	Не забудьте взять фотоаппарат и запас позитива &ndash; с нами всегда весело, надежно и интересно! <img alt="Улыбка" border="0" src="http://www.kuluarbc.com.ua/plugins/editors/jce/tiny_mce/plugins/emotions/img/smiley-smile.gif" title="Улыбка" /></li>\r\n<li>\r\n	Инструктор в зависимости от погодных условий и состояния группы имеет право вносить <a href="http://www.kuluarbc.com.ua/teh/izmenenija-v-marshrute.html" target="_blank">изменения в маршрут.</a></li>\r\n</ul>', '', '', '', '', 1250, 5000, 175, 'Симферополь', 'Севастополь', '', '', '/files/routes/middle/1387387694_46.jpg', '/home/serg/www/localhost/files/routes/middle/1387387694_46.jpg', '/files/routes/thumb/1387387694_19.jpg', '/home/serg/www/localhost/files/routes/thumb/1387387694_19.jpg'),
(3, 1, 'Пеший поход в Крым – Дорога в маленький рай ', 30, 1, 0, '<p>Выдались свободные выходные? Так почему бы не пойти в <strong>пеший поход в Крым</strong>? Маршрут построен так, что всего за три дня вы прогуляетесь крымскими лесами, пройдете настоящий горный хребет, попутно подниметесь на парочку вершин. А уже на второй день мы выйдем к морю и заночуем на пляже, у самого уреза воды. Что может быть романтичнее? Кроме этого, насладимся достопримечательностями, которыми так богат мыс Караул-Оба и Новый Свет. Этот маленький поход по Крыму вы запомните на всю жизнь!</p>', '<h2 style="text-align: justify;">План пешего похода в Крым</h2><p><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">1 день. Симферополь&ndash;Земляничное</span></strong><strong>&ndash;</strong><strong><span style="font-size: 13pt;">пер. Маски&ndash;т/с Ай-Серез (12,8 км)</span></strong></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Как всегда, сбор группы на Симферопольском железнодорожном вокзале в 11 утра. Инструктор распределяет продукты, садимся на автобус и едем в Земляничное. Это небольшое горное село досталось нам в наследство от грозных кочевников, которые осели тут сотни лет назад. От села по хорошей грунтовой дороге поднимаемся к перевалу Маски, где можно сделать перекус. От перевала до уютной стоянки в березовой роще около двух часов ходьбы.</span></span></p><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray1.jpg" style=""><img alt="мост на пути к Маски" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray1-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray.jpg" style=""><img alt="перевал маски" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray-192x150.jpg" style="border: 1px solid #000000;" width="192" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray2.jpg" style=""><img alt="Дорога к стоянке" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray2-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></span></span></p><div style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">2 день. Хребет Орта-Сырт &ndash; Веселое &ndash; бухта Кутлакская (10,4 км)</span></strong></span></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">От стоянки немного идем по лесной тропе и начинаем подниматься на перевал. Нам нужно набрать всего до двухсот метров, подъем небольшой, но немножко попотеть заставит. Зато в конце нас ждет щедрая награда &ndash; вершина Лялель-Оба и чудесные пейзажи с хребта Орта-Сырт. Надо сказать, что Орта-Сырт - это уникальный для Крыма горный хребет с крутыми обрывистыми склонами и небольшими скалами, преодоление которых не составит труда, но сделает наш путь еще интереснее. Хребет полностью голый, на нем не растут деревья, и ничто не будет мешать нам любоваться горными пейзажами. А любоваться действительно есть чем: слева открывается вид на Новый свет, Судак, мыс Меганом, впереди видно море, а справа теряются в тумане высочайшие горные массивы Крыма &ndash; Бабуган-яйла и плато Чатыр-Даг. Вдоль устья ручья по балке Су-Чаптран спускаемся в село Веселое. Спуск интересный, есть в меру сложные преграды, а в конце настоящий водопадик, под которым можно освежиться! Далее вдоль трассы идем к берегу моря, где и становимся лагерем.</span></span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray3.jpg" style=""><img alt="хребет Орта-Сырт" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray3-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray4.jpg" style=""><img alt="небольшие скалы" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray4-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray5.jpg" style=""><img alt="стоянка на берегу моря" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray5-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></p><div style="text-align: justify;"><span style="color: #3366ff;"><strong><span style="font-size: 13pt;">3 день. Мыс Караул-Оба &ndash; Новый свет (7 км)</span></strong></span></div><p style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">Если вчера было красиво, то сегодня будет безумно красиво! Новый свет с его мысами и бухточками по праву считается одним из красивейших мест Крыма. По мысу Караул-Оба идем по хорошей, маркированной тропе, постоянно останавливаясь, чтобы полюбоваться необычайной голубизной моря. Возможно, именно по нашей тропе, в древности ходили тавры, населявшие эти места.</span></span></p><p style="text-align: justify;"><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray6.jpg" style=""><img alt="мыс Сквозной" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray6-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray7.jpg" style=""><img alt="дорога по Караул-Оба" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray7-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a><a class="thumbnail highslide zoomin-cur" href="http://www.kuluarbc.com.ua/images/stories/pohodu-krum/pohod-ray/pohod-ray8.jpg" style=""><img alt="грот Голицина" height="150" src="http://www.kuluarbc.com.ua/images/stories/thumbnails/images-stories-pohodu-krum-pohod-ray-pohod-ray8-200x150.jpg" style="border: 1px solid #000000;" width="200" /></a></p><div style="text-align: justify;"><span style="font-family: times new roman,times;"><span style="font-size: 12pt;">В конце тропы пройдемся по всем известным и чрезвычайно популярным местам &ndash; тропа Голицина, Царский пляж, Разбойничья бухта и выйдем в Новый свет. На его месте в древности была деревня Парадиз. И действительно, Новый свет как маленький рай в укромном уголке Крыма. Из поселка можно напрямую уехать в Симферополь, можно - в Судак, а можно остаться еще на пару деньков, насладиться мягким климатом ЮБК. В Симферополь вы попадете часиков в 17-18, учитывайте это, когда будете покупать билеты назад. </span></span><br /><span style="font-family: times new roman,times;">Этот пеший поход в Крым вы запомните на всю жизнь!</span></div><h2>Условия участия в походе:</h2><ul>\r\n<li>\r\n	Это настоящий <a href="http://www.kuluarbc.com.ua/pohody-krym/" target="_blank">пеший поход в Крыму</a> &ndash; мы идем с рюкзаками, еду готовим на костре, спим в палатках. Поход хоть и всего на три дня, но очень красив и насыщен! Мы пройдемся и по горах и вдоль морского побережья! А спать будем на гальке,&nbsp; в нескольких метрах от моря!</li>\r\n<li>\r\n	Если у вас нет личного снаряжения, его можно взять на <a href="http://www.kuluarbc.com.ua/snaryaga/prokat.html" target="_blank">прокат</a>.</li>\r\n<li>\r\n	Действует система <a href="http://www.kuluarbc.com.ua/vse/skidki.html" target="_blank">скидкок</a>!</li>\r\n<li>\r\n	Деньги сдаются гиду в первый день похода. О порядке и способах оплаты можно почитать <a href="http://www.kuluarbc.com.ua/teh/poryadok-oplaty.html" target="_blank">тут</a>.</li>\r\n<li>\r\n	Не забудьте взять фотоаппарат и запас позитива &ndash; с нами всегда весело, надежно и интересно! <img alt="Улыбка" border="0" src="http://www.kuluarbc.com.ua/plugins/editors/jce/tiny_mce/plugins/emotions/img/smiley-smile.gif" title="Улыбка" /></li>\r\n<li>\r\n	Инструктор в зависимости от погодных условий и состояния группы имеет право вносить <a href="http://www.kuluarbc.com.ua/teh/izmenenija-v-marshrute.html" target="_blank">изменения в маршрут.</a></li>\r\n</ul>', '', '', '', '', 700, 2800, 92, 'Симферополь', 'Судак', '', '', '/files/routes/middle/1387387835_41.jpg', '/home/serg/www/localhost/files/routes/middle/1387387835_41.jpg', '/files/routes/thumb/1387387835_44.jpg', '/home/serg/www/localhost/files/routes/thumb/1387387835_44.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
CREATE TABLE IF NOT EXISTS `slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_p` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `name`, `link`, `image`, `image_p`, `priority`) VALUES
(1, 'Крым', '/features/crimea', '/files/slides/1387353662_44.jpeg', '/home/serg/www/dev3/files/slides/1387353662_44.jpeg', 1),
(2, 'Карпаты', '/features/karpaty', '/files/slides/1387354048_96.jpeg', '/home/serg/www/dev3/files/slides/1387354048_96.jpeg', 2),
(3, 'Экзотика', '/features/exotic', '/files/slides/1387354071_45.jpeg', '/home/serg/www/dev3/files/slides/1387354071_45.jpeg', 3),
(4, 'Зима', '/features/winter', '/files/slides/1387353638_68.jpeg', '/home/serg/www/dev3/files/slides/1387353638_68.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
CREATE TABLE IF NOT EXISTS `trainers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `practice` date NOT NULL,
  `experience` date NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `progress` varchar(255) NOT NULL,
  `text_short` text NOT NULL,
  `text_long` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_p` varchar(255) NOT NULL,
  `middle` varchar(255) NOT NULL,
  `middle_p` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `thumb_p` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `show_on_main_page` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `birthday`, `practice`, `experience`, `slogan`, `progress`, `text_short`, `text_long`, `image`, `image_p`, `middle`, `middle_p`, `thumb`, `thumb_p`, `priority`, `show_on_main_page`) VALUES
(1, 'Тарас Поздний', '1988-01-02', '2008-01-10', '2010-06-10', 'Вперед и только вперед!', 'не указано', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Уже на последних курсах понял &mdash;&nbsp; я настолько сильно люблю природу и горы, что обычная работа мне не подойдет. Нужно связать работу с хобби, так и появилась идея создания своего проекта. После окончания КПИ вернулся в родной город и пока живу тут. Что будет дальше? Поживем &ndash; увидим.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">В настоящее время не женат, кроме туризма увлекаюсь спортом (турнички, футбол, капоейра...), сайтами, раньше очень много читал фентези, но в последнее время отдалился &ndash; нету столько времени. Или, может, уже перерос чтение развлекательных книг, если и читаю, то что-то полезное.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Родители были альпинистами, но со временем переквалифицировались в туристов, подрабатывали инструкторами и брали нас с сестрой с собой в походы. В первый свой поход (Карпаты) я пошел в 9 лет, потом был небольшой перерыв и где-то с 11-12 по 3-4 похода каждый год. В основном Крым-Карпаты. Чуть позже&nbsp; добавился и Кавказ. В основном хожу в пешие или горные походы, но был и в парочке водных.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Наши, украинские, горы чрезвычайно красивы, но Кавказ круче в разы! А ведь Крым, Карпаты и Кавказ &ndash; это лишь маленький кусочек нашей воистину прекрасной и необъятной планеты! Хочется увидеть все и побывать везде! Поэтому, одной из целей является парочка походов/поездок в новые страны каждый год. Пока есть возможность, позволяет здоровья, нужно брать от жизни максимум!</span></p>', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Уже на последних курсах понял &mdash;&nbsp; я настолько сильно люблю природу и горы, что обычная работа мне не подойдет. Нужно связать работу с хобби, так и появилась идея создания своего проекта. После окончания КПИ вернулся в родной город и пока живу тут. Что будет дальше? Поживем &ndash; увидим.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">В настоящее время не женат, кроме туризма увлекаюсь спортом (турнички, футбол, капоейра...), сайтами, раньше очень много читал фентези, но в последнее время отдалился &ndash; нету столько времени. Или, может, уже перерос чтение развлекательных книг, если и читаю, то что-то полезное.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;text-decoration:none;">&nbsp;</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Родители были альпинистами, но со временем переквалифицировались в туристов, подрабатывали инструкторами и брали нас с сестрой с собой в походы. В первый свой поход (Карпаты) я пошел в 9 лет, потом был небольшой перерыв и где-то с 11-12 по 3-4 похода каждый год. В основном Крым-Карпаты. Чуть позже&nbsp; добавился и Кавказ. В основном хожу в пешие или горные походы, но был и в парочке водных.</span></p><p style="text-align:left;">&nbsp;</p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Наши, украинские, горы чрезвычайно красивы, но Кавказ круче в разы! А ведь Крым, Карпаты и Кавказ &ndash; это лишь маленький кусочек нашей воистину прекрасной и необъятной планеты! Хочется увидеть все и побывать везде! Поэтому, одной из целей является парочка походов/поездок в новые страны каждый год. Пока есть возможность, позволяет здоровья, нужно брать от жизни максимум!</span></p>', '', '', '/files/trainers/middle/1387313208_30.jpg', '/home/serg/www/localhost/files/trainers/middle/1387313208_30.jpg', '/files/trainers/thumb/1387313208_15.jpg', '/home/serg/www/localhost/files/trainers/thumb/1387313208_15.jpg', 0, 1),
(2, 'Диана Несмеяна', '1992-07-12', '2005-08-25', '2012-05-30', 'Солнце в ладонях, сердце в груди!', 'победила сама себя', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></p>', '<p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Уже на последних курсах понял &mdash;&nbsp; я настолько сильно люблю природу и горы, что обычная работа мне не подойдет. Нужно связать работу с хобби, так и появилась идея создания своего проекта. После окончания КПИ вернулся в родной город и пока живу тут. Что будет дальше? Поживем &ndash; увидим.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">В настоящее время не женат, кроме туризма увлекаюсь спортом (турнички, футбол, капоейра...), сайтами, раньше очень много читал фентези, но в последнее время отдалился &ndash; нету столько времени. Или, может, уже перерос чтение развлекательных книг, если и читаю, то что-то полезное.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Родители были альпинистами, но со временем переквалифицировались в туристов, подрабатывали инструкторами и брали нас с сестрой с собой в походы. В первый свой поход (Карпаты) я пошел в 9 лет, потом был небольшой перерыв и где-то с 11-12 по 3-4 похода каждый год. В основном Крым-Карпаты. Чуть позже&nbsp; добавился и Кавказ. В основном хожу в пешие или горные походы, но был и в парочке водных.</span></p><p style="text-align:left;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">Наши, украинские, горы чрезвычайно красивы, но Кавказ круче в разы! А ведь Крым, Карпаты и Кавказ &ndash; это лишь маленький кусочек нашей воистину прекрасной и необъятной планеты! Хочется увидеть все и побывать везде! Поэтому, одной из целей является парочка походов/поездок в новые страны каждый год. Пока есть возможность, позволяет здоровья, нужно брать от жизни максимум!</span></p>', '', '', '/files/trainers/middle/1387387313_31.png', '/home/serg/www/localhost/files/trainers/middle/1387387313_31.png', '/files/trainers/thumb/1387387313_17.png', '/home/serg/www/localhost/files/trainers/thumb/1387387313_17.png', 1, 1),
(3, 'Инструктор №3', '1988-01-01', '2008-01-01', '2012-05-30', 'Вперед и только вперед!', 'победила сам себя и не испугался орла', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></p>', '<p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></p><p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></span></p><p><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;"><span style="font-family:Arial;font-size:16px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;">И так, родился я в Белой Церкви &ndash; небольшом, но и не маленьком городе, вблизи Киева. Сначала учился в обычной школе, потом в Белоцерковском экономико-правовом лицее, по окончанию которого поступил в КПИ на факультет ИЕЕ, специальность энергоменеджер (или как-то так).</span></span></span></p>', '', '', '/files/trainers/middle/1387387394_86.png', '/home/serg/www/localhost/files/trainers/middle/1387387394_86.png', '/files/trainers/thumb/1387387394_75.png', '/home/serg/www/localhost/files/trainers/thumb/1387387394_75.png', 2, 1);
